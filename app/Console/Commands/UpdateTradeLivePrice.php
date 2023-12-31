<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\TradePrice;
use App\TradePairLivePrice;
use App\Models\Tradepair;
use App\Traits\TradeData;

class UpdateTradeLivePrice extends Command
{
    use TradeData;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:tradeprice';

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
        
        $trades = Tradepair::orderBy('orderlist','Asc')->get();
        foreach ($trades as $key => $trade) {
            $tid = $trade->id;
            $cprice = $trade->convert_price;
            $coinone = $trade->coinone;
            $cointwo = $trade->cointwo;
            
            $data = Tradepair::where('id',$trade->id)->first();
            $dataget =  $this->getMarketSummary($trade->id);
            /* if($trade->type == 2){
                $data->symbol = strtoupper($trade->coinone.'USDT');
            } else {
                $data->symbol = strtoupper($trade->coinone.$trade->cointwo);
            } */
            $data->live_price  = ncMul($cprice,$dataget['Last']);
            $data->hrchange  = display_format($dataget['Exchange'],2);
            $data->hrvolume  = $dataget['Volume'];
            $data->updated_at  = date('Y-m-d H:i:s',time());
            $data->save();

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
                    $cprice = $trade->convert_price;
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
