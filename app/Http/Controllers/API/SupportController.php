<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Auth;

use App\User;
use App\Models\Commission;
use App\Models\Supportticket;
use App\Models\Supportchat;


class SupportController extends Controller
{
    
 public $successStatus = 200; 


 public function SupportTicketView()
 {

  $user =Auth::user();
  $tickets = Supportticket::where('uid', $user->id)->orderBy('id','desc')->get();  
    return response()->json(['sucess'=>true,'result'=>$tickets,'message'=>""],200); 
 }

 public function CreateTicket(Request $request)
{
  $validator=Validator::make($request->all(),[

    'subject' => 'required',
    'message' => 'required'
  ]);
  if($validator->fails()){
    return response()->json(['success'=>false,'result'=>NULL,'message'=>$validator->errors()->first()],200);
  }
  $uid=Auth::user()->id;
  $ticket_id = "EX".rand(1000000, 99999999);

  $new_ticket =new Supportticket();
  $new_ticket->uid =$uid;
  $new_ticket->ticket_id =$ticket_id;
  $new_ticket->subject =$request->subject;
  $new_ticket->message =$request->message;
  $new_ticket->status = 0;

  $new_ticket->save();

  $save_record=$new_ticket;

  if($save_record)
  {
    $chat_msg = new Supportchat();
    $chat_msg->uid =$uid;
    $chat_msg->ticketid=$ticket_id;
    $chat_msg->message=$request->message;
    $chat_msg->reply = NULL;
    $chat_msg->user_status = 1;
    $chat_msg->admin_status = 0;
    $chat_msg->save();
  }

   return response()->json(['success'=>true,'result'=>$new_ticket,'message'=>"New Ticket Created Successfully"],200);
}

public function GetMessage(Request $request)
{
   $user = Auth::user();

   $validator=Validator::make($request->all(),[
   'ticket_id'=>'required|alpha_num|max:20',
    ]);

    if($validator->fails()){
     return response()->json(['success'=>false,'result'=>NULL,'message'=>$validator->errors()->first()],200);
     } 
       $ticket_id =$request->ticket_id; 
 
  if(!$ticket_id){
       return response()->json(['success'=>false,'result'=>NULL,'message'=>"Invalid Input"],200);
      }
   
      $ticket =Supportticket::where([['uid','=',$user->id],['ticket_id','=',$ticket_id]])->first();
      if(!is_object($ticket)){
      return response()->json(['success'=>false,'result'=>NULL,'message'=>"Invalid Input"]);
      }
   $chat_msg =Supportchat::where([['uid','=',$user->id],['ticketid','=',$ticket_id]])->get();  
   $update = Supportchat::where([['uid','=',$user->id],['ticketid','=',$ticket_id]])->update(['user_status' => 1]);
    return response()->json(['success'=>true,'result'=>$chat_msg,'message'=>""],200);
  
}

public function CreateMessage(Request $request)
{
   $user =Auth::user();
   $validator =Validator::make($request->all(),[
    'ticket_id'=>'required|alpha_num|max:20',
    'message' =>'required| regex:/(^[A-Za-z0-9 ]+$)+/'

  ]);
  
  if($validator->fails())
  {
    return response()->json(["success" => false,'result' => NULL,'message'=> $validator->errors()->first()], 401); 
  }

  $ticket_id =$request->ticket_id;
  $ticket=Supportticket::where([['uid','=',$user->id],['ticket_id','=',$ticket_id]])->first();

  if(!is_object($ticket)){
    return response()->json(['success'=>false ,'result'=>NULL,'message'=>'Invalid Input']);
  }

  $chat_msg = new Supportchat();
  $chat_msg->uid =$user->id;
  $chat_msg->ticketid=$request->ticket_id;
  $chat_msg->message = $request->message;
  $chat_msg->reply = NULL;
  $chat_msg->user_status = 1;
  $chat_msg->admin_status = 0;
  $chat_msg->save();
 
 return response()->json(['success'=>true,'result'=>$chat_msg,'message'=>"chat created sucessfully"]); 
}

}
