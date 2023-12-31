@php $title = "P2P - USDT/INR | Buy and Sell USDT with INR on Panther Exchange P2P"; $atitle ="history";
@endphp
@include('layouts.header')
<link rel="stylesheet" type="text/css" href="{{url('css/match.css')}}" />
<link rel="stylesheet" type="text/css" href="{{url('css/p2pbuy.css')}}" />
<div class="pagecontent gridpagecontent innerpagegrid">
@include('layouts.headermenu')
			</section>
			<article class="gridparentbox">
				<div class="container sitecontainer">
        <div class="back-link-tag">
                  <a href="" class="back-link"><i class="fa fa-arrow-left"></i> Back</a>
                 </div>
        <div class="buyfullcontent">
         <div>
           <!-- <div class="cancel-button">
               <button class="cancel-btn">Cancel Order</button> 
           </div> -->
           <div class="box cancel-button">
	<a class="button cancel-btn" href="#popup1">Cancel Order</a>
</div>

<div id="popup1" class="overlay">
	<div class="popupe">
    <p class="pay-para-txt">Are you sure you want to cancel the order? </p>
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
     <p class="note-txt">Penalty for not paying after clicking "Yes, i will pay": Minimum <b>10 USDT</b>or <b>1.2%</b>of trade </p>
    
    </div>

    <div>
       <a href="p2pmatch"> <button class="back-btn">No, Go back</button> </a>
        <button class="cancel-button">Cancel-order</button>
       
    </div>
		<a class="close" href="#">×</a>
		
	</div>
</div>
           
               <h5 class="sellers-head">Matching With Direct Sellers</h5>
                <p class="buy-order">We will email you when your order is ,matched.</p>
                <p class="buy-order"><b>Buy Order {{ $order->filled }} @ Price {{ $order->volume }}</b></p>
              </div>
                <div class="load-spinner">
                <div class="loader"></div>
                </div>
                <p class="time-txt">Time taken depends on current demand & your price</p>
                <p class="time-txt">Placed on May 29, 2023, 12:12:58</p>
             
          </div>
</div>
         </article>
			@include('layouts.footermenu')

</div>
@include('layouts.footer')   




    
   
   
</body>
</html>