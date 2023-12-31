<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Instantuser extends Model
{
  
  protected $table ="instant_user_transaction";


  public static function createTransaction($uid,$type,$paymentname,$payment_address,$credit_currency,$debit_currency,$amount,$credit_amount,$debit_amount,$commission,$adminfee){
       
            $tran = new Instantuser();
            $tran->uid = $uid;
            $tran->type = $type;
            $tran->paymentname   = $paymentname;
            $tran->payment_address   = $payment_address;
            $tran->credit_currency = $credit_currency;
            $tran->debit_currency = $debit_currency;
            $tran->amount = $amount;
            $tran->credit_amount = $credit_amount;
            $tran->debit_amount = $debit_amount;
            $tran->commission = $commission;            
            $tran->adminfee = $adminfee;
            $tran->created_at = date('Y-m-d H:i:s',time());
            $tran->updated_at = date('Y-m-d H:i:s',time());
            $tran->save();
        return $tran;

    }

}
