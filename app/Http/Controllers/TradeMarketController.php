<?php
namespace App\Http\Controllers;

use Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Adminwallet;
use App\Models\Trade;
use App\Models\Commission;
use App\Models\Completedtrade;
use App\Models\Selltrade;
use App\Models\Tradepair;
use App\Models\Transaction;
use App\User;
use App\Models\Wallet;
use Auth;
use Illuminate\Http\Request;
use App\Models\AffliateTransaction;
use App\Traits\TradeData;
use App\Libraries\BinanceClass;

class TradeMarketController extends Controller {
	use TradeData;
	/**
	 * @param  Illuminate\Http\Request request
	 * @return [jsondata]
	 */
	
	public function buymarket(Request $request) {
		$validator = Validator::make($request->all(), [
			'buypair' => 'required|numeric',
			'buymarketvolume' => 'required|numeric',
		]);
		if ($validator->fails()) { 
			$data['status'] = 'fail';
			$data['msg'] = "<div id='buymarketsuccess' class='alerttext text-danger text-center'>".__('message.Allfieldsrequired')."</div>";
			return $data;           
		}
		$buypair = (int)$request->buypair;
		$buymarketvolume = (float)$request->buymarketvolume;
		if ($buypair != "" && $buymarketvolume > 0) {			
			$volume = $buymarketvolume;
			$pair = Tradepair::where(['id' => $buypair,'active' => 1])->first();
			if($pair){
				$order_type = 2;
				$user = Auth::user()->id;
				$commission = bcdiv(sprintf('%.10f', $pair->buy_trade), 100, 8);
				if($pair->type == 1 || $pair->type == 2){
					$coinone_decimal = $pair->coinone_decimal;
					$cointwo_decimal = $pair->cointwo_decimal;
					if($pair->min_buy_amount > 0 && $volume < $pair->min_buy_amount)
					{
						$data['status'] = 'fail';
						$data['msg'] = "<div id='buymarketsuccess' class='alerttext text-danger text-center'>Minimum buy amount ".number_format($pair->min_buy_amount, 8, '.', '')."</div>";
						return $data;
					}
					if($pair->max_amount > 0 && $volume > $pair->max_amount)
					{
						$data['status'] = 'fail';
						$data['msg'] = "<div id='buymarketsuccess' class='alerttext text-danger text-center'>Maximum buy amount ".number_format($pair->max_amount, 8, '.', '')."</div>";
						return $data;
					}
					$balance = 0;
					$wallet = Wallet::where([['uid', '=', $user],['currency', '=', $pair->cointwo],])->first();
					if ($wallet) {
						$balance = $wallet->balance;
					}
					if($pair->min_buy_price > 0 && $balance < $pair->min_buy_price)
					{
						$data['status'] = 'fail';
						$data['msg'] = "<div id='buymarketsuccess' class='alerttext text-danger text-center'>Total value must be at least ".number_format($pair->min_buy_price, 8, '.', '')." ".$pair->cointwo."</div>";
						return $data;
					}
					DB::beginTransaction();
					try
					{
						$is_price = 0;
						$get_last_price = $this->getLastPrice($pair_details->coinone.$pair_details->cointwo);
						if(!isset($get_last_price->lastPrice))
						{
							$get_last_price_data = TradePair::where('id', $pair_details->id)->first();
							if(is_object($get_last_price))
							{
								$is_price = $get_last_price->live_price;
							}
						}
						else
						{
							$is_price = $get_last_price->lastPrice;
						}

						$quoteOrder = ncMul($is_price, $volume, $cointwo_decimal);
						//admin fees
						$fees = bcmul(sprintf('%.10f', $quoteOrder), sprintf('%.10f', $commission), 8);
						$get_total_val = bcadd(sprintf('%.10f', $quoteOrder), sprintf('%.10f', $fees), 8);
							
						if($get_total_val > $balance){
							$message = "Your current balance is ".$is_user_balance." ".$pair_details->cointwo." (Your trade volume is ".$volume.")";
							$data['status'] = 'fail';
							$data['msg'] = "<div id='buymarketsuccess' class='alerttext text-danger text-center'>$message</div>";
							return $data;
						}
						$getpair = strtoupper($pair_details->coinone.$pair_details->cointwo);
						//get order book
						$orderbook = $this->liquidityNewPlaceMarketOrder($quoteOrder, $volume, $getpair, "BUY", $cointwo_decimal, $coinone_decimal);
						if($orderbook['status'] == 'success')
						{
							$obalance = $balance;
							$result = $orderbook['message'];
							
							$trade = new Trade;
							$trade->uid = $user;
							$trade->trade_type = "Buy";
							$trade->pair = $pair->id;
							$trade->ouid = $result['clientOrderId'];
							$trade->order_id = $result['orderId'];
							$trade->order_type = 2;
							$trade->volume = $volume;
							$trade->value = $quoteOrder;
							$trade->fees = $fees;
							$trade->remaining = 0;
							$trade->status = 0;
							$trade->leverage = 1;
							$trade->spend = 0;
							$trade->post_ty = 'web';
							$trade->balance = $obalance;
							$trade->status_text = $result['status'];
							$trade->is_type = 1;
							$trade->save();
								
							$trade_id = $trade->id;
							if(isset($result['fills']))
							{
								//get average price
								$get_avg_price = $total_value = 0;
								for ($j = 0; $j < count($result['fills']); $j++)
								{ 
									$get_data = $result['fills'][$j];
									$get_avg_price+=$get_data['price'];
								}

								if(count($result['fills']) > 0 && $get_avg_price > 0)
								{
									$get_avg_price = $get_avg_price / count($result['fills']);
									$total_value = ncMul($get_avg_price, $result['executedQty'], $cointwo_decimal);
								}
								$fees = bcmul(sprintf('%.10f', $total_value), sprintf('%.10f', $commission), 8);
								$totalprice = bcadd(sprintf('%.10f', $total_value), sprintf('%.10f', $fees), 8);
						
								Trade::where('id', $trade_id)->update([
									'price' => $get_avg_price,
									'filled' => $result['executedQty'],
									'value' => $total_value,
									'fees' => $fees,
									'status' => 1
								]);
								$balance = bcsub(sprintf('%.10f', $balance), sprintf('%.10f', $totalprice), 8);
								$wallet = Wallet::where([
									['uid', '=', $user],
									['currency', '=', $pair->cointwo],
								])->update(['balance' => $balance, 'updated_at' => date('Y-m-d H:i:s',time())]);

								//Before trade start
								$tCurrency = $pair->coinone.'/'.$pair->cointwo;
								$remark ='Buy Post liquidty Market Trade '.$tCurrency;
								$this->AllcoinUpdateBalanceTrack($user,$pair->cointwo,0,$totalprice,$balance,$obalance,'buytrade',$remark,$trade_id);
								//$this->creditAmount($user, $pair->coinone, $result['executedQty'],$remark,$trade_id);
								Wallet::creditAmount($user, $pair->coinone, $result['executedQty'], 8,'buytrade',$remark,$trade_id);
								$adminbalanceupdate = $this->adminBalanceUpdate($pair->cointwo, $fees,'buy');
								$pairTr =  $pair->coinone.'/'.$pair->cointwo;
								//AdminTransactions::CreateTransaction($trade->uid, 'buy', $pair->cointwo,0,$get_avg_price,$trade->volume,$total_value,$fees,$commission,$pairTr,'Market',$trade->id);
								$balanceOne = Wallet::getBalance($user, $pair->coinone);
								$balanceTwo = Wallet::getBalance($user, $pair->cointwo);
								$data['balanceOne'] = $balanceOne;
								$data['balanceTwo'] = $balanceTwo;
								$data['status'] = 'buymarketsuccess';
								$data['trade'] = $result;
								$data['balance'] = $balance;
								$data['msg'] = "<div id='buymarketsuccess'  class='alerttext text-success text-center'>".__('message.PostTradeSuccessfully')."</div>";

								DB::commit();
								return $data;
							} else{
								$trade->status = 100;
								$trade->status_text = "Operation Cancel";
								$trade->save();
								
								$message = "Something went wrong, try again later!";
								$data['status'] = 'fail';
								$data['msg'] = "<div id='buymarketsuccess' class='alerttext text-danger text-center'>$message</div>";
							}
						} else {
							$message = "Something went wrong, try again later!";
							if(isset($orderbook['message']))
							{
								$message = $orderbook['message'];
							}
							//rollback here
							DB::rollBack();

							$data['status'] = 'fail';
							$data['msg'] = "<div id='buymarketsuccess' class='alerttext text-danger text-center'>$message</div>";
							return $data;
						}
					}
					catch(Exception $e)
					{
						//rollback here
						DB::rollBack();
						$data['status'] = 'fail';
						$data['msg'] = "<div id='buymarketsuccess' class='alerttext text-danger text-center'>Something went wrong, try again later!</div>";
						return $data;
					}
					
				} else{
					DB::beginTransaction();
					try
					{
						$ogetliveprice=$this->TradePrice($buypair);
						$Liveprice=$ogetliveprice['Last']; 
						
						//validation ends
						$result = Trade::where([
							['trade_type', '=', 'Sell'],
							['pair', '=', $pair->id],
							['status', '=', 0],
						])->where(function ($tradeprice)use($Liveprice) {              
							$tradeprice->where(function($tradeprice) {
								$tradeprice->whereIn('order_type', ['1','2'] );      
							})->orWhere([
								['stoplimit', '!=', null],
								['stoplimit', '>=', $Liveprice],        
								['order_type', '=', '3'] 
							])->orWhere([
								['stoplimit', '!=', null],
								['stoplimit', '>=', $Liveprice],        
								['order_type', '=', '4'] 
							]);
							})->orderBy('price', 'asc')->get();
						//select pair
						$buypair = $pair->id;
					
						$min_trade_volume = $pair->min_buy_amount;
						if($volume > 0 && $min_trade_volume <= $volume) {
							if ($result->count() > 0) {
								
								if ($result->sum('remaining') >= $volume) {
									$obalance = Wallet::where([['uid', '=', $user],['currency', '=', $pair->cointwo]])->value('balance');
									if($obalance <= 0){
										$data['status'] = 'fail';
										$data['msg'] = "<div id='buymarketwarning'class='alerttext text-danger text-center'>'".__('message.Insufficient') . $pair->cointwo." " . __('message.Wallet')."'</div>";
										return $data;
									}
									//select user balance
									$balance = 0;
									$wallet = Wallet::where([
										['uid', '=', $user],
										['currency', '=', $pair->cointwo],
									])->first();

									if ($wallet) {
										$balance = $wallet->balance;
									}

									$require_volume = $volume;
									$totalamount = 0;
									$totalprice = 0;
									foreach ($result as $res) {
										if ($res->remaining >= $require_volume) {											
											$total = bcmul(sprintf('%.10f', $res->price), sprintf('%.10f', $require_volume), 8);
											$totalprice += $total;
											break;
										} else {											
											$total = bcmul(sprintf('%.10f', $res->price), sprintf('%.10f', $res->remaining), 8);
											$totalprice += $total;
											$require_volume = bcsub(sprintf('%.10f', $require_volume), sprintf('%.10f', $res->remaining), 8);
										}
									}
									//admin fees
									$fees = bcmul(sprintf('%.10f', $totalprice), sprintf('%.10f', $commission), 8);
									$totalprice = bcadd(sprintf('%.10f', $totalprice), sprintf('%.10f', $fees), 8);							

									if ($totalprice <= $balance) {
										$orderId = TransactionString(20);
										$clientOrderId = $user;
										$status = 'PENDING';
										$is_type = 0;
										
										$trade = new Trade;
										$trade->uid = $user;
										$trade->trade_type = "Buy";
										$trade->pair = $buypair;
										$trade->ouid = $clientOrderId;
										$trade->order_id = $orderId;
										$trade->order_type = 2;
										$trade->volume = $volume;
										$trade->value = $totalprice;
										$trade->fees = $fees;
										$trade->remaining = $trade->volume;
										$trade->status = 0;
										$trade->leverage = 1;
										$trade->spend = 0;
										$trade->post_ty = 'web';
										$trade->balance = $obalance;
										$trade->status_text = $status;
										$trade->is_type = $is_type;
										$trade->save();
										$trade_id = $trade->id;

										// escrow balance
										$balance = bcsub(sprintf('%.10f', $balance), sprintf('%.10f', $totalprice), 8);
										$escrow = bcadd(sprintf('%.10f', $wallet->escrow_balance), sprintf('%.10f', $totalprice), 8);
										$wallet = Wallet::where([
											['uid', '=', $user],
											['currency', '=', $pair->cointwo],
										])->update(['balance' => $balance, 'escrow_balance' => $escrow,'updated_at' => date('Y-m-d H:i:s',time())]);

										
										//Before trade start
									$tCurrency = $pair->coinone.'/'.$pair->cointwo;
									$this->AllcoinUpdateBalanceTrack($user,$pair->cointwo,0,$totalprice,$balance,$obalance,'buytrade','Buy Post Market Trade '.$tCurrency,$trade_id);

									
										$remaining = $trade->volume;
										//dd($totalprice);
										foreach ($result as $data) {
											$avil = Trade::checkStatus($data->id);
											
											if($data->status == 0){
												//trade calculate
												if ($data->remaining <= $remaining) {
													$remaining = bcsub(sprintf('%.10f', $remaining), sprintf('%.10f', $data->remaining), 8);
													$update = array('remaining' => 0, 'status' => 1,'status_text' => 'COMPLETED','updated_at' => date('Y-m-d H:i:s',time()));
													$complete_volume = $data->remaining;
													//admin balance update
													$adminbalanceupdate = $this->adminBalanceUpdate($pair->coinone, $data->fees,'sell');
													//affiliat Process											
													$this->affliatAmount($data->uid,$pair->coinone,$data->fees,'Sell',$data->price,$data->volume);
													//debit admin fee
													$sellerbalanceupdate = $this->debitAmount($data->uid, $pair->coinone, $data->fees);
												} else {
													$buyremaining = bcsub(sprintf('%.10f', $data->remaining), sprintf('%.10f', $remaining), 8);
													$update = array('remaining' => $buyremaining);
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
												//end complete trade
												$this->updateTradePrice($pair->id);
												//pairs
												$pairs = array('one' => $pair->coinone, 'two' => $pair->cointwo);
												//Update Balance to buyer
												$buyerbalanceupdate = $this->updateBuyerbalance($trade->uid, $complete_volume, $total, $pairs, 'Buy', $trade_id,$tCurrency);
												//Updata balance to Seller
												$sellerbalanceupdate = $this->updateSellerbalance($data->uid, $total, $complete_volume, $pairs, 'Sell', $data->id,$tCurrency);
												//update remaining in selltrade
												if ($remaining == 0) {
													//update admin balance
													$adminbalanceupdate = $this->adminBalanceUpdate($pair->cointwo, $trade->fees,'buy');
													$this->affliatAmount($trade->uid,$pair->cointwo,$trade->fees,'Buy',$trade->price,$trade->volume);
													//debit admin fee
													$buyerbalanceupdate = $this->debitAmount($trade->uid, $pair->cointwo, $trade->fees);
													$update = array('remaining' => 0, 'status' => 1,'status_text' => 'COMPLETED','updated_at' => date('Y-m-d H:i:s',time()));
													$trade->where('id', $trade_id)->update($update);
													break;
												} else {
													$trade->where('id', $trade_id)->update(['remaining' => $remaining,'updated_at' => date('Y-m-d H:i:s',time())]);
												}
											}
										}
										$balanceOne = Wallet::getBalance($user, $pair->coinone);
										$balanceTwo = Wallet::getBalance($user, $pair->cointwo);
										$data['balanceOne'] = $balanceOne;
										$data['balanceTwo'] = $balanceTwo;
										DB::commit();

										$data['status'] = 'buymarketsuccess';
										$data['balance'] = $balance;
										$data['msg'] = "<div id='buymarketsuccess'  class='alerttext text-success text-center'>".__('message.PostTradeSuccessfully')."</div>";
										return $data;

									} else {
										DB::rollBack();
										$data['status'] = 'fail';
										$data['msg'] = "<div id='buymarketwarning'class='alerttext text-danger text-center'>'".__('message.Insufficient')." " . $pair->cointwo . " wallet!'</div>";

									}

								} else {
									DB::rollBack();
									$data['status'] = 'fail';
									$data['msg'] = "<div id='buymarketwarning' class='alerttext text-danger text-center'>".__('message.Onlyavailable')."." . display_format($result->sum('remaining')) . "</div>";
								}
							} else {
								DB::rollBack();
								$data['status'] = 'fail';
								$data['msg'] = "<div id='buymarketwarning' class='alerttext text-danger text-center'>".__('message.Tradenotavailableyet')."</div>";
							}
						} else {
							DB::rollBack();
							$data['status'] = 'fail';
							$data['msg'] = "<div id='buymarketwarning' class='alerttext text-danger text-center'>" .__('message.Amountmustbe').display_format($min_trade_volume)."</div>";
						}
					}catch(Exception $e){
						DB::rollBack();
						$data['status'] = 'fail';
						$data['msg'] = "<div id='buymarketsuccess' class='alerttext text-danger text-center'>Something went wrong, try again later!</div>";
						return $data;
					}

				}
			} else {
				$data['status'] = 'fail';
				$data['msg'] = "<div id='buymarketsuccess' class='alerttext text-danger text-center'>".__('message.InvalidTradepair')."</div>";

			}
		} else {
			$data['status'] = 'fail';
			$data['msg'] = "<div id='buymarketsuccess' class='alerttext text-danger text-center'>".__('message.Allfieldsrequired')."</div>";

		}
		return $data;
	}

	/**
	 * @param  Illuminate\Http\Request request
	 * @return [jsondata]
	 */
	public function sellmarket(Request $request) {		
		$validator = Validator::make($request->all(), [
			'sellpair' => 'required|numeric',
			'sellmarketvolume' => 'required|numeric',
		]);
		if ($validator->fails()) { 
			$data['status'] = 'fail';
			$data['msg'] = "<div id='sellmarketwarning' class='alerttext text-danger text-center'>".__('message.Allfieldsrequired')."</div>";
			return $data;           
		}
		$pair = (int)$request->sellpair;
		$sellmarketvolume = (float)$request->sellmarketvolume;
		if ($pair != "" && $sellmarketvolume > 0) {
			$pair = Tradepair::where(['id' => $pair,'active' => 1])->first();
			if($pair){
				$commission = bcdiv(sprintf('%.10f', $pair->sell_trade), 100, 8);
				// get inputs
				$volume = $sellmarketvolume;
				$order_type = 2;
				$user = Auth::user()->id;
				if($pair->type == 1 || $pair->type == 2){
					$coinone_decimal = $pair->coinone_decimal;
					$cointwo_decimal = $pair->cointwo_decimal;
					if($pair->min_sell_amount > 0 && $volume < $pair->min_sell_amount)
					{
						$data['status'] = 'fail';
						$data['msg'] = "<div id='sellmarketwarning' class='alerttext text-danger text-center'>Minimum sell amount ".number_format($pair->min_sell_amount, 8, '.', '')."</div>";
						return $data;
					}

					if($pair->max_amount > 0 && $volume > $pair->max_amount)
					{
						$data['status'] = 'fail';
						$data['msg'] = "<div id='sellmarketwarning' class='alerttext text-danger text-center'>Maximum sell amount ".number_format($pair->max_amount, 8, '.', '')."</div>";
						return $data;
					}
					$balance = 0;
					$wallet = Wallet::where([['uid', '=', $user],['currency', '=', $pair->coinone],])->first();
					if ($wallet) {
						$balance = $wallet->balance;
					}
					if($balance < $volume)
					{
						$data['status'] = 'fail';
						$data['msg'] = "<div id='sellmarketwarning' class='alerttext text-danger text-center'>Total value must be at least ".number_format($volume, 8, '.', '')." ".$pair->coinone."</div>";
						return $data;
					}
					DB::beginTransaction();
					try
					{						
						//admin fees
						$fees = bcmul(sprintf('%.10f', $volume), sprintf('%.10f', $commission), 8);
						$get_total_val = bcadd(sprintf('%.10f', $volume), sprintf('%.10f', $fees), 8);
							
						if($get_total_val > $balance){
							$message = "Your current balance is ".$balance." ".$pair_details->coinone." (Your trade volume is ".$get_total_val.")";
							$data['status'] = 'fail';
							$data['msg'] = "<div id='sellmarketwarning' class='alerttext text-danger text-center'>$message</div>";
							return $data;
						}
						$getpair = strtoupper($pair_details->coinone.$pair_details->cointwo);
						//get order book
						$api = new BinanceClass;
						$liqpair = $pair->coinone.$pair->cointwo;
						$orderbook = $api->place_market_sellorder($liqpair,$volume);
						//$orderbook = $this->liquidityNewPlaceMarketOrder($quoteOrder, $volume, $getpair, "BUY", $cointwo_decimal, $coinone_decimal);
						if($orderbook['status'] == 'success')
						{
							$obalance = $balance;
							$result = $orderbook['message'];
							
							$trade = new Trade;
							$trade->uid = $user;
							$trade->trade_type = "Sell";
							$trade->pair = $pair->id;
							$trade->ouid = $result['clientOrderId'];
							$trade->order_id = $result['orderId'];
							$trade->order_type = 2;
							$trade->volume = $volume;
							$trade->value = $quoteOrder;
							$trade->fees = $fees;
							$trade->remaining = 0;
							$trade->status = 0;
							$trade->leverage = 1;
							$trade->spend = 0;
							$trade->post_ty = 'web';
							$trade->balance = $obalance;
							$trade->status_text = $result['status'];
							$trade->is_type = 1;
							$trade->save();
								
							$trade_id = $trade->id;
							if(isset($result['fills']))
							{
								//get average price
								$get_avg_price = $total_value = 0;
								for ($j = 0; $j < count($result['fills']); $j++)
								{ 
									$get_data = $result['fills'][$j];
									$get_avg_price+=$get_data['price'];
								}

								if(count($result['fills']) > 0 && $get_avg_price > 0)
								{
									$get_avg_price = $get_avg_price / count($result['fills']);
									$total_value = ncMul($get_avg_price, $result['executedQty'], $cointwo_decimal);
								}
								$fees = bcmul(sprintf('%.10f', $result['executedQty']), sprintf('%.10f', $commission), 8);
								$totalprice = bcadd(sprintf('%.10f', $result['executedQty']), sprintf('%.10f', $fees), 8);
						
								Trade::where('id', $trade_id)->update([
									'price' => $get_avg_price,
									'filled' => $result['executedQty'],
									'value' => $total_value,
									'fees' => $fees
								]);
								$balance = bcsub(sprintf('%.10f', $balance), sprintf('%.10f', $totalprice), 8);
								$wallet = Wallet::where([
									['uid', '=', $user],
									['currency', '=', $pair->coinone],
								])->update(['balance' => $balance,'updated_at' => date('Y-m-d H:i:s',time())]);

								//Before trade start
								$tCurrency = $pair->coinone.'/'.$pair->cointwo;
								$remark ='Sell Post liquidty Market Trade '.$tCurrency;
								$this->AllcoinUpdateBalanceTrack($user,$pair->coinone,0,$result['executedQty'],$balance,$obalance,'selltrade',$remark,$trade_id);
								//$this->creditAmount($user, $pair->cointwo, $total_value,$remark,$trade_id);
								Wallet::creditAmount($user, $pair->cointwo, $total_value, 8,'selltrade',$remark,$trade_id);
								$adminbalanceupdate = $this->adminBalanceUpdate($pair->coinone, $fees,'sell');
								$pairTr =  $pair->coinone.'/'.$pair->cointwo;
								//AdminTransactions::CreateTransaction($trade->uid, 'sell', $pair->coinone,0,$get_avg_price,$trade->volume,$total_value,$fees,$commission,$pairTr,'Market',$trade->id);
								
								$data['status'] = 'sellmarketsuccess';
								$data['balance'] = $balance;
								$data['msg'] = "<div id='sellmarketsuccess' class='alerttext text-success text-center'>".__('message.PostTradeSuccessfully')."</div>";
								$balanceOne = Wallet::getBalance($user, $pair->coinone);
								$balanceTwo = Wallet::getBalance($user, $pair->cointwo);
								$data['balanceOne'] = $balanceOne;
								$data['balanceTwo'] = $balanceTwo;

								DB::commit();
								return $data;
							}
						} else {
							$message = "Something went wrong, try again later!";
							if(isset($orderbook['message']))
							{
								$message = $orderbook['message'];
							}
							//rollback here
							DB::rollBack();

							$data['status'] = 'fail';
							$data['msg'] = "<div id='sellmarketwarning' class='alerttext text-danger text-center'>$message</div>";
							return $data;
						}
					}
					catch(Exception $e)
					{
						//rollback here
						DB::rollBack();
						$data['status'] = 'fail';
						$data['msg'] = "<div id='sellmarketwarning' class='alerttext text-danger text-center'>Something went wrong, try again later!</div>";
						return $data;
					}
					
				}else {
					DB::beginTransaction();
					try
					{
						$ogetliveprice=$this->TradePrice($pair->id);
						$Liveprice=$ogetliveprice['Last']; 
						//select available trade
						$result = Trade::where([
							['trade_type', '=', 'Buy'],
							['pair', '=', $pair->id],
							['status', '=', 0],
						])->where(function ($tradeprice) use ($Liveprice) {  
							$tradeprice->where(function($tradeprice) {
								$tradeprice->whereIn('order_type', ['1','2'] );      
							})->orWhere([
								['stoplimit', '!=', null],
								['stoplimit', '<=', $Liveprice], 
								['order_type', '=', '3'] 
							])->orWhere([
								['stoplimit', '!=', null],
								['stoplimit', '<=', $Liveprice],        
								['order_type', '=', '4'] 
							]); 
						})->orderBy('price', 'desc')->get();
						
						$min_trade_volume = $pair->min_sell_amount;
						if ($volume > 0 && $min_trade_volume <= $volume) {
							if ($result->count() > 0) {
								if ($result->sum('remaining') >= $volume) {

									//wallet balance
									$balance = 0;
									$wallet = Wallet::where([
										['uid', '=', $user],
										['currency', '=', $pair->coinone],
									])->first();
									if ($wallet) {
										$balance = $wallet->balance;
									}
									//admin commission
									$fees = bcmul(sprintf('%.10f', $volume), sprintf('%.10f', $commission), 8);
									$totalvolume = bcadd(sprintf('%.10f', $fees), sprintf('%.10f', $volume), 8);

									if ($balance >= $totalvolume) {
										// escrow balance
									$obalance = Wallet::where([['uid', '=', $user],['currency', '=', $pair->coinone]])->value('balance');
									if($obalance <= 0){
										$data['status'] = 'fail';
										$data['msg'] = "<div id='sellmarketwarning'class='alerttext text-danger text-center'>'".__('message.Insufficient')." " . $pair->coinone . " wallet!'</div>";
										return $data;
									}
										$require_volume = $volume;
										$totalprice = 0;
										foreach ($result as $res) {
											if ($res->remaining >= $require_volume) {
												$total = bcmul(sprintf('%.10f', $res->price), sprintf('%.10f', $require_volume), 8);
												$totalprice += $total;
												break;
											} else {
												$total = bcmul(sprintf('%.10f', $res->price), sprintf('%.10f', $res->remaining), 8);
												$totalprice += $total;
												$require_volume = bcsub(sprintf('%.10f', $require_volume), sprintf('%.10f', $res->remaining), 8);
											}
										}
										$orderId = TransactionString(20);
										$clientOrderId = $user;
										$status = 'PENDING';
										$is_type = 0;
										
										$trade = new Trade;
										$trade->uid = $user;
										$trade->trade_type = "Sell";
										$trade->pair = $pair->id;
										$trade->ouid = $clientOrderId;
										$trade->order_id = $orderId;
										$trade->order_type = 2;
										$trade->volume = $volume;
										$trade->value = $totalprice;
										$trade->fees = $fees;
										$trade->remaining = $trade->volume;
										$trade->status = 0;
										$trade->leverage = 1;
										$trade->spend = 0;
										$trade->post_ty = 'web';
										$trade->balance = $obalance;
										$trade->status_text = $status;
										$trade->is_type = $is_type;
										$trade->created_at = date('Y-m-d H:i:s', time());
										$trade->updated_at = date('Y-m-d H:i:s', time());
										$trade->save();
										$trade_id = $trade->id;

										// escrow balance
										$balance = bcsub(sprintf('%.10f', $balance), sprintf('%.10f', $totalvolume), 8);
										$escrow = bcadd(sprintf('%.10f', $wallet->escrow_balance), sprintf('%.10f', $totalvolume), 8);
										$wallet = Wallet::where([
											['uid', '=', $user],
											['currency', '=', $pair->coinone],
										])->update(['balance' => $balance, 'escrow_balance' => $escrow]);
										//Before trade start
									$tCurrency = $pair->coinone.'/'.$pair->cointwo;
									$this->AllcoinUpdateBalanceTrack($user,$pair->coinone,0,$totalvolume,$balance,$obalance,'selltrade','Sell Post Market Trade '.$tCurrency,$trade_id);
										$remaining = $trade->volume;
										foreach ($result as $data) {
											$avil = Trade::checkStatus($data->id);
											if($avil){
												//trade calculate
												if ($data->remaining <= $remaining) {
													$remaining = bcsub(sprintf('%.10f', $remaining), sprintf('%.10f', $data->remaining), 8);
													$update = array('remaining' => 0, 'status' => 1,'status_text' => 'COMPLETED','updated_at' => date('Y-m-d H:i:s',time()));
													$complete_volume = $data->remaining;
													//admin balance update
													$adminbalanceupdate = $this->adminBalanceUpdate($pair->cointwo, $data->fees,'buy');
													$this->affliatAmount($data->uid,$pair->cointwo,$data->fees,'Buy',$data->price,$data->volume);
													//debit admin fee
													$buyerbalanceupdate = $this->debitAmount($data->uid, $pair->cointwo, $data->fees);
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
												$complete->pair = $pair->id;
												$complete->type = 'Sell';
												$complete->buytrade_id = $data->id;
												$complete->selltrade_id = $trade_id;
												$complete->price = $price;
												$complete->volume = $complete_volume;
												$complete->value = $total;
												$complete->created_at = date('Y-m-d H:i:s', time());
												$complete->updated_at = date('Y-m-d H:i:s', time());
												$complete->save();
												//end complete trade
												$this->updateTradePrice($pair->id);
												//select pair
												$pairs = array('one' => $pair->coinone, 'two' => $pair->cointwo);
												//Update Balance to buyer
												$buyerbalanceupdate = $this->updateBuyerbalance($data->uid, $complete_volume, $total, $pairs, 'Buy', $data->id,$tCurrency);
												//Updata balance to Seller
												$buyerbalanceupdate = $this->updateSellerbalance($trade->uid, $total, $complete_volume, $pairs, 'Sell', $trade_id,$tCurrency);											
												///Return Buyer balance once completed
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
													//update admin balance
													$adminbalanceupdate = $this->adminBalanceUpdate($pair->coinone, $trade->fees,'sell');												
													$this->affliatAmount($trade->uid,$pair->coinone,$trade->fees,'Sell',$trade->price,$trade->volume);												
													//debit admin fee
													$sellerbalanceupdate = $this->debitAmount($trade->uid, $pair->coinone, $trade->fees);
													$update = array('remaining' => 0, 'status' => 1,'status_text' => 'COMPLETED','updated_at' => date('Y-m-d H:i:s',time()));
													$trade->where('id', $trade_id)->update($update);
													break;
												} else {
													$trade->where('id', $trade_id)->update(['remaining' => $remaining]);
												}
											}
										}
										DB::commit();
										$data['status'] = 'sellmarketsuccess';
										$data['balance'] = $balance;
										$data['msg'] = "<div id='sellmarketsuccess' class='alerttext text-success text-center'>".__('message.PostTradeSuccessfully')."</div>";
										$balanceOne = Wallet::getBalance($user, $pair->coinone);
										$balanceTwo = Wallet::getBalance($user, $pair->cointwo);
										$data['balanceOne'] = $balanceOne;
										$data['balanceTwo'] = $balanceTwo;
										return $data;
									} else {
										DB::rollBack();
										$data['msg'] = "<div id='sellmarketwarning' class='alerttext text-danger text-center'>".__('message.Insufficient')." " . $pair->coinone ." ". __('message.Wallet')." </div>";
										$data['status'] = 'fail';
										return $data;
									}
								} else {
									DB::rollBack();
									$data['msg'] = "<div id='sellmarketwarning' class='alerttext text-danger text-center'>" .__('message.Onlyavailable') .display_format($result->sum('remaining')) . "</div>";
									$data['status'] = 'fail';
									return $data;
								}
							} else {
								DB::rollBack();
								$data['msg'] = "<div id='sellmarketwarning' class='alerttext text-danger text-center'>".__('message.Tradenotavailableyet')."</div>";
								$data['status'] = 'fail';
								return $data;
							}
						} else {
							DB::rollBack();
							$data['msg'] = "<div id='sellmarketwarning' class='alerttext text-danger text-center'>".__('message.Amountmustbe').display_format($min_trade_volume)."</div>";
							$data['status'] = 'fail';
							return $data;
						}
					}
					catch(Exception $e)
					{
						//rollback here
						DB::rollBack();
						$data['status'] = 'fail';
						$data['msg'] = "<div id='sellmarketwarning' class='alerttext text-danger text-center'>Something went wrong, try again later!</div>";
						return $data;
					}
				}
			} else {
				$data['msg'] = "<div id='sellmarketwarning' class='alerttext text-danger text-center'>".__('message.InvalidTradepair')."</div>";
				$data['status'] = 'fail';
			}
		} else {
			$data['msg'] = "<div id='sellmarketwarning' class='alerttext text-danger text-center'>".__('message.Allfieldsrequired')."</div>";
			$data['status'] = 'fail';
		}
		return $data;
	}

	/**
	 * [updateBuyerbalance description]
	 * @param  [int] $uid     [user ID]
	 * @param  [float] $buy     [Buy Price]
	 * @param  [float] $spent   [Amount of spent]
	 * @param  [int] $pair    [Pair ID]
	 * @param  [int] $type    [Order Type]
	 * @param  [id] $tradeid [description]
	 * @return void
	 */
	public function updateBuyerbalance($uid, $buy, $spent, $pair, $type, $tradeid,$tCurrency = null) {
		// tansaction insert
		$transaction = Transaction::insert([
			['uid' => $uid, 'tradeid' => $tradeid, 'reason' => $type . ' ' . $pair['one'], 'price' => $buy, 'currency' => $pair['one'], 'status' => 'credit', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
			['uid' => $uid, 'tradeid' => $tradeid, 'reason' => $type . ' ' . $pair['one'] . ' spent ' . $pair['two'], 'price' => $spent, 'currency' => $pair['two'], 'status' => 'debit', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
		]);

		$remark = 'Completed Buy Trade '.$tCurrency;
		// credit price
		$this->creditAmount($uid, $pair['one'], $buy,$remark,$tradeid);
		// debit price
		$this->debitAmount($uid, $pair['two'], $spent);
		return;
	}

	/**
	 * [updateSellerbalance description]
	 * @param  [int] $uid     [user ID]
	 * @param  [float] $buy     [Buy Price]
	 * @param  [float] $spent   [Amount of spent]
	 * @param  [int] $pair    [Pair ID]
	 * @param  [int] $type    [Order Type]
	 * @param  [id] $tradeid [description]
	 * @return void
	 */
	public function updateSellerbalance($uid, $buy, $spent, $pair, $type, $tradeid,$tCurrency=null) {
		// tansaction insert
		$transaction = Transaction::insert([
			['uid' => $uid, 'tradeid' => $tradeid, 'reason' => $pair['one'] . ' Sold for ' . $pair['two'] . '(' . $buy . ')', 'price' => $buy, 'currency' => $pair['two'], 'status' => 'credit', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
			['uid' => $uid, 'tradeid' => $tradeid, 'reason' => $pair['two'] . '(' . $buy . ') equelant to ' . $pair['one'] . ' Sold', 'price' => $spent, 'currency' => $pair['one'], 'status' => 'debit', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
		]);

		$remark = 'Completed Sell Trade '.$tCurrency;
		// credit price
		$this->creditAmount($uid, $pair['two'], $buy,$remark,$tradeid);
		// debit price
		$this->debitAmount($uid, $pair['one'], $spent);
		return;
	}

	/**
	 * [adminBalanceUpdate description]
	 * @param  [string] $currency [Curreny name]
	 * @param  [float] $price    [price value]
	 * @return void
	 */
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

	/**
	 * [creditAmount description]
	 * @param  [int] $uid      [user ID]
	 * @param  [string] $currency [Currency Name]
	 * @param  [float] $price    [price value]
	 * @return void
	 */
	public function creditAmount($uid, $currency, $price,$remark =null,$insertid) {
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

		$this->AllcoinUpdateBalanceTrack($uid,$currency,$price,0,$walletbalance,$oldbalance,'trade',$remark,$insertid);
	}

	public function affliatAmount($uid,$coin,$amount,$type,$price,$volume){		
		AffliateTransaction::affliate_transaction($uid,$coin,$amount,$type,$price,$volume);
		return true;
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
			Wallet::where([['uid', '=', $uid], ['currency', '=', $currency]])->update(['escrow_balance' => $total, 'updated_at' => date('Y-m-d H:i:s')]);
		} else {
			Wallet::insert(['uid' => $uid, 'currency' => $currency, 'escrow_balance' => $price, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
		}

	}
	/**
	 * [creditStopAmount description]
	 * @param  [int] $uid          [User ID]
	 * @param  [string] $currency     [Currency Name]
	 * @param  [float] $price        [Price Value]
	 * @param  [float] $remain_price [Remainig Price]
	 * @return void
	 */
	public function creditStopAmount($uid, $currency, $price, $remain_price,$insertid) {
		$userbalance = Wallet::where([['uid', '=', $uid], ['currency', '=', $currency]])->first();
		$oldbalance = $userbalance->balance;
		if ($userbalance) {
			$total = bcsub(sprintf('%.10f', $userbalance->escrow_balance), sprintf('%.10f', $remain_price), 8);
			$baltotal = bcadd(sprintf('%.10f', $price), sprintf('%.10f', $userbalance->balance), 8);
			Wallet::where([['uid', '=', $uid], ['currency', '=', $currency]])->update(['balance' => $baltotal, 'escrow_balance' => $total, 'updated_at' => date('Y-m-d H:i:s')]);
			$walletbalance = $baltotal;
			$this->AllcoinUpdateBalanceTrack($uid,$currency,$price,0,$walletbalance,$oldbalance,'trade','Best price complete to remaining balance return',$insertid);
		}		

	}

	public function AllcoinUpdateBalanceTrack($uid,$currency,$creditamount=0,$debitamount=0,$walletbalance=0,$oldbalance=null,$tradetype=null,$remark=null,$insertid)
	{
		if($creditamount > 0 || $debitamount > 0)
		{
			$Models = '\App\Models\OverallTransaction';
			$Models::AddTransaction($uid,$currency,$tradetype,$creditamount,$debitamount,$walletbalance,$oldbalance,$remark,'web',$insertid);
		}
		return true;
	}
	public function getLastPrice1($pair)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.binance.com/api/v3/ticker/24hr?symbol=".$pair);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $headers = array();
        $headers[] = "Accept: application/json, text/plain";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        if (curl_errno($ch)) {
            $result = '';
        } else {
            $result = curl_exec($ch);
        }
        curl_close($ch);
        return json_decode($result);    
    }

    public function liquidityNewPlaceMarketOrder($quoteOrder, $volume, $getpair, $coin_type, $cointwo_decimal, $coinone_decimal)
    {
        if($quoteOrder > 0)
        {
            $quoteOrder = number_format($quoteOrder, $cointwo_decimal, '.', '');
            //--API Call
            $nonce=round(microtime(true) * 1000);
            //--
            $uri='https://api.binance.com/api/v3/order';
            $strsign='symbol='.$getpair.'&side=BUY&type=MARKET&quoteOrderQty='.$quoteOrder.'&recvWindow=60000&timestamp='.$nonce;
            //--
            $sign=hash_hmac('SHA256',$strsign,"");
            $ch = curl_init($uri);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-MBX-APIKEY:d3n1ggWGQeNGJSaKy7VpjK6blFXRBCHylvkmdtQNcRh57S2Bb4JrMmphCf9Firm2'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, 'symbol='.$getpair.'&side=BUY&type=MARKET&quoteOrderQty='.$quoteOrder.'&recvWindow=60000&timestamp='.$nonce.'&signature='.$sign);
            curl_setopt($ch, CURLOPT_URL, $uri);
            $execResult = curl_exec($ch);
            $details = json_decode($execResult, true);

            if(isset($details['code'], $details['msg'])) {
                $data['status'] = 'failed';
                $data['message'] = $details['msg'];
                return $data;
            } else if(isset($details['orderId'])) {
                $data['status'] = 'success';
                $data['message'] = $details;
                return $data;
            } else {
                $data['status'] = 'failed';
                $data['message'] = 'Something went wrong, try again later!';
                return $data;
            }
        }
        else
        {
            //--API Call
            $nonce=round(microtime(true) * 1000);
            //--
            $uri='https://api.binance.com/api/v3/order';
            $strsign='symbol='.$getpair.'&side=BUY&type=MARKET&quantity='.$volume.'&recvWindow=60000&timestamp='.$nonce;
            //--
            $sign=hash_hmac('SHA256',$strsign,"");
            $ch = curl_init($uri);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-MBX-APIKEY:'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, 'symbol='.$getpair.'&side=BUY&type=MARKET&quantity='.$volume.'&recvWindow=60000&timestamp='.$nonce.'&signature='.$sign);
            curl_setopt($ch, CURLOPT_URL, $uri);
            $execResult = curl_exec($ch);
            $details = json_decode($execResult, true);

            if(isset($details['code'], $details['msg'])) {
                $data['status'] = 'failed';
                $data['message'] = $details['msg'];
                return $data;
            } else if(isset($details['orderId'])) {
                $data['status'] = 'success';
                $data['message'] = $details;
                return $data;
            } else {
                $data['status'] = 'failed';
                $data['message'] = 'Something went wrong, try again later!';
                return $data;
            }
        }
    }

}
