@php $title = "Cryptosavings"; $atitle ="cryptosavings";
@endphp
@include('layouts.header')
<div class="pagecontent gridpagecontent innerpagegrid">
@include('layouts.headermenu')
	
</section>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

<!-- <section class="progress-sec">
<div class="home-demo">
  <div class="owl-carousel owl-theme">
    <div class="item">
      <h2>Swipe</h2>
    </div>
  </div>
</div>
</section> -->



    <article class="gridparentbox ">
        <form action="{{ url('/stacksubmit') }}" method="POST">
        @csrf
        <div class="container sitecontainer cryptosaving">
        @if(session('error'))
         <span class="alert alert-danger">
            <strong> {{ session('error') }}</strong>
        </span>
        @endif
        
        <section class="saving-page">
    <div class="contain-width">
                <div class="data-cnt">
                    <div class="sub-all">Subscribe</div>
                    <div class="btn-img">
                        <!-- <img src="{{ url('images/bnt-img.png') }}"/> -->
                        <p>{{ $result->deposit_coin }}</p>
                    </div>
                </div>
        <div class="pop-sep">
            <div  class="duration">Duration (Days)</div>
                <div class="ratio-btn">
                    <input type="radio" id="axscat" name="duration_title" value="{{ $result->duration_title }}"/>
                    <label for="axscat">{{$result->duration_title}}</label>
                </div>
                @error('duration_title')
                    <span  style="color: red;">{{ $message }}</span>
                @enderror
        </div>

            <div class="max-amt">
                <input data-bn-type="input" placeholder="Enter amount" class="input-box" name="no_of_coin" id="amount" value="" />
                <span id="errorText" style="color: red;"></span>
                <div class="bn-input-suffix pop-sep">
                    <div class="max-btn">
                        <input type ="button" class="css-i6m49h" onclick="maxusdt()" value="Max"/>
                        <div class="btn-img">
                            <!-- <img src="{{ url('images/bnt-img.png') }}"/> -->
                            <p>{{ $result->deposit_coin }}</p>
                        </div>
                    </div>
                </div>
                <label class="bn-input-label css-1ju406z"><div data-bn-type="text" class="sub-amount">Subscription Amount</div></label>
            </div>
            @error('no_of_coin')
                <span  style="color: red;">{{ $message }}</span>
            @enderror

            <div class="buybtn">
                <div class="avaliable-btn">
                    <h4>{{$usdt_bal}} USDT <span>Available</span></h4>
                </div>
                {{-- <div class="buynow">
                    <a data-bn-type="link" href="#">Buy Now</a>
                </div> --}}
            </div>

            <div class="enough">
                <div class="info">
                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                    <h4>Don’t have enough crypto?</h4>
                </div>
                <div class="info">
                    <h4>Convert</h4>
                    <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                </div>
            </div>

                <div class="minmum">
                    <h4 >Amount Limits</h4>
                    <h4><span>Minimum: </span>{{ $result->min_amt }} {{ $result->deposit_coin }}</h4>
                </div>


                <!-- <div class="auto-subscribe">
                    <div class="d-flex">
                        <label class="switch">
                            <input type="checkbox" checked="checked">
                            <span class="slider round"></span>
                        </label>


                        <div class="auto-text">
                            <h4>Auto-Subscribe</h4>
                            <p> The available balance in your Spot Wallet will be used daily at 02:00 and 16:00 (UTC+0) to subscribe to Flexible Products.</p>
                        </div>
                    </div>
                    <div class="load-auto-img">
                        <img src="{{ url('images/auto-img.png') }}"  />
                    </div>

                </div> -->

            
            <div class="left-txt">
                <div class="summary-detail">
                   <h4>Summary</h4>
                   <div class="realtime">
                    <p>Real-Time ER</p>
                    <div class="summary-pre">
                        <h6>{{$result->reward_interest }}%</h6>
                        <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="0.398438" y="0.574219" width="20" height="20" rx="2" fill="#EAECEF"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M16.3984 5.9082H4.39844V15.2415H16.3984V5.9082ZM11.3984 12.7529L15.0651 9.0862L13.8851 7.9082L11.3984 10.3955L9.39844 8.39554L5.73177 12.0622L6.91044 13.2415L9.39844 10.7535L11.3984 12.7529Z" fill="#929AA5"/>
                        </svg>
                    </div>
                   </div>
                  <p>Real-Time ER is a live indication of rewards you can receive,
                        and is subject to change every minute. Rewards are accrued
                        and directly accumulated in your Earn Wallet every minute,
                        adding onto your total Flexible Product balance. There are no
                        transaction records as these rewards are not distributed to
                        your Spot Wallet.</p>
                  
                </div>
            
            <div class="daily">
                <h6>Daily Est. Reward</h6>
                <p>--</p>
            </div>

            <div class="infohave">
            <i class="fa fa-info-circle" aria-hidden="true"></i>
                    <h4>ER does not mean the actual or predicted returns in fiat currency.</h4>
            </div>

            <div class="checkbox">
                <input type="checkbox">
                <h4 class="checkmark">  I have read and agreed to <a target="_blank" href="#" >Switch Simple Earn Service Agreement</a></h4>
            </div>

            <div class="cnfrm-btn">
                    <button type="submit" type="submit" id="submitButton">Confirm</button>
                </div>

        </div>
        </div>
    </div>
    <input type="hidden" name="deposit_coin" value="{{ $result->deposit_coin }}">
    <input type="hidden" name="stackid" value="{{ $result->id }}">
</form>
  
  </section>
        </div>

    </article>

	
        @include('layouts.footermenu')
</div>
@include('layouts.footer')
<div class="modal fade modalbgt" id="ticket">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Create Ticket</h4>
        <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
			<form class="siteformbg" action="{{ url('submitNewTicket') }}" id="theform" method="post" autocomplete="off">
				@csrf
				<div class="form-group">
					<label>Title</label>
					<input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror" required="required">
					@error('subject')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
					@enderror 
				</div>
				<div class="form-group">
					<label>Enter your message</label>
					<textarea rows="3" class="form-control @error('subject') is-invalid @enderror" name="message" required="required"></textarea>
					@error('message')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
					@enderror 
				</div>
				<div class="form-group mt-2 text-center">
					<input  class="btn sitebtn" value="Submit" />
				</div>	
			</form>
      </div>      
    </div>
  </div>
</div>



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>


<script>
    $(function() {
  // Owl Carousel
  var owl = $(".owl-carousel");
  owl.owlCarousel({
    items: 1,
    margin: 10,
    // autoplay:true,
    autoplayTimeout:3000,
    loop: true,
    nav: false,
    autoplayHoverPause:true,
    
    responsive: {
    0: {
      items: 1
    },

    600: {
      items: 1
    },

    1024: {
      items: 1
    },

    1366: {
      items: 1
    }
  }
  
  });
});

</script>

<script>
  function maxusdt(){

   var submitButton = $('#submitButton');
   var balance = "<?php echo $usdt_bal ?>";
   $('#amount').val(balance);
   if(balance == 0){
      $('#errorText').text("Your USDT balance is 0");
          submitButton.attr('disabled', true);
   }
   else if(balance % 100 !== 0){
     $('#errorText').text("Amount must be a multiple of 100");
          submitButton.attr('disabled', true);
            } else {
      $('#errorText').text("");
          submitButton.prop('disabled', false);
   }
  } 
</script>

<script>
  $(".toggle-password").click(function() {

$(this).toggleClass("fa-eye fa-eye-slash");
var input = $($(this).attr("toggle"));
if (input.attr("type") == "password") {
  input.attr("type", "text");
} else {
  input.attr("type", "password");
}
});

  $(document).ready(function() {
    $('#amount').on('input', function() {
       var value = $(this).val();
        var submitButton = $('#submitButton');
        
        if (value !== "") {
            var intValue = parseInt(value);
            
            if (intValue % 100 !== 0) {
                $('#errorText').text("Amount must be a multiple of 100");
                submitButton.attr('disabled', true);
            } else {
                $('#errorText').text("");
                submitButton.prop('disabled', false);
            }
        } else {
            $('#errorText').text("");
            submitButton.prop('disabled', false);
        }
    });
});
</script>