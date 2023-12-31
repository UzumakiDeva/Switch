<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\UserOld;
use App\Traits\GoogleAuthenticator;
use App\Models\Country;
use App\Models\Tradepair;
use App\Models\GeneralSettings;

class HomeController extends Controller
{
    use GoogleAuthenticator;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function p2ptrade()
    {
        return view('p2pmarket.markettrade');
    }
    public function landing()
    {
        $trades = Tradepair::where(['active' => 1, 'is_spot' => 1])->orderBy('orderlist','Asc')->get();
        return view('welcome',['trades' => $trades]);
    }
    public function importUser(){
        $oldUsers = UserOld::orderBy('id', 'asc')->get();
        foreach($oldUsers as $oldUser){
            $secret1 = $this->createSecret();
            $referal_id = $this->generateBarcodeNumber();
            echo $oldUser->id;
            $is_exits = User::where('email',$oldUser->email)->first();
            if(!is_object($is_exits)){
                $user = new User;
                $user->role = $oldUser->role;
                $user->first_name = $oldUser->first_name;
                $user->last_name = $oldUser->last_name;
                $user->email = $oldUser->email;
                $user->password = $oldUser->password;
                $user->phone_country = $oldUser->phone_country;
                $user->phone_no = $oldUser->phone;
                $user->phone_verified = $oldUser->phone_verified;
                $user->google2fa_secret = $oldUser->secret1;
                $ctry = Country::where('code',$oldUser->country)->first();
                if(is_object($ctry)){
                    $user->country = $ctry->id;
                }            
                $user->nationality = $oldUser->nationality;
                $user->dob = $oldUser->dob;
                $user->email_verify = $oldUser->email_verified;
                $user->company_type = $oldUser->company_type;
                $user->business_name = $oldUser->business_name;
                $user->business_country = $oldUser->business_country;
                $user->business_email = $oldUser->business_email;
                $user->business_first_name = $oldUser->business_first_name;
                $user->business_middle_name = $oldUser->business_middle_name;
                $user->business_last_name = $oldUser->business_last_name;
                $user->referral_id = $referal_id;
                $user->save();
            }
        }
        dd('DOne');
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
    public function form_referral(Request $request)
    {
        $validator = $this->validate($request, [
            'referral_code' => 'required|max:18',
        ]);

        $referral_code= $request->referral_code;
        if($referral_code !="")
        {
            $User  = User::where('referral_id',$referral_code)->value('first_name');
            if($User){
                $var =  \Response::json(array(
                    'status' => true,
                    'res' => $User
                ));
            }else{
                $var =  \Response::json(array(
                    'status' => false,
                    'res' => 'Invalid referral code'
                ));
            }
        }else{
            $var =  \Response::json(array(
                'status' => false,
                'res' => 'Invalid referral code'
            ));
        }
        return $var;
    }
    public function show($key)
    {
        $Content = GeneralSettings::Where('key',$key)->first();
        if(!$Content)
        {
          return abort(404);  
        }   
        return view('cms.cmscontent',['Content'=>$Content]);
    }
}
