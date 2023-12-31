<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\User;
use App\Models\MarketPlace;
use Mail;

class UpdateBankExpired extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:p2pexpired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update all p2p pending payment transaction';

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
        $now = Carbon::now();
        $date = Carbon::parse($now)->toDateString();
        $time = Carbon::parse($now)->toTimeString();

        $products = MarketPlace::whereIn('status',[1,2,3])->where('closed_at', '<', $now)->get();
        if(count($products) > 0){
            foreach ($products as $product) {
                $tid = $product->id;
                if($product->status == 3){
                    MarketPlace::where('id',$tid)->update(['status' => 5, 'status_text' => 'Rise Dispute','remarks' => 'Rise Dispute Query delay not received payment','updated_at' => date('Y-m-d H:i:s',time())]);
                }else{
                   if($product->trade_type == 'Buy'){
                        MarketPlace::where('id',$tid)->update(['status' => 4, 'is_hold' => 1, 'status_text' => 'Timeout Cancelled','remarks' => '','updated_at' => date('Y-m-d H:i:s',time())]);
                    }else{
                        MarketPlace::where('id',$tid)->update(['status' => 0, 'is_hold' => 0, 'status_text' => 'Pending','remarks' => '','updated_at' => date('Y-m-d H:i:s',time())]);
                    } 
                }
                
            }
        }   
        $this->info('Cancelled all pending expired pending trades!');
    }
}
