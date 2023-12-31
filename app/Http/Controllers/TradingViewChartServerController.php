<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response as response;
use Illuminate\Http\Request;
use App\Models\TradeViewChart;
use App\Models\Completedtrade;
use App\Models\Tradepair;
use DB;
use Session;
use App\Libraries\BinanceClass;

class TradingViewChartServerController extends Controller
{
  public function __construct(){       
  }
  public function gettradedetail(){
    $get = Session::get('pair');
    $coin = $get['coin'];
    $pair = $get['pair'];
    $coinpair = explode('/',$pair);
    $trdepair = Tradepair::where([
      ['coinone', '=', $coinpair[0]],
      ['cointwo', '=', $coinpair[1]],
      ['active', '=', 1],
    ])->first();
    return $trdepair;
  }
  public function symbol_info() {
    $sitename = config('app.name', '');
    $trdepairs = Tradepair::get();
    $symbol=array();
    $description=array();
    $ticker=array();
    $type=array();
    foreach($trdepairs as $trdepair){  
      $symbol[] =  $trdepair->coinone.'/'.$trdepair->cointwo;
      $description[] = $sitename.' : '.$trdepair->coinone.' / '.$trdepair->cointwo;
      $ticker[] = $trdepair->coinone.'/'.$trdepair->cointwo;
      $type[] = 'cryto';
    } 

    $response = array (
      'symbol' => $symbol,
      'description' => $description,
      'exchange-listed' => $sitename,
      'exchange-traded' => $sitename,
      'minmovement' => 1,
      'minmov2' => 
      array (
        0 => 10,
        1 => 1,
        2 => 10,
        3 => 1,
        4 => 1,
      ),
      'fractional' => false,
      'pricescale' => 
      array (
        0 => 100000,
        1 => 10000,
        2 => 100000,
        3 => 1000,
        4 => 10000,
      ),
      'has-intraday' => true,
      'has-no-volume' => 
      array (
        0 => false,
        1 => false,
        2 => false,
        3 => false,
        4 => false,
      ),
      'type' => $type,
      'ticker' => $ticker,
      'timezone' => 'America/New_York',
      'session-regular' => '24x7',
      'has-daily' => true,
      'has-weekly-and-monthly' => true,
      'intraday-multipliers' => 
      array (
        0 => '1',
        1 => '5',
        2 => '15',
        3 => '30',
        4 => '60',
      ),
      'supported-resolutions' => 
      array (
        0 => '1',
        1 => '5',
        2 => '15',
        3 => '30',
        4 => '60',
        5 => '1D',
      ),
    );
    return response($response)
    ->header('Content-Type', 'text/plain');        
  }

  public function config() { 
    
   
    $response = array (
      'supports_search' => true,
      'supports_group_request' => false,
      'supports_marks' => true,
      'supports_timescale_marks' => true,
      'supports_time' => true,
      'exchanges' => 
      array (
        0 => 
        array (
          'value' => '',
          'name' => 'All Exchanges',
          'desc' => '',
        ),
        1 => 
        array (
          'value' => 'BTC',
          'name' => 'BTC',
          'desc' => 'BTC',
        ),
        2 => 
        array (
          'value' => 'ETH',
          'name' => 'ETH',
          'desc' => 'ETH',
        ),3 => 
        array (
          'value' => 'LTC',
          'name' => 'LTC',
          'desc' => 'LTC',
        ),4 => 
        array (
          'value' => 'PTR',
          'name' => 'PTR',
          'desc' => 'PTR',
        ),5 => 
        array (
          'value' => 'DASH',
          'name' => 'DASH',
          'desc' => 'DASH',
        ),
        
      ),
      'symbols_types' => 
      array (
        0 => 
        array (
          'name' => 'All types',
          'value' => '',
        ),
    // 1 => 
    // array (
    //   'name' => 'Stock',
    //   'value' => 'stock',
    // ),
    // 2 => 
    // array (
    //   'name' => 'Index',
    //   'value' => 'index',
    // ),
      ),
      'supported_resolutions' => 
     array (
        0 => '1',
        1 => '5',
        2 => '15',
        3 => '30',
        4 => '60',
        5 => 'D',
        6 => '2D',
        7 => '3D',
        8 => 'W',
        9 => '3W',
        10 => 'M',
        11 => '6M',
      ),
    );
    return response($response)
    ->header('Content-Type', 'text/plain');
  }

  public function time() {
    return response(1532437619)
    ->header('Content-Type', 'text/plain');        
  }

  public function symbols(Request $request) {
    $sitename = config('app.name', '');
    $coinpair = explode('/',$request->symbol); 
   $trdepair = Tradepair::where([
    ['coinone', '=', $coinpair[0]],
    ['cointwo', '=', $coinpair[1]],
    ['active', '=', 1],
  ])->first();
   $pair = $trdepair->id; 
   
    $response = array (
      'name' =>  $request->symbol,
      'exchange-traded' => $pair,
      'exchange-listed' => "",
      'timezone' => 'Asia/Kolkata',
      'minmov' => 1,
      'minmov2' => 0,
      'pointvalue' => 1,
      'session' => '0930-1630',
      'has_intraday' => false,
      'has_no_volume' => false,
      'description' => $sitename,
      'type' => 'stock',
      'supported_resolutions' => 
      array (
        0 => '1',
        1 => '5',
        2 => '15',
        3 => '30',
        4 => '60',
        5 => 'D',
        6 => '2D',
        7 => '3D',
        8 => 'W',
        9 => '3W',
        10 => 'M',
        11 => '6M',
      ),
      'pricescale' => 10000000,
      'ticker' => $request->symbol,
    );
    return response($response)
    ->header('Content-Type', 'text/plain');
  }

  public function history(Request $request) { 
   $coinpair = explode('/',$request->symbol); 
   //$resolution = strtolower($request->resolution); 
   $resolution = '1d';
   $trdepair = Tradepair::where([
    ['coinone', '=', $coinpair[0]],
    ['cointwo', '=', $coinpair[1]]
  ])->first();
   $pair = $trdepair->id;
   if($trdepair->is_dust == 1){
    $open=array();
  $time=array();
  $low=array();
  $hight=array();
  $close=array();
  $volume=array();
  $liqi = $trdepair->symbol;
  $api = new BinanceClass;
  $candlestick_data = $api->candlestick_data($liqi,$resolution);
  if(isset($candlestick_data)){
    foreach($candlestick_data as $key => $trade){     
      $time1  = $trade['openTime'] /1000;
      $date = date('Y-m-d H:i:s'  ,$time1);
      $time2 = strtotime($date);
      $open[] =  (float) $trade['open'];          
      $low[] = (float)$trade['low'];
      $hight[] =(float)$trade['high'];
      $close[] =(float)$trade['close']; 
      $volume[] =(float)$trade['volume']; 
      $time[] = $time2;
      } 
    }else{
      $open[] =  '';

      $time[] = '';
      $low[] = '';
      $hight[] ='';
      $close[] =''; 
    }
  $find = array(
      't'=>$time,
      'o'=>$open,
      'h'=>$hight,
      'l'=>$low,
      'c'=>$close,
      'v'=>$close, 
      's' => 'ok',
      );  
      $response = $find;
   }else{   
   $CompleteTrade = json_decode($this->vvchart($pair));   
   $open=array();
    $time=array();
    $low=array();
    $hight=array();
    $close=array();
    if($trdepair->is_bot == 1){
      $liqi = $trdepair->symbol;
      $candlestick_data = json_decode(crul("https://socket.dex-trade.com/graph/hist?t=".$liqi."&r=D"));      
      if(count($candlestick_data) > 0){
        $candlestick_data = array_reverse($candlestick_data);
        foreach($candlestick_data as $key => $trade){     
          $time1  = $trade->time;
          $date = date('Y-m-d H:i:s'  ,$time1);
          $time2 = $trade->time;
          $open[] =  (float) $trade->open /1e8;          
          $low[] = (float)$trade->low /1e8;
          $hight[] =(float)$trade->high /1e8;
          $close[] =(float)$trade->close /1e8; 
          $volume[] =(float)$trade->volume /1e6; 
          $time[] = $time2;
        } 
      }
    }
   if (!empty($CompleteTrade)) {
    $request->session()->put('history_count', 1);    
    
    foreach($CompleteTrade as $trade){  
      $open[] =  $trade->open;
      $time[] = $trade->time;
      $low[] = $trade->low;
      $hight[] =$trade->high;
      $close[] =$trade->close; 
    }   
  }
  $find = array(
      't'=>$time,
      'o'=>$open,
      'h'=>$hight,
      'l'=>$low,
      'c'=>$close,
      'v'=>$close, 
      's' => 'ok',
    );  
    $response = $find;
  
}
  return response($response)
  ->header('Content-Type', 'text/plain');
}

public function marks() {
  $response = array (
    'id' => 
    array (
      0 => 0,
      1 => 1,
      2 => 2,
      3 => 3,
      4 => 4,
      5 => 5,
    ),
    'time' => 
    array (
      0 => time(),
      1 => 1532044800,
      2 => 1531785600,
      3 => 1531785600,
      4 => 1531094400,
      5 => 1529798400,
    ),
    'color' => 
    array (
      0 => 'red',
      1 => 'blue',
      2 => 'green',
      3 => 'red',
      4 => 'blue',
      5 => 'green',
    ),
    'text' => 
    array (
      0 => 'Today',
      1 => '4 days back',
      2 => '7 days back + Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
      3 => '7 days back once again',
      4 => '15 days back',
      5 => '30 days back',
    ),
    'label' => 
    array (
      0 => 'A',
      1 => 'B',
      2 => 'CORE',
      3 => 'D',
      4 => 'EURO',
      5 => 'F',
    ),
    'labelFontColor' => 
    array (
      0 => 'white',
      1 => 'white',
      2 => 'red',
      3 => '#FFFFFF',
      4 => 'white',
      5 => '#000',
    ),
    'minSize' => 
    array (
      0 => 14,
      1 => 28,
      2 => 7,
      3 => 40,
      4 => 7,
      5 => 14,
    ),
  );
        //return response($response)->header('Content-Type', 'text/plain');
}

public function timescale_marks() {
  $response = array (
    0 => 
    array (
      'id' => 'tsm1',
      'time' => 1532390400,
      'color' => 'red',
      'label' => 'A',
      'tooltip' => '',
    ),
    1 => 
    array (
      'id' => 'tsm2',
      'time' => 1532044800,
      'color' => 'blue',
      'label' => 'D',
    // 'tooltip' => 
    // array (
    //   0 => 'Dividends: $0.56',
    //   1 => 'Date: Fri Jul 20 2018',
    // ),
    ),
    2 => 
    array (
      'id' => 'tsm3',
      'time' => 1531785600,
      'color' => 'green',
      'label' => 'D',
    // 'tooltip' => 
    // array (
    //   0 => 'Dividends: $3.46',
    //   1 => 'Date: Tue Jul 17 2018',
    // ),
    ),
    3 => 
    array (
      'id' => 'tsm4',
      'time' => 1531094400,
      'color' => '#999999',
      'label' => 'E',
    // 'tooltip' => 
    // array (
    //   0 => 'Earnings: $3.44',
    //   1 => 'Estimate: $3.60',
    // ),
    ),
    4 => 
    array (
      'id' => 'tsm7',
      'time' => 1529798400,
      'color' => 'red',
      'label' => 'E',
    // 'tooltip' => 
    // array (
    //   0 => 'Earnings: $5.40',
    //   1 => 'Estimate: $5.00',
    // ),
    ),
  );
  return response($response)
  ->header('Content-Type', 'text/plain');
}
public function vvchart($pair=1)
{

  $old_time = '2018-08-31 00:00:00';
  $now_time = date('Y-m-d H:i:s',time());

  $lastminit = Completedtrade::select(DB::raw('SUM(volume) as volume, MAX(price) as Maxamount, MIN(price) as Minamount, MIN(id) first, max(id) last, DATE_FORMAT(FROM_UNIXTIME(FLOOR(UNIX_TIMESTAMP(created_at) /(10*60))*10*60) , "%Y-%m-%d %H:%i") as createdAt'))
  ->where(['pair' => $pair])
  ->whereBetween('created_at', [$old_time, $now_time])
      //->where(DB::raw('id IN (SELECT MAX(id) FROM completedtrades)'))
  ->groupBy(DB::raw('DATE_FORMAT(FROM_UNIXTIME(FLOOR(UNIX_TIMESTAMP(created_at) /(10*60))*10*60) , "%Y-%m-%d %H:%i")'))
  
  ->limit(200)->get();
  if(count($lastminit) > 0){
    foreach($lastminit as $last) {
      $first[] = $last->first;
      $lastvalue[] = $last->last;
    }


    $openval = Completedtrade::whereIn('id', $first)->get();
    $closeval = Completedtrade::whereIn('id', $lastvalue)->get();
       //dd($openval);
    
    $old_time = strtotime('2018-08-31');
    $now_time = strtotime($now_time);
    
    foreach ($lastminit as $key => $last) {
        //echo $old_time."<br />";
        //echo $now_time."<br />";
      if($old_time < $now_time)
      {
        $old_time = strtotime($last->createdAt);
        $time = $old_time;
        $time = (int)$time;
        $open = $openval[$key]->price;
        $heigh = $last->Maxamount;
        $low = $last->Minamount;
        $close = $closeval[$key]->price;
        $height = $last->Maxamount;
        $data[] = array(
          'time' => $time, 
          'open' => $open,
          'high' => $heigh,
          'low' => $low,
          'close' => $close,
          'height'=> $height
        );
        if($old_time == strtotime($last->createdAt)){
          $old_time = $old_time + (10*60);
        }
      }
    }
    return json_encode($data);

  }else{
    return false;
  }
}
}
