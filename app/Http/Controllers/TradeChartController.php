<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
 
use Carbon\Carbon;
use App\Models\TradeViewChart;
use DB;
use App\Models\Tradepair;
use App\Models\Completedtrade;
use App\Models\Trade;
use App\Models\Selltrade;
use App\Libraries\BinanceClass;
use App\Models\TradePairLivePrice;
use App\TradeBot;

class TradeChartController extends Controller
{
     public function __construct(){       
     }

    public function trade_details($pair)
    {  
    	$CompleteTrade = Completedtrade::where('pair', $pair)->where('created_at','>',Carbon::now()->subDay(1))->get(); 
    	$high = Completedtrade::where('pair', $pair)->where('created_at','>',Carbon::now()->subDay(1))->max('price'); 
    	$low = Completedtrade::where('pair', $pair)->where('created_at','>',Carbon::now()->subDay(1))->min('price');  

    	foreach($CompleteTrade as $trade)
    	{    
        $btcaddress = new TradeViewChart;
        $btcaddress->pair = $trade->pair;
        $btcaddress->open = $CompleteTrade[0]->price;
        $btcaddress->high = $high;
        $btcaddress->low = $low;
        $btcaddress->close = $CompleteTrade[sizeof($CompleteTrade)-1]->price;
        $btcaddress->save();
    	}	
    	
    }
     public function getTradeChartDetails()
     {  
        $pair = Tradepair::where('active',1)->get();  
        foreach($pair as $p)
        {  
              $i = $p->id;
         
            $closingTrade = Completedtrade::where('pair', $i)->where('created_at','>',Carbon::now()->subDay(1))->orderBy('id', 'desc')->first();  
            $openingTrade = Completedtrade::where('pair', $i)->where('created_at','>',Carbon::now()->subDay(1))->orderBy('id', 'asc')->first();
            $high = Completedtrade::where('pair', $i)->where('created_at','>',Carbon::now()->subDay(1))->max('price','id'); 
            $low = Completedtrade::where('pair', $i)->where('created_at','>',Carbon::now()->subDay(1))->min('price');  
            if($closingTrade)    
            {
                $btcaddress = new TradeViewChart;
                $btcaddress->pair = $i;
                $btcaddress->open = $openingTrade->price;
                $btcaddress->high = $high;
                $btcaddress->low = $low;
                $btcaddress->close = $closingTrade->price;
                $btcaddress->save();
            }
        }
        return "Updated!";
    }
     function  marketdepthchart($pair='')
     { 
        $pairlist = Tradepair::where('id',$pair)->first();
        $cprice = 1;
        if(!is_object($pairlist)){
          $result = json_encode(array(),JSON_PRETTY_PRINT);
          echo $result;
        } 
        $bid_data2 = array();
        $ask_data2 = array();
        if($pairlist->is_dust == 1 && $pairlist->is_bot == 0){
            $liqi = $pairlist->symbol;
            try{
          $api = new BinanceClass;          
          $market_depth = $api->market_depth($liqi);

          $buy_order  = $market_depth['bids'];
          $sell_order  = $market_depth['asks'];
          

          foreach($buy_order as $key => $bid)
          {
            $bid_data = array();
            $bid_data[] = $key;
            $bid_data[] = $bid;
            $bid_data2[] = $bid_data;
          }

          foreach($sell_order as $key => $ask)
          {
            $ask_data = array();
            $ask_data[] = $key;
            $ask_data[] = $ask;
            $ask_data2[] = $ask_data; 
          }

          //$bid_result['asks'] = $ask_data2;
          //$bid_result['bids'] = $bid_data2;
          $bid_result['depth'] = $market_depth['depth'];
         // $result = json_encode($bid_result,JSON_PRETTY_PRINT);
          //echo $result;
        }catch(\Exception $e){
           $bid_result['depth'] = array();
          //return $e->getMessage();
          //dd($e->getMessage());
        }
        }
          
            $buy_order = Trade::select('price',DB::raw('SUM(remaining) as remaining'),DB::raw('group_concat(created_at) as created_at'))
             ->where(['trade_type' => 'Buy','order_type' => 1, 'pair' => $pair,'status' => 0])        
             ->groupBy('price')
             ->orderBy('price', 'asc')
             ->limit(100)->get();
             $sell_order = Trade::select('price', DB::raw('SUM(remaining) as remaining'),DB::raw('group_concat(created_at) as created_at'))
             ->where(['trade_type' => 'Sell','order_type' => 1, 'pair' => $pair,'status' => 0])
             ->orderBy('price', 'asc')
             ->groupBy('price')
             ->limit(100)->get();
             $complete = Completedtrade::where([['pair' ,'=' ,$pair]])->limit(200)->orderBy('id','DESC')->get();

             

        if(count($buy_order) > 0)
        {
          foreach($buy_order as $bid)
          {
            $bid_data = array();
            $bid_data[] = $bid->price;
            $bid_data[] = $bid->remaining;
            $bid_data2[] = $bid_data;
          }
        }
        if(count($sell_order) > 0)
        {
          foreach($sell_order as $ask)
          {
            $ask_data = array();
            $ask_data[] = $ask->price;
            $ask_data[] = $ask->remaining;
            $ask_data2[] = $ask_data; 
          }
          
        }

        $bid_result['asks'] = $ask_data2;
        $bid_result['bids'] = $bid_data2;
        $bid_result['trades'] = $complete;
        $bid_result['lastUpdateId'] = 1;
        $result = json_encode($bid_result,JSON_PRETTY_PRINT);
        echo $result; 
            
     }
     public function getBinanceOrderBook($value='')
     {
       $pairlist = Tradepair::where('id',$pair)->first();
     }
     public function generateBotTrade($id){

        $trades = Tradepair::where(['is_bot' => 1,'id' => $id])->get();
        if(count($trades) > 0){
            foreach($trades as $trade){
                $PID = $trade->id;
                TradeBot::where('pair',$PID)->delete();
                $startBuyPrice = $trade->start_buy_price;
                $endBuyPrice = $trade->end_buy_price;
                $startSellPrice = $trade->start_sell_price;
                $endSellPrice = $trade->end_sell_price;
                $startVolume = $trade->start_volume;
                $endVolume = $trade->end_volume;
                $coinone_decimal = $trade->coinone_decimal;
                $cointwo_decimal = $trade->cointwo_decimal;
                for($i=1;$i<=10;$i++){
                    $type = "Buy";
                    $price = $this->randomDecimal($startBuyPrice,$endBuyPrice,$cointwo_decimal);
                    $volume = $this->randomDecimal($startVolume,$endVolume,$coinone_decimal);
                    $value = ncMul($price,$volume,$cointwo_decimal);
                    $orderId = TransactionString(20);
                    $botTrade = new TradeBot;
                    $botTrade->trade_type = $type;
                    $botTrade->pair = $PID;
                    $botTrade->order_type = 1;
                    $botTrade->price = $price;
                    $botTrade->volume = $volume;
                    $botTrade->value = $value;
                    $botTrade->fees = 0;
                    $botTrade->commission = 0;
                    $botTrade->remaining = $botTrade->volume;
                    $botTrade->created_at = date('Y-m-d H:i:s',time());
                    $botTrade->save();
                    //dd($botTrade);
                }
                for($i=1;$i<=10;$i++){
                    $type = "Sell";
                    $price = $this->randomDecimal($startSellPrice,$endSellPrice,$cointwo_decimal);
                    $volume = $this->randomDecimal($startVolume,$endVolume,$coinone_decimal);
                    
                    $value = ncMul($price,$volume,$cointwo_decimal);
                    $orderId = TransactionString(20);
                    $botTrade = new TradeBot;
                    $botTrade->trade_type = $type;
                    $botTrade->pair = $PID;
                    $botTrade->order_type = 1;
                    $botTrade->price = $price;
                    $botTrade->volume = $volume;
                    $botTrade->value = $value;
                    $botTrade->fees = 0;
                    $botTrade->commission = 0;
                    $botTrade->remaining = $botTrade->volume;
                    $botTrade->created_at = date('Y-m-d H:i:s',time());
                    $botTrade->save();
                    //dd($botTrade);
                }
                return "Done";
            }

        }
    }
    /**
     * @param float $min
     * @param float $max
     * @param int $digit
     * @return float|int
     */
    public function randomDecimal(float $min, float $max, int $digit = 2)
    {
        $num = $min + lcg_value() * ($max - $min);
        return $randomFloat = sprintf('%.'.$digit.'f', $num);
        //return mt_rand($min  10, $max  10) / pow(10, $digit);
    }
}
