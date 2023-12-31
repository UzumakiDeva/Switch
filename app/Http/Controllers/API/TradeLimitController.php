<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Validator;
use Session;
use App\Libraries\BinanceClass;
use App\Traits\TradeData;
use App\Models\Tradepair;
use App\Models\Transaction;
use App\Models\Trade;
use App\Models\Wallet;
use App\Models\Completedtrade;
use App\Models\AffliateTransaction;


class TradeLimitController extends Controller{
    use TradeData;

    public function buylimit(Request $request) {


		$validator = Validator::make($request->all(), [
		    'pair' 	=> 'required|numeric|min:1',
		    'price' 	=> 'required|numeric|min:0',
		    'quantity' => 'required|numeric|min:0',
		]);
		if ($validator->fails()) { 
           
            return response()->json(["success"=>false,"result"=>NULL,"message"=>$validator->errors()->first()],200);        
		}
		$buypair 	= (int)$request->pair;
		$buyprice 	= (float)$request->price;
		$buyvolume 	= (float)$request->quantity;
         
		if ($buypair != "" && $buyprice > 0 && $buyvolume > 0) {
			$user = Auth::user()->id;			
			$pair = Tradepair::where(['id' => $buypair,'active' => 1])->first();
			if($pair){
				$min_trade_price = $pair->min_buy_price;
				// dd($min_trade_price);
				if($buyprice >= $min_trade_price)
				{
					$buypair = $pair->id;
					if ($buyprice > 0) {
						$selltrade = Trade::where([['trade_type', '=', 'Sell'],['status', '=', 0],['order_type', '=', 1],['pair', '=', $buypair],['uid', '=', $user]])->orderBy('price', 'asc')->first();
						
						if ($selltrade) {
							if ($selltrade->price > $buyprice) {
								$tradeble = true;
							} else {
								$tradeble = true;
							}
						} else {
							$tradeble = true;
						}
						if ($tradeble) {
							$min_trade_volume = $pair->min_buy_amount;
							if ($min_trade_volume <= $buyvolume) {
								$buyprice =  display_format($buyprice,8);
								$buyvolume =  display_format($buyvolume,8);						
								if($pair->buy_trade > 0){
									$commission = bcdiv(sprintf('%.10f', $pair->buy_trade), 100, 8);
									$buytotal 	= bcmul(sprintf('%.10f', $buyprice), sprintf('%.10f', $buyvolume), 8);
									$buyfee 	= bcmul(sprintf('%.10f', $buytotal), sprintf('%.10f', $commission), 8);
									$total 		= bcadd(sprintf('%.10f', $buytotal), sprintf('%.10f', $buyfee), 8);
								}else{
									$commission = 0;
									$total 		= bcmul(sprintf('%.10f', $buyprice), sprintf('%.10f', $buyvolume), 8);
									$buyfee 	= 0;
								}								
								
								//select user balance
								$balance = 0;
								$wallet = Wallet::where([['uid', '=', $user],['currency', '=', $pair->cointwo]])->first();
								if($wallet){
									$balance = $wallet->balance;
								}
								if ((float)$balance >= (float)$total && $balance > 0) {

									if($pair->type == 1 || $pair->type == 2){
										/*************   Start Liquiduty  **************** */	
										$api = new BinanceClass;
										$liqpair = $pair->coinone.$pair->cointwo;
										$buypriceli  = display_format($buyprice,6);
										if($buypriceli > 10){
											$buypriceli  = display_format($buypriceli,2);
										}else if($buypriceli > 0.1){
											$buypriceli  = display_format($buypriceli,3);
										}else if($buyprice < 0.0001){
											$buypriceli  = display_format($buyprice,5);
										}else if($buyprice < 0.00001){
											$buypriceli  = display_format($buyprice,6);
										}else if($buyprice < 0.000001){
											$buypriceli  = display_format($buyprice,8);
										}
										
										$buyvolumeli = display_format($buyvolume,5);
										if($buyvolume < 0.00001){
											$buyvolumeli = display_format($buyvolume,7);
										}
										
										$buyliq = $api->place_limit_buyorder($liqpair,$buyvolumeli,$buypriceli);
										if(isset($buyliq)){
										if (in_array("Filter failure: PRICE_FILTER", $buyliq)) {							
                                            return response()->json(['success'=>false,'result'=>NULL,"message"=>"Price is too high, too low, and/or not following the tick size rule for the symbol."]);
											
										}else if (in_array("Filter failure: PERCENT_PRICE" , $buyliq)) {
									         return response()->json(['success'=>false,'result'=>NULL,"message"=>"Price is X% too high or X% too low from the average weighted price over the last Y minutes"]);

										}else if (in_array("Filter failure: LOT_SIZE" , $buyliq)) {
                                            return response()->json(['success'=>false,'result'=>NULL,"message"=>"Quantity is too high, too low, and/or not following the step size rule for the symbol."]);

										}else if (in_array("Filter failure: MIN_NOTIONAL", $buyliq)) {
                                            return response()->json(['success'=>false,'result'=>NULL,"message"=>"Price * quantity is too low to be a valid order for the symbol."]);

											
										}else if (in_array("Filter failure: MAX_NUM_ORDERS" , $buyliq)) { 
                                            return response()->json(['success'=>false,'result'=>NULL,"message"=>"Account has too many open orders on the symbol."]);  

										}else if (in_array("Filter failure: MAX_ALGO_ORDERS" , $buyliq)) {
         
                                            return response()->json(['success'=>false,'result'=>NULL,"message"=>"Account has too many open stop loss and/or take profit orders on the symbol."]);  	

										}else if (in_array("Filter failure: MAX_NUM_ICEBERG_ORDERS" , $buyliq)) {
                                            return response()->json(['success'=>false,'result'=>NULL,"message"=>"Account has too many open iceberg orders on the symbol."]); 

										}else if (in_array("Filter failure: EXCHANGE_MAX_NUM_ORDERS" , $buyliq)) {
                                            return response()->json(['success'=>false,'result'=>NULL,"message"=>"Account has too many open orders on the exchange."]);  


										}else if (in_array("Filter failure: EXCHANGE_MAX_ALGO_ORDERS"    , $buyliq)) {

                                            return response()->json(['success'=>false,'result'=>NULL,"message"=>"Account has too many open stop loss and/or take profit orders on the exchange."]);  

										}else if(isset($buyliq['msg'])){
											$msg = $buyliq['msg'];
                                            return response()->json(['success'=>false,'result'=>NULL,'message'=>$msg]);
											
										}
										$orderId = $buyliq['orderId'];
										$clientOrderId = $buyliq['clientOrderId'];
										$status = $buyliq['status'];
										$is_type =1;
										}else{
                                            return response()->json(["success"=>false,"result"=>NULL,"message"=>"Something Went wrong please try again later"]);

										}
										
									/*************   End Liquiduty  **************** */	
									}else{
										$orderId = TransactionString(20);
										$clientOrderId = $user;
										$status = 'PENDING';
										$is_type = 0;
									}
									// escrow balance
									$obalance = Wallet::where([['uid', '=', $user],['currency', '=', $pair->cointwo]])->value('balance');
									$balance = bcsub(sprintf('%.10f', $balance), sprintf('%.10f', $total), 8);
									$escrow  = bcadd(sprintf('%.10f', $wallet->escrow_balance), sprintf('%.10f', $total), 8);
									$wallet  = Wallet::where([['uid', '=', $user],['currency', '=', $pair->cointwo]])->update(['balance' => $balance, 'escrow_balance' => $escrow]);
									
									$value = bcsub(sprintf('%.10f', $total), sprintf('%.10f', $buyfee), 8);
									$price = $buyprice;
									$trade = new Trade;
									$trade->uid = $user;
									$trade->trade_type = "Buy";
									$trade->ouid = $clientOrderId;
									$trade->order_id = $orderId;
									$trade->pair = $buypair;
									$trade->order_type = 1;
									$trade->price = $price;
									$trade->volume = $buyvolume;
									$trade->value = $value;
									$trade->fees = $buyfee;
									$trade->commission = $commission;
									$trade->remaining = $trade->volume;
									$trade->status = 0;
									$trade->leverage = 1;
									$trade->spend = 0;
									$trade->post_ty = 'Mobile';
									$trade->balance = $obalance;
									$trade->status_text = $status;
									$trade->is_type = $is_type;
									$trade->created_at = date('Y-m-d H:i:s',time());
									$trade->save();
									$trade_id = $trade->id;		
									//Before trade start
									$tCurrency = $pair->coinone.'/'.$pair->cointwo;
									$this->AllcoinUpdateBalanceTrack($user,$pair->cointwo,0,$total,$balance,$obalance,'buytrade','Buy Post Limit Trade '.$tCurrency,$trade_id);									
								if($pair->type == 0){
									$ogetliveprice=$this->TradePrice($buypair);
									$Liveprice=$ogetliveprice['Last'];
									//select query
									$result = Trade::where([
												['trade_type', '=', 'Sell'],
												['pair', '=', $buypair],
												['status', '=', 0]           
											])->where(function ($tradeprice)use($price,$Liveprice) {              
												$tradeprice->where(function($tradeprice)use($price) {
													$tradeprice->whereIn('order_type', ['1','2'] )->where([['price', '<=', $price]]);      
												})->orWhere([
													['stoplimit', '!=', null],
													['stoplimit', '>=', $Liveprice],
													['price', '<=', $price],
													['order_type', '=', '3'] 
												])->orWhere([
													['stoplimit', '!=', null],
													['stoplimit', '>=', $Liveprice],        
													['order_type', '=', '4'] 
												])->orderBy('price', 'asc');
												});

									if ($result->count() > 0) {
										$remaining = $trade->volume;
										foreach ($result->get() as $data) {
											$avil = Trade::checkStatus($data->id);
											$is_escrow = Wallet::checkEscrowbalance($data->uid, $pair->coinone);
											if((float)$is_escrow >= (float)$data->remaining){
												$ishave_bal = true;
											}else{
												$ishave_bal = false;
												//$data->status = 101;
												//$data->save();
											}
											if($avil && $ishave_bal){
												//trade calculate
												if ($data->remaining <= $remaining) {
													$remaining = bcsub(sprintf('%.10f', $remaining), sprintf('%.10f', $data->remaining), 8);
													$update = array('remaining' => 0, 'status' => 1,'status_text' => 'COMPLETED','updated_at' => date('Y-m-d H:i:s',time()));
													$complete_volume = $data->remaining;
													//admin balance update
													//$adminbalanceupdate = $this->adminBalanceUpdate($pair->coinone, $data->fees);
													$this->affliatAmount($data->uid,$pair->coinone,$data->fees,'Sell',$data->price,$data->volume);
													//debit admin fee
													$sellerbalanceupdate = $this->debitAmount($data->uid, $pair->coinone, $data->fees);
												} else {
													$buyremaining = bcsub(sprintf('%.10f', $data->remaining), sprintf('%.10f', $remaining), 8);
													$update = array('remaining' => $buyremaining,'updated_at' => date('Y-m-d H:i:s',time()));
													$complete_volume = $remaining;
													$remaining = 0;
												}

												//update trader sell table
												Trade::where('id', $data->id)->update($update);
												$price = $data->price;
												//insert complete trade table
												$total = bcmul(sprintf('%.10f', $complete_volume), sprintf('%.10f', $price), 8);
												$complete = new Completedtrade;
												$complete->pair = $buypair;
												$complete->type = 'Buy';
												$complete->buytrade_id = $trade_id;
												$complete->selltrade_id = $data->id;
												$complete->price = $price;
												$complete->volume = $complete_volume;
												$complete->value = $total;
												$complete->save();

												$this->updateTradePrice($buypair);

												//pairs
												$pairs = array('one' => $pair->coinone, 'two' => $pair->cointwo);

												//Update Balance to buyer
												$buyerbalanceupdate = $this->updateBuyerbalance($trade->uid, $complete_volume, $total, $pairs, 'Buy', $trade_id,$tCurrency,$trade->id);

												//Updata balance to Seller
												$sellerbalanceupdate = $this->updateSellerbalance($data->uid, $total, $complete_volume, $pairs, 'Sell', $data->id,$tCurrency,$data->id);

												//update remaining in selltrade
												if ($remaining == 0) {

													//update admin balance
													//$adminbalanceupdate = $this->adminBalanceUpdate($pair->cointwo, $trade->fees);

													$this->affliatAmount($trade->uid,$pair->cointwo,$trade->fees,'Buy',$trade->price,$trade->volume);
													//debit admin fee
													$buyerbalanceupdate = $this->debitAmount($trade->uid, $pair->cointwo, $trade->fees);
													//update trade complete
													$update = array('remaining' => 0, 'status' => 1,'status_text' => 'COMPLETED','updated_at' => date('Y-m-d H:i:s',time()));
													$trade->where('id', $trade_id)->update($update);
													//Remaining Balance return Limit Buyer Fully complete request
													$buyed = Completedtrade::where('buytrade_id', $trade_id)->sum('value');
													$remain_price = bcsub(sprintf('%.10f', $value), sprintf('%.10f', $buyed), 8);

													$commission3 = bcmul(sprintf('%.10f', $commission), sprintf('%.10f', $remain_price), 8);

													$admin_remaining_comm = bcadd(sprintf('%.10f', $remain_price), sprintf('%.10f', $commission3), 8);
													$this->creditStopAmount($user, $pair->cointwo, $admin_remaining_comm, $remain_price,$trade->id);

													break;
												} else {
													$trade->where('id', $trade_id)->update(['remaining' => $remaining,'updated_at' => date('Y-m-d H:i:s',time())]);
												}
											}
										}
									}
								}
								$balanceOne = Wallet::getBalance($user, $pair->coinone);
								$balanceTwo = Wallet::getBalance($user, $pair->cointwo);
								$data['status'] = 'buylimitsuccess';
								$data['balanceOne'] = $balanceOne;
								$data['balanceTwo'] = $balanceTwo;
								$data['balance'] = $balance;
                                return response()->json(["success"=>True,"result"=>$data,"message"=>"Post Trade Successfully!"]);
								

								} else {
                                    return response()->json(["success"=>false ,"result"=>NULL ,"message"=>'Insufficient funds in'. $pair->cointwo.' Wallet!']);
									
								}
							} else {
                                return response()->json(["success"=>false, 'result'=>NULL,"message"=>'Amount must be greater or equal than the minimum trade volume of '.display_format($min_trade_volume)]);
							}
						} else {
                            return response()->json(["success"=>false, "result"=>NULL ,"message"=>'You cannot add buy order greater than your sell order price!']);
						}
					} else {
                        return response()->json(["success"=>false,"result"=>NULL ,"message"=>"Price can't be zero!"]);

					}
				} else{
                    return response()->json(["success"=>false,"result"=>NULL,"message"=>'Price must be greater than or equal to the minimum trade price of '.display_format($min_trade_price)]);

				}
			}else {
                return response()->json(["success"=>false,"result"=>NULL,"message"=>"Invalid Trade pair"]);

			}
	
		} else {
            return response()->json(["success"=>false,"result"=>NULL,"message"=>"All fields required!"]);

		}

		return $data;
	}
    public function selllimit(Request $request) {
		$validator = Validator::make($request->all(), [
			'pair' => 'required|numeric|min:1',
			'price' => 'required|numeric|min:0',
			'quantity' => 'required|numeric|min:0',
		]);
		if ($validator->fails()) {            
            return response()->json(["success"=>false,"result"=>NULL,"message"=>$validator->errors()->first()],200);        
		}
		$sellpair 	= (int)$request->pair;
		$sellprice 	= (float)$request->price;
		$sellvolume = (float)$request->quantity;

		if ($sellpair != "" && $sellprice > 0 && $sellvolume > 0) {

			$user = Auth::user()->id;			
			//select pair
			$pair = Tradepair::where(['id' => $sellpair,'active' => 1])->first();
			if($pair){
				$min_trade_price = $pair->min_sell_price;
				if($sellprice >= $min_trade_price)
				{					
					$sellpair = $pair->id;
					if ($sellprice > 0) {
						$buytrade = Trade::where([
							['trade_type', '=', 'Buy'],
							['status', '=', 0],
							['order_type', '=', 1],
							['pair', '=', $sellpair],
							['uid', '=', $user],
						])->orderBy('price', 'desc')->first();
						if (is_object($buytrade)) {
							if ($buytrade->price < $sellprice) {
								$tradeble = true;
							} else {
								$tradeble = true;
							}
						} else {
							$tradeble = true;
						}
						if ($tradeble) {
							$min_trade_volume = $pair->min_sell_amount;
							if ($sellvolume > 0 && $min_trade_volume <= $sellvolume) {
								$sellprice =  display_format($sellprice,8);
								$sellvolume =  display_format($sellvolume,8);
								if($pair->sell_trade > 0){
									$commission = bcdiv(sprintf('%.10f', $pair->sell_trade), 100, 8);
									$selltotal  = bcmul(sprintf('%.10f', $sellprice), sprintf('%.10f', $sellvolume), 8);
									$sellfee    = bcmul(sprintf('%.10f', $sellvolume), sprintf('%.10f', $commission), 8);
									$total 		= bcadd(sprintf('%.10f', $sellvolume), sprintf('%.10f', $sellfee), 8);
								}else{
									$commission = 0;
									$selltotal  = bcmul(sprintf('%.10f', $sellprice), sprintf('%.10f', $sellvolume), 8);
									$sellfee    = 0;
									$total 		= $sellvolume;
								}
								//select user balance
								$balance = 0;								
								$wallet = Wallet::where([['uid', '=', $user],['currency', '=', $pair->coinone]])->first();
								if($wallet){
									$balance = $wallet->balance;
								}
								if ((float) $balance >= (float) $total && $balance > 0) {
									if($pair->type == 1 || $pair->type == 2){
									/*************   Start Liquiduty  **************** */	
										$api = new BinanceClass;										
										$liqpair = $pair->coinone.$pair->cointwo;
										$sellpriceli  = display_format($sellprice,5);
										$sellvolume =  display_format($sellvolume,5);
										if($sellpriceli > 10){
											$sellpriceli  = display_format($sellpriceli,2);
										}else if($sellpriceli > 0.1){
											$sellpriceli  = display_format($sellpriceli,3);
										}else if($sellpriceli < 0.0001){
											$sellpriceli  = display_format($sellpriceli,4);
										}else if($sellpriceli < 0.000001){
											$sellpriceli  = display_format($sellpriceli,7);
										}
										if($sellvolume > 10){
											$sellvolume  = display_format($sellvolume,2);
										}else if($sellvolume < 0.0001){
											$sellvolume  = display_format($sellvolume,4);
										}else if($sellvolume < 0.000001){
											$sellvolume  = display_format($sellvolume,7);
										}
										$sellliq = $api->place_limit_sellorder($liqpair,$sellvolume,$sellpriceli);
										if(isset($sellliq)){
										if (in_array("Filter failure: PRICE_FILTER", $sellliq)) {
											$msg ="Price is too high, too low, and/or not following the tick size rule for the symbol.";
											return response()->json(['success'=>false,'result'=>NULL,"message"=>$msg]);
										}else if (in_array("Filter failure: PERCENT_PRICE" , $sellliq)) {
											$msg = "Price is X% too high or X% too low from the average weighted price over the last Y minutes.";					
											return response()->json(['success'=>false,'result'=>NULL,"message"=>$msg]);
										}else if (in_array("Filter failure: LOT_SIZE" , $sellliq)) {
											$msg = "Quantity is too high, too low, and/or not following the step size rule for the symbol.";
											return response()->json(['success'=>false,'result'=>NULL,"message"=>$msg]);
										}else if (in_array("Filter failure: MIN_NOTIONAL", $sellliq)) {
											$msg = "Price * quantity is too low to be a valid order for the symbol.";
											return response()->json(['success'=>false,'result'=>NULL,"message"=>$msg]);
										}else if (in_array("Filter failure: MAX_NUM_ORDERS" , $sellliq)) {   	
											$msg = "Account has too many open orders on the symbol.";
											return response()->json(['success'=>false,'result'=>NULL,"message"=>$msg]);
										}else if (in_array("Filter failure: MAX_ALGO_ORDERS" , $sellliq)) {
											$msg = "Account has too many open stop loss and/or take profit orders on the symbol.";
											return response()->json(['success'=>false,'result'=>NULL,"message"=>$msg]);
										}else if (in_array("Filter failure: MAX_NUM_ICEBERG_ORDERS" , $sellliq)) {
											$msg = "Account has too many open iceberg orders on the symbol.";
											return response()->json(['success'=>false,'result'=>NULL,"message"=>$msg]);
										}else if (in_array("Filter failure: EXCHANGE_MAX_NUM_ORDERS" , $sellliq)) {
											$msg = "Account has too many open orders on the exchange.";
											return response()->json(['success'=>false,'result'=>NULL,"message"=>$msg]);
										}else if (in_array("Filter failure: EXCHANGE_MAX_ALGO_ORDERS"    , $sellliq)) {
											$msg = "Account has too many open stop loss and/or take profit orders on the exchange.";
											return response()->json(['success'=>false,'result'=>NULL,"message"=>$msg]);
										}else if(isset($sellliq['msg'])){
											$msg = $sellliq['msg'];
											return response()->json(['success'=>false,'result'=>NULL,"message"=>$msg]);
										}
										$orderId = $sellliq['orderId'];
										$clientOrderId = $sellliq['clientOrderId'];
										$status = $sellliq['status'];
										$is_type = 1;
										}else{
											return response()->json(['success'=>false,'result'=>NULL,"message"=>'Something went wrong please try again later!']);
										}
										
									/*************   End Liquiduty  **************** */	
									}else{
										$orderId = TransactionString(20);
										$clientOrderId = $user;
										$status = 'PENDING';
										$is_type = 0;
									}
									// escrow balance
									$obalance = Wallet::where([['uid', '=', $user],['currency', '=', $pair->coinone]])->value('balance');
									$balance = bcsub(sprintf('%.10f', $balance), sprintf('%.10f', $total), 8);
									$escrow = bcadd(sprintf('%.10f', $wallet->escrow_balance), sprintf('%.10f', $total), 8);
									$wallet = Wallet::where([['uid', '=', $user],['currency', '=', $pair->coinone]])->update(['balance' => $balance, 'escrow_balance' => $escrow]);

									//Before trade start									
									
	               					$price = $sellprice;
									$trade = new Trade;
									$trade->uid = Auth::user()->id;
									$trade->trade_type = 'Sell';
									$trade->ouid = $clientOrderId;
									$trade->order_id = $orderId;
									$trade->pair = $sellpair;
									$trade->order_type = 1;
									$trade->price = $price;
									$trade->volume = $sellvolume;
									$trade->value = $selltotal;
									$trade->fees = $sellfee;
									$trade->commission = $commission;
									$trade->remaining = $trade->volume;
									$trade->status = 0;
									$trade->leverage = 1;
									$trade->spend = 0;
									$trade->post_ty = 'Mobile';
									$trade->balance = $obalance;
									$trade->status_text = $status;
									$trade->is_type = $is_type;
									$trade->created_at = date('Y-m-d H:i:s',time());
									$trade->save();
									$trade_id = $trade->id;
									
									$tCurrency = $pair->coinone.'/'.$pair->cointwo;
									$this->AllcoinUpdateBalanceTrack($user,$pair->coinone,0,$total,$balance,$obalance,'selltrade','Sell Post Limit Trade '.$tCurrency,$trade_id);
								if($pair->type == 0){
									//select query
									$ogetliveprice=$this->TradePrice($pair->id);
									$Liveprice=$ogetliveprice['Last'];
									$result = Trade::where([
										['trade_type', '=', 'Buy'],
												['pair', '=', $sellpair],
												['status', '=', 0],
											])->where(function ($tradeprice) use ($price,$Liveprice) {  
												$tradeprice->where(function($tradeprice)use($price) {
													$tradeprice->whereIn('order_type', ['1','2'] )->where([['price', '>=', $price]]);      
												})->orWhere([
													['stoplimit', '!=', null],
													['stoplimit', '<=', $Liveprice],
													['price', '>=', $price],
													['order_type', '=', '3'] 
												])->orWhere([
													['stoplimit', '!=', null],
													['stoplimit', '<=', $Liveprice],        
													['order_type', '=', '4'] 
												]); 
											})->orderBy('price', 'desc');

									if ($result->count() > 0) {

										$remaining = $trade->volume;
										foreach ($result->get() as $data) {
											$avil = Trade::checkStatus($data->id);
											$is_escrow = Wallet::checkEscrowbalance($data->uid, $pair->cointwo);
											$purchase = ncMul($data->price,$data->remaining);
											if((float)$is_escrow >= (float)$purchase){
												$ishave_bal = true;
											}else{
												$ishave_bal = false;
												//$data->status = 101;
												//$data->save();
											}
											if($avil && $ishave_bal){
												//trade calculate
												if ($data->remaining <= $remaining) {
													$remaining = bcsub(sprintf('%.10f', $remaining), sprintf('%.10f', $data->remaining), 8);
													$update = array('remaining' => 0, 'status' => 1,'status_text' => 'COMPLETED','updated_at' => date('Y-m-d H:i:s',time()));
													$complete_volume = $data->remaining;
													//admin balance update
													//$adminbalanceupdate = $this->adminBalanceUpdate($pair->cointwo, $data->fees);
													$this->affliatAmount($data->uid,$pair->cointwo,$data->fees,'Buy',$data->price,$data->volume);
													//debit admin fee
													$buyerbalanceupdate = $this->debitAmount($data->uid, $pair->cointwo, $data->fees);
													//stop limit remaining return to buyer
													$buycompleted = 0;

												} else {
													$buyremaining = bcsub(sprintf('%.10f', $data->remaining), sprintf('%.10f', $remaining), 8);
													$update = array('remaining' => $buyremaining,'updated_at' => date('Y-m-d H:i:s',time()));
													$complete_volume = $remaining;
													$remaining = 0;
													$buycompleted = 1;
												}

												//updata trader buy table
												Trade::where('id', $data->id)->update($update);
												$price = $data->price;
												//insert complete trade table
												$total = bcmul(sprintf('%.10f', $complete_volume), sprintf('%.10f', $price), 8);
												$complete = new Completedtrade;
												$complete->pair = $sellpair;
												$complete->type = 'Sell';
												$complete->buytrade_id = $data->id;
												$complete->selltrade_id = $trade_id;
												$complete->price = $price;
												$complete->volume = $complete_volume;
												$complete->value = $total;
												$complete->save();

												$this->updateTradePrice($sellpair);
												//pairs
												$pairs = array('one' => $pair->coinone, 'two' => $pair->cointwo);

												//Update Balance to buyer
												$buyerbalanceupdate = $this->updateBuyerbalance($data->uid, $complete_volume, $total, $pairs, 'Buy', $data->id,$tCurrency,$data->id);

												//Updata balance to Seller
												$sellerbalanceupdate = $this->updateSellerbalance($trade->uid, $total, $complete_volume, $pairs, 'Sell', $trade_id,$tCurrency,$trade->id);

												if ($buycompleted == 0) {
													if ($data->order_type != 2) {
														$selled = Completedtrade::where('buytrade_id', $data->id)->sum('value');
														$remain_price = bcsub(sprintf('%.10f', $data->value), sprintf('%.10f', $selled), 8);
														$commission3 = bcmul(sprintf('%.10f', $data->commission), sprintf('%.10f', $remain_price), 8);

														$admin_remaining_comm = bcadd(sprintf('%.10f', $remain_price), sprintf('%.10f', $commission3), 8);
														$this->creditStopAmount($data->uid, $pair->cointwo, $admin_remaining_comm, $remain_price,$data->id);
													}
												}

												//update remaining in selltrade
												if ($remaining == 0) {
													//debit admin fee
													//$adminbalanceupdate = $this->adminBalanceUpdate($pair->coinone, $trade->fees);
													$this->affliatAmount($trade->uid,$pair->coinone,$trade->fees,'Sell',$trade->price,$trade->volume);

													$sellerbalanceupdate = $this->debitAmount($trade->uid, $pair->coinone, $trade->fees);
													$update = array('remaining' => 0, 'status' => 1,'status_text' => 'COMPLETED','updated_at' => date('Y-m-d H:i:s',time()));
													$trade->where('id', $trade_id)->update($update);
													break;
												} else {
													$trade->where('id', $trade_id)->update(['remaining' => $remaining,'updated_at' => date('Y-m-d H:i:s',time())]);
												}
											}
										}
									}
								}
								$balanceOne = Wallet::getBalance($user, $pair->coinone);
								$balanceTwo = Wallet::getBalance($user, $pair->cointwo);
								$data['balanceOne'] = $balanceOne;
								$data['balanceTwo'] = $balanceTwo;
								$data['status'] = 'selllimitsuccess';
								$data['balance'] = $balance;

								return response()->json(["success"=>True,"result"=>$data,"message"=>"Post Trade Successfully!"]);
								} else {
									return response()->json(["success"=>false ,"result"=>NULL ,"message"=>'Insufficient funds in'. $pair->coinone.' Wallet!']);
								}
							} else {
								return response()->json(["success"=>false ,"result"=>NULL ,"message"=>"Amount must be greater or equal than the minimum trade volume of ".display_format($min_trade_volume).""]);
							}
						} else {
							return response()->json(["success"=>false,"result"=>" ","message"=>"Price Must be greater than your last buy price!"]);
						}
					} else {
						return response()->json(["success"=>false,"result"=>" ","message"=>"Price can't be zero!"]);
					}
				} else {
					return response()->json(["success"=>false,"result"=>" ","message"=>"Price must be greater or equal than the minimum trade price of ".display_format($min_trade_price).""]);				
				}
			} else {
				return response()->json(["success"=>false,"result"=>" ","message"=>"Invalid Trade pair!"]);				
			}
			
		} else {
			return response()->json(["success"=>false,"result"=>" ","message"=>"All fields required!"]);
		}
		return $data;		
	}
   
    public function updateBuyerbalance($uid, $buy, $spent, $pair, $type, $tradeid,$tCurrency = null,$actionid=null) {
		// tansaction insert
		$transaction = Transaction::insert([
			['uid' => $uid, 'tradeid' => $tradeid, 'reason' => $type . ' ' . $pair['one'], 'price' => $buy, 'currency' => $pair['one'], 'status' => 'credit', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
			['uid' => $uid, 'tradeid' => $tradeid, 'reason' => $type . ' ' . $pair['one'] . ' spent ' . $pair['two'], 'price' => $spent, 'currency' => $pair['two'], 'status' => 'debit', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
		]);
		$remark = 'Completed Buy Trade '.$tCurrency;
		// credit price
		$this->creditAmount($uid, $pair['one'], $buy,$remark,$actionid);
		// debit price
		$this->debitAmount($uid, $pair['two'], $spent);
		return;
	}
    public function updateSellerbalance($uid, $buy, $spent, $pair, $type, $tradeid,$tCurrency=null,$actionid=null) {
		// tansaction insert
		$transaction = Transaction::insert([
			['uid' => $uid, 'tradeid' => $tradeid, 'reason' => $pair['one'] . ' Sold for ' . $pair['two'] . '(' . $buy . ')', 'price' => $buy, 'currency' => $pair['two'], 'status' => 'credit', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
			['uid' => $uid, 'tradeid' => $tradeid, 'reason' => $pair['two'] . '(' . $buy . ') equelant to ' . $pair['one'] . ' Sold', 'price' => $spent, 'currency' => $pair['one'], 'status' => 'debit', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
		]);

		$remark = 'Completed Sell Trade '.$tCurrency;
		// credit price
		$this->creditAmount($uid, $pair['two'], $buy,$remark,$actionid);
		// debit price
		$this->debitAmount($uid, $pair['one'], $spent);
		return;
	}
    public function creditAmount($uid, $currency, $price,$remark =null,$actionid=null) {
		$userbalance = Wallet::where([['uid', '=', $uid], ['currency', '=', $currency]])->first();	
		if ($userbalance) {
			$oldbalance = $userbalance->balance;
			$total = bcadd(sprintf('%.10f', $price), sprintf('%.10f', $userbalance->balance), 8);
			Wallet::where([['uid', '=', $uid], ['currency', '=', $currency]])->update(['balance' => $total], ['updated_at' => date('Y-m-d H:i:s')]);
			$walletbalance = $total;
		} else {
			$oldbalance = 0;
			Wallet::insert(['uid' => $uid, 'currency' => $currency, 'balance' => $price, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
			$walletbalance = $price;
		}		
		$this->AllcoinUpdateBalanceTrack($uid,$currency,$price,0,$walletbalance,$oldbalance,'trade',$remark,$actionid);
	}
    public function debitAmount($uid, $currency, $price) {
		$userbalance = Wallet::where([['uid', '=', $uid], ['currency', '=', $currency]])->first();
		if ($userbalance) {
			$total = bcsub(sprintf('%.10f', $userbalance->escrow_balance), sprintf('%.10f', $price), 8);
			Wallet::where([['uid', '=', $uid], ['currency', '=', $currency]])->update(['escrow_balance' => $total, 'updated_at' => date('Y-m-d H:i:s')]);

		} else {
			Wallet::insert(['uid' => $uid, 'currency' => $currency, 'escrow_balance' => $price, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
		}
	}
    public function AllcoinUpdateBalanceTrack($uid,$currency,$creditamount=0,$debitamount=0,$walletbalance=0,$oldbalance=null,$tradetype=null,$remark=null,$actionid=null)
	{
		if($creditamount > 0 || $debitamount > 0)
		{
			$Models = '\App\Models\OverallTransaction';
			$Models::AddTransaction($uid,$currency,$tradetype,$creditamount,$debitamount,$walletbalance,$oldbalance,$remark,'web',$actionid);
		}		
		return true;
	}
    public function creditStopAmount($uid, $currency, $price, $remain_price,$actionid=null) {
		$userbalance = Wallet::where([['uid', '=', $uid], ['currency', '=', $currency]])->first();
		$oldbalance = $userbalance->balance;
		if ($userbalance) {
			$total = bcsub(sprintf('%.10f', $userbalance->escrow_balance), sprintf('%.10f', $remain_price), 8);
			$baltotal = bcadd(sprintf('%.10f', $price), sprintf('%.10f', $userbalance->balance), 8);
			Wallet::where([['uid', '=', $uid], ['currency', '=', $currency]])->update(['balance' => $baltotal, 'escrow_balance' => $total, 'updated_at' => date('Y-m-d H:i:s')]);
			$walletbalance = $baltotal;
			$this->AllcoinUpdateBalanceTrack($uid,$currency,$price,0,$walletbalance,$oldbalance,'trade','Best price complete to remaining balance return',$actionid);
		}		

	}
    public function affliatAmount($uid,$coin,$amount,$type,$price,$volume){		
		AffliateTransaction::affliate_transaction($uid,$coin,$amount,$type,$price,$volume);
		return true;
	}

}
?>