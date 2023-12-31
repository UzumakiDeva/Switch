<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Staking_setting;
use App\Models\Staking_interest;
use App\Models\Stacking_wallet;
use App\Models\RewardHistory;
use Validator;
use App\Models\Wallet;
use App\Models\Staking_user_deposit;
use App\User;
use App\Models\Stacking_withdraw;
use Auth;
use App\Models\StakingOverAllStake;
use App\Models\AffilateCommission;
use App\Models\Tradepair;



class StakeController extends Controller
{
	public $successStatus = 200;


	public function stakelist() {

		$data = Staking_setting::where('contract_visual',1)->get();

		return response()->json(["success"=> true ,"result" => $data ,"message" =>""],$this->successStatus);
	}

	public function earnings(){

		$uid = \Auth::user()->id;
		$data = array();

		$staking_amount   = Staking_interest::where('uid',$uid)->sum('amount_set');
		$direct_amount    = RewardHistory::where('uid',$uid)->where('type','direct_income')->sum('amount');
		$level_amount     = RewardHistory::where('uid',$uid)->where('type','level_income')->sum('amount');
		$rank1_amount     = RewardHistory::where('uid',$uid)->where('type','rank_1')->sum('amount');
		$rank2_amount     = RewardHistory::where('uid',$uid)->where('type','rank_2')->sum('amount');
		$rank3_amount     = RewardHistory::where('uid',$uid)->where('type','rank_3')->sum('amount');
		$rank4_amount     = RewardHistory::where('uid',$uid)->where('type','rank_4')->sum('amount');
		$cto_amount       = RewardHistory::where('uid',$uid)->where('type','cto')->sum('amount');

		$total_amount     = $staking_amount+$direct_amount+$level_amount+$rank1_amount+$rank2_amount+$rank3_amount+$rank4_amount+$cto_amount;

		$main_balance     = Stacking_wallet::where('uid',\Auth::user()->id)->where('currency','SET')->sum('balance');
		$total_withdraw          = Stacking_withdraw::where('uid',\Auth::user()->id)->where('coin','SET')->sum('amount');

		$data[] = ["name"=>"Total Income","amount"=> display_format($total_amount).' '."SET","key"=>"total_income","image"=>url('images/total-income.png')];
		$data[] = ["name"=>"Staking Income","amount"=> display_format($staking_amount).' '."SET","key"=>"stake_income","image"=>url('images/staking-income.png')];
		$data[] = ["name"=>"Direct Income","amount"=> display_format($direct_amount).' '."SET","key"=>"direct_income","image"=>url('images/direct-income.png')];
		$data[] = ["name"=>"Gen 1-2 Income","amount"=> display_format($level_amount).' '."SET","key"=>"level_income","image"=>url('images/level-income.png')];
		$data[] = ["name"=>"Gen 2-5 Income","amount"=> display_format($rank1_amount).' '."SET","key"=>"rank_1","image"=>url('images/rank1.png')];
		$data[] = ["name"=>"Gen 6-10 Income","amount"=> display_format($rank2_amount).' '."SET","key"=>"rank_2","image"=>url('images/rank2.png')];
		$data[] = ["name"=>"Gen 11-15 Income","amount"=> display_format($rank3_amount).' '."SET","key"=>"rank_3","image"=>url('images/rank3.png')];
		$data[] = ["name"=>"Gen 16-20 Income","amount"=> display_format($rank4_amount).' '."SET","key"=>"rank_4","image"=>url('images/rank4.png')];
		$data[] = ["name"=>"CTO Income","amount"=> display_format($cto_amount).' '."SET","key"=>"cto","image"=>url('images/rank5.png')];				
		$data[] = ["name"=>"Total Withdraw","amount"=> display_format($total_withdraw).' '."SET","key"=>"total_withdraw","image"=>url('images/rank6.png')];
		$data[] = ["name"=>"Main Balance","amount"=> display_format($main_balance).' '."SET","key"=>"","image"=>url('images/rewards-income.png')];

		return response()->json(["success" =>true ,"result"=>$data ,"message"=>""],$this->successStatus);

	}

	public function earninghistory(Request $request){

		$type = $request->type;
		if ($type == 'stake_income' || $type == 'total_income') {

			$data    = Staking_interest::where('uid',\Auth::user()->id)->orderBy('id', 'desc')->get(); 
		} else if ($type == 'total_withdraw') {
			$data    =  Stacking_withdraw::where('uid',\Auth::user()->id)->where('coin','SET')->get();
		}else {

			$data    = RewardHistory::where('uid',\Auth::user()->id)->where('type',$type)->orderBy('id', 'desc')->get();
		}

		return response()->json(["success"=>true,"result"=>$data,"message"=>""],$this->successStatus);
	}

	public function stacksubmit(Request $request){

		$validator = Validator::make($request->all(), [
			'stackid'        => 'required',
			'no_of_coin'     => 'required|numeric',
			'duration_title' => 'required|in:daily,weekly,monthly,quarterly,semiannually,annually,730days,1460days',
		]);

		if ($validator->fails()) { 
        	return response()->json(["success" => false,"result" => NULL,"message"=> $validator->errors()->first()], 200);           
        }

		$no_of_coin     = $request->no_of_coin;
		$stackid        = $request->stackid;
		$uid            = \Auth::id();
		$Staking 	    = Staking_setting::where('id',$stackid)->first();
		$deposit_coin   = $Staking->deposit_coin;
		$amount         = 0;
        $total_estimated_reward = 0;
        $reward_interest = $Staking->reward_interest;
		$live_price 	= Tradepair::where('coinone','SET')->where('cointwo','USDT')->value('close');        
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

					$percentage = ncDiv($reward_interest,100,8); 
                    $amount     = ncMul($percentage,$no_of_coin,8); 
                    $total_estimated_reward = ncMul($amount,730,8);

				}else if($duration_title == '1460days')
				{
					$expiry_date = strtotime("+1460 day", $today);

					$percentage = ncDiv($reward_interest,100,8); 
                    $amount     = ncMul($percentage,$no_of_coin,8); 
                    $total_estimated_reward = ncMul($amount,1460,8);
				}else
				{
					return response()->json(["success" => false,"result" => NULL,"message"=> "Something went wrong! try again!"], 200);
				}


				if($rewards_credit_type == 'daily')
				{
					$next_reward = strtotime('+1 day', $today);
					//$next_reward = $today;
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
								
								return response()->json(["success"=>true,"result"=>"","message"=>"Stake Submitted Successfully!"],$this->successStatus);

							}else{
								return response()->json(["success" => false,"result" => NULL,"message"=> "Warning! Entered amount must be equal to or lesser than the Maximum Locked Amount!"], 200);
							}
						}else{
							return response()->json(["success" => false,"result" => NULL,"message"=> "Warning! Entered amount must be equal to or greater than the Minimum Locked Amount!"], 200);
						}
					}else{

						return response()->json(["success" => false,"result" => NULL,"message"=> "Insufficient fund in your ".$deposit_coin." wallet !.you need minimum  amount of ".$no_of_coin." in your ".$deposit_coin." main wallet"], 200);

					}
				}else{
					
					return response()->json(["success" => false,"result" => NULL,"message"=> "Please try some other duration because staking expired on ".date('d-m-Y',$enddate)], 200);
				}
			}else{

				return response()->json(["success" => false,"result" => NULL,"message"=> "Staking already expired!"], 200);
			}
		}else{
			
			return response()->json(["success" => false,"result" => NULL,"message"=> "Invalid Request given please try again later"], 200);
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
					return response()->json(["success"=>true,"result"=>"","message"=>"Withdraw placed successfully!"],$this->successStatus);
				} else {
					return response()->json(["success" => false,"result" => NULL,"message"=> "Insufficient funds!"], 200);
				} 
			}
			catch(Exception $e) {
				DB::rollBack();
				return response()->json(["success" => false,"result" => NULL,"message"=> "Something went wrong, try again later!"], 200);
			}
		} else {
			return response()->json(["success" => false,"result" => NULL,"message"=> "Insufficient funds!"], 200);
		}
	} else {
		return response()->json(["success" => false,"result" => NULL,"message"=> "Please enter a amount"], 200);
	}

}

public function referralinfo() {

	$user   = Auth::user();
	$result = array();


	$referral_id = Auth::user()->referral_id;
	$uid 		 = Auth::user()->id;
	$info 	     = StakingOverAllStake::where('uid',$uid)->orderBy('overallstake','desc')->first();

	$role = Auth::user()->role;
	if ($role =='Personal') {
		$levels = AffilateCommission::take(5)->get();  
	} elseif ($role == 'Excutive Manager')  {
		$levels = AffilateCommission::take(5)->get();
	} elseif ($role == 'Senior Manager')  {
		$levels = AffilateCommission::take(10)->get();
	} elseif ($role == 'Club Manager')  {
		$levels = AffilateCommission::take(15)->get();
	}elseif ($role == 'Cheif Manager' || $role == 'Vice President' || $role == 'President' || $role == 'Senior President')  {
		$levels = AffilateCommission::get();
	} else {
		$levels = AffilateCommission::take(2)->get();  
	}

	$child_array[] = $user->id;
	$data = array();
	$mybussiness = 0;
	$myTeam = 0;
	foreach($levels as $level){
		if(count($child_array) > 0){
			foreach($child_array as $ids){
				$levelUsers = StakingOverAllStake::where('pid', $ids)->get();
				if(count($levelUsers) > 0){
					foreach($levelUsers as $keylevel => $value){
						$data['Gen'.$level->generation][] = ["name"=>$value->name,"mail"=>$value->email,"over_all_stake"=>$value->overallstake,"business"=>$value->bussiness,"total"=>$value->total_bussiness,"role"=>$value->role,"parent_info"=>isset($value->parent['name'])?$value->parent['name']:"" ]; 
						$mybussiness += $value->overallstake;
						$child_array[]= $value->uid;                                
						if (($key = array_search($value->pid, $child_array)) !== false) {
							unset($child_array[$key]);
						}
					}                        
				}else{
					if (($key = array_search($ids, $child_array)) !== false) {
						unset($child_array[$key]);
					}
				}
				$myTeam ++;                    
			}                 
		}else{
			$data['Gen'.$level->generation] = array();
		}            
	}


	$result['referral_information'] = ["refer_url"=>url('res/'.Auth::user()->referral_id) ,"refer_id"=>Auth::user()->referral_id,"my_role"=>$info->role,"my_overAll_stake"=>$info->overallstake,"my_bussiness"=>$info->bussiness,"strong_leg"=> $info->strongleg,"other_leg"=>$info->otherleg,"strongemail"=>$info->strong_email];

	$result['level_information'] = $data;

	return response()->json(["success" =>true,"data"=>$result,"message"=>""],$this->successStatus);

}

public function mystake(){

	$uid 		  = Auth::user()->id;
	$user_deposit = Staking_user_deposit::where('uid',$uid)->get();
	$live_price   = Tradepair::where('coinone','SET')->where('cointwo','USDT')->value('close'); 

	return response()->json(["success" =>true,"data"=>$user_deposit,"live_price"=>$live_price,"message"=>""],$this->successStatus);
}

}
