<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Validator;
use Auth;
use Carbon\Carbon;

use App\Models\Tradepair;
use App\Models\Trade;
use App\Models\Wallet;
use App\Models\Completedtrade;
use App\Models\MarketPlace;
use App\Models\Bankuser;
use App\Models\Commission;
use App\Models\MatchHistory;

class P2PMarketplaceController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','twofa','kyc']);
    }

    public function index($market=null){
        if($market!=NULL){
            $coinpair = explode('_',$market);  
            $selectPair = Tradepair::where([
                ['coinone', '=', $coinpair[0]],
                ['cointwo', '=', $coinpair[1]],
                ['active', '=', 1],
                ['is_market', '=', 1],                
            ])->first();
        } else {
            $selectPair =  Tradepair::where(['active' => 1,'is_market' => 1])->orderBy('orderlist','Asc')->first();            
        }
        if(!$selectPair){
            return abort(404);
        }
        $pair = $selectPair->id;
        $coinone = $selectPair->coinone;
        $cointwo = $selectPair->cointwo;
        
        $trades = Tradepair::where(['active' => 1,'is_market' => 1])->orderBy('orderlist','Asc')->get();
        $buytrades = MarketPlace::where(['pair' => $pair,'trade_type' => 'Buy','status' => 0])->orderBy('price','Desc')->get();
        $selltrades = MarketPlace::where(['pair' => $pair,'trade_type' => 'Sell','status' => 0])->orderBy('price','Asc')->get();
        $uid = Auth::user()->id;        
        $opentrades = MarketPlace::where(['pair' => $pair,'uid' => $uid,'status' => 0])->orderBy('id','Desc')->get();
        $completetrades = MarketPlace::where([['pair','=', $pair],['uid' ,'=', $uid],['status','!=',0]])->orderBy('id','Desc')->get();
        return view('p2p.markettrade',['coinone' => $coinone, 'cointwo' => $cointwo,'trades' => $trades,'selectPair' => $selectPair,'buytrades' => $buytrades,'selltrades' => $selltrades,'opentrades' => $opentrades,'completetrades' => $completetrades]);
    }
    public function ajaxMatchhistroy(Request $request){
        try{
            $pair = Crypt::decrypt($request->id);  
        }catch(\Illuminate\Contracts\Encryption\DecryptException $e){            
            return abort(404);
        }
        $histroys = MatchHistory::where([['pair' ,'=' ,$pair]])->limit(20)->orderBy('id','DESC')->get();
        return view('p2p.ajax.match-histroy',['histroys' => $histroys]);
    }
    public function ajaxMarketdepth(Request $request)
    {  
        try{
            $pair = Crypt::decrypt($request->id);  
        }catch(\Illuminate\Contracts\Encryption\DecryptException $e){            
            return abort(404);
        }  
   
        $type =$request->type;
        
      if($type == 'Buy'){
        $marketdepth_B =MarketPlace::select('price',DB::raw('SUM(remaining) as remaining'),DB::raw('group_concat(created_at) as created_at'))
        ->where(['trade_type' => 'Buy','order_type' => 1, 'pair' => $pair,'status' => 0]) 
        ->groupBy('price')
        ->orderBy('price', 'asc')
        ->limit(100)->get();

        return view('p2p.ajax.market-depth',['marketdepth_B'=>$marketdepth_B]);
      }

      if($type == 'Sell'){
        $marketdepth_S =MarketPlace::select('price', DB::raw('SUM(remaining) as remaining'),DB::raw('group_concat(created_at) as created_at'))
        ->where(['trade_type' => 'Sell','order_type' => 1, 'pair' => $pair,'status' => 0])
        ->orderBy('price', 'asc')
        ->groupBy('price')
        ->limit(100)->get();
        
        return view('p2p.ajax.market-depth_S',['marketdepth_S'=>$marketdepth_S]);
         
      }
               
    }
    public function p2pMatch(Request $request)
    {
        $uid = Auth::user()->id; 
        /*try{
            $buyid = Crypt::decrypt($request->id);  
        }catch(\Illuminate\Contracts\Encryption\DecryptException $e){            
            return abort(404);
        }*/   
        $buyid = $request->id;  
        $order = MarketPlace::where(['order_id' => $buyid,'uid' => $uid])->first();
        if(!is_object($order)){
            return abort(404);
        }
        $selectPair =  Tradepair::where(['id' => $order->pair,'active' => 1])->first();
        $pair = $selectPair->id;
        $type = $selectPair->cointwodetails['type'];
        $coinOne = $selectPair->coinone;
        $coinTwo = $selectPair->cointwo;
        if($order->status == 0){
            return view('/p2p.matchsellcoin',['order'=>$order,'type' => $type,'coinOne' => $coinOne,'coinTwo' => $coinTwo]);
        } elseif($order->status == 1){

            if($order->trade_type == 'Sell'){
                $getMatch =  MarketPlace::where(['tuid' => $order->id,'status' => 1])->first();
                if(is_object($getMatch)){
                    $receive = ncMul($getMatch->price,$getMatch->remaining);
                }else{
                    $receive = ncMul($order->price,$order->remaining);
                }
                return view('/p2p.p2psell',['order'=>$order,'type' => $type,'coinOne' => $coinOne,'coinTwo' => $coinTwo,'receive' => $receive,'selectPair' => $selectPair]);
            }
            else{
                $bankdetail = Bankuser::where(['uid' => $order->ouid,'type' => 'bank'])->first();
                $upidetail = Bankuser::where(['uid' => $order->ouid,'type' => 'upi'])->first();
                return view('/p2p.match-seller',['order'=>$order,'type' => $type,'coinOne' => $coinOne,'coinTwo' => $coinTwo,'bankdetail' => $bankdetail,'bankdetail' => $bankdetail,'upidetail' => $upidetail,'selectPair' => $selectPair]);
            }            
            
        } elseif($order->status == 2){
            if($order->trade_type == 'Sell'){
                $getMatch =  MarketPlace::where(['tuid' => $order->id,'status' => 1])->first();
                if(is_object($getMatch)){
                    $receive = ncMul($getMatch->price,$getMatch->remaining);
                }else{
                    $receive = ncMul($order->price,$order->remaining);
                }
                return view('/p2p.p2psell',['order'=>$order,'type' => $type,'coinOne' => $coinOne,'coinTwo' => $coinTwo,'receive' => $receive,'selectPair' => $selectPair]);
            }
            else{
                //dd($coinTwo);
                return view('/p2p.buycoin',['order'=>$order,'type' => $type,'coinOne' => $coinOne,'coinTwo' => $coinTwo,'selectPair' => $selectPair]);
            }            
            
        } elseif($order->status == 3){
            if($order->trade_type == 'Sell'){
                $getMatch =  MarketPlace::where(['tuid' => $order->id,'status' => 1])->first();
                if(is_object($getMatch)){
                    $receive = ncMul($getMatch->price,$getMatch->remaining);
                }else{
                    $receive = ncMul($order->price,$order->remaining);
                }
                return view('/p2p.sellorder',['order'=>$order,'type' => $type,'coinOne' => $coinOne,'coinTwo' => $coinTwo,'receive' => $receive,'selectPair' => $selectPair]);
            }
            else{
                //dd($coinTwo);
                return view('/p2p.buyer-waiting',['order'=>$order,'type' => $type,'coinOne' => $coinOne,'coinTwo' => $coinTwo,'selectPair' => $selectPair]);
            }            
            
        } elseif($order->status == 4 || $order->status == 7){
            return view('/p2p.orderclosed',['order'=>$order,'type' => $type,'coinOne' => $coinOne,'coinTwo' => $coinTwo,'selectPair' => $selectPair]);
        }elseif($order->status == 5 || $order->status == 6){
            return view('/p2p.raise-dispute',['order'=>$order,'type' => $type,'coinOne' => $coinOne,'coinTwo' => $coinTwo,'selectPair' => $selectPair]);
        } elseif($order->status == 100){
            return view('/p2p.payreceive',['order'=>$order,'type' => $type,'coinOne' => $coinOne,'coinTwo' => $coinTwo,'selectPair' => $selectPair]);
        }
        return view('/p2p.matchsellcoin',['order'=>$order,'type' => $type,'coinOne' => $coinOne,'coinTwo' => $coinTwo,'selectPair' => $selectPair]);
    }
    public function paymenttypeUpdate($orderid,$type)
    {
        $uid = Auth::user()->id;
        $trade = MarketPlace::where(['order_id' => $orderid,'uid' => $uid])->first();
        if(!is_object($trade)){
            return abort(404);
        }
        $type = strtolower($type);
        DB::beginTransaction();
        try
        {
            $bankdetail = Bankuser::where(['uid' => $trade->ouid,'type' => $type])->first();
            if(!is_object($bankdetail)){
                return  back()->with('fail',"Something went wrong!. Trader not add payment $type details!");
            }
            $trade->paymenttype = $type;        
            $trade->account_name = $bankdetail->account_name;
            $trade->account_no = $bankdetail->account_no;
            $trade->bank_name = $bankdetail->bank_name;
            $trade->bank_branch = $bankdetail->bank_branch;
            $trade->paypal_id = $bankdetail->paypal_id;
            $trade->swift_code = $bankdetail->swift_code;
            $trade->branch_code = $bankdetail->branch_code;
            $trade->aliasupi = $bankdetail->aliasupi;
            $trade->upiid = $bankdetail->upiid;
            $trade->qrcode = $bankdetail->qrcode;
            $trade->status = 2;
            $trade->status_text = 'Payment proof Upload';
            $trade->save();

            $getMatch =  MarketPlace::where(['id' => $trade->tuid,'status' => 1])->first();
            $getMatch->paymenttype = $type;        
            $getMatch->account_name = $bankdetail->account_name;
            $getMatch->account_no = $bankdetail->account_no;
            $getMatch->bank_name = $bankdetail->bank_name;
            $getMatch->bank_branch = $bankdetail->bank_branch;
            $getMatch->paypal_id = $bankdetail->paypal_id;
            $getMatch->swift_code = $bankdetail->swift_code;
            $getMatch->branch_code = $bankdetail->branch_code;
            $getMatch->aliasupi = $bankdetail->aliasupi;
            $getMatch->upiid = $bankdetail->upiid;
            $getMatch->qrcode = $bankdetail->qrcode;
            $getMatch->status = 2;
            $getMatch->status_text = 'Awaiting fund receive';
            $getMatch->save();
            DB::commit();
            return  back()->with('success',"Deposit fund as soon as!");
        }catch(Exception $e){
            DB::rollBack();
            return  back()->with('fail',"Something went wrong please try again later!");
        }
    }
    public function p2pTradeCancel(Request $request){
        $this->validate($request, [
            'orderID' => 'required|alpha_dash|max:60',
            'reasons' => 'required|string|max:60',
        ]);
        
        $uid = Auth::user()->id;
        $orderid = $request->orderID;
        $remarks = $request->reasons;
        $trade = MarketPlace::where(['order_id' => $orderid,'uid' => $uid])->whereIn('status',[0,1])->first();
        if(!is_object($trade)){
            $trade = MarketPlace::where(['order_id' => $orderid,'uid' => $uid,'status' => 2,'trade_type' => 'Buy'])->first();
            if(!is_object($trade)){
                return abort(404);
            }            
        }
        DB::beginTransaction();
        try
        {
            $tuid = $trade->id;
            $pair = Tradepair::where(['id' => $trade->pair,'active' => 1])->first();
            if($trade->trade_type == "Buy"){            
                $is_cointwo = Commission::coindetails($pair->cointwo);
                if($is_cointwo->type != 'fiat'){
                    $remark = "P2p buy trade Cancelled!";
                    $debitamt = ncMul($trade->price,$trade->remaining,8);
                    Wallet::debitEscrowAmount($uid, $pair->cointwo, $debitamt, 8,'buytrade',$remark,$tuid);
                }
                $trade->status = 4;
                $trade->status_text = 'Cancelled';
                $trade->remarks = $remarks;
                $trade->save();
            }else{
                $is_coinone = Commission::coindetails($pair->coinone);
                if($is_coinone->type != 'fiat'){
                    $remark = "P2p sell trade Cancelled!";
                    $sellfee  = ncMul($trade->remaining, $trade->commission,8);
                    $debitamt = ncAdd($trade->remaining,$sellfee);
                    Wallet::debitEscrowAmount($uid, $pair->coinone, $debitamt, 8,'selltrade',$remark,$tuid);
                }
                $trade->status = 7;
                $trade->status_text = 'Cancelled';
                $trade->remarks = $remarks;
                $trade->save();
            }
            $is_match = MarketPlace::where(['tuid' => $tuid])->whereIn('status',[0,1,2])->first();
            if(is_object($is_match)){
                $is_match->status = 0;
                $is_match->is_hold = 0;
                $is_match->status_text = 'Pending';
                $is_match->remarks = $remarks;
                $is_match->save();
            }
            DB::commit();
            return  back()->with('success',"Trade cancelled successfully!");
        }catch(Exception $e){
            DB::rollBack();
            return  back()->with('fail',"Something went wrong please try again later!");
        }
    }
    public function proofUpload(Request $request){
        $validator = $this->validate($request, [
            'orderID' => 'required|alpha_dash|max:60',
            'slipupload' => 'required|mimes:jpeg,jpg,png|max:2048',
        ]);
        $uid = Auth::user()->id;
        $orderid = $request->orderID;
        $trade = MarketPlace::where(['order_id' => $orderid,'uid' => $uid])->whereIn('status',[2])->first();
        if(!is_object($trade)){
            return abort(404);
        }
        DB::beginTransaction();
        try
        {
            $expired = Carbon::now()->addMinutes(15);
            if($this->imgvalidaion($_FILES['slipupload']['tmp_name']) == 1){
                if($request->hasFile('slipupload')){
                    $dir = 'slipupload/';
                    $path = 'storage' . DIRECTORY_SEPARATOR . $dir;
                    $location = 'storage'. DIRECTORY_SEPARATOR. $dir;

                    $slip = $request->File('slipupload');
                    $filenamewithextension = $slip->getClientOriginalName();
                    $photnam = str_replace('.','',microtime(true));
                    $filename = pathinfo($photnam, PATHINFO_FILENAME);
                    $extension = $slip->getClientOriginalExtension();
                    $photo = $filename.'.'. $extension;
                    $slip->move($path, $photo);
                    $slip_img = url($location.$photo);

                }else{
                    return  back()->with('fail','Upload Proof image may be crashed.please to upload another image!');
                }                

            } else{
                return  back()->with('fail','Upload Proof image may be crashed.please to upload another image!');
            }
            $trade->slipupload = $slip_img;
            $trade->status = 3;
            $trade->status_text = 'Waiting for seller release fund!';
            $trade->closed_at =  $expired;
            $trade->save();

            $getMatch =  MarketPlace::where(['id' => $trade->tuid])->first();
            $getMatch->slipupload = $slip_img;
            $getMatch->closed_at =  $expired;
            $getMatch->status = 3;
            $getMatch->status_text = 'Buyer request release fund!';
            $getMatch->save();

            //Mail
            try {
                $pair = Tradepair::where(['id' => $trade->pair,'active' => 1])->first();
                $escrow_volume = $trade->escrow_volume;          
                $matchVol = $escrow_volume." ".$pair->coinone;

                $sellername = $getMatch->user['first_name'].' '. $getMatch->user['last_name'];
                $selleremail = $getMatch->user['email'];

                Mail::send('email.p2p.requestpayment-buyer', ['name' => $sellername,'order' => $getMatch,'selectPair' => $pair], function($message) use ($selleremail,$matchVol) {
                    $message->subject("Payment made successfully by the Buyer $matchVol for your Sell Trade!");
                    $message->to($selleremail);
                });
            } catch (\Swift_TransportException $e){
                    //dd($e);
            } catch (Exception $e){
                //dd($e);
            }


            DB::commit();
            return  back()->with('success',"Slip upload successfully!");
        }catch(Exception $e){
            DB::rollBack();
            return  back()->with('fail',"Something went wrong please try again later!");
        }
    }
    public function notReceived(Request $request){
       // dd();
        $uid = Auth::user()->id;
        $orderid = $request->orderID;
        $trade = MarketPlace::where(['order_id' => $orderid,'uid' => $uid])->whereIn('status',[3])->first();
        if(!is_object($trade)){
            return abort(404);
        }
        $expired = Carbon::now()->addMinutes(30);
        //$time = Carbon::parse($trade->closed_at);
        //$expired = $time->addMinutes(30);

        $trade->closed_at =  $expired;
        $trade->updated_at = date('Y-m-d H:i:s',time());
        $trade->save();

        $getMatch =  MarketPlace::where(['id' => $trade->tuid])->first();
        $getMatch->closed_at =  $expired;
        $getMatch->updated_at = date('Y-m-d H:i:s',time());
        $getMatch->save();
        return  back()->with('success',"Time extended successfully!");

    }

    public function completeP2p(Request $request){
        //dd($request->status);
        $validator = $this->validate($request, [
            'orderID' => 'required|alpha_dash|max:90',
            'status' => 'required|alpha_dash|max:60',
        ]);

        $uid = Auth::user()->id;
        $orderid = $request->orderID;
        $trade = MarketPlace::where(['order_id' => $orderid,'uid' => $uid])->whereIn('status',[3])->first();
        if(!is_object($trade)){
            return abort(404);
        }
        DB::beginTransaction();
        try
        {
            $pair = Tradepair::where(['id' => $trade->pair,'active' => 1])->first();
            //Update Seller
            $escrow_volume = $trade->escrow_volume;
            $sellfee = ncMul($escrow_volume, $trade->commission,8);
            $debitamt = ncAdd($trade->escrow_volume,$sellfee);
            Wallet::clearEscrowAmount($uid, $pair->coinone, $debitamt, 8);

            $remaining = ncSub($trade->remaining,$trade->escrow_volume); 
            if($remaining == 0){
                $trade->filled = ncAdd($trade->filled,$trade->escrow_volume);
                $trade->remaining = $remaining;
                $trade->status = 100;
                $trade->status_text = 'Completed';
                //$trade->escrow_volume = 0;
                $trade->updated_at = date('Y-m-d H:i:s',time());
                $trade->save();
            }else{
                $trade->filled = ncAdd($trade->filled,$trade->escrow_volume);
                $trade->remaining = $remaining;
                $trade->status = 0;
                $trade->status_text = 'Partialy Filled';
                $trade->escrow_volume = 0;
                $trade->is_hold = 0;
                $trade->updated_at = date('Y-m-d H:i:s',time());
                $trade->save();
            }
            //Update Buyer
            $getMatch =  MarketPlace::where(['id' => $trade->tuid])->first();

            $remaining = ncSub($getMatch->remaining,$escrow_volume); 
            if($remaining == 0){
                $getMatch->filled = ncAdd($getMatch->filled,$escrow_volume);
                $getMatch->remaining = $remaining;
                $getMatch->status = 100;
                $getMatch->status_text = 'Completed';
                //$getMatch->escrow_volume = 0;
                $getMatch->updated_at = date('Y-m-d H:i:s',time());
                $getMatch->save();
            }else{
                $getMatch->filled = ncAdd($getMatch->filled,$escrow_volume);
                $getMatch->remaining = $remaining;
                $getMatch->status = 0;
                $getMatch->status_text = 'Partialy Filled';
                $getMatch->escrow_volume = 0;
                $getMatch->is_hold = 0;
                $getMatch->updated_at = date('Y-m-d H:i:s',time());
                $getMatch->save();
            }
            $remark= "P2P Trade complete $pair->coinone / $pair->cointwo";
            $buyfee     = ncMul($escrow_volume, $getMatch->commission,8);
            $creditAmt = ncSub($escrow_volume,$buyfee); 
            Wallet::creditAmount($getMatch->uid, $pair->coinone, $creditAmt, 8,"buytrade",$remark,$getMatch->id);

            $type = 'Buy';
            $oldprice = MatchHistory::where('pair',$pair->id)->orderBy('id', 'desc')->value('price');
            if($oldprice > $trade->price){
                 $type = 'Sell';
            }
            $complete = new MatchHistory;
            $complete->pair = $pair->id;
            $complete->type = $type;
            $complete->buytrade_id = $getMatch->id;
            $complete->selltrade_id = $trade->id;
            $complete->price = $trade->price;
            $complete->volume = $escrow_volume;
            $complete->value = ncMul($trade->price,$escrow_volume);
            $complete->save();

            $pair->live_price = $trade->price;
            $pair->save();
            //Mail
            try {          
                $matchVol = $escrow_volume." ".$pair->coinone;
                $buyername = $trade->tradeuser['first_name'].' '. $trade->tradeuser['last_name'];
                $buyeremail = $trade->tradeuser['email'];

                $sellername = $trade->user['first_name'].' '. $trade->user['last_name'];
                $selleremail = $trade->user['email'];

                Mail::send('email.p2p.completepayment-buyer', ['sellername' => $buyername,'relasecoin' => $matchVol], function($message) use ($buyeremail,$matchVol) {
                    $message->subject("Buy Trade $matchVol completed!");
                    $message->to($buyeremail);
                });

                Mail::send('email.p2p.completepayment-seller', ['sellername' => $sellername,'relasecoin' => $matchVol], function($message) use ($selleremail,$matchVol) {
                    $message->subject("Sell Trade $matchVol completed!");
                    $message->to($selleremail);
                });
            } catch (\Swift_TransportException $e){
                    //dd($e);
            } catch (Exception $e){
                //dd($e);
            }            

            DB::commit();
            return  back()->with('success',"Trade completed successfully!");
        }catch(Exception $e){
            DB::rollBack();
            return  back()->with('fail',"Something went wrong please try again later!");
        }
    }

    public function filterSellTrade(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'buypair'   => 'required|numeric|min:1',
            'search_offer_critical_price'  => 'nullable|numeric|min:0',
            'search_offer_amount' => 'nullable|numeric|min:0',
        ]);
        if ($validator->fails()) { 
            $data['status'] = "fail";
            $data['msg'] = "<div class='alert alert-danger   alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><div id='buylimitwarning'>All fields required!</div></div>";
            return  $data;          
        }
        $uid = Auth::user()->id;
        $selectPair =  Tradepair::where(['id' => $request->buypair,'active' => 1])->first();
        $pair = $selectPair->id;
        $coinone = $selectPair->coinone;
        $cointwo = $selectPair->cointwo;
        if(isset($request->search_offer_critical_price) && isset($request->search_offer_amount)){
            $price = $request->search_offer_critical_price;
            $amount = $request->search_offer_amount;
            $selltrades = MarketPlace::where([['pair', '=', $pair],['trade_type', '=', 'Sell'],['status', '=', 0], ['uid', '!=', $uid], ['price', '<=', $price], ['remaining', '>=', $amount]])->orderBy('price','Asc')->get();
        }else if(isset($request->search_offer_critical_price)){
            $price = $request->search_offer_critical_price;
            $selltrades = MarketPlace::where([['pair', '=', $pair],['trade_type', '=', 'Sell'],['status', '=', 0], ['uid', '!=', $uid], ['price', '<=', $price]])->orderBy('price','Asc')->get();
        }else if(isset($request->search_offer_amount)){
            $amount = $request->search_offer_amount;
            $selltrades = MarketPlace::where([['pair', '=', $pair],['trade_type', '=', 'Sell'],['status', '=', 0], ['uid', '!=', $uid], ['remaining', '>=', $amount]])->orderBy('price','Asc')->get();
        }else{
            $selltrades = MarketPlace::where([['pair', '=', $pair],['trade_type', '=', 'Sell'],['status', '=', 0], ['uid', '!=', $uid]])->orderBy('price','Asc')->get();
        }

        return view('ajax.selltradefilter',['coinone' => $coinone, 'cointwo' => $cointwo,'selectPair' => $selectPair,'selltrades' => $selltrades]);
    }
    public function updateXID(Request $request)
    {
        $this->validate($request, [
            'xid' => 'required|alpha_dash|unique:users|max:25',
        ]);
        
        $user = Auth::user();
        $user->xid = $request->xid;
        $user->save();
        return  back()->with('success',"Your XID has been set successfully. Start placing order now!");
    }
    public function filterBuyTrade(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sellpair'   => 'required|numeric|min:1',
            'search_order_critical_price'  => 'nullable|numeric|min:0',
            'search_order_amount' => 'nullable|numeric|min:0',
        ]);
        if ($validator->fails()) { 
            $data['status'] = "fail";
            $data['msg'] = "<div class='alert alert-danger   alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><div id='buylimitwarning'>All fields required!</div></div>";
            return  $data;          
        }
        $uid = Auth::user()->id;
        $selectPair =  Tradepair::where(['id' => $request->sellpair,'active' => 1])->first();
        $pair = $selectPair->id;
        $coinone = $selectPair->coinone;
        $cointwo = $selectPair->cointwo;
        
        if(isset($request->search_order_critical_price) && isset($request->search_order_amount)){
            $price = $request->search_order_critical_price;
            $amount = $request->search_order_amount;
            $selltrades = MarketPlace::where([['pair', '=', $pair],['trade_type', '=', 'Buy'],['status', '=', 0], ['uid', '!=', $uid], ['price', '>=', $price], ['remaining', '>=', $amount]])->orderBy('price','Desc')->get();
        }else if(isset($request->search_order_critical_price)){
            $price = $request->search_order_critical_price;
            $selltrades = MarketPlace::where([['pair', '=', $pair],['trade_type', '=', 'Buy'],['status', '=', 0], ['uid', '!=', $uid], ['price', '>=', $price]])->orderBy('price','Desc')->get();
        }else if(isset($request->search_order_amount)){
            $amount = $request->search_order_amount;
            $selltrades = MarketPlace::where([['pair', '=', $pair],['trade_type', '=', 'Buy'],['status', '=', 0], ['uid', '!=', $uid], ['remaining', '>=', $amount]])->orderBy('price','Desc')->get();
        }else{
            $selltrades = MarketPlace::where([['pair', '=', $pair],['trade_type', '=', 'Buy'],['status', '=', 0], ['uid', '!=', $uid]])->orderBy('price','Desc')->get();
        }
        

        return view('ajax.buytradefilter',['coinone' => $coinone, 'cointwo' => $cointwo,'selectPair' => $selectPair,'buytrades' => $selltrades]);
    }

    public function buyMarketCreate(Request $request){
        $validator = Validator::make($request->all(), [
            'buypair'   => 'required|numeric|min:1',
            'search_offer_critical_price'  => 'required|numeric|min:0',
            'search_offer_amount' => 'required|numeric|min:0',
            'xid' => 'nullable|string',
        ]);
        if ($validator->fails()) { 
            $data['status'] = "fail";
            $data['msg'] = "<div class='alert alert-danger   alert-dismissible'>All fields required!</div>";
            return  $data;          
        }
        $xid        = $request->xid;
        $buypair    = (int)$request->buypair;
        $buyprice   = (float)$request->search_offer_critical_price;
        $buyvolume  = (float)$request->search_offer_amount;
        $uid = Auth::user()->id;
        if($buyprice <= 0 && $buyvolume <= 0){
            $data['status'] = "fail";
            $data['msg'] = "<div class='alert alert-danger   alert-dismissible'>Price and Amount must be greaterthan zero!</div>";
            return  $data;
        
        }        

        $pair = Tradepair::where(['id' => $buypair,'active' => 1])->first();
        if(!is_object($pair)){
            $data['status'] = "fail";
            $data['msg'] = "<div class='alert alert-danger   alert-dismissible'>Invalid trade pair!</div>";
            return  $data;
        }
        DB::beginTransaction();
        try
        {
            $pairID = $pair->id;
            $coinOne = $pair->coinone;
            $coinTwo = $pair->cointwo;

            $is_coinone = Commission::coindetails($pair->coinone);
            $is_cointwo = Commission::coindetails($pair->cointwo);
            if($is_coinone->type == 'fiat'){
                $bankdetail = Bankuser::where(['uid' => $uid])->first();
                if(!$bankdetail){
                    $data['status'] = "fail";
                    $data['msg'] = "<div class='alert alert-danger   alert-dismissible'>Please fill your bank details!</div>";
                    return  $data;        
                }
            }

            if($pair->buy_trade > 0){
                $commission = bcdiv(sprintf('%.10f', $pair->buy_trade), 100, 8);
                $total      = bcmul(sprintf('%.10f', $buyprice), sprintf('%.10f', $buyvolume), 8);
                $buyfee     = bcmul(sprintf('%.10f', $buyvolume), sprintf('%.10f', $commission), 8);
                $debitamt   = $total;
            }else{
                $commission = 0;
                $total      = bcmul(sprintf('%.10f', $buyprice), sprintf('%.10f', $buyvolume), 8);
                $buyfee     = 0;
                $debitamt   = $total;
            }
            $balance = 0;        
            $obalance = 0;

            if($is_cointwo->type != 'fiat'){
                $wallet = Wallet::where([['uid', '=', $uid],['currency', '=', $pair->cointwo]])->first();
                if($wallet){
                    $balance = $wallet->balance;
                }
                if ((float)$balance < (float)$debitamt) {
                    $data['status'] = "fail";
                    $data['msg'] = "Insufficient funds in  $pair->cointwo Wallet!";
                    return  $data;
                }
                $obalance = Wallet::where([['uid', '=', $uid],['currency', '=', $pair->cointwo]])->value('balance');            
            }

            $orderId = TransactionString(20);

            $trade = new MarketPlace;
            $trade->uid = $uid;
            $trade->trade_type = "Buy";
            $trade->order_id = $orderId;
            $trade->xid = Auth::user()->xid;
            $trade->pair = $buypair;
            $trade->order_type = 1;
            $trade->price = $buyprice;
            $trade->volume = $buyvolume;
            $trade->value = $total;
            $trade->fees = $buyfee;
            $trade->commission = $commission;
            $trade->remaining = $trade->volume;
            $trade->status = 0;
            $trade->status_text = 'Pending';
            $trade->post_ty = 'web';
            $trade->balance = $obalance;        
            $trade->is_type = 0;
            $trade->filled= 0;
            $trade->created_at = date('Y-m-d H:i:s',time());
            $trade->save();

            $id = $trade->id;
            $order_id = $trade->order_id;            
            if($is_cointwo->type != 'fiat'){
                $remark ="P2P buy trade post on $pair->coinone / $pair->cointwo";
                Wallet::creditEscrowAmount($uid, $pair->cointwo, $debitamt, 8,'buytrade',$remark,$id);
            }

            $data['status'] = 'buylimitsuccess';
            $data['balance'] = $balance;
            $data['url'] = url('/p2p-matchorder/'.$order_id);
            $data['msg'] = "<div class='alert alert-success   alert-dismissible'>Post Trade Successfully!</div>";
            if($is_coinone->type != 'fiat' && $is_cointwo->type != 'fiat'){
                $this->checkMatchSellCrypto($id,$buypair,$buyprice,$buyvolume,$xid);
            }else{
                $this->checkMatchSell($id,$buypair,$buyprice,$buyvolume,$xid);
            }
            
            DB::commit();
            
            return  $data;
        } catch(Exception $e){
            //rollback here
            DB::rollBack();
            $data['status'] = 'fail';
            $data['msg'] = "<div id='buymarketsuccess' class='alerttext text-danger text-center'>Something went wrong, try again later!</div>";
            return $data;
        }
    }
    public function checkMatchSellCrypto($tid,$PID,$price,$amount,$xid=null){
        $pairID = (int)$PID;
        $price = (float)$price;
        $amount = (float)$amount;
        if($xid){
            $selltrades = MarketPlace::where([['pair', '=', $pairID],['trade_type', '=', 'Sell'],['status', '=', 0], ['price', '=', $price], ['remaining', '>=', $amount],['is_hold', '=', 0],['xid','=',$xid]])->orderBy('id','Asc')->first();
        }else{
            $selltrades = MarketPlace::where([['pair', '=', $pairID],['trade_type', '=', 'Sell'],['status', '=', 0], ['price', '=', $price], ['remaining', '>=', $amount],['is_hold', '=', 0]])->orderBy('id','Asc')->first();
        } 
        $pair = Tradepair::where(['id' => $pairID,'active' => 1])->first();       
        //dd($selltrades);
        if(is_object($selltrades)){
            //Update Seller
            $escrow_volume = $amount;
            $sellfee = ncMul($escrow_volume, $selltrades->commission,8);
            $debitamt = ncAdd($escrow_volume,$sellfee);
            Wallet::clearEscrowAmount($selltrades->uid, $pair->coinone, $debitamt, 8);

            $remaining = ncSub($selltrades->remaining,$amount); 
            if($remaining == 0){
                $selltrades->filled = ncAdd($selltrades->filled,$amount);
                $selltrades->remaining = $remaining;
                $selltrades->status = 100;
                $selltrades->status_text = 'Completed';
                //$trade->escrow_volume = 0;
                $selltrades->updated_at = date('Y-m-d H:i:s',time());
                $selltrades->save();
            }else{
                $selltrades->filled = ncAdd($selltrades->filled,$amount);
                $selltrades->remaining = $remaining;
                $selltrades->status = 0;
                $selltrades->status_text = 'Partialy Filled';
                $selltrades->escrow_volume = 0;
                $selltrades->is_hold = 0;
                $selltrades->updated_at = date('Y-m-d H:i:s',time());
                $selltrades->save();
            }
            $remark= "P2P Trade complete $pair->coinone / $pair->cointwo";
            $stotal = ncMul($selltrades->price,$escrow_volume);
            Wallet::creditAmount($selltrades->uid, $pair->cointwo, $stotal, 8,"selltrade",$remark,$selltrades->id);

            //Update Buyer
            $buytrade =  MarketPlace::where(['id' => $tid])->first();

            $remaining = ncSub($buytrade->remaining,$amount); 
            if($remaining == 0){
                $buytrade->filled = ncAdd($buytrade->filled,$escrow_volume);
                $buytrade->remaining = $remaining;
                $buytrade->status = 100;
                $buytrade->status_text = 'Completed';
                $buytrade->updated_at = date('Y-m-d H:i:s',time());
                $buytrade->save();
            }else{
                $buytrade->filled = ncAdd($buytrade->filled,$escrow_volume);
                $buytrade->remaining = $remaining;
                $buytrade->status = 0;
                $buytrade->status_text = 'Partialy Filled';
                $buytrade->escrow_volume = 0;
                $buytrade->is_hold = 0;
                $buytrade->updated_at = date('Y-m-d H:i:s',time());
                $buytrade->save();
            }
            $remark= "P2P Trade complete $pair->coinone / $pair->cointwo";
            $buyfee     = ncMul($escrow_volume, $buytrade->commission,8);
            $creditAmt = ncSub($escrow_volume,$buyfee);
            $btotal = ncMul($escrow_volume, $buytrade->price,8); 
            Wallet::clearEscrowAmount($buytrade->uid, $pair->cointwo, $btotal, 8);
            Wallet::creditAmount($buytrade->uid, $pair->coinone, $creditAmt, 8,"buytrade",$remark,$buytrade->id);

            $type = 'Buy';
            $oldprice = MatchHistory::where('pair',$pair->id)->orderBy('id', 'desc')->value('price');
            if($oldprice > $buytrade->price){
                 $type = 'Sell';
            }
            $complete = new MatchHistory;
            $complete->pair = $pair->id;
            $complete->type = $type;
            $complete->buytrade_id = $buytrade->id;
            $complete->selltrade_id = $selltrades->id;
            $complete->price = $buytrade->price;
            $complete->volume = $escrow_volume;
            $complete->value = ncMul($buytrade->price,$escrow_volume);
            $complete->save();

            $pair->live_price = $buytrade->price;
            $pair->save();
            //Mail
            try {          
                $matchVol = $escrow_volume." ".$pair->coinone;
                $buyername = $buytrade->user['first_name'].' '. $buytrade->user['last_name'];
                $buyeremail = $buytrade->user['email'];

                $sellername = $selltrades->user['first_name'].' '. $selltrades->user['last_name'];
                $selleremail = $selltrades->user['email'];

                Mail::send('email.p2p.completepayment-buyer', ['sellername' => $buyername,'relasecoin' => $matchVol], function($message) use ($buyeremail,$matchVol) {
                    $message->subject("Buy Trade $matchVol completed!");
                    $message->to($buyeremail);
                });

                Mail::send('email.p2p.completepayment-seller', ['sellername' => $sellername,'relasecoin' => $matchVol], function($message) use ($selleremail,$matchVol) {
                    $message->subject("Sell Trade $matchVol completed!");
                    $message->to($selleremail);
                });
            } catch (\Swift_TransportException $e){
                    //dd($e);
            } catch (Exception $e){
                //dd($e);
            }
        }
        return $selltrades;
        
    }
    public function checkMatchSell($tid,$PID,$price,$amount,$xid=null){
        $pairID = (int)$PID;
        $price = (float)$price;
        $amount = (float)$amount;
        if($xid){
            $selltrades = MarketPlace::where([['pair', '=', $pairID],['trade_type', '=', 'Sell'],['status', '=', 0], ['price', '=', $price], ['remaining', '>=', $amount],['is_hold', '=', 0],['xid','=',$xid]])->orderBy('id','Asc')->first();
        }else{
            $selltrades = MarketPlace::where([['pair', '=', $pairID],['trade_type', '=', 'Sell'],['status', '=', 0], ['price', '=', $price], ['remaining', '>=', $amount],['is_hold', '=', 0]])->orderBy('id','Asc')->first();
        } 
        $pair = Tradepair::where(['id' => $pairID,'active' => 1])->first();       
        //dd($selltrades);
        if(is_object($selltrades)){
            $expired = Carbon::now()->addMinutes(15);           
            
            $status_text = "Request to buyer release fund";
            $status = 1;
            $received = ncMul($price,$amount);
            $buyername = $selltrades->user['first_name'].' '. $selltrades->user['last_name'];
            $buyeremail = $selltrades->user['email'];
            $b_ouid = $selltrades->uid;
            $b_tuid = $selltrades->id;
            //Update Buyer
            MarketPlace::where('id',$tid)->update(['ouid' => $b_ouid,'tuid' => $b_tuid, 'buyer' => $buyername, 'status' => 1, 'is_hold' => 1, 'status_text' => $status_text,'received' => $received , 'escrow_volume' => $amount,'closed_at' =>  $expired,'updated_at' => date('Y-m-d H:i:s',time())]);
            //Update Seller
            $trade = MarketPlace::where('id',$tid)->first();
            $sellername = $trade->user['first_name'].' '. $trade->user['last_name'];            
            $selleremail = $trade->user['email'];            
            $s_ouid = $trade->uid;            
            $s_tuid = $trade->id;  
            
            MarketPlace::where('id',$selltrades->id)->update(['ouid' => $s_ouid,'tuid' => $s_tuid, 'buyer' => $sellername, 'status' => 1, 'is_hold' => 1, 'status_text' => $status_text,'received' => $received , 'escrow_volume' => $amount,'closed_at' =>  $expired,'updated_at' => date('Y-m-d H:i:s',time())]);

            //Mail
            try {          
                $matchVol = $amount." ".$pair->coinone;
                $buytrade = MarketPlace::where('id',$tid)->first();
                $selltrade = MarketPlace::where('id',$selltrades->id)->first();

                Mail::send('email.p2p.Match-buyer', ['name' => $sellername,'order' => $buytrade,'selectPair' => $pair], function($message) use ($selleremail,$matchVol) {
                    $message->subject("Seller matched for your $matchVol order. Make Payment!");
                    $message->to($selleremail);
                });

                Mail::send('email.p2p.Match-seller', ['name' => $buyername,'order' => $selltrade,'selectPair' => $pair], function($message) use ($buyeremail,$matchVol) {
                    $message->subject("Buyer matched for your $matchVol order. Make Payment!");
                    $message->to($buyeremail);
                });
            } catch (\Swift_TransportException $e){
                    //dd($e);
            } catch (Exception $e){
                //dd($e);
            }

            return $trade;
        }
        return $selltrades;
        
    }
    public function checkMatchBuy($tid,$PID,$price,$amount,$xid=null){
        $pairID = (int)$PID;
        $price = (float)$price;
        $amount = (float)$amount;
        if($xid){
            $selltrades = MarketPlace::where([['pair', '=', $pairID],['trade_type', '=', 'Buy'],['status', '=', 0], ['price', '=', $price], ['remaining', '>=', $amount],['is_hold', '=', 0],['xid','=',$xid]])->orderBy('id','Asc')->first();
        }else{
            $selltrades = MarketPlace::where([['pair', '=', $pairID],['trade_type', '=', 'Buy'],['status', '=', 0], ['price', '=', $price], ['remaining', '>=', $amount],['is_hold', '=', 0]])->orderBy('id','Asc')->first();
        }
        $pair = Tradepair::where(['id' => $pairID,'active' => 1])->first();        
        //dd($selltrades);
        if(is_object($selltrades)){
            $expired = Carbon::now()->addMinutes(15);           
            
            $status_text = "Request to buyer release fund";
            $status = 1;
            $received = ncMul($price,$amount);
            $buyername = $selltrades->user['first_name'].' '. $selltrades->user['last_name'];
            $buyeremail = $selltrades->user['email'];
            $b_ouid = $selltrades->uid;
            $b_tuid = $selltrades->id;
            //Update Seller
            MarketPlace::where('id',$tid)->update(['ouid' => $b_ouid,'tuid' => $b_tuid, 'buyer' => $buyername, 'status' => 1, 'is_hold' => 1, 'status_text' => $status_text,'received' => $received , 'escrow_volume' => $amount,'closed_at' =>  $expired,'updated_at' => date('Y-m-d H:i:s',time())]);
            //Update Buyer
            $trade = MarketPlace::where('id',$tid)->first();
            $sellername = $trade->user['first_name'].' '. $trade->user['last_name'];
            $selleremail = $trade->user['email'];            
            $s_ouid = $trade->uid;            
            $s_tuid = $trade->id;  
            
            MarketPlace::where('id',$selltrades->id)->update(['ouid' => $s_ouid,'tuid' => $s_tuid, 'buyer' => $sellername, 'status' => 1, 'is_hold' => 1, 'status_text' => $status_text,'received' => $received , 'escrow_volume' => $amount,'closed_at' =>  $expired,'updated_at' => date('Y-m-d H:i:s',time())]);
            //Mail
            try {          
                $matchVol = $amount." ".$pair->coinone;
                $buytrade = MarketPlace::where('id',$selltrades->id)->first();
                $selltrade = MarketPlace::where('id',$tid)->first();

                Mail::send('email.p2p.Match-buyer', ['name' => $buyername,'order' => $buytrade,'selectPair' => $pair], function($message) use ($buyeremail,$matchVol) {
                    $message->subject("Seller matched for your $matchVol order. Make Payment!");
                    $message->to($buyeremail);
                });

                Mail::send('email.p2p.Match-seller', ['name' => $sellername,'order' => $selltrade,'selectPair' => $pair], function($message) use ($selleremail,$matchVol) {
                    $message->subject("Buyer matched for your $matchVol order. Make Payment!");
                    $message->to($selleremail);
                });
            } catch (\Swift_TransportException $e){
                    //dd($e);
            } catch (Exception $e){
                //dd($e);
            }

            return $trade;
        }
        return $selltrades;
        
    }
    public function checkMatchBuyCrypto($tid,$PID,$price,$amount,$xid=null){
        $pairID = (int)$PID;
        $price = (float)$price;
        $amount = (float)$amount;
        if($xid){
            $buytrade = MarketPlace::where([['pair', '=', $pairID],['trade_type', '=', 'Buy'],['status', '=', 0], ['price', '=', $price], ['remaining', '>=', $amount],['is_hold', '=', 0],['xid','=',$xid]])->orderBy('id','Asc')->first();
        }else{
            $buytrade = MarketPlace::where([['pair', '=', $pairID],['trade_type', '=', 'Buy'],['status', '=', 0], ['price', '=', $price], ['remaining', '>=', $amount],['is_hold', '=', 0]])->orderBy('id','Asc')->first();
        } 
        $pair = Tradepair::where(['id' => $pairID,'active' => 1])->first();       
        //dd($selltrades);
        if(is_object($buytrade)){
            //Update Seller
            $selltrades =  MarketPlace::where(['id' => $tid])->first();
            
            $escrow_volume = $amount;
            $sellfee = ncMul($escrow_volume, $selltrades->commission,8);
            $debitamt = ncAdd($escrow_volume,$sellfee);
            Wallet::clearEscrowAmount($selltrades->uid, $pair->coinone, $debitamt, 8);

            $remaining = ncSub($selltrades->remaining,$amount); 
            if($remaining == 0){
                $selltrades->filled = ncAdd($selltrades->filled,$amount);
                $selltrades->remaining = $remaining;
                $selltrades->status = 100;
                $selltrades->status_text = 'Completed';
                //$trade->escrow_volume = 0;
                $selltrades->updated_at = date('Y-m-d H:i:s',time());
                $selltrades->save();
            }else{
                $selltrades->filled = ncAdd($selltrades->filled,$amount);
                $selltrades->remaining = $remaining;
                $selltrades->status = 0;
                $selltrades->status_text = 'Partialy Filled';
                $selltrades->escrow_volume = 0;
                $selltrades->is_hold = 0;
                $selltrades->updated_at = date('Y-m-d H:i:s',time());
                $selltrades->save();
            }
            $remark= "P2P Trade complete $pair->coinone / $pair->cointwo";
            $stotal = ncMul($amount, $selltrades->price,8);
            Wallet::creditAmount($selltrades->uid, $pair->cointwo, $stotal, 8,"selltrade",$remark,$selltrades->id);
            
            //Update Buyer
            $remaining = ncSub($buytrade->remaining,$amount); 
            if($remaining == 0){
                $buytrade->filled = ncAdd($buytrade->filled,$escrow_volume);
                $buytrade->remaining = $remaining;
                $buytrade->status = 100;
                $buytrade->status_text = 'Completed';
                $buytrade->updated_at = date('Y-m-d H:i:s',time());
                $buytrade->save();
            }else{
                $buytrade->filled = ncAdd($buytrade->filled,$escrow_volume);
                $buytrade->remaining = $remaining;
                $buytrade->status = 0;
                $buytrade->status_text = 'Partialy Filled';
                $buytrade->escrow_volume = 0;
                $buytrade->is_hold = 0;
                $buytrade->updated_at = date('Y-m-d H:i:s',time());
                $buytrade->save();
            }
            $remark= "P2P Trade complete $pair->coinone / $pair->cointwo";
            $buyfee     = ncMul($escrow_volume, $buytrade->commission,8);
            $creditAmt = ncSub($escrow_volume,$buyfee);
            $btotal = ncMul($escrow_volume, $buytrade->price,8); 
            Wallet::clearEscrowAmount($buytrade->uid, $pair->cointwo, $btotal, 8);
            Wallet::creditAmount($buytrade->uid, $pair->coinone, $creditAmt, 8,"buytrade",$remark,$buytrade->id);

            $type = 'Buy';
            $oldprice = MatchHistory::where('pair',$pair->id)->orderBy('id', 'desc')->value('price');
            if($oldprice > $buytrade->price){
                 $type = 'Sell';
            }
            $complete = new MatchHistory;
            $complete->pair = $pair->id;
            $complete->type = $type;
            $complete->buytrade_id = $buytrade->id;
            $complete->selltrade_id = $selltrades->id;
            $complete->price = $buytrade->price;
            $complete->volume = $escrow_volume;
            $complete->value = ncMul($buytrade->price,$escrow_volume);
            $complete->save();

            $pair->live_price = $buytrade->price;
            $pair->save();
            //Mail
            try {          
                $matchVol = $escrow_volume." ".$pair->coinone;
                $buyername = $buytrade->user['first_name'].' '. $buytrade->user['last_name'];
                $buyeremail = $buytrade->user['email'];

                $sellername = $selltrades->user['first_name'].' '. $selltrades->user['last_name'];
                $selleremail = $selltrades->user['email'];

                Mail::send('email.p2p.completepayment-buyer', ['sellername' => $buyername,'relasecoin' => $matchVol], function($message) use ($buyeremail,$matchVol) {
                    $message->subject("Buy Trade $matchVol completed!");
                    $message->to($buyeremail);
                });

                Mail::send('email.p2p.completepayment-seller', ['sellername' => $sellername,'relasecoin' => $matchVol], function($message) use ($selleremail,$matchVol) {
                    $message->subject("Sell Trade $matchVol completed!");
                    $message->to($selleremail);
                });
            } catch (\Swift_TransportException $e){
                    //dd($e);
            } catch (Exception $e){
                //dd($e);
            }
        }
        return $buytrade;
        
    }
    public function sellMarketCreate(Request $request){
        $validator = Validator::make($request->all(), [
            'sellpair' => 'required|numeric|min:1',
            'search_order_critical_price' => 'required|numeric|min:0',
            'search_order_amount' => 'required|numeric|min:0',
            'xid' => 'nullable|string',
        ]);
        if ($validator->fails()) { 
            $data['status'] = "fail";
            $data['msg'] = "<div class='alert alert-danger   alert-dismissible'>All fields required!</div>";
            return  $data;          
        }
        $xid        = $request->xid;
        $sellpair    = (int)$request->sellpair;
        $price   = (float)$request->search_order_critical_price;
        $volume  = (float)$request->search_order_amount;
        $uid = Auth::user()->id;
        if($price <= 0 && $volume <= 0){
            $data['status'] = "fail";
            $data['msg'] = "<div class='alert alert-danger   alert-dismissible'>Price and Amount must be greaterthan zero!</div>";
            return  $data;
        }        
        $pair = Tradepair::where(['id' => $sellpair,'active' => 1])->first();
        if(!is_object($pair)){
            $data['status'] = "fail";
            $data['msg'] = "<div class='alert alert-danger   alert-dismissible'>Invalid trade pair!</div>";
            return  $data;
        }
        DB::beginTransaction();
        try
        {
            $is_coinone = Commission::coindetails($pair->coinone);
            $is_cointwo = Commission::coindetails($pair->cointwo);
            if($is_cointwo->type == 'fiat'){
                $bankdetail = Bankuser::where(['uid' => $uid])->first();
                if(!$bankdetail){
                    $data['status'] = "fail";
                    $data['msg'] = "<div class='alert alert-danger   alert-dismissible'>Please fill your bank details!</div>";
                    return  $data;        
                }
            }
            
            if($pair->buy_trade > 0){
                $commission = bcdiv(sprintf('%.10f', $pair->sell_trade), 100, 8);
                $total      = bcmul(sprintf('%.10f', $price), sprintf('%.10f', $volume), 8);
                $fee     = bcmul(sprintf('%.10f', $volume), sprintf('%.10f', $commission), 8);
                $debitamt = ncAdd($volume,$fee);
            }else{
                $commission = 0;
                $total      = bcmul(sprintf('%.10f', $price), sprintf('%.10f', $volume), 8);
                $fee     = 0;
                $debitamt = $volume;
            }
            $pairID = $pair->id;
            $balance = 0;
            if($is_coinone->type != 'fiat'){
                $wallet = Wallet::where([['uid', '=', $uid],['currency', '=', $pair->coinone]])->first();
                if($wallet){
                    $balance = $wallet->balance;
                }
                if ((float)$balance < (float)$debitamt) {
                    $data['status'] = "fail";
                    $data['msg'] = "<div class='alert alert-danger   alert-dismissible'>Insufficient funds in  $pair->coinone Wallet!</div>";
                    return  $data;
                }
                $obalance = Wallet::where([['uid', '=', $uid],['currency', '=', $pair->coinone]])->value('balance');
            }

            $orderId = TransactionString(20);

            $trade = new MarketPlace;
            $trade->uid = $uid;
            $trade->trade_type = "Sell";
            $trade->xid = Auth::user()->xid;
            $trade->order_id = $orderId;
            $trade->pair = $pairID;
            $trade->order_type = 1;
            $trade->price = $price;
            $trade->volume = $volume;
            $trade->value = $total;
            $trade->fees = $fee;
            $trade->commission = $commission;
            $trade->remaining = $trade->volume;
            $trade->status = 0;
            $trade->status_text = 'Pending';
            $trade->post_ty = 'web';
            $trade->balance = $obalance;
            if($is_cointwo->type == 'fiat'){
                $trade->account_name = $bankdetail->account_name;
                $trade->account_no = $bankdetail->account_no;
                $trade->bank_name = $bankdetail->bank_name;
                $trade->bank_branch = $bankdetail->bank_branch;
                $trade->paypal_id = $bankdetail->paypal_id;
                $trade->swift_code = $bankdetail->swift_code;
                $trade->branch_code = $bankdetail->branch_code;
            }
            $trade->is_type = 0;
            $trade->filled= 0;
            $trade->created_at = date('Y-m-d H:i:s',time());
            $trade->save();

            $id = $trade->id;
            $order_id = $trade->order_id;
            
            if($is_coinone->type != 'fiat'){
                $remark ="P2P sell trade post on $pair->coinone / $pair->cointwo";
                Wallet::creditEscrowAmount($uid, $pair->coinone, $debitamt, 8,'selltrade',$remark,$id);
            }
            $data['status'] = 'sellsuccess';
            $data['balance'] = $balance;
            $data['url'] = url('/p2p-matchorder/'.$order_id);
            $data['msg'] = "<div class='alert alert-success   alert-dismissible'>Post Trade Successfully!</div>";
            if($is_coinone->type != 'fiat' && $is_cointwo->type != 'fiat'){
                $this->checkMatchBuyCrypto($id,$pairID,$price,$volume,$xid);
            }else{
                $this->checkMatchBuy($id,$pairID,$price,$volume,$xid);
            }            
            DB::commit();
            
            return  $data;
        }catch(Exception $e){
            //rollback here
            DB::rollBack();
            $data['status'] = 'fail';
            $data['msg'] = "<div class='alerttext text-danger text-center'>Something went wrong, try again later!</div>";
            return $data;
        }
    }

    public function buyComplete(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric|min:1',
            'sellvolume' => 'required|numeric|min:0',
        ]);
        if ($validator->fails()) { 
            $data['status'] = "fail";
            $data['msg'] = "All fields required!";
            return  $data;          
        }
        $id = $request->id;
        $uid = Auth::user()->id;
        $volume = $request->sellvolume;
        $market = MarketPlace::where(['status' => 0,'trade_type' => 'Sell', 'id' => $id])->first();
        if(is_object($market)){
            $pair = Tradepair::where(['id' => $market->pair,'active' => 1])->first();
            if(!is_object($pair)){
                $data['status'] = "fail";
                $data['msg'] = "Invalid trade pair!";
                return  $data;
            }
            $price = $market->price;
            $total = ncMul($price,$volume);
            $balance = 0;
            $pairID = $pair->id;
            $wallet = Wallet::where([['uid', '=', $uid],['currency', '=', $pair->cointwo]])->first();
            if($wallet){
                $balance = $wallet->balance;
            }
            if ((float)$balance < (float)$total) {
                $data['status'] = "fail";
                $data['msg'] = "Insufficient funds in $pair->cointwo Wallet!";
                return  $data;
            }
            if($market->remaining < $volume){
                $data['status'] = "fail";
                $data['msg'] = "Only available Quantity ".$market->remaining;
                return  $data;
            }            

            $remaining = ncSub($market->remaining, $volume);
            if($pair->buy_trade > 0){
                $commission = bcdiv(sprintf('%.10f', $pair->buy_trade), 100, 8);
                $total      = bcmul(sprintf('%.10f', $price), sprintf('%.10f', $volume), 8);
                $buyfee     = bcmul(sprintf('%.10f', $volume), sprintf('%.10f', $commission), 8);
            }else{
                $commission = 0;
                $total      = bcmul(sprintf('%.10f', $price), sprintf('%.10f', $volume), 8);
                $buyfee     = 0;
            }
            $orderId = TransactionString(20);
            $buyer = $market->user->first_name.' '.$market->user->last_name;
            $trade = MarketPlace::createTrade($uid,"Buy",$orderId,$pairID,$price,$volume,$total,$buyfee,$commission,0,1,'Completed',$obalance,$volume,$market->id,$market->uid,$buyer);
            // escrow balance
            $obalance = $balance;
            $balance = bcsub(sprintf('%.10f', $balance), sprintf('%.10f', $total), 8);
            $escrow = bcadd(sprintf('%.10f', $wallet->escrow_balance), sprintf('%.10f', $total), 8);
            $wallet = Wallet::where([
                ['uid', '=', $uid],
                ['currency', '=', $pair->cointwo],
            ])->update(['balance' => $balance, 'escrow_balance' => $escrow,'updated_at' => date('Y-m-d H:i:s',time())]);
            $tCurrency = $pair->coinone.'/'.$pair->cointwo;
            $this->AllcoinUpdateBalanceTrack($uid,$pair->cointwo,0,$total,$balance,$obalance,'trade','Buy P2P Market Trade '.$tCurrency,$trade);

            $complete_volume = ncSub($volume,$buyfee);
            $complete_total = ncSub($total,$market->fees);
            $pairs = array('one' => $pair->coinone, 'two' => $pair->cointwo);
            $tCurrency = $pair->coinone.'/'.$pair->cointwo;
            $buyerbalanceupdate = $this->updateBuyerbalance($uid, $complete_volume, $total, $pairs, 'Buy', $trade,$tCurrency);
            //Update balance to Seller
            $sellerbalanceupdate = $this->updateSellerbalance($market->uid, $complete_total, $volume, $pairs, 'Sell', $market->id,$tCurrency);
            if($remaining == 0){
                $update = array('remaining' => 0, 'status' => 1,'status_text' => 'COMPLETED','updated_at' => date('Y-m-d H:i:s',time()));
                $market->where('id', $market->id)->update($update);
            }

            $data['status'] = "success";
            $data['msg'] = "order Successfully!";
            return  $data;


        }
    }

    public function sellComplete(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric|min:1',
            'sellvolume' => 'required|numeric|min:0',
        ]);
        if ($validator->fails()) { 
            $data['status'] = "fail";
            $data['msg'] = "All fields required!";
            return  $data;          
        }
        $id = $request->id;
        $uid = Auth::user()->id;
        $volume = $request->sellvolume;
        $market = MarketPlace::where(['status' => 0,'trade_type' => 'Buy', 'id' => $id])->first();
        if(is_object($market)){
            $pair = Tradepair::where(['id' => $market->pair,'active' => 1])->first();
            if(!is_object($pair)){
                $data['status'] = "fail";
                $data['msg'] = "Invalid trade pair!";
                return  $data;
            }
            $price = $market->price;
            $total = ncMul($price,$volume);
            $balance = 0;
            $wallet = Wallet::where([['uid', '=', $uid],['currency', '=', $pair->coinone]])->first();
            if($wallet){
                $balance = $wallet->balance;
            }
            if ((float)$balance < (float)$volume) {
                $data['status'] = "fail";
                $data['msg'] = "Insufficient funds in $pair->coinone Wallet!";
                return  $data;
            }
            if($market->remaining < $volume){
                $data['status'] = "fail";
                $data['msg'] = "Only available Quantity ".$market->remaining;
                return  $data;
            }
            
            $remaining = ncSub($market->remaining, $volume);
            if($pair->sell_trade > 0){
                $commission = bcdiv(sprintf('%.10f', $pair->buy_trade), 100, 8);
                $total      = bcmul(sprintf('%.10f', $price), sprintf('%.10f', $volume), 8);
                $buyfee     = bcmul(sprintf('%.10f', $total), sprintf('%.10f', $commission), 8);
            }else{
                $commission = 0;
                $total      = bcmul(sprintf('%.10f', $price), sprintf('%.10f', $volume), 8);
                $buyfee     = 0;
            }
            $trade = MarketPlace::createTrade($uid,"Sell",$orderId,$pairID,$price,$volume,$total,$fee,$commission,$remaining,$status,$status_text,$obalance,$filled=0,$ouid=null,$tuid=null,$buyer=null);
            // escrow balance
            $obalance = $balance;
            $balance = bcsub(sprintf('%.10f', $balance), sprintf('%.10f', $volume), 8);
            $escrow = bcadd(sprintf('%.10f', $wallet->escrow_balance), sprintf('%.10f', $volume), 8);
            $wallet = Wallet::where([
                ['uid', '=', $uid],
                ['currency', '=', $pair->coinone],
            ])->update(['balance' => $balance, 'escrow_balance' => $escrow,'updated_at' => date('Y-m-d H:i:s',time())]);
            $tCurrency = $pair->coinone.'/'.$pair->cointwo;
            $this->AllcoinUpdateBalanceTrack($uid,$pair->coinone,0,$volume,$balance,$obalance,'trade','Sell P2P Market Trade '.$tCurrency,$trade);
            
            $complete_volume = ncSub($volume,$buyfee);
            $complete_total = ncSub($total,$market->fees);
            $pairs = array('one' => $pair->coinone, 'two' => $pair->cointwo);
            $tCurrency = $pair->coinone.'/'.$pair->cointwo;
            $buyerbalanceupdate = $this->updateBuyerbalance($market->uid, $volume, $complete_total, $pairs, 'Buy', $trade,$tCurrency);
            //Update balance to Seller
            $sellerbalanceupdate = $this->updateSellerbalance($uid, $total, $complete_volume, $pairs, 'Sell', $market->id,$tCurrency);
            
            $data['status'] = "fail";
            $data['msg'] = "Only available Quantity ".$market->remaining;
            return  $data;


        }
    }
    /**
     * [updateBuyerbalance description]
     * @param  [int] $uid     [user ID]
     * @param  [float] $buy     [Buy Price]
     * @param  [float] $spent   [Amount of spent]
     * @param  [int] $pair    [Pair ID]
     * @param  [int] $type    [Order Type]
     * @param  [id] $tradeid [description]
     * @return void
     */
    public function updateBuyerbalance($uid, $buy, $spent, $pair, $type, $tradeid,$tCurrency = null) {

        $remark = 'P2P Buy Trade '.$tCurrency;
        // credit price
        $this->creditAmount($uid, $pair['one'], $buy,$remark,$tradeid);
        // debit price
        $this->debitAmount($uid, $pair['two'], $spent);
        return;
    }

    /**
     * [updateSellerbalance description]
     * @param  [int] $uid     [user ID]
     * @param  [float] $buy     [Buy Price]
     * @param  [float] $spent   [Amount of spent]
     * @param  [int] $pair    [Pair ID]
     * @param  [int] $type    [Order Type]
     * @param  [id] $tradeid [description]
     * @return void
     */
    public function updateSellerbalance($uid, $buy, $spent, $pair, $type, $tradeid,$tCurrency=null) {
        $remark = 'Completed Sell Trade '.$tCurrency;
        // credit price
        $this->creditAmount($uid, $pair['two'], $buy,$remark,$tradeid);
        // debit price
        $this->debitAmount($uid, $pair['one'], $spent);
        return;
    }

    /**
     * [adminBalanceUpdate description]
     * @param  [string] $currency [Curreny name]
     * @param  [float] $price    [price value]
     * @return void
     */
    public function adminBalanceUpdate($currency, $price,$type=null) {
        $adminbalance = Adminwallet::where('currency', '=', $currency)->first();
        if ($adminbalance) {
            $total_bal = ncAdd($price, $adminbalance->balance, 8);
            $total_cmn = ncAdd($price, $adminbalance->commission, 8);
            $trade     = ncAdd($price, $adminbalance->trade, 8);
            if($type == 'buy'){
                $buytrade     = ncAdd($price, $adminbalance->buytrade, 8);
                $selltrade    = $adminbalance->selltrade;
            }else{
                $buytrade     = $adminbalance->buytrade;
                $selltrade    = ncAdd($price, $adminbalance->selltrade, 8);
            }
            Adminwallet::where('currency', '=', $currency)->update(['balance' => $total_bal, 'commission' => $total_cmn, 'trade'=>$trade, 'buytrade'=>$buytrade,'selltrade'=>$selltrade,'updated_at' => date('Y-m-d H:i:s')]);
        } else {
             if($type == 'buy'){
                $buytrade     = $price;
                $selltrade    = 0;
            }else{
                $buytrade     = 0;
                $selltrade    = $price;
            }
            Adminwallet::insert(['currency' => $currency, 'balance' => $price, 'commission' => $price, 'trade'=>$price, 'buytrade'=>$buytrade,'selltrade'=>$selltrade,'created_at' => date('Y-m-d H:i:s',time()), 'updated_at' => date('Y-m-d H:i:s',time())]);
        }
    }

    /**
     * [creditAmount description]
     * @param  [int] $uid      [user ID]
     * @param  [string] $currency [Currency Name]
     * @param  [float] $price    [price value]
     * @return void
     */
    public function creditAmount($uid, $currency, $price,$remark =null,$insertid) {
        $userbalance = Wallet::where([['uid', '=', $uid], ['currency', '=', $currency]])->first();
        if ($userbalance) {
            $oldbalance = $userbalance->balance;
            $total = bcadd(sprintf('%.10f', $price), sprintf('%.10f', $userbalance->balance), 8);
            Wallet::where([['uid', '=', $uid], ['currency', '=', $currency]])->update(['balance' => $total], ['updated_at' => date('Y-m-d H:i:s')]);

            $walletbalance = $total;
        } else {
            $oldbalance = 0;
            Wallet::insert(['uid' => $uid, 'currency' => $currency, 'balance' => $price, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
            $walletbalance = $price;
        }

        $this->AllcoinUpdateBalanceTrack($uid,$currency,$price,0,$walletbalance,$oldbalance,'trade',$remark,$insertid);
    }

    public function affliatAmount($uid,$coin,$amount,$type,$price,$volume){     
        AffliateTransaction::affliate_transaction($uid,$coin,$amount,$type,$price,$volume);
        return true;
    }

    /**
     * [debitAmount description]
     * @param  [int] $uid      [user ID]
     * @param  [string] $currency [Currency Name]
     * @param  [float] $price    [price value]
     * @return void
     */
    public function debitAmount($uid, $currency, $price) {
        $userbalance = Wallet::where([['uid', '=', $uid], ['currency', '=', $currency]])->first();
        if ($userbalance) {
            $total = bcsub(sprintf('%.10f', $userbalance->escrow_balance), sprintf('%.10f', $price), 8);
            Wallet::where([['uid', '=', $uid], ['currency', '=', $currency]])->update(['escrow_balance' => $total, 'updated_at' => date('Y-m-d H:i:s')]);
        }
    }
    /**
     * [creditStopAmount description]
     * @param  [int] $uid          [User ID]
     * @param  [string] $currency     [Currency Name]
     * @param  [float] $price        [Price Value]
     * @param  [float] $remain_price [Remainig Price]
     * @return void
     */
    public function creditStopAmount($uid, $currency, $price, $remain_price,$insertid) {
        $userbalance = Wallet::where([['uid', '=', $uid], ['currency', '=', $currency]])->first();
        $oldbalance = $userbalance->balance;
        if ($userbalance) {
            $total = bcsub(sprintf('%.10f', $userbalance->escrow_balance), sprintf('%.10f', $remain_price), 8);
            $baltotal = bcadd(sprintf('%.10f', $price), sprintf('%.10f', $userbalance->balance), 8);
            Wallet::where([['uid', '=', $uid], ['currency', '=', $currency]])->update(['balance' => $baltotal, 'escrow_balance' => $total, 'updated_at' => date('Y-m-d H:i:s')]);
            $walletbalance = $baltotal;
            $this->AllcoinUpdateBalanceTrack($uid,$currency,$price,0,$walletbalance,$oldbalance,'trade','Best price complete to remaining balance return',$insertid);
        }       

    }

    public function AllcoinUpdateBalanceTrack($uid,$currency,$creditamount=0,$debitamount=0,$walletbalance=0,$oldbalance=null,$tradetype=null,$remark=null,$insertid)
    {
        if($creditamount > 0 || $debitamount > 0)
        {
            $Models = '\App\Models\OverallTransaction';
            $Models::AddTransaction($uid,$currency,$tradetype,$creditamount,$debitamount,$walletbalance,$oldbalance,$remark,'web',$insertid);
        }
        return true;
    }
    public function trade()
    {
        $uid = Auth::user()->id;        
        $listPairs = Tradepair::where([['active', '=', 1],['is_market', '=', 1]])->orderBy('id', 'desc')->get();
        $historys = MarketPlace::where(['uid'=> $uid])->orWhere(['ouid'=> $uid])->whereNotIn('status', [100,7])->orderBy('id', 'desc')->paginate(15);
        
        return view('p2phistory.trade',['listPairs' => $listPairs,'historys' => $historys]);
    }
    public function deposits()
    {
        $uid = Auth::user()->id;
        
        $coinsList = Commission::get();
        $historys = MarketPlace::where([['uid', '=', $uid],['status','=',100]])->orWhere(['ouid'=> $uid,'status' => 100])->orderBy('id', 'desc')->paginate(15); 
        
        return view('p2phistory.deposit',['coinsList' => $coinsList,'historys' => $historys]);
    }
    public function withdraw()
    {
        $uid = Auth::user()->id;
        $coinsList = Commission::get();
        $historys = MarketPlace::where([['uid', '=', $uid],['status','=',7]])->orWhere(['ouid'=> $uid,'status' => 7])->orderBy('id', 'desc')->paginate(15); 
        return view('p2phistory.withdraw',['coinsList' => $coinsList,'historys' => $historys]);
    }
    public function p2pBuy(Request $request)
    {
        $uid = Auth::user()->id; 
        try{
            $buyid = Crypt::decrypt($request->id);  
        }catch(\Illuminate\Contracts\Encryption\DecryptException $e){            
            return abort(404);

        }      
        $buyorder = MarketPlace::where(['id' => $buyid,'trade_type' => 'Sell'])->first();
        if(!is_object($buyorder)){
            return abort(404);
        }
        $selectPair =  Tradepair::where(['id' => $buyorder->pair,'active' => 1])->first();
        $pair = $selectPair->id;
        $type = $selectPair->cointwodetails['type'];
        $coinOne = $selectPair->coinone;
        $coinTwo = $selectPair->cointwo;

        return view('/p2pmarket.buy',['buyorder'=>$buyorder,'type' => $type,'coinOne' => $coinOne,'coinTwo' => $coinTwo]);
    }
    public function p2pSell(Request $request)
    {
        $uid = Auth::user()->id;
        $bankdetail = Bankuser::where(['uid' => $uid])->first();
        if(!$bankdetail){
            $data['status'] = "fail";
            $data['msg'] = "<div id='buylimitwarning' class='alerttext text-danger text-center'>Please fill your bank details!</div>";
            return  $data;
        
        }
        try{
            $sellid = Crypt::decrypt($request->id);
        }catch(\Illuminate\Contracts\Encryption\DecryptException $e){
            return abort(404);
        }       

        $sellorder = MarketPlace::where(['id' => $sellid,'trade_type' => 'Buy'])->first();
        if(!is_object($sellorder)){
            return abort(404);
        }
        $selectPair =  Tradepair::where(['id' => $sellorder->pair,'active' => 1])->first();
        $pair = $selectPair->id;
        $type = $selectPair->cointwodetails['type'];
        $coinOne = $selectPair->coinone;
        $coinTwo = $selectPair->cointwo;
        
        return view('/p2pmarket.sell',['sellorder'=>$sellorder,'bankuser'=>$bankdetail,'type' => $type,'coinOne' => $coinOne,'coinTwo' => $coinTwo]);
    }

    public function p2pBuyEdit(Request $request)
    {
        $uid = Auth::user()->id; 
        try{
            $buyid = Crypt::decrypt($request->id);  
        }catch(\Illuminate\Contracts\Encryption\DecryptException $e){
            return abort(404);
        }      
        $buyorder = MarketPlace::where(['id' => $buyid,'trade_type' => 'Buy'])->first();
        if(!is_object($buyorder)){
            return abort(404);
        }
        $selectPair =  Tradepair::where(['id' => $buyorder->pair,'active' => 1])->first();
        $pair = $selectPair->id;
        $type = $selectPair->cointwodetails['type'];
        $coinOne = $selectPair->coinone;
        $coinTwo = $selectPair->cointwo;
        $is_owner = 0;
        if($uid == $buyorder->uid){
            $is_owner = 1;
        }

        return view('/p2pmarket.buyupdate',['buyorder'=>$buyorder,'type' => $type,'coinOne' => $coinOne,'coinTwo' => $coinTwo,'is_owner' => $is_owner]);
    }
    public function p2pSellEdit(Request $request)
    {
        $uid = Auth::user()->id; 
        try{
            $buyid = Crypt::decrypt($request->id);  
        }catch(\Illuminate\Contracts\Encryption\DecryptException $e){
            return abort(404);
        }      
        $buyorder = MarketPlace::where(['id' => $buyid,'trade_type' => 'Sell'])->first();
        if(!is_object($buyorder)){
            return abort(404);
        }
        $selectPair =  Tradepair::where(['id' => $buyorder->pair,'active' => 1])->first();
        $pair = $selectPair->id;
        $type = $selectPair->cointwodetails['type'];
        $coinOne = $selectPair->coinone;
        $coinTwo = $selectPair->cointwo;
        $is_owner = 0;
        if($uid == $buyorder->uid){
            $is_owner = 1;
        }

        return view('/p2pmarket.sellupdate',['sellorder'=>$buyorder,'type' => $type,'coinOne' => $coinOne,'coinTwo' => $coinTwo,'is_owner' => $is_owner]);
    }
    public function p2pBuyupload(Request $request){
        $validator = $this->validate($request, [
            'amount' => 'required|numeric|max:10000000',
            'id' => 'required',
            'paymenttype' => 'in:Bank,Paypal,Crypto',
        ]);
        try{
            $buyid = Crypt::decrypt($request->id);  
        }catch(\Illuminate\Contracts\Encryption\DecryptException $e){
            return abort(404);
        }
        $uid = Auth::user()->id;
        $buyorder = MarketPlace::where(['id' => $buyid,'trade_type' => 'Sell','status' => 0])->first();
        if(!is_object($buyorder)){
            return redirect()->back()->with('failed', 'Invalid data given.please try again!');
        }       
        $amount = $request->amount; 
        $paymenttype = $request->paymenttype; 
        $remaining =$buyorder->remaining;
        if($amount > $remaining){
            return redirect()->back()->with('failed', 'Only avaliable quantity '.$remaining);
        }
        $remainQty = ncSub($remaining,$amount,8);

        $selectPair =  Tradepair::where(['id' => $buyorder->pair,'active' => 1])->first();
        $pair = $selectPair->id;
        $type = $selectPair->cointwodetails['type'];
        $orderId = TransactionString(20);
        $total = ncMul($buyorder->price,$amount);
        $coinOne = $selectPair->coinone;
        $coinTwo = $selectPair->cointwo;
        if($selectPair->buy_trade > 0){
            $commission = bcdiv(sprintf('%.10f', $selectPair->buy_trade), 100, 8);
            $buyfee     = bcmul(sprintf('%.10f', $amount), sprintf('%.10f', $commission), 8);
        }else{
            $commission = 0;
            $buyfee     = 0;
        }
        if($type == 'fiat'){
            $validator = $this->validate($request, [
                'slipupload' => 'required|mimes:jpeg,jpg,png|max:2048',
            ]);
            if($this->imgvalidaion($_FILES['slipupload']['tmp_name']) == 1){
                if($request->hasFile('slipupload')){
                    $dir = 'slipupload/';
                    $path = 'storage' . DIRECTORY_SEPARATOR .'app'. DIRECTORY_SEPARATOR.'public'. DIRECTORY_SEPARATOR. $dir;
                    $location = 'storage' . DIRECTORY_SEPARATOR .'app'. DIRECTORY_SEPARATOR.'public'. DIRECTORY_SEPARATOR. $dir;

                    $slip = $request->File('slipupload');
                    $filenamewithextension = $slip->getClientOriginalName();
                    $photnam = str_replace('.','',microtime(true));
                    $filename = pathinfo($photnam, PATHINFO_FILENAME);
                    $extension = $slip->getClientOriginalExtension();
                    $photo = $filename.'.'. $extension;
                    $slip->move($path, $photo);
                    $slip_img = url($location.$photo);

                }else{
                    return  back()->with('failed','Upload Proof image may be crashed.please to upload another image!');
                }                

            } else{
                return  back()->with('failed','Upload Proof image may be crashed.please to upload another image!');
            }
            $status_text = "Request to seller release fund";
            $status = 2;
            $filled = 0;
            $obalance = 0;
            $is_Credit = false;
        }else{
            $slip_img = "";
            $filled = $amount;
            $status_text = "Completed";
            $status = 100;
            $buyorder->filled = ncAdd($buyorder->filled,$amount);            
            $is_Credit = true; 
            $obalance = 0;
            $wallet = Wallet::where([['uid', '=', $uid],['currency', '=', $coinTwo]])->first();
            if($wallet){
                $obalance = $wallet->balance;
            }
            if($obalance < $total){
                return  back()->with('failed',"Insufficient funds in $coinTwo Wallet!");
            }           
        }
        $trade = new MarketPlace;
        $trade->uid = $uid;
        $trade->trade_type = "Buy";
        $trade->ouid = $buyorder->uid;
        $trade->tuid = $buyorder->id;
        $trade->buyer = $buyorder->user['first_name'].' '. $buyorder->user['last_name'];
        $trade->order_id = $orderId;
        $trade->pair = $buyorder->pair;
        $trade->order_type = 1;
        $trade->price = $buyorder->price;
        $trade->volume = $amount;
        $trade->value = $total;
        $trade->fees = $buyfee;
        $trade->commission = $commission;
        $trade->remaining = $amount;
        $trade->status = $status;
        $trade->status_text = $status_text;
        $trade->buyer_status = 1;
        $trade->seller_status = 0;
        $trade->slipupload = $slip_img;
        $trade->paymenttype = $paymenttype;
        $trade->account_name = $buyorder->account_name;
        $trade->account_no = $buyorder->account_no;
        $trade->bank_name = $buyorder->bank_name;
        $trade->bank_branch = $buyorder->bank_branch;
        $trade->paypal_id = $buyorder->paypal_id;
        $trade->swift_code = $buyorder->swift_code;
        $trade->branch_code = $buyorder->branch_code;
        $trade->post_ty = 'web';
        $trade->balance = $obalance;        
        $trade->is_type = 0;
        $trade->filled= $filled;
        $trade->created_at = date('Y-m-d H:i:s',time());
        $trade->save();
        
        $buyorder->remaining = $remainQty;
        if($remainQty == 0){
            $buyorder->status = 100;
            $buyorder->status_text = 'Completed';
        }
        $buyorder->updated_at = date('Y-m-d H:i:s',time());
        $buyorder->save();

        $sellername = $buyorder->user['first_name'].' '. $buyorder->user['last_name'];
        $relasecoin = $coinOne;
        $selleremail = $buyorder->user['email'];
        Mail::send('email.p2p.requestpayment-buyer', ['sellername' => $sellername,'coin' => $relasecoin], function($message) use ($selleremail) {
            
            $message->subject("Buyer requset release fund!");
            $message->to($selleremail);
        });

        if($is_Credit){
            //Buyer Amount Credit
            $creditBuyer = ncSub($amount,$buyfee,8);
            $this->creditAmount($uid, $coinOne, $creditBuyer,"P2P Buy complete $coinOne/$coinTwo",$trade->id);
            Wallet::debitAmount($uid,$coinTwo,$total,8,'p2pbuy',"P2P Buy complete $coinOne/$coinTwo",$trade->id);
            //Seller Amount Credit
            $this->creditAmount($buyorder->uid, $coinTwo, $total,"P2P Sell complete $coinOne/$coinTwo",$buyorder->id);
            $this->debitAmount($buyorder->uid, $coinOne, $amount);

            $relasecoin = $amount.' '.$coinOne;
            $sellername = $buyorder->user['first_name'].' '. $buyorder->user['last_name'];
            $selleremail = $buyorder->user['email'];
            Mail::send('email.p2p.completepayment-buyer', ['sellername' => $sellername,'relasecoin' => $relasecoin], function($message) use ($selleremail) {
                
                $message->subject("Sell Trade $tCurrency completed!");
                $message->to($selleremail);
            });
            $buyername = Auth::user()->first_name.' '.Auth::user()->last_name;
            $buyeremail = Auth::user()->email;
            Mail::send('email.p2p.completepayment-seller', ['sellername' => $buyername,'relasecoin' => $relasecoin], function($message) use ($buyeremail) {
                
                $message->subject("Sell Trade $tCurrency completed!");
                $message->to($buyeremail);
            });
            return  back()->with('success','Your trade is Successfully completed!');
        }
        return  back()->with('success','Your trade is waiting for seller approval!');

    }

    public function p2pSellupload(Request $request){
        $validator = $this->validate($request, [
            'amount' => 'required|numeric|max:10000000',
            'id' => 'required',
            'paymenttype' => 'in:Bank,Paypal,Both,Crypto',
        ]);
        try{
            $buyid = Crypt::decrypt($request->id);  
        }catch(\Illuminate\Contracts\Encryption\DecryptException $e){
            return abort(404);
        }
        $uid = Auth::user()->id;
        $buyorder = MarketPlace::where(['id' => $buyid,'trade_type' => 'Buy','status' => 0])->first();
        if(!is_object($buyorder)){
            return redirect()->back()->with('failed', 'Invalid data given.please try again!');
        }       
        $amount = $request->amount; 
        $paymenttype = $request->paymenttype; 
        $remaining =$buyorder->remaining;
        if($amount > $remaining){
            return redirect()->back()->with('failed', 'Only avaliable quantity '.$remaining);
        }
        $bankdetail = Bankuser::where(['uid' => $uid])->first();
        if(!$bankdetail){
            return redirect()->back()->with('failed', 'Please fill your bank details or Paypal Details!');        
        }

        $remainQty = ncSub($remaining,$amount,8);

        $selectPair =  Tradepair::where(['id' => $buyorder->pair,'active' => 1])->first();
        $pair = $selectPair->id;
        $type = $selectPair->cointwodetails['type'];
        $orderId = TransactionString(20);
        $total = ncMul($buyorder->price,$amount);
        $coinOne = $selectPair->coinone;
        $coinTwo = $selectPair->cointwo;
        if($selectPair->sell_trade > 0){
            $commission = bcdiv(sprintf('%.10f', $selectPair->sell_trade), 100, 8);
            $buyfee     = bcmul(sprintf('%.10f', $amount), sprintf('%.10f', $commission), 8);
        }else{
            $commission = 0;
            $buyfee     = 0;
        }
        $selldebit = ncAdd($amount,$buyfee);
        $balance = 0;
        $wallet = Wallet::where([['uid', '=', $uid],['currency', '=', $coinOne]])->first();
        if($wallet){
            $balance = $wallet->balance;
        }
        if ((float)$balance < (float)$selldebit) {
            return  back()->with('failed',"Insufficient funds in $coinOne Wallet! You need $selldebit $coinOne in your wallet!");
        }
        $obalance = Wallet::where([['uid', '=', $uid],['currency', '=', $coinOne]])->value('balance');
        $balance = bcsub(sprintf('%.10f', $balance), sprintf('%.10f', $selldebit), 8);
        $escrow  = bcadd(sprintf('%.10f', $wallet->escrow_balance), sprintf('%.10f', $selldebit), 8);
        $wallet  = Wallet::where([['uid', '=', $uid],['currency', '=', $coinOne]])->update(['balance' => $balance, 'escrow_balance' => $escrow]);

        $tCurrency = $coinOne.'/'.$coinTwo;
        

        if($type == 'fiat'){
            $status_text = "Request to buyer release fund";
            $status = 1;
            $filled = 0;
            $is_Credit = false;

            $sellername = $buyorder->user['first_name'].' '. $buyorder->user['last_name'];
            $relasecoin = $total.' '.$coinTwo;
            $selleremail = $buyorder->user['email'];
            Mail::send('email.p2p.requestpayment-seller', ['sellername' => $sellername,'relasecoin' => $relasecoin], function($message) use ($selleremail) {
                
                $message->subject("Seller requset release fund!");
                $message->to($selleremail);
            });

        }else{
            $slip_img = "";
            $filled = $amount;
            $status_text = "Completed";
            $status = 100;
            $buyorder->filled = ncAdd($buyorder->filled,$amount);            
            $is_Credit = true;

            $relasecoin = $amount.' '.$coinOne;
            $sellername = $buyorder->user['first_name'].' '. $buyorder->user['last_name'];
            $selleremail = $buyorder->user['email'];
            Mail::send('email.p2p.completepayment-seller', ['sellername' => $sellername,'relasecoin' => $relasecoin], function($message) use ($selleremail) {
                
                $message->subject("Sell Trade $tCurrency completed!");
                $message->to($selleremail);
            });
            $buyername = Auth::user()->first_name.' '.Auth::user()->last_name;
            $buyeremail = Auth::user()->email;
            Mail::send('email.p2p.completepayment-buyer', ['sellername' => $buyername,'relasecoin' => $relasecoin], function($message) use ($buyeremail) {                
                $message->subject("Sell Trade $tCurrency completed!");
                $message->to($buyeremail);
            });
        }
        $trade = new MarketPlace;
        $trade->uid = $uid;
        $trade->trade_type = "Sell";
        $trade->ouid = $buyorder->uid;
        $trade->tuid = $buyorder->id;
        $trade->buyer = $buyorder->user['first_name'].' '. $buyorder->user['last_name'];
        $trade->order_id = $orderId;
        $trade->pair = $buyorder->pair;
        $trade->order_type = 1;
        $trade->price = $buyorder->price;
        $trade->volume = $amount;
        $trade->value = $total;
        $trade->fees = $buyfee;
        $trade->commission = $commission;
        $trade->remaining = $amount;
        $trade->status = $status;
        $trade->status_text = $status_text;
        $trade->buyer_status = 1;
        $trade->seller_status = 0;
        $trade->slipupload = null;
        $trade->paymenttype = $paymenttype;
        $trade->account_name = $bankdetail->account_name;
        $trade->account_no = $bankdetail->account_no;
        $trade->bank_name = $bankdetail->bank_name;
        $trade->bank_branch = $bankdetail->bank_branch;
        $trade->paypal_id = $bankdetail->paypal_id;
        $trade->swift_code = $bankdetail->swift_code;
        $trade->branch_code = $bankdetail->branch_code;
        $trade->post_ty = 'web';
        $trade->balance = $obalance;        
        $trade->is_type = 0;
        $trade->filled= $filled;
        $trade->created_at = date('Y-m-d H:i:s',time());
        $trade->save();

        $this->AllcoinUpdateBalanceTrack($uid,$coinOne,0,$selldebit,$balance,$obalance,'p2psell','Sell P2P Market Trade '.$tCurrency,$trade->id);

        $buyorder->remaining = $remainQty;
        if($remainQty == 0){
            $buyorder->status = 100;
            $buyorder->status_text = 'Completed';
        }
        $buyorder->updated_at = date('Y-m-d H:i:s',time());
        $buyorder->save();

        if($is_Credit){
            //Seller Amount Credit            
            $this->creditAmount($uid, $coinTwo, $total,"P2P Sell complete $coinOne/$coinTwo",$trade->id);
            $this->debitAmount($uid, $coinOne, $selldebit);
            //Buyer Amount Credit
            $buyfee     = bcmul(sprintf('%.10f', $amount), sprintf('%.10f', $buyorder->commission), 8);
            $creditBuyer = ncSub($amount,$buyfee,8);
            $this->creditAmount($buyorder->uid, $coinOne, $creditBuyer,"P2P Buy complete $coinOne/$coinTwo",$buyorder->id);
            $debitBuyer = ncMul($buyorder->price,$amount);
            $this->debitAmount($buyorder->uid, $coinTwo, $debitBuyer);
            return  back()->with('success','Your trade is Successfully completed!');
        }
        return  back()->with('success','Your trade is waiting for seller approval!');

    }
    public function buyerUpdate(Request $request){
        $validator = $this->validate($request, [
            'id' => 'required',
            'remarks' => 'required|max:120',
            'status' => 'required|numeric|max:101',
        ]);
        try{
            $buyid = Crypt::decrypt($request->id);  
        }catch(\Illuminate\Contracts\Encryption\DecryptException $e){
            return abort(404);
        }
        $uid = Auth::user()->id;
        $buyorder = MarketPlace::where(['id' => $buyid,'trade_type' => 'Buy'])->first();
        if(!is_object($buyorder)){
            return redirect()->back()->with('failed', 'Invalid data given.please try again!');
        }
        $remarks = $request->remarks;
        $status = $request->status;
        $is_owner = 0;
        if($uid == $buyorder->uid){
            $is_owner = 1;
        }
        if($is_owner == 1){
            if($status  == 7){
                $buyorder->status = 100;
                $buyorder->status_text = 'Cancelled';
                $buyorder->remarks = $remarks;
                $buyorder->save();
                $sellorder = MarketPlace::where(['id' => $buyorder->tuid,'trade_type' => 'Sell'])->first();
                if(is_object($sellorder)){
                    $bremaining = ncAdd($sellorder->remaining,$buyorder->remaining);
                    $sellorder->remaining = $bremaining;
                    $sellorder->status_text = 'Pending';
                    $sellorder->status = 0;
                    $sellorder->save();
                }
                return redirect()->back()->with('success', 'Your trade is Successfully Cancelled!');
            } else if($status  == 5){
                $buyorder->status = 5;
                $buyorder->status_text = 'Buyer Rise Dispute Query';
                $buyorder->remarks = $remarks;
                $buyorder->save();
                $user = Auth::user();
                try {
                    Mail::send('email.p2p.dispute-admin', ['user' => $user], function($message) use ($user) {
                        $message->from($user->email,$user->first_name.' '.$user->last_name);
                        $message->subject("Buyer Rise Dispute Query");
                        $message->to('support@switchex.io');
                    });
                    Mail::send('email.p2p.dispute-user', ['user' => $user], function($message) use ($user) {
                        
                        $message->subject("Buyer Rise Dispute Query");
                        $message->to($user->email);
                    });
                } catch (Exception $e){
                dd($e);
                }
                return redirect()->back()->with('success', 'Your Query Successfully submit to admin!');
            } else{
                return redirect()->back()->with('failed', 'Invalid data given.please try again!');
            }
        } else{
            if($status  == 4){
                $buyorder->status = 4;
                $buyorder->status_text = 'Seller Cancelled Request';
                $buyorder->remarks = $remarks;
                $buyorder->save();
                return redirect()->back()->with('success', 'Your trade is Successfully Cancelled!');
            }else if($status  == 6){
                $buyorder->status = 6;
                $buyorder->status_text = 'Seller Request Dispute Query';
                $buyorder->remarks = $remarks;
                $buyorder->save();
                $user = Auth::user();
                try {
                    Mail::send('email.p2p.dispute-admin', ['user' => $user], function($message) use ($user) {
                        $message->from($user->email,$user->first_name.' '.$user->last_name);
                        $message->subject("Seller Request Dispute Query");
                        $message->to('support@switchex.io');
                    });
                    Mail::send('email.p2p.dispute-user', ['user' => $user], function($message) use ($user) {
                        
                        $message->subject("Rise Dispute Query");
                        $message->to($user->email);
                    });
                } catch (Exception $e){
                dd($e);
                }
                return redirect()->back()->with('success', 'Your Query Successfully submit to admin!');
            }else if($status  == 100){
                $selectPair =  Tradepair::where(['id' => $buyorder->pair,'active' => 1])->first();
                $amount = $buyorder->remaining;
                $total = ncMul($buyorder->price,$buyorder->remaining);
                $coinOne = $selectPair->coinone;
                $coinTwo = $selectPair->cointwo;

                $buyorder->remaining = 0;
                $buyorder->status = 100;
                $buyorder->status_text = 'Completed';
                $buyorder->remarks = $remarks;
                $buyorder->save();

                $sellorder = MarketPlace::where(['id' => $buyorder->tuid,'trade_type' => 'Sell'])->first();
                //Seller Amount debit
                $sellfee = bcmul(sprintf('%.10f', $amount), sprintf('%.10f', $sellorder->commission), 8);
                $selldebit = ncAdd($amount,$sellfee,8);
                $this->debitAmount($uid, $coinOne, $selldebit);
                $bremaining = ncSub($sellorder->remaining,$amount);
                if($bremaining == 0){
                    $sellorder->remaining = 0;
                    $sellorder->status_text = 'Completed';
                    $sellorder->status = 100;
                    $sellorder->save();
                }
                //Buyer Credit
                $buyfee     = bcmul(sprintf('%.10f', $amount), sprintf('%.10f', $buyorder->commission), 8);
                $creditBuyer = ncSub($amount,$buyfee,8);
                $this->creditAmount($buyorder->uid, $coinOne, $creditBuyer,"P2P Buy complete $coinOne/$coinTwo",$buyorder->id);

                $tCurrency = $coinOne.'/'.$coinTwo;
                $relasecoin = $amount.' '.$coinOne;
                $sellername = $buyorder->user['first_name'].' '. $buyorder->user['last_name'];
                $selleremail = $buyorder->user['email'];
                Mail::send('email.p2p.completepayment-seller', ['sellername' => $sellername,'relasecoin' => $relasecoin], function($message) use ($selleremail) {
                    
                    $message->subject("Sell Trade $tCurrency completed!");
                    $message->to($selleremail);
                });
                $buyername = Auth::user()->first_name.' '.Auth::user()->last_name;
                $buyeremail = Auth::user()->email;
                Mail::send('email.p2p.completepayment-buyer', ['sellername' => $buyername,'relasecoin' => $relasecoin], function($message) use ($buyeremail) {
                    
                    $message->subject("Sell Trade $tCurrency completed!");
                    $message->to($buyeremail);
                });

                return redirect()->back()->with('success', 'Your Trade Successfully Completed!');
            } else{
                return redirect()->back()->with('failed', 'Invalid data given.please try again!');
            }
        }
    }
    public function sellerUpdate(Request $request){
        $validator = $this->validate($request, [
            'id' => 'required',
            'remarks' => 'required|max:120',
            'status' => 'required|numeric|max:101',
        ]);
        try{
            $buyid = Crypt::decrypt($request->id);  
        }catch(\Illuminate\Contracts\Encryption\DecryptException $e){
            return abort(404);
        }
        $uid = Auth::user()->id;
        $sellorder = MarketPlace::where(['id' => $buyid,'trade_type' => 'Sell'])->first();
        if(!is_object($sellorder)){
            return redirect()->back()->with('failed', 'Invalid data given.please try again!');
        }
        $remarks = $request->remarks;
        $status = $request->status;
        $is_owner = 0;
        if($uid == $sellorder->uid){
            $is_owner = 1;
        }
        if($is_owner == 1){
            $selectPair =  Tradepair::where(['id' => $sellorder->pair,'active' => 1])->first();
            $amount = $sellorder->remaining;
            $total = ncMul($sellorder->price,$sellorder->remaining);
            $coinOne = $selectPair->coinone;
            $coinTwo = $selectPair->cointwo;
            if($status  == 7){
                if($sellorder->status == 0){
                    $sellfee = ncMul($sellorder->remaining,$sellorder->commission);
                    $sellercredit = ncAdd($sellorder->remaining,$sellfee);
                    $this->creditAmount($sellorder->uid, $coinOne, $sellercredit,"P2P Sell cancel $coinOne/$coinTwo",$sellorder->id);
                    $sellorder->status = 7;
                    $sellorder->status_text = 'Cancelled';
                    $sellorder->remarks = $remarks;
                    $sellorder->save();
                } else{
                    $sellorder->status = 4;
                    $sellorder->status_text = 'Cancelled';
                    $sellorder->remarks = $remarks;
                    $sellorder->save();
                }
                return redirect()->back()->with('success', 'Your trade is Successfully Cancelled!');
            } else if($status  == 6){
                $sellorder->status = 6;
                $sellorder->status_text = 'Seller Rise Dispute Query';
                $sellorder->remarks = $remarks;
                $sellorder->save();
                try {
                    Mail::send('email.p2p.dispute-admin', ['user' => $user], function($message) use ($user) {
                        $message->from($user->email,$user->first_name.' '.$user->last_name);
                        $message->subject("Seller Request Dispute Query");
                        $message->to('support@switchex.io');
                    });
                    Mail::send('email.p2p.dispute-user', ['user' => $user], function($message) use ($user) {
                        
                        $message->subject("Rise Dispute Query");
                        $message->to($user->email);
                    });
                } catch (Exception $e){
                dd($e);
                }
                return redirect()->back()->with('success', 'Your Query Successfully submit to admin!');
            }else if($status  == 100){       

                $sellorder->remaining = 0;
                $sellorder->status = 100;
                $sellorder->status_text = 'Completed';
                $sellorder->remarks = $remarks;
                $sellorder->save();                
                //Seller Amount debit
                $sellfee = $sellorder->fees;
                $selldebit = ncAdd($amount,$sellfee,8);
                $this->debitAmount($uid, $coinOne, $selldebit);
                //Buyer Credit
                $buyorder = MarketPlace::where(['id' => $sellorder->tuid,'trade_type' => 'Buy'])->first();
                $buyfee     = bcmul(sprintf('%.10f', $amount), sprintf('%.10f', $buyorder->commission), 8);
                $creditBuyer = ncSub($amount,$buyfee,8);
                $bremaining = ncSub($buyorder->remaining,$amount);
                if($bremaining == 0){
                    $buyorder->remaining = 0;
                    $buyorder->status_text = 'Completed';
                    $buyorder->status = 100;
                    $buyorder->save();
                } else{
                    $buyorder->remaining = $bremaining;
                    $buyorder->save();
                }
                $this->creditAmount($buyorder->uid, $coinOne, $creditBuyer,"P2P Buy complete $coinOne/$coinTwo",$buyorder->id);

                $tCurrency = $coinOne.'/'.$coinTwo;
                $relasecoin = $amount.' '.$coinOne;
                $sellername = $buyorder->user['first_name'].' '. $buyorder->user['last_name'];
                $selleremail = $buyorder->user['email'];
                Mail::send('email.p2p.completepayment-buyer', ['sellername' => $sellername,'relasecoin' => $relasecoin], function($message) use ($selleremail) {
                    
                    $message->subject("Sell Trade $tCurrency completed!");
                    $message->to($selleremail);
                });
                $buyername = Auth::user()->first_name.' '.Auth::user()->last_name;
                $buyeremail = Auth::user()->email;
                Mail::send('email.p2p.completepayment-seller', ['sellername' => $buyername,'relasecoin' => $relasecoin], function($message) use ($buyeremail) {
                    
                    $message->subject("Sell Trade $tCurrency completed!");
                    $message->to($buyeremail);
                });

                return redirect()->back()->with('success', 'Your Trade Successfully Completed!');
            } else{
                return redirect()->back()->with('failed', 'Invalid data given.please try again!');
            }
        } else{
            if($status  == 4){
                $sellorder->status = 7;
                $sellorder->status_text = 'Buyer Cancelled Request';
                $sellorder->remarks = $remarks;
                $sellorder->save();

                $sellfee = ncMul($sellorder->remaining,$sellorder->commission);
                $sellercredit = ncAdd($sellorder->remaining,$sellfee);
                $this->creditAmount($sellorder->uid, $coinOne, $sellercredit,"P2P Sell cancel $coinOne/$coinTwo",$sellorder->id);
                $buyorder = MarketPlace::where(['tuid' => $buyid,'trade_type' => 'Buy'])->first();
                $bremaining = ncAdd($sellorder->remaining,$buyorder->remaining);
                $buyorder->remaining = $bremaining;
                $buyorder->save();

                return redirect()->back()->with('success', 'Your trade is Successfully Cancelled!');
            }else if($status  == 6){
                $sellorder->status = 5;
                $sellorder->status_text = 'Buyer Request Dispute Query';
                $sellorder->remarks = $remarks;
                $sellorder->save();
                try {
                    Mail::send('email.p2p.dispute-admin', ['user' => $user], function($message) use ($user) {
                        $message->from($user->email,$user->first_name.' '.$user->last_name);
                        $message->subject("Buyer Request Dispute Query");
                        $message->to('support@switchex.io');
                    });
                    Mail::send('email.p2p.dispute-user', ['user' => $user], function($message) use ($user) {
                        
                        $message->subject("Rise Dispute Query");
                        $message->to($user->email);
                    });
                } catch (Exception $e){
                dd($e);
                }
                return redirect()->back()->with('success', 'Your Query Successfully submit to admin!');
            }else if($status  == 100){
                $validator = $this->validate($request, [
                    'slipupload' => 'required|mimes:jpeg,jpg,png|max:2048',
                ]);
                if($this->imgvalidaion($_FILES['slipupload']['tmp_name']) == 1){
                    if($request->hasFile('slipupload')){
                        $dir = 'slipupload/';
                        $path = 'storage' . DIRECTORY_SEPARATOR .'app'. DIRECTORY_SEPARATOR.'public'. DIRECTORY_SEPARATOR. $dir;
                        $location = 'storage' . DIRECTORY_SEPARATOR .'app'. DIRECTORY_SEPARATOR.'public'. DIRECTORY_SEPARATOR. $dir;

                        $slip = $request->File('slipupload');
                        $filenamewithextension = $slip->getClientOriginalName();
                        $photnam = str_replace('.','',microtime(true));
                        $filename = pathinfo($photnam, PATHINFO_FILENAME);
                        $extension = $slip->getClientOriginalExtension();
                        $photo = $filename.'.'. $extension;
                        $slip->move($path, $photo);
                        $slip_img = url($location.$photo);

                    }else{
                        return  back()->with('failed','Upload Proof image may be crashed.please to upload another image!');
                    }                

                } else{
                    return  back()->with('failed','Upload Proof image may be crashed.please to upload another image!');
                }
                $sellorder->status = 1;
                $sellorder->status_text = 'Buyer Request Release fund';
                $sellorder->remarks = $remarks;
                $sellorder->slipupload = $slip_img;
                $sellorder->save();
                return redirect()->back()->with('success', 'Your request Successfully submit to seller!');
            } else{
                return redirect()->back()->with('failed', 'Invalid data given.please try again!');
            }
        }
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

}