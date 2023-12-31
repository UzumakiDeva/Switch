@include('layouts.header')

<div class="pagecontent gridpagecontent innerpagegrid">
@include('layouts.headermenu')  	
</section>
	<article class="gridparentbox">	
	<div class="container sitecontainer profilepagebg">
		<div class="innerpagecontent">
			<h2 class="h2"></h2>
		</div>
		<div class="panelcontentbox">
			<div class="contentbox">
				<div class="kyctablebox kycpagebg">
					<div class="kycboxleft">
						<div class="mlmwizardform">
						<form action="{{url('bank-Add')}}" id="#myform" method="post"  autocomplete ="off" class="siteformbg">
                            @csrf
                                <div class="progressbg whiteboxbg">
                            </div>
                           <div class="kycformright">								
							<div class="form-card">
							<div class="subheading">
                                <h5>Add bank </h5>
								<a class="arrowbacklink" href="{{url('/upi-list')}}"><i class="fa fa-arrow-left"></i></a>
                                <hr/>	
                                <div class="row">
                                    <div class="col-md-6">
									<div class="form-group">     
                                        <label>Account Number</label>									
                                        <input type="text" name="account_number" class="form-control  @error('account_number') is-invalid @enderror">
                                            @error('account_number')
					                       <span class="invalid-feedback" role="alert">
						                      <strong>{{ $message }}</strong>
					                        </span>
					                    @enderror    
                                </div>	
                            </div>		
                                <div class="col-md-6">				
									<div class="form-group">
									<label for="bank_name">Bank Name</label>
                                    <input type="text" name="bank_name" class="form-control  @error('bank_name') is-invalid @enderror">
                                        @error('bank_name')
					                       <span class="invalid-feedback" role="alert">
						                      <strong>{{ $message }}</strong>
					                        </span>
					                    @enderror                                  
                                </div>
                                </div>                                
                            </div>
                            <div class="row">
                                    <div class="col-md-6">
									<div class="form-group">     
                                        <label>IFSC code</label>									
                                        <input type="text" name="ifsc_code" class="form-control  @error('ifsc_code') is-invalid @enderror">
                                        @error('ifsc_code')
					                       <span class="invalid-feedback" role="alert">
						                      <strong>{{ $message }}</strong>
					                        </span>
					                    @enderror
                                   </div>	
                                </div>		
                                <div class="col-md-6">				
									<div class="form-group">
                                    <label>Account Type</label>
                                    <select  name="accounttype" class="form-control" >
						            <option disabled selected>Account Type</option> 
						                <option value="current">Current</option>
						                <option value="savings">Savings</option>
					               </select>
                                </div>
                                </div>                                
                            </div>
							</div>
								<input type="submit"  class="action-button sitebtn"  />					
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
