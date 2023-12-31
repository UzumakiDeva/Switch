@php 
$title = "P2P - $coinOne/$coinTwo | Buy and Sell $coinOne with $coinTwo on switchExchange P2P"; 
$atitle ="market-place";
@endphp
@include('layouts.header')
<link rel="stylesheet" type="text/css" href="{{url('css/p2psell.css')}}" />
<link rel="stylesheet" type="text/css" href="{{url('css/p2pbuy.css')}}" />
<link rel="stylesheet" type="text/css" href="{{url('css/sellorder.css')}}" />
<div class="pagecontent gridpagecontent innerpagegrid">
@include('layouts.headermenu')
			</section>
			<article class="gridparentbox">
				<div class="container sitecontainer">
                    @if ($message = Session::get('fail'))
  <div class="alert alert-danger alert-block"> 
    <strong>{!! $message !!}</strong>
  </div>
@endif
  
  @if ($message = Session::get('success'))
  <div class="alert alert-success alert-block">
    <strong>{!! $message !!}</strong>
  </div>
  @endif

         
            <div class="back-link-tag">
                  <a href="{{route('marketplace')}}" class="back-link"><i class="fa fa-arrow-left"></i> Back</a>
                 </div>

              <div class="buyfullcontent wait-txt">                    
              
                     <h2 class="sell-matched">{{ $order->trade_type }} order closed</h2> 
                     <p class="completed-para">Completed <b>{{ $order->filled }} {{ $coinOne }}  of {{ $order->volume }} {{ $coinOne }}</b></p>
                        <p class="completed-para">Placed on {{ date('M d,Y, h:i A',strtotime($order->created_at)) }}
                        </p>
                     </div> 

                     <div class="buyfullcontent">
						<h2 class="sell-matched">Payment #1 for {{ $order->volume }} {{ $coinOne }}</h2> 
                        <p class="completed-para">Completed <b>{{ $order->filled }} {{ $coinOne }} of {{ $order->volume }} {{ $coinOne }}</b></p>
                        <i class="fa fa-close"></i>
                        <h2 class="sell-matched wait-txt">Cancelled</h2> 
                        @if($order->trade_type == 'Buy')
                        <p class="completed-para">Seller has not received payment. </p>
                        @else
                        <p class="completed-para">Buyer has not received payment. </p>
                        @endif
                     </div>

                     
					
				</div>
			</article>
			@include('layouts.footermenu')
</div>
@include('layouts.footer')




