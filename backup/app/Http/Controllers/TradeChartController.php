<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
 
use Carbon\Carbon;
use App\Models\TradeViewChart;
use DB;
use App\Models\Tradepair;
use App\Models\Completedtrade;
use App\Models\Trade;
use App\Models\Selltrade;
use App\Libraries\BinanceClass;
use App\Models\TradePairLivePrice;

class TradeChartController extends Controller
{
     public function __construct(){       
     }

    public function trade_details($pair)
    {  
    	$CompleteTrade = Completedtrade::where('pair', $pair)->where('created_at','>',Carbon::now()->subDay(1))->get(); 
    	$high = Completedtrade::where('pair', $pair)->where('created_at','>',Carbon::now()->subDay(1))->max('price'); 
    	$low = Completedtrade::where('pair', $pair)->where('created_at','>',Carbon::now()->subDay(1))->min('price');  

    	foreach($CompleteTrade as $trade)
    	{    
        $btcaddress = new TradeViewChart;
        $btcaddress->pair = $trade->pair;
        $btcaddress->open = $CompleteTrade[0]->price;
        $btcaddress->high = $high;
        $btcaddress->low = $low;
        $btcaddress->close = $CompleteTrade[sizeof($CompleteTrade)-1]->price;
        $btcaddress->save();
    	}	
    	
    }
     public function getTradeChartDetails()
     {  
        $pair = Tradepair::where('active',1)->get();  
        foreach($pair as $p)
        {  
              $i = $p->id;
         
            $closingTrade = Completedtrade::where('pair', $i)->where('created_at','>',Carbon::now()->subDay(1))->orderBy('id', 'desc')->first();  
            $openingTrade = Completedtrade::where('pair', $i)->where('created_at','>',Carbon::now()->subDay(1))->orderBy('id', 'asc')->first();
            $high = Completedtrade::where('pair', $i)->where('created_at','>',Carbon::now()->subDay(1))->max('price','id'); 
            $low = Completedtrade::where('pair', $i)->where('created_at','>',Carbon::now()->subDay(1))->min('price');  
            if($closingTrade)    
            {
                $btcaddress = new TradeViewChart;
                $btcaddress->pair = $i;
                $btcaddress->open = $openingTrade->price;
                $btcaddress->high = $high;
                $btcaddress->low = $low;
                $btcaddress->close = $closingTrade->price;
                $btcaddress->save();
            }
        }
        return "Updated!";
    }
     function  marketdepthchart($pair='')
     { 
        $pairlist = Tradepair::where('id',$pair)->first();
        $cprice = 1;
        if(!is_object($pairlist)){
          $result = json_encode(array(),JSON_PRETTY_PRINT);
          echo $result;
        } 
        if($pairlist->is_dust == 1){
            $liqi = $pairlist->coinone.$pairlist->cointwo;
          $api = new BinanceClass;          
          $market_depth = $api->market_depth($liqi);

          $buy_order  = $market_depth['bids'];
          $sell_order  = $market_depth['asks'];
          $bid_data2 = array();
          $ask_data2 = array();

          foreach($buy_order as $key => $bid)
          {
            $bid_data = array();
            $bid_data[] = $key;
            $bid_data[] = $bid;
            $bid_data2[] = $bid_data;
          }

          foreach($sell_order as $key => $ask)
          {
            $ask_data = array();
            $ask_data[] = $key;
            $ask_data[] = $ask;
            $ask_data2[] = $ask_data; 
          }

          $bid_result['asks'] = $ask_data2;
          $bid_result['bids'] = $bid_data2;
          $bid_result['depth'] = $market_depth['depth'];
          $result = json_encode($bid_result,JSON_PRETTY_PRINT);
          echo $result;
        }else{
             $buy_order = Trade::select('price',DB::raw('SUM(remaining) as remaining'),DB::raw('group_concat(created_at) as created_at'))
             ->where(['trade_type' => 'Buy','order_type' => 1, 'pair' => $pair,'status' => 0])        
             ->groupBy('price')
             ->orderBy('price', 'asc')
             ->limit(100)->get();
             $sell_order = Trade::select('price', DB::raw('SUM(remaining) as remaining'),DB::raw('group_concat(created_at) as created_at'))
             ->where(['trade_type' => 'Sell','order_type' => 1, 'pair' => $pair,'status' => 0])
             ->orderBy('price', 'asc')
             ->groupBy('price')
             ->limit(100)->get();
             $complete = Completedtrade::where([['pair' ,'=' ,$pair]])->limit(200)->orderBy('id','DESC')->get();

              $bid_data2 = array();
              $ask_data2 = array();

              if(count($buy_order) > 0)
              {
                foreach($buy_order as $bid)
                {
                  $bid_data = array();
                  $bid_data[] = $bid->price;
                  $bid_data[] = $bid->remaining;
                  $bid_data2[] = $bid_data;
                }
              }
              if(count($sell_order) > 0)
              {
                foreach($sell_order as $ask)
                {
                  $ask_data = array();
                  $ask_data[] = $ask->price;
                  $ask_data[] = $ask->remaining;
                  $ask_data2[] = $ask_data; 
                }
                
              }

              $bid_result['asks'] = $ask_data2;
              $bid_result['bids'] = $bid_data2;
              $bid_result['trades'] = $complete;
              $bid_result['lastUpdateId'] = 1;
              $result = json_encode($bid_result,JSON_PRETTY_PRINT);
              echo $result; 
            }
     }
     public function getBinanceOrderBook($value='')
     {
       $pairlist = Tradepair::where('id',$pair)->first();
     }
}
