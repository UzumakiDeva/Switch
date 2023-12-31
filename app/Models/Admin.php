<?php
namespace App\Models;

use Illuminate\Notifications\Notifiable;
 
use Illuminate\Foundation\Auth\User as Authenticatable; 
use Illuminate\Database\Eloquent\Model;

class Admin extends Authenticatable 
{	
	protected $table = "admin";
    protected $fillable = ['name','email','senha'];
}
	