@php $title = "Staking"; $atitle ="staking";
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



	<article class="gridparentbox stacking">		
	
  <div class="stacking-back">
			<div class="container sitecontainer stacking">

  <section class="stacking-banner">

	
  <div class="container sitecontainer">
  <div class="innerpagecontent">
  <h4>Staking</h4>
  <p>Simple & Secure. Search popular coins and start earning.</p>
  </div>

  <div class="stackingbannerright">
  <div class="stacking-card">
    <div toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></div>

    <div class="owl-carousel owl-theme">

    @foreach ($stake as $value)
      <div class="card item">
        <div class="xchange-rate">

         <?php  $withdraw = 0;?>
          @foreach ($value->withdraw  as $data)
          <?php $withdraw +=  $data->amount;?>
          @endforeach

          <?php 
          $reward = 0;
          $reward = $value->rewards->where('deposit_id',$value->id)->sum('amount');
          ?>

          <h4>Withdraw : <span>{{ $withdraw }}</span> SET</h4>

          <h4>Reward Earn : <span>{{ $reward }}</span> SET</h4>

          <!-- <h5></h5> -->
          <!-- <p>≈ $ 0.00</p> -->
          <a href="{{ url('earning') }}"><h3>Account</h3></a>
        </div>
        <div class="xchange-rate ryt">
          <h4>Est. Total Value : <span>{{ $wallet }}</span> SET</h4>
          <h4>Est. Total Value in USDT: <span>{{ $estimated_amt_usdt }}</span> USDT</h4>
          <!-- <h5></h5> -->
          <!-- <p>≈ $ 0.00</p> -->
          <a href="{{ url('earning') }}"><h3>History</h3></a>
        </div>
      </div>
    @endforeach

    

   </div>

  </div>

</div>
</section>




	</div>
	</div>


<section class="card-stacking">
    <div class="container sitecontainer stacking">
      <div class="eth-card-total">
        <div class="swap-icon"><img src="{{ url('images/swap-icon.png') }}" class="eth-icon"></div>
        @foreach($list as $value)
        <div class="card border-style-cls">

            <h4>{{$value->stacking_title}}
            <img src="{{ url('images/color/set.svg') }}" class="eth-icon" style="width: 35px;">
            </h4>

            <p> Deposit coin : {{$value->deposit_coin }}</p>
            <p> Min Allocation : {{$value->min_amt }} {{$value->deposit_coin }}</p>
            <p> Max Allocation : {{$value->max_amt }} {{$value->deposit_coin }}</p>
            <p> Duration : {{$value->duration_title }}</p>

            <div class="card-btn">
              <a href="{{ url('/stacksubscribepage/'.\Crypt::encrypt($value->id) ) }}" ><span>Subscribe</span></a>
            </div>

            </div>
            @endforeach

            

            
            </div>

            </div>

            
    </section>


    <div class="profilepaget showtable">
    <div class="panelcontentbox">

      <div class="tab-content">
        <div id="trade" class="tab-pane fade in show active">
          <div class="searchfrmbox">
          </div>
          <div class="table-responsive sitescroll" data-simplebar>
            <table class="table sitetable table-responsive-stack" id="table1">
              <thead>
                <tr>
                  <th>Date & Time</th>
                  <th>Title</th>
                  <th>Deposit Coin</th>
                  <th>Amount</th>
                  <th>SET Staked</th>
                  <th>Staking Reward</th>
                  <th>No. of Days</th>
                  <th>Total Estimated Reward</th>
                  <th>Last Reward</th>
                  <th>Next Reward</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @if(count($stake)>0)
                @foreach($stake as $stake)
                <tr>
                  <td>{{ date('d-m-Y H:i:s',strtotime($stake->created_at))  }}</td>
                  <td>{{ $stake->staking_title }}</td>
                  <td>{{ $stake->deposit_coin }}</td>
                  <td>{{ $stake->no_of_coin }}</td>
                  <td>{{ ncDiv($stake->no_of_coin,$stake->live_price,4) }} SET</td>
                  <td>{{ $stake->annual_yield }} %</td>
                  <td>{{ $stake->duration_title }}</td>
                  <td>{{ ($stake->total_estimated_reward > 0) ? ncDiv($stake->total_estimated_reward,$stake->live_price,4).' '.'SET' : '-'  }}</td>
                  <td>{{ $stake->last_reward }}</td>
                  <td>{{ $stake->next_reward }}</td>
                  @if($stake->status == 1)
                  <td>
                    @if($stake->stakingsetting['cancellation_controll'] == 1)
                    <a class="badge badge-warning" href="{{ url('/cancelstake/'.\Crypt::encrypt($stake->id) ) }}">Cancel</a>
                   @else --- @endif
                  </td>
                  @else
                  <td>-</td>
                  @endif
                </tr>
                @endforeach
                @else
                <tr>
                  <td>No record found!
                  </td>
                </tr>
                @endif
              </tbody>
            </table>
          </div>
        </div>


      </div>
    </div>
  </div>

</article>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>


<script>
    $(function() {
  // Owl Carousel
  var owl = $(".owl-carousel");
  owl.owlCarousel({
    items: 1,
    margin: 10,
    autoplay:true,
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

<!-- <script>
            $(document).ready(function() {
              $('.owl-carousel').owlCarousel({
                loop: true,
                margin: 10,
                responsiveClass: true,
                autoplay: true,
                responsive: {
                  0: {
                    items: 1,
                    nav: true
                  },
                  600: {
                    items: 1,
                    nav: false
                  },
                  1000: {
                    items: 4,
                    nav: true,
                    loop: true,
                    margin: 20
                  }
                }
              })
            })
          </script> -->

@if(session('success'))
<script type="text/javascript">
  toastr.success("{{ session('success') }}");
</script>
@endif