<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Tradepair;
use App\Models\Trade;
use App\Models\Wallet;
use App\Models\Completedtrade;

use Illuminate\Support\Facades\Crypt;

class TradeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','twofa' ,'kyc'])->except('tradingViewChart',
        'marketDepthChart');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($market=NULL)
    {
        if($market!=NULL){
            $coinpair = explode('_',$market);  
            $selectPair = Tradepair::where([
                ['coinone', '=', $coinpair[0]],
                ['cointwo', '=', $coinpair[1]],
                ['active', '=', 1],
                ['is_spot', '=', 1],
            ])->first();
        } else {
            $selectPair =  Tradepair::where(['active' => 1, 'is_spot' => 1])->orderBy('orderlist','Asc')->first();            
        }
        if(!$selectPair){
            return abort(404);
        }
        $pair = $selectPair->id;
        $uid = Auth::user()->id;
        $coinone = $selectPair->coinone;
        $cointwo = $selectPair->cointwo;
        $coinonebalance = Wallet::where(['uid'=> $uid,'currency'=> $coinone])->value('balance');
        $cointwobalance = Wallet::where(['uid'=> $uid,'currency'=> $cointwo])->value('balance');
        $trades = Tradepair::where(['active' => 1, 'is_spot' => 1])->orderBy('orderlist','Asc')->get();
        
        $complete = Completedtrade::where([['pair' ,'=' ,$pair]])->limit(200)->orderBy('id','DESC')->get();
        $openTrades = Trade::where(['uid' => $uid, 'status' => 0])->get();
        $closeTrades = Trade::where([['uid','=', $uid], ['status' ,'!=', 0]])->get();
        
        if(\Session::get('mode') ==''){
            \Session::put('mode','nightmode');
        }
        return view('trade',['coinone' => $coinone, 'cointwo' => $cointwo,'trades' => $trades,'selectPair' => $selectPair,'openTrades' => $openTrades,'closeTrades' => $closeTrades,'completes' => $complete,'coinonebalance' => $coinonebalance,'cointwobalance' => $cointwobalance]);
    }
    public function Update_Openorder(){
        $uid =Auth::user()->id;
          
           if(!isset($uid)){       
            return abort(404);
           }
        
        $openTrades = Trade::where(['uid' => $uid, 'status' => 0])->orderby('id','DESC')->get();  
        return view('openorders',['openTrades'=>$openTrades]);  
    }
    public function Update_Orderhistory(){
        $uid =Auth::user()->id;

           if(!isset($uid)){            
            return abort(404);
        }  
    
        $closeTrades = Trade::where([['uid','=', $uid], ['status' ,'!=', 0]])->orderby('id','DESC')->get();
        return view('orderhistory',['closeTrades'=>$closeTrades]);
    }
    public function Update_tradehistory(Request $request){

        try{
            $pair = Crypt::decrypt($request->id);  
        }catch(\Illuminate\Contracts\Encryption\DecryptException $e){            
            return abort(404);
        }
        $selectPair =  Tradepair::where(['id' => $pair])->first();
        $complete = Completedtrade::where([['pair' ,'=' ,$pair]])->limit(50)->orderBy('id','DESC')->get();
        $liqi = $selectPair->symbol;
        if($selectPair->is_bot == 1){
            $bots = json_decode(crul("https://api.dex-trade.com/v1/public/trades?pair=".$liqi));
        }else{
            $bots = array();
        }
        
        return view('tradehistory-update',['completes' => $complete,'bots' => $bots]);
   
    }
    public function marketView()
    {
        $trades = Tradepair::where('active',1)->orderBy('orderlist','Asc')->get();
        foreach ($trades as $pairs) 
        {
          /* market pair */
          $markets[$pairs->cointwo][] = $pairs->coinone;
        }
        $tabsTrades = Tradepair::where('active',1)->orderBy('orderlist','Asc')->take(4)->get();
        return view('market',['trades' => $trades,'tabsTrades' =>$tabsTrades,'marketpairs' => $markets]);
    }
    public function cancelTrade($id){
        $id = \Crypt::decrypt(($id));
        $uid = Auth::user()->id;
        $trades = Trade::where(['id' => $id, 'uid' => $uid, 'status' => 0])->first();
        if(!$trades){
            return abort(404);
        }
        if($trades->trade_type == 'Buy'){
            $this->Tradecancelbuyorder($trades->id);
        } else{
            $this->Tradecancelsellorder($trades->id);
        }
        return redirect()->back()->with('cancelerror', 'Bad Request!');        
    }
    public function Tradecancelbuyorder($id) {      

        //$id = \Crypt::decrypt(($id));
        $uid = Auth::user()->id;
        // Buy Trade
        $buytrades = Trade::where(['id' => $id, 'uid' => $uid, 'status' => 0])->first();
        if ($buytrades) {
            $price      = $buytrades->price;
            $volume     = $buytrades->remaining;
            $spend      = $buytrades->spend;
            $leverage   = $buytrades->leverage;
            $trdepair   = Tradepair::where(['active' => 1,'id' => $buytrades->pair])->first();
            $currency   = $trdepair->cointwo;
            $commission = $buytrades->commission;
            $value      = ncAdd($buytrades->value, $buytrades->fees,8);
            $selled     = 0;
            $fee        = ncAdd($buytrades->fees, $value, 8);
            $url = "/trades/".$trdepair->coinone.'_'.$trdepair->cointwo;
            if($trdepair->is_type == 1){
                $check = $this->cancelOrder($buytrades->pair,$buytrades->order_id);
                if($check->success == "true"){
                    $returnvalue = ncMul($price,$volume,8);
                    $returncommission = ncMul($returnvalue,$commission,8);
                    $total = ncAdd($returnvalue,$returncommission,8);
                    $leve_bal = 0; 
                    $pairname   = $trdepair->coinone.'/'.$trdepair->cointwo;
                    $this->creditAmountPending($uid, $currency, $total, $fee,$leve_bal,'buy',$pairname,$id);          
                    $buytrades->status_text = "CANCELLED";
                    $buytrades->status = 100;
                    $buytrades->save();
                }else{
                    $msg = $check->message;
                    return redirect($url)->with('cancelerror', 'Bad Request! '.$msg);
                }
            }else{
                if($buytrades->order_type !=2) {
                    $selled = Completedtrade::where('buytrade_id', $buytrades->id)->sum('value');
                    $selledcom = ncMul($selled,$commission,8);
                    $selltotal = ncAdd($selled,$selledcom,8);
                    $total = ncSub($value,$selltotal,8);
                    $value  = ncSub($buytrades->value, $selled, 8);
                }
                $fee        = ncAdd($buytrades->fees, $value, 8);
                $leve_bal = 0;     
                $pairname   = $trdepair->coinone.'/'.$trdepair->cointwo;
                $this->creditAmountPending($uid, $currency, $total, $fee,$leve_bal,'buy',$pairname,$id);

                $buytrades->status_text = "CANCELLED";
                $buytrades->status = 100;
                $buytrades->save();
            }
            \Session::flash('cancelsuccess', 'Pending order cancelled successfully!');
            return redirect($url)->with('cancelsuccess','Pending order cancelled successfully!');

        } else {
            return redirect()->back()->withErrors('cancelerror', 'Bad Request!');
        }
    }

    public function Tradecancelsellorder($id) {
        $uid = Auth::user()->id;
        // Buy Trade
        $selltrades = Trade::where(['id' => $id, 'uid' => $uid, 'status' => 0])->first();
        if ($selltrades) {
            $volume     = $selltrades->remaining;
            $spend      = $selltrades->spend;
            $leverage   = $selltrades->leverage;
            $trdepair   = Tradepair::where(['active' => 1,'id' => $selltrades->pair])->first();
            $currency   = $trdepair->coinone;
            $value      = $volume;
            $adminfee   = ncMul($value, $selltrades->commission, 8);
            $total      = ncAdd($value, $adminfee, 8);
            $fee        = ncAdd($selltrades->fees, $value, 8);
            $leve_bal = 0;            
            $url = "/trades/".$trdepair->coinone.'_'.$trdepair->cointwo;
            if($trdepair->is_type == 1){           
                $check = $this->cancelOrder($selltrades->pair,$selltrades->order_id);
                if($check->success == "true"){

                    $pairname   = $trdepair->coinone.'/'.$trdepair->cointwo;
                    $this->creditAmountPending($uid, $currency, $total, $fee,$leve_bal,'sell',$pairname,$id);
                    $selltrades->status_text = "CANCELLED";
                    $selltrades->status = 100;
                    $selltrades->save();
                }else{
                    $msg = $check->message;
                    return redirect($url)->with('cancelerror', 'Bad Request!'.$msg);
                }
            }else{
                $pairname   = $trdepair->coinone.'/'.$trdepair->cointwo;
                $this->creditAmountPending($uid, $currency, $total, $fee,$leve_bal,'sell',$pairname,$id);
                $selltrades->status_text = "CANCELLED";
                $selltrades->status = 100;
                $selltrades->save();
            }
             \Session::flash('cancelsuccess', 'Pending order cancelled successfully!');
            return redirect($url)->with('cancelsuccess','Pending order cancelled successfully!');


        } else {
            return redirect()->back()->withErrors('cancelerror', 'Bad Request!');
        }

    }

    public function marketPlace(){
        return view('marketplace');
    }


   public function creditAmountPending($uid, $currency, $balance, $escrow,$leverage,$tradetype,$pairname = null,$insertid=null) {
        $userbalance = Wallet::where([['uid', '=', $uid], ['currency', '=', $currency]])->first();
        $oldbalance = $userbalance->balance;
        if ($userbalance) {
            $leverage   = ncSub($userbalance->vilimpu_camanilai,$leverage,8);
            $total      = ncAdd($userbalance->balance,$balance, 8);
            $walletbalance =$total;
            $ecrowtotal = ncSub($userbalance->escrow_balance, $escrow, 8);
            if($ecrowtotal < 0){
                $total = ncAdd($total,$ecrowtotal,8);
                $ecrowtotal = 0;
            }
            $userbalance->balance           = $total;
            $userbalance->escrow_balance    = $ecrowtotal;
            $userbalance->updated_at        = date('Y-m-d H:i:s',time());
            $userbalance->save();
        }
        $this->AllcoinUpdateBalanceTrack($uid,$currency,$balance,$walletbalance,$oldbalance,$tradetype,$pairname,$insertid);

        return true;
    }

    
    public function AllcoinUpdateBalanceTrack($uid,$currency,$amount,$walletbalance,$oldbalance,$tradetype,$pairname,$insertid)
    {
        $Models = '\App\Models\OverallTransaction';
        $remark = 'Cancelled '.$tradetype.' trade in ' .$pairname;
        $type = $tradetype.'trade';
        $Models::AddTransaction($uid,$currency,$type,$amount,0,$walletbalance,$oldbalance,$remark,'web',$insertid);
        return true;
    }

    public function marketDepthChart($market=NULL)
    {
        if($market!=NULL){
            $coinpair = explode('_',$market); 
            $selectPair = Tradepair::where([
                ['coinone', '=', $coinpair[0]],
                ['cointwo', '=', $coinpair[1]],
                ['active', '=', 1],
            ])->first();
        } else {
            $selectPair =  Tradepair::where(['active' => 1, 'is_market' => 1])->orderBy('orderlist','Asc')->first();            
        }
        if(!$selectPair){
            return abort(404);
        }
        return view('marketdepth-chart',['selectPair' => $selectPair]);
    }

    public function tradingViewChart($market=NULL)
    {
        if($market!=NULL){
            $coinpair = explode('_',$market);  
            $selectPair = Tradepair::where([
                ['coinone', '=', $coinpair[0]],
                ['cointwo', '=', $coinpair[1]],
                ['active', '=', 1],
                ['is_spot', '=', 1],
            ])->first();
        } else {
            $selectPair =  Tradepair::where(['active' => 1, 'is_spot' => 1])->orderBy('orderlist','Asc')->first();            
        }
        if(!$selectPair){
            return abort(404);
        }
        return view('tradingview-chart',['selectPair' => $selectPair]);
    }
    
}
