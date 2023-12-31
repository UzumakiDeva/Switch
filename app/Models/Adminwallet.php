<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Adminwallet extends Model
{
    protected $table = 'adminwallet';

    public static function admincreditAmount($currency, $amount, $commission,$type)
    {
        $adminbalnce = Adminwallet::where([['currency', '=',$currency]])->first();
        if($adminbalnce) {
            $total = ncAdd($amount, $adminbalnce->balance, 8);
            $adminbalnce->balance = $total;
            $adminbalnce->commission = $total;
            $adminbalnce->instant_type = $type;
            $adminbalnce->updated_at = date('Y-m-d H:i:s',time());
            $adminbalnce->save();
            return $adminbalnce;
        } else {        	
            Adminwallet::insert(['currency' => $currency, 'balance' => $amount, 'commission' => $amount, 'instant_type' => $type, 'created_at' => date('Y-m-d H:i:s',time()), 'updated_at' => date('Y-m-d H:i:s',time())]);
        }
    }


}
