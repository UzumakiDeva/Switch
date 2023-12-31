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

        <div class="container sitecontainer">
        <section class="saving-page">
    <div class="contain-width">
                <div class="data-cnt">
                    <div class="sub-all">Subscribe</div>
                    <div class="btn-img">
                        <img src="{{ url('images/bnt-img.png') }}"/>
                    </div>
                </div>
        <div class="pop-sep">
            <div  class="duration">Duration (Days)</div>
                <div class="ratio-btn">
                    <input type="radio" id="axscat" name="animal" value=""/>
                    <label for="axscat">Flexible</label>
                </div>
        </div>
    
        <div class="amnt-detail">
            <div class="max-amt">
                <input data-bn-type="input" placeholder="Enter amount" class="input-box" value="" />
                <div class="bn-input-suffix pop-sep">
                    <div class="max-btn">
                        <button data-bn-type="button" class="css-i6m49h">Max</button>
                        <div class="btn-img">
                            <img src="{{ url('images/bnt-img.png') }}"/>
                        </div>
                    </div>
                </div>
                <label class="bn-input-label css-1ju406z"><div data-bn-type="text" class="sub-amount">Subscription Amount</div></label>
            </div>
            <div class="buybtn">
                <div class="avaliable-btn">
                    <h4>0 BNT <span>Available</span></h4>
                </div>
                <div class="buynow">
                    <a data-bn-type="link" href="#">Buy Now</a>
                </div>
            </div>
            <div class="css-iw44fb">
                <div class="css-10nf7hq">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="css-1abjj3z">
                        <path
                            d="M12.011 2H12C6.472 2 2 6.472 2 12c0 5.527 4.472 10 10 10 5.516 0 9.988-4.473 10-9.989.012-5.527-4.461-10-9.989-10.011zm.998 16.984h-2.018v-2.007h2.018v2.007zm0-4.633h-2.018V5.005h2.018v9.346z"
                            fill="currentColor"
                        ></path>
                    </svg>
                    <div data-bn-type="text" class="css-1mdhm3s">Don’t have enough crypto?</div>
                </div>
                <div class="css-1bd2egb">
                    <div data-bn-type="text" class="css-155nust">Convert</div>
                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M438.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-160-160c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L338.8 224 32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l306.7 0L233.4 393.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l160-160z"/></svg>
                </div>
            </div>
            <div class="css-t1c45i">
                <div class="css-prp3gn">Amount Limits</div>
                <div class="css-1o4igj2">
                    <div class="css-1yth19f">
                        <div class="css-ompmya">Minimum:</div>
                        <div class="css-4cffwv">0.001 AXS</div>
                    </div>
                   
                </div>
            </div>
            <div class="auto-subscribe">
                <button type="button" role="switch" aria-checked="true" class="css-bsatan" style="direction: ltr;">
                    <div class="css-1ouokj1" style="transform: translateX(16px);"></div>
                    <input type="checkbox" data-bn-type="checkbox" class="css-1bzb8nq" checked="" />
                </button>
                <div class="css-rtmgzp">
                    <div class="css-10nf7hq">
                        <div data-bn-type="text" class="css-q9r0e3">Auto-Subscribe</div>
                      
                    </div>
                    <div data-bn-type="text" class="css-ax3aaq">
                      The available balance in your Spot Wallet
                      will be used daily at 02:00 and 16:00
                      (UTC+0) to subscribe to Flexible
                      Products.
                    </div>
                </div>
                <img src="{{ url('images/auto-img.png') }}"  />
            </div>

            <div class="left-txt">
                <div class="summary-detail">
                    <div class="css-hx74sz">
                        <div class="summary-cnt">
                            
                            <div class="css-chrzr4">
                              Real-Time APR is a live indication of rewards you can receive,
                              and is subject to change every minute. Rewards are accrued
                              and directly accumulated in your Earn Wallet every minute,
                              adding onto your total Flexible Product balance. There are no
                              transaction records as these rewards are not distributed to
                              your Spot Wallet.
                            </div>
                        </div>
                    
                    </div>
                  
                  
                </div>
            
            <div class="css-15hdzbk"><span class="key">Daily Est. Reward</span><span data-bn-type="text" class="css-1jekytx">--</span></div>
            <div class="css-1p061rf">
                <div class="css-1pytbvt">
                    <div class="css-9e3i13">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="css-va7khm">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 21a9 9 0 100-18 9 9 0 000 18zM10.75 8.5V6h2.5v2.5h-2.5zm0 9.5v-7h2.5v7h-2.5z" fill="currentColor"></path>
                        </svg>
                        <div data-bn-type="text" class="css-2l9trw">The APR is subject to change on a daily basis. Please refer to the details on the page.</div>
                    </div>
                   
                    
                    <div class="agree-box">
                        <label class="check-list">
                            <div class="cnfrm-box">
                                <input type="checkbox" data-bn-type="checkbox" hidden="" name="remember" data-indeterminate="false" class="css-p19g2b" />
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" aria-hidden="true" data-indeterminate="false" class="css-1iztezc">
                                    <path
                                        fill-rule="evenodd"
                                        clip-rule="evenodd"
                                        d="M7.035 16.812l-.001.002 2.121 2.121.002-.002 2.121-2.12 9.19-9.192-2.12-2.121-9.191 9.19-3.536-3.534-2.121 2.12 3.535 3.536z"
                                        fill="currentColor"
                                    ></path>
                                </svg>
                            </div>
                        </label>
                        <label class="check-list">
                            <div class="cnfrm-box">
                                <input type="checkbox" data-bn-type="checkbox" hidden="" name="remember" data-indeterminate="false" class="css-p19g2b" />
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" aria-hidden="true" data-indeterminate="false" class="css-1iztezc">
                                    <path
                                        fill-rule="evenodd"
                                        clip-rule="evenodd"
                                        d="M7.035 16.812l-.001.002 2.121 2.121.002-.002 2.121-2.12 9.19-9.192-2.12-2.121-9.191 9.19-3.536-3.534-2.121 2.12 3.535 3.536z"
                                        fill="currentColor"
                                    ></path>
                                </svg>
                            </div>
                        </label>
                        <div class="agree-box">
                            <label class="check-list">
                                <div class="cnfrm-box">
                                    <input type="checkbox" data-bn-type="checkbox" hidden="" name="remember" data-indeterminate="false" class="css-p19g2b" />
                                    
                                </div>
                            </label>
                            <div class="pop-sep">
                                <input type="checkbox" checked="">
                                <span class="checkmark"></span>  I have read and agreed to <a data-bn-type="link" target="_blank" href="#" class="css-567q3f">Binance Simple Earn Service Agreement</a>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <div class="cnfrm-btn">
                    <button data-bn-type="button" id="pos-confirm" type="primary" disabled="" class="css-1yae18a">Confirm</button>
                </div>
                
            </div>
        </div>
        </div>
    </div>
  
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
					<input type="submit" class="btn sitebtn" value="Submit" />
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
  $(".toggle-password").click(function() {

$(this).toggleClass("fa-eye fa-eye-slash");
var input = $($(this).attr("toggle"));
if (input.attr("type") == "password") {
  input.attr("type", "text");
} else {
  input.attr("type", "password");
}
});
</script>