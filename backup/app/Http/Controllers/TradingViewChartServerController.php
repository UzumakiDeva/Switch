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
      'pricescale' => 100,
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
  $liqi = $trdepair->coinone.$trdepair->cointwo;
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
   
   if (!empty($CompleteTrade)) {
    $request->session()->put('history_count', 1); 
    $open=array();
    $time=array();
    $low=array();
    $hight=array();
    $close=array();
    
    foreach($CompleteTrade as $trade){  
      $open[] =  $trade->open;
      $time[] = $trade->time;
      $low[] = $trade->low;
      $hight[] =$trade->high;
      $close[] =$trade->close; 
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
    
  } else {  
    $response = array (
      't'=>  array (
        0 => 1501459200,
        1 => 1501545600,
        2 => 1501632000,
        3 => 1501718400,
        4 => 1501804800,
        5 => 1502150400,
        6 => 1502236800,
        7 => 1502323200,
        8 => 1502409600,
        9 => 1502668800,
        10 => 1502755200, 
      ),
      'o' =>  array (
        0 => 149.900000000000005684341886080801486968994140625,
        1 => 149.099999999999994315658113919198513031005859375,
        2 => 159.280000000000001136868377216160297393798828125,
        3 => 157.05000000000001136868377216160297393798828125,
        4 => 156.06999999999999317878973670303821563720703125,
        5 => 158.599999999999994315658113919198513031005859375,
        6 => 159.259999999999990905052982270717620849609375,
        7 => 159.900000000000005684341886080801486968994140625,
        8 => 156.599999999999994315658113919198513031005859375,
        9 => 159.31999999999999317878973670303821563720703125,
        10 => 160.659999999999996589394868351519107818603515625,
      ),
      'h' =>  array (
        0 => 150.330000000000012505552149377763271331787109375,
        1 => 150.219999999999998863131622783839702606201171875,
        2 => 159.75,
        3 => 157.210000000000007958078640513122081756591796875,
        4 => 157.400000000000005684341886080801486968994140625,
        5 => 161.830000000000012505552149377763271331787109375,
        6 => 161.270000000000010231815394945442676544189453125,
        7 => 160,
        8 => 158.572800000000000864019966684281826019287109375,
        9 => 160.210000000000007958078640513122081756591796875,
        10 => 162.19499999999999317878973670303821563720703125, 
      ),
      'l' =>  array (
        0 => 148.1299999999999954525264911353588104248046875,
        1 => 148.409999999999996589394868351519107818603515625,
        2 => 156.159999999999996589394868351519107818603515625,
        3 => 155.020000000000010231815394945442676544189453125,
        4 => 155.68999999999999772626324556767940521240234375,
        5 => 158.270000000000010231815394945442676544189453125,
        6 => 159.1100000000000136424205265939235687255859375,
        7 => 154.6299999999999954525264911353588104248046875,
        8 => 156.06999999999999317878973670303821563720703125,
        9 => 158.75,
        10 => 160.1399999999999863575794734060764312744140625, 
      ),
      'c' =>  array (
        0 => 148.849999999999994315658113919198513031005859375,
        1 => 150.05000000000001136868377216160297393798828125,
        2 => 157.1399999999999863575794734060764312744140625,
        3 => 155.56999999999999317878973670303821563720703125,
        4 => 156.3899999999999863575794734060764312744140625,
        5 => 160.080000000000012505552149377763271331787109375,
        6 => 161.06000000000000227373675443232059478759765625,
        7 => 155.270000000000010231815394945442676544189453125,
        8 => 157.479999999999989768184605054557323455810546875,
        9 => 159.849999999999994315658113919198513031005859375,
        10 => 161.599999999999994315658113919198513031005859375,
      ),
      'v' =>  array (
        0 => 19422655,
        1 => 24725526,
        2 => 69222793,
        3 => 26000738,
        4 => 20349532,
        5 => 35775675,
        6 => 25640394,
        7 => 39081017,
        8 => 25943187,
        9 => 21754810,
        10 => 27936774,
      ),
      's' => 'ok',
    );
  }
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
