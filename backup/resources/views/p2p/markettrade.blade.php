@php 
$title = "P2P - $coinone/$cointwo | Buy and Sell $coinone with $cointwo on PantherExchange P2P"; 
$atitle ="market-place";
if($cointwo == 'INR') { 
  $image = url('images/color/inr.svg');
  $symbol = "<img src='".$image."' class='symbols' />";
} else{ 
  $symbol = ''; 
}
@endphp
@include('layouts.header')
<link rel="stylesheet" type="text/css" href="{{url('css/wazrix.css')}}" />
<style>
  .symbols {
    width: 13px;
    margin-right: 1px;
}
</style>
<div class="pagecontent gridpagecontent innerpagegrid">
  @include('layouts.headermenu')
</section>
<article class="gridparentbox">
  <div class="container sitecontainer">
    <section>
      <main>
       <div class="top-header">
        <div class="top-part" style="max-width: 1138px; position: relative">
          <div class="left_part">

            <div class="p1">'
              <div class="p1-text">P2P-{{$coinone}}/{{$cointwo}}</div></div>

            </div>

          </div>
        </div>
        
      </main>
    </section>

    <section class="order-book-table">
      <div class="contain-width">

        <div class="row">
        <div class="col-sm-12 col-md-12 col-xl-4 col-lg-4">
        
        <div class="tab-menu">
              <ul>
                 <li><a href="#" class="tab-a active-a" data-id="tab1">Market Depth</a></li>
               
              </ul>
           </div><!--end of tab-menu-->


           <div  class="tab tab-active" data-id="tab1">
            <div class="table-direction">
            <table class="table market-depth-table">
              <thead>
                <th class="table-head">Volume</th>
                <th class="table-head">Buy price</th>
                
              </thead>

              <tbody id="market_B">                


              </tbody>
            </table>

            <table class="table market-depth-table">
              <thead>
                <th class="table-head">Sell price</th>
                <th class="table-head">Volume</th>
              </thead>

              <tbody id="market_S">
                


              </tbody>
            </table>
            </div>
           
                 
           </div><!--end of tab one--> 
        

           <div  class="tab " data-id="tab2">
           <div class="table-direction">
           <table class="table market-depth-table">
              <thead>
                <th class="table-head">Volume %</th>
                <th class="table-head">Buy price</th>
               
              </thead>

              <tbody id="market_S1">
                <tr>
                  <td data-label="Volume">55.43</td>
                  <td data-label="Buy price" class="green-num">90.20</td>
                 
                 
                </tr>
            
                <tr>
                  <td data-label="Volume">677.88</td>
                  <td data-label="Buy price" class="green-num">90.20</td>
                  
                 </tr>
            
                <tr>
                  <td data-label="Volume">727.88</td>
                  <td data-label="Buy price" class="green-num">90.00</td>
                  
                </tr>
            
                <tr>
                  <td data-label="Volume">907.13</td>
                  <td data-label="Buy price" class="green-num">90.00</td>
                 
                </tr>
                <tr>
                  <td data-label="Volume">55.43</td>
                  <td data-label="Buy price" class="green-num">1,839.22</td>
                 
                </tr>

                <tr>
                  <td data-label="Volume">55.43</td>
                  <td data-label="Buy price" class="green-num">89.50</td>
                
                </tr>

                <tr>
                  <td data-label="Volume">55.43</td>
                  <td data-label="Buy price" class="green-num">91.05</td>
                  
                </tr>


              </tbody>
          </table>

          <table class="table market-depth-table">
              <thead>
                
                <th class="table-head">Sell price</th>
                <th class="table-head">Volume</th>
              </thead>

              <tbody id="market_S1">
                <tr>
                   <td data-label="Sell price" class="red-num">90.59</td>
                  <td data-label="Volume">2,678.24</td>
              
                </tr>
            
                <tr>
                  <td data-label="Sell price" class="red-num">90.60</td>
                  <td data-label="Volume">3,332.47</td>
                 </tr>
            
                <tr>
                  <td data-label="Sell price" class="red-num">90.64</td>
                  <td data-label="Volume">3,401.65</td>
                </tr>
            
                <tr>
                 <td data-label="Sell price" class="red-num">90.74</td>
                  <td data-label="Volume">3,386.28</td>
                </tr>
                <tr>
                  <td data-label="Sell price" class="red-num">90.64</td>
                  <td data-label="Volume">3,462.84</td>
                </tr>

                <tr>
                  <td data-label="Sell price" class="red-num">90.74</td>
                  <td data-label="Volume">3,470.84</td>
                </tr>

                <tr>
                   <td data-label="Sell price" class="red-num">89.01</td>
                  <td data-label="Volume">2,864.03</td>
                </tr>


              </tbody>
          </table>
           </div>
        
           </div><!--end of tab two--> 
              
     
    </div>

        
        <div class="col-sm-12 col-md-12 col-xl-4 col-lg-4">
          <h5 class="match-txt">Match History</h5>
          <table class="table match-his">
            <thead>
              <th class="table-head">Price</th>
              <th class="table-head">Volume</th>
              <th class="table-head">Time</th>

            </thead>
            <tbody id="matchhistroy">
              
            </tbody>
          </table>
        </div>

        <div class="col-sm-12 col-lg-4 col-md-12 col-xl-4">
          <div overflow="hidden" height="352px" class="sc-gsTEea ustd-button">
            <div height="56px" class="sc-gsTEea grp-button">
              <div class="sc-gsTEea sc-hYZPxA  known-video irHXoL">
                <select class="hvpiJG select-dropdown" onchange="location = this.value;">                          
                    @forelse($trades as $trade)
                    <option  value="{{url('marketplace/'.$trade->coinone.'_'.$trade->cointwo)}}" @if($coinone.$cointwo == $trade->coinone.$trade->cointwo) selected @endif>{{$trade->coinone.'/'.$trade->cointwo}}</option>                           
                    @empty
                    @endforelse
                </select>


              </div>
              <div class="sc-gsTEea sc-cHjwLt  known-video keSexs">{!! $symbol !!}90</div></div>
              <div class="sc-gsTEea gIthqj"><span font-size="20px" color="var(--color-text-l0)" class="sc-bdfBQB kOQuca">P2P Markets</span>
                <span font-size="12px" color="var(--color-text-l1)" class="sc-bdfBQB jaGfxD">Use PantherExchange P2P when you want to buy {{$coinone}} to trade cryptos, or when you want to sell {{$coinone}} and cash out to {{$cointwo}}. It's safe and hassle free!</span>
                <div class="sc-edoYdd jXXMqd">How it works</div>

                <img src="{{ url('img/how-it-works.svg') }}" alt="how-it-works" class="works">
                <div class="sc-gsTEea ObOWG">
                  <div class="sc-gsTEea iwbTIv"><a href="#" target="_blank" rel="noopener noreferrer" class="know-more">Know more</a></div>
                  <div class="sc-gsTEea bvSUnn"><a class="sc-iWRHom know-more">
                    <div class="sc-gsTEea  known-video"><i class="sc-hYAvtR bQYeKg mdi mdi-arrow-right-drop-circle-outline"></i>Video Tutorials</div>
                  </a>
                </div>
              </div>
            </div>
          </div>

        </div>

      </div>
    </div>
  </section>





  <section class="login-sctn">
    <div class="contain-width">
     <div class="row">
     
    <div class="col-sm-12 col-lg-4 col-md-12 col-xl-4">

   <div class="panelcontentbox">
      <div class="innerpagetab historytab">
							<ul class="nav nav-tabs tabbanner" role="tablist">
															<li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#USDTmarket" data-bs-target="#USDTmarket">Buyers</a></li>
																<li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#MATICmarket" data-bs-target="#MATICmarket">Seller</a></li>
							
							</ul>
			</div>

			<div class="tab-content">
					<div id="USDTmarket" class="tab-pane  active">
							<div class="table-responsive sitescroll" data-simplebar="init"><div class="simplebar-track vertical" style="visibility: hidden;"><div class="simplebar-scrollbar" style="visibility: visible; top: 0px; height: 443px;"></div></div><div class="simplebar-track horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="visibility: visible; left: 0px; width: 102px;"></div></div><div class="simplebar-scroll-content" style="padding-right: 17px; margin-bottom: -34px;"><div class="simplebar-content" style="padding-bottom: 17px; margin-right: -17px;">
							<table class="table sitetable">
          <thead>
              <th>Buy Price</th>
              <th>Volume</th>
              <th>XID</th>
             
            </thead>
            <tbody>
              @forelse($buytrades as $buytrade)
              <tr onclick="sellRow({{$buytrade->price}},{{$buytrade->remaining}})">
              <td data-label="Buy Price"  class="green-num">{!! $symbol !!} {{ $buytrade->price }}</td>
              <td data-label="Volume">{{ $buytrade->remaining }}</td>
              <td data-label="XID">{{ $buytrade->xid }}</td>
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
	    	<div id="MATICmarket" class="tab-pane">
										<div class="table-responsive sitescroll" data-simplebar="init"><div class="simplebar-track vertical" style="visibility: hidden;"><div class="simplebar-scrollbar" style="visibility: visible; top: 0px; height: 129px;"></div></div><div class="simplebar-track horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="visibility: visible; left: 0px; width: 109px;"></div></div><div class="simplebar-scroll-content" style="padding-right: 17px; margin-bottom: -34px;"><div class="simplebar-content" style="padding-bottom: 17px; margin-right: -17px;">
											<table class="table sitetable">
                      <thead>
                <th>Sell Price</th>
                <th>Volume</th>
                <th>XID</th>
              
               </thead>
               <tbody>
              @forelse($selltrades as $selltrade)
              <tr onclick="buyRow({{$selltrade->price}},{{$selltrade->remaining}})">
              <td data-label="Sell Price"  class="red-num">{!! $symbol !!}{{ $selltrade->price }}</td>
              <td data-label="Volume">{{ $selltrade->remaining }}</td>
              <td data-label="XID">{{ $selltrade->xid }}</td>
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

    <div class="col-sm-12 col-lg-4 col-md-12 col-xl-4">      
      <ul class="tabs open-orders">
        <li data-num=".one" class="active open-box">Open Orders</li>
        <li data-num=".two" class="open-box">Completed Orders</li>

      </ul>
      @guest
      <div class="content">
        <div class="one active">          
         <a class="login-txt" href="{{route('login')}}">Login</a>
         <a class="accnt-txt" href="{{route('register')}}">Create a account</a>
       </div>
       <div class="two">
        <a class="login-txt" href="{{route('login')}}">Login</a>
        <a class="accnt-txt" href="{{route('register')}}">Create a account</a>        
      </div>
      </div>
      @else
       <div class="content">
      <div class="one active"> 
      <table class="table market-depth-table">
                <thead>
                  <th class="table-head">PAIR</th>
                  <th class="table-head">QUANTITY</th>
                  <th class="table-head">PRICE</th>
                  <th class="table-head">PENDING ACTIONS</th>
                </thead>

                <tbody>
                  @forelse($opentrades as $opentrade)
                  <tr class="my-orders-{{ strtolower($opentrade->trade_type) }}">
                    <td class="my-orders"><span class="underline">{{$opentrade->pairDetails['coinone']}}</span><span class="subtext">{{$opentrade->pairDetails['cointwo']}}</span></td>
                    <td class="my-orders"><span class="underline">{{ $opentrade->volume }}</span><span class="subtext">{{ $opentrade->remaining }}</span> </td>
                    <td>{{ $opentrade->price }}</td>
                    <td><a href="{{ url('/p2p-matchorder/'.$opentrade->order_id) }}"> <span class="badge badge-warning">{{ $opentrade->status_text }}</span></a></td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="6">No record found</td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
        </div>
      <div class="two">
      <table class="table market-depth-table">
                <thead>
                  <th class="table-head">PAIR</th>
                  <th class="table-head">QUANTITY</th>
                  <th class="table-head">PRICE</th>
                  <th class="table-head">STATUS</th>
                </thead>

                <tbody>
                   @forelse($completetrades as $completetrade)
                  <tr class="my-orders-{{ strtolower($completetrade->trade_type) }}">
                    <td class="my-orders"><span class="underline">{{$completetrade->pairDetails['coinone']}}</span><span class="subtext">{{$completetrade->pairDetails['cointwo']}}</span></td>
                    <td class="my-orders"><span class="underline">{{ $completetrade->volume }}</span><span class="subtext">{{ $completetrade->remaining }}</span> </td>
                    <td>{{ $completetrade->price }}</td>

                    <td><a href="{{ url('/p2p-matchorder/'.$completetrade->order_id) }}"> <span class="badge @if($completetrade->status == 100) badge-success @else badge-danger @endif">{{ $completetrade->status_text }}</span></a></td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="6">No record found</td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
        </div>
        </div>
      @endguest
    
    
      </div>

      <div class="col-sm-12 col-lg-4 col-md-12 col-xl-4">
        @if (session('success'))
            <div class="alert alert-success">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              {{ session('success') }}
          </div>
          @endif
          @if (session('error'))
          <div class="alert alert-danger">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              {{ session('error') }}
          </div>
          @endif
        <div class="form-details">

          <button class="tablinksz" onclick="openPage('Home', this)" id="defaultOpen">Buy</button>
          <button class="tablinksz" onclick="openPage('News', this)" >Sell</button>
          
          <div id="Home" class="tabcontentsz">
           <!-- <input placeholder="0.00" class="price-input"> -->
           <div class="sc-gsTEea sc-eltbHq input-flex jOIKUb">
            <div class="sc-gsTEea sc-cKZGGw input-flex inr-price">
              <span class="sc-bdfBQB price-txt">Price</span><span class="sc-bdfBQB inr-txt">{{$cointwo}}</span>
            </div>
            <input id="buyprice"  type="number" placeholder="" onkeypress="return AvoidSpace(event)" class="input-box input-pad" name="buyprice" step="0.000001" min="0" max="100000000" >
          </div>

          <div class="sc-gsTEea sc-eltbHq input-flex jOIKUb">
            <div class="sc-gsTEea sc-cKZGGw input-flex inr-price">
              <span class="sc-bdfBQB price-txt">Volume</span><span class="sc-bdfBQB inr-txt">{{$coinone}}</span>
            </div>
            <input id="buyvolume" type="number" onkeypress="return AvoidSpace(event)" class="input-box input-pad" name="buyvolume" step="0.000001" min="0" max="100000000" placeholder="0.0" autocapitalize="off" autocomplete="off" spellcheck="false" autocorrect="off" inputmode="decimal">
          </div>

          <div class="sc-gsTEea sc-eltbHq input-flex jOIKUb">
            <div class="sc-gsTEea sc-cKZGGw input-flex inr-price">
              <span class="sc-bdfBQB price-txt">Total</span><span class="sc-bdfBQB inr-txt">{{$cointwo}}</span>
            </div>
            <input type="text" placeholder="0.0" autocapitalize="off" autocomplete="off" spellcheck="false" autocorrect="off" inputmode="decimal" class="input-box input-pad" id="buytotal" >
          </div>
          @if(Auth::user()->xid != '')
          <button class="btn btn-block sitebtn green-btn" data-bs-toggle="modal" data-bs-target="#createbuytrade">Buy</button>
          @else
          <button class="buy-btn" data-bs-toggle="modal" data-bs-target="#createxid" class="btn btn-default">Buy</button>
          @endif
          
       </div>

       <div id="News" class="tabcontentsz">
        <div class="sc-gsTEea sc-eltbHq input-flex jOIKUb">
          <div class="sc-gsTEea sc-cKZGGw input-flex inr-price">
            <span class="sc-bdfBQB price-txt">Price</span><span class="sc-bdfBQB inr-txt">{{$cointwo}}</span>
          </div>
          <input type="number" placeholder="Price"  onkeypress="return AvoidSpace(event)" class="input-box input-pad" id="sellprice" name="sellprice" required="required" step="0.0001" min="0" max="1000000" value="{{ $selectPair->close }}">
        </div>

        <div class="sc-gsTEea sc-eltbHq input-flex jOIKUb">
          <div class="sc-gsTEea sc-cKZGGw input-flex inr-price">
            <span class="sc-bdfBQB price-txt">Volume</span><span class="sc-bdfBQB inr-txt">{{$coinone}}</span>
          </div>
          <input type="number" placeholder="" onkeypress="return AvoidSpace(event)" class="input-box input-pad" id="sellvolume" name="sellvolume"  required="required" step="0.0001" min="0" max="1000000" utocomplete="off" spellcheck="false" autocorrect="off" inputmode="decimal">
        </div>

        <div class="sc-gsTEea sc-eltbHq input-flex jOIKUb">
          <div class="sc-gsTEea sc-cKZGGw input-flex inr-price">
            <span class="sc-bdfBQB price-txt">Total</span><span class="sc-bdfBQB inr-txt">{{$cointwo}}</span>
          </div>
          <input type="text" placeholder="0.0" autocapitalize="off" autocomplete="off" spellcheck="false" autocorrect="off" inputmode="decimal" class="input-box input-pad" id="selltotal" name="selltotal" >
        </div>

        @if(Auth::user()->xid != '')
          <button class="btn btn-block sitebtn red-btn" data-bs-toggle="modal" data-bs-target="#createselltrade">Sell</button>
          @else
          <button class="btn btn-block sitebtn red-btn" data-bs-toggle="modal" data-bs-target="#createxid">Sell</button>
          @endif     
        
     </div> 
   </div>

 </div>
</div>
</div>
</div>
</section>
</div>
</article>
<!-- modal popup   -->
<div class="modal fade modalbgt" id="createbuytrade">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Buy {{$coinone}} For {{$cointwo}}</h4>
        <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div id="buymarketmsg"> </div>
        <table class="table">
          <tbody>
            <tr>
              <td data-label="Sell Price">At Price</td>
              <td data-label="Volume">{!! $symbol !!} <span id="buyprice_dis"> 92 </span></td>
            </tr>

            <tr>
              <td data-label="Sell Price">Volume</td>
              <td data-label="Volume"><span id="buyvolume_dis"> 00 </span> {{$coinone}}</td>
            </tr>

            <tr>
              <td data-label="Sell Price">Total</td>
              <td data-label="Volume">{!! $symbol !!} <span id="buytotal_dis"> 00 </span></td>
            </tr>

            <tr>
              <td data-label="Sell Price">Fee: <span id="buyfee_dis"> 00 </span>%</td>
            </tr>

          </tbody>
        </table>
      <form class="siteformbg" id="buymarket" autocomplete="off">
        @csrf
        <div class="form-group">
          <input type="hidden" name="buypair"  value="{{ $selectPair->id }}" required="required">
          <input type="hidden" id="buy_price" name="search_offer_critical_price"  required="required">
          <input type="hidden" id="buy_quantity" name="search_offer_amount"  required="required">
        </div>
        <div class="form-group mt-2 text-center">
          <input type="button" class="btn sitebtn" id="buymarket_submit" value="Confirm to buy" />
        </div>  
      </form>
      </div>      
    </div>
  </div>
</div>
<div class="modal fade modalbgt" id="createselltrade">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Sell {{$coinone}} For {{$cointwo}}</h4>
        <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div id="sellmarketmsg"> </div>
        <table class="table">
          <tbody>
            <tr>
              <td data-label="Sell Price">At Price</td>
              <td data-label="Volume">{!! $symbol !!} <span id="sellprice_dis"> 92 </span></td>
            </tr>

            <tr>
              <td data-label="Sell Price">Volume</td>
              <td data-label="Volume"><span id="sellvolume_dis"> 00 </span> {{$coinone}}</td>
            </tr>

            <tr>
              <td data-label="Sell Price">Total</td>
              <td data-label="Volume">{!! $symbol !!} <span id="selltotal_dis"> 00 </span></td>
            </tr>

            <tr>
              <td data-label="Sell Price">Fee: <span id="sellfee_dis"> 00 </span>%</td>
            </tr>

          </tbody>
        </table>
      <form class="siteformbg" id="sellmarket" autocomplete="off">
        @csrf
        <div class="form-group">
          <input type="hidden" name="sellpair"  value="{{ $selectPair->id }}" required="required">
          <input type="hidden" id="sell_price" name="search_order_critical_price"  required="required">
          <input type="hidden" id="sell_quantity" name="search_order_amount"  required="required">
        </div>
        <div class="form-group mt-2 text-center">
          <input type="button" class="btn sitebtn" id="sellmarket_submit" value="Confirm to sell" />
        </div>  
      </form>
      </div>      
    </div>
  </div>
</div>

<div class="modal fade modalbgt" id="createxid">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Create Your XID</h4>
        <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <ul class="xid-body-username-confirmation-message-list">
          <li>XID helps you find high volume P2P traders</li>
          <li>Create &amp; share your XID everywhere</li>
          <li>Get matched instantly with other traders</li></ul>
      <form class="siteformbg" action="{{ url('update-xid') }}" id="theform" method="post" autocomplete="off">
        @csrf
        <div class="form-group">
          <input type="text" name="xid" class="form-control @error('xid') is-invalid @enderror" placeholder="eg: cryptotrader" required="required">
          @error('xid')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror 
        </div>
        <div class="form-group mt-2 text-center">
          <input type="submit" class="btn sitebtn" value="Create XID" />
        </div>  
      </form>
      </div>      
    </div>
  </div>
</div>
@include('layouts.footermenu')
</div>
@include('layouts.footer')   
<script>
  function openCity(evt, cityName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
     tabcontent[i].style.display = "none";
   }
   tablinks = document.getElementsByClassName("tablinks");
   for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}
</script>


<script>
  let list = document.querySelectorAll("ul li");
  let content = Array.from(document.querySelectorAll(".content div"));


  list.forEach((li) => {
    li.addEventListener("click", (e) => {

      list.forEach((li) => {
        li.classList.remove("active");
        e.currentTarget.classList.add("active");
      });

      content.forEach((div) => {
        div.classList.remove("active");
        document
        .querySelector(e.currentTarget.dataset.num)
        .classList.add("active");
      });
    });
  });

</script>

<script>
  function openPage(pageName,elmnt,color) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontentsz");
    for (i = 0; i < tabcontent.length; i++) {
      tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinksz");
    for (i = 0; i < tablinks.length; i++) {
      tablinks[i].style.backgroundColor = "";
    }
    document.getElementById(pageName).style.display = "block";
    elmnt.style.backgroundColor = "rgb(238 239 243)";
  }


  document.getElementById("defaultOpen").click();
</script>


<script>
  $(document).ready(function(){ 
    $('.tab-a').click(function(){  
      $(".tab").removeClass('tab-active');
      $(".tab[data-id='"+$(this).attr('data-id')+"']").addClass("tab-active");
      $(".tab-a").removeClass('active-a');
      $(this).parent().find(".tab-a").addClass('active-a');
    });
  });
</script>

<script>
  $(".Click-here").on('click', function() {
    $(".custom-model-main").addClass('model-open');
  }); 
  $(".close-btn, .bg-overlay").click(function(){
    $(".custom-model-main").removeClass('model-open');
  });
// TAB
  $(document).on('click', '.tab-wrap ul li a', function (e) {
    var curTabContentId = $(this).attr('href');    $(this).parents('.tab-wrap').find('ul li').removeClass('active');    $(this).parents('li').addClass('active');
    $(this).parents('.tab-wrap').find('.tab-content-id').removeClass('active');
    $(curTabContentId).addClass("active");
    e.preventDefault();
  });

  $('.modal').on('shown.bs.modal', function() {
  $(this).css("z-index", parseInt($('.modal-backdrop').css('z-index')) + 1);
});
</script>

<script language="javascript" type="text/javascript" >
var coinOneDecimal = {{ $selectPair->coinone_decimal }};
var coinTwoDecimal = {{ $selectPair->cointwo_decimal }};

$('#buyvolume , #buyprice').on('keyup', function(){
  buycal();
});

$('#sellvolume, #sellprice').on('keyup', function(){
  sellcal();
});
$('#buytotal').on('keyup', function(){
  buyTotalcal();
});
$('#selltotal').on('keyup', function(){
  sellTotalcal();
});

function buycal(){
  var buyprice = parseFloat($('#buyprice').val());
  var buyvolume = parseFloat($('#buyvolume').val());
  var buytotal = parseFloat(buyprice) * parseFloat(buyvolume);
  var buyfee    = parseFloat(buytotal) * parseFloat({{ $selectPair->buy_trade }});
  var points    = parseFloat(coinTwoDecimal) + 1;


  buytotal = parseFloat(buytotal).toFixed(coinTwoDecimal);

  buyfee = parseFloat(buyfee).toFixed(coinTwoDecimal);


  if(buytotal > 0){
    document.getElementById('buytotal').value = buytotal;
    document.getElementById('buy_price').value = buyprice;
    document.getElementById('buy_quantity').value = buyvolume;
    $('#buyfees').html(buyfee);
    $('#buytotal').html(buytotal);

    $('#buyprice_dis').html(buyprice);
    $('#buyvolume_dis').html(buyvolume);
    $('#buytotal_dis').html(buytotal);
  } else {
    $('#buyfees').html(0);
    document.getElementById('buytotal').value = 0;
  }
}
function buyTotalcal(){
  var buyprice = parseFloat($('#buyprice').val());
  if(buyprice > 0){

  }else{
    var buyprice = parseFloat($('#lastprice').text().trim());
  }
  
  var buytotal = parseFloat($('#buytotal').val());
  var buyvolume = parseFloat(buytotal) / parseFloat(buyprice);
  var buyfee    = parseFloat(buytotal) * parseFloat({{ $selectPair->buy_trade }});    
  buytotal = parseFloat(buytotal) + parseFloat(buyfee);
  var points    = parseFloat(coinTwoDecimal) + 1;


  buyvolume = parseFloat(buyvolume).toFixed(coinTwoDecimal);

  buyfee = parseFloat(buyfee).toFixed(coinTwoDecimal);


  if(buyvolume > 0){
    document.getElementById('buyvolume').value = buyvolume;
    document.getElementById('buyprice').value = buyprice;

    document.getElementById('buy_price').value = buyprice;
    document.getElementById('buy_quantity').value = buyvolume;

    $('#buyfees').html(buyfee);

    $('#buyprice_dis').html(buyprice);
    $('#buyvolume_dis').html(buyvolume);
    $('#buytotal_dis').html(buytotal);

  } else {
    $('#buyfees').html(0);
    document.getElementById('buyvolume').value = 0;
    document.getElementById('buyprice').value = buyprice;
  }
}
function sellTotalcal(){
  var sellprice = parseFloat($('#sellprice').val());
  if(sellprice > 0){

  }else{
    var sellprice = parseFloat($('#lastprice').text().trim());
  }
  var selltotal = parseFloat($('#selltotal').val());
  var sellvolume = parseFloat(selltotal) / parseFloat(sellprice);
  var sellfee    = parseFloat(selltotal) * parseFloat({{ $selectPair->sell_trade }});
  var points    = parseFloat(coinTwoDecimal) + 1;


  sellvolume = parseFloat(sellvolume).toFixed(coinTwoDecimal);

  sellfee = parseFloat(sellfee).toFixed(coinTwoDecimal);


  if(sellvolume > 0){
    document.getElementById('sellvolume').value = sellvolume;
    document.getElementById('sellprice').value = sellprice;

    document.getElementById('sell_price').value = sellprice;
    document.getElementById('sell_quantity').value = sellvolume;

    $('#sellfees').html(sellfee);

    $('#sellprice_dis').html(sellprice);
    $('#sellvolume_dis').html(sellvolume);
    $('#selltotal_dis').html(selltotal);
  } else {
    $('#sellfees').html(0);
    document.getElementById('sellvolume').value = 0;
    document.getElementById('sellprice').value = sellprice;
  }
}

function sellcal() {
  var sellprice = parseFloat($('#sellprice').val());
  var sellvolume = parseFloat($('#sellvolume').val());
  var sellfee    = parseFloat(sellvolume) * parseFloat({{ $selectPair->sell_trade }});
  var selltotal = parseFloat(sellvolume) * parseFloat(sellprice);

  selltotal = parseFloat(selltotal).toFixed(coinTwoDecimal);


  if(selltotal > 0){
    sellfees = sellfee.toFixed(9);
    document.getElementById('selltotal').value =  parseFloat(selltotal).toFixed(coinTwoDecimal);
    document.getElementById('sell_price').value = sellprice;
    document.getElementById('sell_quantity').value = sellvolume;

    $('#sellfees').html(sellfees.slice(0,-1));

    $('#sellprice_dis').html(sellprice);
    $('#sellvolume_dis').html(sellvolume);
    $('#selltotal_dis').html(selltotal);
  } else {
    $('#sellfees').html(0);
    document.getElementById('selltotal').value = 0;
  }
}
function sellRow(price,remaining)
  {
    
    document.getElementById("sellprice").value = price;
    document.getElementById("sellvolume").value = remaining;
    //document.getElementById("buymarketvolume").value = remaining;
    
    $(".tradepage").addClass("buyorderformactive1");
    $(".tradepage").removeClass("sellorderformactive1");
    $('#buytab').addClass('active');
    $('#selltab').removeClass('active');
    
    
    buycal();
    
  }
  function buyRow(price,remaining)
  {
    document.getElementById("buyprice").value = price;
    document.getElementById("buyvolume").value = remaining;
    //document.getElementById("sellmarketvolume").value = remaining;
    
    $(".tradepage").addClass("sellorderformactive1");
    $(".tradepage").removeClass("buyorderformactive1");
    $('#selltab').addClass('active');
    $('#buytab').removeClass('active');
    sellcal();
     
  }

  $("#buymarket_submit").click(function(){
    document.getElementById('buymarket_submit').classList.add('hide');
    $('#buymarket_submit').hide();
    $.ajax({
    type: "POST",
    url: '{{ route("buyMarketCreate") }}',
    data: $("#buymarket").serialize(),
    }).done(function( request ) {
    if(request.status == 'buylimitsuccess')
    {
      document.getElementById('buymarket_submit').classList.remove('hide');
      $('#buymarket')[0].reset();
      $('#buymarketmsg').html(request.msg);
      window.location =request.url;      
    }
    else
    {
      document.getElementById('buymarket_submit').classList.remove('hide');
      $('#buymarket_submit').show();
      $('#buymarketmsg').html(request.msg);
    }

  });
});
$("#sellmarket_submit").click(function(){
    document.getElementById('sellmarket_submit').classList.add('hide');
    $('#sellmarket_submit').hide();
    $.ajax({
    type: "POST",
    url: '{{ route("sellMarketCreate") }}',
    data: $("#sellmarket").serialize(),
    }).done(function( request ) {
    if(request.status == 'sellsuccess')
    {
      document.getElementById('sellmarket_submit').classList.remove('hide');
      $('#sellmarket')[0].reset();
      $('#sellmarketmsg').html(request.msg); 
      window.location =request.url;      
    }
    else
    {
      document.getElementById('sellmarket_submit').classList.remove('hide');
      $('#sellmarket_submit').show();
      $('#sellmarketmsg').html(request.msg);
    }

  });
});



function updateMatchHistroy(){
  $.ajax({url:"{{ url('/latest-matchhistroy/'.\Crypt::encrypt($selectPair->id)) }}", type:"GET", async:true, cache:false, success:function(result)
  {
      $("#matchhistroy").html(result);
  }});
}
function updateBuyHistroy(){
  $.ajax({url:"{{ url('/latest-buyerhistroy/'.\Crypt::encrypt($selectPair->id)) }}", type:"GET", async:true, cache:false, success:function(result)
  {
      $("#buyerhistroy").html(result);
  }});
}
function updateSellHistroy(){
  $.ajax({url:"{{ url('/latest-sellerhistroy/'.\Crypt::encrypt($selectPair->id)) }}", type:"GET", async:true, cache:false, success:function(result)
  {
      $("#buyerhistroy").html(result);
  }});
}
function updateMarketdepth_B(){
  $.ajax({url:"{{url('/latest-marketdepth/'.\Crypt::encrypt($selectPair->id).'/Buy')}}", type:"GET" ,async:true, cache:false ,success:function(result){
      $("#market_B").html(result);
  }});
}                                                       

function updateMarketdepth_S(){
  $.ajax({url:"{{url('/latest-marketdepth/'.\Crypt::encrypt($selectPair->id).'/Sell')}}", type:"GET" ,async:true, cache:false ,success:function(result){
      $("#market_S").html(result);
  }});
}
setInterval(function()
{ 
  updateMatchHistroy();
   updateMarketdepth_B();
  updateMarketdepth_S();
 },5000);
</script>

</body>
</html>

