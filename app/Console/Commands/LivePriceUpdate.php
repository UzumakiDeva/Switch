<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\TradePrice;
use App\TradePairLivePrice;
use App\Models\Tradepair;
use App\Traits\TradeData;

class LivePriceUpdate extends Command
{
    use TradeData;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:liveprice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Live price for all trade pair';

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
        $exchangeTicker = json_decode(crul("https://api.binance.com/api/v3/ticker/24hr"));
        if(count($exchangeTicker) > 0){
            foreach($exchangeTicker as $dataget ){
                $pairsymbol = $dataget->symbol;
                $trade =  Tradepair::where('symbol',$pairsymbol)->first();
                if(is_object($trade)){
                    $trade->open = $dataget->openPrice;
                    $trade->high = $dataget->highPrice;
                    $trade->low = $dataget->lowPrice;
					if($trade->coinone != 'SET'){
						$trade->close = $dataget->lastPrice;
					}
                    $trade->hrchange  = display_format($dataget->priceChangePercent,2);
                    $trade->hrvolume  = $dataget->volume;
                    $trade->updated_at  = date('Y-m-d H:i:s',time());
                    $trade->save();
                }
            }
        }        
        
        $exchangeInfo = json_decode(crul("https://api.binance.com/api/v3/exchangeInfo"));
        $symbols = $exchangeInfo->symbols;
        foreach($symbols as $symbol) { 
            $pairsymbol = $symbol->symbol;
            $trades = Tradepair::where('symbol',$pairsymbol)->get(); 
            if(count($trades) > 0){
                foreach($trades as $sTrade){
                    $trade = Tradepair::where('id',$sTrade->id)->first();
                    $filters = $symbol->filters;
                    $cprice = 1;
                    if(is_object($trade)){                
                        foreach($filters as $filter){
                            if($filter->filterType == 'PRICE_FILTER'){
                                $trade->minprice = ncMul($filter->minPrice,$cprice);
                                $trade->maxprice = ncMul($filter->maxPrice,$cprice);
                                $trade->ticksize = $filter->tickSize;
                            }
                            if($filter->filterType == 'LOT_SIZE'){
                                $trade->minqty = $filter->minQty;
                                $trade->maxqty = $filter->maxQty;
                                $trade->stepsize = $filter->stepSize;
                            }
                            if($filter->filterType == 'MIN_NOTIONAL'){
                                $trade->minnotional = ncMul($filter->minNotional,$cprice);
                            }
                        }
                        $trade->save();
                    }
                }
            }
        }
        
        $this->info('Trade Price update successfully');
    }
}
