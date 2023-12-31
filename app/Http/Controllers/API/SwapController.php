<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Tradepair;
use App\Models\Wallet;
use App\Models\SwapHistory;
use Redirect;
use Illuminate\Support\Facades\Crypt;
use Validator;

class SwapController extends Controller
{
    public $successStatus = 200;
    

    public function swaplist(){

      $list = Tradepair::where('is_swap',1)->get();
     
      return response()->json(["success"=> true ,"result" => $list ,"message" =>""],$this->successStatus);
    }

    public function getbalance(Request $request){

      $validator = Validator::make($request->all(), [
        'coinone'        => 'required|alpha_dash|max:6',
        'cointwo'        => 'required|alpha_dash|max:6',
        'coinoneamount'  => 'required|numeric|min:0',
        'cointwoamount'  => 'required|numeric|min:0',
        'type'           => 'required',
      ]);

      if ($validator->fails()) { 
        return response()->json(["success" => false,"result" => NULL,"message"=> $validator->errors()->first()], 200);           
      }

      $coinone = $request->coinone;
      $cointwo = $request->cointwo;

      if($request->type =="from"){
        $amount = $request->coinoneamount;

      }
      else if($request->type =="to"){
        $amount = $request->cointwoamount;
      }

   if($coinone != "" && $cointwo !=" " && $amount >=0  ){
       if($coinone == $cointwo){
       return response()->json(["success"=>false,"result"=>NULL,"message"=>"Can't Choose Same Coin"],$this->successStatus);
      }
      $sell  =Tradepair::where(['coinone'=>$coinone ,'cointwo'=>$cointwo])->where('is_swap',1)->first();
      if($sell){
       $pair_id   = $sell->id;
       $Liveprice = $sell->close;          


       if($request->type == 'from'){
        $Liveprice          = floatval($Liveprice);
        $paidamount         = Floatval($amount *$Liveprice);
        $commission         = bcdiv(sprintf('%.10f', $sell->swap_commission), 100, 8);
        $fees               = bcmul(sprintf('%.10f', $paidamount), sprintf('%.10f', $commission), 8);
        $data               = array();
        $data['amount']     = $amount;
        $data['liveprice']  = display_format($Liveprice,8);
        $data['paidamount'] = display_format($paidamount,8); 
        $data['fees']       = $fees;
        $data['feecon']     = $sell->cointwo;
        $data['commission']       = $sell->swap_commission;
        return response()->json(["success"=>true,"result"=>$data,"message"=>""],$this->successStatus);

      }
      else if($request->type =='to'){
       $amount              = floatval($amount);
       $Liveprice           = floatval($Liveprice);
       $paidamount          = Floatval($amount / $Liveprice);
       $commission          = bcdiv(sprintf('%.10f', $sell->swap_commission), 100, 8);
       $fees                = bcmul(sprintf('%.10f', $amount), sprintf('%.10f', $commission), 8);

       $data                = array();
       $data['amount']      = $amount;
       $data['liveprice']   = display_format($Liveprice,8);
       $data['paidamount']  = display_format($paidamount,8); 
       $data['fees']        = $fees;
       $data['feecon']      = $sell->cointwo;
       $data['commission']        = $sell->swap_commission;
       return response()->json(["success"=>true,"result"=>$data,"message"=>""],$this->successStatus);
     }
   }
   $buy  = Tradepair::where(['coinone'=>$cointwo ,'cointwo'=>$coinone])->where('is_swap',1)->first();
   if($buy){
     $pair_id =$buy->id;
     $Liveprice =$buy->close;          

     if($request->type == 'from'){
      $Liveprice = floatval($Liveprice);
      $paidamount = Floatval($amount /$Liveprice);
      $commission = bcdiv(sprintf('%.10f', $buy->swap_commission), 100, 8);
      $fees = bcmul(sprintf('%.10f', $paidamount), sprintf('%.10f', $commission), 8);
      $data =array();
      $data['amount'] =$amount;
      $data['liveprice'] =display_format($Liveprice,8);
      $data['paidamount'] =display_format($paidamount,8);
      $data['fees'] =$fees;
      $data['feecon'] =$buy->coinone;
      $data['commission'] =$buy->swap_commission;
      return response()->json(["success"=>true,"result"=>$data,"message"=>""],$this->successStatus);

    }
    else if($request->type =='to'){
     $amount = floatval($amount);
     $Liveprice = floatval($Liveprice);
     $paidamount = Floatval($amount * $Liveprice);
     $commission = bcdiv(sprintf('%.10f', $buy->swap_commission), 100, 8);
     $fees = bcmul(sprintf('%.10f', $amount), sprintf('%.10f', $commission), 8);

     $data =array();
     $data['amount'] =$amount;
     $data['liveprice'] =display_format($Liveprice,8);
     $data['paidamount'] =display_format($paidamount,8); 
     $data['fees'] =$fees;
     $data['feecon'] =$buy->coinone;
     $data['commission'] =$buy->swap_commission;
     return response()->json(["success"=>true,"result"=>$data,"message"=>""],$this->successStatus);
    }
  }
}
return response()->json(["success"=>true,"result"=>NULL,"message"=>""],$this->successStatus);

}

public function SwapTrade(Request $request){

  $validator = Validator::make($request->all(), [
    'coinone'              => 'required|alpha_dash|max:6',
    'cointwo'              => 'required|alpha_dash|max:6',
    'coinoneamount'        => 'required|numeric|min:0',
    'cointwoamount'        => 'required|numeric|min:0',
  ]); 
  if ($validator->fails()) { 
    return response()->json(["success" => false,"result" => NULL,"message"=> $validator->errors()->first()], 200);           
  }

  $user =Auth::user();
  $from =$request->coinone;
  $to =$request->cointwo;
  $coinoneamount =$request->coinoneamount;
  $cointwoamount =$request->coinoneamount;
  if($from == $to){
    return response()->json(["success" => false,"result" => NULL,"message"=> "Invalid Pair"], 200);
  }
  if($from != NULL && $to != NULL){

    $sell  =Tradepair::where([ 'coinone'=>$from ,'cointwo'=>$to])->where('is_swap',1)->first();
    if($sell){
      $pair =$sell->id;
      $fromamount =$coinoneamount;

      $data = $this->sellinstant($pair,$fromamount,'sell');
      return $data;
    }
    $buy =Tradepair::where(['coinone'=>$to ,'cointwo'=>$from])->where('is_swap',1)->first();
    if($buy){
      $pair =$buy->id;
      $fromamount =$cointwoamount;
      $data = $this->sellinstant($pair,$fromamount,'buy');
      return $data;

    }
    else {

      return response()->json(["success" => false,"result" => NULL,"message"=> "Invalid Pair"], 200);
    } 
  } 
} 

public function sellinstant($pair,$amount,$type){
  $pair = (int)$pair;
  $amount = (float)$amount;

  if($amount > 0 && $pair != "" ){
    $pair = Tradepair::where(['active'=>1,'id' => $pair])->where('is_swap',1)->first();
    $user =Auth::user();
    if(is_object($pair)){
     $commission = bcdiv(sprintf('%.10f', $pair->swap_commission), 100, 8);    
     
     $cointwo =$pair->cointwo;
     $coinone =$pair->coinone;
     if($type =='sell'){
      $wallet = Wallet::where(['uid' => $user->id, 'currency' => $coinone])->first();
     }
      if($type =='buy'){
        $wallet = Wallet::where(['uid' => $user->id, 'currency' => $cointwo])->first();
      }
     if($wallet->balance < $amount){
       return response()->json(["success" => false,"result" => NULL,"message"=> "Insufficent fund in your wallet!"], 200);
      }      
    }else{
     return response()->json(["success" => false,"result" => NULL,"message"=> "This pair currently disabled!"], 200);
    }   
    $Liveprice =$pair->close;        
    if($type =='sell'){
      $paidamount = floatval($amount * $Liveprice);
      $fees = bcmul(sprintf('%.10f', $paidamount), sprintf('%.10f', $commission), 8);       
      $get_total_val = bcsub(sprintf('%.10f', $paidamount), sprintf('%.10f', $fees), 8);
      $spendcoin = $coinone;
      $recivecoin = $cointwo;       
    }
    else if($type == 'buy'){
      $paidamount = floatval($amount / $Liveprice);
      $fees = bcmul(sprintf('%.10f', $paidamount), sprintf('%.10f', $commission), 8);
      $get_total_val = bcsub(sprintf('%.10f', $paidamount), sprintf('%.10f', $fees), 8);
      $spendcoin = $cointwo;
      $recivecoin = $coinone;
      
    }
    // echo display_format($fees,8);exit;
    $orderId = TransactionString(20);
    $clientOrderId = $user->id;
    $is_type = 0;
    $status ='COMPLETED';

    $trade = new SwapHistory;
    $trade->uid = $user->id;
    $trade->pair = $pair->id;
    $trade->recive_coin = $recivecoin;
    $trade->spend_coin = $spendcoin;
    $trade->ouid = $clientOrderId;
    $trade->order_id = $orderId;
    $trade->order_type = 4;
    $trade->volume = $amount;
    $trade->liveprice = $Liveprice;
    $trade->value = ncMul($Liveprice,$amount,8);
    $trade->fees =$fees;
    $trade->status = 1;
    $trade->leverage = 1;
    $trade->spend = 0;
    $trade->post_by = 'app';
    $trade->status_text = $status;
    $trade->is_type = $is_type;
    $trade->save();
    $trade_id = $trade->id;
    $remark = "Swap coin $spendcoin to $recivecoin"; 
    Wallet::creditAmount($user->id, $recivecoin,$get_total_val,8,'swap',$remark,$trade_id);
    Wallet::debitAmount($user->id, $spendcoin,$amount,8,'swap',$remark,$trade_id);

    return response()->json(["success" => true,"result" => NULL,"message"=> "Swapp Your Assets successfully!"], 200);
  }
}

public function pairlist(Request $request){

  $validator = Validator::make($request->all(), [
    'key'        => 'required',
  ]);

  if ($validator->fails()) { 
    return response()->json(["success" => false,"result" => NULL,"message"=> $validator->errors()->first()], 200);           
  }

  $key = $request->key;
  $uid = Auth::id();
  
  if(isset($key)){
    $coin = Tradepair::where(['coinone'=>$key])->where('is_swap',1)->first();
    $symbol =$coin->coinone;

    $onepairs =  Tradepair::where(['active' => 1, 'coinone' => $symbol])->where('is_swap',1)->pluck('cointwo')->toArray(); 
    $twopairs =   Tradepair::where(['active' => 1, 'cointwo' => $symbol])->where('is_swap',1)->pluck('coinone')->toArray();               

    $merge =array_merge($onepairs,$twopairs);
    $res =array_unique($merge);

    foreach ($res as $value ){
      $datas = Tradepair::where(['active' => 1, 'coinone' => $symbol,'cointwo'=>$value])->where('is_swap',1)->get();
      $cointwo_balance = Wallet::where('uid',$uid)->where('currency',$value)->value('balance');
      if (count($datas) > 0) {
        $data[] = ['cointwo' =>$value,'liveprice'=>$datas[0]->close,'commission_percentage' => $datas[0]->swap_commission,'type' => 'percentage','balance' => (string)$cointwo_balance];
      }
      else {
        $datas1 = Tradepair::where(['active' => 1, 'coinone' => $value,'cointwo'=>$symbol])->where('is_swap',1)->get();
        $cointwo_balance = Wallet::where('uid',$uid)->where('currency',$value)->value('balance');
        if (count($datas1) > 0) {
          $data[] = ['cointwo' =>$value,'liveprice'=>$datas1[0]->close,'commission_percentage' => $datas1[0]->swap_commission,'type' => 'percentage','balance' => (string)$cointwo_balance];
        }
      }
    }
    $balance = Wallet::where('uid',$uid)->where('currency',$key)->value('balance');
  //  $data['pairs']=$res;
    return response()->json(["success" => true,"balance" => (string)$balance,"result" => $data,"message" =>""],$this->successStatus);

  }

}

public function SwapHistory(Request $request){

  $uid         = Auth::id();        
  $history     = SwapHistory::where(['uid' => $uid])->get();

  $data = array();

  foreach ($history as $key =>$value) {

    $data[$key]['order_id']     = $value->order_id;
    $data[$key]['receive_coin'] = $value->recive_coin;
    $data[$key]['spend_coin']   = $value->spend_coin;
    $data[$key]['volume']       = (string)$value->volume;
    $data[$key]['value']        = (string)$value->value;
    $data[$key]['liveprice']    = $value->liveprice;
    $data[$key]['fees']         = (string)$value->fees;
    $data[$key]['status_text']  = $value->status_text;
  }

  return response()->json(["success" => true,"result" => $data,"message" =>""],$this->successStatus);

}

}

