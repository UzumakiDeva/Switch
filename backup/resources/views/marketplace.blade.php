@php $title = "P2P Marketplace"; $atitle ="market-place"; @endphp @include('layouts.header')
<link href="https://fonts.googleapis.com/css?family=Maven+Pro:400,700" rel="stylesheet" />
<link href="{{url('build/app.css')}}" rel="stylesheet" />
<link rel="stylesheet" type="text/css" media="screen" href="{{url('css-min/key/d21097e83a2df4340d4e94d76fb19d62e89abfe0/t/1548074956.css')}}" />
<link rel="stylesheet" type="text/css" media="screen" href="{{url('css-min/marketplace.css')}}" />
<div class="pagecontent gridpagecontent tradepage chartactive"> @include('layouts.headermenu') </section>

  <main role="main" id="wrap">
    @if(Auth::user()->email)
    @else
  <div class="mainBody"></div>
  <h1 class="comingSoon">COMING SOON!....</h1> 
  @endif
    <div class="container">
      <div id="middle">
        <div class="container market-place-contain">
          <div class="d-flex flex-column flex-xl-row justify-content-start mt-xl-5">
            <div class="dropdown p-1 p-xl-0 mr-1" id="tradingpair_switch"> <a class="dropdown-toggle cursor-pointer pl-2" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Change marketplace                </a> <span class="dropdown-menu shadow" x-placement="bottom-start">
            <form class="accordion" id="accordion-marketplaces">
              <div>
                        <a class="nav-link collapsed active"
                           data-toggle="collapse" data-target="#collapse_crypto_fiat" aria-expanded="true" aria-controls="collapse_crypto_fiat">
                            <h4 class="mb-0 pl-1">
                                P2P Marketplace (Crypto/Euro)                                        </h4>
                        </a>
                        <a class="nav-link collapsed"
                           data-toggle="collapse" data-target="#collapse_crypto_crypto" aria-expanded="true" aria-controls="collapse_crypto_crypto">
                            <h4 class="mb-0 pl-1">
                                P2P Marketplace (Crypto/Crypto)                                        </h4>
                        </a>

                        <div id="collapse_crypto_fiat" class="collapse" aria-labelledby="heading_crypto_fiat" data-parent="#accordion-marketplaces">
                          @forelse($trades as $trade)
                            @if($trade->cointwo == 'EUR')
                            <div class="tradingpair-link"><a class="d-block" href="{{ url('marketplace/'.$trade->coinone.'_'.$trade->cointwo) }}">{{ $trade->coinone.' / '.$trade->cointwo}}</a></div>
                            @endif
                          @empty
                          @endforelse
                        </div>
                    </div>             <div>
                       
                        <div>                                                                                              
                        <div id="collapse_crypto_crypto" class="collapse" aria-labelledby="heading_crypto_crypto" data-parent="#accordion-marketplaces">
                            @forelse($trades as $trade)
                            @if($trade->cointwo != 'EUR')
                            <div class="tradingpair-link"><a class="d-block" href="{{ url('marketplace/'.$trade->coinone.'_'.$trade->cointwo) }}">{{ $trade->coinone.' / '.$trade->cointwo}}</a></div>
                            @endif
                          @empty
                         
                          @endforelse                                   
                        </div>
                    </div>
                    
                    </div>
                      </form>
        </span> </div>
            <div class="transformer-tabs d-flex flex-column flex-xl-row justify-content-between">
              @php $i = 1; @endphp
              @forelse($trades as $trade)
              @if($trade->cointwo == $cointwo)              
              <div class="marketplace-tabs d-flex flex-xl-row flex-column @if($i >= 5 && $selectPair->id != $trade->id) d-xl-none @endif" data-idx="crypto_fiat"> <a class="@if($selectPair->id == $trade->id) active @endif" href="{{ url('marketplace/'.$trade->coinone.'_'.$trade->cointwo) }}">{{ $trade->coinone.' / '.$trade->cointwo}} </a> </div>
              
              @php $i++; @endphp
              @endif
              @empty
              @endforelse
              <div class="marketplace-tabs d-flex flex-xl-row flex-column  d-xl-none" data-idx="crypto_fiat">
                <div class="promoted-text"> </div>
                </span>
              </div>
              <div class="marketplace-tabs d-xl-flex d-none">
                <div class="dropdown p-1 p-xl-0 mr-1" id="more_tradingpair_switch"> <a class="dropdown-toggle cursor-pointer pl-2" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">New trade pair</a> <span class="dropdown-menu shadow" x-placement="bottom-start">
                  @php $i = 1; @endphp
              @forelse($trades as $trade)
              @if($trade->cointwo == $cointwo)
              @if($i > 4)              
              <div class="dropdown-item tradingpair-link pb-1 text-center w200"><a style="background: transparent" href="{{ url('marketplace/'.$trade->coinone.'_'.$trade->cointwo) }}">{{ $trade->coinone.' / '.$trade->cointwo}}</a></div>
              @endif
              
              @php $i++; @endphp
              @endif
              @empty
              @endforelse
                
                                           </span> </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-md text-center" id="last_update_before_wrap" style="
              background-image: none;
              background-color: #0A2528;
            ">
            <div class="d-inline-block bgs20"> <i class="far fa-fw fa-clock bc-color-gray-dark position-relative bc-top-plus-1"></i> Data updated before:
              <div class="d-block d-lg-inline"> <span class="align-right font-weight-bold" id="last_update_before">{{ humanTiming(strtotime($selectPair->updated_at)) }}</span
                >
                
              </div>
            </div>
          </div>
          <div class="col-md text-center">
            <div class="d-inline-block">
              
              @if($cointwo == 'EUR')
              Current {{ $selectPair->coinonedetails['coinname'] }} price:
              <strong id="ticker_price" data-value="{{ display_format($selectPair->close,$selectPair->cointwo_decimal) }}"
                >€{{ display_format($selectPair->close,$selectPair->cointwo_decimal,2) }}</strong
              >
              @else
              Current exchange rate:
              <strong id="ticker_price" data-value="{{ display_format($selectPair->close,$selectPair->cointwo_decimal) }}"
                >{{ display_format($selectPair->close,$selectPair->cointwo_decimal,2) }} {{ $coinone.' / '.$cointwo }}</strong
              >
              @endif
              <div class="d-block d-lg-inline">(as of: {{ date('d/m/y h:i A',time())}})</div>
            </div>
          </div>
        </div>
        <div class="row d-block d-lg-none">
          <div class="col px-0">
            <div
              class="row no-gutters px-0 px-sm-3 px-md-0"
              id="marketplace_switch"
            >
              <div class="col">
                <a class="bc-bg-color-blue-light py-3 px-2 d-block" id="buyTab"
                  >Buy / Bid</a
                >
              </div>
              <div class="col">
                <a class="py-3 px-2 d-block" id="sellTab">Sell / Ask</a>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col px-0">
            <div class="card-deck-wrapper">
              <div class="card-deck">
                <div
                  class="card bc-card-marketplace bc-card-buy"
                  id="box_offers"
                >
                  <h2 class="card-header">
                    <span class="d-none d-lg-inline-block">Buy / Bid</span>
                <div class="buysell_price my-auto"> from: <strong>
                        <span id="rate_buy" data-rate="27700" style=""
                          >{{ display_format($selectPair->close,$selectPair->cointwo_decimal,2) }}</span>
                        
                        {{$cointwo}}
                      </strong> </div>
                </h2>
                <div class="card-form">
                  <div id="buystatus" style="display:none"></div>
                  <div id="buylimitmsg" class="text-center" style="color: red;"></div>
                  <div id="offer_form_div" class="p-2 bc-bg-color-blue-light">
                    <form action="/en/btceur/saveAsOrder" method="POST" id="trade_offer_form" data-search="0">
                      @csrf
                      <input type="hidden" placeholder="" class="input-xlarge" id="buypair" name="buypair" value="{{ $selectPair->id }}" >
                      <div class="bc-box_buy_sell_form">
                        <div class="form-group row no-gutters">
                          <label class="col-sm-4 col-form-label" for="search_offer_amount">Number of {{ $selectPair->coinonedetails['coinname'] }}</label>
                          <div class="col-sm-8">
                            <div class="input-group">
                              <input type="text" name="search_offer_amount" class="watchOfferInput form-control w-70" id="search_offer_amount" autocomplete="off" />
                              <div class="input-group-append w-30">
                                <div class="input-group-text">{{ $coinone }}</div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group row no-gutters">
                          <label class="col-sm-4 col-form-label" for="search_offer_critical_price">Purchase price (max.)</label>
                          <div class="col-sm-8">
                            <div class="input-group">
                              <input type="text" name="search_offer_critical_price" class="watchOfferInput form-control w-70" id="search_offer_critical_price" autocomplete="off" />
                              <div class="input-group-append w-30">
                                <div class="input-group-text">{{$cointwo}} / {{$coinone}}</div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group row no-gutters">
                          <label class="col-4 col-form-label">Volume</label>
                          <div class="col-8 py-2"> <strong id="offer_summe">---</strong> <strong>{{$cointwo}}</strong> <a class="ml-1 bc-dnone" id="reset_offer" href="#" onclick='form_reset("offer"); return false;'>(Reset)</a
                              >
                              
                    
                            </div>
                            
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                  <div class="card-body">
                    <div id="trade_offer_results">
                      <div class="table-responsive">
                        <table class="table table-striped table-shadow">
                          <thead id="offer_head" >
                            <tr style="background-color:#1D1D1D">
                              <th>Amount (min.)</th>
                              <th>{{$cointwo}} / {{$coinone}}</th>
                              <th>Volume</th>
                            
                              <th class="min-no-wrap">Buy</th>
                            </tr>
                          </thead>

                          <tbody
                            id="trade_offer_results_table_body"
                            class="fs14 buyTrade"
                          >
                          @forelse($selltrades as $selltrade)
                          @php if($cointwo == 'EUR') { 
                            $symbol = '€';
                          } else{ 
                            $symbol = ''; 
                          } @endphp
                            <tr
                              class=""
                              id="trade_id_265729864"
                              data-trade-id="{{ $selltrade->id }}"
                              data-order-id="{{ $selltrade->order_id }}"
                              data-critical-price-formatted="27,700.00"
                              data-critical-price="{{ $selltrade->price }}"
                              data-trade-type="offer"
                              data-amount="{{ $selltrade->remaining }}"
                              data-min-amount="0.05"
                              data-uid="0yybQZoNoQ8nfFW8rrI."
                            >
                              <td>{{ $selltrade->remaining }}</td>
                              <td>{{ $symbol.''.$selltrade->price }}</td>
                              <td>{{ $symbol.''.ncMul($selltrade->price,$selltrade->remaining) }}</td>
                            
                              <td>
                                <a
                                  class="bc-sbl"
                                  href="{{ url('p2pbuy/'.Crypt::encrypt($selltrade->id)) }}"
                                  >BUY</a
                                >
                              </td>
                            </tr>
                            @empty
                            <tr>
                              <td colspan="4">No Record found!</td>
                            </tr>
                            @endforelse
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  
                </div>
                <div
                  class="card bc-card-marketplace bc-card-sell d-none d-lg-inline-block"
                  id="box_orders"
                >
                  <h2 class="card-header">
                    <span class="d-none d-lg-inline-block">Sell / Ask</span>
                    <div class="buysell_price my-auto">
                      from:
                      <strong>
                        <span id="rate_sell" data-rate="27506.96" style=""
                          >{{ display_format($selectPair->close,$selectPair->cointwo_decimal,2) }}</span
                        >
                        {{$cointwo}}
                      </strong>
                    </div>
                  </h2>

                  <div class="card-form">
                    <div id="sellstatus" style="display:none"></div>
                    <div id="selllimitmsg" class="text-center" style="color: red;"></div>
                    <div id="order_form_div" class="p-2 bc-bg-color-blue-light">
                      <form
                        action="/en/btceur/saveAsOffer"
                        method="POST"
                        id="trade_order_form"
                        data-search="0"
                      >
                      @csrf
                        <input type="hidden" placeholder="" class="input-xlarge" id="sellpair" name="sellpair" value="{{ $selectPair->id }}" >
                        <div class="bc-box_buy_sell_form">
                          <div class="form-group row no-gutters">
                            <label
                              class="col-sm-4 col-form-label"
                              for="search_order_amount"
                              >Number of {{ $selectPair->coinonedetails['coinname'] }}</label
                            >
                            <div class="col-sm-8">
                              <div class="input-group">
                                <input
                                  type="text"
                                  name="search_order_amount"
                                  class="watchOrderInput form-control w-70"
                                  id="search_order_amount"
                                  autocomplete="off"
                                />
                                <div class="input-group-append w-30">
                                  <div class="input-group-text">{{ $coinone }}</div>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="form-group row no-gutters">
                            <label
                              class="col-sm-4 col-form-label"
                              for="search_order_critical_price"
                              >Sales price (min.)</label
                            >
                            <div class="col-sm-8">
                              <div class="input-group">
                                <input
                                  type="text"
                                  name="search_order_critical_price"
                                  class="watchOrderInput form-control w-70"
                                  id="search_order_critical_price"
                                  autocomplete="off"
                                />
                                <div class="input-group-append w-30">
                                  <div class="input-group-text">{{$cointwo}} / {{$coinone}}</div>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="form-group row no-gutters">
                            <label class="col-4 col-form-label">Volume</label>
                            <div class="col-8 py-2">
                              <strong id="order_summe">---</strong>
                              <strong>{{$cointwo}}</strong>
                              <a
                                class="fs13 ml-1 bc-dnone"
                                id="reset_order"
                                href="#"
                                onclick='form_reset("order"); return false;'
                                >(Reset)</a
                              >
                              <div class="text-center">
                         </div>
                    
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                  <div class="card-body sellcard">
                    <div id="trade_order_results">
                      <div class="table-responsive">
                        <table class="table table-striped table-shadow">
                          <thead id="order_head">
                            <tr style="background-color:#1D1D1D">
                              <th>Amount (min.)</th>
                              <th>{{$cointwo}} / {{$coinone}}</th>
                              <th>Volume</th>
                             
                              <th class="min-no-wrap">Sell</th>
                            </tr>
                          </thead>
                          <tbody
                            id="trade_order_results_table_body"
                            class="fs14 sellTrade"
                          >
                            @forelse($buytrades as $buytrade)
                            @php if($cointwo == 'EUR') { 
                              $symbol = '€';
                            } else{ 
                              $symbol = ''; 
                            } 
                            @endphp
                            <tr
                              class=""
                              id="trade_id_265729864"
                              data-trade-id="{{ $buytrade->id }}"
                              data-order-id="{{ $buytrade->order_id }}"
                              data-critical-price-formatted="27,700.00"
                              data-critical-price="{{ $buytrade->price }}"
                              data-trade-type="offer"
                              data-amount="{{ $buytrade->remaining }}"
                              data-min-amount="0.05"
                              data-uid="0yybQZoNoQ8nfFW8rrI."
                            >
                              <td>{{ $buytrade->remaining }}</td>
                              <td>{{ $symbol.''.$buytrade->price }}</td>
                              <td>{{ $symbol.''.ncMul($buytrade->price,$buytrade->remaining) }}</td>
                            
                              <td>
                                <a
                                  class="bc-sbl"
                                  href="{{ url('p2psell/'.Crypt::encrypt($buytrade->id)) }}"
                                  >Sell</a
                                >
                              </td>
                            </tr>
                            @empty
                            <tr>
                              <td colspan="4">No Record found!</td>
                            </tr>
                            @endforelse
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>

                  
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

     

      
      <div class="dnone" id="hidden_order_trades"></div>
    
     
      
      <div class="dnone" id="hidden_order_trades"></div>
   
    </main>
    @include('layouts.footermenu')
    </div>
        @include('layouts.footer')
      <script>
      $("body").addClass("tradepagebg");
      </script>
      <script
        type="text/javascript"
        src="{{url('js-min/key/ed0ba9a577bf062e2993a4ceac00fd72c16430dc/t/1643194364.js')}}"
      ></script>


      <script type="text/javascript">
        var search_url_offer = "/en/btceur/offerSearch";
        var search_url_order = "/en/btceur/orderSearch";
        var url_trade_multiply = "/en/btceur/tradeMultiply";
        var clear_offer_results = false;
        var clear_order_results = false;

        function changeSorting(field, id_prefix, type) {
          var $current_sorting = $("#" + id_prefix + type + "_" + "sort_field");
          var $current_sort_direction = $(
            "#" + id_prefix + type + "_" + "sort_direction"
          );

          var current_sorting_value = $current_sorting.val();
          var current_sort_direction_value = $current_sort_direction.val();

          var sort_image_asc = $(
            '<img class="mbm3" src="/images/arrow-090-small.png" />'
          );
          var sort_image_desc = $(
            '<img class="mbm3" src="/images/arrow-270-small.png" />'
          );

          var sort_image = sort_image_asc;

          if (current_sorting_value == field) {
            // richtung ändern
            sort_image =
              1 == current_sort_direction_value
                ? sort_image_desc
                : sort_image_asc;
            $("#" + id_prefix + type + "_" + "sort_direction").val(
              1 == current_sort_direction_value ? 2 : 1
            );
          } else {
            $current_sorting.val(field);
            $current_sort_direction.val(1);
          }

          $("." + type + "_sort_image").empty();
          $("#" + type + "_" + field + "_sort_image").append(sort_image);

          initSearch(type);
          doSearch(type);

          return false;
        }

        function form_reset(type) {
          showIndicator();
          if ("offer" == type) {
            $("#box_offers").load("/en/btceur/resetOfferForm", function () {
              hideIndicator();
            });
          } else {
            $("#box_orders").load("/en/btceur/resetOrderForm", function () {
              hideIndicator();
            });
          }
        }

        var ajax_manager;
        $(function () {
          //create an ajaxmanager named someAjaxProfileName
          ajax_manager = $.manageAjax.create("tradeSearch", {
            queue: "clear",
            abortOld: true,
          });

          $("#search_offer_amount").attr("autocomplete", "off");
          $("#search_order_amount").attr("autocomplete", "off");

          $("#search_offer_critical_price").attr("autocomplete", "off");
          $("#search_order_critical_price").attr("autocomplete", "off");

          $("#marketplace_switch a").on("click", function () {
            var id = $(this).attr("id");
            if (id === "buyTab") {
              
              $other = $("#sellTab");
              $showTab = $(".bc-card-buy");
              $hideTab = $(".bc-card-sell");
            } else {
              $other = $("#buyTab");
              $showTab = $(".bc-card-sell");
              $hideTab = $(".bc-card-buy");
            }

            $other.removeClass("bc-bg-color-blue-light");
            $(this).addClass("bc-bg-color-blue-light");
            $showTab.removeClass("d-none d-lg-inline-block");
            $hideTab.addClass("d-none d-lg-inline-block");
          });
        });

        

        $(".more_sarrow").on("click", function () {
          $(this).toggleClass("active");
          var id = $(this).attr("id");
          $("#more_payment_methods_trade_" + id).toggle();
        });

     

        function rebuildOrders(trade_row, type, amount, price) {
          var current_sort_direction = $(
            "#search_" + type + "_" + "sort_direction"
          ).val();
          var current_sorting = $("#search_" + type + "_" + "sort_field").val();

          $("#trade_" + type + "_results_table_body tr.no_result").remove();
          $("#trade_" + type + "_results_table_body").append(trade_row);

          sort_fields = {};
          if ("offer" == type) {
            sort_fields["critical_price"] = "ASC";
          } else {
            sort_fields["critical_price"] = "DESC";
          }

          if ("amount" == current_sorting) {
            sort_fields["amount"] = current_sort_direction;
          }

          var sorted = $("#trade_" + type + "_results_table_body tr")
            .toArray()
            .sort(function (a, b) {
              return tradeSorter(a, b, sort_fields);
            });

          $("#trade_" + type + "_results_table_body").empty();

          $.each(sorted, function (index, value) {
            $("#trade_" + type + "_results_table_body").append(value);
          });

          var $trades = $("#trade_" + type + "_results_table_body tr");
          var last_trade_value = parseFloat(
            $trades
              .filter(":visible:last")
              .attr(
                "amount" === current_sorting
                  ? "data-amount"
                  : "data-critical-price"
              )
          );
          var new_trade_value = parseFloat(
            "amount" === current_sorting ? amount : price
          );
          var last_trade_order_direction = sort_fields["critical_price"];

          if ("amount" === current_sort_direction) {
            last_trade_order_direction =
              1 == current_sort_direction ? "ASC" : "DESC";
          }

          if ("offer" === type) {
            b_has_additional_trades_reloaded =
              b_has_additional_offer_trades_reloaded;
          } else {
            b_has_additional_trades_reloaded =
              b_has_additional_order_trades_reloaded;
          }

          if (
            ("DESC" === last_trade_order_direction &&
              last_trade_value < new_trade_value) ||
            ("ASC" === last_trade_order_direction &&
              last_trade_value > new_trade_value) ||
            $trades.length < 25
          ) {
            resetUpdateCounter();
            trade_row.removeClass("bc-dnone").highlight(2000);
            updateRate();
          }

          if (false === b_has_additional_trades_reloaded) {
            $trades.filter(":visible:gt(24)").addClass("bc-dnone");
            $trades.filter(":hidden:gt(19)").remove();
          }
        }

        function removeOrder(id, type) {
          var remove_callback = function () {
            $(this).remove();
            updateRate();
            var $trades = $("#trade_" + type + "_results_table_body tr");

            if (25 > $trades.filter(":visible").length) {
              $trades
                .filter(":hidden:first")
                .removeClass("bc-dnone")
                .highlight(2000);
            }

            if (
              0 === $("#trade_" + type + "_form").data("search") &&
              10 >= $trades.length
            ) {
              $.ajax({
                type: "GET",
                url: "/en/btceur/loadMarketOffers",
                context: $("#trade_" + type + "_results_table_body"),
                data: { type: type },
                dataType: "html",
              }).done(function (msg) {
                $(this).empty().append(msg);
              });
            }
          };

          $trade = $("#trade_id_" + id);

          if (true === $trade.is(":visible")) {
            $trade.toggle("highlight", 500, remove_callback);
          } else {
            $trade.addClass("bc-dnone", remove_callback);
          }
        }

        function resetUpdateCounter() {
          secs_since_last_change = 0;
          $("#last_update_before").text("0");
          $("#last_update_before_wrap").highlight(2000);
        }

        function updateRate() {
          var $rate_buy = $("#rate_buy");
          var $rate_sell = $("#rate_sell");

          var $first_offer = $("#trade_offer_results_table_body tr:first");
          var $first_order = $("#trade_order_results_table_body tr:first");

          if (
            parseFloat($rate_buy.attr("data-rate")) !=
            parseFloat($first_offer.attr("data-critical-price"))
          ) {
            $rate_buy
              .text($first_offer.attr("data-critical-price-formatted"))
              .attr("data-rate", $first_offer.attr("data-critical-price"))
              .highlight(2000);
          }

          if (
            parseFloat($rate_sell.attr("data-rate")) !=
            parseFloat($first_order.attr("data-critical-price"))
          ) {
            $rate_sell
              .text($first_order.attr("data-critical-price-formatted"))
              .attr("data-rate", $first_order.attr("data-critical-price"))
              .highlight(2000);
          }
        }
      </script>
<script language="javascript" type="text/javascript" >
var coinOneDecimal = {{ $selectPair->coinone_decimal }};
  var coinTwoDecimal = {{ $selectPair->cointwo_decimal }};

$('#search_offer_amount , #search_offer_critical_price').on('keyup', function(){
  buycal();
  callBuyFilter();
});

$('#search_order_amount, #search_order_critical_price').on('keyup', function(){
  sellcal();
  callSellFilter();
});

function buycal(){
  var buyprice = parseFloat($('#search_offer_critical_price').val());
  var buyvolume = parseFloat($('#search_offer_amount').val());
  var buytotal = parseFloat(buyprice) * parseFloat(buyvolume);
  var buyfee    = parseFloat(buytotal) * parseFloat({{ $selectPair->buy_trade }});    
  //buytotal = parseFloat(buytotal) + parseFloat(buyfee);
  var points    = parseFloat(coinTwoDecimal) + 1;


  buytotal = parseFloat(buytotal).toFixed(coinTwoDecimal);

  buyfee = parseFloat(buyfee).toFixed(coinTwoDecimal);


  if(buytotal > 0){
    $('#offer_summe').html(buytotal);
  } else {
    $('#offer_summe').html(0);
  }
}

function sellcal() {
  var sellprice = parseFloat($('#search_order_critical_price').val());
  var sellvolume = parseFloat($('#search_order_amount').val());
  var sellfee    = parseFloat(sellvolume) * parseFloat({{ $selectPair->sell_trade }});
  var selltotal = parseFloat(sellvolume) * parseFloat(sellprice);

  selltotal = parseFloat(selltotal).toFixed(coinTwoDecimal+1);


  if(selltotal > 0){
    $('#order_summe').html(selltotal.slice(0,-1));
  } else {
    $('#order_summe').html('---');
  }
}
function callBuyFilter(){
  $.ajax({
    type: "POST",
    url: '{{ route("filterSellTrade") }}',
    data: $("#trade_offer_form").serialize(),
    }).done(function( result ) {      
      $('#trade_offer_results_table_body').html(result);
  });
}
function callSellFilter(){
  $.ajax({
    type: "POST",
    url: '{{ route("filterBuyTrade") }}', 
    data: $("#trade_order_form").serialize(),
    }).done(function( result ) {      
      $('#trade_order_results_table_body').html(result);
  });
}
</script>