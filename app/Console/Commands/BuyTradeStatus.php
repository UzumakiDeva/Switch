<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\Models\Tradepair;
use App\Models\Buytrade;

use App\Models\Wallet;
use App\Models\Adminwallet;
use App\Models\AdminTransactions;
use App\Models\OverallTransaction;
use App\Libraries\BinanceClass;
use App\Models\AffliateTransaction;
use Illuminate\Support\Facades\Mail;
use App\Mail\Cryptobuy;

class BuyTradeStatus extends Command
{
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:buytrade';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update liquidity buy trade histroy status';

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
		$buytrades = Buytrade::where([ ['status', '=', 0]])->whereIn('is_type',[1, 2])->get();
		if(count($buytrades) > 0){			
			foreach ($buytrades as $buytrade) {
				$pair = Tradepair::where('id',$buytrade->pair)->first();
				$api = new BinanceClass;
				$orderid = $buytrade->order_id;
				if($pair->type == 2){
					$liqu = $pair->coinone."USDT";
				}else{
					$liqu = $pair->coinone.$pair->cointwo;
				}
				$orderstatus = $api->order_status($liqu, $orderid);
				if(isset($orderstatus['status'])){
					if($orderstatus['status'] == 'NEW'){
					  $status ='0';
					  $order_status = $orderstatus['status'];
					}
					elseif($orderstatus['status'] == 'CANCELED'){
					  $status ='100';
					  $order_status = $orderstatus['status'].' Liquidity';
					   $update = array('status' => 100,'status_text' => $order_status,'updated_at' => date('Y-m-d H:i:s',time()));
						Buytrade::where('id', $buytrade->id)->update($update);
						$remark ="Buy trade cancelled binance pair $pair->coinone /$pair->cointwo";
						$remain_price = bcadd(sprintf('%.10f', $buytrade->value), sprintf('%.10f', $buytrade->fees), 8); 
						//$this->creditAmount($buytrade->uid, $pair->cointwo, $remain_price,$remark,'web liquidity cancelled',$buytrade->id);
					}
					elseif($orderstatus['status'] == "FILLED"){
					  $status ='1';
					  $order_status = $orderstatus['status'];
					  $adminbalanceupdate = $this->adminBalanceUpdate($pair->cointwo, $buytrade->fees,'buy');

					  //$this->affliatAmount($buytrade->uid,$pair->cointwo,$buytrade->fees,'Buy',$buytrade->price,$buytrade->volume);
						$pairTr =  $pair->coinone.'/'.$pair->cointwo;
						if($buytrade->order_type == 1){
							$trade_type = 'Limit';
						}else {
							$trade_type = 'Market';
						}
						$tradeid = $buytrade->id;
					   AdminTransactions::CreateTransaction($buytrade->uid, 'buy', $pair->cointwo,0,$buytrade->price,$buytrade->volume,$buytrade->value,$buytrade->fees,$buytrade->commission,$pairTr,$trade_type,$tradeid);
						//update trade complete
						$update = array('remaining' => 0, 'status' => 1,'status_text' => $order_status,'updated_at' => date('Y-m-d H:i:s',time()));
						Buytrade::where('id', $buytrade->id)->update($update);
						//Remaining Balance return Limit Buyer Fully complete request
						$remain_price = bcadd(sprintf('%.10f', $buytrade->value), sprintf('%.10f', $buytrade->fees), 8);
						
						$this->debitAmount($buytrade->uid, $pair->cointwo, $remain_price); 
						$remark ="Buy trade complete binance pair $pair->coinone /$pair->cointwo";
						$this->creditAmount($buytrade->uid, $pair->coinone, $buytrade->volume,$remark,'web liquidity',$buytrade->id);
						//Mail
						$user = User::where('id',$buytrade->uid)->first(); 

						$details = array(
							'coinone'       => $pair->coinone,
							'cointwo'       => $pair->cointwo,
							'amount'     	=> $buytrade->volume,
							'price'       	=> $buytrade->price,  
						); 

						Mail::to($user->email)->send(new Cryptobuy($user,$details)); 
					}
				}else{
					echo $orderid."  $liqu ".$orderstatus['msg'];
				}
			}
		}
            
        $this->info('Buy trade updated to All Users');
    }
    /**
        * [debitAmount description]
        * @param  [int] $uid      [user ID]
        * @param  [string] $currency [Currency Name]
        * @param  [float] $price    [price value]
        * @return void
    */
    public function debitAmount($uid, $currency, $price) {
        
        $userbalance = Wallet::where([['uid', '=', $uid], ['currency', '=', $currency]])->first();
        if ($userbalance) {
            $total = bcsub(sprintf('%.10f', $userbalance->escrow_balance), sprintf('%.10f', $price), 8);
            $update_wallet = Wallet::where('uid', $uid)->where('currency', $currency)
            ->update(['escrow_balance' => $total]);
        }        
    }
    
    /**
        * [creditAmount description]
        * @param  [int] $uid      [user ID]
        * @param  [string] $currency [Currency Name]
        * @param  [float] $price    [price value]
        * @return void
    */
    public function creditAmount($uid, $currency, $price,$remark=null,$actionfrom=null,$actionid=null) {
        
        $userbalance = Wallet::where([['uid', '=', $uid], ['currency', '=', $currency]])->first();
        if ($userbalance) {
            $oldbalance = $userbalance->balance;
            $total = bcadd(sprintf('%.10f', $price), sprintf('%.10f', $userbalance->balance), 8);
            Wallet::where([['uid', '=', $uid], ['currency', '=', $currency]])->update(['balance' => $total], ['updated_at' => date('Y-m-d H:i:s')]);
            $balance = $total;
        } else {
            $oldbalance = 0;
            $balance = $price;
            Wallet::insert(['uid' => $uid, 'currency' => $currency, 'balance' => $price, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
        }
        
        OverallTransaction::addTransaction($uid,$currency,'buytrade',$price,0,$balance,$oldbalance,$remark,$actionid,'user');
    }
    /**
        * [adminBalanceUpdate description]
        * @param  [string] $currency [Curreny name]
        * @param  [float] $price    [price value]
        * @return void
    */
    public function affliatAmount($uid,$coin,$amount,$type,$price,$volume){     
        AffliateTransaction::affliate_transaction($uid,$coin,$amount,$type,$price,$volume);
        return true;
    }

    public function adminBalanceUpdate($currency, $price,$type=null) {
        $adminbalance = Adminwallet::where('currency', '=', $currency)->first();
        if ($adminbalance) {
            $total_bal = ncAdd($price, $adminbalance->balance, 8);
            $total_cmn = ncAdd($price, $adminbalance->commission, 8);
            $trade     = ncAdd($price, $adminbalance->trade, 8);
            if($type == 'buy'){
                $buytrade     = ncAdd($price, $adminbalance->buytrade, 8);
                $selltrade    = $adminbalance->selltrade;
            }else{
                $buytrade     = $adminbalance->buytrade;
                $selltrade    = ncAdd($price, $adminbalance->selltrade, 8);
            }
            Adminwallet::where('currency', '=', $currency)->update(['balance' => $total_bal, 'commission' => $total_cmn, 'trade'=>$trade, 'buytrade'=>$buytrade,'selltrade'=>$selltrade,'updated_at' => date('Y-m-d H:i:s')]);
        } else {
             if($type == 'buy'){
                $buytrade     = $price;
                $selltrade    = 0;
            }else{
                $buytrade     = 0;
                $selltrade    = $price;
            }
            Adminwallet::insert(['currency' => $currency, 'balance' => $price, 'commission' => $price, 'trade'=>$price, 'buytrade'=>$buytrade,'selltrade'=>$selltrade,'created_at' => date('Y-m-d H:i:s',time()), 'updated_at' => date('Y-m-d H:i:s',time())]);
        }
    }
}
