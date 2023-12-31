<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use App\User;
use Auth;
use Mail;
use App\Http\Middleware\twofaMiddleware;
use App\Mail\SendOtpVerification;
use App\Models\Bankuser;
use App\Models\AffliateTransaction;
use App\Models\AffilateCommission;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use App\Models\Kyc;
use App\Models\Userprofile;
use App\Models\Country;
use App\Models\StakingOverAllStake;
use Session;
use Hash;
use App\Traits\GoogleAuthenticator;

class UserpanelController extends Controller
{
    use GoogleAuthenticator;
    public function __construct()
    {
        $this->middleware(['auth','twofa']);
    }

    public function tradehistroy()
    {
        return view('/userpanel.trade-histroy');
    }
    public function deposit()
    {
        return view('/userpanel.deposit');
    }  
    public function withdraw()
    {
        return view('/userpanel.withdraw');
    }  
    public function support()
    {
        return view('/userpanel.support');
    } 
    public function chat()
    {
        return view('/userpanel.chat');
    }
    public function profileView()
    {   
        $user_id = Auth::user()->id;
        $userdata = User::where(['id' => $user_id])->first();
        $bankdetail = Bankuser::where(['uid' => $user_id])->first();
        $kyc_data = Kyc::where(['uid' => $user_id])->orderBy('id', 'desc')->first();
        $country = Country::get();
        $referaldetail =AffliateTransaction::where(['uid' =>$user_id])->get(); 
        $QR_Image = "";
        $secret = "";
        if($userdata->google2fa_verify == 0){
            $secret = $userdata->google2fa_secret;
            if($secret === null || trim($secret) === '' ){
                $secret = $this->createSecret();
                $userdata->google2fa_secret = $secret;
                $userdata->save();
            }
            $sitename = seoUrl(config('app.name'));
            $QR_Image = $this->getQRCodeGoogleUrl($sitename.'-('.$userdata->email.')', $secret);
        }

        return view('profile', ['user' => $userdata, 'bankdetail' => $bankdetail, 'profile' => $userdata, 'kyc_data' => $kyc_data,'country' => $country,'image' => $QR_Image, 'secret' => $secret,'referaldetail' => $referaldetail ]);
    }

    public function updateprofileimg(Request $request)
    {
        $uid = mb_substr(Auth::user()->name, 0, 3);
        $image = $request->image;        
            list($type, $image) = explode(';', $image);
            list(, $image) = explode(',', $image);
            $image = base64_decode($image);
            $trade_url = \Config::get('app.url');
            $dir = 'users'. DIRECTORY_SEPARATOR .'userprofile';
            $path = 'storage' . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . $dir;
            $image_name = $uid . str_replace('.', '', microtime(true)). '.png';
            // $img = $trade_url.'public/images/userprofile/'.$image_name;
            $img_url = $trade_url.'/storage/userprofile/'.$image_name;
            $path = storage_path('/app/public/userprofile/' . $image_name); 
            //File::put($path, $image);
            file_put_contents($path, $image); 
            if($image_name)
            { 
                $img = $image_name; 
                $profile_img = $image_name;  
                $profile = new User;
                $profiles = $profile->where(['id' => Auth::id()])->count();
                if($profiles > 0){
                    $profile->where('id', '=', Auth::id())->update(['profileimg' => $img_url]); 
                    return 1;
                }
            }
            else
            {
                return 0;
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

         if(crypt($current_password, $input_password) == $input_password)
        {
                if($new_password == $confirm_password)
                {
                     $password = bcrypt($new_password);
                    $update = User::where('id' , '=' , $user->id)->update(['password' => $password]);
                    if($update)
                    {
                        $password_success_response = 'Password Changed Successfully!';
                        return Redirect::back()->with(['passwordupdated' => $password_success_response]);
                    }
                    else
                    {
                        $password_failed_response = 'Password Not Updated!';
                        return Redirect::back()->with(['passwordnotupdated' => $password_failed_response]);
                    }
              
            }
            else
            {
                $password_failed_response = 'Password length should be minimum 8!';
                return Redirect::back()->with(['passwordnotupdated' => $password_failed_response]);
            }
        }
        else
        {
            $password_failed_response = 'You entered wrong current password!';
            return Redirect::back()->with(['passwordnotupdated' => $password_failed_response]);
        }
    }

    public function profileupload(Request $request)
    {  
            $security = User::where('id', Auth::id())->first();

            $country = \DB::table('countries')->get();
            $countries = $country;
            $niceNames = array(
                'file_input_file' => 'Profile Picture'
            );

            $this->validate($request, [                            
                 'file_input_file' => 'required|file|max:1000|mimes:jpg,png,jpeg,PNG,Png',
            ],[],$niceNames);

            if($this->imgvalidaion($_FILES['file_input_file']['tmp_name']) == 1)
            {
                if(Input::hasFile('file_input_file')){
                $back = Input::File('file_input_file');
                $back_ra=preg_replace("/[^A-Z0-9._-]/i", "_", $back->getClientOriginalName());
                $rand = rand(0000, 9999);
                $img = $rand."-".$back_ra;
                $back->move(public_path().'/images/userprofile/', $img);
                $back_img = URL::to("/") . '/images/userprofile/'. $img; 
                $kyc_update=User::where(['id' => $security->id])->update(['profileimg' => $img]);

                return redirect()->back()->with('successimage', 'Profile Picture Updated Successfully!');
                }       

                else
                {
                    return Redirect::back()->withErrors( 'errorimage', 'Try again!'); 
                }
            }
            else
            {
                return Redirect::back()->withErrors( 'errorimage', 'Unwanted images are can\'t approved');
            }
    }


    public function persinoaldetais_update(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required | string | max:80',
            'last_name' => 'required | string | max:80',
            'phone_no' => 'required | min:10 ',
            'dob' => 'required|date|before:-18 years',
            'nationality' => 'required | string | max:40',
            'country' => 'required|numeric',
            'address' => 'nullable|regex:/(^[- .,\/0-9a-zA-Z]+$)+/',
        ]);
        
        $user_id = Auth::user()->id;
        $fname = $request->input('first_name');
        $lname = $request->input('last_name');
        $phone_no = $request->input('phone_no');
        $country = $request->input('country');
        $address = $request->input('address');
        $dob = $request->input('dob');
        $nationality = $request->input('nationality');
        $user = new User;
        $user->where('id', '=', $user_id)->update(['first_name' => $fname, 'last_name' => $lname, 'dob' => $dob,'nationality' => $nationality, 'phone_no' => $phone_no, 'country' => $country, 'address' => $address]);
        return redirect()->route('myprofile')->with('profilestatus', 'Personal Details Updated Successfully');
    }

    public function updateBankDetails(Request $request)
    {
        
        $user = Auth::user()->id;
        $this->validate($request, [
            'account_name' => 'required|regex:/^[\w]+([-_\s]{1}[a-z0-9]+)*$/i|max:50',
            'account_no' => 'required|regex:/^[\w]+([-_\s]{1}[a-z0-9]+)*$/i|max:50',
            'bank_name' => 'required|regex:/^[\w]+([-_\s]{1}[a-z0-9]+)*$/i|max:50',
            'bank_branch' => 'nullable|regex:/(^[- .,\/0-9a-zA-Z]+$)+/|max:50',
            'bank_branch_code' => 'nullable|regex:/^[\w]+([-_\s]{1}[a-z0-9]+)*$/i|max:50',
            'swift_code' => 'required|regex:/^[\w]+([-_\s]{1}[a-z0-9]+)*$/i|max:50',
        ]);
        $account_name = $request->account_name;
        $account_no = $request->account_no;
        $bank_name = $request->bank_name;
        $bank_branch = $request->bank_branch;
        $remark = $request->remark;
        $ifsc_code = $request->swift_code;
        $is_user_bank = Bankuser::where([['uid' , '=' , $user]])->first();
        if($is_user_bank && $is_user_bank->count() > 0)
        {
            $update = Bankuser::where([['uid' , '=' , $user]])->update(['account_name' => $account_name, 'account_no' => $account_no, 'bank_name' => $bank_name, 'bank_branch' => $bank_branch, 'swift_code' => $ifsc_code]);
            if($update)
            {
                $bank_success_response = 'Bank Details Updated Successfully!';
                return redirect()->route('myprofile')->with('bankstatus', $bank_success_response);

            }
        }
        else{
            $bank_details = new Bankuser();
            $bank_details->uid = $user;
            $bank_details->account_name = $request->account_name;
            $bank_details->account_no = $request->account_no;
            $bank_details->bank_name = $request->bank_name;
            $bank_details->bank_branch = $request->bank_branch;
            $bank_details->swift_code = $request->swift_code;
            if($bank_details->save())
            {
                $bank_success_response = 'Bank Details Updated Successfully!';
                return redirect()->route('myprofile')->with('bankstatus', $bank_success_response);
            }
        }
    }


    public function updatePaypalDetails(Request $request)
    {        
        $user = Auth::user()->id;
        $this->validate($request, [
            'paypal_id' => 'required|regex:/(^[- .,@\/0-9a-zA-Z]+$)+/|max:100'
        ]);
        $paypal_id = $request->paypal_id;
        $is_user_paypal = Bankuser::where([['uid' , '=' , $user]])->first();
        if(is_object($is_user_paypal))
        {
            $is_user_paypal->paypal_id = $paypal_id;
            $is_user_paypal->save();
            $paypal_success_response = 'Paypal Details Updated Successfully!';
            return redirect()->route('myprofile')->with('paypalstatus', $paypal_success_response);
        }
        else{
            $bank_details = new Bankuser();
            $bank_details->uid = $user;
            $bank_details->paypal_id = $request->paypal_id;
            if($bank_details->save())
            {
                $bank_success_response = 'Paypal Details Added Successfully!';
                return redirect()->route('myprofile')->with('paypalstatus', $bank_success_response);
            }
        }
    }
    
    public function editbank(){

        return view('bank-edit');
    }

    public function bankDetail()
    {
        $user = Auth::user()->id;
        $is_user_bank = Bankuser::where([['uid' , '=' , $user], ['status', '=', 1]])->paginate(15);
        return view('bank', ['bank_details' => $is_user_bank]);

    }

    public function addBankdetail()
    {
        return view('bank-add');
    }

    public function bankview()
    {
        $user = Auth::user()->id;
        $is_user_bank = Bankuser::where([['uid' ,$user],['type','=','bank'] ])->paginate(10);
         return view('bank',['bank_details'=>$is_user_bank,'user'=>$user]);
         //dd($is_user_bank);

    }
  
    public function upilist()
    {
      $user=Auth::user()->id;
      $is_user_upi =Bankuser::where([['uid',$user],['type','=','upi']])->paginate(15);
      return view('upi-list',['upi'=>$is_user_upi]);

    }

    public function upi()
    {
        return view ('upi');
    }

    public function upiadd(Request $request)
    {
       $user_id=Auth::user()->id;
       $this->validate($request, [

        'alias' => 'required',
        'upiid' => 'required',
        'qrcode' =>'nullable'
    ]);
        
        $count = Bankuser::where([['uid',$user_id],['type', '=','upi']])->count();
       if($count<5)
       {
        $upi_details =new Bankuser;
        $upi_details->uid =$user_id;
        $upi_details->type ='upi';
        $upi_details->aliasupi =$request->alias;
        $upi_details->upiid =$request->upiid;

        if($request->hasFile('qrcode')){
            $dir = 'deposit/';
            $path = 'storage' . DIRECTORY_SEPARATOR . $dir;
            $location = 'storage'. DIRECTORY_SEPARATOR. $dir;

            $qrcode = $request->File('qrcode');//
            $filenamewithextension = $qrcode->getClientOriginalName();
            $photnam = str_replace('.','',microtime(true));
            $filename = pathinfo($photnam, PATHINFO_FILENAME);
            $extension = $qrcode->getClientOriginalExtension();
            $photo = $filename.'.'. $extension;
            $qrcode->move($path, $photo);
            $upi_details->qrcode = $location.$photo;
      }

        $upi_details->save();
        return redirect('/upi-list')->with('success',"Upi id Added Successfully");
       }
        else{ 
        return redirect('/upi-list')->with('error',"Maximum 5 Upi Account can be added!");
        }
    }

    public function deleteBank(Request $request)
    {
        $user = Auth::user()->id;
        $get_id = $request->id;
        $is_user_bank = Bankuser::where([['uid' , '=' , $user], ['id', '=', $get_id]])->first();
        if($is_user_bank)
        {
            $update = Bankuser::where([['uid' , '=' , $user], ['id', '=', $get_id]])->update(['status' => 0]);
            if($update)
            {
                return \Response::json(array(
                    'status' => true,
                    'msg' => "Bank Details Deleted Successfully!"
                ));
            }
        }
    }
    public function deletebankdetail(Request $request)
    {
      $user =Auth::user()->id;
      $get_id =Decrypt($request->id);

      $is_bank =Bankuser::where([['uid','=',$user],['id','=',$get_id]])->first();
      if($is_bank)
      {
        $is_bank->delete();
      }
      else{
        return back()->witherrors('error',"check the input");
      }
      return redirect('/bank')->with('success',"removed");

    }
    public function deleteupi(Request $request){

        $user =Auth::user()->id;
        $get_id=Decrypt($request->id);
        $is_upi =Bankuser::where([['uid','=',$user],['id','=',$get_id],['type','=','upi']])->first();
    
        $is_upi->delete();
        return redirect('/upi-list')->with('success',"Remove successfully");
        }

    public function addBank(Request $request)
        {
            //dd($request);
         $user = Auth::user()->id;
         $this->validate($request, [
    
                'account_number' => 'required|alpha_num',
                'ifsc_code' => 'required|alpha_num',
                'accounttype'=>'required|in:current,savings',
                'bank_name' => 'required|regex:/^[\w]+([-_\s]{1}[a-z0-9]+)*$/i|max:50',
                'bank_address' => 'nullable|regex:/(^[- .,\/0-9a-zA-Z]+$)+/|max:100'
            ]);
    
            // $count = Bankuser::where(['uid' => Auth::id(),'status' => 1])->count();
            // $count = Bankuser::where(['uid' => Auth::id()])->count();
        $count = Bankuser::where([['uid',$user],['type', '=','bank']])->count();
        if($count < 5){
                $bank_details = new Bankuser();
                $bank_details->uid = $user;
                $bank_details->type ='bank';
                $bank_details->account_no = $request->account_number;
                $bank_details->swift_code =$request->ifsc_code;
                $bank_details->accounttype =$request->accounttype;
                $bank_details->bank_name = $request->bank_name;
                if($bank_details->save())
                //dd($bank_details);
                {
                    $success_response = 'Bank Details Added Successfully!';
                    return redirect('/bank')->with('success', $success_response);
                }
                }else{
                $success_response = 'Maximum 5 Bank Account can be added!';
                    return redirect('/bank')->with('success', $success_response);
            }
        }
    
    public function bankDetails(Request $request)
    {
        $user = Auth::user()->id;
        $get_id = Crypt::decrypt($request->id);
        $is_user_bank = Bankuser::where([['uid' , '=' , $user], ['id', '=', $get_id]])->first();
        return view('userpanel/update_bank_details', ['bank' => $is_user_bank]);
    }

    public function userprofileupdate(Request $request)
    {

        $security = User::where('id', Auth::id())->first();
        $niceNames = array(
            'uname' => __('common.User_Name'),
            'phoneno' => __('common.Phone_Number'),
            'country' => __('common.Country'),
        );
        $this->validate($request, [
                            'uname' => 'alpha|required',
                            'phoneno' => 'numeric|required',
                            'country' => 'numeric|required',
                            
                        ],[],$niceNames);

        $data = [ 'name' => $request->uname,
            'phone_no' => $request->phoneno,
            'country' => $request->country
            ];


       $user = \App\User::where('id',Auth::id())->update($data);
        if($user){
       return redirect()->back()->with('profilemsg', 'Personal details updated successfully.');   
       }
       else{
        return Redirect::back()->withErrors( 'profilemsg', 'Updated failed!'); 
       }
    }

    public function userbank(Request $request)
    {   

        $security = User::where('id', Auth::id())->first();
        $niceNames = array(
            'acc_name' => __('common.Account_Name'),
            'acc_no' => __('common.Account_Number'),
            'bank_name' => __('common.Bank_Name'),
            'bank_branch' => __('common.Bank_Branch'),
            'bank_address' => __('common.Bank_Address'),
            'swift_code' => __('common.Swift_code'),
        );
        $this->validate($request, [
                            'acc_name' => 'alpha|required',
                            'acc_no' => 'numeric|required',
                            'bank_name' => 'alpha|required',
                            'bank_branch' => 'alpha_num|required',
                            'bank_address' => 'alpha_num|required',
                            'swift_code' => 'alpha_num|required',
                        ],[],$niceNames);

        if($request->acc_name !="" && $request->acc_no !="" && $request->bank_name !="" && $request->bank_branch !="" && $request->bank_address !="" && $request->swift_code !="" )
        {

             $save = Bankuser::create([
            'uid' => $security->id,
            'account_name' => $request->acc_name,
            'account_number' => $request->acc_no,
            'bank_name' =>$request->bank_name,
            'bank_branch' =>$request->bank_branch,
            'bank_address' =>$request->bank_address,
            'swift_code' => $request->swift_code
            ]);

        return Redirect::back()->with( 'bankmsg', 'Bank Details Updated Successfully!'); 
        }
        else
        {
          return Redirect::back()->with( 'failbankmsg', 'Failed! Try again!'); 

        }


    }

    
      public function changepwd(Request $request)
    {
        $security = User::where('id', Auth::id())->first();

    $niceNames = array(
    'oldpwd' => __('common.Old_Password'),
    'newpwd' => __('common.New_Password'),
    'confirmnewpwd' => __('common.Confirm_Password'),
    );


    $this->validate($request, [
    'oldpwd' => 'required|min:6',
    'newpwd' => 'required|min:6',
    'confirmnewpwd' => 'required|min:6'
    ],[],$niceNames);



        $oldpwd =$request->oldpwd;
        $newpwd =$request->newpwd;
        $confirmnewpwd =$request->confirmnewpwd;
  
         $user = User::find(Auth::id());
        $hashedPassword = $user->password;

        if (Hash::check($oldpwd, $hashedPassword)) 
        {

                    if($newpwd == $confirmnewpwd)
                    {

                            $data = [ 'password' =>  bcrypt($newpwd)];

                            $user = \App\User::where('id',Auth::id())->update($data);
                            if($user)
                            {
                                return back()->with('success','Password Changed successfully!');
                            }
                            else
                            {
                                return back()->with('error','Try again!');
                            }
                    }
                    else
                    {
                        return back()->with('error','Password Mismatch!');
                 
                    }
          

        }
         else
            {
                return back()->with('error','Old Password Wrong!');
         
            }


    }
    public function userbankdetails()
    {
        $security = User::where('id', Auth::id())->first();

       
        $userbank= \DB::select("SELECT * FROM `user_bank`  where `uid`= $security->id order by id desc ");
        
            return view('/userpanel.user_bank',[
            'verfiyid' => $security,
            'userbank' => $userbank,

            ]);
      

    }

    public function kycdetails()
    {
        $security = Kyc::where('uid', Auth::id())
                    ->orderBy('kyc_id', 'DESC')
                    ->first();
        
            return view('/userpanel.kyc-details',[
            'kyc' => $security

            ]);
    }


    public function imgvalidaion($img)
    {
      $myfile = fopen($img, "r") or die("Unable to open file!");

      $value = fread($myfile,filesize($img));
      
      if (! empty($value) && strpos($value, "<?php") !== false) {
        $img = 0;
      } 
      elseif (! empty($value) && strpos($value, "<?=") !== false){
        $img = 0;
      }
      elseif (! empty($value) && strpos($value, "eval") !== false) {
        $img = 0;
      }
      elseif (! empty($value) && strpos($value,"<script") !== false) {
        $img = 0;
      }else{
        $img=1;
      }

      fclose($myfile);

      return $img;
    }

    public function userDownlineList(){
        $user = Auth::user();
        $referral_id = Auth::user()->referral_id;
        $uid = Auth::user()->id;
        $info = StakingOverAllStake::where('uid',$uid)->orderBy('overallstake','desc')->first();
        //$levels = AffilateCommission::get();
        $role = Auth::user()->role;
        if ($role =='Personal') {
            $levels = AffilateCommission::take(5)->get();  
        } elseif ($role == 'Excutive Manager')  {
            $levels = AffilateCommission::take(5)->get();
        } elseif ($role == 'Senior Manager')  {
            $levels = AffilateCommission::take(10)->get();
        } elseif ($role == 'Club Manager')  {
            $levels = AffilateCommission::take(15)->get();
        }elseif ($role == 'Cheif Manager' || $role == 'Vice President' || $role == 'President' || $role == 'Senior President')  {
            $levels = AffilateCommission::get();
        } else {
            $levels = AffilateCommission::take(2)->get();  
        }

        $child_array[] = $user->id;
        $data = array();
        $mybussiness = 0;
        $myTeam = 0;
        foreach($levels as $level){
            if(count($child_array) > 0){
                foreach($child_array as $ids){
                    $levelUsers = StakingOverAllStake::where('pid', $ids)->get();
                    if(count($levelUsers) > 0){
                        foreach($levelUsers as $keylevel => $value){
                            $data['Gen'.$level->generation][$value->uid] = $value;
                            $mybussiness += $value->overallstake;
                            $child_array[]= $value->uid;                                
                            if (($key = array_search($value->pid, $child_array)) !== false) {
                              unset($child_array[$key]);
                            }
                        }                        
                    }else{
                        if (($key = array_search($ids, $child_array)) !== false) {
                          unset($child_array[$key]);
                        }
                    }
                    $myTeam ++;                    
                }                 
            }else{
                $data['Gen'.$level->generation] = array();
            }            
        }
        //dd($data);
        return view('referral-info',['users' => $data,'count' => $myTeam,'info' => $info]);
    }


}
