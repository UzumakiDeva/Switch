<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ChartBot;
use App\Models\Tradepair;

class ChartBotDextrade extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:chartbotdata';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'chart bot data updated';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $tradepair =Tradepair::where(['is_dust' => 2,'is_bot' => 2 ])->get();
   
        if(count($tradepair)>0){
        foreach($tradepair as $data){
        $id =$data->id;  
        $symbol =$data->symbol;
        $ifexits = ChartBot::where(['pair'=>$id])->delete(); 
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://socket.dex-trade.com/graph/hist?t='.$symbol.'&r=D&',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        $response = curl_exec($curl);
      
          curl_close($curl);
          $candlestick_data = json_decode($response);
              
          foreach($candlestick_data as $data){  
          $chart_data = new ChartBot;
          $chart_data->pair =$id;
          $chart_data->low = $data->low;
          $chart_data->high = $data->high;
          $chart_data->open = $data->open;
          $chart_data->close = $data->close;
          $chart_data->volume = $data->volume;
          $chart_data->time = $data->time;
      
          $chart_data->save();
      
           }
          }
        }
        $this->info('Chart Bot Data Updated !');
      }

}