<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class BuySellCommission extends Model
{
    public static function selectCommission($currency){
    	$data = BuySellCommission::where('source',$currency)->first();
        if($data){
        	return $data;
        }else{
            return false;
        }
    }

    public static function getLivePrice(){
    	$data = BuySellCommission::where('source',$currency)->first();
        if($data){
        	return $data->buy;
        }else{
            return false;
        }
    }
}
