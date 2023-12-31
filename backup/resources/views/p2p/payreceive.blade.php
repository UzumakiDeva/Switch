@php 
$title = "P2P - $coinOne/$coinTwo | Buy and Sell $coinOne with $coinTwo on PantherExchange P2P"; 
$atitle ="market-place";
if($coinTwo == 'INR') { 
  $image = url('images/color/inr.svg');
  $symbol = "<img src='".$image."' class='symbols' />";
} else{ 
  $symbol = ''; 
}
@endphp
@include('layouts.header')
<link rel="stylesheet" type="text/css" href="{{url('css/p2psell.css')}}" />
<link rel="stylesheet" type="text/css" href="{{url('css/p2pbuy.css')}}" />
<link rel="stylesheet" type="text/css" href="{{url('css/sellorder.css')}}" />
<style>
  .symbols {
    width: 11px;
    margin-right: 1px;
  }
</style>
<div class="pagecontent gridpagecontent innerpagegrid">
   @include('layouts.headermenu')
</section>
<article class="gridparentbox">
  <div class="container sitecontainer">

    <div class="buyfullcontent wait-txt">
       <h2 class="sell-matched">{{ $order->trade_type }} order closed</h2> 
    <p class="completed-para">Completed <b>{{ $order->filled }} {{ $coinOne }}  of {{ $order->volume }} {{ $coinOne }}</b></p>
    <p class="completed-para">Placed on {{ date('M d,Y, h:i A',strtotime($order->created_at)) }}</p>
      </p>
   </div> 

   <div class="buyfullcontent">
      <h2 class="sell-matched">Payment #1 for {{ display_format($order->escrow_volume,$selectPair->coinone_decimal) }} {{ $coinOne }}</h2> 
    <p class="completed-para">Completed <b>{{ display_format($order->filled,$selectPair->coinone_decimal) }} {{ $coinOne }} of {{ display_format($order->volume,$selectPair->coinone_decimal) }} {{ $coinOne }}</b></p>
      <i class="fa fa-check" style="color: #ebebeb;"></i>
      <h2 class="sell-matched wait-txt">{{ $order->trade_type }} of for {{ $order->volume }} {{ $coinTwo }} for {!! $symbol !!} {{ $order->value }} amount successful  </h2> 
      <p class="completed-para">TDS Deducted :{{ display_format($order->fees,$selectPair->coinone_decimal) }} {{ $coinOne }} @ {{ ncMul($order->commission,100,1) }} %
      </p>
   </div>



</div>
</article>
@include('layouts.footermenu')
</div>
@include('layouts.footer')
