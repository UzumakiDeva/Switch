<?php
namespace App\Traits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Auth;
use App\User;
use App\Models\Completedtrade;
use App\Models\Trade;
use App\Models\Selltrade;
use App\Models\Tradepair;
use App\Models\TradePairLivePrice;
use App\Libraries\BinanceClass;

trait TradeData
{
	public function tradeBuy($pairid,$limit=100){
     	$buytrades = Trade::select('price',DB::raw('SUM(remaining) as remaining'),DB::raw('group_concat(created_at) as created_at'))
      	->where(['trade_type' => 'Buy','order_type' => 1, 'pair' => $pairid,'status' => 0])        
      	->groupBy('price')
      	->orderBy('price', 'desc')
      	->limit($limit)->get();
      	return $buytrades;
  	}
  	public function tradeSell($pairid,$limit=100){
       	$selltrades = Trade::select('price', DB::raw('SUM(remaining) as remaining'),DB::raw('group_concat(created_at) as created_at'))
      	->where(['trade_type' => 'Sell','order_type' => 1, 'pair' => $pairid,'status' => 0])
      	->orderBy('price', 'asc')
      	->groupBy('price')
      	->limit($limit)->get();
      	return $selltrades;
  	}
  	public function tradeComplete($pairid,$limit=100){
      	$completedtrade = Completedtrade::where(['pair' => $pairid])->orderBy('id', 'desc')->limit($limit)->get();
      	return $completedtrade;
  	}
  	public function marketpair($pairid){
	    $pair = Tradepair::where(['id' => $pairid])->first();
	    if($pair->type == 1){
	      $coinone = $pair->coinone;
	      $cointwo = $pair->cointwo;
	      $market = $coinone.$cointwo;
	      return $market;
	    }else if($pair->type == 2){
	    	$coinone = $pair->coinone;
	      	$cointwo = "BUSD";
	      	$market = $coinone.$cointwo;
	    	return $market;
	    }else{
	      return false;
	    }
	}
  	//Get the last 24 hour summary of all active exchanges for a market
  	public function getMarketSummary($pairid){
    	$api = new BinanceClass;
    	$buytrades = array();
    	$pair = $this->marketpair($pairid);
	    if($pair){ 
	    	try {    
	      	$result =  $api->hr_ticker_price($pair);
	      	if(isset($result['lastPrice'])){
	      		$data['Last']     = display_format($result['lastPrice']);
	      	}else{
	      		$data['Last']     = 0;
	      	}if(isset($result['openPrice'])){
	      		$data['Open']     = display_format($result['openPrice']);
	      	}else{
	      		$data['Open']     = 0;
	      	}if(isset($result['lowPrice'])){
	      		$data['Low']     = display_format($result['lowPrice']);
	      	}else{
	      		$data['Low']     = 0;
	      	}
	      	if(isset($result['highPrice'])){
	      		$data['High']     = display_format($result['highPrice']);
	      	}else{
	      		$data['High']     = 0;
	      	}if(isset($result['volume'])){
	      		$data['Volume']     = display_format($result['volume']);
	      	}else{
	      		$data['Volume']     = 0;
	      	}if(isset($result['priceChangePercent'])){
	      		$data['Exchange']     = display_format($result['priceChangePercent']);
	      	}else{
	      		$data['Exchange']     = 0;
	      	}
	      } catch (Exception $e) {
	      	return false;
	      }
	      
	    }else{
	      $data = $this->TradePrice($pairid);
	    }
    	return $data;    
  	}
	public function hrExchange($current,$yesterday){
		if($yesterday > 0){
		  $exchangerate = ncSub($current, $yesterday, 8);
		  $exchanger =  ncDiv($exchangerate, $yesterday, 8);     
		  $exchange =  ncMul($exchanger, 100, 2);     
		}else{
		  $exchange = display_format(0,2);
		}
		return $exchange;
	}
  	public function TradePrice($pairid){
	    $yesterday = date('Y-m-d H:i:s', strtotime("-1 days"));
	    $PrevDay = 0;
	    $open = Completedtrade::where('pair',$pairid)->where('created_at', '>=', $yesterday)->orderBy('id', 'asc')->value('price');
		$last = Completedtrade::where('pair',$pairid)->where('created_at', '>=', $yesterday)->orderBy('id', 'desc')->value('price');
	    $min = Completedtrade::where('pair',$pairid)->where('created_at', '>=', $yesterday)->min('price');
	    $max = Completedtrade::where('pair',$pairid)->where('created_at', '>=', $yesterday)->max('price');
	    $volume = Completedtrade::where('pair',$pairid)->where('created_at', '>=', $yesterday)->sum('volume');
	    $PrevDay =  Completedtrade::where('pair',$pairid)->where('created_at', '<=', $yesterday)->orderBy('id', 'desc')->value('price');
	    if(!$last){
	      $last = 0;
	    }
		if(!$open){
			$open = 0;
		  }
	    if(!$min){           
	      $min = 0;
	    }
	    if(!$max){
	      $max = 0;
	    }
	    if(!$volume){
	      $volume = 0;
	    }
	    $exchange = $this->hrExchange($last,$PrevDay);

	    $data['Open']     = display_format($open);
		$data['Last']     = display_format($last);
	    $data['Low']      = display_format($min);
	    $data['High']     = display_format($max);
	    $data['Volume']   = display_format($volume);
	    $data['Exchange'] = $exchange;
	    return $data;
  	}
	public function updateTradePrice($pairid){		
		$price = Tradepair::where('id',$pairid)->first();
		if(is_object($price)){
			if($price->type == 0){
				$data = $this->TradePrice($pairid);
			}else{
				$data = $this->getMarketSummary($pairid);
			}
			$price->open = display_format($data['Open'],$price->cointwo_decimal);
			$price->close = display_format($data['Last'],$price->cointwo_decimal);
			$price->low = display_format($data['Low'],$price->cointwo_decimal);
			$price->high = display_format($data['High'],$price->cointwo_decimal);
			$price->hrchange = $data['Exchange'];
			$price->hrvolume = display_format($data['Volume'],$price->coinone_decimal);
			$price->updated_at = date('Y-m-d H:i:s',time());
			$price->save();
		} else {
			return false;
		}
	}
  	/**
  		Binance Liqudity
  	**/
  	public function cancelOrder($pairid,$uuid){
		$api = new BinanceClass;
		$pair = $this->marketpair($pairid);
		if($pair){            
		  $details = $api->cancel_order($pair,$uuid);      
		}else{
		  return 'Invalid pair id';
		}
		return $details;    
	}
	public function liquidityGetOrder($pairid,$order_id){
   		$api = new BinanceClass;
	    $pair = $this->marketpair($pairid);
	    if($pair){            
	      $details = $api->order_status($pair,$order_id);      
	    }else{
	      return 'Invalid pair id';
	    }
	    return $details;    
  	}

	public function liquidityOrderBook($pairid){
		$api = new BinanceClass;
		$buytrades = array();
		$pair = $this->marketpair($pairid);
		if($pair){
		  $market = $api->market_depth($pair);
		  if(isset($market)){
		    $buytrades = $market;
		  }else{
		    $buytrades = $market;                
		  }        
		}else{
		  return 'Invalid pair id';
		}
		return $buytrades;
	}

	public function LiquidityMarketHistory($pairid){
		$api = new BinanceClass;
		$buytrades = array();
		$pair = $this->marketpair($pairid);
		if($pair){            
		  $completedtrade = $api->market_history($pair);           
		}else{
		  return 'Invalid pair id';
		}
		return $completedtrade;
	}

	public function liquidityBuyLimitTrade($pairid,$price,$volume){
		$api = new BinanceClass;
		$pair = $this->marketpair($pairid);
		if($pair){            
		  $details = $api->place_limit_buyorder($pair,$volume,$price);       
		}else{
		  return 'Invalid pair id';
		}
		return $details;
	}

	public function liquiditySellLimitTrade($pairid,$price,$volume){
		$api = new BinanceClass;
		$pair = $this->marketpair($pairid);
		if($pair){            
		  $details = $api->place_limit_sellorder($pair,$volume,$price);       
		}else{
		  return 'Invalid pair id';
		}
		return $details;
	}
	public function getLastPrice($pair)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.binance.com/api/v3/ticker/24hr?symbol=".$pair);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $headers = array();
        $headers[] = "Accept: application/json, text/plain";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        if (curl_errno($ch)) {
            $result = '';
        } else {
            $result = curl_exec($ch);
        }
        curl_close($ch);
        return json_decode($result);    
    }
}