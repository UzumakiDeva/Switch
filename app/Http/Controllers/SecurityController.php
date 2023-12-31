<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Models\Kyc;
use App\Mail\SendOtpVerification;
use Auth;
use Mail;
use App\Models\CMS;

class SecurityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


   	public function index()
    {
    	$user = Auth::user();       
        $user_id = Auth::user()->id;
        $userdata = User::where(['id' => $user_id])->first();
        $kyc_data = Kyc::where(['uid' => $user_id])->orderBy('kyc_id', 'desc')->first();
        $kyc_enable = CMS::value('kyc_enable');

        if($user->twofa!="" && $user->kyc_verify == 1 && \Session::get('otpstatus') == 1){
            return redirect('/trade');
        }
        return view('security', ['user' => $userdata, 'kyc_data' => $kyc_data,'kyc_enable' => $kyc_enable]);
    }
    public function dashboard()
    {
        $user_id = Auth::user()->id;
        $security = Auth::user();
        if(is_null($security))
        {
            auth()->logout();
            return back()->with('success', 'You need to confirm your account. We have sent you an activation code, please check your email.');
        }
        elseif($security->status == 1)
        {
            auth()->logout();
            return back()->with('error', 'Your account has been deactivated for the '. $security->reason);

        }
        elseif($security->twofa !="" ){
            if($security->twofa_status == 0){
                \Session::put('otpstatus', 1);
                return redirect('/trade');
            }           
            else if($security->twofa == 'email_otp')
            {
                $user = Auth::user();
                $rand = rand(100000,999999);
                $security->profile_otp = $rand;
                $security->save();
                try 
                {
                    \Session::flash('status', 'Check your email inbox/spam folder for verification code!.');   

                    \Mail::to($user->email)->send(new SendOtpVerification($rand));
                   // dd($user->email);
                    return redirect()->route('twofaotp');
                } 
                catch (Exception $e)
                {
                    dd($e);
                }
            } elseif($security->twofa == 'google_otp'){
                if($security->google2fa_verify == 3){
                    \Session::put('otpstatus', 1);
                    return redirect('/trade');
                }else{
                    return redirect()->route('twofaotp');
                }
            }else{
                \Session::put('otpstatus', 1);
                return redirect('/trade');
            }
        }else{
            \Session::put('otpstatus', 1);
            return redirect('/trade');
        }
    }
}
