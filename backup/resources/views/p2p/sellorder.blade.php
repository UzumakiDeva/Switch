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
   <div class="buyfullcontent">
    <h2 class="sell-matched">Sell ordered closed</h2> 
    <p class="completed-para">Completed  <b>{{ display_format($order->filled,$selectPair->coinone_decimal) }} {{ $coinOne }} of {{ display_format($order->volume,$selectPair->coinone_decimal) }} {{ $coinOne }}</b></p>
    <p class="completed-para">Placed on {{ date('M d,Y, h:i A',sxzsatrtotime($order->created_at)) }}
                        </p>
  </div>

  <div class="buyfullcontent">
    <h2 class="sell-matched">Payment #1 for {{ display_format($order->escrow_volume,$selectPair->coinone_decimal) }} {{ $coinOne }}</h2> 
    <p class="completed-para">Completed <b>{{ display_format($order->filled,$selectPair->coinone_decimal) }} {{ $coinOne }} of {{ display_format($order->volume,$selectPair->coinone_decimal) }} {{ $coinOne }}</b></p>
  </div>




  <div class="buyfullcontent wait-txt">


    <h2 class="sell-matched">Waiting for confirmation</h2> 

 </div> 

 <div class="buyfullcontent wait-txt">
   <h2 class="sell-matched">Check your Bank Account and confirm below </h2> 

   <div>
    <button class="not-receive">Not Received</button>
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
        <button class="not-receive">No, Go Back</button>
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
