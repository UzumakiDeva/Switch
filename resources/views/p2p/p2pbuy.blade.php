@php $title = "History"; $atitle ="history";
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
<link rel="stylesheet" type="text/css" href="{{url('css/p2pbuy.css')}}" />
<div class="pagecontent gridpagecontent innerpagegrid">
@include('layouts.headermenu')
			</section>
			<article class="gridparentbox">
				<div class="container sitecontainer">
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
					<div class="buyfullcontent">
						<h2 class="sell-matched">Sellers Matched Make Payment</h2> 
                        <p class="completed-para">Completed <b>{{ $order->filled }} {{ $coinOne }}  of {{ $order->volume }} {{ $coinOne }}</b></p>
                        <p class="completed-para">Placed on {{ date('M d,Y, h:i A',strtotime($order->created_at)) }}
                        </p>
                       

      <div class="box">
	<a class="button" href="#popup1">Cancel Order</a>
</div>

<div id="popup1" class="overlay">
	<div class="popupe">
    <p class="pay-para-txt">Are you sure you want to cance the order? </p>
    <p>All matched trades except the trades where you've paid or clicked <b>"Yes, I Will pay" will be cancelled.</b></p>
     <select name="select">
  <option value="" selected>Select Reson for Cancellation</option>
  <option value="option-1">I don't want trade anymore</option>
  <option value="option-2">I want to modify the price</option>
  <option value="option-3">Placed order by mistake</option>
  <option value="option-4">UPI Option is not available</option>
  <option value="option-5">Other Reasons</option>
</select>
<div class="important-note ">
     <p class="note-txt"><b>Please Note</b></p>
     <p class="note-txt">Penalty for not paying after clicking "Yes, i will pay": Minimum <b>{{ $order->volume }} {{ $coinOne }}</b>or <b>1.2%</b>of trade </p>
    
    </div>

    <div>
        <button class="back-btn">No, Go back</button>
        <button class="cancel-button">Cancel-order</button>
       
    </div>
		<a class="close" href="#">×</a>
		
	</div>
</div>
                    </div>

                	<div class="buyfullcontent">
						<h2 class="sell-matched">Payment #1 for {{ $order->volume }} {{ $coinOne }}</h2> 
                        <p class="completed-para">Completed <b>{{ $order->filled }} {{ $coinOne }} of {{ $order->volume }} {{ $coinOne }}</b></p>
                     </div>

                     <div class="buyfullcontent">
                     <h2 class="sell-matched">SELECT PAYMENT MODE WITHIN</h2> 
                        <p class="completed-para">Completed <b>0.000 {{ $coinOne }} of 14.50 {{ $coinOne }}</b></p>
                     </div>

                     <div class="buyfullcontent">
                     <h2 class="sell-matched">Pay Exactly</h2> 
                        <!-- <p class="completed-para">Completed <b>0.000 USDT of 14.50 USDT</b></p> -->
                        

                        <a href ="#" onclick="show('popupk')" ><button class="upi-btn">UPI</button></a>
                     <div class="popupk" id="popupk">

                     <p class="pay-para-txt">Continue to pay ?</p>

               <p>Confirm the extended the time to 60 minutes and see the payment details.</p>
               <div class="important-note">
     <p class="note-txt"><b>Please Note</b></p>
     <p class="note-txt">Penalty for not paying after clicking "Yes, i will pay": Minimum <b>10 {{ $coinOne }}</b>or <b>1.2%</b>of trade </p>
     </div>

  <div>
  <a href=""><button class="pay-btn">Yes, I will pay </button></a>
  
  <a href="#" onclick="hide('popupk')" class="close-btn">Close</a>
</div>
</div>  

                     <a href ="#" onclick="show('popupk')" ><button class="upi-btn">IMPS</button></a>
                     <div class="popupk" id="popupk">

                     <p class="pay-para-txt">Continue to pay ?</p>

               <p>Confirm the extended the time to 60 minutes and see the payment details.</p>
               <div class="important-note">
     <p class="note-txt"><b>Please Note</b></p>
     <p class="note-txt">Penalty for not paying after clicking "Yes, i will pay": Minimum <b>10 {{ $coinOne }}</b>or <b>1.2%</b>of trade </p>
     </div>

  <div>
  <a href=""><button class="pay-btn">Yes, I will pay </button></a>
  <a href="#" onclick="hide('popupk')" class="close-btn">Close</a>
</div>
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