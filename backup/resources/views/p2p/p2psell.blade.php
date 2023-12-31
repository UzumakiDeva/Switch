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
						<h2 class="sell-matched">Buyers Matched Make Payment</h2> 
                        <p class="completed-para">Completed  <b>{{ $order->filled }} {{ $coinOne }} of {{ $order->volume }} {{ $coinOne }}</b></p>
                        <p class="completed-para">Placed on {{ date('M d,Y, h:i A',strtotime($order->created_at)) }}
                        </p>
                        <button class="cancel-btn" data-bs-toggle="modal" data-bs-target="#canceltrade">Stop further matching</button>
                    </div>

                	<div class="buyfullcontent">
						<h2 class="sell-matched">Payment #1 for {{ $order->volume }} {{ $coinOne }}</h2> 
                        <p class="completed-para">Completed <b>{{ $order->filled }} {{ $coinOne }} of {{ $order->volume }} {{ $coinOne }}</b></p>
                     </div>



                     
                     <div class="buyfullcontent wait-txt">
                     <div class="hour-load">
                      <div class="hourglass"></div>
                      </div>
                     
                     <h2 class="sell-matched">Waiting for the payment</h2> 
                        <p class="completed-para">Waiting for buyer to confirm the payment to your
                          bank account .Expected time- 1 hour.
                        </p>
                     </div> 

                     <div class="buyfullcontent wait-txt">
                     <h2 class="sell-matched">You will receive</h2> 
                        <p class="completed-para">{!! $symbol !!}{{ $receive }}
                        </p>
                     </div> 

                     
					
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