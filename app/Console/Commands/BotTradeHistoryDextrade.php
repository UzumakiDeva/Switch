<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\BotTradeHistory;
use App\Models\Tradepair;

class BotTradeHistoryDextrade extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:BotTradeHistory';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Bot Trade History updated';

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
         $ifexits = BotTradeHistory::where(['pair'=>$id])->delete(); 
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.dex-trade.com/v1/public/trades?pair='.$symbol,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
          CURLOPT_HTTPHEADER => array(
            'Cookie: PHPSESSID=ugfse13tihu8sdrbra002a3bc9'
          ),
        )); 
        $response = curl_exec($curl);  
        curl_close($curl);
          $total = json_decode($response);
          $trade_history =$total->data;
          foreach($trade_history as $data){  
          $trade_history= new BotTradeHistory;
          $trade_history->pair =$id;
          $trade_history->type = $data->type;
          $trade_history->price = $data->rate;
          $trade_history->volume = $data->volume;
          $trade_history->save();
           }
          }
        }
        $this->info('Update BotTrade History');
    }
}