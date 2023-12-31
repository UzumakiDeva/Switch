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
    <h2 class="sell-matched">Sell ordered closed</h2> 
    <p class="completed-para">Completed  <b>{{ display_format($order->filled,$selectPair->coinone_decimal) }} {{ $coinOne }} of {{ display_format($order->volume,$selectPair->coinone_decimal) }} {{ $coinOne }}</b></p>
    <p class="completed-para">Placed on {{ date('M d,Y, h:i A',strtotime($order->created_at)) }}
                        </p>
  </div>

  <div class="buyfullcontent">
    <h2 class="sell-matched">Payment #1 for {{ display_format($order->escrow_volume,$selectPair->coinone_decimal) }} {{ $coinOne }}</h2> 
    <p class="completed-para">Completed <b>{{ display_format($order->filled,$selectPair->coinone_decimal) }} {{ $coinOne }} of {{ display_format($order->volume,$selectPair->coinone_decimal) }} {{ $coinOne }}</b></p>
  </div>




  <div class="buyfullcontent wait-txt">


    <h2 class="sell-matched">Waiting for confirmation</h2> 
    <p class="completed-para" id="demo">0 mins,00 secs</p>
 </div> 

 <div class="buyfullcontent wait-txt">
   <h2 class="sell-matched">Check your Bank Account and confirm below </h2> 

   <div>
    <a href="{{url('/p2p-paymentnotreceived/'.$order->order_id)}}"><button class="not-receive">Not Received</button></a>
    <button class="receive" id="myBtn">Received</button>

    <div id="myModal" class="modal">

      <!-- Modal content -->
      <div class="modal-text">
        <span class="close">&times;</span>
        <h5 class="buy-usdt-inr">Payment confirmation</h5>
        <p>Are you sure you have received {!! $symbol !!}{{ display_format($order->received,$selectPair->cointwo_decimal) }}  from the buyer? {{ display_format($order->escrow_volume,$selectPair->coinone_decimal) }} {{ $coinOne }} will be transferred to the buyer. </p>
        <form class="siteformbg" action="{{ route('p2pcompelte') }}" id="theform" method="post" autocomplete="off">
        @csrf
        <input type="hidden" name="orderID" value="{{ $order->order_id }}">
        <input type="checkbox" id="statusPayment" name="status" value="Received" required>
        <label class="checked-cnfrm"> I have a checked my Bank account</label><br>
        <input type="submit" class="btn sitebtn" value="Yes, I Received" />
        </form>

      </div>

    </div>
    <p>Not received will be enabled after 30mins. If you have received partial payment, select "NOT RECEIVED" button. 
      If you don't select any option, it will be moved to dispute.
    </p>
  </div>
</div> 



</div>
</article>
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


<script>

// Get the modal
  var modal = document.getElementById("myModal");

// Get the button that opens the modal
  var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
  var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
  btn.onclick = function() {
    modal.style.display = "block";
  }

// When the user clicks on <span> (x), close the modal
  span.onclick = function() {
    modal.style.display = "none";
  }

// When the user clicks anywhere outside of the modal, close it
  window.onclick = function(event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
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
       document.getElementById("demo").innerHTML = "<span class='text-danger'>Trade moved to dispute</span>";
    }
 }, 1000);
</script>