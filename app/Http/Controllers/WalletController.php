<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;
use App\User;
use App\Models\Wallet;
use App\Models\Commission;

use App\Models\Coinwithdraw;
use App\Models\CurrencyWithdraw;
use App\Models\Currencydeposit;
use App\Models\AdminBank;
use App\Models\Deposit;
use App\Models\Bankuser;
use Illuminate\Support\Facades\Redirect;
use App\Traits\GoogleAuthenticator;
use App\Models\CMS;
use App\Models\Cryptotransaction;
use App\Mail\SendOtpVerification;
use App\Models\Country;
use App\Models\Tradepair;

class WalletController extends Controller
{
    use GoogleAuthenticator;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','twofa','kyc']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user()->id;
        $userWallet = Wallet::where('uid', '=', $user)->get();
        $coins = Commission::where([['shown','=',1]])->orderBy('orderlist', 'asc')->get();
        $is_obj =Wallet::where(['uid'=>$user ,'currency'=>'USDT'])->first();
        if(is_object($is_obj)){
            $usdt =$is_obj->balance;
        }
        if($is_obj == NULL)
        {
            $usdt =0;
        }
        if($userWallet->count())
        {
            $othercurrencyconversion    = 0;
            $usdtbalance                = 0;
            foreach($userWallet as $balance)
            {
                $closeusdtamt =  $tradepair = Tradepair::where([
                    ['coinone', '=', $balance->currency],
                    ['cointwo', '=', 'USDT'],
                    ['active', '=', 1]
                ])->first();
                $currency[$balance->currency]['balance'] = sprintf("%.8f", $balance->balance);
                $currency[$balance->currency]['escrow'] = sprintf("%.8f", $balance->escrow_balance);
                if (isset($balance->balance) && isset($closeusdtamt['close']) && $balance->currency !='USDT') {

                    $othercurrencyconversion += $balance->balance*$closeusdtamt['close'];
                    $usdtconversion           = $balance->balance*$closeusdtamt['close'];
                    $currency[$balance->currency]['balanceinusdt'] = sprintf("%.8f", $usdtconversion);
                } elseif (isset($balance->balance) && $balance->currency =='USDT'){
                    $usdtbalance += $balance->balance*1;
                    $currency[$balance->currency]['balanceinusdt'] = sprintf("%.8f", $usdtbalance);
                }
            }
        }
        else
        {
            $othercurrencyconversion    = 0;
            $currency='';
        }
        $totalamount    =  sprintf("%.8f" ,$usdt+$othercurrencyconversion);
        return view('wallet', ['balance' => $currency,'coins' => $coins,'usdt'=>$totalamount]);
    }
    
    public function deposit($coin)
    {
        $coin = strtoupper($coin);
        $coins = Commission::where([['source','=',$coin],['shown','=',1]])->first();
        $tokenLists = Commission::where([['source','=',$coin],['type','!=','coin']])->get();
        $coinLists = Commission::select('source')->where([['shown','=',1],['is_deposit','=',1]])->groupBy('source')->orderBy('orderlist', 'asc')->get();
        $uid = Auth::user()->id;

        if(is_object($coins)){
            if($coins->is_deposit === 0){
                return redirect('wallet')->with('adminwalletbank','Currently disable deposit for '.$coin);
            }
            $type = $coins->type;
            $address = Wallet::where(['uid'=> $uid,'currency'=> $coin])->value('mukavari');
            $trxaddress = Wallet::where(['uid'=> $uid,'currency'=> 'TRX'])->value('mukavari');
            $ethaddress = Wallet::where(['uid'=> $uid,'currency'=> 'ETH'])->value('mukavari');
            if($type == 'trxtoken'){
                if($coins->source == 'NAS'){
                    $coinname = 'Tron (TRC10)';
                } else{
                    $coinname = 'Tron (TRC20)';
                }
                
            } else if($type == 'bsctoken'){
                $coinname = 'BSC (BEP20)';
            } else if($type == 'erctoken'){
                $coinname = 'Ethereum (ERC20)';
            } else if($type == 'polytoken'){
                $coinname = 'MATIC (Poly20)';
            } else if($type == 'token'){
                $coinname = 'Ethereum (ERC20)';
            }  else{
                $coinname = $coins->coinname;
            }          
            
            $symbol = $coins->source;
            $type = $coins->type;
            if(!$address){
                $address = '';
            }
            $payment_id = Wallet::where(['uid'=> $uid,'currency'=> $coin])->value('payment_id');
            if(!$payment_id)
            {
                $payment_id =""; 
            }

            return view('deposit', ['address' => $address,'coinLists' => $coinLists,'coinname' => $coinname,'coin' => $symbol,'type' => $type,'coindetails' => $coins,'payment_id' => $payment_id,'trxaddress' =>$trxaddress,'ethaddress' => $ethaddress,'tokenLists' => $tokenLists]);
        }else{
            return redirect('wallet')->with('adminwalletbank','Invalid Coin/Currency');
        }
    }
    public function fiatdeposit(Request $request)
    {
        $fiat_name = $request->fiat_name;
        $coins = Commission::where([['source','=',$fiat_name],['type','=','fiat']])->first();
        $country = Country::get();
        if($coins){
            $user = Auth::user()->id;
            $admin_account = AdminBank::where('coin' , $fiat_name)->first();
            if($admin_account && $admin_account->count() > 0)
            {
                $account = trim($admin_account->account," ");
                $account_details = str_replace(array("\r\n", "\r", "\n"), "<br />", $account); 
                $depositfee = $coins->deposit_fee;
                $admindepositfee = ncDiv($coins->deposit_fee,100,8);

                return view('userpanel.fiatdeposit', ['currency' => $fiat_name, 'admin_account' => $account_details,'country' => $country,'depositfee' => $depositfee,'admindepositfee' => $admindepositfee]);
            }else{
                return redirect('wallet')->with('error','Admin bank details not available!');
            }
        }else{
            return redirect('wallet')->with('error','Invalid Coin/Currency');
        }        
    }    

    public function uploadProof(Request $request)
    {
        $user = Auth::user()->id;
        $currency = $request->currency;
        $validator = $this->validate($request, [
                'amount' => 'required|numeric|max:10000000',
                'paymenttype' => 'required',
            ]);
        $amount = $request->amount; 
        $paymenttype = $request->paymenttype; 

        if($paymenttype == 'wirepayment')
        {
            $validator = $this->validate($request, [
                'proof' => 'required|mimes:jpeg,jpg,png|max:2000'
            ]);            

            $admin_account = AdminBank::where('id' , 1)->first();
            if($admin_account && $admin_account->count() > 0)
            {
                $account = trim($admin_account->account," ");
                $account_details = str_replace(array("\r\n", "\r", "\n"), "<br />", $account); 
            }        
            $min_deposit = Commission::where('source', $currency)->value('min_deposit');
            if(isset($min_deposit) && $min_deposit <= $amount)
            {
                if($amount > 0)
                {
                    if($this->imgvalidaion($_FILES['proof']['tmp_name']) == 1 )
                    {
                        $dir = 'proof/';
                        $path = 'storage' . DIRECTORY_SEPARATOR .'app'. DIRECTORY_SEPARATOR.'public'. DIRECTORY_SEPARATOR. $dir;

                        if(Input::hasFile('proof')){
                            $fornt = Input::File('proof');
                            $filenamewithextension = $fornt->getClientOriginalName();
                            $photnam = str_replace('.','',microtime(true));
                            $filename = pathinfo($photnam, PATHINFO_FILENAME);
                            $extension = $fornt->getClientOriginalExtension();
                            $photo = $filename.'.'. $extension;
                            $fornt->move($path, $photo);
                            $front_img = $path.$photo;
                        }

                        $deposit_request = new Deposit();
                        $deposit_request->uid = $user;
                        $deposit_request->txid = TransactionString();
                        $deposit_request->amount = $amount;
                        $deposit_request->credit_amount = $amount;
                        $deposit_request->proof = url($front_img);
                        $deposit_request->currency = $currency;
                        $deposit_request->type = 'wirepayment';
                        $deposit_request->status = 0;                


                        if($deposit_request->save())
                        {
                            \Session::flash('success', 'Proof Uploaded Successfully. Please wait for admin confirmation.');
                            return redirect('fiatdeposit/'.$currency)->with(['admin_account' => $account_details, 'currency' => $currency]);
                        }
                        else
                        {
                            \Session::flash('error', 'Proof Uploaded Failed. Try Again!');
                            return redirect('fiatdeposit/'.$currency)->with(['admin_account' => $account_details, 'currency' => $currency]);
                        }
                    }else{
                        \Session::flash('error', 'Proof Uploaded Failed. Try Again!');
                        return redirect('fiatdeposit/'.$currency)->with(['admin_account' => $account_details, 'currency' => $currency]);
                    }
                }
                else
                {
                    \Session::flash('error', 'Entered amount should be above zero.');
                    return redirect('fiatdeposit/'.$currency)->with(['admin_account' => $account_details, 'currency' => $currency]);
                }
            }else{
                \Session::flash('error', 'Your amount must be greater than or equal to the minimum deposit amount  '.$min_deposit .' '.$currency);
                return redirect('fiatdeposit/'.$currency)->with(['admin_account' => $account_details, 'currency' => $currency]);
            }
        }
    }

    public function withdraw($coin)
    {
        $coin = strtoupper($coin);
        $coins = Commission::where([['source','=',$coin],['shown','=',1]])->first();
        $coinLists = Commission::select('source')->where([['shown','=',1],['is_withdraw','=',1]])->groupBy('source')->orderBy('orderlist', 'asc')->get();
        $uid = Auth::user()->id;
        if(is_object($coins)){
            $tokenLists = Commission::where([['source','=',$coin],['type','!=','fiat']])->get();

            if($coins->is_deposit === 0){
                return redirect('wallet')->with('adminwalletbank','Currently disable withdraw for '.$coin);
            }
            $type = $coins->type;
            $address = Wallet::where(['uid'=> $uid,'currency'=> $coin])->value('mukavari');            
            $balance = Wallet::where(['uid'=> $uid,'currency'=> $coin])->value('balance');            
            $coinname = $coins->coinname;
            $symbol = $coins->source;
            $type = $coins->type;
            if(!$address){
                $address = '';
            }if(!$balance){
                $balance = 0;
            }
            $payment_id = Wallet::where(['uid'=> $uid,'currency'=> 'XRP'])->value('payment_id');

            if(!$payment_id)
            {
                $payment_id =""; 
            }

            return view('withdraw', ['address' => $address,'coinLists' => $coinLists,'coinname' => $coinname,'coin' => $symbol,'type' => $type,'coindetails' => $coins,'payment_id' => $payment_id,'balance' => $balance,'tokenLists' => $tokenLists]);
        }else{
            return redirect('wallet')->with('adminwalletbank','Invalid Coin/Currency');
        }
    }
    public function validatecryptoWithdraw(Request $request){
        $this->validate($request, [
            'coin'      => 'required|alpha_dash|max:15',
            'address'   => 'required|alpha_dash',
            'network'   => 'required|alpha_dash|max:10',
            'amount'    => 'required|numeric',
        ]);
        $uid = \Auth::id();        
        $currency = strtoupper($request->coin);
        $network = $request->network;
        $btcDeatils = Commission::where(['source' => $currency,'type' => $network])->first();
        if($btcDeatils){
            if($currency == 'BTC')
            {
                $this->validate($request, [
                'address' => 'required|regex:/^[13][a-km-zA-HJ-NP-Z1-9]{25,34}$/',
                ]); 
            }
            else if($currency == 'ETH' || $currency == 'BNB' || $currency == 'MATIC'|| $network == 'token' || $network == 'erctoken'|| $network == 'bsctoken' || $network == 'polytoken')
            {
                $this->validate($request, [
                'address' => 'required|regex:/^0x[a-fA-F0-9]{40}$/',
                ]); 
            }
            else if($currency == 'LTC')
            {
                $this->validate($request, [
                'address' => 'required|regex:/^[LM3][a-km-zA-HJ-NP-Z1-9]{26,33}$/',
                ]); 

            }
            else if($currency == 'XRP')
            {
                $this->validate($request, [
                'destination_tag' => 'required|numeric',
                ]); 

            }      
            $to_address = $request->address;  

            if($request->withdrawtype)
            {
              $withdrawtype = $request->withdrawtype;
            }else{
                $withdrawtype =  NULL;
            }
            $amount = abs($request->amount);
            if($btcDeatils->com_type == 'Fixed'){
               $fee         = $btcDeatils->withdraw; 
               $debitamt    = ncSub($amount, $fee,8);
            }else{
                $commission = ncDiv($btcDeatils->withdraw,100);
                $fee        = ncMul($amount,$commission,8);
                $debitamt   = ncSub($amount, $fee,8);
            }
            $balance        = 0;            
            $balance        = Wallet::where([['uid', '=', $uid],['currency',$currency]])->value('balance');
            $min_withdraw   = $btcDeatils->min_withdraw;
            $perday_withdraw = $btcDeatils->perday_withdraw;
            $type = $btcDeatils->type;
            if($type == 'fiat')
            {
                $TodaywithdrawAmount = CurrencyWithdraw::where(['uid' => $uid, 'type' => $currency])->whereIn('status',[0,1])->whereRaw('Date(created_at) = CURDATE()')->sum('amount');
            }
            else{
                $TodaywithdrawAmount = Coinwithdraw::where(['uid' => $uid, 'coin_name' => $currency])->whereIn('status',[0,1])->whereRaw('Date(created_at) = CURDATE()')->sum('amount');
            }

            $findminmumwithdrawamount = bcsub($perday_withdraw,$TodaywithdrawAmount,8);
                if($debitamt > $btcDeatils->netfee){
                    if($amount >= $min_withdraw AND $amount > 0){
                        if($findminmumwithdrawamount >= $amount){   
                            if($to_address!=""){
                                if($balance >= $amount){
                                    if($request->network == 'token' || $request->network == 'erctoken'){
                                        $network = "ERC20";
                                    }else if($request->network == 'bsctoken'){
                                        $network = "BEP20";
                                    }else if($request->network == 'trxtoken'){
                                        $network = "TRC20";
                                    }else if($request->network == 'polytoken'){
                                        $network = "MATIC ERC20";
                                    }else{
                                        $network = $request->network;
                                    }

                                    $data['toaddress'] =  $to_address;
                                    $data['amount']     =  $amount;
                                    $data['currency']   =  $currency;
                                    $data['desc']   =  $request->desc ? $request->desc : NULL;
                                    $data['network']   =  $request->network ? $request->network : NULL;
                                    $data['destination_tag']   =  $request->destination_tag ? $request->destination_tag : NULL;
                                    $data['fee']   =  $fee;
                                    $data['receive_amount']   =  $debitamt;
                                    $data['name']   =  Auth::user()->first_name.' '.Auth::user()->last_name ;
                                    $data['networkname']   =  $network;
                                    //$data['withdrawtype']   =  $withdrawtype;
                                    \Session::put('withdrawl', $data); 
                                    $user = Auth::user(); 

                                    $twofa_withdraw_enable= CMS::value('twofa_withdraw_enable');
                                    if($twofa_withdraw_enable == 1)
                                    {   
                                        if(Auth::user()->twofa == 'google_otp')
                                        {
                                            return Redirect('/withdrawconform')->with('success','Please enter GoogleAuthenticator OTP! for withdraw conform');
                                        }else{
                                            $user = Auth::user();
                                            $rand = rand(100000,999999);
                                            $security = User::where(['id' => $uid, 'email_verify' => 1])->first();
                                            $security->profile_otp = $rand;
                                            $security->save();

                                            \Session::flash('status', 'Check your email inbox/spam folder for verification code!.'); 

                                            \Mail::send('email.withdrawotp', ['data' => $data,'otp' => $rand], function($message) use ($user,$data) {                               
                                                $message->subject("Confirm Your Withdrawal Request for ".$data['amount'].' '.$data['currency']);
                                                $message->to($user->email);
                                            });
                                            return Redirect('/withdrawconform')->with('success','Please check your email  to confirm your withdrawal requested. Check Inbox/Spam folder for Activation Link'); 
                                        }                                           
                                        
                                    }
                                    else
                                    {
                                        \Mail::send('email.withdrawrequest', ['data' => $data], function($message) use ($user,$data) {                               
                                            $message->subject("Confirm Your Withdrawal Request for ".$data['amount'].' '.$data['currency']);
                                            $message->to($user->email);
                                        });
                                        //$this->without_2fa_withdrawstore();
                                        //return redirect('/withdrawhistory/'.$currency);
                                        $title = "Success";
                                        $msg = "Please check your email  to confirm your withdrawal requested. Check Inbox/Spam folder for Activation Link ";
                                        return view('message', ['title' => $title,'msg' => $msg]);
                                    }
                                }else{
                                    return redirect('withdraw/'.$currency)->with('fail', "Insufficient fund in your $currency Wallet !!!.You need ". display_format($amount,8)." " .$currency); 
                                }
                            }else{
                                return redirect('withdraw/'.$currency)->with('fail', 'Please enter valid '.$currency.' Address!'); 
                            } 
                        }else {
                            return redirect('withdraw/'.$currency)->with('fail', "Per day withdraw request amount  only ".display_format($perday_withdraw,8)."  ".$currency); 
                        }
                    }else {
                        return redirect('withdraw/'.$currency)->with('fail', "Withdraw amount must be greater than or equal to ".display_format($min_withdraw,8)."  ".$currency); 
                    }  
                }else{
                    return redirect('withdraw/'.$currency)->with('fail', "Minimum ".$currency." withdraw amount should be greater than or equal to ".$fee."");
                }
        }else{
            return redirect('withdraw/'.$currency)->with('fail', "Invalid Coin/Currency given please check!"); 
        }                 
        return Redirect::back(); 
    }
    public function withdraw_otp(){
        return view('withdrawotp');
    }

    public function approvewithdraw($email,$toaddress)
    {
        $email = \Crypt::decryptString($email);
        $user = User::where(['email' => $email])->first();
        if(is_object($user))
        {
            $ses  = \Session::get('withdrawl');
            if(!isset($ses)){
                return redirect('/wallet')->with('adminwalletbank','Approve withdraw URL expired!.Please try again.');
            }
            $to_address = $ses['toaddress'];
            $currency   = $ses['currency'];
            if($to_address == $toaddress){
                $this->without_2fa_withdrawstore();
                return  redirect('/withdraw-histroy')->with('success', "Withdraw successful!");
            }else {
               return redirect('/wallet')->with('adminwalletbank','Invalid Request! Please try again');
            }
           
        } else {
            return redirect('/wallet')->with('adminwalletbank','Invalid Url! Please try again');
        }

    }

    public function without_2fa_withdrawstore(){      
        $uid        = \Auth::id();
        $user       = User::where('id',$uid)->first();
        $ses        = \Session::get('withdrawl');
        $to_address = $ses['toaddress'];
        $currency   = $ses['currency'];
        $balance    = 0;
        $btcDeatils = Commission::where('source', $currency)->first();

        if($btcDeatils)
        {
            $type = $btcDeatils->type;

            if($type == 'fiat'){
                $url = 'withdraw-histroy/'.$currency;
            }else{
                $url = 'withdraw-histroy/';
            }
            $decimal    = $btcDeatils->point_value;
            $commission = bcdiv($btcDeatils->withdraw,100,8);
            $amount     = abs($ses['amount']);
            $fee        = display_format($btcDeatils->netfee,8);
            $admin_amount = bcmul($commission, $amount,8);
            $debitamt1  = bcadd($admin_amount, $fee,8);
            $debitamt   = bcsub($amount, $debitamt1,8);
            $balance    = Wallet::where([['uid', '=', $uid],['currency',$currency]])->value('balance');

            $liveprice  = 0;
            if($amount >= $fee AND $amount > 0){
                if($to_address!=""){
                    if($balance >= $amount){
                       $wallet = Wallet::where([['uid', '=', $uid],['currency',$currency]])->first();
                        if($type == 'fiat'){
                            $inserid = CurrencyWithdraw::createTransaction($uid,$currency,$ses['bankid'],$to_address,$amount,$debitamt1,$debitamt);
                        }else{
                            if($ses['network'] == 'token' || $ses['network'] == 'erctoken'){
                                $fromaddress    = Wallet::where(['currency' =>'ETH','uid' => \Auth::id()])->value('mukavari');
                                $network = "ERC20";
                            }else if($ses['network'] == 'bsctoken'){
                                $fromaddress    = Wallet::where(['currency' =>'ETH','uid' => \Auth::id()])->value('mukavari');
                                $network = "BEP20";
                            }else if($ses['network'] == 'trxtoken'){
                                $fromaddress    = Wallet::where(['currency' =>'TRX','uid' => \Auth::id()])->value('mukavari');
                                $network = "TRC20";
                            }else{
                                $fromaddress    = Wallet::where(['currency' =>$currency,'uid' => \Auth::id()])->value('mukavari');
                                $network = $ses['network'];
                            }
                            //Internal transaction for coin withdraw
                            $internal_trans = Wallet::where([['uid' ,'!=' , $uid],['mukavari' ,'=' , $to_address]])->first();
                            if(isset($internal_trans))
                            {
                                $uid1           = $internal_trans->uid;
                                $amount         = $ses['amount'];
                                $txid           = TransactionString().$uid1;
                                $confirm        = 1;
                                $time           = date("Y-m-d H:i:s");
                                $status         = 1;
                                $nirvaki_nilai  = 99;
                                
                                $remark = "User ".$currency." withdraw request";                               

                                Cryptotransaction::createTransaction($uid1,$currency,$txid,$fromaddress,$to_address,$amount,$confirm,$time,$status,$nirvaki_nilai);

                                $inserid = Coinwithdraw::createTransaction($uid,$currency,$fromaddress,$to_address,$amount,$debitamt1,$debitamt,1,$network,$ses['destination_tag'],'Web',"Internal Transfer $uid1");

                                Wallet::creditAmount($uid1, $currency, $amount, 8,'withdraw',$remark,$inserid);

                            }else{
                                $inserid = Coinwithdraw::createTransaction($uid,$currency,$fromaddress,$to_address,$amount,$debitamt1,$debitamt,0,$network,$ses['destination_tag'],'Web');
                            }
                        }                        
                        $remark = "User ".$currency." withdraw request";
                        $wallet = Wallet::debitAmount($uid,$currency,$amount,$decimal,'withdraw',$remark,$inserid);
                        session()->forget('withdrawl');
                    }else{
                        return redirect($url)->with('fail', "Insufficient fund in your $currency Wallet !!!.You need $amount $currency"); 
                    }
                }else{
                    return redirect($url)->with('fail', 'Please enter valid '.$currency.' Address!'); 
                } 
            } else {
                return redirect($url)->with('fail', "Withdraw amount must be greater than or equal to $fee  $currency"); 
            }
        }else{
            return redirect('/wallet')->with('adminwalletbank','Invalid OTP! Please try again');            
        }  
    }

    public function withdrawstore(Request $request){

        $niceNames = array(
            'otp' => 'OTP',
        );
        
        $this->validate($request, [
            'otp' => 'numeric|required'
        ],[],$niceNames);
        
        $uid = \Auth::id();
        $user = User::where('id',$uid)->first();
        if($user->twofa == 'google_otp'){
            $otp     = $request->otp;
            $secret  = $user->google2fa_secret;
            $oneCode = $this->getCode($secret);
            $data    = $this->verifyCode($secret, $otp, 2);
        }else{
            $profile_otp = $user->profile_otp;
            $otp = $request->otp;
            if($profile_otp == $otp){
                $data = true;
            }else{
                $data = false;
            }
        }
        if($data){
            $ses        = \Session::get('withdrawl');
            //dd($ses);
            $to_address = $ses['toaddress'];
            $currency   = $ses['currency'];
            $network   = $ses['network'];            
            $amount    = abs($ses['amount']);
           // $withdrawtype = $ses['withdrawtype'];
            $balance    = 0;
            $btcDeatils = Commission::where(['source' =>  $currency,'type' => $network])->first();

            if($btcDeatils)
            {
                $type = $btcDeatils->type;
                $decimal   = $btcDeatils->point_value;
                if($type == 'fiat'){
                        $url = 'fiatwithdraw/'.$currency;
                }else{
                    $url = 'withdraw/'.$currency;
                }
                if($btcDeatils->com_type == 'Fixed'){
                   $fee         = $btcDeatils->withdraw; 
                   $debitamt    = ncSub($amount, $fee,8);
                }else{
                    $commission = ncDiv($btcDeatils->withdraw,100);
                    $fee        = ncMul($amount,$commission,8);
                    $debitamt   = ncSub($amount, $fee,8);
                }                      
                
                $min_withdraw   = $btcDeatils->min_withdraw;
                $balance = Wallet::where([['uid', '=', $uid],['currency',$currency]])->value('balance');
                $mtype   ='Web';

                if($amount >= $min_withdraw AND $amount > 0){
                    if($to_address!=""){
                        if($balance >= $amount){
                            $wallet = Wallet::where([['uid', '=', $uid],['currency',$currency]])->first();
                            $remark = "User ".$currency." withdraw request";
                            
                            if($type == 'fiat'){
                                $insertid = CurrencyWithdraw::createTransaction($uid,$currency,$ses['bankid'],$to_address,$amount,$fee,$debitamt);
                               Wallet::debitAmount($uid,$currency,$amount,$decimal,'withdraw',$remark,$insertid);

                            }else{
                                if($ses['network'] == 'token' || $ses['network'] == 'erctoken'){
                                    $fromaddress    = Wallet::where(['currency' =>'ETH','uid' => \Auth::id()])->value('mukavari');
                                    $network = "ERC20";
                                }else if($ses['network'] == 'bsctoken'){
                                    $fromaddress    = Wallet::where(['currency' =>'ETH','uid' => \Auth::id()])->value('mukavari');
                                    $network = "BEP20";
                                }else if($ses['network'] == 'trxtoken'){
                                    $fromaddress    = Wallet::where(['currency' =>'TRX','uid' => \Auth::id()])->value('mukavari');
                                    $network = "TRC20";
                                }else{
                                    $fromaddress    = Wallet::where(['currency' => $currency,'uid' => \Auth::id()])->value('mukavari');
                                    $network = $ses['network'];
                                }
                                //Internal transaction for coin withdraw
                                if($ses['destination_tag'] !=""){
                                    $internal_trans = Wallet::where([['uid' ,'!=' , $uid],['mukavari' ,'=' , $to_address],['payment_id' ,'=' , $ses['destination_tag']]])->first();
                                }else{
                                    $internal_trans = Wallet::where([['uid' ,'!=' , $uid],['mukavari' ,'=' , $to_address]])->first();
                                }                                
                                if(isset($internal_trans))
                                {
                                    $uid1           = $internal_trans->uid;
                                    $amount         = $ses['amount'];
                                    $txid           = TransactionString().$uid1;
                                    $confirm        = 1;                                    
                                    $time           = date("Y-m-d H:i:s",time());
                                    $status         = 1;
                                    $nirvaki_nilai  = 99;

                                    Cryptotransaction::createTransaction($uid1,$currency,$txid,$fromaddress,$to_address,$amount,$confirm,$time,$status,$nirvaki_nilai,$ses['network']);

                                    $insertid = Coinwithdraw::createTransaction($uid,$currency,$fromaddress,$to_address,$amount,$fee,$debitamt,1,$network,$ses['destination_tag'],$mtype,"Internal Transfer $uid1");

                                    Wallet::debitAmount($uid,$currency,$amount,$decimal,'withdraw',$remark,$insertid);

                                    $remark1 = "User ".$currency." withdraw request";
                                    Wallet::creditAmount($uid1, $currency, $amount, 8,'withdraw',$remark,$insertid );

                                }else{
                                    $insertid = Coinwithdraw::createTransaction($uid,$currency,$fromaddress,$to_address,$amount,$fee,$debitamt,0,$network,$ses['destination_tag'],$mtype);
                                     Wallet::debitAmount($uid,$currency,$amount,$decimal,'withdraw',$remark,$insertid);
                                }   

                                                        
                            }
                            session()->forget('withdrawl');
                            return  redirect('/withdraw-histroy')->with('success', "Withdraw successful!");
                            
                        }else{
                            return redirect($url)->with('fail', "Insufficient fund in your $currency Wallet !!!.You need $amount $currency"); 
                        }
                    }else{
                        return redirect($url)->with('fail', 'Please enter valid '.$currency.' Address!'); 
                    } 
                } else {
                    return redirect($url)->with('fail', "Withdraw amount must be greater than or equal to ".display_format($min_withdraw,8)."  ".$currency); 
                }
            }else{

                return redirect('/wallet')->with('adminwalletbank','Invalid OTP! Please try again');            
            } 
        }else{
            return redirect('/withdrawconform')->with('faild','Invalid OTP!');            
        } 
    }


    function TransactionString($length = 64) {
        $str = substr(hash('sha256', mt_rand() . microtime()), 0, $length);
        return $str;
    }

    public function imgvalidaion($img)
    {
      $myfile = fopen($img, "r") or die("Unable to open file!");
      $value = fread($myfile,filesize($img));      
      if (! empty($value) && strpos($value, "<?php") !== false) {
        $img = 0;
      } 
      elseif (! empty($value) && strpos($value, "<?=") !== false){
        $img = 0;
      }
      elseif (! empty($value) && strpos($value, "eval") !== false) {
        $img = 0;
      }
      elseif (! empty($value) && strpos($value,"<script") !== false) {
        $img = 0;
      }else{
        $img=1;
      }

      fclose($myfile);

      return $img;
    }
}
