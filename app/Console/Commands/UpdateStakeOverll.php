<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Staking_user_deposit;
use App\Models\StakingOverAllStake;
use App\Models\AffilateCommission;
use App\User;

class UpdateStakeOverll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:stakeoverall';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update all user stake balance';

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
        $users = User::where(['email_verify' => 1])->get();
        foreach($users as $user){
            $uid = $user->id;
            $name = $user->first_name.' '.$user->last_name;
            $email = $user->email;
            $overall = Staking_user_deposit::where(['uid' => $uid])->sum('no_of_coin');            
            $refcode     = $user->parent_id;
            $referralID  = $user->referral_id;
            $child = User::where('parent_id',$referralID)->count();
			$child_ids = User::where('parent_id',$referralID)->pluck('id');            
            $child_exists = Staking_user_deposit::whereIn('uid',$child_ids)->distinct('uid')->count();
            $thirty_days = strtotime('+30 day', strtotime($user->created_at)); 
            //$reg = date('d-m-Y',strtotime($user->created_at));
            //$thirt = date('d-m-Y',$thirty_days);
            //echo "$uid Register $reg 30 $thirt - ";
            echo "$uid  - ";
            $pID = null;
            if($refcode != ''){
                $referuser = User::where('referral_id',$refcode)->first();
                if (!empty($referuser)) {
                    $pID = $referuser->id;
                } else {
                    $pID = null;
                }
            }
            if(!isset($overall)){
                $overall = 0;
            }
            $strong = StakingOverAllStake::where(['pid' => $uid])->orderBy('total_bussiness', 'desc')->first();            

            $coin = 'USDT';
            $stakeWallet = StakingOverAllStake::where(['uid'=> $uid,'currency' => $coin])->first();
            if(!$stakeWallet){  
                $stakeWallet = new StakingOverAllStake; 
                $stakeWallet->uid        = $uid;
                $stakeWallet->currency   = $coin;                
                $stakeWallet->email          = $email;           
                
                $stakeWallet->created_at = date('Y-m-d H:i:s',time());  
            }
            $stakeWallet->name           = $name;            
            $stakeWallet->pid            = $pID; 
            $stakeWallet->directchild    = $child; 
            $stakeWallet->overallstake   = $overall;                                      
            $stakeWallet->stakecount     = $child_exists;
            
            if(is_object($strong)){
                $strongLeg = StakingOverAllStake::where(['pid' => $uid])->max('total_bussiness');
                $totalleg = StakingOverAllStake::where(['pid' => $uid])->sum('total_bussiness');
                $direct500  = StakingOverAllStake::where([['pid','=', $uid],['overallstake','>=',500 ]])->count();
                $boost_direct_count = Staking_user_deposit::whereIn('uid',$child_ids)->where('created_at','>=',$thirty_days)->distinct('uid')->count();
                $boost_direct_amount = Staking_user_deposit::whereIn('uid',$child_ids)->where('created_at','>=',$thirty_days)->sum('no_of_coin');

                $otherLeg = ncSub($totalleg,$strongLeg);

                $stronguid = $strong->uid;
                //echo "$stronguid ";
                $strong_email = $strong->userdetails->email;
                $strong_name = $strong->userdetails->first_name.' '.$strong->userdetails->last_name;
                $stakeWallet->stronguid     = $stronguid;
                $stakeWallet->strong_name     = $strong_name;
                $stakeWallet->strong_email     = $strong_email;
                $getBusiness = $this->getBusiness($uid);
                $stakeWallet->bussiness     = $getBusiness['myBussiness'];
                $stakeWallet->total_bussiness     = ncAdd($getBusiness['myBussiness'],$overall);
                $stakeWallet->team_size     = $getBusiness['myTeam'];
                $stakeWallet->strongleg     = $strongLeg;
                $stakeWallet->otherleg     = $otherLeg;
                $stakeWallet->totalleg     = $totalleg;
                $stakeWallet->min_500      = $direct500;
                $stakeWallet->boost_direct_count     = $boost_direct_count;
                $stakeWallet->boost_direct_amount     = $boost_direct_amount;
                if($overall >= 10000 &&  $strongLeg >= 2500000 && $otherLeg >= 2500000){
                    $stakeWallet->role = 'Senior President';
                }elseif($overall >= 9000 &&  $strongLeg >= 500000 && $otherLeg >= 500000){
                    $stakeWallet->role = 'President';
                }elseif($overall >= 7000 &&  $strongLeg >= 250000 && $otherLeg >= 250000){
                    $stakeWallet->role = 'Vice President';
                }elseif($overall >= 5000 &&  $strongLeg >= 100000 && $otherLeg >= 100000){
                    $stakeWallet->role = 'Cheif Manager';
                }elseif($overall >= 2500 &&  $strongLeg >= 50000 && $otherLeg >= 50000 && $direct500 >= 10){
                    $stakeWallet->role = 'Club Manager';
                }elseif($overall >= 1000 &&  $strongLeg >= 25000 && $otherLeg >= 25000 && $direct500 >= 5){
                    $stakeWallet->role = 'Senior Manager';
                }elseif($overall >= 500 &&  $strongLeg >= 5000 && $otherLeg >= 5000 && $child_exists >= 3){
                    $stakeWallet->role = 'Excutive Manager';
                }else{
                    $stakeWallet->role = 'Personal';                    
                }
                if($boost_direct_count >= 3 && $boost_direct_amount >= 1000){
                    $is_boost = 1;
					$stakeWallet->is_boost = 2;
                }else{
                    $is_boost = 0;
                }
                User::where('id',$uid)->update(['role' => $stakeWallet->role,'is_boost' => $is_boost,'updated_at' => date('Y-m-d H:i:s',time())]);
            }else{
                $stakeWallet->total_bussiness = $overall;
                $stakeWallet->strongleg      = 0;               
                $stakeWallet->otherleg       = 0;                
                $stakeWallet->bussiness      = 0;
                $stakeWallet->min_500        = 0;
            }                                      
            $stakeWallet->updated_at     = date('Y-m-d H:i:s',time()); 
            $stakeWallet->save();            
        }
        //$this->updateRole();
        $this->info('User stake referral details updated!');
    }

    public function getBusiness($id){
        $levels = AffilateCommission::get();
        $child_array[] = $id;
        $data = array();
        $mybussiness = 0;
        $myTeam = 0;
        foreach($levels as $level){
            if(count($child_array) > 0){
                foreach($child_array as $ids){
                    $levelUsers = StakingOverAllStake::where('pid', $ids)->get();
                    if(count($levelUsers) > 0){
                        foreach($levelUsers as $keylevel => $value){
                            $mybussiness += $value->overallstake;
                            $child_array[]= $value->uid;                                
                            if (($key = array_search($value->pid, $child_array)) !== false) {
                              unset($child_array[$key]);
                            }
                            $myTeam ++;
                        }                        
                    }else{
                        if (($key = array_search($ids, $child_array)) !== false) {
                          unset($child_array[$key]);
                        }
                    }                                        
                }                 
            }else{
                break;
            }            
        }
        $data['myBussiness']  = $mybussiness;
        $data['myTeam']  = $myTeam;
        return $data;
    }

    public function updateRole(){
        $coin = 'USDT';
        $users = StakingOverAllStake::where([['overallstake','>=',500 ],['stakecount','>=',3 ]])->get();
        if(count($users) > 0){
            foreach($users as $user){
                $uid        = $user->uid;
                $myStake    = $user->overallstake;
                $strongLeg  = $user->strongleg;
                $totalleg   = $user->totalleg;
                $otherLeg   = $user->otherleg;
                $strongPer  = ncMul($strongLeg,0.6,8);
                $otherPer   = ncMul($otherLeg,0.4,8);
                $bussiness  = ncAdd($strongPer,$otherPer);
                $direct500  = $user->min_500;
                
                if($myStake >= 5000 && $bussiness >= 200000){
                    $role = 'Cheif_Manager';
                    $roles = 'Cheif Manager';
                }elseif($myStake >= 2500 && $bussiness >= 100000 && $direct500 >= 10){
                    $role = 'Club_Manager';
                    $roles = 'Club Manager';
                }elseif($myStake >= 1000 && $bussiness >= 50000 && $direct500 >= 5){
                    $role = 'SR_Manager';
                    $roles = 'Senior Manager';
                }else{
                    $role = 'Ex_Manager';
                    $roles = 'Excutive Manager';
                }
                $update = array('role'=> $roles,'min_500' => $direct500,'updated_at' => date('Y-m-d H:i:s',time()));
                StakingOverAllStake::where(['uid'=> $uid,'currency' => $coin])->update($update);
                User::where('id',$uid)->update(['role' => $role,'updated_at' => date('Y-m-d H:i:s',time())]);
            }            
        }
    }
}
