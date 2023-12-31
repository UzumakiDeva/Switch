@php 
$title = "P2P - $coinOne/$coinTwo | Buy and Sell $coinOne with $coinTwo on switchExchange P2P"; 
$atitle ="market-place";
if($coinTwo == 'INR') {
if(Session::get('mode') == 'nightmode'){
$image = url('images/inr-light.svg');
}else{
$image = url('images/color/inr.svg');
}
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
           <!-- <div class="cancel-button">
               <button class="cancel-btn">Cancel Order</button> 
           </div> -->
           <div class="box cancel-button">
  <a class="button cancel-btn" data-bs-toggle="modal" data-bs-target="#canceltrade">Cancel Order</a>
</div>
    @if($order->trade_type == 'Buy')
    <div>      
      <h5 class="sellers-head">Matching With Direct Sellers</h5>
      <hr>
      <p class="buy-order">We will email you when your order is matched.</p>
      <p class="buy-order"><b>Buy Order {{ $order->volume }} {{ $coinOne }} @ Price {!! $symbol !!}{{ $order->price }}</b></p>
    </div>
    @else
    <div>      
      <h5 class="sellers-head">Matching With Direct Buyers</h5>
      <hr>
      <p class="buy-order">We will email you when your order is matched</p>
      <p class="buy-order"><b>Sell Order {{ $order->volume }} {{ $coinOne }} @ Price {!! $symbol !!}{{ $order->price }}</b></p>
    </div>
    @endif
    <div class="load-spinner">
      <div class="loader"></div>
    </div>
    <p class="time-txt">Time taken depends on current demand & your price</p>
    <p class="time-txt">Placed on {{ date('M d,Y, h:i A',strtotime($order->created_at)) }}</p>
    <hr><p class="time-txt">Your OrderID: {{ $order->order_id }}</p>

  </div>
</article>
<div class="modal fade modalbgt" id="canceltrade">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Are you sure you want to cancel the order? </h4>
        <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <p class="t-gray">All matched trades except the trades where you've paid or clicked <b>"Yes, I Will pay" will be cancelled.</b></p>
      <form class="siteformbg" action="{{ route('p2pcancel') }}" id="theform" method="post" autocomplete="off">
        @csrf
        <input type="hidden" name="orderID" value="{{ $order->order_id }}">
        <div class="form-group" class="form-control @error('reasons') is-invalid @enderror" >
          <select name="reasons" required="required">
            <option value="" selected>Select Reason for Cancellation</option>
            <option>I don't want trade anymore</option>
            <option>I want to modify the price</option>
            <option>Placed order by mistake</option>
            <option>UPI Option is not available</option>
            <option>Other Reasons</option>
          </select>
          @error('reasons')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror 
        </div>
        <div class="important-note ">
         <p class="note-txt"><b>Please Note</b></p>
         <p class="note-txt">Penalty for not paying after clicking "Yes, i will pay": Minimum <b>10 USDT</b>or <b>1.2%</b>of trade </p>
        
        </div>
        <div class="form-group mt-2 text-center">
          <span class="badge badge-danger" data-bs-dismiss="modal">No, Go back</span>
          <input type="submit" class="btn sitebtn" value="Cancel-order" />
        </div>  
      </form>
      </div>      
    </div>
  </div>
</div>
@include('layouts.footermenu')
</div>
@include('layouts.footer')   







</body>
</html>