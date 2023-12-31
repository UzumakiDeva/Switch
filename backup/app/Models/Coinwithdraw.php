<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coinwithdraw extends Model
{
	protected $table = 'coin_withdraw';

    protected $fillable = [
     'uid', 'coin_name', 'sender','reciever','amount','transaction_id','remark','status'
    ];
    
    public static function listView($uid,$coin=null)
    {
		if($coin){
			$list = Coinwithdraw::where(['uid' => $uid, 'coin_name' => $coin])->orderBy('id', 'desc')->paginate(15);
		} else{
			$list = Coinwithdraw::where(['uid' => $uid])->orderBy('id', 'desc')->paginate(15);
		}    	     	
    	return $list;
    }
    public static function createTransaction($uid,$coin,$fromaddress,$toaddress,$amount,$fee,$ramount,$status=0,$network=null,$tag=null){
    	$Withdraw 					= new Coinwithdraw();
    	$Withdraw->uid 				= $uid;
    	$Withdraw->coin_name		= $coin;
    	$Withdraw->sender 			= $fromaddress;
    	$Withdraw->reciever 		= $toaddress;
    	$Withdraw->amount 			= $amount;
    	$Withdraw->request_amount 	= $ramount;
    	$Withdraw->admin_fee 		= $fee;
      $Withdraw->network    = $network;
      $Withdraw->destination_tag    = $tag;
    	$Withdraw->transaction_id 	= TransactionString(15);
    	$Withdraw->status 			= $status;
        //$Withdraw->withdrawtype     = $withdrawtype;
    	$Withdraw->created_at 		= date('Y-m-d H:i:s',time());
    	$Withdraw->updated_at 		= date('Y-m-d H:i:s',time());
    	$Withdraw->save();
    	return $Withdraw->id;
    }
    public function coindetails()
    {
      return $this->belongsTo('App\Models\Commission', 'coin_name','source');
    }

}
