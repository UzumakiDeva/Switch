<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tradepair extends Model
{
    protected $table = 'tradepairs';

    public function tradepairsdetails()
	{
	  return $this->belongsTo('App\User', 'user_id');
	}

	public function getCoinName($pairid,$type=NULL){
		$pair = Tradepair::where(['id' => $pairid ,'active' => 1])->first();
		if($type == 'coinone'){
			return $pair->coinone;
		}elseif($type == 'cointwo'){
			return $pair->cointwo;
		}else{
			return $pair;
		}
	}

	public function coinonedetails()
	{
	  return $this->belongsTo('App\Models\Commission', 'coinone','source');
	}

	public function cointwodetails()
	{
	  return $this->belongsTo('App\Models\Commission', 'cointwo','source');
	}
}
