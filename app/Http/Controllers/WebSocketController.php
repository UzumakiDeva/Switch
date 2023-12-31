<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use App\Models\Trade;
use App\Models\Selltrade;
use App\Models\Completedtrade;
use App\User;
use App\Models\Commission;
use App\Models\Wallet;
use App\Models\Tradepair;
use App\Models\Tradechart;
use App\Models\Leverage;
use App\Models\Message;
use Redirect;
use Auth;
use Session;
use Illuminate\Support\Facades\DB;
use App\Traits\TradeData;

class WebSocketController extends Controller implements MessageComponentInterface{

    use TradeData;
    private $connections = [];

    public function __construct() {

    }
    
     /**
     * When a new connection is opened it will be passed to this method
     * @param  ConnectionInterface $conn The socket/connection that just connected to your application
     * @throws \Exception
     */
     function onOpen(ConnectionInterface $conn){
        $this->connections[$conn->resourceId] = compact('conn') + ['uid' => null];
        // $this->clients->attach($conn);
        echo "Connection Established! \n";
        echo " new conncection ".$conn->resourceId."\n";
    }
    
     /**
     * This is called before or after a socket is closed (depends on how it's closed).  SendMessage to $conn will not result in an error if it has already been closed.
     * @param  ConnectionInterface $conn The socket/connection that is closing/closed
     * @throws \Exception
     */
     function onClose(ConnectionInterface $conn){
        $disconnectedId = $conn->resourceId;
        unset($this->connections[$disconnectedId]);
        foreach($this->connections as &$connection)
            $connection['conn']->send(json_encode([
                'offline_user' => $disconnectedId,
                'from_user_id' => 'server control',
                'from_resource_id' => null
            ]));
        echo "Connection Closed! \n";
    }
    
     /**
     * If there is an error with one of the sockets, or somewhere in the application where an Exception is thrown,
     * the Exception is sent back down the stack, handled by the Server and bubbled back up the application through this method
     * @param  ConnectionInterface $conn
     * @param  \Exception $e
     * @throws \Exception
     */
     function onError(ConnectionInterface $conn, \Exception $e){


        $userId = $this->connections[$conn->resourceId]['uid'];
        echo " {$e->getMessage()}\n";
        unset($this->connections[$conn->resourceId]);
        $conn->close();
    }
    
     /**
     * Triggered when a client sends data through the socket
     * @param  \Ratchet\ConnectionInterface $conn The socket/connection that sent the message to your application
     * @param  string $msg The message received
     * @throws \Exception
     */
    /*function onMessage(ConnectionInterface $conn, $msg, $market=NULL){
        $con_details=json_decode($msg);
        $uid = $con_details->uid;
        $pair =$con_details->pair;

        $this->trade_index($uid,$pair,$conn);

    }*/

    function onMessage(ConnectionInterface $conn, $msg){

        
        if(is_null($this->connections[$conn->resourceId]['uid'])){
            $this->connections[$conn->resourceId]['uid'] = $msg;
            $onlineUsers = [];
            $con_details=json_decode($msg);
            $pair = 'BTC_USD';
            $uid = '' ;
            if(isset($con_details->_token) ){
                $uid = $con_details->_token;
            }
            if(isset($con_details->market) ){
                $pair = $con_details->market;
            }
            $mydata = $this->OrderBook($pair,$uid);
            foreach($this->connections as $resourceId => &$connection){
                $connection['conn']->send(json_encode($mydata));
            }
            //$conn->send(json_encode($mydata));
        } else{            
            $fromUserId = $this->connections[$conn->resourceId]['uid'];
            $con_details=json_decode($msg);
            $pair = '';
            $uid = '' ;
            if(isset($con_details->_token) ){
                $uid = $con_details->_token;
            }
            if(isset($con_details->market) ){
                $pair = $con_details->market;
            }
            $mydata = $this->OrderBook($pair,$uid);
            foreach($this->connections as $resourceId => &$connection){
                $connection['conn']->send(json_encode($mydata));
            }
        }
    }

    public function OrderBook($pair=NULL,$uid=""){
        if($pair){
            $coinpair = explode('_',$pair); 
            $trdepair = Tradepair::where([
                ['coinone', '=', $coinpair[0]],
                ['cointwo', '=', $coinpair[1]]
            ])->first();
        }else{
            $trdepair =  Tradepair::first();
        }
        $coinone = $trdepair->coinone;
        $cointwo = $trdepair->cointwo;
        $tid = $trdepair->id;

        if($uid !=""){
            $token = \Crypt::decrypt($uid);
            $onebalance = $this->UserBalance($token,$coinone,$coinone_decimal);
            $twobalance = $this->UserBalance($token,$cointwo,$cointwo_decimal);
            $mobile     = $this->mobileorderBook($tid,$token);

            return $result = array('coinone' => $coinone, 'cointwo' => $cointwo,'mobile' => $mobile);
        }else{
            $mobile     = $this->mobileorderBook($tid);
            return $result = array('coinone' => $coinone, 'cointwo' => $cointwo, 'mobile' => $mobile);
        }
    }


    public function BuyTrade($tid,$coinone,$cointwo){
        $data ="";
        $trades = $this->tradeBuy($tid);
        if(count($trades) > 0){
            foreach($trades as $buytrade){
                $data.='<div class="div-tr" onclick="buyRow('.display_format($buytrade['price']).','.display_format($buytrade['remaining']).');">';
                $data.='<div>'.display_format($buytrade['price'],8).'</div>';
                $data.='<div class="buy-price-green">'.display_format($buytrade['remaining'],8).'</div>';
                $data.='<div>'.ncMul($buytrade['price'],$buytrade['remaining'],8).'</div>';
                $data.='</div>';
            }
        }else{
            $data="<div class='text-center'>".'No records found!'."</div>";
        }
        return $data;
    }

    public function SellTrade($tid,$coinone,$cointwo){
        $data ="";
        $trades = $this->tradeSell($tid);
        if(count($trades) > 0){
            foreach($trades as $selltrade){
                $data.=' <div class="div-tr" onclick="sellRow('.display_format($selltrade['price']).','.display_format($selltrade['remaining']).');">';
                $data.='<div>'.display_format($selltrade['price'],8).'</div>';
                $data.='<div class="sell-price-red">'.display_format($selltrade['remaining'],8).'</div>';
                $data.='<div>'.ncMul($selltrade['price'],$selltrade['remaining'],8).'</div>';
                $data.='</div>';

            }
        }else{
           $data="<div class='text-center'>".'No records found!'."</div>";
        }
        return $data;
    }

    public function CompleteTrade($tid,$coinone,$cointwo){
        $data ="";
        $trades = $this->tradeComplete($tid);
        if(count($trades) > 0){
            foreach($trades as $completedtrade){

            $data.='<div class="div-tr">';
            if($completedtrade['type'] == 'Buy')
            {
             $data.='<div>'.display_format($completedtrade['price'],8).'</div>';
             $data.='<div class="t-green">'.display_format($completedtrade['volume'],8).'</div>';
            }
            elseif($completedtrade['type'] == 'Sell')
            {
             $data.=' <div>'.display_format($completedtrade['price'],8).'</div>';
             $data.='<div class="t-red">'.display_format($completedtrade['volume'],8).'</div>';
            }           
            $data.='<div><span class="grey-t">'.ncMul($completedtrade['price'],$completedtrade['volume'],8).'</span></div>';
            $data.='<div><span class="grey-t">'.date('d-m-Y H:i:s',strtotime($completedtrade['created_at'])).'</span></div>';

            $data.='</div>';
            }
        }else{
            $data="<div class='text-center'>".'No records found!'."</div>";
        }
        return $data;
    }

    public function LiveTrade(){
        $pairs = Tradepair::where('active',1)->get();
        $data ="";
        if(count($pairs) > 0){
            foreach ($pairs as $tradeorders) {

            $dataget =  $this->getMarketSummary($tradeorders->id);    
            $coinone = $tradeorders['coinone'];
            $cointwo = $tradeorders['cointwo'];

            $com_one = Commission::coindetails($coinone);
            $com_two = Commission::coindetails($cointwo);
            $coinone_decimal = $com_one->point_value;
            $cointwo_decimal = $com_two->point_value;
            $url = url('/trades/'.$tradeorders['coinone'].'_'.$tradeorders['cointwo'] );
            $url2 = "'".$url."'";

            $data.='<tr onclick="window.location='.$url2.'" style="cursor: pointer;">';
            $data.='<td>'.$tradeorders['coinone'].'/'.$tradeorders['cointwo'].'</td>
            <td>'.display_format($dataget['Last'], $cointwo_decimal).'</td>';
            $ecchange = $dataget['Exchange'];
            if($ecchange >= 0){
                $data.='<td><span class="t-green"></span>'.display_format($ecchange, 2).'%'.'</td>';
            }else{
                $data.='<td><span class="t-red"></span>'.display_format($ecchange, 2).'%'.'</td>';
            }
            $data.='<td>'.display_format($dataget['Volume'], $coinone_decimal).'</td>';
            $data.='</tr>';


            }
        }else{
            $data="<div class='text-center'>".'No records found!'."</div>";
        } 
        return  $data;    
    }

    public function mobileorderBook($tid,$uid=null) 
    {        
        $trade = Tradepair::where(['active' => 1,'id' => $tid])->first();
        if(!$trade){
            return response()->json(['result'=> NULL,'success' => false,'message' => 'Invalid Trade pair!'], 200);
        }
        $coinone = $trade->coinone;
        $cointwo = $trade->cointwo;
        $com_one = Commission::coindetails($coinone);
        $com_two = Commission::coindetails($cointwo);
        $coinone_decimal = $trade->coinone_decimal;
        $cointwo_decimal = $trade->cointwo_decimal;

        $buy = array();
        $sell = array();
        $complete = array();
        $buytrades = $this->tradeBuy($trade->id);            
        if(count($buytrades) > 0){
            $qty  = 0;
            foreach ($buytrades as $key => $buytrade) {
                $buy[$key]['Rate'] = display_format($buytrade->price,$cointwo_decimal);
                $buy[$key]['Quantity'] = display_format($buytrade->remaining,$coinone_decimal);
                $qty = $buytrade->Quantity + $qty;
                $buy[$key]['Sum'] = display_format($qty,$coinone_decimal);
                $buy[$key]['Total'] = ncMul($buytrade->price,$buytrade->remaining,$cointwo_decimal);
            }
        }
        $selltrades = $this->tradeSell($trade->id);
        if(count($selltrades) > 0){
            $qty  = 0;
            foreach ($selltrades as $key => $selltrade) {
                $sell[$key]['Rate'] = display_format($selltrade->price,$cointwo_decimal);
                $sell[$key]['Quantity'] = display_format($selltrade->remaining,$coinone_decimal);
                $qty = $selltrade->Quantity + $qty;
                $sell[$key]['Sum'] = display_format($qty,$coinone_decimal);
                $sell[$key]['Total'] = ncMul($selltrade->price,$selltrade->remaining,$cointwo_decimal);
            }
        }
        $type = 'normal';
        if($uid !=""){
            $balanceOne = 0;
            $balanceTwo = 0;
            $balanceOne = Wallet::where(['uid' => $uid,'currency' => $trade->coinone])->value('balance');
            if(!$balanceOne){
                $balanceOne = 0;
            }
            $balanceTwo = Wallet::where(['uid' => $uid,'currency' => $trade->cointwo])->value('balance');
            if(!$balanceTwo){
                $balanceTwo = 0;
            }
            $data['balance']['coinone']    = display_format($balanceOne,$coinone_decimal);
            $data['balance']['cointwo']    = display_format($balanceTwo,$cointwo_decimal);
        }
        $dataget =  $this->getMarketSummary($trade->id);
        $tradepair = Tradepair::where('active',1)->orderBy('orderlist','Asc')->get();
        $market =array();
        if(count($tradepair) > 0){
            foreach ($tradepair as $key => $tradepairs) {
                $dataget =  $this->getMarketSummary($tradepairs->id);
                $market[$key]['pairone']    = $tradepairs->coinone;
                $market[$key]['pairtwo']    = $tradepairs->cointwo;
                $market[$key]['price']      = $dataget['Last'];
                $market[$key]['volume']     = $dataget['Volume'];
                $market[$key]['exchange']   = $dataget['Exchange'];
            }
        }
        $data['coinone']    = $trade->coinone;
        $data['cointwo']    = $trade->cointwo;
        $data['buy']        = $buy;
        $data['sell']       = $sell;
        $data['type']       = $type;
        $data['dataget']    = $dataget;
        $data['market']     = $market;
        $data['commission']['coinone'] = $com_two->sell_trade;
        $data['commission']['cointwo'] = $com_one->buy_trade;
        return $data; 
    }



}
