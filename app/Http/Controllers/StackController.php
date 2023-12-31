<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use Auth;
use Mail;
use Session;
use App\Libraries\BinanceClass;
use Validator;
use App\Models\Staking_information;
use App\Models\Staking_setting;
use App\Models\Staking_user_deposit;
use App\Models\Staking_terms;
use App\Models\Staking_interest;
use App\Models\Wallet;
use App\Models\Stacking_wallet;
use App\Models\Stacking_withdraw;
use App\User;
use App\Models\RewardHistory;
use App\Models\Tradepair;


class StackController extends Controller
{

    public function __construct()
    {
       $this->middleware(['auth','twofa']);
    }

    public function Termsall(Request $request)
    {
        $result = Staking_terms::first();
        return view('/userpanel.stack.terms',['terms' => $result]);

    }

    public function Index(Request $request)
    {

        $info = Staking_information::first();
        return view('/userpanel.stack.stack',['info'=>$info]);
    }



    public function Investment(Request $request)
    {
        $uid= \Auth::id();
       $Staking_user_deposit = Staking_user_deposit::where('uid',$uid)->orderBy('id', 'desc')->paginate(10);
        return view('/userpanel.stack.investmentstacking',['Staking_user_deposit' => $Staking_user_deposit]);
    }

    public function Reward(Request $request)
    {
       $uid= \Auth::id();
       $Staking_user_reward = Staking_interest::whereNotIn('status',[100])->where('uid',$uid)->orderBy('id', 'desc')->paginate(10);
        return view('/userpanel.stack.reward',['Staking_user_reward' => $Staking_user_reward]);
    }

  public function Submitstack(Request $request)
    {

        $this->validate($request, [
            'deposit_coin'   => 'required',
            'stackid'        => 'required',
            'no_of_coin'     => 'required|numeric',
            'duration_title' => 'required|in:weekly,monthly,quarterly,semiannually,annually,24months,48months',
        ]);

        $deposit_coin   = $request->deposit_coin;
        $no_of_coin     = $request->no_of_coin;
        
        $stackid        = \Crypt::decrypt($request->stackid);
        $uid            = \Auth::id();
        $Staking = Staking_setting::where('id',$stackid)->first();
        

        if(is_object($Staking))
        {
            $deposit_coin   = $Staking->deposit_coin;
            $min_amt        = $Staking->min_amt;
            $max_amt        = $Staking->max_amt;
            $duration_title = $Staking->duration_title;

            $enddate = date('d-m-Y', strtotime($Staking->enddate));
             time();
            $today = date('d-m-Y',time());
            $today = strtotime($today);
            $enddate = strtotime($enddate);

            if($enddate >= $today){
                if($duration_title == '24months')
                {
                    $expiry_date = strtotime("+2 years", $today);
                }else if($duration_title == '48months')
                {
                    $expiry_date = strtotime("+4 years", $today);
                }else
                {
                    return redirect('/stacking')->with('error', 'Something went wrong! try again!');
                }


                if($enddate >= $expiry_date)
                {
                    $expiry_date = date('Y-m-d', $expiry_date);
                    $Wallet_balance = Wallet::where(['uid' => $uid,'currency' =>$deposit_coin ])->value('balance');
                    if($Wallet_balance >= $no_of_coin)
                    {
                        if($min_amt <= $no_of_coin)
                        {
                           if($max_amt >= $no_of_coin){
                                $insert = new Staking_user_deposit();
                                $insert->txid = TransactionString();
                                $insert->uid = $uid;
                                $insert->stak_id = $Staking->id;
                                $insert->staking_title = $Staking->stacking_title;
                                $insert->deposit_coin = $deposit_coin;
                                $insert->actual_staking_amount = $no_of_coin;
                                $insert->no_of_coin = $no_of_coin;
                                $insert->duration_title = $duration_title;
                                $insert->expiry_date = $expiry_date;
                                $insert->annual_yield   = $Staking->reward_interest;
                                $insert->cancellation_fee =  $Staking->penalty_amount;
                                $insert->cancellation_type = $Staking->penalty_type;
                                $insert->status = 1;
                                $insert->save();

                                $remark = $deposit_coin. ' Staking deposit';
                                Wallet::debitAmount($uid, $deposit_coin,$no_of_coin,8,'Staking policy deposit by user',$insert->id);

                                return redirect('/stacking')->with('success', 'Submitted successfully!');

                            }else{
                                return redirect()->back()->with('error', 'Warning! Entered amount must be equal to or greater than the Minimum Locked Amount!');
                            }
                        }else{

                            return redirect()->back()->with('error', 'Warning! Entered amount must be equal to or lesser than the Maximum Locked Amount!');
                        }
                    }else{

                        return redirect()->back()->with('error', 'Insufficient fund in your '.$deposit_coin.' wallet !.you need minimum  amount of '.$no_of_coin.' in your '.$deposit_coin.' main wallet');
                    }
                }else{
                    return redirect()->back()->with('error', 'Please try some other duration because staking expired on '.date('d-m-Y',$enddate));
                }
            }else{
                return redirect()->back()->with('error', 'Staking already expired!');
            }
        }else{
            return redirect()->back()->with('error', 'Invalid Request given please try again later');
        }    

    }

   public function dateDiffInDays($date1, $date2)  
    { 
        // Calculating the difference in timestamps 
        $diff = strtotime($date2) - strtotime($date1); 
          
        // 1 day = 24 hours 
        // 24 * 60 * 60 = 86400 seconds 
        return abs(round($diff / 86400)); 
    }



     public function Stackterm($id)
    {
        $id = \Crypt::decrypt($id);
        $result = Staking_setting::where('id',$id)->first();
        return view('/userpanel.stack.oneterms',['result' => $result]);

    }


    public function Ajaxcancle(Request $request)
    {
        $uid= \Auth::id();
        $id = \Crypt::decrypt($request->investid);
        $deposit = Staking_user_deposit::where(['uid' => $uid,'id'=> $id])->first();

        $result = Staking_setting::where('id',$deposit->stak_id)->first();
        $penalty_type=$result->penalty_type;

        if(is_object($deposit))
        {
            $deposit_coin=$deposit->deposit_coin;
            $no_of_coin=$deposit->no_of_coin;
            $status=$deposit->status;
            $expiry_date = $deposit->expiry_date;
            $today =  time();          
            $expiry_date = strtotime($expiry_date);
            $status = 0;
            if($expiry_date <= $today)
            {
                $amount = $no_of_coin;
                $amt = 0;
                $status = 0;
            }
            else{
                $status = 1;
                if($penalty_type == 'fixed' || $penalty_type == 'Fixed')
                {
                    $penalty_amount=$result->penalty_amount;
                    $amt = $result->penalty_amount;
                    $amount=ncSub($no_of_coin,$penalty_amount,8);
                }
                else
                {
                    $penalty_amount = ncDiv($result->penalty_amount,100,8);            
                    $amt = ncMul($penalty_amount, $no_of_coin,8); 
                    $amount=ncSub($no_of_coin,$amt,8);
                }
            }
            $res = array();
            $res['penalty_coin'] = $deposit_coin;
            $res['amount'] = $amount;
            $res['penalty_amount'] = $amt;
            $res['status'] = $status;
            $res['cancellation_policy'] = $result->cancellation_policy;
            echo json_encode($res);
        }
    }
    public function Sterm($id)
    {
        $id = \Crypt::decrypt($id);
        $result = Staking_setting::where('id',$id)->first();
        return view('/userpanel.stack.stackterms',['result' => $result]);

    }

     public function Ajaxrenewal(Request $request)
    {
        $id = \Crypt::decrypt($request->renewid);
        $uid= \Auth::id();
        $result = Staking_user_deposit::where(['uid' => $uid,'id' => $id])->first();
        if(is_object($result))
        {
         echo json_encode($result);
        }
    }

      public function Submitcancelpolicy(Request $request,$investid= null)
        {
            $transid = \Crypt::decrypt($request->investid);
            $uid= \Auth::id();

            $deposit = Staking_user_deposit::where(['uid' =>$uid,'id'=> $transid ])->first();


            $result = Staking_setting::where('id',$deposit->stak_id)->first();
            $penalty_type=$result->penalty_type;

            if(is_object($deposit))
            {
                $deposit_coin=$deposit->deposit_coin;
                $no_of_coin=$deposit->no_of_coin;
                $status=$deposit->status;
                $expiry_date=$deposit->expiry_date;
                $today =  time();          
                $expiry_date =strtotime($expiry_date);

                if($status == 1 || $status == 4)
                {
                    if($expiry_date <= $today)
                    {
                        $amount = $no_of_coin;
                    }
                    else{
                            if($penalty_type == 'fixed' || $penalty_type == 'Fixed')
                            {
                                $penalty_amount=$result->penalty_amount;
                                $amount=ncSub($no_of_coin,$penalty_amount,8);
                            }
                            else
                            {
                                $penalty_amount = ncDiv($result->penalty_amount,100,8);            
                                $amt = ncMul($penalty_amount, $no_of_coin,8); 
                                $amount=ncSub($no_of_coin,$amt,8);
                            }
                    }
                    $deposit->status = 2;
                    $deposit->cancel_date  = date("Y-m-d H:i:s",time());
                    $deposit->save();

                    Stacking_wallet::creditAmount($uid,$deposit_coin,$amount,8,'Cancel stack','user cancelled staking deposit', $deposit->id);
                    
                    return redirect('/mycontract')->with('success', 'Cancelled successfully!');
                    
                }else{
                    return redirect('/mycontract')->with('error', 'Staking might already cancelled!');
                } 
            }
            else
            {
                return redirect('/mycontract')->with('error', 'Invalid Request given please try again later');
            }

        }
     public function SubmitRenewal(Request $request)
    {
        $renewid = \Crypt::decrypt($request->renewid);
        $uid= \Auth::id();

        
        $deposit = Staking_user_deposit::where(['uid' => $uid,'id'=>$renewid])->first();

        if(is_object($deposit))
        {
            $duration_title = $deposit->duration_title;
            $stak_id = $deposit->stak_id;

            $set = Staking_setting::where('id',$stak_id)->value('enddate');
            $enddate = date('d-m-Y', strtotime($set));
            $today = date("d-m-Y");


                 if($duration_title == 'weekly')
                    {
                      $expiry_date =date('Y-m-d', strtotime('+1 week', strtotime($today)));
                    }
                    else if($duration_title == 'monthly')
                    {
                        $time = strtotime($today);
                        $expiry_date = date("Y-m-d", strtotime("+1 month", $time));
                    }
                    else if($duration_title == 'quarterly')
                    {
                       $expiry_date = date('Y-m-d', strtotime("+3 months", strtotime($today)));
                    }
                    else if($duration_title == 'semiannually')
                    {
                       $expiry_date = date('Y-m-d', strtotime("+6 months", strtotime($today)));
                    }

                    else if($duration_title == 'annually')
                    {
                        $date = strtotime($today);
                        $new_date = strtotime('+ 1 year', $date);
                        $expiry_date =date('Y-m-d', $new_date);
                    }


            if($enddate >=$today  && $enddate >= $expiry_date)
            {
                    
                $update = Staking_user_deposit::where(['id' => $renewid,'uid'=>$uid])->update(['status' => 1,'expiry_date' => $expiry_date]);

                return redirect('/mycontract')->with('success', 'Submitted successfully!');
            }
            else
            {
                return redirect('/mycontract')->with('error', 'Staking already expired!');

            }
        }
        else
        {
            return redirect('/mycontract')->with('error', 'Invalid Request given please try again later');

        }

    }



    public function Stackwithdraw(Request $request)
    {
       $uid= \Auth::id();
       $withdraw = Stacking_wallet::where('uid',$uid)->orderBy('id', 'desc')->paginate(10);
        return view('/userpanel.stack.wallet',['withdraw' => $withdraw]);
    }


    public function Ajaxstack_withdraw(Request $request)
    {
        $id = \Crypt::decrypt($request->withdrawid);
        $uid= \Auth::id();
        $result = Stacking_wallet::where(['uid' => $uid,'id' => $id])->first();
        if(is_object($result))
        {
            echo json_encode($result);
        }
    }
    public function Sumbit_Stackingwithdraw(Request $request)
    {
        $this->validate($request, [
            'stack_withdraw_amount'      => 'required|numeric',
            'withdrawid' => 'required',
        ]);
        $stack_withdraw_amount =$request->stack_withdraw_amount;

        if($stack_withdraw_amount !='' && $stack_withdraw_amount > 0)
        {
            $id = \Crypt::decrypt($request->withdrawid);
            $uid= \Auth::id();
            $result = Stacking_wallet::where(['uid' => $uid,'id' => $id])->first();
            
            if(is_object($result))
            {

                $balance = $result->balance;

                if($balance >= $stack_withdraw_amount)
                {
                    $coin = $result->currency;        
                    $status= 0;
                    //stacking wallet
                    $debit = Stacking_wallet::where(['uid' => $uid,'id' => $id,'currency' =>$coin ])->first();
                    if(isset($debit))
                    {
                        $total = ncSub($debit->balance, $stack_withdraw_amount, 8);
                        $debit->balance = $total;
                        $debit->updated_at = date('Y-m-d H:i:s',time());
                        $debit->save();

                        //normal wallet
                      //  $id = $result->id;
                       // $remark = 'Staking withdraw amount to wallet';
                       // Wallet::creditAmount($uid,$coin,$stack_withdraw_amount,8,'stakingwithdraw',$remark, $id);
                        $status= 0;
                    }
                    //stacking withdraw

                    $withdraw = new Stacking_withdraw();
                    $withdraw->uid = $uid;
                    $withdraw->stack_id = $result->stacking_id;
                    $withdraw->coin = $coin;
                    $withdraw->amount = $stack_withdraw_amount;
                    $withdraw->status = $status;
                    $withdraw->save();

                    return redirect('/stackwallet')->with('success', 'Withdraw placed successfully!');
                }
                else
                {
                    return redirect('/stackwallet')->with('error', 'Insufficient fund in your staking wallet! ');

                }
            }
            else
            {
               return redirect('/stackwallet')->with('error', 'Invalid Request given please try again later');
            }
        }
        else
        {
           return redirect('/stackwallet')->with('error', 'Must amount enter above 0!');

        }
    }

    public function Withdrawtrans()
    {
       $uid= \Auth::id();
       $withdraw = Stacking_withdraw::where('uid',$uid)->orderBy('id', 'desc')->paginate(10);
        return view('/userpanel.stack.withdraw',['withdraw' => $withdraw]);
    }


    public function stakingproduct()
    {
        //$mystack = Staking_user_deposit::where('uid', \Auth::id())->pluck('stak_id')->toArray();

       /* $list = Staking_setting::where('contract_visual',1)
        ->orWhere(function ($query) use ($mystack) { $query->whereIn('id',$mystack);})->get();
        */


        $list = Staking_setting::where('contract_visual',1)->get();
        $uid= \Auth::id();
        $stake_wallet = Staking_interest::where(['uid'=>$uid,'coin' =>'USDT'])->sum('interest_amt');
        $lastmonthprofit = Staking_interest::where('created_at', '>=', DB::raw('DATE_SUB(NOW(), INTERVAL 30 DAY)'))
    ->sum('interest_amt');
    $stakes = Staking_user_deposit::where('uid',$uid)->with('rewards')->with('withdraw')->get();
    $wallet = Stacking_wallet::where('uid',$uid)->where('currency','SET')->value('balance');

    $pair = Tradepair::where('coinone','SET')->where('cointwo','USDT')->value('close');
    $estimated_amt_usdt = ncMul($wallet,$pair,8);
    
    return view('staking.stacking',['list' => $list,'stake_wallet' =>$stake_wallet,'lastmonthprofit'=> $lastmonthprofit,"stake"=>$stakes,"wallet"=>$wallet,"estimated_amt_usdt" => $estimated_amt_usdt,'liveprice' => $pair]);
       // return view('/userpanel.stack.stakingproduct',['list' => $list]);
        
    }

    public function Ajaxdeposit(Request $request)
    {
        $uid= \Auth::id();
        $id = \Crypt::decrypt($request->stak_id);
        $result = Staking_setting::where('id',$id)->first();
        $res = array();
        $res['staking_information'] = $result->staking_information;
        echo json_encode($res);
    }
    public function StackdepositSubmit($sid)
    {
        $id = \Crypt::decrypt($sid);
        $staking = Staking_setting::where('id',$id)->first();
        $deposit_coin =  $staking->deposit_coin;
        $balance =  0;

        $wallet = Wallet::where(['uid' => \Auth::id(),'currency' => $deposit_coin])->first();

        if(isset($wallet))
        {
            $balance =  $wallet->balance;
        }

        return view('/userpanel.stack.stakingdepositform',['staking' => $staking ,'balance' => $balance]);
    }

    public function stakingdepositform()
    {
        return view('/userpanel.stack.stakingdepositform');
    }

    public function stacksubscribepage($id)
    {
        $id = \Crypt::decrypt($id);
        $result = Staking_setting::where('id',$id)->first();
        $uid =Auth::id();
        $Wallet_balance = Wallet::where(['uid' => $uid,'currency' =>'USDT' ])->value('balance');
        return view('staking.cryptosavings',['result' => $result,"usdt_bal"=>$Wallet_balance]);

    }

    public function stacksubmit(Request $request)
    {

        $this->validate($request, [
            'deposit_coin'   => 'required',
            'stackid'        => 'required',
            'no_of_coin'     => 'required|numeric',
            'duration_title' => 'required|in:daily,weekly,monthly,quarterly,semiannually,annually,730days,1460days',
        ]);

        $deposit_coin   = $request->deposit_coin;
        $no_of_coin     = $request->no_of_coin;
        
        $stackid        = $request->stackid;
        $uid            = \Auth::id();
        $Staking = Staking_setting::where('id',$stackid)->first();
        $amount         = 0;
        $total_estimated_reward = 0;
        $reward_interest = $Staking->reward_interest;      
        $staking_amount  = $request->no_of_coin;
        $live_price      = Tradepair::where('coinone','SET')->where('cointwo','USDT')->value('close');
        $amountset       = ncDiv($no_of_coin,$live_price,8);
        $stake_usdt      = $amountset;        

        if(is_object($Staking))
        {
            $deposit_coin        = $Staking->deposit_coin;
            $min_amt             = $Staking->min_amt;
            $max_amt             = $Staking->max_amt;
            $duration_title      = $Staking->duration_title;
            $rewards_credit_type = $Staking->rewards_credit_type;

            $enddate = date('d-m-Y', strtotime($Staking->enddate));
            $today = date('d-m-Y',time());
            $today = strtotime($today);
            $enddate = strtotime($enddate);


            if($enddate >= $today){

                if($duration_title == '730days')
                {
                    $expiry_date = strtotime("+730 day", $today);

                    $percentage = ncdiv($reward_interest,100,8); 
                    $amount     = ncMul($percentage,$staking_amount,8); 
                    $total_estimated_reward = ncMul($amount,730,8);

                }else if($duration_title == '1460days')
                {
                    $expiry_date = strtotime("+1460 day", $today);

                    $percentage = ncdiv($reward_interest,100,8); 
                    $amount     = ncMul($percentage,$staking_amount,8); 
                    $total_estimated_reward = ncMul($amount,1460,8);

                }else
                {
                    return redirect('/staking')->with('error', 'Something went wrong! try again!');
                }


                if($rewards_credit_type == 'daily')
                {
                   $next_reward = strtotime('+1 day', $today);
                //    $next_reward = $today;
                }
                else if($rewards_credit_type == 'weekly')
                {
                    $next_reward = strtotime('+1 week', $today);
                }else if($rewards_credit_type == 'monthly')
                {
                    $next_reward = strtotime("+1 month", $today);
                }else if($rewards_credit_type == 'quarterly')
                {
                    $next_reward  = strtotime("+3 month", $today);
                }else if($rewards_credit_type == 'semiannually')
                {
                    $next_reward  = strtotime("+6 month", $today);
                }else if($rewards_credit_type == 'annually')
                {
                    $next_reward = strtotime("+12 month", $today);
                }


            if($enddate >= $expiry_date)
            {
                $expiry_date = date('Y-m-d', $expiry_date);
                $next_reward = date('Y-m-d', $next_reward);
                $Wallet_balance = Wallet::where(['uid' => $uid,'currency' =>$deposit_coin ])->value('balance');
                if($Wallet_balance >= $no_of_coin)
                {
                        //echo $no_of_coin;exit();
                    if($min_amt <= $no_of_coin)
                    {
                     if($max_amt >= $no_of_coin){
						 $total_set_estimate = ncDiv($total_estimated_reward,$live_price,4);
						 
                        $insert = new Staking_user_deposit();
                        $insert->txid = TransactionString();
                        $insert->uid = $uid;
                        $insert->stak_id = $Staking->id;
                        $insert->staking_title = $Staking->stacking_title;
                        $insert->deposit_coin = $deposit_coin;
                        $insert->actual_staking_amount = $no_of_coin;
                        $insert->no_of_coin = $no_of_coin;
                        $insert->duration_title = $duration_title;
                        $insert->expiry_date = $expiry_date;
                        $insert->annual_yield   = $Staking->reward_interest;
                        $insert->cancellation_fee =  $Staking->penalty_amount;
                        $insert->cancellation_type = $Staking->penalty_type;
                        $insert->next_reward   = $next_reward;
                        $insert->total_estimated_reward   = $total_estimated_reward;
						$insert->total_set_estimate   = $total_set_estimate;
                        $insert->live_price   = $live_price;
                        $insert->stake_usdt   = $stake_usdt;
                        $insert->status = 1;
                        $insert->save();

                        $remark = $deposit_coin. ' Staking deposit';
                        Wallet::debitAmount($uid,$deposit_coin,$no_of_coin,8,'staking','Staking policy deposit by user',$insert->id);
                        $user   = User::find($uid);
                        if ($user->parent_id !='') {
                            self::directreferal($uid,$amountset,$Staking->direct_interest,$Staking->reward_token,$Staking->id,$insert->id);
                        }
                        return redirect('/staking')->with('success', 'Stake Submitted Successfully!');

                    }else{
                        return redirect()->back()->with('error', 'Warning! Entered amount must be equal to or lesser than the Maximum Locked Amount!');
                    }
                }else{

                    return redirect()->back()->with('error', 'Warning! Entered amount must be equal to or greater than the Minimum Locked Amount!');
                }
            }else{

                return redirect()->back()->with('error', 'Insufficient fund in your '.$deposit_coin.' wallet !.you need minimum  amount of '.$no_of_coin.' in your '.$deposit_coin.' main wallet');
            }
        }else{
            return redirect()->back()->with('error', 'Please try some other duration because staking expired on '.date('d-m-Y',$enddate));
        }
    }else{
        return redirect()->back()->with('error', 'Staking already expired!');
    }
}else{
    return redirect()->back()->with('error', 'Invalid Request given please try again later');
}    

}

public function stake_history() {

    $uid= \Auth::id();
    $interest   = Staking_interest::where('uid',$uid)->get();
    $stake_wallet = Staking_interest::where(['uid'=>$uid,'coin' =>'USDT'])->sum('interest_amt');
    $lastmonthprofit = Staking_interest::where('created_at', '>=', DB::raw('DATE_SUB(NOW(), INTERVAL 30 DAY)'))
    ->sum('interest_amt');
    return view('staking.staking-history',["interest" => $interest,'stake_wallet' =>$stake_wallet,'lastmonthprofit'=> $lastmonthprofit]); 
}


public function stake_account() {

    $uid= \Auth::id();
    $account   = Staking_user_deposit::where('uid',$uid)->get();
    $stake_wallet = Staking_interest::where(['uid'=>$uid,'coin' =>'USDT'])->sum('interest_amt');
    $lastmonthprofit = Staking_interest::where('created_at', '>=', DB::raw('DATE_SUB(NOW(), INTERVAL 30 DAY)'))
    ->sum('interest_amt');
    return view('staking.staking-account',["account" => $account,'stake_wallet' =>$stake_wallet,'lastmonthprofit'=> $lastmonthprofit]); 
}

public static function creditStacking($uid,$coin,$amount){
    $checkwallet = Stacking_wallet::where(['uid' => $uid,'currency' => $coin])->first();
    if(!is_object($checkwallet))
    {
        $wallet = new Stacking_wallet();
        $wallet->uid  = $uid;
        $wallet->currency  = $coin;
        $wallet->balance  = $amount;
        $wallet->direct_income  = $amount;
        $wallet->save();
    }
    else{
        $oldbalance = $checkwallet->balance;
        $olddirect  = $checkwallet->direct_income;
        $total = ncAdd($oldbalance, $amount, 8);
        $direct_amt = ncAdd($olddirect,$amount,8);
        $checkwallet->balance = $total;
        $checkwallet->updated_at = date('Y-m-d H:i:s',time());
        $checkwallet->save();
    }
}

public static function directreferal($uid,$amount,$percentage,$coin,$stak_id,$deposit_id=null) {
    $user = User::find($uid);
    $reward_user  = User::where('referral_id',$user->parent_id)->first();
    $reward_user_sake =  Staking_user_deposit::where('uid',$reward_user->id)->get();
    if (is_object($reward_user) && count($reward_user_sake)>0) {
        $percentage = ncDiv($percentage,100,8); 
        $amount     = ncMul($percentage,$amount,8);    

        self::creditStacking($reward_user->id,$coin,$amount);
        $reward_history = new RewardHistory;
        $reward_history->uid = $reward_user->id;
        $reward_history->coin = $coin;
        $reward_history->type = 'direct_income';
        $reward_history->amount = $amount;
        $reward_history->stake_id = $stak_id;
        $reward_history->deposit_id = $deposit_id;
        $reward_history->stake_user_id = $user->id;
        $reward_history->stake_user_name = $user->first_name.'.'.$user->last_name;
        $reward_history->stake_user_email = $user->email;
        $reward_history->save();
        return true;       

    }
    return false;
}

public function stakedailyreward() {


    $today   = date('Y-m-d');
    $users   = Staking_user_deposit::where('status',1)->where('next_reward',$today)->get();

    if (isset($users) && count($users)>0 ){

        foreach ($users as $user ) {
            $setting                = Staking_setting::where('id',$user->stak_id)->first();
            $reward_type            = $setting->reward_type;
            $reward_interest        = $setting->reward_interest;
            $reward_coin            = $setting->reward_token;
            $duration_title         = $user->duration_title;
            $rewards_credit_type    = $setting->rewards_credit_type;
            $depositamt             = $user->no_of_coin;
            $enddate                = strtotime($setting->enddate);
            $expiry_time            = self::renewDate($duration_title);
            $next_reward            = self::renewDate($rewards_credit_type);
            $staking_amount         = $user->actual_staking_amount;
           
            if($enddate > $expiry_time){
                $expiry_date = date('Y-m-d', $next_reward);
               $update = Staking_user_deposit::where(['id' => $user->id,'uid' =>$user->uid])->update(['last_reward' => $today ,'next_reward' => $expiry_date ,'status' => 1,'updated_at' => date('Y-m-d H:i:s',time())]);
            }else{
                //echo "dd1";exit;
               $update = Staking_user_deposit::where(['id' => $user->id,'uid' =>$user->uid])->update(['last_reward' => $today ,'next_reward' => null ,'expiry_date' => null,'status' => 4,'updated_at' => date('Y-m-d H:i:s',time())]);
            }

            // if($rewards_credit_type == 'daily'){
            //     $period = 365;
            // }elseif($rewards_credit_type == 'weekly'){
            //     $period = 52;
            // }elseif($rewards_credit_type == 'monthly'){
            //     $period = 12;
            // }elseif($rewards_credit_type == 'quarterly'){
            //     $period = 4;
            // }elseif($rewards_credit_type == 'semiannually'){
            //     $period = 2;
            // }elseif($rewards_credit_type == 'annually'){
            //     $period = 1;
            // }else{
            //     $period = 1;
            // }
           
              if($reward_type == 'percentage')
                {
                    /**Percentage calculation 
                        (Rate/Period)*Amount
                        period(weekly,monthly,semiannually,quarterly,annually)
                    **/
                        
                    $percentage = ncdiv($reward_interest,100,8); 
                    $amount     = ncMul($percentage,$staking_amount,8);                   
                    
                }elseif($reward_type == 'fixed'){
                    /**Fixed calculation 
                        (Reward/Period)
                        period(weekly,monthly,semiannually,quarterly,annually)
                    **/
                    $Reward = $reward_interest;
                    $amount = ncDiv($Reward,$period,8);
                }else{
                     $amount = 0;
                }

                if($amount > 0){
                    $insert = new Staking_interest();
                    $insert->uid  = $user->uid;
                    $insert->stak_id  = $user->stak_id;
                    $insert->txid  = TransactionString();
                    $insert->coin  = $reward_coin;
                    $insert->interest_type  = $reward_type;
                    $insert->interest_amt  = $reward_interest;
                    $insert->duration_title  = $duration_title;
                   // $insert->period  = $period;
                    $insert->period  = 0;
                    $insert->amount  = $amount;
                    $insert->status  = 1;
                    $insert->save();
                    
                    /** Auto credit Stacking_wallet **/
                    self::creditStacking($user->uid,$reward_coin,$amount);
                    
                }
        }
    }

    $products = Staking_setting::whereDate('enddate', '=', $today)->get();
    if(count($products) > 0){
        foreach($products as $product){
            $stackusers = Staking_user_deposit::where(['stak_id' => $product->id])->whereIn('status', array(1, 4))->get();
            if(count($stackusers) > 0){
                foreach($stackusers as $stackuser){
                    $uid = $stackuser->uid;
                    $deposit_coin = $stackuser->deposit_coin;
                    $no_of_coin = $stackuser->no_of_coin;
                    $update = Staking_user_deposit::where(['id' => $stackuser->id,'uid' => $uid])->update(['status' => 5,'cancel_date'=> date("Y-m-d",time()),'updated_at' => date('Y-m-d H:i:s',time())]);
                    /** Auto credit Stacking_wallet **/
                    self::creditStacking($uid,$deposit_coin,$no_of_coin);
                }
            }
        }
    }

}

public static function renewDate($duration_title){
    $today = date('d-m-Y',time());
    $today = strtotime($today);

    if($duration_title == 'daily')
    {
        $expiry_date = strtotime('+1 day', $today);
    }else if($duration_title == 'weekly')
    {
        $expiry_date = strtotime('+1 week', $today);
    }else if($duration_title == 'monthly')
    {
        $expiry_date = strtotime("+1 month", $today);
    }else if($duration_title == 'quarterly')
    {
        $expiry_date  = strtotime("+3 month", $today);
    }else if($duration_title == 'semiannually')
    {
        $expiry_date  = strtotime("+6 month", $today);
    }else if($duration_title == 'annually')
    {
        $expiry_date = strtotime("+12 month", $today);
    }else if($duration_title == '730days')
    {
        $expiry_date = strtotime("+730 day", $today);
    }else if($duration_title == '1460days')
    {
        $expiry_date = strtotime("+1460 day", $today);
    }
    return $expiry_date;
}

public function earnings(){

    $interest_data    = Staking_interest::where('uid',\Auth::user()->id)->orderBy('id', 'desc')->paginate(20);
    $interest_amount  = Staking_interest::where('uid',\Auth::user()->id)->sum('amount_set');

    $direct_amount    = RewardHistory::where('uid',\Auth::user()->id)->where('type','direct_income')->sum('amount');
    $stake_amount     = RewardHistory::where('uid',\Auth::user()->id)->where('type','stake_income')->sum('amount');
    $level_amount     = RewardHistory::where('uid',\Auth::user()->id)->where('type','level_income')->sum('amount');
    $rank1_amount     = RewardHistory::where('uid',\Auth::user()->id)->where('type','rank_1')->sum('amount');
    $rank2_amount     = RewardHistory::where('uid',\Auth::user()->id)->where('type','rank_2')->sum('amount');
    $rank3_amount     = RewardHistory::where('uid',\Auth::user()->id)->where('type','rank_3')->sum('amount');
    $rank4_amount     = RewardHistory::where('uid',\Auth::user()->id)->where('type','rank_4')->sum('amount');
    $reward_amount    = RewardHistory::where('uid',\Auth::user()->id)->where('type','reward_income')->sum('amount');
    $cto_amount       = RewardHistory::where('uid',\Auth::user()->id)->where('type','cto')->sum('amount');

    $total_amount     = $interest_amount+$direct_amount+$level_amount+$rank1_amount+$rank2_amount+$rank3_amount+$rank4_amount+$cto_amount;

    $reward_amount    = Stacking_wallet::where('uid',\Auth::user()->id)->where('currency','SET')->sum('balance');

    $withdraw_amount  = Stacking_withdraw::where('uid',\Auth::user()->id)->where('coin','SET')->sum('amount');
    $withdraw_data    = Stacking_withdraw::where('uid',\Auth::user()->id)->where('coin','SET')->paginate(20);

    return view('earning',["interest_data" => $interest_data,"interest_amount"=>$interest_amount,"direct_amount"=>$direct_amount,"stake_amount"=>$stake_amount,"level_amount"=>$level_amount,"rank1_amount"=>$rank1_amount,"rank2_amount"=>$rank2_amount,"rank3_amount"=>$rank3_amount,"rank4_amount"=>$rank4_amount,"reward_amount"=>$reward_amount,"type"=>"total_income","total_amount"=>$total_amount,"cto_amount" => $cto_amount,"withdraw_amount" => $withdraw_amount,"withdraw_data" => $withdraw_data]);

}


public function earninghistory($type){

    $interest_data    = Staking_interest::where('uid',\Auth::user()->id)->orderBy('id', 'desc')->paginate(20);
    $interest_amount  = Staking_interest::where('uid',\Auth::user()->id)->sum('amount_set');

    $direct_amount    = RewardHistory::where('uid',\Auth::user()->id)->where('type','direct_income')->sum('amount');
    $stake_amount     = RewardHistory::where('uid',\Auth::user()->id)->where('type','stake_income')->sum('amount');
    $level_amount     = RewardHistory::where('uid',\Auth::user()->id)->where('type','level_income')->sum('amount');
    $rank1_amount     = RewardHistory::where('uid',\Auth::user()->id)->where('type','rank_1')->sum('amount');
    $rank2_amount     = RewardHistory::where('uid',\Auth::user()->id)->where('type','rank_2')->sum('amount');
    $rank3_amount     = RewardHistory::where('uid',\Auth::user()->id)->where('type','rank_3')->sum('amount');
    $rank4_amount     = RewardHistory::where('uid',\Auth::user()->id)->where('type','rank_4')->sum('amount');
    $cto_amount       = RewardHistory::where('uid',\Auth::user()->id)->where('type','cto')->sum('amount');

    $reward_amount    = Stacking_wallet::where('uid',\Auth::user()->id)->where('currency','SET')->sum('balance');
    $reward_history   = RewardHistory::where('uid',\Auth::user()->id)->where('type',$type)->orderBy('id', 'desc')->paginate(20);

    $total_amount     = $interest_amount+$direct_amount+$level_amount+$rank1_amount+$rank2_amount+$rank3_amount+$rank4_amount+$cto_amount;
    $withdraw_amount  = Stacking_withdraw::where('uid',\Auth::user()->id)->where('coin','SET')->sum('amount');
    $withdraw_data    = Stacking_withdraw::where('uid',\Auth::user()->id)->where('coin','SET')->paginate(20);
    return view('earning',["interest_data" => $interest_data,"interest_amount"=>$interest_amount,"direct_amount"=>$direct_amount,"stake_amount"=>$stake_amount,"level_amount"=>$level_amount,"rank1_amount"=>$rank1_amount,"rank2_amount"=>$rank2_amount,"rank3_amount"=>$rank3_amount,"rank4_amount"=>$rank4_amount,"reward_amount"=>$reward_amount,"type"=>$type,"reward_history"=>$reward_history,"total_amount"=>$total_amount,"cto_amount" => $cto_amount,"withdraw_amount" => $withdraw_amount,"withdraw_data" => $withdraw_data]);


}

public function CancelStack($id) {

    $id      = Crypt::decrypt($id);

    $stake   = Staking_user_deposit::where('id',$id)->where('status',1)->first();

    if($stake){

        $deposit_coin = $stake->deposit_coin;
        $reward_coin  = $stake->stakingsetting->reward_token;
        $uid          = $stake->uid;

        $amount       = $stake->rewards->where('deposit_id',$stake->id)->sum('amount');
        $created_date = new \DateTime($stake->created_at->format('Y-m-d'));
        $today        = new \DateTime(date("Y-m-d"));

        $interval     = $created_date->diff($today);
        $daysDiff     = $interval->days;

        if ($daysDiff >365 ) {
            $credit_amount = $amount;
        } elseif($daysDiff >180) {
            $percentage = ncDiv(50,100,8);
            $credit_amount     = ncMul($percentage,$amount);
        } elseif($daysDiff >90) {
            $percentage = ncDiv(25,100,8);
            $credit_amount     = ncMul($percentage,$amount);
        } elseif($daysDiff >25) {
            $percentage = ncDiv(10,100,8);
            $credit_amount     = ncMul($percentage,$amount);
        } else{
            $credit_amount = 0;
        }

        $debit = Stacking_wallet::where('uid',$uid)->where('currency',$reward_coin)->first();



        if(isset($debit))
        {
            $oldbalance          = $debit->balance;
            $total               = ncSub($debit->balance,$amount, 8);
            $debit->balance      = $total;
            $debit->main_balance = $debit->main_balance + $credit_amount;
            $debit->updated_at   = date('Y-m-d H:i:s',time());
            $debit->save();
        }

        $stake->status       = 2;
        $stake->cancel_date  = date("Y-m-d H:i:s",time());
        $stake->save();

    return redirect('staking')->with('success', 'Stacking cancelled successfully!');

}else{
    return redirect()->back()->withErrors('cancelerror', 'Already cancelled!');
}
}

public function stakewithdraw(Request $request) {

    $uid = \Auth::id();
    $debit = Stacking_wallet::where(['uid' => $uid,'currency' =>"SET" ])->first();
    $amount = $request->amount;

    $rules['amount'] ='required|numeric';

    $validator = Validator::make($request->all(),$rules);

    if ($validator->passes()) {

        if(is_object($debit))
        {
            DB::beginTransaction();
            try {
                $total = $debit->balance;
                if ($total > 0 && $amount > 0 && $total >= $amount) {
                    $debit->balance = ncSub($total,$amount,8);
                    $debit->updated_at   = date('Y-m-d H:i:s',time());
                    $debit->save();
                    $status = 0;

                    $remark = "Stake withdraw Completed";

                    $withdraw           = new Stacking_withdraw();
                    $withdraw->uid      = $uid;
                    $withdraw->stack_id = null;
                    $withdraw->coin     = 'SET';
                    $withdraw->amount   = $amount;  
                    $withdraw->status   = $status;
                    $withdraw->save();

                    Wallet::creditAmount($uid,'SET',$amount,8,'stakingwithdraw',$remark, $withdraw->id);

                    DB::commit();
                    return redirect('/earning')->with('success', 'Withdraw placed successfully!');
                } else {
                    return redirect('/earning')->with('error', 'Insufficient funds');
                } 
            }
            catch(Exception $e) {
                DB::rollBack();
                return redirect('/earning')->with('error', 'Something went wrong, try again later!');
            }
        } else {
            return redirect('/earning')->with('error', 'Insufficient funds');
        }
    } else {
        return redirect()->back()->with('error',"Amount Must be a Number");
    }

}

} 