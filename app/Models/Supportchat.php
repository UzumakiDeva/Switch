<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supportchat extends Model
{
    protected $fillable = [
    	'uid','ticketid', 'message','reply', 'user_status',  'admin_status'
    ];
}
