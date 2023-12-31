<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; 
use Validator;
use Session;
use App\Models\Wallet;
use App\Models\Coinwithdraw;
use App\Models\CurrencyWithdraw;
use App\Models\Deposit;
use App\Models\Cryptotransaction;
use App\Models\Trade;
use App\Models\Completedtrade;
use App\Models\Tradepair;
use App\Models\User;
use App\Models\Commission;

class HistoryController extends Controller 
{
    public $successStatus = 200;
    /** 
     * details api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function trade(){
        $uid = Auth::id();    
        $historys = Trade::where(['uid' => $uid])->get();
         if(count($historys)>0){
           $data =array();
           foreach($historys as $key =>$list) {

            if($list->order_type == 2){
                $Type ='Market';
             }
             else if($list->order_type == 1){
               $Type ='Limit';
               
             }
            $pair =Tradepair::where(['id'=> $list->pair])->first();
            $data[$key]['pair']       =$pair->coinone.'/'.$pair->cointwo;
			$data[$key]['trade_type']  	= $list->trade_type;
			$data[$key]['order_type']  	= $Type;
            $data[$key]['price']  	= display_format($list->price);
			$data[$key]['volume']  	= display_format($list->volume);
            $data[$key]['remaining']  	= display_format($list->remaining);
            $data[$key]['fees']  	= display_format($list->fees);
            $data[$key]['status']  	= $list->status_text;
            $data[$key]['created_at'] =$list->created_at;
            $data[$key]['updated_at'] =$list->updated_at;            
           }
           return response()->json(["success" => true,'result'=>$data,"message"=>""],$this->successStatus); 
         }
         return response()->json(["success" => false,'result'=>NULL,"message"=>"No Records Found"],$this->successStatus);
    }

    public function withdraw(){
        $uid= Auth::id();
        $list = Coinwithdraw::where(['uid' => $uid])->orderBy('id', 'desc')->get();
        if(count($list)> 0){
            $data =array();
            foreach($list as $key =>$lists) {
                 
                if($lists->status == 0){
                    $Status     ="Pending";
               }else if($lists->status == 1){
                      $Status      ="Success";  
               }else if($lists->status == 2){
                     $Status    ="Denied";  
               }else{
                     $Status      ="Pending";
               }

                $data[$key]['assets']       =$lists->coin_name;
                $data[$key]['txid']  	= $lists->txid;
                $data[$key]['sender']  	= $lists->sender;
                $data[$key]['reciever']  	= $lists->reciever;
                $data[$key]['amount']  	= $lists->amount;
                $data[$key]['remark']  	= $lists->remark;
                $data[$key]['status']  	= $Status;
                $data[$key]['created_at'] =$lists->created_at;
                $data[$key]['updated_at'] =$lists->updated_at;            
               }
               return response()->json(["success" => true,'result'=>$data,"message"=>""],$this->successStatus); 
            
        }
        return response()->json(["success" => false,'result'=>NULL,"message"=>"No Records Found"],$this->successStatus);

        
    }
    public function deposit(){
        $uid= Auth::id();
        $list = Cryptotransaction::where(['uid' => $uid])->orderBy('id', 'desc')->get();
        if(count($list)>0){
            
            $data =array();
            foreach($list as $key => $lists){
                  
                if($lists->status == 0){
                       $Status     ="Waiting for admin approval";
                }else if($lists->status == 1){
                         $Status      ="Pending";  
                }else if($lists->status == 2){
                        $Status    ="Success";  
                }else{
                        $Status      ="Admin reject user request";
                }
                
                $data[$key]['txid'] =$lists->txid;
                $data[$key]['assets'] =$lists->currency;
                $data[$key]['from_addr'] =$lists->from_addr;
                $data[$key]['to_addr'] =$lists->to_addr;
                $data[$key]['amount'] =display_format($lists->amount);
                $data[$key]['remark'] =$lists->remark;
                $data[$key]['status'] =$Status;
                $data[$key]['created_at'] =$lists->created_at;
                
            }
            return response()->json(["success" => true,'result'=>$data,"message"=>""],$this->successStatus);  
        }
        return response()->json(["success" => false,'result'=>NULL,"message"=>"No Records Found"],$this->successStatus);
    }

    public function withdrawList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'coin' => 'required|alpha_dash|max:10',
            'limit' => 'required|numeric|min:0|max:100',
            'offset' => 'required|numeric|min:0|max:100000'
        ]);

        if ($validator->fails()) { 
        return response()->json(['result'=> NULL,'success' => false,'message' => $validator->errors()->first()], 200);           
        }

        $limit=  $request->limit;
        $offset=  $request->offset;

        $coin =$request->coin;
        $details = Commission::coindetails($coin);
        $url ="";
        if($details){
            if($details->type == 'fiat'){
                $DepositList = CurrencyWithdraw::listView(Auth::id(),$coin,$limit,$offset);
                    foreach ($DepositList as $key => $value) {
                    $DepositList[$key]['card_no']= $value->card_no != Null ?  $value->card_no : '';
                    $DepositList[$key]['holder_name']= $value->holder_name != Null ?  $value->holder_name : '';
                    $DepositList[$key]['card_bankname']= $value->card_bankname != Null ?  $value->card_bankname : '';
                    $DepositList[$key]['address']= $value->address != Null ?  $value->address : '';
                 } 

                return response()->json(['result'=> $DepositList,'type' => 'fiat','coin' => $coin,'url' => "",'success' => true,'message' => ''], 200);
            }else{
                $DepositList = Coinwithdraw::listView(Auth::id(),$coin,$limit,$offset);
                $url = $details->url;
                return response()->json(['result'=> $DepositList,'type' => 'coin','coin' => $coin,'url' => $url,'success' => true,'message' => ''], 200);
            }
        }else{

            return response()->json(['result'=> NULL,'success' => false,'message' => 'Invalid Coin/Currency!'], 200);


        }
    }

    public function depositList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'coin'      => 'required|alpha_dash|max:10',
            'limit'     => 'required|numeric|min:0|max:100',
            'offset'    => 'required|numeric|min:0|max:10000'
        ]);

        if ($validator->fails()) { 
            return response()->json(['result'=> NULL,'success' => false,'message' => $validator->errors()->first()], 200);           
        }

        $limit=  $request->limit;
        $offset=  $request->offset;

        $coin =$request->coin;
        $details = Commission::coindetails($coin);


        if($details){
            if($details->type == 'fiat'){
                $DepositList = Deposit::listView(Auth::id(),$coin,$limit,$offset);
                foreach ($DepositList as $key => $value) {
                    $DepositList[$key]['type']= $value->type != Null ?  $value->type : 'wirepayment';
                     $DepositList[$key]['amount']= display_format($value->amount,8) ;
                     $DepositList[$key]['credit_amount']= display_format($value->credit_amount,8) ;
                 } 

                return response()->json(['result'=> $DepositList,'type' => 'fiat','coin' => $coin,'success' => true,'message' => ''], 200);
            }else{

                $DepositList = array();
                $DepositList1 = Cryptotransaction::where(['uid' => Auth::id(), 'currency' => $coin])->orderBy('id', 'desc')->offset($offset)->limit($limit)->get(); 
                 foreach ($DepositList1 as $key => $value) {

                    $DepositList[$key]['id']= $value->id ;
                    $DepositList[$key]['uid']= $value->uid ;
                    $DepositList[$key]['currency']= $value->currency ;
                    $DepositList[$key]['txtype']= $value->txtype ;
                    $DepositList[$key]['txid']= $value->txid ;
                    $DepositList[$key]['from_addr']= $value->from_addr ;
                    $DepositList[$key]['to_addr']= $value->to_addr ;
                    $DepositList[$key]['amount']= display_format($value->amount,8) ;
                    $DepositList[$key]['status']= $value->status ;

                    $old_date_timestamp = strtotime($value->created_at);
                    $updated_at = strtotime($value->updated_at);
                    $DepositList[$key]['created_at']= date('Y-m-d H:i:s', $old_date_timestamp);
                    $DepositList[$key]['updated_at']= date('Y-m-d H:i:s', $updated_at);
                 }        


                 return response()->json(['result'=> $DepositList,'type' => 'coin','coin' => $coin,'success' => true,'message' => ''], 200);
            }
        }else{
            return response()->json(['result'=> NULL,'success' => false,'message' => 'Invalid Coin/Currency!'], 200);
        }
    }

    public function buy_history(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'ordertype' => 'required|alpha_dash|max:15',
            'pair'      => 'required|numeric|min:0|max:10000',
            'limit'     => 'required|numeric|min:0|max:100',
            'offset'    => 'required|numeric|min:0|max:10000'
        ]);

        $ordertype  =  $request->ordertype;
        $pair       =  $request->pair;
        $limit      =  $request->limit;
        $offset     =  $request->offset;

        if ($validator->fails()) { 
            return response()->json(['result'=> NULL,'success' => false,'message' => $validator->errors()->first()], 200);           
        }
  
        $user = Auth::user();

        if($ordertype == 'limit') {
            $order_type = 1;
        } elseif($ordertype == 'market'){
            $order_type = 2;
        }

        $tradepair = Tradepair::where('active',1)->where('id', $pair)->first();
        $coinonecommission = Commission::where('status',1)->where('source', '=', $tradepair->coinone)->first();
        $cointwocommission = Commission::where('status',1)->where('source', '=', $tradepair->cointwo)->first();
        $coinone_decimal = 8;
        if($coinonecommission->type == 'fiat')
        {
            $coinone_decimal = 2;
        }
        $cointwo_decimal = 8;
        if($cointwocommission->type == 'fiat')
        {
            $cointwo_decimal = 2;
        }

        $user = Auth::user();
        $buytrade = Trade::where([
        ['uid', '=', $user->id],
        ['trade_type','=','Buy'],
        ['order_type', '=', $order_type],
        ['pair', '=', $pair]
        ])->orderBy('id', 'desc')->offset($offset)->limit($limit)->get();

        if($order_type == 2)
        {
            $buytrade = Completedtrade::join('buytrades', 'completedtrades.buytrade_id', '=', 'buytrades.id')->select('buytrades.*', 'completedtrades.*')->orderBy('completedtrades.id', 'desc')->where('buytrades.pair', $tradepair->id)->where('buytrades.uid', $user->id)->where('buytrades.order_type', 2)->offset($offset)->limit($limit)->get();
        }
        return response()->json(['result'=> $buytrade,'pair' =>$tradepair->coinone.'_'.$tradepair->cointwo,'coinone' => $tradepair->coinone, 'cointwo' => $tradepair->cointwo,'ordertype' => $ordertype,'coinonecommission' => $coinone_decimal, 'cointwocommission' => $cointwo_decimal,'success' => true,'message' => ''], 200);
    }

    public function sell_history(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'ordertype' => 'required|alpha_dash|max:15',
            'pair'      => 'required|numeric|min:0|max:10000',
            'limit'     => 'required|numeric|min:0|max:100',
            'offset'    => 'required|numeric|min:0|max:10000'
        ]);

        $ordertype  =  $request->ordertype;
        $pair       =  $request->pair;
        $limit      =  $request->limit;
        $offset     =  $request->offset;

        if ($validator->fails()) { 
            return response()->json(['result'=> NULL,'success' => false,'message' => $validator->errors()->first()], 200);           
        }
  
        $user = Auth::user();
        if($ordertype == 'limit') {
            $order_type = 1;
        } elseif($ordertype == 'market'){
            $order_type = 2;
        }

        $tradepair = Tradepair::where('active',1)->where('id', $pair)->first();
        $coinonecommission = Commission::where('status',1)->where('source', '=', $tradepair->coinone)->first();
        $cointwocommission = Commission::where('status',1)->where('source', '=', $tradepair->cointwo)->first();

        $coinone_decimal = 8;
        $cointwo_decimal = 8;
        if($coinonecommission->type == 'fiat')
        {
            $coinone_decimal = 2;
        }            
        if($cointwocommission->type == 'fiat')
        {
            $cointwo_decimal = 2;
        }

        $user = Auth::user();
        $selltrade = Trade::where([
            ['uid', '=', $user->id],
            ['trade_type','=','Sell'],
            ['order_type', '=', $order_type],
            ['pair', '=', $pair]
        ])->orderBy('id', 'desc')->offset($offset)->limit($limit)->get();

        if($order_type == 2)
        {
            $selltrade = Completedtrade::join('selltrades', 'completedtrades.selltrade_id', '=', 'selltrades.id')
                ->select('selltrades.*', 'completedtrades.*')
                ->orderBy('completedtrades.id', 'desc')->where('selltrades.pair', $tradepair->id)->where('selltrades.uid', $user->id)->where('selltrades.order_type', 2)->offset($offset)->limit($limit)->get();
        }

        return response()->json(['result'=> $selltrade,'pair' =>$tradepair->coinone.'_'.$tradepair->cointwo,'coinone' => $tradepair->coinone, 'cointwo' => $tradepair->cointwo,'ordertype' => $ordertype,'coinonecommission' => $coinone_decimal, 'cointwocommission' => $cointwo_decimal,'success' => true,'message' => ''], 200);
    }
    public function cancelFiatWithdraw(Request $request){
        $validator = Validator::make($request->all(), [
            'withdrawid' => 'required|numeric'
        ]);
        if ($validator->fails()) { 
            return response()->json(['result'=> NULL,'success' => false,'message' => $validator->errors()->first()], 200);           
        }

        $user = Auth::user()->id;
        $deposit_id = $request->withdrawid;

        $deposit_request = CurrencyWithdraw::where(['id' => $deposit_id,'uid' => $user,'status' => 0])->first();

        if(is_object($deposit_request)){
            $remark = "User cancelled ".$deposit_request->type." withdraw request";
            Wallet::creditAmount($user, $deposit_request->type, $deposit_request->request_amount, 2,'withdraw',$remark);            
            $deposit_request->status = 3;
            $deposit_request->updated_at  = date('Y-m-d H:i:s',time());
            $deposit_request->save();

            return response()->json(['result'=> NULL,'success' => true,'message' => 'Withdraw Request has been cancelled successfully'], 200);

        }else{
            return response()->json(['result'=> NULL,'success' => false,'message' => 'Invalid Request!'], 200);
        }
    }


}