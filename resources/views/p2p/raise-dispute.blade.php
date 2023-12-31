@php 
$title = "P2P - $coinOne/$coinTwo | Buy and Sell $coinOne with $coinTwo on switchExchange P2P"; 
$atitle ="market-place";
if($coinTwo == 'INR') { 
  $image = url('images/color/inr.svg');
  $symbol = "<img src='".$image."' class='symbols' />";
} else{ 
  $symbol = ''; 
}
@endphp

@include('layouts.header')
<link rel="stylesheet" type="text/css" href="{{url('css/match.css')}}" />
<link rel="stylesheet" type="text/css" href="{{url('css/p2pbuy.css')}}" />
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
    <div class="back-link-tag">
                  <a href="{{route('marketplace')}}" class="back-link"><i class="fa fa-arrow-left"></i> Back</a>
                 </div>
        <div class="buyfullcontent">
          @if ($message = Session::get('fail'))
  <div class="alert alert-danger alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button> 
    <strong>{!! $message !!}</strong>
  </div>
@endif
  
  @if ($message = Session::get('success'))
  <div class="alert alert-success alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button> 
    <strong>{!! $message !!}</strong>
  </div>
  @endif
  
         <div>
           
    @if($order->trade_type == 'Buy')
    <div>      
      <h5 class="sellers-head">Rise Dispute Query</h5>
      <hr>
      <p class="buy-order">We will email you when your order is closed.</p>
      <p class="buy-order"><b>Buy Order {{ $order->volume }} {{ $coinOne }} @ Price {!! $symbol !!}{{ $order->price }}</b></p>
    </div>
    @else
    <div>      
      <h5 class="sellers-head">Rise Dispute Query</h5>
      <hr>
      <p class="buy-order">We will email you when your order is closed</p>
      <p class="buy-order"><b>Sell Order {{ $order->volume }} {{ $coinOne }} @ Price {!! $symbol !!}{{ $order->price }}</b></p>
    </div>
    @endif
    <div class="load-spinner">
      <div class="loader"></div>
    </div>
    <p>You will immediately get an email from our dispute team requesting payment proof. Then, within the next 15 minutes, please reach out to our support team via support ticket</p>
    <p class="time-txt">Placed on {{ date('M d,Y, h:i A',strtotime($order->created_at)) }}</p>
    <hr><p class="time-txt">Your OrderID: {{ $order->order_id }}</p>

  </div>
</article>

@include('layouts.footermenu')
</div>
@include('layouts.footer')   







</body>
</html>