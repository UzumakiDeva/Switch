<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; 
use App\Traits\GoogleAuthenticator;
use Mail;
use App\Mail\EmailVerification;
use App\Mail\SendOtpVerification;
use Validator;
use Session;
use App\User;
use App\Models\Kyc;
use App\Models\Bankuser;

class UserController extends Controller 
{   
    use GoogleAuthenticator; 
    public $successStatus = 200;

    public function enableTwofactor(Request $request)
    {   
        $validator = Validator::make($request->all(), [
            'twofa'  => 'required',
        ]);
        if ($validator->fails()) { 
            return response()->json(["success" => false,'result' => NULL,'message'=> $validator->errors()->first()], 200);           
        }
        $twofa =$request->twofa;
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
            return response()->json(['success'=>true ,'result'=>$secret ,'message'=>'Google Two factor authentication enable']);
        }else if($twofa == 'email'){
            $user->twofa = 'email_otp';
            $user->twofa_status = 1;
            $user->save();
            return response()->json(['success'=>true ,'result'=>NULL ,'message'=>'Email Two factor authentication enable']);
        }else{
            return response()->json(['success'=>false ,'result'=>NULL ,'message'=>'']);
        }
    }
    public function diableTwoFactor(){
        $user = Auth::user();
        if($user->twofa_status == 1){
            $user->twofa_status = 0;
            $user->save();
            return response()->json(['success'=>true ,'result'=>NULL,'message'=>'Two Factor authentication disbled']);     
           }
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
                return response()->json(['success'=>true,'result'=>NULL,'message'=>'OTP verified']);
            } else {
                return response()->json(['success'=>false,'result'=>NULL,'message'=>'OTP mismatch']);
            } 
        }else{
            if($user->profile_otp == $otp){
                $rand = rand(100000,999999);
                $user->profile_otp = $rand;
                $user->save();
                return response()->json(['success'=>true,'result'=>NULL,'message'=>'OTP verified']);
            }else {                
                return response()->json(['success'=>false,'result'=>NULL,'message'=>'OTP mismatch']); 
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
            \Mail::to($user->email)->send(new SendOtpVerification($rand));
            return response()->json(['emailstatus', 'Check your email inbox/spam folder for verification code!.']);
        } 
        catch (Exception $e)
        {
            dd($e);
        }
    }
    public function profileUpdate(Request $request) 
    { 
        $uid = Auth::id(); 
        $validator = Validator::make($request->all(), [
            'first_name'  => 'nullable|regex:/^[\pL\s\-]+$/u|max:100',
            'last_name'  => 'nullable|regex:/^[\pL\s\-]+$/u|max:100',
            'phone_no'  => 'nullable|max:15',
            'nationality' =>'nullable|regex:/^[\pL\s\-]+$/u|max:100',
            'phone_country' =>'nullable|max:20',
            'dob' => 'nullable',
        ]);
        if ($validator->fails()) { 
            return response()->json(["success" => false,'result' => NULL,'message'=> $validator->errors()->first()], 200);           
        }
        $user = User::where('id',$uid)->first();
        if(isset($request->first_name)){
            $user->first_name = $request->first_name;
        }
        if(isset($request->last_name)){
            $user->last_name = $request->last_name;
        }
        if(isset($request->phone_no)){
            $user->phone_no = $request->phone_no;
        }
        if(isset($request->nationality)){
            $user->nationality = $request->nationality;
        }
        if(isset($request->phone_country)){
            $user->phone_country = $request->phone_country;
        }
        if(isset($request->dob)){
            $user->dob = date('Y-m-d', strtotime($request->dob));
        } 
        $user->save();
        return response()->json(["success" => true,'result' => $user,'message'=> ""], $this-> successStatus); 
    } 
    public function details() 
    { 
        $uid = Auth::id();
        $user = User::where('id',$uid)->first();

        if($user->kyc_verify == 0){
            $kyc_status      ="KYC not submitted";
        }else if($user->kyc_verify == 1){
          $kyc_status      ="KYC Verified";  
        }else if($user->kyc_verify == 2){
          $kyc_status     ="KYC Waiting for approval";  
        }else if($user->kyc_verify == 3){
          $kyc_status     ="KYC rejected please re-submit";  
        }else{
            $kyc_status      =" ";
        }
          
         $data =array();
         $data['first_name'] =$user->first_name;
         $data['last_name']  =$user->last_name;
         $data['email']      =$user->email;
         $data['phone_country']      =$user->phone_country;
         $data['phone_no']      =$user->phone_no;
         $data['country']      =$user->country;
         $data['nationality']      =$user->nationality;
         $data['dob']      =$user->dob;
         $data['profileimg']      =$user->profileimg;
         $data['address']      =$user->address;
         $data['twofa']      =$user->twofa;
         $data['twofa_status']      =$user->twofa_status;
         $data['google2fa_secret']      =$user->google2fa_secret;
         $data['google2fa_verify']      =$user->google2fa_verify;
         $data['email_verify']      =$user->email_verify;
         $data['kyc_verify']      =$user->kyc_verify;
         $data['kyc_status']      =$kyc_status;
         $data['referral_id']      =$user->referral_id;
         $data['parent_id']      =$user->parent_id;
                   
        return response()->json(["success" => true,'result' => $data,'message'=> ""], $this->successStatus); 
    }
    public function userblock(){
        
        $uid = Auth::id();
        $user =User::where(['id'=>$uid])->first();
        if($user){
            User::where(['id'=> $uid])->update(['status' => 1]);
            return response()->json(['result'=> '','success' => true,'message' => 'Account  Deactivated Successfully'], 200);
        }      
    } 
    public function profileImage(Request $request)
    {
        $credentials = $request->only('profileimg');
        $rules = [
            'profileimg' => 'required|file|max:5120|mimes:jpg,png,jpeg,PNG,Png'
        ];
        $validator = Validator::make($credentials, $rules);
        if($validator->fails()) 
        {
            return response()->json(['success'=> '', 'message'=> $validator->messages()->first(),'result' => ''],200);
        }

        $security = User::where('id', Auth::id())->first();
  
        if(imgvalidaion($_FILES['profileimg']['tmp_name']) == 1)
        {    

            if($request->hasFile('profileimg')){
                $dir = 'userprofile/';
                $path = 'storage' . DIRECTORY_SEPARATOR .'app'. DIRECTORY_SEPARATOR.'public'. DIRECTORY_SEPARATOR. $dir;
                $location = 'public' . DIRECTORY_SEPARATOR .'storage'. DIRECTORY_SEPARATOR. $dir;

                $fornt = $request->File('profileimg');//
                $filenamewithextension = $fornt->getClientOriginalName();
                $photnam = str_replace('.','',microtime(true));
                $filename = pathinfo($photnam, PATHINFO_FILENAME);
                $extension = $fornt->getClientOriginalExtension();
                $photo = $filename.'.'. $extension;
                $fornt->move($path, $photo);
                $back_img = $path.$photo;

                $kyc_update=User::where(['id' => $security->id])->update(['profileimg' => url($back_img)]);

                $user=User::where(['id' => $security->id])->first();
                return response()->json(['success'=> true,'result' =>url( $back_img),'message' => 'Profile Picture Updated Successfully!'], 200);
            }else{
                return response()->json(['success'=> false,'result' => '','message' => 'Try again!'], 200);
            }
        }else{
            return response()->json(['success'=> false,'result' => '','message' => 'Unwanted images are cannot approved'], 200);
        }        
    }
       
    public function sendOTP(Request $request)
    {
        $validator = Validator::make($request->all(), [
          'type' => 'required|in:email,sms',
        ]);
        if ($validator->fails()) { 
            return response()->json(["success" => false,'result' => NULL,'message'=> $validator->errors()->first()], 200);           
        }
        $user = Auth::user();
        $type = $request->type;
        $Param = array('type' => strtolower($type));
        $otp  = rand(100000,999999);
        if(isset($user)){
        $data = $user;
        $profile_upload = User::where(['email' => $data->email])->update(['profile_otp' => $otp]);

        try{
        Mail::to($data['email'])->send(new SendotpVerification($otp));
        } catch(Exception $e){
            dd($e);
        }

        if($type == 'email'){
            return response()->json(['success' => true,'result' => NULL, 'message' => 'Email successfully send to '.$data->email]);
        }else{
            return response()->json(['success' => true,'result' => NULL, 'message' => 'SMS successfully send to '.$data->phone_number]);
        }        
        }else{
        return response()->json(['success' => false,'result' => NULL, 'message' =>'']);
        }
    }
    public function sendEmail($thisUser)
    {
        try {
            Mail::to($thisUser['email'])->send(new SendOtpVerification($thisUser));
        } catch (Exception $e){
            dd($e);
        }
    }

    public function verifyOTP(Request $request)
    {
        $validator = Validator::make($request->all(), [
          'OTP' => 'required|numeric',
          'type' => 'required|in:email,google',
        ]);
        if ($validator->fails()) { 
        return response()->json(["success" => false,'result' => NULL,'message'=> $validator->errors()->first()], 200);           
        }
        $user = Auth::user();
        $type = $request->type;
        if($type =='email'){
            $profile_otp =$user->profile_otp;
        }
        if($type == 'google'){
            $profile_otp =$user->google2fa_secret;
        }
        $otp = $request->OTP;
        if($profile_otp == $otp){
        if($type == 'email'){  
          User::where(['id' => $user->id])->update(['email_verify'=> 1,'email_verified_at' => date('Y-m-d H:i:s',time())]);
          return response()->json(['success' => true,'result' => NULL, 'message' => "Email successfully verified!"]);
        }else{
          User::where(['id' => $user->id])->update(['google2fa_verify' => 1]);
        //   Kyc::where('uid',$user->id)->update(['status' => 1]);
          return response()->json(['success' => true,'result' => NULL, 'message' => "Google secret successfully verified"]);
        }        
        }else{
        return response()->json(['success' => false,'result' => NULL, 'message' => 'OTP mismatch']);
        }
    }
    public function changePassword(Request $request)
    {
        // dd($request);
        $validator = Validator::make($request->all(), [
           'current-password' => 'required',
            'new-password' => 'required|string|min:8|max:16',
            'confirm-password' => 'required|same:new-password'
        ]);    

        $rules = [
            'current-password' => 'required',
            'new-password' => 'required|string|min:8|max:16',
            'confirm-password' => 'required|same:new-password'
        ];

        $messages = [
        'current-password.required' => 'Current Password is required.',
        'new-password.required' => 'New Password is required.',
        'new-password.regex' => 'Password should contain at least 1 of a-z and A-Z and number and special character.',
        'confirm-password.required' => 'Confirm Password is required.',
        'confirm-password.regex' => 'Password should contain at least 1 of a-z and A-Z and number and special character.',
        ];
        $validator = \Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(),'success'=> false,'result' => ''], 200);
        }  

        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            response()->json(['success'=> false,'result' => '','message'=> 'Your current password does not matches with the password you provided. Please try again.!'], 200);
        }

        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            //Current password and new password are same
            response()->json(['result'=> '','success' => false,'message' => 'New Password cannot be same as your current password. Please choose a different password.'], 200);
        }     
        $user = Auth::user();
        $currentpassword = $request->get('current-password'); 
        $dbpassword = $user->password;
        // dd($currentpassword ,$dbpassword);
        $uid =$user->id;

        if(crypt($currentpassword, $dbpassword) == $dbpassword)
        {
            //Change Password
            $user = Auth::user();
            $user->password = bcrypt($request->get('new-password'));
            $user->save();

          return response()->json(['result'=> '','success' => true,'message' => 'Password changed successfully !'], 200);
        }
        else
        {
            return response()->json(['result'=> '','success' => false,'message' => 'Current password does not match!'], 200);
        }       

    }
    public function update_kyc(Request $request)
    { 

        $uid =Auth::user()->id;
        $kycdetail =Kyc::where(['uid' =>$uid])->first();
         if($kycdetail){
           if( $kycdetail->status =='1'){
            return response()->json(["success" => false,'result' =>"",'message'=> "KYC details Already Added"], 200); 
           }
           else if($kycdetail->status == '0'){
            $res['id'] = $kycdetail->id;
            return response()->json(["success" =>false,'result' =>$res,'message'=> "Please Upload Your ID Front Image"], 200); 
           }
         }
         
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|regex:/^[\pL\s\-]+$/u|max:30',
            'last_name' => 'required |regex:/^[\pL\s\-]+$/u|max:30',
            'dob' => 'required|date|before:-18 years',
            'city' => 'required |regex:/^[\pL\s\-]+$/u|max:30',
            'country' => 'required |regex:/^[\pL\s\-]+$/u|max:30',
            'id_type' => 'required',
            'id_number' => 'required |regex:/^[a-z\d\-_\s]+$/i|max:50',
            'id_exp' => 'required|date',
        ]);
        if ($validator->fails()) { 
            return response()->json(["success" => false,'result' => NULL,'message'=> $validator->errors()->first()], 200);           
        }

        $kyc = new Kyc;
        $kyc->uid = Auth::user()->id;
        $kyc->fname = $request->input('first_name');
        $kyc->lname = $request->input('last_name');
        $kyc->dob = date('Y-m-d', strtotime($request->input('dob')));
        $kyc->city = $request->input('city');
        $kyc->country = $request->input('country');
        $kyc->id_type = $request->input('id_type');
        $kyc->id_number = $request->input('id_number');
        $kyc->id_exp = date('Y-m-d', strtotime($request->input('id_exp')));
        $kyc->status = 0; 
        $kyc->save();

        $res['id'] = $kyc->id;

        return response()->json(["success" => true,'result' => $res,'message'=> "KYC details updated, Please upload id proof!"], 200); 
     
    }
    public function front_upload_id(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kycid' => 'required',
            'front_upload_id' => 'required|mimes:jpeg,jpg,png|max:5120',
        ]);
        if ($validator->fails()) { 
            return response()->json(["success" => false,'result' => "",'message'=> $validator->errors()->first()], 200);           
        }

        if($this->imgvalidaion($_FILES['front_upload_id']['tmp_name']) == 1)
        {
            if($request->hasFile('front_upload_id')){
                $dir = 'kyc/';
                $path = 'storage' . DIRECTORY_SEPARATOR .'app'. DIRECTORY_SEPARATOR.'public'. DIRECTORY_SEPARATOR. $dir;
                $location = 'public' . DIRECTORY_SEPARATOR .'storage'. DIRECTORY_SEPARATOR. $dir;

                $fornt = $request->File('front_upload_id');//
                $filenamewithextension = $fornt->getClientOriginalName();
                $photnam = str_replace('.','',microtime(true));
                $filename = pathinfo($photnam, PATHINFO_FILENAME);
                $extension = $fornt->getClientOriginalExtension();
                $photo = $filename.'.'. $extension;
                $fornt->move($path, $photo);
                $front_img = $location.$photo;
            }
                
            $kycid= $request->input('kycid');           
            $kyc = new Kyc;
            $kyc->where('id', '=', $kycid)->update(['front_img' => url($front_img), 'status' => 0]);
            return response()->json(["success" => true,'result' => url($front_img),'message'=> "Front Image Updated Successfully!"], 200); 
        }
        else
        {
            return response()->json(["success" => false,'result' => "",'message'=> "Something went wrong try again!"], 200);
        }
     
    }
    public function back_upload_id(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kycid' => 'required',
            'back_upload_id' => 'required|mimes:jpeg,jpg,png|max:5120',
        ]);
        if ($validator->fails()) { 
            return response()->json(["success" => false,'result' => "",'message'=> $validator->errors()->first()], 200);           
        }

        if($this->imgvalidaion($_FILES['back_upload_id']['tmp_name']) == 1)
        {
            if($request->hasFile('back_upload_id')){
                $dir = 'kyc/';
                $path = 'storage' . DIRECTORY_SEPARATOR .'app'. DIRECTORY_SEPARATOR.'public'. DIRECTORY_SEPARATOR. $dir;
                $location = 'public' . DIRECTORY_SEPARATOR .'storage'. DIRECTORY_SEPARATOR. $dir;
                $back = $request->File('back_upload_id');

                $filenamewithextension = $back->getClientOriginalName();
                $backname = str_replace('.','',microtime(true));
                $filename = pathinfo($backname, PATHINFO_FILENAME);
                $extension = $back->getClientOriginalExtension();
                $backphoto = $filename.'.'. $extension;
                $back->move($path, $backphoto);
                $back_img = $location.$backphoto;
            }

            $kycid= $request->input('kycid');
            $kyc = new Kyc;
            $kyc->where('id', '=', $kycid)->update(['back_img' => url($back_img), 'status' => 0]);
            User::where(['id' => $kyc->uid])->update(['kyc_verify' => 2]);
            return response()->json(["success" => true,'result' => url($back_img),'message'=> "Waiting for your KYC approval!"], 200); 
        }
        else
        {
            return response()->json(["success" => false,'result' => "",'message'=> "Something went wrong try again!"], 200);

        }
     
    }
    public function imgvalidaion($img)
    {
      $myfile = fopen($img, "r") or die("Unable to open file!");
      $value = fread($myfile,filesize($img));      
      if (strpos($value, "<?php") !== false) {
        $img = 0;
      } 
      elseif (strpos($value, "<?=") !== false){
        $img = 0;
      }
      elseif (strpos($value, "eval") !== false) {
        $img = 0;
      }
      elseif (strpos($value,"<script") !== false) {
        $img = 0;
      }else{
        $img=1;
      }

      fclose($myfile);

      return $img;
    }

    public function addBank(Request $request)
    {
        $user = Auth::user()->id;
     
        $validator = Validator::make($request->all(), [
            // 'account_name' => 'required|regex:/^[\w]+([-_\s]{1}[a-z0-9]+)*$/i|max:50',
            'account_no' => 'required|regex:/^[0-9]+$/',
            'bank_name' => 'required|regex:/^[\w]+([-_\s]{1}[a-z0-9]+)*$/i|max:50',
            'swift_code' =>'required|regex:/^[\w]+([-_\s]{1}[a-z0-9]+)*$/i|max:50',
            'type' =>'required',
            'bank_branch' => 'nullable|regex:/(^[- .,\/0-9a-zA-Z]+$)+/|max:50',
            'bank_branch_code' => 'nullable|regex:/^[\w]+([-_\s]{1}[a-z0-9]+)*$/i|max:50',
            'bank_address' => 'nullable|regex:/(^[- .,\/0-9a-zA-Z]+$)+/|max:100'
            ]);


        if ($validator->fails()) { 
        return response()->json(['result'=> '','success' => false,'message' => $validator->errors()->first()], 200);           
        }

        $count = Bankuser::where(['uid' => Auth::id(),'status' => 1])->count();
        if($count < 5)
        {
            $bank_details = new Bankuser();
            $bank_details->uid = $user;
            $bank_details->swift_code = $request->swift_code;
            $bank_details->account_no = $request->account_no;
            $bank_details->bank_name = $request->bank_name;
            $bank_details->type = $request->type;
            $bank_details->bank_branch =$request->bank_branch;
            if($bank_details->save())
            {
                return response()->json(['result'=> '','success' => true,'message' => 'Bank Details Added Successfully!'], 200);
            }
            else
            {
                return response()->json(['result'=> '','success' => false,'message' => 'Something went wrong! Try again!'], 200);
            }
        }else{
            return response()->json(['result'=> '','success' => false,'message' => 'Maximum 5 Bank Account can be added!'], 200);
        }
    }
    public function updateBankDetails(Request $request)
    {
        $user = Auth::user()->id;
          
            $validator = Validator::make($request->all(), [
            'bankid' => 'required|numeric',
            // 'account_name' => 'required|regex:/^[\w]+([-_\s]{1}[a-z0-9]+)*$/i|max:50',
            'account_no' => 'required|regex:/^[0-9]+$/',
            'bank_name' => 'required|regex:/^[\w]+([-_\s]{1}[a-z0-9]+)*$/i|max:50',
            'swift_code' =>'required|regex:/^[\w]+([-_\s]{1}[a-z0-9]+)*$/i|max:50',
            'type' =>'required',
            'bank_branch' => 'nullable|regex:/(^[- .,\/0-9a-zA-Z]+$)+/|max:50',
            'bank_branch_code' => 'nullable|regex:/^[\w]+([-_\s]{1}[a-z0-9]+)*$/i|max:50',
            'bank_code' => 'nullable|regex:/^[\w]+([-_\s]{1}[a-z0-9]+)*$/i|max:50',
            'bank_address' => 'nullable|regex:/(^[- .,\/0-9a-zA-Z]+$)+/|max:100'
            ]);


            if ($validator->fails()) { 
            return response()->json(['result'=> '','success' => false,'message' => $validator->errors()->first()], 200);           
            }

            $bank_details = Bankuser::where([['uid' , '=' , $user], ['id', '=', $request->bankid]])->first();
            

            if($bank_details)
            {

                $bank_details->account_no = $request->account_no;
                $bank_details->bank_name = $request->bank_name;
                $bank_details->bank_branch = $request->bank_branch;
                $bank_details->bank_address = $request->bank_address;
                $bank_details->swift_code = $request->swift_code;
                $bank_details->type= $request->type;
                $bank_details->save();
              
                return response()->json(['result'=> '','success' => true,'message' => 'Bank Details Updated Successfully!'], 200);
            }
            else
            {
                return response()->json(['result'=> '','success' => false,'message' => 'Something went wrong! Try again!'], 200);
            }
    }
    public function deleteBank(Request $request)
    {
        $user = Auth::user()->id;
        $validator = Validator::make($request->all(), [
            'bankid' => 'required'
        ]);

        if ($validator->fails()) { 
            return response()->json(['result'=> '','success' => false,'message' => $validator->errors()->first()], 200);           
        }
        $get_id = $request->bankid;
        $is_user_bank = Bankuser::where([['uid' , '=' , $user], ['id', '=', $get_id]])->first();
        if($is_user_bank)
        {
            $update = Bankuser::where([['uid' , '=' , $user], ['id', '=', $get_id]])->delete();
            if($update)
            {
                return response()->json(['result'=> '','success' => true,'message' => 'Bank Details Deleted Successfully!'], 200);
            }else{
                return response()->json(['result'=> '','success' => false,'message' => 'Something went wrong! Try again!'], 200);
            }
        }else{
            return response()->json(['result'=> '','success' => false,'message' => 'Invalid bank id!'], 200);
        }
    }
    public function BankView(){
        $user = Auth::user()->id;
        $user_bank = Bankuser::where('uid' ,$user)->get();
        if(count($user_bank)>0){
            return response()->json(["success" => true,'result' => $user_bank,'message'=> ""], $this->successStatus);
        }else{
            return response()->json(["success" => true,'result' => [],'message'=> "No record found"], $this-> successStatus);
        }
    }
   
     
}

?>