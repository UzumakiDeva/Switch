<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Crypt; 
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Mail;
use Validator;
use Session;
use Auth;
use App\User;
use App\Models\Wallet;
use App\Models\Commission;
use App\Models\Coinwithdraw;
use App\Models\CurrencyWithdraw;
use App\Models\Currencydeposit;
use App\Traits\GoogleAuthenticator;
use App\Models\Cryptotransaction;
use App\Mail\SendOtpVerification;
use App\Models\Tradepair;

class WalletController extends Controller
{
    public $successStatus = 200;
    use GoogleAuthenticator;
       
    public function validatecryptoWithdraw(Request $request){

        $validator = Validator::make($request->all(), [
            'coin' => 'required|required|alpha',
            'address' => 'required|alpha_dash',
            'amount'  =>'required|numeric|min:0',
            'OTP'    =>'required|numeric',
            'network' =>'required',
        ]);
        if ($validator->fails()) { 
        	return response()->json(["success" => false,"result" => NULL,'message'=> $validator->errors()->first()], 200);           
        }
        $uid = \Auth::id();
        $user =User::where(['id'=>$uid])->first();      
        $currency = strtoupper($request->coin);
        $otp =$request->OTP;

      if($user->twofa_status == 1)
      {

       if($user->twofa == 'google_otp'){
        $secret = $user->google2fa_secret;
        $oneCode = $this->getCode($secret);
        $data = $this->verifyCode($secret, $otp, 2);
           if(!$data){
            return response()->json(['success'=>false,'result'=>NULL,'message'=>'OTP mismatch']);
           } 
        }
        elseif($user->twofa == 'email_otp'){
            $profile_otp = $user->profile_otp;
            
            if($profile_otp != $otp){
                return response()->json(['success'=>false,'result'=>NULL,'message'=>'OTP mismatch']);
            }
        }
      }
        else{

            $profile_otp = $user->profile_otp;

            if($profile_otp != $otp){
                return response()->json(['success'=>false,'result'=>NULL,'message'=>'OTP mismatch']);
            }

        }
        $otp  = rand(100000,999999);
        $profile_upload = User::where(['email' => $user->email])->update(['profile_otp' => $otp]);

        
        // if(Auth::user()->kyc_verify == 1){
            
            $btcDeatils = Commission::where(['source' =>  $currency,'type' => $request->network])->first();
            if($btcDeatils){
                $network = $request->network;
                if($currency == 'BTC')
                {
                    $validator = Validator::make($request->all(), [
                    'address' => 'required|regex:/^[13][a-km-zA-HJ-NP-Z1-9]{25,34}$/',
                    ]); 
                }
                else if($currency == 'ETH' || $currency == 'BNB' || $currency == 'MATIC' || $network == 'token' || $network == 'erctoken'|| $network == 'bsctoken' || $network == 'polytoken')
                {
                    $validator = Validator::make($request->all(), [
                    'address' => 'required|regex:/^0x[a-fA-F0-9]{40}$/',
                    ]); 
                }
                else if($currency == 'LTC')
                {
                    $validator = Validator::make($request->all(),[
                    'address' => 'required|regex:/^[LM3][a-km-zA-HJ-NP-Z1-9]{26,33}$/',
                    ]); 

                }
                else if($currency == 'XRP')
                {
                    $validator = Validator::make($request->all(), [
                    'destination_tag' => 'required|numeric',
                    ]); 

                }
                else if($request->network)
                {
                    $validator = Validator::make($request->all(), [
                        'network' => 'required|alpha_dash',
                    ]); 

                }
                $validator = Validator::make($request->all(), [
                    'amount' => 'required|numeric',
                    'coin' => 'required|alpha_dash',
                ]); 
                if ($validator->fails()) { 
                    return response()->json(["success" => false,"result" => NULL,'message'=> $validator->errors()->first()], 200);           
                }       
                $to_address = $request->address;   
                
                if($request->network)
                {
                  $Rnetwork = $request->network;
                }else{
                    $Rnetwork = 'Coin';
                }

                if($request->destination_tag)
                {
                  $destination_tag = $request->destination_tag;
                }else{
                    $destination_tag =  NULL;
                }
                  
                if($request->withdrawtype)
                {
                  $withdrawtype = $request->withdrawtype;
                }else{
                    $withdrawtype =  NULL;
                }
            
                $balance        = 0;        
                $commission     = ($btcDeatils->withdraw / 100);
                $amount         = abs($request->amount);
                $decimal    = $btcDeatils->point_value;
                if($btcDeatils->com_type == 'Fixed'){
                   $fee         = $btcDeatils->withdraw; 
                   $debitamt    = ncSub($amount, $fee,8);
                }else{
                    $commission = ncDiv($btcDeatils->withdraw,100);
                    $fee        = ncMul($amount,$commission,8);
                    $debitamt   = ncSub($amount, $fee,8);
                }
                $balance        = Wallet::where([['uid', '=', $uid],['currency',$currency]])->value('balance');
                $min_withdraw   = $btcDeatils->min_withdraw;
                $perday_withdraw = $btcDeatils->perday_withdraw;
                $network         = $Rnetwork;
                $type = $btcDeatils->type;
                $mtype ='App';

                if($type == 'fiat')
                {
                    $TodaywithdrawAmount = CurrencyWithdraw::where(['uid' => $uid, 'type' => $currency])->whereIn('status',[0,1])->whereRaw('Date(created_at) = CURDATE()')->sum('amount');
                }
                else{
                    $TodaywithdrawAmount = Coinwithdraw::where(['uid' => $uid, 'coin_name' => $currency])->whereIn('status',[0,1])->whereRaw('Date(created_at) = CURDATE()')->sum('amount');
                }

                $findminmumwithdrawamount = bcsub($perday_withdraw,$TodaywithdrawAmount,8);
                if($debitamt > $fee){
                    if($amount >= $min_withdraw AND $amount > 0){
                        if($findminmumwithdrawamount >= $amount){   
                            if($to_address!=""){
                                if($balance >= $amount && $balance > 0){
                                    $wallet = Wallet::where([['uid', '=', $uid],['currency',$currency]])->first();
                                    $checkbal = ncSub($wallet->balance,$amount);
                                    if($checkbal <= 0){
                                        return response()->json(['success'=>false ,"result"=>"","message"=>"Insufficient fund!"]);
                                    }
                                    if($type == 'fiat'){
                                         
                                         if($request->bank_id){
                                            $bankid = $request->bank_id;
                                         }
                                         else{
                                            $bankid =NULL;
                                         }
                                        $inserid = CurrencyWithdraw::createTransaction($uid,$currency,$bankid,$to_address,$amount,$fee,$debitamt);
                                    }else{
                                        if($Rnetwork == 'token' || $Rnetwork == 'erctoken'){
                                            $fromaddress    = Wallet::where(['currency' =>'ETH','uid' => \Auth::id()])->value('mukavari');
                                            $network = "ERC20";
                                        }else if($Rnetwork == 'bsctoken'){
                                            $fromaddress    = Wallet::where(['currency' =>'ETH','uid' => \Auth::id()])->value('mukavari');
                                            $network = "BEP20";
                                        }else if($Rnetwork == 'trxtoken'){
                                            $fromaddress    = Wallet::where(['currency' =>'TRX','uid' => \Auth::id()])->value('mukavari');
                                            $network = "TRC20";
                                        }else{
                                            $fromaddress    = Wallet::where(['currency' => $currency,'uid' => \Auth::id()])->value('mukavari');
                                            $network = $Rnetwork;
                                        }
                                        //Internal transaction for coin withdraw
                                        $internal_trans = Wallet::where([['uid' ,'!=' , $uid],['mukavari' ,'=' , $to_address]])->first();
                                        if(isset($internal_trans))
                                        {
                                            $uid1           = $internal_trans->uid;                                            
                                            $amount         = $amount;
                                            $txid           = TransactionString().$uid1;
                                            $confirm        = 1;
                                            $time           = date("Y-m-d H:i:s");
                                            $status         = 1;
                                            $nirvaki_nilai  = 99;
                                            
                                            $remark = "Internal Transfer from $uid ";                               
            
                                            Cryptotransaction::createTransaction($uid1,$currency,$txid,$fromaddress,$to_address,$amount,$confirm,$time,$status,$nirvaki_nilai,$Rnetwork);
            
                                            $inserid = Coinwithdraw::createTransaction($uid,$currency,$fromaddress,$to_address,$amount,$fee,$debitamt,1,$network,$destination_tag,$mtype,"Internal Transfer $uid1");
            
                                            Wallet::creditAmount($uid1, $currency, $amount, 8,'deposit',$remark,$inserid);
            
                                        }else{
                                            $inserid = Coinwithdraw::createTransaction($uid,$currency,$fromaddress,$to_address,$amount,$fee,$debitamt,0,$network,$destination_tag,$mtype);
                                        }
                                    }  
                                    $remark = "User ".$currency." withdraw request";
                                    $wallet = Wallet::debitAmount($uid,$currency,$amount,$decimal,'withdraw',$remark,$inserid);
                                    return response()->json(['success'=>true ,"result"=>"" ,"message"=>"Withdraw Successfully"]);  

                                }else{
                                    return response()->json(['success'=>false ,"result"=>"","message"=>"Insufficient fund in your $currency Wallet !!!.You need ". display_format($amount,8)." " .$currency]);
                                }
                            }else{
                                return response()->json(['success'=>false ,"result"=>"","message"=>'Please enter valid '.$currency.' Address!']);
                            } 
                        }else {
                            return response()->json(['success'=>false ,"result"=>"","message"=>"Per day withdraw request amount  only ".display_format($perday_withdraw,8)."  ".$currency]); 
                        }
                    }else {
                        return response()->json(['success'=>false ,"result"=>"","message"=>"Withdraw amount must be greater than or equal to ".display_format($min_withdraw,8)."  ".$currency]); 
                    }  
                }else{
                    return response()->json(['success'=>false ,"result"=>"","message"=>"Minimum ".$currency." withdraw amount should be greater than or equal to ".$fee.""]);
                }
            }else{
                return response()->json(['success'=>false ,"result"=>"","message"=>"Invalid Coin/Currency given please check!"]);('withdraw/'.$currency)->with('fail', "Invalid Coin/Currency given please check!"); 
            }
        // }else{
        //     return response()->json(['success'=>false ,"result"=>"","message"=>"Only KYC verified Users canbe Withdraw!"]);
        // }
            
    }

    public function withdrawotp(Request $request){
        $validator = Validator::make($request->all(), [
            'coin' => 'required|required|alpha',
            'address' => 'required|alpha_dash',
            'amount'  =>'required|numeric|min:0',
            'network' =>'required|alpha|max:15',
        ]);
        $coin = $request->coin;
        $network = $request->network;
        if($coin == 'ETH' || $coin == 'BNB' || $coin == 'MATIC' || $network == 'token' || $network == 'erctoken'|| $network == 'bsctoken' || $network == 'polytoken')
        {
            $validator = Validator::make($request->all(), [
            'address' => 'required|regex:/^0x[a-fA-F0-9]{40}$/',
            ]); 
        }
        if ($validator->fails()) { 
        	return response()->json(["success" => false,"result" => NULL,'message'=> $validator->errors()->first()], 200);           
        }
        $user = Auth::user();
        $email =  $user->email;
        $uid = \Auth::id();    
        $coin = $request->coin;
        $coins = strtoupper($coin);
        $address =$request->address;
        $amount = $request->amount;
        
        $coinDeatils = Commission::where(['source' => $coins,'type' => $request->network])->first();
        if(!is_object($coinDeatils)){
            return response()->json(['success'=>false ,"result"=>"","message"=>"Invalid coin or network given please check!"]);
        }
        $min_withdraw   = $coinDeatils->min_withdraw;
        if($amount >= $min_withdraw AND $amount > 0){
            $balance        = Wallet::where(['uid' => $uid,'currency' => $coins])->value('balance');
            if($balance > 0 && $balance >= $amount){
                $checkbal = ncSub($balance,$amount);
                if($checkbal <= 0){
                    return response()->json(['success'=>false ,"result"=>"","message"=>"Insufficient fund!"]);
                }
                if($user->twofa == 'google_otp'){
                    return response()->json(['success'=>true,"result"=>"","message"=>"Please enter GoogleAuthenticator OTP!"]);
                }
                $otp  = rand(100000,999999);
                $profile_upload = User::where(['email' => $email])->update(['profile_otp' => $otp]);
                Mail::send('email.withdrawconfirm', ['otp'=>$otp,'coin' => $coins,'address' => $address,'amount' => $amount], function($message) use ($coins,$address,$amount) {
                    $message->subject("Make Confirm Your Withdraw Order");
                    $message->to(Auth::user()->email);
                });
                return response()->json(['success'=>true,"result"=>"","message"=>"Otp  Send to Your Email"]);
            }else {      
                return response()->json(['success'=>false ,"result"=>"","message"=>"Insufficient fund in your $coins Wallet !!!.You need ". display_format($amount,8)." " .$coins]);
            }
        }else {      
            return response()->json(['success'=>false ,"result"=>"","message"=>"Withdraw amount must be greater than or equal to ".display_format($min_withdraw,8)."  ".$coins]);
        }     
                   
    }

    function TransactionString($length = 64) {
        $str = substr(hash('sha256', mt_rand() . microtime()), 0, $length);
        return $str;
    }

    
}
