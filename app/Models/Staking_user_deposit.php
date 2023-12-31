<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staking_user_deposit extends Model
{	
	protected $connection = 'mysql3';
    protected $table = 'staking_user_deposit';  

  	public function stakingsetting()
    {
       return $this->belongsTo('App\Models\Staking_setting', 'stak_id', 'id');

    }  

    public function rewards()
    {
       return $this->hasMany('App\Models\Staking_interest', 'stak_id', 'stak_id');

    }

    public function withdraw()
    {
       return $this->hasMany('App\Models\Stacking_withdraw', 'stack_id', 'stak_id');

    }
}
