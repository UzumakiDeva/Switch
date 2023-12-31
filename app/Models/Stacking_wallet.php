<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stacking_wallet extends Model
{	
	protected $connection = 'mysql3';
    protected $table = 'stacking_wallet'; 

     public function stakingsetting()
    {
            return $this->belongsTo('App\Staking_setting', 'stacking_id', 'id');

    }  	   

     public static function creditAmount($uid, $currency, $amount, $decimal,$type=null,$remark=null,$actionid=null)
    {
        $userbalance = Stacking_wallet::where([['uid', '=', $uid], ['currency', '=',$currency]])->first();        
        if($userbalance) {
            $oldbalance = $userbalance->balance;
            $total = ncAdd($amount, $userbalance->balance, $decimal);

            $walletbalance =  $total;
            $site_balance = ncAdd($amount, $userbalance->site_balance, $decimal);
            $userbalance->balance = $total;
            $userbalance->updated_at = date('Y-m-d H:i:s',time());
            $userbalance->save();
        } else {    
            $oldbalance = 0;
            $walletbalance =  $amount;      
            Stacking_wallet::insert(['uid' => $uid, 'currency' => $currency, 'balance' => $amount,'created_at' => date('Y-m-d H:i:s',time()), 'updated_at' => date('Y-m-d H:i:s',time())]);
        }
        self::AllcoinUpdateBalanceTrack($uid,$currency,$amount,0,$walletbalance,$oldbalance,$type,$remark,$actionid);
    }

      public static function AllcoinUpdateBalanceTrack($uid,$currency,$creditamount=0,$debitamount=0,$walletbalance=0,$oldbalance=null,$tradetype=null,$remark=null,$actionid=null)
    {
        if($creditamount > 0 || $debitamount > 0)
        {
            $Models = '\App\Model\OverallTransaction';
            $Models::AddTransaction($uid,$currency,$tradetype,$creditamount,$debitamount,$walletbalance,$oldbalance,$remark,'web',$actionid);
        }        
        return true;
    }

}
