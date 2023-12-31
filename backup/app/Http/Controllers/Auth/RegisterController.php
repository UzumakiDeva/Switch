<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Auth;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Traits\GoogleAuthenticator;
use App\Mail\EmailVerification;
use Illuminate\Support\Str;
use Mail;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers,GoogleAuthenticator;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/registersuccess';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed','regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/'],
            'referralid' => 'nullable|alpha_num|max:18',
            'g-recaptcha-response' => 'required|captcha',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $secret1 = $this->createSecret();
        $referal_id = $this->generateBarcodeNumber();
        $role = 'personal';
        \Session::flash('status', 'Thanks for signing up. Please confirm your email address to activate your account. Check Inbox/Spam folder for Activation Link.');
        if(isset($data['referralid']) && $data['referralid'] !=""){
            $result = User::where('referral_id', $data['referralid'])->first();
            if(empty($result)){  
                \Session::flash('error', 'Invalid referral code!');
                return redirect('register');
            }
            $user =  User::create([
                'role'  => $role,
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'referral_id'  => $referal_id,
                'password' => Hash::make($data['password']),
                'google2fa_secret'  => $secret1,
                'parent_id'     => $data['referralid']
            ]);
        }else{
            $user =  User::create([
                'role'  => $role,
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'referral_id'  => $referal_id,
                'password' => Hash::make($data['password']),
                'google2fa_secret'  => $secret1,
            ]);
        }
        \Session::put('successemail', $user->email);
        $thisUser = User::findOrFail($user->id);
        $this->sendEmail($thisUser); 
        return $user;
    }
    
    public function sendEmail($thisUser)
    {
        try {
            Mail::send('email.sendEmail', ['user' => $thisUser], function($message) use ($thisUser) {                
                $message->subject("Account Activation");
                $message->to($thisUser['email']);
            });
        } catch (Exception $e){
        dd($e);
        }
    }

    public function res($referral_code)
    {

        $result = User::where('referral_id', $referral_code)->first();
        if($result != "")
        {
            return view('/auth.register',[
            'referral_code' => $result['referral_id'],
            'name' => $result['first_name'].' '.$result['last_name'],
            ]);  
        }
        else
        {
            \Session::flash('error', 'Invalid referral code!');
             return redirect('/register');
        }     

    }
    public function codeNumberExists($number) {
        return User::where('referral_id',$number)->exists();
    }
    public function generateBarcodeNumber() {
        $number = 'PANTH'.mt_rand(100000000, 999999999);
        if ($this->codeNumberExists($number)) {
            return $this->generateBarcodeNumber();
        }
        return $number;
    }
}
