<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tradepair;

class UpdateLivePrizeDextrade extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:liveprizeDextrade';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update High Low Open Close';

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
        $pair =Tradepair::where(['is_dust' => 0,'is_bot' => 1 ])->get();
		if(count($pair) > 0){
			foreach($pair as $data){           
			  $symbol =$data->symbol;
				  $id =$data->id;
				 //  $symbol =$pair->pluck('symbol')->all();
				  $curl = curl_init();
				
				curl_setopt_array($curl, array(
				  CURLOPT_URL => 'https://api.dex-trade.com/v1/public/ticker?pair='.$symbol,
				  CURLOPT_RETURNTRANSFER => true,
				  CURLOPT_ENCODING => '',
				  CURLOPT_MAXREDIRS => 10,
				  CURLOPT_TIMEOUT => 0,
				  CURLOPT_FOLLOWLOCATION => true,
				  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				  CURLOPT_CUSTOMREQUEST => 'GET',
				  CURLOPT_HTTPHEADER => array(
					'Cookie: PHPSESSID=0tgibugfgp6ubfaapield3dhm0; _csrf=QU36yemtF48jZgOFN7ZKt1Nnzv_YJuir'
				  ),
				));
				
				$response = curl_exec($curl);
				$total_data = json_decode($response);
				$data =$total_data->data;
				curl_close($curl);
				// echo $response;
				
				$update =Tradepair::where(['id'=> $id])->first();
				$update->close  = $data->last;
				$update->open  =$data->open;
				$update->low =$data->low;
				$update->high =$data->high;
				$update->hrvolume =$data->volume_24H;
				$change =$data->last -  $data->open ;
				$change_price = ($data->open == '0') ? 0 : (($change / $data->open) * 100);
				$update->hrchange =display_format($change_price,2);
				
				$update->save();
			}
		}

    $this->info('Trade Price update successfully');
    }

}
