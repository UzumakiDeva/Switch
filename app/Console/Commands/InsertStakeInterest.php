<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tradepair;
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
use App\Models\StakingOverAllStake;
use App\Models\AffilateCommission;

class InsertStakeInterest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:insertstakeinterest';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'insert stake interest';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        
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
    			$live_price             = Tradepair::where('coinone','SET')->where('cointwo','USDT')->value('close');
    			$staking_amount         = ncDiv($user->actual_staking_amount,$live_price,8);
                $amount_staked = $user->actual_staking_amount;
                $setstake = ncDiv($user->no_of_coin,$user->live_price,4);

    			if($enddate > $expiry_time){
    				$expiry_date = date('Y-m-d', $next_reward);
    				$update = Staking_user_deposit::where(['id' => $user->id,'uid' =>$user->uid])->update(['last_reward' => $today ,'next_reward' => $expiry_date ,'status' => 1,'updated_at' => date('Y-m-d H:i:s',time())]);
    			}else{

                    $interest     = Staking_interest::where('uid',$user->uid)->where('deposit_id',$user->id)->sum('amount'); 
                    $total_amount = $interest;
                    $debit = Stacking_wallet::where(['uid' => $user->uid,'currency' =>$reward_coin ])->first();

                    if(isset($debit))
                    {
                        /*if ($total_amount > 0) {
                            $debit->main_balance = ncAdd($debit->main_balance,$total_amount,8);
                            $debit->updated_at   = date('Y-m-d H:i:s',time());
                            $debit->save();
                        }*/
                    }

    				$update = Staking_user_deposit::where(['id' => $user->id,'uid' =>$user->uid])->update(['last_reward' => $today ,'next_reward' => null ,'expiry_date' => null,'status' => 4,'updated_at' => date('Y-m-d H:i:s',time())]);
    			}

    			if($reward_type == 'percentage')
    			{
                    /**Percentage calculation 
                        (Rate/Period)*Amount
                        period(weekly,monthly,semiannually,quarterly,annually)
                    **/
                        
                        $percentage = ncdiv($reward_interest,100,8); 
                        $amount     = ncMul($percentage,$staking_amount,8);                   
                        $amount_usdt  = ncMul($percentage,$amount_staked,8);
                        $amount_set  = ncMul($percentage,$setstake,8);                   

                    }elseif($reward_type == 'fixed'){
                    /**Fixed calculation 
                        (Reward/Period)
                        period(weekly,monthly,semiannually,quarterly,annually)
                    **/
                        $Reward = $reward_interest;
                        $amount = ncDiv($Reward,$period,8);
                        $amount_usdt  = ncDiv($Reward,$period,8);
                    }else{
                    	$amount = 0;
                        $amount_usdt  = 0;
                        $amount_set = 0;
                        $setstake = 0;
                    }

                    if($amount > 0){
                    	$insert = new Staking_interest();
                    	$insert->uid  = $user->uid;
                    	$insert->stak_id  = $user->stak_id;
                        $insert->deposit_id  = $user->id;
                    	$insert->txid  = TransactionString();
                    	$insert->coin  = $reward_coin;
                    	$insert->interest_type  = $reward_type;
                    	$insert->interest_amt  = $reward_interest;
                    	$insert->duration_title  = $duration_title;
                   // $insert->period  = $period;
                    	$insert->period  = 0;
                    	$insert->amount  = $amount;
                        $insert->amount_usdt  = $amount_usdt;
                        $insert->amount_set  = $amount_set;
                        $insert->amount_staked  = $amount_staked;
                        $insert->set_stake  = $setstake;
                    	$insert->status  = 1;
                    	$insert->save();

                    	/** Auto credit Stacking_wallet **/
                    	self::creditStacking($user->uid,$reward_coin,$amount_set);
						self::updateLevelIncome($user->uid,$amount_set,$user->stak_id,$user->id);	

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


            $this->info('Stake Interest Inserted successfully');
        }

        public static function renewDate($duration_title){
        	$today = date('d-m-Y',time());
        	$today = strtotime($today);

        	if($duration_title == 'daily')
        	{
        		$expiry_date = strtotime('+1 day', $today);
				//$expiry_date = $today;
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

        public static function creditStacking($uid,$coin,$amount,$main=0){
        	$checkwallet = Stacking_wallet::where(['uid' => $uid,'currency' => $coin])->first();
        	if(!is_object($checkwallet))
        	{
        		$wallet = new Stacking_wallet();
        		$wallet->uid  = $uid;
        		$wallet->currency  = $coin;
        		$wallet->balance  = $amount;
                $wallet->main_balance  = $main;
        		$wallet->direct_income  = 0;
        		$wallet->save();
        	}
        	else{
        		$oldbalance = $checkwallet->balance;
        		$olddirect  = $checkwallet->direct_income;
        		$total = ncAdd($oldbalance, $amount, 8);
        		$direct_amt = ncAdd($olddirect,$amount,8);
                $oldmain_balance = ncAdd($checkwallet->main_balance,$main,8);
        		$checkwallet->balance = $total;
                $checkwallet->main_balance = $oldmain_balance;
        		$checkwallet->updated_at = date('Y-m-d H:i:s',time());
        		$checkwallet->save();
        	}
        }

		public function updateLevelIncome($userid,$amount,$stake_id,$deposit_id){
            $users       = User::where('id',$userid)->first();
            if(is_object($users)){
            $refcode     = $users->parent_id;
            $commissions = AffilateCommission::get(); 
            $creditamount = $amount;
            $totalamount  = 0;
            $calculate  = 0;
            if($refcode != ''){
                if(count($commissions) > 0){ 
                   foreach($commissions as $commission) {
                    $coin = $commission->coin;              
                    $lev = $commission->generation;              
                    $role = $commission->role;
                    $type = $commission->title;           
                    $referuser = User::where('referral_id',$refcode)->first();
                    if($referuser){
                        //echo  $role .' Type: '.$type." USER $referuser->id ROLE $referuser->role <>"; 
                        $stake = Staking_user_deposit::where('uid',$referuser->id)->get();
                     if (count($stake) > 0) {
                        $is_boost = 1;
                        if($role == 'All'){
                            if($lev == 1 || $lev == 2){
                                $is_reward = 1;
                                if($referuser->is_boost == 1){
                                    $is_boost = 2;
                                }
                            }else if($lev == 3 || $lev == 4 || $lev == 5){
                                $stakecount = StakingOverAllStake::where(['uid'=> $referuser->id])->value('stakecount');
                                if($stakecount >= 3){
                                    $is_reward = 1;
                                }else{
                                    $is_reward = 0;
                                }
                                if($referuser->is_boost == 1){
                                    $is_boost = 2;
                                }                            
                            }else if($lev == 6 || $lev == 7 || $lev == 8 || $lev == 9 || $lev == 10){
                                $stakecount = StakingOverAllStake::where(['uid'=> $referuser->id])->value('stakecount');
                                if($stakecount >= 5){
                                    $is_reward = 1;
                                }else{
                                    $is_reward = 0;
                                }                            
                            }else{
                                $is_reward = 0;
                            }                            
                        }else if($role == 'Ex_Manager' && $referuser->role == 'Excutive Manager'){
                            $is_reward = 1;
                        }else if(($role == 'Ex_Manager' && $referuser->role == 'Senior Manager') ||($role == 'SR_Manager' && $referuser->role == 'Senior Manager')){
                            $is_reward = 1;
                        }else if(($role == 'Ex_Manager' && $referuser->role == 'Club Manager') ||($role == 'SR_Manager' && $referuser->role == 'Club Manager') ||($role == 'Club_Manager' && $referuser->role == 'Club Manager')){
                            $is_reward = 1;
                        }else if(($role == 'Ex_Manager' && $referuser->role == 'Cheif Manager') ||($role == 'SR_Manager' && $referuser->role == 'Cheif Manager') ||($role == 'Club_Manager' && $referuser->role == 'Cheif Manager') ||($role == 'Cheif_Manager' && $referuser->role == 'Cheif Manager')){
                            $is_reward = 1;
                        }else if($referuser->role == 'Senior President' || $referuser->role == 'President' || $referuser->role == 'Vice President' || $referuser->role == 'Cheif Manager'){
                            $is_reward = 1;
                        }else{
                            $is_reward = 0;
                        }
                        if($is_reward ===1){
                            $dbcommission = $commission->stake * $is_boost;
                            $calculate  = bcdiv(sprintf('%.10f',$dbcommission),100,8);
                            $commission_affilate = bcmul(sprintf('%.10f',$amount) ,sprintf('%.10f',$calculate),8);
                            $creditamount = $commission_affilate;
                            if($creditamount > 0)
                            {
                                $uid = $referuser->id;  
                                $remark = $type; 
                                self::creditStacking($uid,$coin,$creditamount,$creditamount);
                                $reward_history                   = new RewardHistory;
                                $reward_history->uid              = $uid;
                                $reward_history->type             = $remark;
                                $reward_history->levels           = 'Level '.$lev;
                                $reward_history->coin             = $coin;
                                $reward_history->amount           = $creditamount;
                                $reward_history->stake_id         = $stake_id;
                                $reward_history->deposit_id       = $deposit_id;
                                $reward_history->stake_user_id    = $users->id;
                                $reward_history->stake_user_name  = $users->first_name.' '.$users->last_name;
                                $reward_history->stake_user_email = $users->email;
                                $reward_history->is_boost = $is_boost;
                                $reward_history->save();

                            }else {
                                break;
                            }
                            //echo $uid.' Stake - '.$stake_id.' Amount - '.$creditamount."<br>";
                        }   
                     }    
                    } else { 
                        break;
                    } 

                    $refcode = $referuser->parent_id;  
                  //  $users = $referuser;  
                }            
            }         
        }
        } 
    }

    public static function directreferal($uid,$amount,$percentage,$coin,$stak_id,$remark) {
        $user = User::find($uid);
        $reward_user  = User::where('referral_id',$user->parent_id)->first();
        if (is_object($reward_user)) {
            $percentage = ncDiv($percentage,100,8); 
            $amount     = ncMul($percentage,$amount,8);    

            self::creditStacking($reward_user->id,$coin,$amount);
            $reward_history                   = new RewardHistory;
            $reward_history->uid              = $reward_user->id;
            $reward_history->type             = $remark;
            $reward_history->amount           = $amount;
            $reward_history->stake_id         = $stak_id;
            $reward_history->stake_user_id    = $user->id;
            $reward_history->stake_user_name  = $user->first_name.'.'.$user->last_name;
            $reward_history->stake_user_email = $user->email;
            $reward_history->save();
            return true;       

        }
        return false;
    }

}
