<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\UserPaymentTransaction;

class DeletePendingPayment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:pendingpayment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete all pending payments';

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
        $currentDate = date('Y-m-d');
        $payments = UserPaymentTransaction::whereDate('created_at', '<=', $currentDate)->where('payment_type','=','coinpayments')->where('status','<=',0)->get();
        if(count($payments) > 0){
            foreach ($payments as $payment) {
                UserPaymentTransaction::where(['id' => $payment->id])->delete();
            } 
        }


       /* $date = new \DateTime();
        $date->modify('-48 hours');
        $formatted_date = $date->format('Y-m-d H:i:s');
        $payments1 = UserPaymentTransaction::whereDate('created_at', '<=', $formatted_date)->where('payment_type','=','booking')->where('status','<=',0)->get();
        if(count($payments1) > 0){
            foreach ($payments1 as $paymenta) {
                $data = UserPaymentTransaction::where(['id' => $paymenta->id])->first();
                if($data){
                    $data->status = 2;
                    $data->status_text = 'Auto Cancelled';
                    $data->save();
                }
            } 
        }*/


        /* $payments = UserPaymentTransaction::whereDate('created_at', '<=', $currentDate)->where('payment_type','!=','coinpayments')->where('status','!=',1)->get();
        if(count($payments) > 0){
            foreach ($payments as $payment) {
                UserPaymentTransaction::where(['id' => $payment->id])->delete();
            } 
        } */
              
        $this->info('all pending payments deleted');
    }
}
