<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StakingOverAllStake extends Model
{	
	protected $connection = 'mysql3';
    protected $table = 'users_staking_overall';    

    public function userdetails()
	{
	  return $this->belongsTo('App\User', 'uid','id');
	}

	public function parentdetails()
	{
	  return $this->belongsTo('App\User', 'pid','id');
	}

	public function parent()
	{
	  return $this->belongsTo('App\Models\StakingOverAllStake', 'pid','uid');
	}
}