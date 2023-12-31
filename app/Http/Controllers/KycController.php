<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserKycRequestMail;
use App\Models\Kyc;
use App\User;
use Auth;
use App\Models\Country;

use Validator;
use App\Models\Hyperverge;

class KycController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','twofa'],['except' => [
            'hypervergeKyc', 'authHyperverge','addhyperverge'
        ]]);
    }

    public function index()
    {
      $user = Auth::user();
      $country = Country::get();
      $Kycstatus = Kyc::where('uid',Auth::id())->latest()->first();
      return view('kyc',['country' => $country,'kyc' => $Kycstatus]);      
    }

    public function hypervergeKyc()
    {      
      $country = Country::get();
      $genToken = $this->authHyperverge();
      //dd($genToken);
      if(isset($genToken->status) && $genToken->status == 'success'){
        $bearToken = $genToken->result->token;
      }else{
        return redirect('/myprofile')->with('kycwarning', 'Quick verify KYC currently busy.Please try again later!');
      }
      return view('kycverification-type',['bearToken' => $bearToken]);      
    }
    public function authHyperverge(){
      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://auth.hyperverge.co/login',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
          "appId": "5tlpix",
          "appKey": "qxzx0urgar9d7jmnzlvx",
          "expiry": 60000
        }',
        CURLOPT_HTTPHEADER => array(
          'Content-Type: application/json'
        ),
      ));

      $response = curl_exec($curl);

      curl_close($curl);
      return json_decode($response);   
    }

    public function test()
    {
      return "test data";
    }

    public function uploadkyc(Request $request){
      //dd($request);
      $rules = [
        'first_name' => 'required|regex:/^[\pL\s\-]+$/u|max:30',
        'last_name' => 'required |regex:/^[\pL\s\-]+$/u|max:30',
        'country' => 'required',
        'id_type' => 'required',
        'city' => 'required',
        'state' => 'required',
        'zip_code' =>'required',
        'gender_type'=>'required',
        'id_number' => 'required |regex:/^[a-z\d\-_\s]+$/i|max:50',
        
        'address_line1' => 'required|max:100',
        'front_upload_id' => 'required|mimes:jpeg,jpg,png|max:2048',
        'back_upload_id' => 'required|mimes:jpeg,jpg,png|max:2048',
        //'selfie_img' => 'required|mimes:jpeg,jpg,png|max:2048',
      ];
       
        
        $messages = [
            'first_name.required' => 'First Name is required.',
            'first_name.regex' => 'Invalid First Name.',
            'state.required' => 'state is required.',
            'zip_code.required' => 'zip_code is required.',
            'gender_type.required' => 'gender_type is required.',
            'last_name.required' => 'Last Name is required.',
            'last_name.regex' => 'Invalid Last Name.',
            'city.required' => 'City is required.',
            'city.regex' => 'Invalid City.',
            'country.required' => 'Country is required.',
            'country.regex' => 'Invalid Country.',
            'id_type.required' => 'ID Type is required.',
            'id_number.required' => 'ID Number is required.',
            'id_number.regex' => 'Invalid ID Type.',
            'id_exp.required' => 'Expiry Date is required.',
            //'address.required' => 'Address is required.',
            'front_upload_id.required' => 'Id Front Document is required.',
            'back_upload_id.required' => 'ID Back Document is required.',
           // 'selfie_img.required' => 'Selfie identity photo is required.'
        ];  
        $validator = \Validator::make($request->all(),$rules, $messages);

        if ($validator->fails()) {
            return back()
            ->withInput()
            ->withErrors($validator);
        }  
     
        $kyc = new Kyc;
        $kyc->uid = Auth::user()->id;
        $kyc->fname = $request->first_name;
        $kyc->lname = $request->last_name;
        $kyc->dob = date('Y-m-d', strtotime($request->dob));
        $kyc->city = $request->city;
        $kyc->phone_no = $request->phone_no;
        $kyc->zip_code = $request->zip_code;
        $kyc->telegram_name = $request->telegram_name;
        $kyc->state = $request->state;
        $kyc->gender_type = $request->gender_type;
        $kyc->country = $request->country;
        $kyc->address_line1 = $request->address_line1;
        $kyc->address_line2 = $request->address_line2;
        $kyc->id_type = $request->id_type;
        $kyc->id_number = $request->id_number;
        $kyc->id_exp = date('Y-m-d', strtotime($request->id_exp));
        
        if($this->imgvalidaion($_FILES['front_upload_id']['tmp_name']) == 1 && $this->imgvalidaion($_FILES['back_upload_id']['tmp_name']) == 1 && $this->imgvalidaion($_FILES['selfie_upload_id']['tmp_name']) == 1 && $this->imgvalidaion($_FILES['resident_upload_id']['tmp_name']) == 1)
        {
         if($request->hasFile('front_upload_id')){
                $dir = 'kyc/';
                $path = 'storage' . DIRECTORY_SEPARATOR . $dir;
				$location = 'storage'. DIRECTORY_SEPARATOR. $dir;

                $fornt = $request->File('front_upload_id');//
                $filenamewithextension = $fornt->getClientOriginalName();
                $photnam = str_replace('.','',microtime(true));
                $filename = pathinfo($photnam, PATHINFO_FILENAME);
                $extension = $fornt->getClientOriginalExtension();
                $photo = $filename.'.'. $extension;
                $fornt->move($path, $photo);
                $front_img = $location.$photo;
          }
          if($request->hasFile('back_upload_id')){
            $dir = 'kyc/';
            $path = 'storage' . DIRECTORY_SEPARATOR . $dir;
            $location = 'storage'. DIRECTORY_SEPARATOR. $dir;
            $back = $request->File('back_upload_id');

            $filenamewithextension = $back->getClientOriginalName();
            $backname = str_replace('.','',microtime(true));
            $filename = pathinfo($backname, PATHINFO_FILENAME);
            $extension = $back->getClientOriginalExtension();
            $backphoto = $filename.'.'. $extension;
            $back->move($path, $backphoto);
            $back_img = $location.$backphoto;
          }
          if($request->hasFile('selfie_upload_id')){
            $dir = 'kyc/';
            $path = 'storage' . DIRECTORY_SEPARATOR . $dir;
            $location = 'storage'. DIRECTORY_SEPARATOR. $dir;
            $back = $request->File('selfie_upload_id');

            $filenamewithextension = $back->getClientOriginalName();
            $backname = str_replace('.','',microtime(true));
            $filename = pathinfo($backname, PATHINFO_FILENAME);
            $extension = $back->getClientOriginalExtension();
            $backphoto = $filename.'.'. $extension;
            $back->move($path, $backphoto);
            $selfie_img = $location.$backphoto;
          }
          if($request->hasFile('resident_upload_id')){
            $dir = 'kyc/';
            $path = 'storage' . DIRECTORY_SEPARATOR . $dir;
            $location = 'storage'. DIRECTORY_SEPARATOR. $dir;
            $back = $request->File('resident_upload_id');

            $filenamewithextension = $back->getClientOriginalName();
            $backname = str_replace('.','',microtime(true));
            $filename = pathinfo($backname, PATHINFO_FILENAME);
            $extension = $back->getClientOriginalExtension();
            $backphoto = $filename.'.'. $extension;
            $back->move($path, $backphoto);
            $resident_img = $location.$backphoto;
          }

          $kyc->front_img = url($front_img);
          $kyc->back_img =  url($back_img);
          $kyc->selfie_img =  url($selfie_img);
          $kyc->proofpaper =  url($resident_img);
          $kyc->status = 0; 
          $kyc->save();
          User::where(['id' => $kyc->uid])->update(['kyc_verify' => 2]);
          $user = Auth::user();

          Mail::to('support@switchex.io')->send(new UserKycRequestMail($user));

          Mail::send('email.user_kyc_intimation', ['user' => $user], function($message) use ($user) {                
                $message->subject("KYC is being processed ");
                $message->to($user['email']);
            });

          return redirect('/myprofile')->with('kycstatus', 'KYC has been submitted successfully. Please wait for admin approval');
        }
       else {
        return redirect('/kyc')->with('kycstatus', 'Your Kyc has been failed ,Unwanted images can not be approved');
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

    public function addhyperverge(Request $request)
    {
        
      $validator =Validator::make($request->all(),[
         'transactionId'=>'required',
         'status' =>'required'

      ]);
          
       if($validator->fails())
         {
           return response()->json(['success'=>false,'result'=>NULL,'message'=>$validator->errors()->first()]);
             }

            $uid = Auth::user()->id;
            $Hyp_data=Hyperverge::where('uid',$uid)->first();
            $details=$request->details;
            if(!is_object($Hyp_data))
            {
             $Hyp_data=new Hyperverge(); 
             $Hyp_data->uid=$uid;

            }
               $Hyp_data->transaction_id=$request->transactionId;
               $Hyp_data->status =$request->status;
               $status=$request->status;
               
              if(isset($details)) 
              {
               $Hyp_data->d_name=$details['digilocker_name'];
               $Hyp_data->d_address=$details['digilocker_address'];
               $Hyp_data->d_dob=$details['digilocker_dob'];
               $Hyp_data->p_id=$details['poi_id'];
               $Hyp_data->p_id_number=$details['poi_idNumber'];
               $Hyp_data->p_name=$details['poi_name'];
               $Hyp_data->p_dob=$details['poi_dob'];
               $Hyp_data->a_id_number=$details['poa_idNumber'];
               $Hyp_data->a_name=$details['poa_name'];
               $Hyp_data->a_dob=$details['poa_dob'];
               $Hyp_data->a_frontadd=$details['poa_addressFront'];
               $Hyp_data->a_backadd=$details['poa_addressBack'];  

               $file_data=$details['poi_imagePath'];

           if($file_data!="" && $this->imgbase64validate($file_data) ==1)
             {
                $name = mb_substr(Auth::user()->name, 0, 3);
               $backname = 'kycpic'.str_replace('.','',microtime(true));
               $file_name = $backname.'.png'; //generating unique file name;
               $dir = 'kyc/';
               \Storage::disk('public')->put($dir.$file_name,base64_decode($file_data));
               $location = 'public' . DIRECTORY_SEPARATOR .'storage'. DIRECTORY_SEPARATOR. $dir;
               $image = $location.$file_name;
               $Hyp_data->image = $image;
             } 

             $file_data=$details['poa_frontImagePath'];

         if($file_data!="" && $this->imgbase64validate($file_data) ==1)
           {
              $name = mb_substr(Auth::user()->name, 0, 3);
             $backname = 'frontimg'.str_replace('.','',microtime(true));
             $file_name = $backname.'.png'; //generating unique file name;
             $dir = 'kyc/';
             \Storage::disk('public')->put($dir.$file_name,base64_decode($file_data));
             $location = 'public' . DIRECTORY_SEPARATOR .'storage'. DIRECTORY_SEPARATOR. $dir;
             $image = $location.$file_name;
             $Hyp_data->front_img = $image;
           } 
           
           $file_data=$details['poa_backImagePath'];


           if($file_data!="" && $this->imgbase64validate($file_data) ==1)
             {
                $name = mb_substr(Auth::user()->name, 0, 3);
               $backname = 'backimg'.str_replace('.','',microtime(true));
               $file_name = $backname.'.png'; //generating unique file name;
               $dir = 'kyc/';
               \Storage::disk('public')->put($dir.$file_name,base64_decode($file_data));
               $location = 'public' . DIRECTORY_SEPARATOR .'storage'. DIRECTORY_SEPARATOR. $dir;
               $image = $location.$file_name;
               $Hyp_data->back_img = $image;
             } 
             
             $file_data=$details['face_imagePath'];


         if($file_data!="" && $this->imgbase64validate($file_data) ==1)
           {
             $name = mb_substr(Auth::user()->name, 0, 3);
             $backname = 'faceimg'.str_replace('.','',microtime(true));
             $file_name = $backname.'.png'; //generating unique file name;
             $dir = 'kyc/';
             \Storage::disk('public')->put($dir.$file_name,base64_decode($file_data));
             $location = 'public' . DIRECTORY_SEPARATOR .'storage'. DIRECTORY_SEPARATOR. $dir;
             $image = $location.$file_name;
             $Hyp_data->face_img = $image;
           } 

         }
               $Hyp_data->save();

               if($status=="auto_approved"){
                 User::where(['id' => $uid])->update(['kyc_verify' => 1]);
                 return response()->json(['success'=>true,'result'=>$Hyp_data,'message'=>"KYC has been submitted successfully"],200);

               }
               elseif($status=="needs_review"){
                 User::where(['id' => $uid])->update(['kyc_verify' => 2]);
                 return response()->json(['success'=>true,'result'=>$Hyp_data,'message'=>"Your KYC have to verify"],200);
               }
               elseif($status=="auto_declined"){
                 User::where(['id' => $uid])->update(['kyc_verify' => 3]);
                 return response()->json(['success'=>false,'result'=>$Hyp_data,'message'=>"Your KYC has rejected"],200);
               }
         
     }

    public function imgbase64validate($value){
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
     return $img;
 }


}
