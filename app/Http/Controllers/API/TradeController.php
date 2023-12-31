<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Validator;
use Session;
use App\Libraries\BinanceClass;
use App\Models\Transaction;
use App\Models\Adminwallet;
use App\User;
use App\Models\Commission;
use App\Models\Tradepair;
use App\Models\Wallet;
use App\Models\Completedtrade;
use App\Models\Trade;
use App\Models\AffliateTransaction;
use App\Http\Controllers\API\TradeLimitController;
use App\Http\Controllers\API\TradeMarketController;

class TradeController extends Controller{
    public $successStatus = 200;
      
       
    public function assetslist(){
        $assets =Commission::where('shown',1)->get();
        $uid = Auth::user()->id;
        $data =array();
        $totalUSD = 0;
        foreach($assets as $key=> $coin){
            $data[$key]['asset']  	= $coin->source;
            $data[$key]['symbol']  	= $coin->source;
            $data[$key]['name']  	= $coin->coinname;
            $data[$key]['type']  	= $coin->type;
            $data[$key]['image']  	= url('images/color/'.$coin->image);
            $data[$key]['point_value']  = $coin->point_value;
            $data[$key]['perday_withdraw']  = $coin->perday_withdraw;
            $data[$key]['fee']  = (string)$coin->withdraw;
            $data[$key]['commission_type']  = $coin->com_type;

            $is_wallet = Wallet::where(['uid'=> $uid,'currency'=> $coin->source])->first();
            if($is_wallet){
                $data[$key]['balance']  = display_format($is_wallet->balance,$coin->point_value);
                $data[$key]['escrow']  = display_format($is_wallet->escrow_balance,$coin->point_value);
                $data[$key]['total']  = ncAdd($is_wallet->balance,$is_wallet->escrow_balance,$coin->point_value);

                $usdt =Tradepair::where(['coinone'=>$coin->source,'cointwo'=>'USDT','active'=>1])->first();
                if(is_object($usdt)){
                    $converttotal = ncMul($is_wallet->balance,$usdt->close,2);                
                }else{
                    $converttotal = ncMul($is_wallet->balance,1,2);
                }
                $data[$key]['usdtconvert'] = $converttotal;
                $totalUSD = ncAdd($totalUSD,$converttotal,2);
            }else{
                $data[$key]['balance']  = display_format(0,$coin->point_value);
                $data[$key]['escrow']  = display_format(0,$coin->point_value);
                $data[$key]['total']  = display_format(0,$coin->point_value);
                $data[$key]['usdtconvert']  = "0.00";
            }     
        }
        return response()->json(["success" => true,'result' => $data,"total_usdt" => $totalUSD,'message'=> ""], $this->successStatus);  
    }


    public function assetDetails(Request $request) {
		$validator = Validator::make($request->all(), [
        	'asset' => 'required|alpha_dash|max:13'
        ]);

        if ($validator->fails()) { 
        	return response()->json(["success" => false,"result" => NULL,'message'=> $validator->errors()->first()], 200);           
        }
        
		$uid = Auth::user()->id;
		$asset = $request->asset;
        $coins = strtoupper($asset); 
		$coin = Commission::where(['source' => $asset ,'shown' => 1])->first();
        $tokenLists = Commission::where([['source','=',$coins],['type','!=','fiat']])->get();
        // dd($tokenLists);
		if(!is_object($coin)){
			return response()->json(["success" => false,"result" => NULL,'message'=> "Invalid coin name given!"], 200);
		}
        $network=array();
        if(count($tokenLists) > 0){
            foreach ($tokenLists as $key => $tokenlist)
          {
            $type = $tokenlist->type;
            $trxaddress = Wallet::where(['uid'=> $uid,'currency'=> 'TRX'])->value('mukavari');
            $ethaddress = Wallet::where(['uid'=> $uid,'currency'=> 'ETH'])->value('mukavari');
           
            if($type == 'trxtoken'){
                if($tokenlist->source == 'NAS'){
                    $coinname = 'Tron (TRC10)'; 
                    $network[$key]['type'] = 'TRC10';                   
                    $network[$key]['name'] =$coinname;
                } else{
                    $coinname = 'Tron (TRC20)';
                    $network[$key]['type'] = 'TRC20';  
                    $network[$key]['name'] =$coinname;
                }
                $useraddress = $trxaddress;  
            }elseif ($type == 'coin') {  
                $coinname = $tokenlist->coinname;
                $is_wallet = Wallet::where(['uid'=> $uid,'currency'=> $tokenlist->source])->first();
                if(is_object($is_wallet)){
                    $useraddress = $is_wallet->mukavari;
                }else{
                    $useraddress = "";
                }
            } else {
                $coinname = 'Ethereum (ERC20)';
                $ntype  ='ERC20';
                if($type == 'bsctoken'){
                    $coinname = 'BSC (BEP20)';
                    $ntype ='BEP20';
                } else if($type == 'erctoken'){
                    $coinname = 'Ethereum (ERC20)';
                    $ntype ='ERC20';
                } else if($type == 'polytoken'){
                    $coinname = 'MATIC (Poly20)';
                    $ntype ='polygon';
                }
                $useraddress = $ethaddress;                
            }
            $network[$key]['type'] = $tokenlist->type;  
            $network[$key]['name'] = $coinname;
            $network[$key]['address'] = $useraddress;
            $network[$key]['withdrawtype'] = $tokenlist->com_type;
            $network[$key]['withdrawcommission'] = $tokenlist->withdraw;
         }

        }

		$currency = strtolower($coin->source);
        $pointvalue =  $coin->point_value;  
        $is_wallet = Wallet::where(['uid'=> $uid,'currency'=> $coin->source])->first();
        if(is_object($is_wallet)){
            $wallet_address = $is_wallet->mukavari;
            $balance = display_format($is_wallet->balance,$pointvalue);
            $escrow_balance = display_format($is_wallet->escrow_balance,$pointvalue);
            $totalbalance = ncAdd($balance,$escrow_balance,$pointvalue);
        }else{
            $wallet_address = "";
            $balance = display_format(0,$pointvalue);
            $escrow_balance = display_format(0,$pointvalue);
            $totalbalance = display_format(0,$pointvalue);
        }
        $data = array();
		$data['asset']  		= $coin->source;
		$data['symbol']  		= strtolower($coin->source);
		$data['address']  		= $wallet_address;
		$data['qrcode'] 		= 'https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=' . $coin->source . ':' . $wallet_address . '&choe=UTF-8';
		$data['name']  			= $coin->coinname;
		$data['type']  			= $coin->type;
		$data['image']  		= url('images/color/'.$coin->image);
		$data['point_value']  	= (string)$coin->point_value;
		$data['perday_withdraw']  = (string)$coin->perday_withdraw;
		$data['fee']  = (string)$coin->withdraw;
		 $data['commission_type']  = $coin->com_type;
		$data['balance']  = $balance;
		$data['escrow']  = $escrow_balance;
		$data['total']  = $totalbalance;		
		return response()->json(["success" => true,'result' => $data,'network'=>$network,'message'=> ""], $this->successStatus);
	}
    public function tradePairList() {

		$tradeprice = Tradepair::where('active',1)->get();
		$data =array();
		foreach($tradeprice as $key => $tradeorders)
		{
			$data[$key]['trade_pair']  	= $tradeorders->coinone.'/'.$tradeorders->cointwo;
			$data[$key]['symbol']  	= $tradeorders->symbol;
            $data[$key]['pair_id']       =$tradeorders->id;
			$data[$key]['base_asset']  	= $tradeorders->coinone;
			$data[$key]['market_asset']  	= $tradeorders->cointwo;
		    $data[$key]['image']  	= url('images/color/'.$tradeorders->coinonedetails['image']);
			$data[$key]['hr_volume']  	= display_format($tradeorders->hrvolume,8);
			$data[$key]['current_price'] = display_format($tradeorders->close,8);
			$data[$key]['hr_exchange'] 	= display_format($tradeorders->hrchange,2);
			$data[$key]['open'] 	= display_format($tradeorders->open,2);
			$data[$key]['close'] 	= display_format($tradeorders->close,2);
			$data[$key]['high'] 	= display_format($tradeorders->high,2);
			$data[$key]['low'] 	= display_format($tradeorders->low,2);
			$data[$key]['coinone_decimal']  	= $tradeorders->coinone_decimal;
            $data[$key]['cointwo_decimal']  	= $tradeorders->cointwo_decimal;
			$data[$key]['is_instant']  	= $tradeorders->is_market;
		}
		return response()->json(["success" => true,'result' => $data,'message'=> ""], $this->successStatus);
	}
	public function index($market=NULL)
	{
		if($market!=NULL){
			$coinpair = explode('_',$market);  
			$selectPair = Tradepair::where([
				['coinone', '=', $coinpair[0]],
				['cointwo', '=', $coinpair[1]],
				['active', '=', 1],
				['is_spot', '=', 1],
			])->first();
		} else {
			$selectPair =  Tradepair::where(['active' => 1, 'is_spot' => 1])->orderBy('orderlist','Asc')->first();            
		}
		if(!$selectPair){
			return abort(404);
		}
		$pair = $selectPair->id;
		$uid = Auth::user()->id;
		$coinone = $selectPair->coinone;
		$cointwo = $selectPair->cointwo;
		$coinonebalance = Wallet::where(['uid'=> $uid,'currency'=> $coinone])->value('balance');
		$cointwobalance = Wallet::where(['uid'=> $uid,'currency'=> $cointwo])->value('balance');
		$trades = Tradepair::where(['active' => 1, 'is_spot' => 1])->orderBy('orderlist','Asc')->get();
		$complete = Completedtrade::where([['pair' ,'=' ,$pair]])->limit(200)->orderBy('id','DESC')->get();
		$openTrades = Trade::where(['uid' => $uid, 'status' => 0])->get();
		$closeTrades = Trade::where([['uid','=', $uid], ['status' ,'!=', 0]])->get();

        $data = array();
        $data['coinone'] =$coinone;
        $data['cointwo'] =$cointwo;
        $data['trades'] =$trades;
        $data['selectPair'] =$selectPair;
        $data['openTrades'] =$openTrades;
        $data['closeTrades'] =$closeTrades;
        $data['completes'] =$complete;
        $data['coinonebalance'] =$coinonebalance;
        $data['cointwobalance'] =$cointwobalance;

		return response()->json(["success" => true,'result'=>$data,'message'=> ""], $this->successStatus);
	}
    public function Openorders(){
        $uid =Auth::user()->id;
        if(!isset($uid)){       
            return response()->json(["success" => false,"result" => NULL,'message'=> "Invalid User ID!"], 200);
		}
        $Trades = Trade::where(['uid' => $uid, 'status' => 0])->orderby('id','DESC')->get();
        if(count($Trades)>0)
        {
         $data =array();
         foreach($Trades as $key =>$openTrades) 
         {
           if($openTrades->order_type == 2){
              $Type ='Market';
           }
           else if($openTrades->order_type == 1){
             $Type ='Limit';
             
           }
         $pair =Tradepair::where(['id'=> $openTrades->pair])->first();
         $pairName =$pair->coinone.'/'.$pair->cointwo;
         $data[$key]['id'] =$openTrades->id;
         $data[$key]['trade_type'] =$openTrades->trade_type;
         $data[$key]['order_id'] =$openTrades->order_id;
         $data[$key]['pair'] =$pairName;
         $data[$key]['order_type'] =$Type;
         $data[$key]['price'] =display_format($openTrades->price);
         $data[$key]['volume'] =display_format($openTrades->volume);
         $data[$key]['value'] =display_format($openTrades->value);
         $data[$key]['fees'] =display_format($openTrades->fees);
         $data[$key]['remaining'] =display_format($openTrades->remaining);
         $data[$key]['balance'] =display_format($openTrades->balance);
         $data[$key]['status']    =$openTrades->status_text;
         $data[$key]['created_at'] =$openTrades->created_at;
         $data[$key]['updated_at'] =$openTrades->updated_at;
         }
        return response()->json(["success" => true,'result'=>$data,"message"=>""],$this->successStatus); 
        }
        else{
            return response()->json(["success" => false,'result'=>NULL,"message"=>"Open Orders Not Found For This User"],$this->successStatus);
        }    
    } 

    public function Market() {

		$tradeprice = Tradepair::where('active',1)->get();
		$data =array();
		foreach($tradeprice as $key => $tradeorders)
		{   $data[$key]['id']       =$tradeorders->id;
			$data[$key]['trade_pair']  	= $tradeorders->coinone.'/'.$tradeorders->cointwo;
			$data[$key]['symbol']  	= $tradeorders->symbol;
			$data[$key]['base_asset']  	= $tradeorders->coinone;
			$data[$key]['market_asset']  	= $tradeorders->cointwo;
		    $data[$key]['image']  	= url('images/color/'.$tradeorders->coinonedetails['image']);
			$data[$key]['hr_volume']  	= display_format($tradeorders->hrvolume,8);
			$data[$key]['current_price'] = display_format($tradeorders->close,8);
			$data[$key]['hr_exchange'] 	= display_format($tradeorders->hrchange,2);
			$data[$key]['open'] 	= display_format($tradeorders->open,2);
			$data[$key]['close'] 	= display_format($tradeorders->close,2);
			$data[$key]['high'] 	= display_format($tradeorders->high,2);
			$data[$key]['low'] 	= display_format($tradeorders->low,2);
			$data[$key]['coinone_decimal']  	= $tradeorders->coinone_decimal;
            $data[$key]['cointwo_decimal']  	= $tradeorders->cointwo_decimal;
			$data[$key]['is_instant']  	= $tradeorders->is_market;
		}
		return response()->json(["success" => true,'result' => $data,'message'=> ""], $this->successStatus);
	}
	
    public function marketView()
    {
        $trades = Tradepair::where('active',1)->orderBy('orderlist','Asc')->get();
        foreach ($trades as $pairs) 
        {
   
          $markets[$pairs->cointwo][] = $pairs->coinone;
        }
        $tabsTrades = Tradepair::where('active',1)->orderBy('orderlist','Asc')->take(4)->get();
        $data =array();
        $data['trades'] =$trades;
        $data['tabsTrades'] =$tabsTrades;
        $data['marketpairs'] =$markets;

        return response()->json(["success" => true ,'result'=>$data,'message'=>""],$this->successStatus);
    }

    public function cancelTrade(Request $request){
        $validator = Validator::make($request->all(), [
        	'id' => 'required|numeric'
        ]);

        if ($validator->fails()) { 
        	return response()->json(["success" => false,"result" => NULL,'message'=> $validator->errors()->first()], 200);           
        }
        $id = $request->id;
        $uid = Auth::user()->id;
        $trades = Trade::where(['id' => $id, 'uid' => $uid, 'status' => 0])->first();
        if(!$trades){
            return response()->json(["success" => false,"result" => NULL,'message'=> "Trade Not Found!"], 200);
        }
        if($trades->trade_type == 'Buy'){
            $responseData = $this->Tradecancelbuyorder($trades->id);
        } else{
            $responseData = $this->Tradecancelsellorder($trades->id);  
        }

       $data = $responseData->getData();  
       return response()->json(["success" =>$data->success,'result'=>NULL,'message'=>$data->message],$this->successStatus);     
    }
	public function Tradecancelbuyorder($id) {      


        $uid = Auth::user()->id;
        // Buy Trade
        $buytrades = Trade::where(['id' => $id, 'uid' => $uid, 'status' => 0])->first();
        if ($buytrades) {
            $price      = $buytrades->price;
            $volume     = $buytrades->remaining;
            $spend      = $buytrades->spend;
            $leverage   = $buytrades->leverage;
            $trdepair   = Tradepair::where(['active' => 1,'id' => $buytrades->pair])->first();
            $currency   = $trdepair->cointwo;
            $commission = $buytrades->commission;
            $value      = ncAdd($buytrades->value, $buytrades->fees,8);
            $selled     = 0;
            $fee        = ncAdd($buytrades->fees, $value, 8);
            if($trdepair->is_type == 1){
                $check = $this->cancelOrder($buytrades->pair,$buytrades->order_id);
                if($check->success == "true"){
                    $returnvalue = ncMul($price,$volume,8);
                    $returncommission = ncMul($returnvalue,$commission,8);
                    $total = ncAdd($returnvalue,$returncommission,8);
                    $leve_bal = 0; 
                    $pairname   = $trdepair->coinone.'/'.$trdepair->cointwo;
                    $this->creditAmountPending($uid, $currency, $total, $fee,$leve_bal,'buy',$pairname,$id);          
                    $buytrades->status_text = "CANCELLED";
                    $buytrades->status = 100;
                    $buytrades->save();
                }else{
                    $msg = $check->message;
					return response()->json(['success'=>false,"result"=>"","message"=>$msg]);
                    
                }
            }else{
                if($buytrades->order_type !=2) {
                    $selled = Completedtrade::where('buytrade_id', $buytrades->id)->sum('value');
                    $selledcom = ncMul($selled,$commission,8);
                    $selltotal = ncAdd($selled,$selledcom,8);
                    $total = ncSub($value,$selltotal,8);
                    $value  = ncSub($buytrades->value, $selled, 8);
                }
                $fee        = ncAdd($buytrades->fees, $value, 8);
                $leve_bal = 0;     
                $pairname   = $trdepair->coinone.'/'.$trdepair->cointwo;
                $this->creditAmountPending($uid, $currency, $total, $fee,$leve_bal,'buy',$pairname,$id);

                $buytrades->status_text = "CANCELLED";
                $buytrades->status = 100;
                $buytrades->save();
            }
			return response()->json(['success'=>true ,"result"=>NULL,"message"=>'Pending order cancelled successfully!']);
            

        } else {
			return resposne()->json(["success"=>true,"result"=>NULL,"message"=>'Bad Request!']);
        }
    }

    public function Tradecancelsellorder($id) {
        $uid = Auth::user()->id;
        // Buy Trade
        $selltrades = Trade::where(['id' => $id, 'uid' => $uid, 'status' => 0])->first();
        if ($selltrades) {
            $volume     = $selltrades->remaining;
            $spend      = $selltrades->spend;
            $leverage   = $selltrades->leverage;
            $trdepair   = Tradepair::where(['active' => 1,'id' => $selltrades->pair])->first();
            $currency   = $trdepair->coinone;
            $value      = $volume;
            $adminfee   = ncMul($value, $selltrades->commission, 8);
            $total      = ncAdd($value, $adminfee, 8);
            $fee        = ncAdd($selltrades->fees, $value, 8);
            $leve_bal = 0;            
            if($trdepair->is_type == 1){           
                $check = $this->cancelOrder($selltrades->pair,$selltrades->order_id);
                if($check->success == "true"){

                    $pairname   = $trdepair->coinone.'/'.$trdepair->cointwo;
                    $this->creditAmountPending($uid, $currency, $total, $fee,$leve_bal,'sell',$pairname,$id);
                    $selltrades->status_text = "CANCELLED";
                    $selltrades->status = 100;
                    $selltrades->save();
                }else{
                    $msg = $check->message;
					return response()->json(["success"=>false,"result"=>NULL,"message"=>$msg]);
                }
            }else{
                $pairname   = $trdepair->coinone.'/'.$trdepair->cointwo;
                $this->creditAmountPending($uid, $currency, $total, $fee,$leve_bal,'sell',$pairname,$id);
                $selltrades->status_text = "CANCELLED";
                $selltrades->status = 100;
                $selltrades->save();
            }
			return response()->json(["success"=>true,"result"=>NULL,"message"=>'Pending order cancelled successfully!']);

        } else {
			return response()->json(["success"=>false ,"result"=>NULL ,"message"=>'Bad Request!']);
        }

    }
	
	public function creditAmountPending($uid, $currency, $balance, $escrow,$leverage,$tradetype,$pairname = null,$insertid=null) {
        $userbalance = Wallet::where([['uid', '=', $uid], ['currency', '=', $currency]])->first();
        $oldbalance = $userbalance->balance;
        if ($userbalance) {
            $leverage   = ncSub($userbalance->vilimpu_camanilai,$leverage,8);
            $total      = ncAdd($userbalance->balance,$balance, 8);
            $walletbalance =$total;
            $ecrowtotal = ncSub($userbalance->escrow_balance, $escrow, 8);
            if($ecrowtotal < 0){
                $total = ncAdd($total,$ecrowtotal,8);
                $ecrowtotal = 0;
            }
            $userbalance->balance           = $total;
            $userbalance->escrow_balance    = $ecrowtotal;
            $userbalance->updated_at        = date('Y-m-d H:i:s',time());
            $userbalance->save();
        }
        $this->AllcoinUpdateBalanceTrack($uid,$currency,$balance,$walletbalance,$oldbalance,$tradetype,$pairname,$insertid);

        return true;
    }

    public function AllcoinUpdateBalanceTrack($uid,$currency,$amount,$walletbalance,$oldbalance,$tradetype,$pairname,$insertid)
    {
        $Models = '\App\Models\OverallTransaction';
        $remark = 'Cancelled '.$tradetype.' trade in ' .$pairname;
        $type = $tradetype.'trade';
        $Models::AddTransaction($uid,$currency,$type,$amount,0,$walletbalance,$oldbalance,$remark,'web',$insertid);
        return true;
    }
    public function postTrade(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pair'      => 'required|alpha_dash|max:20',
            'side'   => 'required|in:buy,sell',
            'type'   => 'required|in:limit,market,instant',
            'quantity'    => 'required|numeric',
            'price'    => 'nullable|numeric',
        ]);
        if ($validator->fails()) { 
        	return response()->json(["success" => false,"result" => NULL,'message'=> $validator->errors()->first()], 200);           
        }

        $pair = $request->pair;
        $side = $request->side;
        $type = $request->type;
        $quantity = $request->quantity;

        if($type == 'limit'){

             $function =new TradeLimitController;
        	if($side == 'buy'){
             return $function->buylimit($request);

        	}else{
              return $function->selllimit($request);

        	}        	
        }else if($type == 'market'){
            $function =new TradeMarketController;
        	if($side == 'buy'){
             return $function->buymarket($request);
        	}else{
              return $function->sellmarket($request);
        	}        	
        }      

    }
}

?>