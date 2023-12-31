<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use Mail;

class User extends Authenticatable  
{
    use Notifiable,HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = 'mysql';
    protected $fillable = [
        'first_name', 'last_name','role','email', 'password','google2fa_secret','referral_id','parent_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendPasswordResetNotification($token){

        $data = [
            $this->email
        ];

        Mail::send('email.reset-password', [
            'fullname'      => $this->first_name.' '.$this->last_name,
            'reset_url'     => route('password.reset', ['token' => $token, 'email' => $this->email]),
        ], function($message) use($data){
            $message->subject('Reset Password Request');
            $message->to($data[0]);
        });
    }
    public static function getUserDetails($id){
        $data = User::where('id', $id)->first();
        return $data;
    }

    public function userStakeInfo()
    {
      return $this->belongsTo('App\Models\StakingOverAllStake', 'id','uid');
    }
	
	function getOnlineUserCount()
	{
		return DB::table(config('session.table'))->count();
	}
	function getLoggedInUsers()
	{
		return DB::table(config('session.table'))
			->distinct()
			->select(['users.id', 'users.name', 'users.email'])
			->whereNotNull('user_id')
			->leftJoin('users', config('session.table') . '.user_id', '=', 'users.id')
			->get();
	}
	function getActiveUsersInLastMinutes(int $minutes)
	{
		return DB::table(config('session.table'))
			->distinct()
			->select(['users.id', 'users.name', 'users.email'])
			->whereNotNull('user_id')
			->where('sessions.last_activity', '>', Carbon::now()->subMinutes($minutes)->getTimestamp())
			->leftJoin('users', config('session.table') . '.user_id', '=', 'users.id')
			->get();
	}
}
