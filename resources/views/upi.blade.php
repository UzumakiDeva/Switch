@php $title = "Payment option"; $atitle ="payment option";
@endphp
@include('layouts.header')
<div class="pagecontent gridpagecontent innerpagegrid">
@include('layouts.headermenu')
			</section>
			<article class="gridparentbox">
				<div class="container sitecontainer">
					<div class="innerpagecontent">
						<h2 class="h2">Payment option</h2> </div>
					<div class="profilepaget">
						<div class="panelcontentbox">
							<div class="innerpagetab">
								<ul class="nav nav-tabs tabbanner" role="tablist">
                                <li class="nav-item"><a class="nav-link " href="{{('bank')}}" >Bank payment</a></li>
									<li class="nav-item"><a class="nav-link active" href="{{('upi-list')}}" >UPI</a></li>										
								</ul>
							</div>
                        <form action="{{url('upi-add')}}"  method="post"  autocomplete ="off" class="siteformbg" enctype='multipart/form-data'>
                            @csrf
                                <div class="progressbg whiteboxbg">
                            </div>
                            <div class="kycformright">								
							<div class="form-card">
							<div class="subheading" >
                                <p >Add your UPI / VPA ID for UPI payments </p>
							    <a href="{{url('/upi-list')}}"><i class="fa fa-arrow-left"></i></a>
							</div>	
                                <div class="row">
                                    <div class="col-md-8">
									<div class="form-group">     
                                        <label>ALIAS</label>									
                                        <input type="text" name="alias" class="form-control  @error('alias') is-invalid @enderror">
                                            @error('alias')
					                       <span class="invalid-feedback" role="alert">
						                      <strong>{{ $message }}</strong>
					                        </span>
					                    @enderror    
                                </div>	
                            </div>	
							<div class='row'>	
                                <div class="col-md-8">				
									<div class="form-group">
									<label for="bank_name">UPI / VPA ID</label>
                                    <input type="text" name="upiid" class="form-control  @error('upiid') is-invalid @enderror">
                                        @error('upiid')
					                       <span class="invalid-feedback" role="alert">
						                      <strong>{{ $message }}</strong>
					                        </span>
					                    @enderror                                  
                                </div> 
							<div class='row'>	
                                <div class="col-md-12">				
									<div class="form-group">
									<label for="bank_name">QR code</label>
                                    <input type="file" name="qrcode" class="form-control  @error('qrcode') is-invalid @enderror">
                                        @error('qrcode')
					                       <span class="invalid-feedback" role="alert">
						                      <strong>{{ $message }}</strong>
					                        </span>
					                    @enderror                                  
                                </div>                               
							<input type="submit"  class="action-button sitebtn"  />	
						</form>
						</div>
					</div>
				</div>
			</article>
			@include('layouts.footermenu')
</div>
@include('layouts.footer')
