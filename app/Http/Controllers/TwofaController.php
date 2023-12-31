<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use App\User;
use Auth;
use App\Traits\GoogleAuthenticator;

use App\Mail\SendOtpVerification;

class TwofaController extends Controller
{
    use GoogleAuthenticator;
    public function __construct()
    {
        $this->middleware('auth');
    }
   	public function index()
    {
        $user = Auth::User();
        return view('2faverification', ['user_details' => $user]);
    }

    public function verifyGoogleTwoFactor(Request $request) {
        $this->validate($request, [
            'google_code' => 'required|numeric'
        ]);      

        $user = Auth::user();
        
        $secret = $user->google2fa_secret;
        $one_time_password = $request->google_code;
        $oneCode = $this->getCode($secret);
        $data = $this->verifyCode($secret, $one_time_password, 2);
        if($data){
            $user->twofa = 'google_otp';
            $user->google2fa_verify = 1;
            $user->twofa_status = 1;
            $user->save();
            \Session::put('otpstatus', 1);
            \Session::flash('twofasuccess', 'Successfully enabled 2FA.');
            return redirect('myprofile')->with('twofasuccess','Successfully enabled 2FA.');
        } else {
            \Session::flash('twofafail', 'You entered wrong google code. Please scan above QR Code again!');
            return redirect('myprofile')->with('twofafail','You entered wrong google code. Please scan above QR Code again!');
        }
    }
    public function enableEmailOTP(Request $request) {
        $this->validate($request, [
            'email_code' => 'required|numeric'
        ]);      

        $user = Auth::user();
        
        $secret = $user->profile_otp;
        $one_time_password = $request->email_code;
        if($secret == $one_time_password){
            $user->twofa = 'email_otp';
            $user->twofa_status = 1;
            $user->profile_otp = null;
            $user->save();
            \Session::put('otpstatus', 1);
            \Session::flash('twofasuccess', 'Successfully enabled 2FA.');
            return redirect('myprofile')->with('twofasuccess','Successfully enabled 2FA.');
        } else {
            \Session::flash('twofafail', 'You entered wrong E-mail code. Check your recent email inbox/spam folder for verification code!!');
            return redirect('myprofile')->with('twofafail','You entered wrong E-mail code. Check your recent email inbox/spam folder for verification code!!');
        }
    }
    public function enableTwofactor($type)
    {
        $twofa = \Crypt::decrypt($type);
        $user = Auth::user();
        if($twofa == 'google'){
            if($user->twofa_status == 0){
                $secret = $this->createSecret();
            }else{
                $secret = $user->google2fa_secret;
            }
            $user->twofa = 'google_otp';
            $user->twofa_status = 1;
            $user->google2fa_verify = 0;
            $user->google2fa_secret = $secret;
            $user->save();
            return redirect()->route('twofaotp')->with('success',__('message.Googletwofa'));
        }else if($twofa == 'email'){
            $user->twofa = 'email_otp';
            $user->twofa_status = 1;
            $user->save();
            return redirect('/profile')->with('success',__('message.EmailTwofactor'));
        }else{
            return redirect('/2faverification')->with('error',__('message.Invalidrequest'));
        }
    }

    public function viewOtppage(){
        $user = Auth::user();
        $data = array();
        if($user->twofa =='google_otp'){
            $data['type'] = 'Google';
            $data['heading'] = 'Google Verification';
            if($user->google2fa_verify == 0){
                $secret = $user->google2fa_secret;
                $sitename = seoUrl(config('app.name'));
                $QR_Image = $this->getQRCodeGoogleUrl($sitename.'-('.$user->email.')', $secret);
                $user->twofa = 'google_otp';
                $user->twofa_status = 1;
                $user->save();
            }
        }else if($user->twofa == 'email_otp'){
            $data['type'] = 'Email';
            $data['heading'] = 'Email Verification';
        }else{
            return redirect('2faverification')->with('success',__('message.Pleaseenabletwoverification'));
        }
        return view('twofaotp', ['data' => $data]);
    }

    public function validateOTP(Request $request){
        $this->validate($request, [
            'OTP' => 'required|numeric'
        ]);
        $user = Auth::user();
        $otp = $request->OTP;
        if($user->twofa =='google_otp'){            
            $secret = $user->google2fa_secret;
            $oneCode = $this->getCode($secret);
            $data = $this->verifyCode($secret, $otp, 2);
            if($data){
                if($user->google2fa_verify == 0){
                    $user->google2fa_verify = 1;
                    $user->twofa_status = 1;
                    $user->save();
                }
                \Session::put('otpstatus', 1);
                return redirect('/trade');
            } else {
                return redirect()->route('twofaotp')->with('twofafail','You entered wrong google code.');
            } 
        }else{
            if($user->profile_otp == $otp){
                $rand = rand(100000,999999);
                $user->profile_otp = $rand;
                $user->save();
                \Session::put('otpstatus', 1);
                return redirect('/trade');
            }else {                
                \Session::flash('error', __('message.Youenteredwrongemailcode'));
                return redirect()->route('twofaotp')->with('twofafail','You entered wrong email code.');
            }
        }
    }

    public function reSendEmail()
    {
        $user = Auth::User();
        $rand = rand(100000,999999);
        $user->profile_otp = $rand;
        $user->save();
        try 
        {
            \Session::flash('emailstatus', 'Check your email inbox/spam folder for verification code!.');
            \Mail::to($user->email)->send(new SendOtpVerification($rand));
           // dd($user->email);
            return redirect()->back()->with('emailstatus', 'Check your email inbox/spam folder for verification code!.');
        } 
        catch (Exception $e)
        {
            dd($e);
        }
    }

    public function diableTwoFactor(){
        $user = Auth::user();
        if($user->twofa_status == 1){
            $user->twofa_status = 0;
            $user->twofa = NULL;
            $user->save();
            return redirect('myprofile')->with('twofasuccess',__('message.Pleaseenabletwoverification'));
        }else{
            return redirect('myprofile')->with('twofasuccess',__('message.Something'));
        }
    }

}
