<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cryptotransaction extends Model
{
    protected $table = 'cryptotransactions';

    public static function listView($uid,$coin=null)
    {
        if(!$coin){
            $list = Cryptotransaction::where(['uid' => $uid])->orderBy('id', 'desc')->paginate(10);
        } else{
            $list = Cryptotransaction::where(['uid' => $uid, 'currency' => $coin])->orderBy('id', 'desc')->paginate(10);
        }    	     	
    	return $list;
    }


    public static function createTransaction($uid,$coin,$txid,$from,$to,$amount,$confirm=3,$time,$status =0,$nirvaki_nilai=0,$network='coin'){
        $tran = Cryptotransaction::where(['uid' => $uid, 'currency' => $coin,'txid' => $txid])->first();
        if(!$tran){
            $tran = new Cryptotransaction();
            $tran->uid = $uid;
            $tran->currency = $coin;
            $tran->txtype = $uid;
            $tran->txid = $txid;
            $tran->from_addr = $from;
            $tran->to_addr = $to;
            $tran->amount = $amount;            
            $tran->status = $status;
            $tran->nirvaki_nilai = $nirvaki_nilai;
			$tran->usdt_deposit_type = $network;
            $tran->created_at = $time;
        }
        $tran->confirmation = $confirm;
        $tran->updated_at = date('Y-m-d H:i:s',time());
        $tran->save();
        return $tran;

    }
    public function coinDetails()
    {
      return $this->belongsTo('App\Bankuser', 'bank_id');
    }
}
