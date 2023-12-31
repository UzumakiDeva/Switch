<?php
namespace App\Libraries;
use App\Libraries\Binance;

class BinanceClass
{	
	
	public function __construct()
	{
		$this->apikey 	= \Config::get('app.bnb_API_Key');
		$this->secret 	= \Config::get('app.bnb_Secret');
		$this->api 		= new Binance($this->apikey,$this->secret);
	}
	//Get latest price of all symbols BNBBTC
	public function getprices($symbol=null)
	{
		if(!is_null($symbol)){
			$ticker = $this->api->price($symbol);
		}else{
			$ticker = $this->api->prices();
		}		
		return $ticker;
	}
	
	//Get latest price of all symbols BNBBTC
	public function getTicker($symbol)
	{
		if(!is_null($symbol)){
			$ticker = $this->api->ticker($symbol);
		}else{
			$ticker = $this->api->ticker();
		}		
		return $ticker;
	}
	
	//Get balances for all of your positions, including estimated BTC value
	public function getbalances(){
		$ticker = $this->api->prices(); // Make sure you have an updated ticker object for this to work
		//echo "BTC owned: ".$balances['BTC']['available'].PHP_EOL;
		//echo "ETH owned: ".$balances['ETH']['available'].PHP_EOL;
		$balances = $this->api->balances($ticker);
		return $balances;
	}
	//Get all bid/ask prices
	public function getbidask(){
		$bookPrices = $this->api->bookPrices();
		return $bookPrices;
	}
	//Place a LIMIT order
	public function place_limit_buyorder($pair,$quantity, $price){
		$order = $this->api->buy($pair, $quantity, $price);
		return $order;
	}
	public function place_limit_sellorder($pair,$quantity, $price){
		$order = $this->api->sell($pair, $quantity, $price);
		return $order;
	}
	//Place a MARKET order
	public function place_market_buyorder($pair,$quantity){
		$order = $this->api->marketBuy($pair, $quantity);
		return $order;
	}
	public function place_market_sellorder($pair,$quantity){
		$order = $this->api->marketSell($pair, $quantity);
		return $order;
	}
	//Place a STOP LOSS order
	public function place_stop_buyorder($pair,$quantity,$price,$stopPrice){
		// When the stop is reached, a stop order becomes a market order
		$type = "STOP_LOSS"; // Set the type STOP_LOSS (market) or STOP_LOSS_LIMIT, and TAKE_PROFIT (market) or TAKE_PROFIT_LIMIT
		$order = $this->api->buy($pair, $quantity, $price, $type, ["stopPrice"=>$stopPrice]);
		return $order;
	}
	public function place_stop_sellorder($pair,$quantity,$price,$stopPrice){
		// When the stop is reached, a stop order becomes a market order
		$type = "STOP_LOSS"; // Set the type STOP_LOSS (market) or STOP_LOSS_LIMIT, and TAKE_PROFIT (market) or TAKE_PROFIT_LIMIT
		$order = $this->api->sell($pair, $quantity, $price, $type, ["stopPrice"=>$stopPrice]);
		return $order;
	}
	//Place an ICEBERG order
	public function place_iceberg_buyorder($pair,$quantity,$price,$icebergQty){
		// Iceberg orders are intended to conceal the true order quantity.
		$type = "LIMIT"; // LIMIT, STOP_LOSS_LIMIT, and TAKE_PROFIT_LIMIT
		$order = $this->api->buy($pair, $quantity, $price, $type, ["icebergQty"=>$icebergQty]);
		return $order;
	}
	public function place_iceberg_sellorder($pair,$quantity,$price,$icebergQty){
		// Iceberg orders are intended to conceal the true order quantity.
		$type = "LIMIT"; // LIMIT, STOP_LOSS_LIMIT, and TAKE_PROFIT_LIMIT
		$order = $this->api->sell($pair, $quantity, $price, $type, ["icebergQty"=>$icebergQty]);
		return $order;
	}
	//Getting 24hr ticker price change statistics for a symbol ETHBTC
	public function hr_ticker_price($pair){
		$prevDay = $this->api->prevDay($pair);
		return $prevDay;
	}
	//Complete Account Trade History Pair ETHBTC
	public function trade_histroy($pair){
		$history = $this->api->history($pair);
		return $history;
	}
	//Get Market Depth pair ETHBTC
	public function market_depth($pair){
		$depth = $this->api->depth($pair);
		return $depth;
	}
	//Get Open Orders
	public function open_orders($pair){
		$openorders = $this->api->openOrders($pair);
		return $openorders;
	}
	//Get Order Status pair ETHBTC
	public function order_status($pair,$orderid){
		$orderstatus = $this->api->orderStatus($pair, $orderid);
		return $orderstatus;
	}
	//Cancel an Order pair ETHBTC
	public function cancel_order($pair,$orderid){
		$response = $this->api->cancel($pair, $orderid);
		return $response;

	}
	//Market History / Aggregate Trades pair ETHBTC
	public function market_history($pair){
		$trades = $this->api->aggTrades($pair);
		return $trades;
	}
	//Get all account orders; active, canceled, or filled. pair ETHBTC
	public function all_account_order($pair){
		$orders = $this->api->orders($pair);
		return $orders;
	}
	//Get Kline/candlestick data for a symbol pair ETHBTC
	public function candlestick_data($pair,$min='1d'){
		//Periods: 1m,3m,5m,15m,30m,1h,2h,4h,6h,8h,12h,1d,3d,1w,1M
		$ticks = $this->api->candlesticks($pair, $min);
		return $ticks;
	}
	//Withdraw Asset BTC
	public function withdraw_coin($asset, $address, $amount){
		$response = $this->api->withdraw($asset, $address, $amount);
		return $response;
	}
	//Withdraw with addressTag
	public function withdraw_addresstag($asset, $address, $amount, $addressTag){
		//Required for coins like XMR, XRP, etc.
		$response = $this->api->withdraw($asset, $address, $amount, $addressTag);
		return $response;
	}
	//Get All Withdraw History
	public function all_withdraw_histroy(){
		$withdrawHistory = $this->api->withdrawHistory();
		return $withdrawHistory;
	}
	//Get Withdraw History for a specific asset BTC
	public function withdraw_histroy_asset($asset){
		$withdrawHistory = $this->api->withdrawHistory($asset);
		return $withdrawHistory;
	}
	//Get Deposit Address Coin BTC
	public function get_deposit_address($coin){
		$depositAddress = $this->api->depositAddress($coin);
		return $depositAddress;
	}
	//Get All Deposit History
	public function all_deposit_histroy(){
		$depositHistory = $this->api->depositHistory();
		return $depositHistory;
	}
	//Get All Deposit History for a specific asset BTC
	public function deposit_histroy_asset($asset){
		$depositHistory = $this->api->depositHistory($asset);
		return $depositHistory;
	}

}