<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail; 
use App\Mail\WithdrawEmail; 

class CurrencyWithdraw extends Model
{
	protected $table = 'withdraw_request';

    public static function listView($uid,$coin)
    {
    	$histroy = CurrencyWithdraw::where(['uid'=>$uid,'type'=> $coin])->orderBy('id', 'desc')->paginate(15);
    	return $histroy;
    }
    public static function createTransaction($uid,$coin,$bankid,$address,$amount,$fee,$ramount){
    	$Withdraw 					= new CurrencyWithdraw();
    	$Withdraw->uid 				= $uid;
        $Withdraw->tran_id          = TransactionString();
    	$Withdraw->type 			= $coin;
    	$Withdraw->bank_id 			= $bankid;
    	$Withdraw->address 			= $address;
    	$Withdraw->amount 			= $ramount;
    	$Withdraw->fee 				= $fee;
    	$Withdraw->request_amount 	= $amount;
    	$Withdraw->status 			= 0;
    	$Withdraw->created_at 		= date('Y-m-d H:i:s',time());
    	$Withdraw->updated_at 		= date('Y-m-d H:i:s',time());
    	$Withdraw->save();
    	return $Withdraw->id;
    }
    public function bankDetails()
    {
      return $this->belongsTo('App\Models\Bankuser', 'bank_id');
    }
}
