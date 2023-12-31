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
use App\Models\AffilateCommission;
use App\Models\StakingOverAllStake;

class InsertStakecto extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:insertStakecto';

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
        $today = date('Y-m-d',time());
        $date = strtotime($today);
        $expiry_date = strtotime('-1 day', $date);
        $yesterday = date('Y-m-d',$expiry_date);
        $total_deposit = Staking_user_deposit::whereDate('created_at',$yesterday)->sum('no_of_coin');
        
        $live_price = Tradepair::where('coinone','SET')->where('cointwo','USDT')->value('close');

        if($total_deposit > 0){
            $users = StakingOverAllStake::whereNotIn('role',['Personal'])->whereNotNull('role')->get();
            if(count($users) > 0){
                foreach($users as $user){
                    $role = $user->role;
                    if($role == 'Excutive Manager'){
                        $percentage   = ncDiv(1,100,3);
                        $total_amount = ncMul($percentage,$total_deposit,3);
                    }elseif($role == 'Senior Manager'){
                        $percentage   = ncDiv(1,100,3);
                        $total_amount = ncMul($percentage,$total_deposit,3);
                    }elseif($role == 'Club Manager'){
                        $percentage   = ncDiv(0.5,100,3);
                        $total_amount = ncMul($percentage,$total_deposit,3);
                    }elseif($role == 'Cheif Manager'){
                        $percentage   = ncDiv(0.5,100,3);
                        $total_amount = ncMul($percentage,$total_deposit,3);
                    }elseif($role == 'Vice President'){
                        $percentage   = ncDiv(0.25,100,3);
                        $total_amount = ncMul($percentage,$total_deposit,3);
                    }elseif($role == 'President'){
                        $percentage   = ncDiv(0.25,100,3);
                        $total_amount = ncMul($percentage,$total_deposit,3);
                    }elseif($role == 'Senior President'){
                        $percentage   = ncDiv(0.25,100,3);
                        $total_amount = ncMul($percentage,$total_deposit,3);
                    }else{
                        $total_amount = 0;
                    }
                    $rolecount = StakingOverAllStake::where('role',$role)->count();
                    $amountUSDT = ncDiv($total_amount,$rolecount,8);
                    $amount = ncDiv($amountUSDT,$live_price,8);
                    $this->creditStacking($user->uid,'SET',$amount);

                    $reward_history                   = new RewardHistory;
                    $reward_history->uid              = $user->uid;
                    $reward_history->type             = 'cto';
                    $reward_history->levels           = 'CTO';
                    $reward_history->coin             = 'SET';
                    $reward_history->amount           = $amount;
                    $reward_history->stake_id         = null;
                    $reward_history->stake_user_id    = null;
                    $reward_history->stake_user_name  = null;
                    $reward_history->stake_user_email = null;
                    $reward_history->save();

                    //echo "$role $rolecount $amountUSDT $amount - ";
                }
            }            
        }
        $this->info('Stake CTO Inserted successfully');
    }
    public static function creditStacking($uid,$coin,$amount){
        $checkwallet = Stacking_wallet::where(['uid' => $uid,'currency' => $coin])->first();
        if(!is_object($checkwallet))
        {
            $wallet = new Stacking_wallet();
            $wallet->uid  = $uid;
            $wallet->currency  = $coin;
            $wallet->balance  = $amount;
            $wallet->main_balance  = $amount;
            $wallet->reward_amt  = $amount;
            $wallet->direct_income  = 0;
            $wallet->save();
        }
        else{
            $oldbalance = $checkwallet->balance;
            $total = ncAdd($oldbalance, $amount, 8);
            $oldmain_balance = ncAdd($checkwallet->main_balance,$amount,8);
            $reward_amt = ncAdd($checkwallet->reward_amt,$amount,8);
            $checkwallet->balance = $total;
            $checkwallet->main_balance = $oldmain_balance;
            $checkwallet->reward_amt = $reward_amt;
            $checkwallet->updated_at = date('Y-m-d H:i:s',time());
            $checkwallet->save();
        }
    }

}
