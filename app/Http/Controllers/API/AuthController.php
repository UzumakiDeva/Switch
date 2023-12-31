<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\User;
use App\Models\UserLogin;
use Laravel\Passport\HasApiTokens;
use Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use App\Mail\EmailVerification;
use App\Mail\SendOtpVerification;
use Illuminate\Support\Str;
use App\Traits\GoogleAuthenticator;
use App\Models\GeneralSettings;
use App\Models\Country;

class AuthController extends Controller
{
    use HasApiTokens, GoogleAuthenticator;
    public $successStatus = 200;

    public function signup(Request $request)
    {

        $first_name = $request->first_name;
        $last_name  = $request->last_name;
        $email      = $request->email;
        $password   = $request->password;
        $passwordconfirmation = $request->passwordconfirmation;
        if ($first_name != "") {
            if ($last_name != "") {
                if ($email != "") {
                    if ($password != "") {
                        if ($passwordconfirmation != "") {
                            if ($password == $passwordconfirmation) {
                                $ifexits = User::where(['email' => $email])->count();

                                if ($ifexits == 0 || $ifexits == NULL) {
                                    $validator = Validator::make($request->all(), [
                                        'first_name' => 'required|regex:/^[\pL\s\-]+$/u|max:100',
                                        'last_name' => 'required|regex:/^[\pL\s\-]+$/u|max:100',
                                        'email'    => 'required|email|unique:users',
                                        'password' => 'required|string|min:8|max:16',
                                        'passwordconfirmation' => 'required|same:password',
                                        'referralid' => 'nullable|alpha_num|max:18',
                                    ]);
                                    if ($validator->fails()) {
                                        return response()->json(["success" => false, "result" => NULL, 'message' => $validator->errors()->first()], 200);
                                    }

                                    $secret1 = $this->createSecret();
                                    $rand = rand(100000, 999999);
                                    $role = 'individual';
                                    $referal_id = $this->generateBarcodeNumber();
                                    if ($request->referralid && $request->referralid != "") {
                                        $refid = $request->referralid;
                                        $result = User::where('referral_id', $refid)->first();
                                        if (empty($result)) {
                                            return response()->json(['success' => false, 'result' => NULL, 'message' => 'Invalid referral code!']);
                                        }
                                        $user = new User([

                                            'first_name' => $request->first_name,
                                            'last_name'   => $request->last_name,
                                            'email'       => $request->email,
                                            'password'    => bcrypt($request->password),
                                            'role'        => $role,
                                            'ipaddr'      => $request->ipaddr,
                                            'device'      => $request->device,
                                            'location'    => $request->location,
                                            'referral_id' => $referal_id,
                                            'parent_id'   => $result->referral_id,
                                            'profile_otp' => $rand,
                                            'google2fa_secret'  => $secret1,
                                            'type'        => 'app',
                                            'remember_token' => Str::random(60)
                                        ]);
                                    } else {
                                        $user = new User([

                                            'first_name' => $request->first_name,
                                            'last_name'   => $request->last_name,
                                            'email'       => $request->email,
                                            'password'    => bcrypt($request->password),
                                            'role'        => $role,
                                            'ipaddr'      => $request->ipaddr,
                                            'device'      => $request->device,
                                            'location'    => $request->location,
                                            'referral_id' => $referal_id,
                                            'profile_otp' => $rand,
                                            'google2fa_secret'  => $secret1,
                                            'type'        => 'app',
                                            'remember_token' => Str::random(60)
                                        ]);
                                    }
                                    $user->save();
                                    $this->sendEmail($user);
                                    // $token = $user->createToken('Oauth token')->accessToken;
                                    return response()->json(['success' => true, 'result' => $user, 'message' => 'Thanks for signing up! Please check your email to complete your registration.']);
                                } else {
                                    return response()->json(['success' => false, 'result' => NULL, 'message' => 'The Email ID has already been taken!']);
                                }
                            } else {
                                return response()->json(['success' => false, 'result' => NULL, 'message' => 'Password mismatch!']);
                            }
                        } else {
                            return response()->json(['success' => false, 'result' => NULL, 'message' => 'Password confirmation field required!']);
                        }
                    } else {
                        return response()->json(['success' => false, 'result' => NULL, 'message' => 'Password field required!']);
                    }
                } else {
                    return response()->json(['success' => false, 'result' => NULL, 'message' => 'Email field required!']);
                }
            } else {
                return response()->json(['success' => false, 'result' => NULL, 'message' => 'Last Name field required!']);
            }
        } else {
            return response()->json(['success' => false, 'result' => NULL, 'message' => 'First Name field required!']);
        }
    }
    public function codeNumberExists($number)
    {
        return User::where('referral_id', $number)->exists();
    }
    public function generateBarcodeNumber()
    {
        $number = 'SWITCH' . mt_rand(100000000, 999999999);
        if ($this->codeNumberExists($number)) {
            return $this->generateBarcodeNumber();
        }
        return $number;
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:8|max:16',
            'remember_me' => 'boolean',
            'ipaddr' => 'required',
            'device' => 'required',
            'location' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(["success" => false, 'result' => NULL, 'message' => $validator->errors()->first()], 200);
        }
        $credentials = request(['email', 'password']);
        // dd($credentials);
        if (!Auth::attempt($credentials))
            return response()->json([
                'success' => false,
                'result' => NULL,
                'message' => 'Email or Password Incorrect!',
                'kycstatus' => NULL,
                'twofactor' => NULL

            ], 200);
        $user = $request->user();
        //Twofa Condition
        if ($user->email_verify != 1) {
            return response()->json(['success' => false, 'result' => NULL, 'kycstatus' => NULL, 'twofactor' => NULL, 'message' => 'Email Not Verify']);
        }
        if ($user->twofa == NULL) {
            $twofa = " ";
        }
        $location = "";
        $ipaddr = "";
        if ($request->location == "") {
            $ip1 = $_SERVER['REMOTE_ADDR'];
            $details = json_decode(crul("http://ipinfo.io/{$ip1}/json"));
            if (isset($details->country)) {
                $location = $details->city . ', ' . $details->region . ', ' . $details->country;
            }
            $ipaddr = $ip1;
        }
        $usersave = User::where('id', '=',  Auth::user()->id)->first();
        if ($usersave->status == 1) {
            auth()->logout();
            return response()->json(['result' => '', 'success' => false, 'kycstatus' => NULL, 'twofactor' => NULL, 'message' => 'Your account has been deactivated'], 200);
        }

        $location = $request->location != "" ? $request->location : $location;
        $ipaddr = $request->ipaddr != "" ? $request->ipaddr : $ipaddr;
        $usersave->ipaddr = $ipaddr;
        $usersave->location = $location;
        $usersave->device = $request->device;
        $usersave->save();

        $UserLogin = Userlogin::isLogged(Auth::id(), $ipaddr, $location, $request->device);

        $tokenResult = $user->createToken($user->email);
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();

        $user_details = array(
            'first_name' => $usersave->first_name,
            'last_name' => $usersave->last_name,
            'email'     => $usersave->email,
            'email'     => $usersave->email,
            'kyc_verify' => $usersave->kyc_verify,
            'email_verify' => $usersave->email_verify,
            'sms_verify' => $usersave->phone_verified,
        );

        $success = [
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString(),
            'user_details' => $user_details
        ];

        $kyc = User::join('kyc', 'users.id', '=', 'kyc.uid')
            ->where('users.id', Auth::user()->id)
            ->select('kyc.*')
            ->latest()->first();


        if (isset($kyc)) {

            if (isset($kyc->status) &&  $kyc->status == 0) {

                $kycstatus['status'] = "KYC not submitted";
                $kycstatus['value']  = 0;
            } elseif (isset($kyc->status) &&  $kyc->status == 1) {
                $kycstatus['status'] = "KYC Verified";
                $kycstatus['value']  = 1;
            } elseif (is_object($kyc) && isset($kyc->status) && $kyc->status == 2) {
                $kycstatus['status'] = "KYC Waiting for approval";
                $kycstatus['value']  = 2;
            } else if (is_object($kyc) && isset($kyc->status) && $kyc->status == 3) {
                $kycstatus['status'] = "KYC rejected please re-submit";
                $kycstatus['value'] = 3;
            }
        } else {
            $kycstatus['status'] = "KYC not submitted";
            $kycstatus['value']  = 0;
        }

        $otpcheck = User::where('id', '=',  Auth::user()->id)->first();

        if ($otpcheck->twofa == 'email_otp') {
            $rand = rand(100000, 999999);

            $otpcheck->profile_otp = $rand;
            $otpcheck->save();

            \Mail::to($user->email)->send(new SendOtpVerification($rand));

            $msg =  'Login successfully Check your email or Spam OTP!';
        } else {
            $msg = 'Login successfully!';
        }
        $result = array();
        $result['type'] =  Auth::user()->twofa != "" ? Auth::user()->twofa : "";
        $result['image'] =  "";
        $result['secret'] =  "";


        if ($user->twofa == 'google_otp') {
            $sitename = config('app.name');
            $secret = Auth::user()->google2fa_secret;
            $QR_Image = $this->getQRCodeGoogleUrl($sitename . '-(' . \Auth::user()->email . ')', $secret);

            if ($user->google2fa_verify != 1) {
                $result['image']  =  $QR_Image;
                $result['secret'] =  $secret;
            }
        }
        return response()->json(['success' => true, 'result' => $success, 'kycstatus' => $kycstatus, 'twofactor' => $result, 'message' => $msg], $this->successStatus);
    }
    public function resetPassword(Request $request)
    {
        $credentials = $request->only('email');
        $rules = [
            'email' => 'required|email',
        ];
        $validator = Validator::make($credentials, $rules);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'result' => '', 'message' => $validator->messages()]);
        }
        $email = $request->email;
        $otp  = rand(100000, 999999);
        if ($email) {
            $forgetsecurity = User::where('email', $email)->first();
            if ($forgetsecurity) {
                $profile_upload = User::where(['email' => $email])->update(['profile_otp' => $otp]);
                $thisUser = User::findOrFail($forgetsecurity->id);
                $this->forgetsendEmail($thisUser);
                return response()->json(['result' => $otp, 'success' => true, 'message' => 'Please check your Email OTP!'], 200);
            } else {
                $success['error'] = '';
                return response()->json(['result' => '', 'success' => false, 'message' => 'Email does not exist!'], 200);
            }
        }
    }
    public function forgetsendEmail($thisUser)
    {
        try {
            Mail::send('email.sendEmailOtp', ['user' => $thisUser->profile_otp], function ($message) use ($thisUser) {
                $message->subject("Reset Password");
                $message->to($thisUser['email']);
            });
        } catch (Exception $e) {
            dd($e);
        }
    }
    public function changeResetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'     => 'required|email',
            'otp'       => 'required|numeric',
            'password'  => 'required|string|min:8|max:16',
            'confirmpassword' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return response()->json(["success" => false, 'result' => '', 'message' => $validator->errors()->first()], 200);
        }

        $email  = $request->email;
        $otp    = $request->otp;
        $password  = $request->password;
        //Change Password
        $user = User::where('email', $email)->first();
        //$user = Auth::user();
        //
        if ($user != "") {
            if ($user->profile_otp == $otp) {
                $user->password = bcrypt($request->password);
                $user->save();
                return response()->json(['result' => '', 'success' => true, 'message' => 'Password changed successfully!'], 200);
            } else {
                return response()->json(['result' => '', 'success' => false, 'message' => 'OTP Mismatch!'], 200);
            }
        } else {
            return response()->json(['result' => '', 'success' => false, 'message' => 'Email doesn`t exits!'], 200);
        }
    }
    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'current_password' => 'required',
            'new_password' => 'min:8|max:16|required_with:confirm_password|same:confirm_password|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
            'confirm_password' => 'min:8|max:16|same:new_password'
        ]);
        $user = Auth::user();

        $current_password = $request->current_password;
        $new_password = $request->new_password;
        $confirm_password = $request->confirm_password;
        $input_password = $user->password;

        if (crypt($current_password, $input_password) == $input_password) {
            if ($new_password == $confirm_password) {
                $password = bcrypt($new_password);
                $update = User::where('id', '=', $user->id)->update(['password' => $password]);
                if ($update) {

                    $password_success_response = 'Password Changed Successfully!';
                    return Response()->json(['result' => '', 'success' => true, 'message' => 'Password Changed Successfully!'], 200);
                } else {
                    $password_failed_response = 'Password Not Updated!';
                    return Response()->json(['result' => '', 'success' => false, 'message' => 'Password Not Updated!']);
                }
            } else {
                $password_failed_response = 'Password length should be minimum 8!';
                return Response()->json(['passwordnotupdated' => $password_failed_response]);
            }
        } else {
            $password_failed_response = 'You entered wrong current password!';
            return Response()->json(['passwordnotupdated' => $password_failed_response]);
        }
    }
    public function logout(Request $request)
    {
        // dd($request);
        $request->user()->token()->revoke();
        return response()->json([
            'success' => true,
            'result' => '',
            'message' => 'Successfully logged out'
        ]);
    }
    public function user(Request $request)
    {
        return response()->json($request->user());
    }
    public function signupActivate($token)
    {
        $user = User::where('activation_token', $token)->first();
        if (!$user) {
            return response()->json([
                'message' => 'This activation token is invalid.'
            ], 404);
        }
        $user->email_verify = 1;
        $user->activation_token = '';
        $user->save();
        \Session::flash('status', 'Verification Success!. activated your account login now');
        $url = "https://naijacrypto.com";
        return redirect($url . 'login');
    }
    public function sendEmail($thisUser)
    {
        try {
            Mail::to($thisUser['email'])->send(new EmailVerification($thisUser));
        } catch (Exception $e) {
            dd($e);
        }
    }
    public function ReconfirmAccount(Request $request)
    {

        $credentials = $request->only('email');
        $rules = [
            'email' => 'required|string|email',
        ];
        $validator = Validator::make($credentials, $rules);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'result' => '', 'message' => $validator->messages()->first()]);
        }
        $email = $request->email;
        $check = User::where('email', $email)->first();
        if ($check) {
            $this->sendEmail($check);
            return response()->json(['result' => '', 'success' => true, 'message' => 'You need to confirm your account. We have sent you an resent activation code, please check your email'], 200);
        } else {
            return response()->json(['result' => '', 'success' => false, 'message' => 'Invalid email id, please check your email'], 200);
        }
    }
    protected function refreshToken(Request $request)
    {
        $request->request->add([
            'grant_type' => 'refresh_token',
            'refresh_token' => $request->refresh_token,
            'client_id' => $this->client->id,
            'client_secret' => $this->client->secret,
            'scope' => ''
        ]);

        $proxy = Request::create(
            'oauth/token',
            'POST'
        );

        return \Route::dispatch($proxy);
    }
    public function refresh(Request $request)
    {
        $http = new Client();

        $response = $http->post(env('APP_URL') . '/oauth/token', [
            'form_params' => [
                'grant_type'    => 'refresh_token',
                'client_id'     => env('PASSWORD_CLIENT_ID'),
                'client_secret' => env('PASSWORD_CLIENT_SECRET'),
                'refresh_token' => $request->cookie(self::REFRESH_TOKEN),
                'scope'         => '*',
            ],
        ]);

        $data = json_decode((string)$response->getBody(), true);

        return response()->json([
            'access_token' => $data['access_token'],
            'expires_in'   => $data['expires_in']
        ])->cookie(self::REFRESH_TOKEN, $data['refresh_token'], self::COOKIE_LIFETIME);
    }
    public function countryList()
    {
        $country = Country::get();

        return response()->json(["success" => true, 'result' =>  $country, 'message' => ""], $this->successStatus);
    }
    public function osVersion()
    {
        $version = GeneralSettings::where('key', 'osversion')->value('description');
        return response()->json(["success" => true, 'result' =>  $version, 'message' => "success"], $this->successStatus);
    }
}
