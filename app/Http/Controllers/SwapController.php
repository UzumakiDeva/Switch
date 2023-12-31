<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Tradepair;
use App\Models\Wallet;
use App\Models\SwapHistory;
use Redirect;
use Illuminate\Support\Facades\Crypt;

class SwapController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','twofa']);
    }

    public function listcoin(){

      $list = Tradepair::where('is_swap',1)->get();
      return view('swap',['list'=>$list]);
    }

    public function getbalance(Request $request){

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
        return NULL ;
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
        $data['comm']       = $sell->swap_commission;
        return response()->json(['data'=>$data]);

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
       $data['comm']        = $sell->swap_commission;
       return response()->json(['data'=>$data]);
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
      $data['comm'] =$buy->swap_commission;
      return response()->json(['data'=>$data]);

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
     $data['comm'] =$buy->swap_commission;
     return response()->json(['data'=>$data]);
   }
 }
}
 return NULL ;

}

public function SwapTrade(Request $request){

  $this->validate($request, [
    'coinone'              => 'required|alpha_dash|max:6',
    'cointwo'              => 'required|alpha_dash|max:6',
    'coinoneamount'        => 'required|numeric|min:0',
    'cointwoamount'        => 'required|numeric|min:0',
  ]); 

  $user =Auth::user();
  $from =$request->coinone;
  $to =$request->cointwo;
  $coinoneamount =$request->coinoneamount;
  $cointwoamount =$request->coinoneamount;
  if($from == $to){
    return redirect('/swap')->with('status','Invalid Pair');
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

      return redirect('/swap')->with('status','Invalid Pair');
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
       return Redirect::back()->with('failed', "Insufficent fund in your wallet!");
      }      
    }else{
      return Redirect::back()->with('failed', "This pair currently disabled!");
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
    $trade->post_by = 'web';
    $trade->status_text = $status;
    $trade->is_type = $is_type;
    $trade->save();
    $trade_id = $trade->id;
    $remark = "Swap coin $spendcoin to $recivecoin"; 
    Wallet::creditAmount($user->id, $recivecoin,$get_total_val,8,'swap',$remark,$trade_id);
    Wallet::debitAmount($user->id, $spendcoin,$amount,8,'swap',$remark,$trade_id);
    return redirect('/swap')->with('status','Swapp Your Assets successfully!');
  }
}

public function pairlist($key){
  //echo $key;exit;
  if(isset($key)){
    $coin = Tradepair::where(['coinone'=>$key])->where('is_swap',1)->first();
    $symbol =$coin->coinone;

            $onepairs =  Tradepair::where(['active' => 1, 'coinone' => $symbol])->where('is_swap',1)->pluck('cointwo')->toArray(); 
            $twopairs =   Tradepair::where(['active' => 1, 'cointwo' => $symbol])->where('is_swap',1)->pluck('coinone')->toArray();               

             $merge =array_merge($onepairs,$twopairs);
             $res =array_unique($merge);
            
      $data['pairs']=$res;
      return $data;
  }
  
}

}

