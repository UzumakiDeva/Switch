@php $title = "Earning"; $atitle ="earning";
@endphp
@include('layouts.header')
<div class="pagecontent gridpagecontent innerpagegrid">
@include('layouts.headermenu')
	
</section>
<article class="gridparentbox earning">		

  <div class="container sitecontainer">
    <div class="innerpagecontent">

      <h2 class="h2">Earning</h2>
    </div>


    <section class="earings">
      <div class="contain-width">
        <div class="row">
          <div class="col-sm-12 col-md-6 col-lg-2 col-xl-2 top-space">
            
              <div class="card-full {{ $type =='total_income' ? 'active' : ''}}">
                <div class="card-direct">
                <a href="{{ route('earningHistory', ['type' => 'total_income']) }}"> 
                  <div class="card-icon">
                    <img src="{{ url('images/total-income.png') }}" class="img-fluid">
                  </div>
                  <div class="icon-title">
                    <h4 class="income-title">Total income </h4>
                    <p class="title-rupee">{{ display_format($total_amount) }} SET</p>
                  </div>
                  </a>
                </div>
<!-- 
                <div class="Click-here">Click Here</div>        
<div class="custom-model-main">
    <div class="custom-model-inner">        
    <div class="close-btn">×</div>
        <div class="custom-model-wrap">
            <div class="pop-up-content-wrap">
               Content Here
            </div>
        </div>  
    </div>  
    <div class="bg-overlay"></div>
</div>  -->

              </div>
            
          </div>

          <div class="col-sm-12 col-md-6 col-lg-2 col-xl-2 top-space">
            
              <div class="card-full {{ $type =='stake_income' ? 'active' : ''}}">
                <div class="card-direct">
                <a href="{{ route('earningHistory', ['type' => 'stake_income']) }}"> 
                  <div class="card-icon">
                    <img src="{{ url('images/staking-income.png') }}" class="img-fluid">
                  </div>
                  <div class="icon-title">
                    <h4 class="income-title">Staking income </h4>
                    <p class="title-rupee">{{ display_format($interest_amount) }} SET</p>
                  </div>
                </a>
                </div>

              </div>
            </a>
          </div>

          <div class="col-sm-12 col-md-6 col-lg-2 col-xl-2 top-space">
              <div class="card-full {{ $type =='direct_income' ? 'active' : ''}}">
                <div class="card-direct">
                <a href="{{ route('earningHistory', ['type' => 'direct_income']) }}"> 
                  <div class="card-icon">
                    <img src="{{ url('images/direct-income.png') }}" class="img-fluid">
                  </div>
                  <div class="icon-title">
                    <h4 class="income-title">Direct income </h4>
                    <p class="title-rupee">{{ display_format($direct_amount) }} SET</p>
                  </div>
                </a>
                </div>

              </div>
            </a>
          </div>

          <div class="col-sm-12 col-md-6 col-lg-2 col-xl-2 top-space">
              <div class="card-full {{ $type =='level_income' ? 'active' : ''}}">
                <div class="card-direct">
                <a href="{{ route('earningHistory', ['type' => 'level_income']) }}"> 
                  <div class="card-icon">
                    <img src="{{ url('images/level-income.png') }}" class="img-fluid">
                  </div>
                  <div class="icon-title">
                    <h4 class="income-title">Gen 1-2 Income</h4>
                    <p class="title-rupee">{{ display_format($level_amount) }} SET</p>
                  </div>
                </a>    
                </div>

              </div>
            </a>
          </div>

          <div class="col-sm-12 col-md-6 col-lg-2 col-xl-2 top-space">
              <div class="card-full {{ $type =='rank_1' ? 'active' : ''}}">
                <div class="card-direct">
                <a href="{{ route('earningHistory', ['type' => 'rank_1']) }}"> 
                  <div class="card-icon">
                    <img src="{{ url('images/rank1.png') }}" class="img-fluid">
                  </div>
                  <div class="icon-title">
                    <h4 class="income-title">Gen 2-5 Income</h4>
                    <p class="title-rupee">{{ display_format($rank1_amount) }} SET</p>
                  </div>
                </a>
                </div>
              </div>
            </a>
          </div>

          <div class="col-sm-12 col-md-6 col-lg-2 col-xl-2 top-space">
              <div class="card-full {{ $type =='rank_2' ? 'active' : ''}}">
                <div class="card-direct">
                <a href="{{ route('earningHistory', ['type' => 'rank_2']) }}"> 
                  <div class="card-icon">
                    <img src="{{ url('images/rank2.png') }}" class="img-fluid">
                  </div>
                  <div class="icon-title">
                    <h4 class="income-title">Gen 6-10 income</h4>
                    <p class="title-rupee">{{ display_format($rank2_amount) }} SET</p>
                  </div>
                </a>
                </div>

              </div>
            </a>
          </div>

          <div class="col-sm-12 col-md-6 col-lg-2 col-xl-2 top-space">
              <div class="card-full {{ $type =='rank_3' ? 'active' : ''}}">
                <div class="card-direct">
                <a href="{{ route('earningHistory', ['type' => 'rank_3']) }}"> 
                  <div class="card-icon">
                    <img src="{{ url('images/rank3.png') }}" class="img-fluid">
                  </div>
                  <div class="icon-title">
                    <h4 class="income-title">Gen 11-15 income</h4>
                    <p class="title-rupee">{{ display_format($rank3_amount) }} SET</p>
                  </div>
                </a>
                </div>

              </div>
            </a>
          </div>

          <div class="col-sm-12 col-md-6 col-lg-2 col-xl-2 top-space">
              <div class="card-full {{ $type =='rank_4' ? 'active' : ''}}">
                <div class="card-direct">
                <a href="{{ route('earningHistory', ['type' => 'rank_4']) }}"> 
                  <div class="card-icon">
                    <img src="{{ url('images/rank4.png') }}" class="img-fluid">
                  </div>
                  <div class="icon-title">
                    <h4 class="income-title">Gen 16-20 income</h4>
                    <p class="title-rupee">{{ display_format($rank4_amount) }} SET</p>
                  </div>
                </a>
                </div>

              </div>
            </a>
          </div>


          <div class="col-sm-12 col-md-6 col-lg-2 col-xl-2 top-space">
              <div class="card-full {{ $type =='cto' ? 'active' : ''}}">
                <div class="card-direct">
                <a href="{{ route('earningHistory', ['type' => 'cto']) }}"> 
                  <div class="card-icon">
                    <img src="{{ url('images/rank5.png') }}" class="img-fluid">
                  </div>
                  <div class="icon-title">
                    <h4 class="income-title">CTO income</h4>
                    <p class="title-rupee">{{ display_format($cto_amount) }} SET</p>
                  </div>
                  </a>
                </div>

              </div>
            
          </div>

          <div class="col-sm-12 col-md-6 col-lg-2 col-xl-2 top-space">
            <div class="card-full {{ $type =='cto' ? 'active' : ''}}">
              <div class="card-direct">
                <a href="{{ route('earningHistory', ['type' => 'total_withdraw']) }}"> 
                  <div class="card-icon">
                    <img src="{{ url('images/rank6.png') }}" class="img-fluid">
                  </div>
                  <div class="icon-title">
                    <h4 class="income-title">Total withdraw</h4>
                    <p class="title-rupee">{{ display_format($withdraw_amount) }} SET</p>
                  </div>
                </a>
              </div>

            </div>
            
          </div>

          <div class="col-sm-12 col-md-6 col-lg-2 col-xl-2 top-space">
            
              <div class="card-full {{ $type =='reward_income' ? 'active' : ''}}">
                <div class="card-direct">
                <a href="{{ route('earningHistory', ['type' => 'reward_income']) }}"> 
                  <div class="card-icon">
                    <img src="{{ url('images/rewards-income.png') }}" class="img-fluid">
                  </div>
                  <div class="icon-title">
                    <h4 class="income-title">Available Balance</h4>
                    <p class="title-rupee">{{ display_format($reward_amount) }} SET</p>
                    @if($reward_amount >0)
                     <p class="pop-contant">
                      <a class="badge badge-warning" id="withdraw">Withdraw</a>
                    </p>
                    @endif
                    
                  </div>
                </a>
                </div>

              </div>

           
          </div>

          
          
        </div>
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
            @if($type == 'total_income' || $type == 'stake_income')
            <div class="innerpagecontent">
              <h2 class="h2"><?php echo str_replace('_'," ",$type).' '."History"?></h2>
            </div>
            <table class="table sitetable table-responsive-stack" id="table1">
              <thead>
                <tr>
                  <th>Date & Time</th>
                  <th>Stake Type</th>
                  <th>Interest Type</th>
                  <th>Total Stake Amount</th>                  
                  <th>Interest Amount</th>
                </tr>
              </thead>
              <tbody>

                @if(count($interest_data)>0)
                @foreach($interest_data as $value)
                <tr>
                  <td>{{ date('d-m-Y H:i:s',strtotime($value->created_at))	}}</td>
                  <td>{{ $value->duration_title }}</td>
                  <td>{{ $value->interest_type}}</td>
                  <td>{{ $value->set_stake }} {{ $value->coin }}</td>
                  <td>{{ $value->amount_set }} {{ $value->coin }}</td>
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

            <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
              <div class="pagination-tt clearfix">
                @if($interest_data->count())
                {{ $interest_data->links() }}
                @endif
              </div>
            </div>

            @elseif ($type != 'reward_income'  &&  $type !='cto' && $type !='total_withdraw')
            <div class="innerpagecontent">
              <h2 class="h2"><?php echo str_replace('_'," ",$type).' '."History"?></h2>
            </div>
            <table class="table sitetable table-responsive-stack" id="table1">
                      <thead>
                        <tr>
                          <th>Date & Time</th>
                          <th>Stake Type</th>
                          <th>Stake User name</th>
                          <th>Type</th>
                          <th>Amount</th>
                        </tr>
                      </thead>
                      <tbody>
                        
                        @if(count($reward_history)>0)
                        @foreach($reward_history as $values)
                        <tr>
                          <td>{{ date('d-m-Y H:i:s',strtotime($values->created_at))  }}</td>
                          <td>{{ App\Models\Staking_setting::where('id',$values->stake_id)->value('stacking_title') }}</td>
                          <td>{{ $values->stake_user_name }}</td>
                          <td>{{ $values->type }}</td>
                          <td>{{ $values->amount }}</td>
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

                    <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                      <div class="pagination-tt clearfix">
                        @if($reward_history->count())
                        {{ $reward_history->links() }}
                        @endif
                      </div>
                    </div>

                    @elseif ($type =='cto')
            <div class="innerpagecontent">
              <h2 class="h2"><?php echo str_replace('_'," ",$type).' '."History"?></h2>
            </div>
            <table class="table sitetable table-responsive-stack" id="table1">
                      <thead>
                        <tr>
                          <th>Date & Time</th>
                          <th>Type</th>
                          <th>Coin</th>
                          <th>Amount</th>
                        </tr>
                      </thead>
                      <tbody>
                        
                        @if(count($reward_history)>0)
                        @foreach($reward_history as $values)
                        <tr>
                          <td>{{ date('d-m-Y H:i:s',strtotime($values->created_at))  }}</td>
                          <td>{{ $values->type }}</td>
                          <td>{{ $values->coin }}</td>
                          <td>{{ $values->amount }}</td>
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

                    <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                      <div class="pagination-tt clearfix">
                        @if($reward_history->count())
                        {{ $reward_history->links() }}
                        @endif
                      </div>
                    </div>

                    @elseif ($type =='total_withdraw')
                    <div class="innerpagecontent">
                      <h2 class="h2"><?php echo str_replace('_'," ",$type).' '."History"?></h2>
                    </div>
                    <table class="table sitetable table-responsive-stack" id="table1">
                      <thead>
                        <tr>
                          <th>Date & Times</th>
                          <th>User name</th>
                          <th>Coin</th>
                          <th>Amount</th>
                        </tr>
                      </thead>
                      <tbody>

                        @if(count($withdraw_data)>0)
                        @foreach($withdraw_data as $values)
                        <tr>
                          <td>{{ date('d-m-Y H:i:s',strtotime($values->created_at))  }}</td>
                          <td>{{ App\User::where('id',$values->uid)->value('first_name').' '. App\User::where('id',$values->uid)->value('last_name') }}</td>
                          <td>{{ $values->coin }}</td>
                          <td>{{ $values->amount }}</td>
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

                    <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                      <div class="pagination-tt clearfix">
                        @if($withdraw_data->count())
                        {{ $withdraw_data->links() }}
                        @endif
                      </div>
                    </div>


            @endif
          </div>
        </div>


      </div>
    </div>
  </div>

</div>
</article>

<div class="custom-model-main">
  <div class="custom-model-inner">        
    <div class="close-btn">×</div>
      <form action="{{ url('/stakewithdraw') }}" method="POST" >
        @csrf
    <div class="custom-model-wrap">
      <div class="pop-up-content-wrap">
        <h4>Withdraw</h4>
        <p>Availble Balance : {{ $reward_amount}}</p>
        <label>Enter Amount :</label>
        <input type="text" name="amount" min = 0 step = "any" required class="form-control">
     </div>
     <!-- <button class="badge badge-warning" href="{{ url('/stakewithdraw/') }}">Withdraw</button> -->
     <input type="submit" value="Withdraw" id="save_btn" class="btn sitebtn upload-result">
   </div>  
 </form>
 </div>  
 <div class="bg-overlay"></div>
</div>
	
        @include('layouts.footermenu')

<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>

<script>

$(document).ready(function(){


   //  $('section.earings .card-full').click(function(){
   //     $('.profilepaget').toggleClass('showtable');
   //     if($(this).hasClass('showtable')){
   //      $('.profilepaget').addClass('showtable');
   //      $('.profilepaget').removeClass('showtable');
   //     }
   // })

   $("#withdraw").on('click', function() {
    $(".custom-model-main").addClass('model-open');
  }); 
   $(".close-btn, .bg-overlay").click(function(){
    $(".custom-model-main").removeClass('model-open');
  });

})


</script>


<script>
$(".Click-here").on('click', function() {
  $(".custom-model-main").addClass('model-open');
}); 
$(".close-btn, .bg-overlay").click(function(){
  $(".custom-model-main").removeClass('model-open');
});





</script>

</div>
@include('layouts.footer')

@if(session('success'))
<script type="text/javascript">
  toastr.success("{{ session('success') }}");
</script>
@endif

@if(session('error'))
<script type="text/javascript">
  toastr.error("{{ session('error') }}");
</script>
@endif

