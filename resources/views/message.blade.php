@php $title = "Email conformation"; $atitle ="email";
@endphp
@include('layouts.header')
	<div class="pagecontent gridpagecontent innerpagegrid">
		<link rel="stylesheet" href="{{ url('css/home.css') }}">
		<style type="text/css">
			i.fa.fa-check-circle.tick-green {
			    font-size: 50px;
			    color: #018e9d;
			}
		</style>
		@include('layouts.headermenu')
			</section>
			<article class="gridparentbox">
				<div class="container sitecontainer">
					<div class="row formboxbg">
						<div class="col-md-5 col-sm-12 col-12 mx-auto">
							<h2 class="heading-title text-center">
								<a href="{{url('/')}}">
					                @if(Session::get('mode')=='nightmode')
					                    <img src="{{ url('landing/img/logo-dark.png') }}" class="dark-logo">
					                @else
					                    <img src="{{ url('landing/img/logo.png') }}" class="light-logo">
					                @endif
					            </a>
					        </h2>
							
							<div class="login-form">
								<div class="loginformbox">
									<div class="formcontentbox">
										<form class="siteformbg">
											<h2 class="heading-title text-center">{{ $title }}!</h2>
											<div class="form-group">
												<p class="text-center text-success"><i class="fa fa-check-circle tick-green" aria-hidden="true"></i></p>
												<p class="notesh5 t-gray text-center">{{$msg}} </div>
						<br/>
											<div class="form-group text-center">
												<a href="{{ url('/wallet') }}" class="btn sitebtn text-uppercase m-btn">@lang('common.Next')</a> </div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</article>
            @include('layouts.footermenu')
</div>
@include('layouts.footer')
		<script>
		$("body").addClass("loginbanner");
		</script>