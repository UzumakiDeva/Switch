<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stacking_withdraw extends Model
{	
	protected $connection = 'mysql3';
    protected $table = 'stacking_withdraw'; 

   public function sta_setting()
    {
      return $this->belongsTo('App\Staking_setting', 'stack_id', 'id');

    }     

}
