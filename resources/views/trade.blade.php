@php
    $title = $coinone . $cointwo . ' | ' . $coinone . ' Buy |' . $coinone . ' Sell';
    $atitle = 'trade';
    $cpair = $selectPair->symbol;
@endphp
@include('layouts.header')
<style>
    input[type="text"]::placeholder {
        /* Firefox, Chrome, Opera */
        text-align: left;
    }

    input[type="number"]::placeholder {
        /* Firefox, Chrome, Opera */
        text-align: left;
    }

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type="text"] {
        text-align: right;
    }

    input[type="number"] {
        text-align: right;
    }
</style>
<div class="pagecontent gridpagecontent tradepage chartactive">
    @include('layouts.headermenu')
    </section>
    <article class="gridparentbox tradecontentbox">
        <!--new! placeholder-->
        <div class="marketlistsidemenu">
            <ul class="marketlistt">
                <li>
                    <div id="sidebarmarketlistCollapse"><i class="fa fa-arrow-left"></i></div>
                    <div class="text-left">{{ $coinone }}/{{ $cointwo }}</div>
                </li>
            </ul>
        </div>
        <!--new!-->
        <div class="container sitecontainer">
            <!--new!-->
            <div class="buyselltabbg buyselltopbox">
                <ul class="nav nav-tabs orderfrmtab buyselltab" role="tablist">
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#buy">Buy</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#sell">Sell</a></li>
                </ul>
            </div>
            <!--new!-->
            <div class="chart-block">
                <div class="livepricelist">
                    <div class="livepricemobile">
                        <ul class="livepricenavbg">
                            <li>
                                <a href="#" class="livepricet coinlisttable"> <img
                                        src="{{ url('images/color/' . $selectPair->coinonedetails['image']) }}"
                                        class="coinlisticon" />
                                    <div>{{ $coinone }}/{{ $cointwo }}</div>
                                </a>
                            </li>
                            <ul class="navbar-nav">
                                <li class="dropdown usermenu"> <a href="#" class="nav-link dropdown-bs-toggle"
                                        role="button" data-bs-toggle="dropdown">Select market
                                        <span class="d-t"><i class="fa fa-angle-down" aria-hidden="true"></i></span>
                                    </a>
                                    <div class="dropdown-menu">
                                        @forelse($trades as $trade)
                                            <a class="dropdown-item"
                                                href="{{ url('trades/' . $trade->coinone . '_' . $trade->cointwo) }}"><img
                                                    src="{{ url('images/color/' . $trade->coinonedetails['image']) }}"
                                                    class="coinlisticon">{{ $trade->coinone . '/' . $trade->cointwo }}</a>
                                        @empty
                                            <a class="dropdown-item" href="#"><img
                                                    src="{{ url('images/color/btc.svg') }}"
                                                    class="coinlisticon">BTC/ECPAY</a>
                                        @endforelse
                                    </div>
                                </li>
                            </ul>
                            <li><a class="livepricet">Last price<br>
                                    @if ($selectPair->coinone == 'SET')
                                        <span
                                            class="@if ($selectPair->hrchange >= 0) t-green @else t-red @endif last_price_{{ $cpair }}SET"
                                            id="lastprice">{{ display_format($selectPair->close, $selectPair->cointwo_decimal) }}</span>
                                    @else
                                        <span
                                            class="@if ($selectPair->hrchange >= 0) t-green @else t-red @endif last_price_{{ $cpair }}"
                                            id="lastprice">{{ display_format($selectPair->close, $selectPair->cointwo_decimal) }}</span>
                                    @endif
                                </a></li>
                            <!-- <li><a class="livepricet">Open price<br><span class="@if ($selectPair->hrchange >= 0) t-green @else t-red @endif open_{{ $cpair }}" id="opneprice">{{ display_format($selectPair->open, $selectPair->cointwo_decimal) }}</span></a></li> -->
                            <li><a class="livepricet">High price<br><span
                                        class="@if ($selectPair->hrchange >= 0) t-green @else t-red @endif high_{{ $cpair }}"
                                        id="opneprice">{{ display_format($selectPair->high, $selectPair->cointwo_decimal) }}</span></a>
                            </li>
                            <li><a class="livepricet">Low Price<br><span
                                        class="@if ($selectPair->hrchange >= 0) t-green @else t-red @endif low_{{ $cpair }}">{{ display_format($selectPair->low, $selectPair->cointwo_decimal) }}</span></a>
                            </li>
                            <li><a class="livepricet">24H change<br><span
                                        class="@if ($selectPair->hrchange >= 0) t-green @else t-red @endif price_change_{{ $cpair }}"
                                        id="24hchng">{{ display_format($selectPair->hrchange, 2) }}%</span></a></li>
                            <li><a class="livepricet">24H Volume<br><span
                                        class="@if ($selectPair->hrchange >= 0) t-green @else t-red @endif quote_{{ $cpair }}"
                                        id="24hvol">{{ display_format($selectPair->hrvolume, 2) }}</span></a></li>
                        </ul>
                    </div>
                </div>
            </div>


            <div class="mobilegrid tabs-nav">
                <li class="orderlist"><a href="#tab-1">Chart</a></li>
                <li class="orderlist"><a href="#tab-2">Open Orders</a></li>
                <li class="orderlist"><a href="#tab-3">Trade History</a></li>
            </div>
            <div class="marketlist">
                <h2 class="heading-box">Markets</h2>
                <div id="closemarketicon" class="closeiconlist"><i class="fa fa-arrow-right"></i></div>
                <div class="table-responsive" data-simplebar>
                    <table class="table sitetable">
                        <thead>
                            <tr>
                                <th>Pair</th>
                                <th>Price</th>
                                <th>24h change</th>
                                <th>24 volume</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($trades as $trade)
                                <tr>
                                    <td>
                                        <a class="t-white"
                                            href="{{ url('trades/' . $trade->coinone . '_' . $trade->cointwo) }}">
                                            <img src="{{ url('images/color/' . $trade->coinonedetails['image']) }}"
                                                class="coinlisticon">{{ $trade->coinone . '/' . $trade->cointwo }}
                                        </a>
                                    </td>
                                    @if ($trade->coinone == 'SET')
                                        <td class="last_price_{{ $trade->coinone . $trade->cointwo }}SET">
                                            {{ $trade->close }}</td>
                                    @else
                                        <td class="last_price_{{ $trade->coinone . $trade->cointwo }}">
                                            {{ $trade->close }}</td>
                                    @endif
                                    <td>
                                        <span
                                            class="@if ($trade->hrchange >= 0) t-green @else t-red @endif price_change_{{ $trade->coinone . $trade->cointwo }}">{{ $trade->hrchange }}%
                                            <i class="fa fa-arrow-up"></i></span>
                                    </td>
                                    <td class="quote_{{ $trade->coinone . $trade->cointwo }}">{{ $trade->hrvolume }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td><img src="{{ url('images/color/btc.svg') }}"
                                            class="coinlisticon">{{ $coinone }}/{{ $cointwo }}</td>
                                    <td>256.36259548</td>
                                    <td><span class="t-green">2.20% <i class="fa fa-arrow-up"></i></span></td>
                                    <td>6.36259548</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>

            <div class="grid-box">
                <div class="chart">
                    <h2 class="heading-box">Chart</h2>
                    <div class="tabrightbox">
                        <ul class="nav nav-tabs tabbanner charttabbg" role="tablist">
                            <li class="nav-item"> <a class="nav-link active" data-bs-toggle="tab"
                                    data-bs-target="#tradechart" href="#tradechart">
                                    Tradingview
                                </a> </li>
                            <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab"
                                    data-bs-target="#marketdepth" href="#marketdepth">
                                    MarketDepth
                                </a> </li>
                        </ul>
                    </div>
                    <div class="tab-content contentbox">
                        <div id="tradechart" class="tab-pane fade in show active tradechartlist">
                            <div class="tradingview-widget-container">
                                <div id="tradingview_49396"></div>

                            </div>
                        </div>
                        <div id="marketdepth" class="tab-pane fade in marketchart">
                            <div id="chartdiv" class=""></div>
                            <script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
                            <script src="https://www.amcharts.com/lib/3/serial.js"></script>
                            <script src="https://www.amcharts.com/lib/3/plugins/dataloader/dataloader.min.js"></script>
                            <script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
                            <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css"
                                type="text/css" media="all" />
                            <script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
                        </div>
                    </div>
                </div>
                <div class="orderbook buysellshow">
                    <h2 class="heading-box">Orderbook
                        <div class="tabrightbox">
                            <ul class="nav nav-tabs tabbanner charttabbg orderchangebg">
                                <li class="nav-item"><a class="nav-link" id="buysellshow"><img
                                            src="{{ url('images/chart1.svg') }}"></a></li>
                                <li class="nav-item"><a class="nav-link" id="buyshow"><img
                                            src="{{ url('images/chart2.svg') }}"></a></li>
                                <li class="nav-item"><a class="nav-link" id="sellshow"><img
                                            src="{{ url('images/chart3.svg') }}"></a></li>
                            </ul>
                        </div>
                    </h2>
                    <div class="orderbookscroll">
                        <div class="table-responsive sitescroll" data-simplebar>
                            <table class="table sitetable">
                                <thead>
                                    <tr>
                                        <th>Price({{ $cointwo }})</th>
                                        <th class="text-right">Amount({{ $coinone }})</th>
                                        <th class="text-right">Total({{ $cointwo }})</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="sellboxorder" id="sellorderbox">
                            <div class="table-responsive sitescroll" id="sellpagescroll">
                                <div class="sellboxtablebg">
                                    <table class="table sitetable">
                                        <thead>
                                            <tr>
                                                <th>Price({{ $cointwo }})</th>
                                                <th class="text-right">Amount({{ $coinone }})</th>
                                                <th class="text-right">Total({{ $cointwo }})</th>
                                            </tr>
                                        </thead>
                                        <tbody class="sellOrderBook" id="sellOrderBook">
                                            <tr>
                                                <td colspan="3">No Record Found!</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="livepricebox" id="livepricebox">
                            <table class="table sitetable">
                                <thead>
                                    <tr>
                                        @if ($selectPair->coinone == 'SET')
                                            <th><span
                                                    class="@if ($trade->hrchange >= 0) t-green @else t-red @endif last_price_{{ $cpair }}SET"
                                                    id="greenlastprice">{{ display_format($selectPair->close, $selectPair->cointwo_decimal) }}</span>
                                            </th>
                                        @else
                                            <th><span
                                                    class="@if ($trade->hrchange >= 0) t-green @else t-red @endif last_price_{{ $cpair }}"
                                                    id="greenlastprice">{{ display_format($selectPair->close, $selectPair->cointwo_decimal) }}</span>
                                            </th>
                                        @endif
                                        <th class="text-right"><span class="price_change_{{ $cpair }}"
                                                id="greenhrchange">{{ display_format($selectPair->hrchange, 2) }}%
                                            </span><i class="fa fa-signal"></i></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="buyboxorder" id="buyorderbox">
                            <div class="table-responsive sitescroll" data-simplebar>
                                <table class="table sitetable">
                                    <thead>
                                        <tr>
                                            <th>Price({{ $cointwo }})</th>
                                            <th class="text-right">Amount({{ $coinone }})</th>
                                            <th class="text-right">Total({{ $cointwo }})</th>
                                        </tr>
                                    </thead>
                                    <tbody id="buyOrderBook">
                                        <td colspan="3">No Record Found!</td>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="orderform">
                    <ul class="ruleslist">
                        <li><a><i class="fa fa-info-circle" aria-hidden="true"></i> Trading Rules
                                <div class="none rulesnotes">
                                    <table class="table sitetable">
                                        <tbody>
                                            <tr>
                                                <td>Minimum Buy Trade Amount : </td>
                                                <td>{{ $selectPair->min_buy_amount }} {{ $coinone }}</td>
                                            </tr>
                                            <tr>
                                                <td>Min Buy Price Movement : </td>
                                                <td>{{ $selectPair->min_buy_price }} {{ $cointwo }}</td>
                                            </tr>
                                            <tr>
                                                <td>Minimum Sell Trade Amount : </td>
                                                <td>{{ $selectPair->min_sell_amount }} {{ $coinone }}</td>
                                            </tr>
                                            <tr>
                                                <td>Minimum sell Price : </td>
                                                <td>{{ $selectPair->min_sell_price }} {{ $cointwo }}</td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </a> </li>
                    </ul>
                    <div class="orderformbg">
                        <h2 class="heading-box">Orderform</h2>
                        <!--new!-->
                        <div class="buyselltabbg">
                            <ul class="nav nav-tabs orderfrmtab buyselltab" role="tablist">
                                <li class="nav-item"><a class="nav-link active" id="buytab" role="tab"
                                        data-bs-toggle="tab" href="#buy" data-bs-target="#buy">Buy</a></li>
                                <li class="nav-item"><a class="nav-link" id="selltab" role="tab"
                                        data-bs-toggle="tab" href="#sell" data-bs-target="#sell">Sell</a></li>
                            </ul>
                        </div>
                        <!--new!-->
                        <div class="clostbuytab"> <a href="#"><i class="fa fa-times"></i></a> </div>
                        <ul class="nav nav-tabs orderfrmtab limitabbg" role="tablist">
                            <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#limit"
                                    data-bs-target="#limit">Limit</a></li>
                            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#market"
                                    data-bs-target="#market">Market</a></li>
                        </ul>
                    </div>
                    <div class="tab-content">

                        <div id="limit" class="tab-pane fade in show active">
                            <div class="orderformbg1">
                                <div class="buyorderform">

                                    <form class="siteformbg" id="buylimit">
                                        @csrf
                                        <div id="buystatus" style="display:none"></div>
                                        <div id="buylimitmsg" class="text-center" style="color: red;">
                                        </div>
                                        <div class="form-group"><span> Available Balance: <span
                                                    class="balanceTwo">{{ $cointwobalance }}</span>
                                                {{ $cointwo }}</span></div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend"> <span
                                                        class="input-group-text">Price</span> </div>
                                                <input type="hidden" placeholder="" class="input-xlarge"
                                                    id="buypair" name="buypair" value="{{ $selectPair->id }}">
                                                <input id="buyprice" type="number" placeholder=""
                                                    onkeypress="return AvoidSpace(event)" class="form-control"
                                                    name="buyprice" step="0.000001" min="0" max="100000000"
                                                    value="{{ $selectPair->close }}">
                                                <div class="input-group-append"> <span
                                                        class="input-group-text">{{ $cointwo }}</span> </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend"> <span
                                                        class="input-group-text">Amount</span> </div>
                                                <input id="buyvolume" type="number"
                                                    onkeypress="return AvoidSpace(event)" class="form-control"
                                                    name="buyvolume" step="0.000001" min="0" max="100000000"
                                                    placeholder="">
                                                <div class="input-group-append"> <span
                                                        class="input-group-text">{{ $coinone }}</span> </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend"> <span
                                                        class="input-group-text">Total</span> </div>
                                                <input type="text" class="form-control" placeholder=""
                                                    id="buytotal">
                                                <div class="input-group-append"> <span
                                                        class="input-group-text">{{ $cointwo }}</span> </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="control-value-box stoplimtboxt">
                                                <div>limitcount</div>
                                                <div>
                                                    <div class="row link-div">
                                                        <div class="col" onclick="calculateBuylimitAmount('25')">
                                                            25%</div>
                                                        <div class="col" onclick="calculateBuylimitAmount('50')">
                                                            50%</div>
                                                        <div class="col" onclick="calculateBuylimitAmount('75')">
                                                            75%</div>
                                                        <div class="col" onclick="calculateBuylimitAmount('100')">
                                                            100%</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group fee-formbox">
                                            <div class="input-group"> <span class="input-group-prepend">
                                                    <div class="commision"><span class="feeamt">Leverage comission
                                                            :</span> <span
                                                            class="feeamt">{{ $selectPair->buy_trade }}%</span></div>
                                                    <div class="commision"><span class="feeamt">Fee</span> <span
                                                            class="feeamt" id="buyfees">0.0000000
                                                            {{ $coinone }}</span></div>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="ratiobtn">
                                            <div class="text-center">
                                                <input type="button" id="buylimit_order"
                                                    class="btn btn-block sitebtn green-btn"
                                                    value="Buy ({{ $coinone }})" />
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="sellorderform">
                                    <form id="sellimit" class="siteformbg">
                                        @csrf
                                        <div id="sellstatus" style="display:none"></div>
                                        <div id="selllimitmsg" class="text-center" style="color: red;"></div>
                                        <div class="form-group"><span> Available Balance: <span class="balanceOne">
                                                    {{ $coinonebalance }} </span>{{ $coinone }}</span></div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="hidden" placeholder="" class="input-xlarge"
                                                    id="sellpair" name="sellpair" value="{{ $selectPair->id }}">
                                                <div class="input-group-prepend"> <span
                                                        class="input-group-text">Price</span> </div>
                                                <input type="number" placeholder="Price"
                                                    onkeypress="return AvoidSpace(event)" class="form-control"
                                                    id="sellprice" name="sellprice" required="required"
                                                    step="0.0001" min="0" max="1000000"
                                                    value="{{ $selectPair->close }}">
                                                <div class="input-group-append"> <span
                                                        class="input-group-text">{{ $cointwo }}</span> </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend"> <span
                                                        class="input-group-text">Amount</span> </div>
                                                <input type="number" placeholder=""
                                                    onkeypress="return AvoidSpace(event)" class="form-control"
                                                    id="sellvolume" name="sellvolume" required="required"
                                                    step="0.0001" min="0" max="1000000">
                                                <div class="input-group-append"> <span
                                                        class="input-group-text">{{ $coinone }}</span> </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend"> <span
                                                        class="input-group-text">Total</span> </div>
                                                <input type="text" class="form-control" placeholder=""
                                                    id="selltotal" name="selltotal">
                                                <div class="input-group-append"> <span
                                                        class="input-group-text">{{ $cointwo }}</span> </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="control-value-box stoplimtboxt">
                                                <div>limitcount</div>
                                                <div>
                                                    <div class="row link-div">
                                                        <div class="col" onclick="calculateSelllimitAmount('25')">
                                                            25%</div>
                                                        <div class="col" onclick="calculateSelllimitAmount('50')">
                                                            50%</div>
                                                        <div class="col" onclick="calculateSelllimitAmount('75')">
                                                            75%</div>
                                                        <div class="col" onclick="calculateSelllimitAmount('100')">
                                                            100%</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group fee-formbox">
                                            <div class="input-group"> <span class="input-group-prepend">
                                                    <div class="commision"><span class="feeamt">Leverage comission
                                                            :</span> <span
                                                            class="feeamt">{{ $selectPair->sell_trade }}%</span></div>
                                                    <div class="commision"><span class="feeamt">Fee</span> <span
                                                            class="feeamt" id="sellfees">0.0000000
                                                            {{ $coinone }}</span></div>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="ratiobtn">
                                            <div class="text-center">
                                                <input type="button" name=""
                                                    class="btn btn-block sitebtn red-btn" id="selllimit_order"
                                                    value="Sell ({{ $coinone }})" />
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div id="market" class="tab-pane fade in">
                            <div class="orderformbg1">
                                <div class="buyorderform">
                                    <form id="buymarket" class="siteformbg">
                                        @csrf
                                        <div id="buymarketstatus" style="display:none"></div>
                                        <div id="buymarketmsg"> </div>
                                        <div class="form-group"><span> Available Balance: <span
                                                    class="balanceTwo">{{ $cointwobalance }}
                                                </span>{{ $cointwo }}</span></div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="hidden" placeholder="" class="input-xlarge"
                                                    id="buypair" name="buypair" value="{{ $selectPair->id }}">
                                                <input type="text" class="form-control" placeholder="Price"
                                                    value="Market Price" disabled="">
                                                <div class="input-group-append"> <span
                                                        class="input-group-text">{{ $cointwo }}</span> </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend"> <span
                                                        class="input-group-text">Amount</span> </div>
                                                <input type="number" placeholder="" class="form-control"
                                                    id="buymarketvolume" name="buymarketvolume"
                                                    onkeyup="if (/[^0-9.]/g.test(this.value)) this.value = this.value.replace(/[^0-9.]/g,'')"
                                                    required step="0.0001" min="0" max="1000000">
                                                <div class="input-group-append"> <span
                                                        class="input-group-text">{{ $coinone }}</span> </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="control-value-box stoplimtboxt">
                                                <div>limitcount</div>
                                                <div>
                                                    <div class="row link-div">
                                                        <div class="col" onclick="calculateBuyMarketAmount('25')">
                                                            25%</div>
                                                        <div class="col" onclick="calculateBuyMarketAmount('50')">
                                                            50%</div>
                                                        <div class="col" onclick="calculateBuyMarketAmount('75')">
                                                            75%</div>
                                                        <div class="col" onclick="calculateBuyMarketAmount('100')">
                                                            100%</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <input type="button" name="" id="buymarket_submit"
                                                class="btn btn-block sitebtn green-btn" value="Buy" />
                                        </div>
                                    </form>
                                </div>
                                <div class="sellorderform">
                                    <form class="siteformbg" id="sellmarket">
                                        @csrf
                                        <div id="sellmarketstatus" style="display:none"></div>
                                        <div id="sellmarketmsg"></div>
                                        <div class="form-group"><span> Available Balance: <span
                                                    class="balanceOne">{{ $coinonebalance }}</span>
                                                {{ $coinone }}</span></div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="hidden" placeholder="" class="input-xlarge"
                                                    id="sellpair" name="sellpair" value="{{ $selectPair->id }}">
                                                <input type="text" class="form-control" placeholder="Price"
                                                    value="Market Price" disabled="">
                                                <div class="input-group-append"> <span
                                                        class="input-group-text">{{ $cointwo }}</span> </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend"> <span
                                                        class="input-group-text">Amount</span> </div>
                                                <input type="number" class="form-control" placeholder=""
                                                    onkeypress="return AvoidSpace(event)" class="form-control"
                                                    id="sellmarketvolume" name="sellmarketvolume"
                                                    onkeyup="if (/[^0-9.]/g.test(this.value)) this.value = this.value.replace(/[^0-9.]/g,'')"
                                                    required step="0.0001" min="0" max="1000000">
                                                <div class="input-group-append"> <span
                                                        class="input-group-text">{{ $coinone }}</span> </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="control-value-box stoplimtboxt">
                                                <div>limitcount</div>
                                                <div>
                                                    <div class="row link-div">
                                                        <div class="col" onclick="calculateSellMarketAmount('25')">
                                                            25%</div>
                                                        <div class="col" onclick="calculateSellMarketAmount('50')">
                                                            50%</div>
                                                        <div class="col" onclick="calculateSellMarketAmount('75')">
                                                            75%</div>
                                                        <div class="col"
                                                            onclick="calculateSellMarketAmount('100')">100%</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <input type="button" name=""
                                                class="btn btn-block sitebtn red-btn" id="sellmarket_submit"
                                                value="Sell" />
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tradehistory" id="completehistroy">
                    <h2 class="heading-box">Trade History</h2>
                    <div class="table-responsive sitescroll" data-simplebar>
                        <table class="table sitetable">
                            <thead>
                                <tr>
                                    <th>Price({{ $cointwo }})</th>
                                    <th>Amount({{ $coinone }})</th>
                                    <th>Total({{ $cointwo }})</th>
                                    <th>Date & Time</th>
                                </tr>
                            </thead>
                            <tbody id="tradeHistory1">

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="openorder">
                    <div class="innerpagetab historytab">
                        <ul class="nav nav-tabs tabbanner" role="tablist">
                            <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#openorder"
                                    data-bs-target="#openorder">Open Orders</a></li>
                            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tradehistory"
                                    data-bs-target="#tradehistory">My Order History</a></li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div id="openorder" class="tab-pane fade in show active">
                            <h2 class="heading-box">Open Orders</h2>
                            <div class="table-responsive sitescroll" data-simplebar>
                                <table class="table sitetable table-responsive-stack" id="table1">
                                    <thead>
                                        <tr>
                                            <th>Order type</th>
                                            <th>Date & Time</th>
                                            <th>Order</th>
                                            <!--<th><span style="visibility:hidden;">Order</span></th>!-->
                                            <th>Pair</th>
                                            <th>Amount</th>
                                            <th>Price</th>
                                            <th>Remaining</th>
                                            <th>Trade Fee</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th>Cancel</th>
                                        </tr>
                                    </thead>
                                    <tbody id="openorders">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="tradehistory" class="tab-pane fade in">
                            <h2 class="heading-box">Trade History</h2>
                            <div class="table-responsive sitescroll" data-simplebar>
                                <table class="table sitetable table-responsive-stack" id="table2">
                                    <thead>
                                        <tr>
                                            <th>Order type</th>
                                            <th>Date & Time</th>
                                            <th>Order</th>
                                            <!--<th><span style="visibility:hidden;">Order</span></th>!-->
                                            <th>Pair</th>
                                            <th>Amount</th>
                                            <th>Price</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody id="orderhistory">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </article>
    @include('layouts.footermenu')
</div>
@include('layouts.footer')
@if ($selectPair->is_dust == 1)
    <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
    <script type="text/javascript">
        new TradingView.widget({
            "autosize": true,
            "symbol": "BINANCE:{{ $selectPair->symbol }}",
            "interval": "1",
            "timezone": "Etc/UTC",
            "theme": @if (Session::get('mode') == 'nightmode')
                "dark"
            @else
                "light"
            @endif ,
            "style": "1",
            "locale": "in",
            "toolbar_bg": "#f1f3f6",
            "enable_publishing": false,
            "backgroundColor": @if (Session::get('mode') == 'nightmode')
                "rgba(0, 0, 0, 1)"
            @else
                "rgba(255, 255, 255, 1)"
            @endif ,
            "hide_legend": true,
            "hide_side_toolbar": false,
            "container_id": "tradingview_49396"
        });
    </script>
@else
    <script type="text/javascript" src="{{ url('js/charting-library/charting_library.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/datafeeds/udf/dist/polyfills.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/datafeeds/udf/dist/bundle.js') }}"></script>
    <script type="text/javascript">

        function getParameterByName(name) {
            name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
            var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
                results = regex.exec(location.search);
            return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
        }

        TradingView.onready(function() {
            var widget = window.tvWidget = new TradingView.widget({
                // debug: true, // uncomment this line to see Library errors and warnings in the console
                autosize: true,
                symbol: '{{ $coinone . '/' . $cointwo }}',
                interval: 'D',
                container_id: "tradingview_49396",
                theme: "Dark",
                style: "1",
                enable_publishing: false,
                hide_top_toolbar: false,
                hide_legend: false,
                save_image: false,


                //  BEWARE: no trailing slash is expected in feed URL
                //datafeed: new Datafeeds.UDFCompatibleDatafeed("https://demo_feed.tradingview.com"),
                datafeed: new Datafeeds.UDFCompatibleDatafeed("{{ url('/') }}"),
                library_path: "{{ url('/js/charting-library') }}/",
                locale: getParameterByName('lang') || "en",
                //  Regression Trend-related functionality is not implemented yet, so it's hidden for a while
                drawings_access: {
                    type: 'black',
                    tools: [{
                        name: "Regression Trend"
                    }]
                },
                disabled_features: ["use_localstorage_for_settings"],
                enabled_features: ["study_templates"],
                charts_storage_url: 'http://saveload.tradingview.com',
                charts_storage_api_version: "1.1",
                client_id: 'tradingview.com',
                user_id: 'public_user_id',
                @if (Session::get('mode') == 'nightmode')
                    overrides: {
                        "paneProperties.background": "#000",
                        "paneProperties.vertGridProperties.color": "#000",
                        "paneProperties.horzGridProperties.color": "#000",
                        "symbolWatermarkProperties.transparency": 90,
                        "scalesProperties.textColor": "#fff",
                    }
                @elseif (Session::get('mode') == 'lightmode')
                    overrides: {
                        "paneProperties.background": "#fff",
                        "paneProperties.vertGridProperties.color": "#fff",
                        "paneProperties.horzGridProperties.color": "#fff",
                        "symbolWatermarkProperties.transparency": 90,
                        "scalesProperties.textColor": "#fff",
                    }
                @else
                    overrides: {
                        "paneProperties.background": "#fff",
                        "paneProperties.vertGridProperties.color": "#fff",
                        "paneProperties.horzGridProperties.color": "#fff",
                        "symbolWatermarkProperties.transparency": 90,
                        "scalesProperties.textColor": "#fff",
                    }
                @endif

            });
        });

    </script>
@endif
<script>
    function AvoidSpace(event) {
        var k = event ? event.which : window.event.keyCode;
        if (k == 32) return false;
    }
</script>
<script>
    $("body").addClass("tradepagebg");
</script>
<script>
    var chart = AmCharts.makeChart("chartdiv", {
        "type": "serial",
        "theme": "dark",
        "dataLoader": {
            "url": "{{ url('marketdepthchart/' . $selectPair->id) }}",
            "format": "json",
            "reload": 5,
            "postProcess": function(data) {
                loadOrderbook(data);
                // Function to process (sort and calculate cummulative volume)
                function processData(list, type, desc) {
                    // Convert to data points
                    for (var i = 0; i < list.length; i++) {
                        list[i] = {
                            value: Number(list[i][0]),
                            volume: Number(list[i][1]),
                        }
                    }
                    // Sort list just in case
                    list.sort(function(a, b) {
                        if (a.value > b.value) {
                            return 1;
                        } else if (a.value < b.value) {
                            return -1;
                        } else {
                            return 0;
                        }
                    });
                    // Calculate cummulative volume
                    if (desc) {
                        for (var i = list.length - 1; i >= 0; i--) {
                            if (i < (list.length - 1)) {
                                list[i].totalvolume = list[i + 1].totalvolume + list[i].volume;
                            } else {
                                list[i].totalvolume = list[i].volume;
                            }
                            var dp = {};
                            dp["value"] = list[i].value;
                            dp[type + "volume"] = list[i].volume;
                            dp[type + "totalvolume"] = list[i].totalvolume;
                            res.unshift(dp);
                        }
                    } else {
                        for (var i = 0; i < list.length; i++) {
                            if (i > 0) {
                                list[i].totalvolume = list[i - 1].totalvolume + list[i].volume;
                            } else {
                                list[i].totalvolume = list[i].volume;
                            }
                            var dp = {};
                            dp["value"] = list[i].value;
                            dp[type + "volume"] = list[i].volume;
                            dp[type + "totalvolume"] = list[i].totalvolume;
                            res.push(dp);
                        }
                    }
                }
                // Init
                var res = [];
                processData(data.bids, "bids", true);
                processData(data.asks, "asks", false);
                //console.log(res);
                return res;
            }
        },
        "graphs": [{
            "id": "bids",
            "fillAlphas": 0.1,
            "lineAlpha": 1,
            "lineThickness": 2,
            "lineColor": "#0f0",
            "type": "step",
            "valueField": "bidstotalvolume",
            "balloonFunction": balloon
        }, {
            "id": "asks",
            "fillAlphas": 0.1,
            "lineAlpha": 1,
            "lineThickness": 2,
            "lineColor": "#f00",
            "type": "step",
            "valueField": "askstotalvolume",
            "balloonFunction": balloon
        }, {
            "lineAlpha": 0,
            "fillAlphas": 0.2,
            "lineColor": "#000",
            "type": "column",
            "clustered": false,
            "valueField": "bidsvolume",
            "showBalloon": false
        }, {
            "lineAlpha": 0,
            "fillAlphas": 0.2,
            "lineColor": "#000",
            "type": "column",
            "clustered": false,
            "valueField": "asksvolume",
            "showBalloon": false
        }],
        "categoryField": "value",
        "chartCursor": {},
        "balloon": {
            "textAlign": "left"
        },
        "valueAxes": [{
            "title": "Volume"
        }],
        "categoryAxis": {
            "title": "Price ({{ $coinone }}/{{ $cointwo }})",
            "minHorizontalGap": 100,
            "startOnAxis": true,
            "showFirstLabel": false,
            "showLastLabel": false
        },
        "export": {
            "enabled": true
        }
    });

    function balloon(item, graph) {
        var txt;
        if (graph.id == "asks") {
            txt = "Ask: <strong>" + formatNumber(item.dataContext.value, graph.chart, 4) + "</strong><br />" +
                "Total volume: <strong>" + formatNumber(item.dataContext.askstotalvolume, graph.chart, 4) +
                "</strong><br />" + "Volume: <strong>" + formatNumber(item.dataContext.asksvolume, graph.chart, 4) +
                "</strong>";
        } else {
            txt = "Bid: <strong>" + formatNumber(item.dataContext.value, graph.chart, 4) + "</strong><br />" +
                "Total volume: <strong>" + formatNumber(item.dataContext.bidstotalvolume, graph.chart, 4) +
                "</strong><br />" + "Volume: <strong>" + formatNumber(item.dataContext.bidsvolume, graph.chart, 4) +
                "</strong>";
        }
        return txt;
    }

    function formatNumber(val, chart, precision) {
        return AmCharts.formatNumber(val, {
            precision: precision ? precision : chart.precision,
            decimalSeparator: chart.decimalSeparator,
            thousandsSeparator: chart.thousandsSeparator
        });
    }

    function sortKeys(obj, desc) {
        var keys = Object.keys(obj);
        keys.sort((a, b) => {
            var d = +a - +b;
            return desc ? -d : d;
        });
        var res = {};
        keys.forEach(i => res[i] = obj[i]);
        return res;
    }

    function financial(val, limit = 2) {
        return Number.parseFloat(val).toFixed(limit);
    }

    var depthSocketBuffer;
    var depthSocketBufferB = {};
    var depthSocketBufferA = {};
    var depthSocketBufferId;
    var lastEventUpdateId;
    var coinOneDecimal = {{ $selectPair->coinone_decimal }};
    var coinTwoDecimal = {{ $selectPair->cointwo_decimal }};
    var depth;
    var orderbook;
    var depthprice = 1;

    var buydepthprice = 1;
    var selldepthprice = 1;
    var k = true;
    var ordered = {};
    var newU = false;

    function loadOrderbook(data) {
        let bR = '';
        let aR = '';
        $.each(data.bids, function(k, v) {
            listprice = parseFloat(v[0]);
            depthSocketBufferB[listprice] = parseFloat(v[1]);
        });
        $.each(data.asks, function(k, v) {
            listprice = parseFloat(v[0]);
            depthSocketBufferA[listprice] = parseFloat(v[1]);
        });
        bufferB = sortKeys(depthSocketBufferB, false);
        bufferA = sortKeys(depthSocketBufferA, true);
        $.each(bufferB, function(k, v) {
            let bSum = parseFloat(k) * parseFloat(v);
            //   bR = '<tr><td>'+k+'</td><td>'+v+'</td><td>'+financial(bSum)+'</td></tr>' + bR;
            bR = '<tr onclick="javascript:buyRow(' + k + ',' + v + ');"><td><span class="t-green">' + k +
                '</span></td><td class="text-right">' + v + '</td><td class="text-right">' + financial(bSum,
                    coinTwoDecimal) + '</td></tr>' + bR;
        });
        $.each(bufferA, function(k, v) {
            let aSum = parseFloat(k) * parseFloat(v);
            //aR = aR + '<tr><td>'+k+'</td><td>'+v+'</td><td>'+financial(aSum)+'</td></tr>';
            aR = aR + '<tr onclick="javascript:sellRow(' + k + ',' + v + ');"><td><span class="t-red">' + k +
                '</span></td><td class="text-right">' + v + '</td><td class="text-right">' + financial(aSum,
                    coinTwoDecimal) + '</td></tr>';
        });

        $("#buyOrderBook").html(bR);
        $("#sellOrderBook").html(aR);
        $("#buyOrderBook .tr-div").slice(50).remove();
        $("#sellOrderBook .tr-div").slice(50).remove();

        $("#sellpagescroll").scrollTop($('#sellpagescroll')[0].scrollHeight);
    }
</script>

<script language="javascript" type="text/javascript">
    $('#buyvolume , #buyprice').on('keyup', function() {
        buycal();
    });

    $('#sellvolume, #sellprice').on('keyup', function() {
        sellcal();
    });

    $('#buytotal').on('keyup', function() {
        buyTotalcal();
    });
    $('#selltotal').on('keyup', function() {
        sellTotalcal();
    });

    function buycal() {
        var buyprice = parseFloat($('#buyprice').val());
        var buyvolume = parseFloat($('#buyvolume').val());
        var buytotal = parseFloat(buyprice) * parseFloat(buyvolume);
        var buyfee = parseFloat(buytotal) * parseFloat({{ $selectPair->buy_trade }});
        var points = parseFloat(coinTwoDecimal) + 1;


        buytotal = parseFloat(buytotal).toFixed(coinTwoDecimal);

        buyfee = parseFloat(buyfee).toFixed(coinTwoDecimal);


        if (buytotal > 0) {
            document.getElementById('buytotal').value = buytotal;
            $('#buyfees').html(buyfee);
            $('#buytotal').html(buytotal);
        } else {
            $('#buyfees').html(0);
            document.getElementById('buytotal').value = 0;
        }
    }

    function buyTotalcal() {
        var buyprice = parseFloat($('#buyprice').val());
        if (buyprice > 0) {

        } else {
            var buyprice = parseFloat($('#lastprice').text().trim());
        }

        var buytotal = parseFloat($('#buytotal').val());
        var buyvolume = parseFloat(buytotal) / parseFloat(buyprice);
        var buyfee = parseFloat(buytotal) * parseFloat({{ $selectPair->buy_trade }});
        buytotal = parseFloat(buytotal) + parseFloat(buyfee);
        var points = parseFloat(coinTwoDecimal) + 1;


        buyvolume = parseFloat(buyvolume).toFixed(coinTwoDecimal);

        buyfee = parseFloat(buyfee).toFixed(coinTwoDecimal);


        if (buyvolume > 0) {
            document.getElementById('buyvolume').value = buyvolume;
            document.getElementById('buyprice').value = buyprice;
            $('#buyfees').html(buyfee);
        } else {
            $('#buyfees').html(0);
            document.getElementById('buyvolume').value = 0;
            document.getElementById('buyprice').value = buyprice;
        }
    }

    function sellTotalcal() {
        var sellprice = parseFloat($('#sellprice').val());
        if (sellprice > 0) {

        } else {
            var sellprice = parseFloat($('#lastprice').text().trim());
        }
        var selltotal = parseFloat($('#selltotal').val());
        var sellvolume = parseFloat(selltotal) / parseFloat(sellprice);
        var sellfee = parseFloat(selltotal) * parseFloat({{ $selectPair->sell_trade }});
        var points = parseFloat(coinTwoDecimal) + 1;


        sellvolume = parseFloat(sellvolume).toFixed(coinTwoDecimal);

        sellfee = parseFloat(sellfee).toFixed(coinTwoDecimal);


        if (sellvolume > 0) {
            document.getElementById('sellvolume').value = sellvolume;
            document.getElementById('sellprice').value = sellprice;
            $('#sellfees').html(sellfee);
        } else {
            $('#sellfees').html(0);
            document.getElementById('sellvolume').value = 0;
            document.getElementById('sellprice').value = sellprice;
        }
    }

    function calculateBuyMarketAmount(percent) {
        var buyprice = parseFloat($('#buyprice').val());
        if (buyprice > 0) {

        } else {
            var buyprice = parseFloat($('#lastprice').text().trim());
        }
        var percentage = percent / 100;
        var balance = parseFloat({{ $cointwobalance }}) * percentage;

        var buytotal = balance;
        var buyvolume = parseFloat(buytotal) / parseFloat(buyprice);
        if (buyvolume > 0) {
            document.getElementById('buymarketvolume').value = buyvolume;
        } else {
            document.getElementById('buymarketvolume').value = 0;
        }
    }

    function calculateSellMarketAmount(percent) {
        var percentage = percent / 100;
        var balance = parseFloat({{ $coinonebalance }}) * percentage;
        if (balance > 0) {
            document.getElementById('sellmarketvolume').value = balance;
        } else {
            document.getElementById('sellmarketvolume').value = 0;
        }
    }

    function calculateBuylimitAmount(percent) {
        var buyprice = parseFloat($('#buyprice').val());
        if (buyprice > 0) {

        } else {
            var buyprice = parseFloat($('#lastprice').text().trim());
        }
        var percentage = percent / 100;
        var balance = parseFloat({{ $cointwobalance }}) * percentage;

        var buytotal = balance;
        var buyvolume = parseFloat(buytotal) / parseFloat(buyprice);
        var buyfee = parseFloat(buytotal) * parseFloat({{ $selectPair->buy_trade }});
        buytotal = parseFloat(buytotal) + parseFloat(buyfee);
        var points = parseFloat(coinTwoDecimal) + 1;


        buyvolume = parseFloat(buyvolume).toFixed(coinTwoDecimal);

        buyfee = parseFloat(buyfee).toFixed(coinTwoDecimal);


        if (buyvolume > 0) {
            document.getElementById('buyvolume').value = buyvolume;
            document.getElementById('buyprice').value = buyprice;
            document.getElementById('buytotal').value = buytotal;
            $('#buyfees').html(buyfee);
        } else {
            $('#buyfees').html(0);
            document.getElementById('buyvolume').value = 0;
            document.getElementById('buyprice').value = buyprice;
            document.getElementById('buytotal').value = buytotal;
        }
    }

    function calculateSelllimitAmount(percent) {
        var sellprice = parseFloat($('#sellprice').val());
        if (sellprice > 0) {

        } else {
            var sellprice = parseFloat($('#lastprice').text().trim());
        }
        var percentage = percent / 100;
        var balance = parseFloat({{ $coinonebalance }}) * percentage;
        var selltotal = parseFloat(balance) * parseFloat(sellprice);
        var sellvolume = parseFloat(balance);
        var sellfee = parseFloat(selltotal) * parseFloat({{ $selectPair->sell_trade }});
        var points = parseFloat(coinTwoDecimal) + 1;


        sellvolume = parseFloat(sellvolume).toFixed(coinTwoDecimal);

        sellfee = parseFloat(sellfee).toFixed(coinTwoDecimal);


        if (sellvolume > 0) {
            document.getElementById('sellvolume').value = sellvolume;
            document.getElementById('sellprice').value = sellprice;
            document.getElementById('selltotal').value = selltotal;
            $('#sellfees').html(sellfee);
        } else {
            $('#sellfees').html(0);
            document.getElementById('sellvolume').value = 0;
            document.getElementById('sellprice').value = sellprice;
        }
    }

    function sellcal() {
        var sellprice = parseFloat($('#sellprice').val());
        var sellvolume = parseFloat($('#sellvolume').val());
        var sellfee = parseFloat(sellvolume) * parseFloat({{ $selectPair->sell_trade }});
        var selltotal = parseFloat(sellvolume) * parseFloat(sellprice);

        selltotal = parseFloat(selltotal).toFixed(coinTwoDecimal);


        if (selltotal > 0) {
            sellfees = sellfee.toFixed(9);
            document.getElementById('selltotal').value = parseFloat(selltotal).toFixed(coinTwoDecimal);

            $('#sellfees').html(sellfees.slice(0, -1));
        } else {
            $('#sellfees').html(0);
            document.getElementById('selltotal').value = 0;
        }
    }

    function sellRow(price, remaining) {

        document.getElementById("buyprice").value = price;
        document.getElementById("buyvolume").value = remaining;
        document.getElementById("buymarketvolume").value = remaining;

        $(".tradepage").addClass("buyorderformactive1");
        $(".tradepage").removeClass("sellorderformactive1");
        $('#buytab').addClass('active');
        $('#selltab').removeClass('active');


        buycal();

    }

    function buyRow(price, remaining) {
        document.getElementById("sellprice").value = price;
        document.getElementById("sellvolume").value = remaining;
        document.getElementById("sellmarketvolume").value = remaining;

        $(".tradepage").addClass("sellorderformactive1");
        $(".tradepage").removeClass("buyorderformactive1");
        $('#selltab').addClass('active');
        $('#buytab').removeClass('active');
        sellcal();

    }
</script>


{{-- main websocket --}}
<script>
    /********** websocket **************/
    @php $uid = \Crypt::encrypt(Auth::user()->id); @endphp
    @php $uid1 = Auth::user()->id; @endphp
    $(document).ready(function() {
        @if ($selectPair->is_dust == 0)
            var websocket = new WebSocket("wss://localhost:9090");
            websocket.onopen = function(event) {
                var messageJSON = {
                    market: "{{ $coinone }}_{{ $cointwo }}",
                    _token: "{{ $uid }}"
                };
                websocket.send(JSON.stringify(messageJSON));
            }
            websocket.onmessage = function(event) {
                var Data = JSON.parse(event.data);
                if (Data.coinone == "{{ $coinone }}" && Data.cointwo == "{{ $cointwo }}") {

                    if (typeof Data === 'string') {
                        Data = JSON.parse(Data);
                        $('#buyOrderBook').html(Data.buy);
                        $('#sellOrderBook').html(Data.sell);
                        $('#tradeHistory1').html(Data.completedtrade);
                        $('#livemarket').html(Data.Liveprice);
                        $('#currentprice1').html(Data.currentprice);
                        $('#hoursvoume').html(Data.hoursvoume);
                        $('#hoursexchange').html(Data.hoursexchange);

                    }
                    if (Data.buy) {
                        $('#buyOrderBook').html(Data.buy);
                    }
                    if (Data.sell) {
                        $('#sellOrderBook').html(Data.sell);
                    }
                    if (Data.completedtrade) {
                        $('#tradeHistory1').html(Data.completedtrade);
                    }
                    if (Data.Liveprice) {
                        $('#livemarket').html(Data.Liveprice);
                    }

                    if (Data.currentprice) {
                        $('#currentprice1').html(Data.currentprice);
                        $('#orderprice').html(Data.currentprice);
                    }
                    if (Data.hoursvoume) {
                        $('#hoursvoume').html(Data.hoursvoume);
                    }
                    if (Data.hoursexchange) {
                        $('#hoursexchange').html(Data.hoursexchange);
                        $('#orderpercent').html(Data.hoursexchange);
                    }

                    if (Data.token) {
                        if (Data.token == '{{ $uid }}') {
                            if (Data.onebalance) {
                                $('#coinOnebalance').html(Data.onebalance);
                                $('#coinOnebalance_market').html(Data.onebalance);
                            }
                            if (Data.twobalance) {
                                $('#coinTwobalance').html(Data.twobalance);
                                $('#coinTwobalance_market').html(Data.twobalance);
                            }
                        }
                    }

                }
            };

            websocket.onerror = function(event) {
                console.log("Problem due to some Error");
            };
            websocket.onclose = function(event) {
                console.log("Connection Closed");
            };
        @elseif ($selectPair->is_dust == 1 && $selectPair->is_bot == 0)

            function sortKeys(obj, desc) {
                var keys = Object.keys(obj);
                keys.sort((a, b) => {
                    var d = +a - +b;
                    return desc ? -d : d;
                });
                var res = {};
                keys.forEach(i => res[i] = obj[i]);
                return res;
            }

            function financial(val, limit = 2) {
                return Number.parseFloat(val).toFixed(limit);
            }

            var depthSocketBuffer;
            //var depthSocketBufferB = {};
            //var depthSocketBufferA = {};
            var depthSocketBufferId;
            var lastEventUpdateId;
            var depth;
            var orderbook;
            var depthprice = 1;

            var buydepthprice = 1;
            var selldepthprice = 1;
            var k = true;
            var ordered = {};
            var newU = false;
            var selectPair = "{{ strtolower($cpair) }}";


            function loadOrderbook_web(data) {
                depthSocketBuffer = data;
                depthSocketBufferId = depthSocketBuffer.lastUpdateId;
                $.each(depthSocketBuffer.bids, function(k, v) {
                    listprice = parseFloat(parseFloat(v[0]) * parseFloat(buydepthprice)).toFixed(8);
                    depthSocketBufferB[listprice] = parseFloat(v[1]);
                });
                $.each(depthSocketBuffer.asks, function(k, v) {
                    listprice = parseFloat(parseFloat(v[0]) * parseFloat(selldepthprice)).toFixed(8);
                    depthSocketBufferA[listprice] = parseFloat(v[1]);
                });
            }

            var websocket = new WebSocket("wss://stream.binance.com:9443/ws/" + selectPair + "@depth@1000ms");
            websocket.onopen = function(event) {
                var messageJSON = {
                    "method": "SUBSCRIBE",
                    "params": [
                        selectPair + "@aggTrade",
                        selectPair + "@depth"
                    ],
                    "id": 1
                };
                //depthhistroy();
                console.log(messageJSON);
                websocket.send(JSON.stringify(messageJSON));
            }

            websocket.onmessage = function(event) {
                var Data = JSON.parse(event.data);
                console.log(Data);

                if (Data.e == 'depthUpdate') {

                    let id = depthSocketBufferId;
                    let bufferB = depthSocketBufferB;
                    let bufferA = depthSocketBufferA;
                    let obj = JSON.parse(event.data);
                    let U = obj.U;
                    let u = obj.u;
                    let b = obj.b;
                    let a = obj.a;
                    let bR = '';
                    let aR = '';
                    let newB = {};
                    let newA = {};

                    let updateDepthCache = function() {
                        $.each(b, function(k, v) {
                            listprice = parseFloat(parseFloat(v[0]) * parseFloat(buydepthprice))
                                .toFixed(8);
                            if (v[1] === '0.00000000') delete bufferB[listprice];
                            else bufferB[listprice] = parseFloat(v[1]);
                        });
                        $.each(a, function(k, v) {
                            listprice = parseFloat(parseFloat(v[0]) * parseFloat(
                                selldepthprice)).toFixed(8);
                            if (v[1] === '0.00000000') delete bufferA[listprice];
                            else bufferA[listprice] = parseFloat(v[1]);
                        });
                    }
                    
                    if (u) {
                        if (u <= id) {} else {
                            if (!newU && U <= id + 1 && u >= id + 1) {
                                updateDepthCache();
                                newU = u;
                            } else {
                                newU = newU + 1;
                                updateDepthCache();
                            }
                        }
                    } else updateDepthCache();
                    bufferB = sortKeys(bufferB, false);
                    bufferA = sortKeys(bufferA, true);

                    // if(k == true ){
                    //      var i=0;
                    //     $.each(bufferB, function(k, v){
                    //       i=i+1;
                    //       if(i <= 100 )
                    //          delete bufferB[k]; 
                    //       });
                    //       var j=0;
                    //       $.each(bufferA, function(k, v){
                    //       j=j+1;
                    //       if(i <= 100 )
                    //          delete bufferA[k]; 
                    //       });
                    //  k=false;
                    // }
                    depthSocketBufferA = bufferA;
                    depthSocketBufferB = bufferB;

                    $.each(bufferB, function(k, v) {
                        let bSum = parseFloat(k) * parseFloat(v);
                        //   bR = '<tr><td>'+k+'</td><td>'+v+'</td><td>'+financial(bSum)+'</td></tr>' + bR;
                        bR = '<tr onclick="javascript:buyRow(' + k + ',' + v +
                            ');"><td><span class="t-green">' + k +
                            '</span></td><td class="text-right">' + v +
                            '</td><td class="text-right">' + financial(bSum, coinTwoDecimal) +
                            '</td></tr>' + bR;
                    });
                    $.each(bufferA, function(k, v) {
                        let aSum = parseFloat(k) * parseFloat(v);
                        //aR = aR + '<tr><td>'+k+'</td><td>'+v+'</td><td>'+financial(aSum)+'</td></tr>';
                        aR = aR + '<tr onclick="javascript:sellRow(' + k + ',' + v +
                            ');"><td><span class="t-red">' + k +
                            '</span></td><td class="text-right">' + v +
                            '</td><td class="text-right">' + financial(aSum, coinTwoDecimal) +
                            '</td></tr>';
                    });

                    $("#buyOrderBook").html(bR);
                    $("#sellOrderBook").html(aR);
                    $("#buyOrderBook .tr-div").slice(50).remove();
                    $("#sellOrderBook .tr-div").slice(50).remove();
                }



                if ((typeof Data['e'] == "aggTrade") || (Data['e'] != null)) {
                    if (Data['e'] == "aggTrade") {
                        // alert($("#historyall_trade").children().length);
                        var com_order_data = '';

                        //   $('#test').html("<div class='loader_smt'></div>");
                        //  $('#historyall_trade').css('display', 'none');
                        var date_ob = new Date(Data['T']);
                        // s=s.toLocaleString('en-US', { hour: 'numeric', hour12: true })

                        // year as 4 digits (YYYY)
                        var year = date_ob.getFullYear();

                        // month as 2 digits (MM)
                        var month = ("0" + (date_ob.getMonth() + 1)).slice(-2);

                        // date as 2 digits (DD)
                        var date = ("0" + date_ob.getDate()).slice(-2);

                        // hours as 2 digits (hh)
                        var hours = ("0" + date_ob.getHours()).slice(-2);

                        // minutes as 2 digits (mm)
                        var minutes = ("0" + date_ob.getMinutes()).slice(-2);

                        // seconds as 2 digits (ss)
                        var seconds = ("0" + date_ob.getSeconds()).slice(-2);


                        // date & time as YYYY-MM-DD hh:mm:ss format: 
                        var s = year + "-" + month + "-" + date + "," + hours + ":" + minutes + ":" +
                            seconds;
                        //			    s = (date_ob.toLocaleTimeString());


                        var is_data = "t-red";
                        if (Data['m']) {
                            is_data = "t-green";
                            Data['p'] = Data['p'] * buydepthprice;
                        } else {
                            Data['p'] = Data['p'] * selldepthprice;
                        }
                        var total = parseFloat(Data['p']) * parseFloat(Data['q']);


                        com_order_data = ('<tr class="tr-div"><td><span class="' + is_data + '">' +
                            parseFloat(Data['p']).toFixed(8) + '</span></td><td>' + parseFloat(Data[
                                'q']).toFixed(8) + '</td> <td>' + total.toFixed(8) + '</td> <td>' + s +
                            '</td></tr>');
                        $('#tradeHistory1').prepend(com_order_data);
                        //console.log(com_order_data);

                        var historylength = $("#tradeHistory1").children().length;
                        if (historylength > 0) {
                            $('#norecord').hide();
                        }
                        $('#tradeHistory1').find(".tr-div").slice(50, historylength).remove();
                    }
                }
            };

            websocket.onerror = function(event) {
                console.log("Problem due to some Error");
            };
            websocket.onclose = function(event) {
                console.log("Connection Closed");
            };
        @elseif ($selectPair->is_bot == 1)
        @endif
        // Send to Everyone
        /* setInterval(function() {
        var messageJSON = {
        market: "{{ $coinone }}_{{ $cointwo }}",
        _token: "{{ $uid }}"
        };
        websocket.send(JSON.stringify(messageJSON));
        //alert();
        }, 10000 ); */
        $("#buylimit_order").click(function() {
            document.getElementById('buylimit_order').classList.add('hide');
            $('.loadbg').show();
            $.ajax({
                type: "POST",
                url: '{{ route('buylimit') }}',
                data: $("#buylimit").serialize(),
            }).done(function(request) {


                if (request.status == 'buylimitsuccess') {
                    document.getElementById('buylimit_order').classList.remove('hide');
                    $('#buylimit')[0].reset();
                    $('#buylimitmsg').html(request.msg);
                    $('.balanceOne').html(request.balanceOne);
                    $('.balanceTwo').html(request.balanceTwo);
                    $('.loadbg').hide();
                    $("#buyprice").val();
                    $("#buyvolume").val('');
                    $("#buytotal").val('');
                    $("#buyfees").val('');
                    toastr.success('Post Trade Successfully!');

                    var spans = $('#buyfees');
                    spans.text('');
                    var messageJSON = {
                        market: "{{ $coinone }}_{{ $cointwo }}",
                        _token: "{{ $uid }}"
                    };
                    websocket.send(JSON.stringify(messageJSON));
                } else {
                    document.getElementById('buylimit_order').classList.remove('hide');
                    $('.loadbg').hide();
                    $('#buylimitmsg').html(request.msg);
                }

            });
        });
        $("#selllimit_order").click(function() {
            document.getElementById('selllimit_order').classList.add('hide');
            $('.loadbg').show();
            $.ajax({
                type: "POST",
                url: '{{ route('selllimit') }}', // This is what I have updated
                data: $("#sellimit").serialize(),
            }).done(function(request) {


                if (request.status == 'selllimitsuccess') {
                    document.getElementById('selllimit_order').classList.remove('hide');
                    $('#sellimit')[0].reset();
                    $('#selllimitmsg').html(request.msg);
                    $('.balanceOne').html(request.balanceOne);
                    $('.balanceTwo').html(request.balanceTwo);
                    $('.loadbg').hide();

                    $("#sellprice").val('');
                    $("#sellvolume").val('');
                    $("#selltotal").val('');
                    $("#sellfees").val('');
                    toastr.success('Post Trade Successfully!');

                    var spans = $('#sellfees');
                    spans.text('');

                    var messageJSON = {
                        market: "{{ $coinone }}_{{ $cointwo }}",
                        _token: "{{ $uid }}"
                    };
                    websocket.send(JSON.stringify(messageJSON));
                } else {
                    document.getElementById('selllimit_order').classList.remove('hide');
                    $('.loadbg').hide();
                    $('#selllimitmsg').html(request.msg);
                }

            });
        });
        $("#buymarket_submit").click(function() {
            document.getElementById('buymarket_submit').classList.add('hide');
            $('.loadbg').show();
            $.ajax({
                type: "POST",
                url: '{{ route('buymarket') }}', // This is what I have updated
                data: $("#buymarket").serialize(),
            }).done(function(request) {


                if (request.status == 'buymarketsuccess') {
                    document.getElementById('buymarket_submit').classList.remove('hide');
                    $('#buymarket')[0].reset();
                    $('#buymarketmsg').html(request.msg);
                    $('.balanceOne').html(request.balanceOne);
                    $('.balanceTwo').html(request.balanceTwo);
                    $('.loadbg').hide();

                    $("#buymarketvolume").val('');
                    var messageJSON = {
                        market: "{{ $coinone }}_{{ $cointwo }}",
                        _token: "{{ $uid }}"
                    };
                    websocket.send(JSON.stringify(messageJSON));
                } else {
                    document.getElementById('buymarket_submit').classList.remove('hide');
                    $('.loadbg').hide();
                    $('#buymarketmsg').html(request.msg);
                }

            });
        });
        $("#sellmarket_submit").click(function() {
            document.getElementById('sellmarket_submit').classList.add('hide');
            $('.loadbg').show();
            $.ajax({
                type: "POST",
                url: '{{ route('sellmarket') }}', // This is what I have updated
                data: $("#sellmarket").serialize(),
            }).done(function(request) {


                if (request.status == 'sellmarketsuccess') {
                    document.getElementById('sellmarket_submit').classList.remove('hide');
                    $('#sellmarket')[0].reset();
                    $('#sellmarketmsg').html(request.msg);
                    $('.balanceOne').html(request.balanceOne);
                    $('.balanceTwo').html(request.balanceTwo);
                    $('.loadbg').hide();

                    $("#sellmarketvolume").val('');
                    var messageJSON = {
                        market: "{{ $coinone }}_{{ $cointwo }}",
                        _token: "{{ $uid }}"
                    };
                    websocket.send(JSON.stringify(messageJSON));
                } else {
                    document.getElementById('sellmarket_submit').classList.remove('hide');
                    $('.loadbg').hide();
                    $('#sellmarketmsg').html(request.msg);
                }

            });
        });

        $.fn.serializeObject = function() {
            var o = Object.create(null),
                elementMapper = function(element) {
                    element.name = $.camelCase(element.name);
                    return element;
                },
                appendToResult = function(i, element) {
                    var node = o[element.name];

                    if ('undefined' != typeof node && node !== null) {
                        o[element.name] = node.push ? node.push(element.value) : [node, element.value];
                    } else {
                        o[element.name] = element.value;
                    }
                };

            $.each($.map(this.serializeArray(), elementMapper), appendToResult);
            return o;
        };

    });
</script>


{{-- update the pair 24vh high low --}}
<script type="text/javascript">
    $(document).ready(function() {

        var conn = new WebSocket("wss://stream.binance.com:9443/ws");
        conn.onopen = function(evt) {

            var cpair = 'BTCUSDT';


            // send Subscribe/Unsubscribe messages here (see below)
            var array_dta = [];
            @forelse($trades as $pairlist)
                @if ($pairlist->is_dust == 1 || $pairlist->is_dust == 2)
                    @if ($pairlist->is_dust == 2)
                        var bpair = "{{ strtolower(trim($pairlist->coinone . 'USDT')) }}";
                    @else
                        var bpair = '{{ strtolower(trim($pairlist->symbol)) }}';
                    @endif
                    array_dta1 = [bpair + "@ticker"];
                    array_dta1.forEach(function(item) {
                        array_dta.push(item);
                    })
                @endif
            @empty
                var bpair = 'btcusdt';
                array_dta1 = [bpair + "@ticker"];
                array_dta1.forEach(function(item) {
                    array_dta.push(item);
                })
            @endforelse
            var messageJSON = {
                "method": "SUBSCRIBE",
                "params": array_dta,
                "id": 1
            };
            conn.send(JSON.stringify(messageJSON));
        }


        conn.onmessage = function(evt) {
            if (evt.data) {
                var get_data = JSON.parse(evt.data);
                if ((typeof get_data['e'] == "24hrTicker") || (get_data['e'] != null)) {
                    var last_price = get_data['c'];
                    var high_price = get_data['h'];
                    var low_price = get_data['l'];
                    var price_change = get_data['P'];
                    var quote = get_data['q'];
                    var symbol = get_data['s'];

                    var is_data = "t-red";
                    if (price_change > 0) {
                        is_data = "t-green";
                    }

                    if ((typeof last_price != 'undefined')) {
                        //console.log('Last',last_price.toString());
                        $('.last_price_' + symbol).html(parseFloat(last_price.toString()));
                    }
                    if ((typeof quote != 'undefined') && (typeof quote != 'undefined')) {
                        //console.log('.quote_'+symbol,quote);
                        $('.quote_' + symbol).html(parseFloat(quote.toString()));
                    }
                    if ((typeof open_price != 'undefined') && (typeof last_price != 'undefined')) {
                        $('.open_' + symbol).html(parseFloat(open_price.toString()));
                    }
                    if ((typeof low_price != 'undefined') && (typeof last_price != 'undefined')) {
                        $('.low_' + symbol).html(parseFloat(low_price.toString()));
                    }
                    if ((typeof high_price != 'undefined') && (typeof last_price != 'undefined')) {
                        $('.high_' + symbol).html(parseFloat(high_price.toString()));
                    }


                    if ((typeof price_change != 'undefined') && (typeof last_price != 'undefined')) {
                        price_change = price_change * 1;
                        price_change = price_change.toFixed(2);
                        $('.price_change_' + symbol).html('<span class="' + is_data + '">' + parseFloat(
                            price_change).toFixed(2) + '% </span>');
                    }

                }
            }

        }

    });
</script>


{{-- update order history and open order --}}
<script>
    function update_openorders() {
        $.ajax({
            url: "{{ url('/openorders') }}",
            type: "GET",
            async: true,
            cache: false,
            success: function(result) {
                $("#openorders").html(result);
            }
        });
    }

    function update_orderhistory() {
        $.ajax({
            url: "{{ url('/orderhistory') }}",
            type: "GET",
            async: true,
            cache: false,
            success: function(result) {
                $("#orderhistory").html(result);
            }
        });
    }

    function update_tradehistory() {
        $.ajax({
            url: "{{ url('/tradehistoryajax/' . \Crypt::encrypt($selectPair->id)) }}",
            type: "GET",
            async: true,
            cache: false,
            success: function(result) {
                $("#tradeHistory1").html(result);
            }
        });
    }

    function generateNumber() {
        var startBuyPrice = "{{ $selectPair->start_buy_price }}";
        var endBuyPrice = "{{ $selectPair->end_buy_price }}";
        var startVolume = "{{ $selectPair->start_volume }}";
        var endVolume = "{{ $selectPair->end_volume }}";
        var openprice = "{{ $selectPair->open }}";

        function generateRandomNumber(price1, price2) {
            var min = price1,
                max = price2,
                randomdnumber = parseFloat(Math.random() * (max - min) + min).toFixed(8);
            return randomdnumber;
        };

        var lastprice = generateRandomNumber(startBuyPrice, endBuyPrice);
        var hvolume = generateRandomNumber(startVolume, endVolume);
        var increase = lastprice - openprice;
        var price_change = (increase / openprice) * 100;

        $("#lastprice").html(parseFloat(lastprice).toFixed(coinTwoDecimal));
        $("#24hchng").html(parseFloat(price_change).toFixed(2) + '%');
        $("#24hvol").html(parseFloat(hvolume).toFixed(2));
        $("#greenlastprice").html(parseFloat(lastprice).toFixed(coinTwoDecimal));
        $("#greenhrchange").html(parseFloat(price_change).toFixed(2) + '%' + ' ');

    };

    setInterval(function() {
        update_openorders();
        update_orderhistory();
        @if ($selectPair->is_dust == 0)
            update_tradehistory();
        @endif

        @if ($selectPair->is_bot == 0 || $selectPair->is_bot == 2)
            //generateNumber();
        @endif
    }, 5000);
</script>


{{-- change theme --}}
<script>
    window.onload = function() {
        @if (Session::get('mode') == 'nightmode')
            $(".tradechartlist iframe").contents().find('body').removeClass('day');
        @else
            $(".tradechartlist iframe").contents().find('body').addClass('day');
        @endif
    }

    $(document).ready(function() {
        $("#hidef").click(function() {
            $("#hidef").addClass("none");
            $("#showf").removeClass("none");
            $("body").removeClass("daymode");
            $(".tradechartlist iframe").contents().find('body').removeClass('day');
        });
        $("#showf").click(function() {
            $("#showf").addClass("none");
            $("body").addClass("daymode");
            $("#hidef").removeClass("none");
            $(".tradechartlist iframe").contents().find('body').addClass('day');
        });
    });
</script>
