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
    <div class="buyfullcontent">
      <h2 class="sell-matched">Sellers Matched Make Payment</h2> 
      <p class="completed-para">Completed <b>{{ $order->filled }} {{$coinOne}} of {{ $order->volume }} {{$coinOne}}</b></p>
      <p class="completed-para">Placed on {{ date('M d,Y, h:i A',strtotime($order->created_at)) }}
      </p>
      <button class="cancel-btn" data-bs-toggle="modal" data-bs-target="#canceltrade">Stop further matching</button>
   </div>

   <div class="buyfullcontent">
      <h2 class="sell-matched">Payment #1 for {{ $order->volume }} {{$coinOne}}</h2> 
      <p class="completed-para">Matched on {{ date('M d,Y, h:i A',strtotime($order->updated_at)) }}</p>
   </div>
   <div class="buyfullcontent wait-txt">
      <div class="hour-load">
        <div class="hourglass"></div>
     </div>

     <h2 class="sell-matched">Select payment mode within</h2> 
     <p class="completed-para" id="demo">0 mins,00 secs</p>
  </div> 

  <div class="buyfullcontent wait-txt">
   <h2 class="sell-matched">Pay Exactly </h2> 
   <p class="completed-para">{!! $symbol !!}{{ $order->value }}
   </p>
   @if($bankdetail)
   <a href="{{ url('/p2p-paymenttype/'.$order->order_id.'/bank') }}"> <span class="badge badge-success">IMPS</span> </a> 
   @endif
   @if($upidetail)
   <a href="{{ url('/p2p-paymenttype/'.$order->order_id.'/upi') }}"> <span class="badge badge-success">UPI</span></a>
   @endif
</div> 



</div>
</article>

<div class="modal fade modalbgt" id="canceltrade">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Are you sure? </h4>
        <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <p class="t-gray">Cancelling trade after 15mins will result in a late cancellation fee.</b></p>
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
            <option>Not sure how to make the payment to the seller</option>
            <option>Problem with chosen payment method</option>
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
          <button class="badge badge-danger" data-bs-dismiss="modal">No, Go back</button>
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


<script>
  $ = function(id) {
    return document.getElementById(id);
 }

 var show = function(id) {
  $(id).style.display ='block';
}
var hide = function(id) {
	$(id).style.display ='none';
}
</script>
<script type="text/javascript">
   @php
   $dateTime = strtotime($order->closed_at);
   $getDateTime = date("F d, Y H:i:s", $dateTime);
   @endphp
   var deadline = new Date("{{ $getDateTime }}").getTime();

   var x = setInterval(function() {
    const d = new Date();
    var now = new Date().getTime();
    console.log(d.toString());
    var t = deadline - now;
    var days = Math.floor(t / (1000 * 60 * 60 * 24));
    var hours = Math.floor((t%(1000 * 60 * 60 * 24))/(1000 * 60 * 60));
    var minutes = Math.floor((t % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((t % (1000 * 60)) / 1000);
    document.getElementById("demo").innerHTML = "<div><span>"+hours+"</span><span> hours,</span>  <span>"+minutes+"</span><span> mins,</span>  <span>"+seconds+"</span><span> secs</span></div>";

    if (t < 0) {
       clearInterval(x);
        //location.reload();
       document.getElementById("demo").innerHTML = "Match auto cancel";
    }
 }, 1000);
</script>