@php $title = "Profile"; $atitle ="profile";
@endphp
@include('layouts.header')
<link rel="stylesheet" href="{{ url('css/intlTelInput.css') }}" type="text/css" />
<div class="pagecontent gridpagecontent innerpagegrid">
@include('layouts.headermenu')
			</section>
			<article class="gridparentbox">
				<div class="container sitecontainer">
					<div class="innerpagecontent">
						<h2 class="h2">Profile</h2> </div>
					<div class="flexbox supportbg pbg">
						<div class="panelcontentbox supportticketlist">
							<h1 class="heading-box">My Profile</h1>
							<div class="p-img text-center p-4">
								@if(Auth::user()->profileimg)
								<img src="{{ url('storage/userprofile') }}/{{Auth::user()->profileimg}}" alt="" class="profilebg">
								@else
								<img src="{{ url('images/pro.svg') }}" alt="" class="profilebg">
								@endif
							</div>
							@php 
								$password = false;
								$profile = false;
								$security = false;
								$kycv = false;
								$refpro = false;
								$bankv = false;
								$paypalv = false;
							@endphp
							@if(session()->has('passwordupdated') || session()->has('passwordnotupdated'))
								@php $password = true; @endphp
							@elseif(session()->has('twofasuccess') || session()->has('twofafail'))
								@php $security = true; @endphp
							@elseif(session()->has('kycwarning') || session()->has('kycstatus'))
								@php $kycv = true; @endphp
							@elseif(session()->has('bankwarning') || session()->has('bankstatus'))
								@php $bankv = true; @endphp
							@elseif(session()->has('paypalwarning') || session()->has('paypalstatus'))
								@php $paypalv = true; @endphp
							@else
								@php $profile = true; @endphp
							@endif
							<div class="supportlist" data-simplebar>
								<ul class="nav nav-tabs tabbanner" role="tablist">
									<li class="nav-item">
										<a class="nav-link @if($profile) active @endif" data-bs-target="#pro1" data-bs-toggle="tab" href="#pro1">
											<p>Manage Personal Information</p>
										</a>
									</li>
									<li class="nav-item">
										<a class="nav-link @if($security) active @endif" data-toggle="tab" data-bs-target="#pro2" data-bs-toggle="tab" href="#pro2">
											<p>2FA SECURITY</p>
										</a>
									</li>
									<li class="nav-item">
										<a class="nav-link @if($kycv) active @endif" data-bs-target="#pro3" data-bs-toggle="tab" href="#pro3">
											<p>KYC Verification</p>
										</a>
									</li>
									<li class="nav-item">
										<a class="nav-link @if($bankv) active @endif" data-bs-target="#pro5" data-bs-toggle="tab" href="#pro5">
											<p>Referral Information</p>
										</a>
									</li>
									<li class="nav-item">
										<a class="nav-link @if($paypalv) active @endif" data-bs-target="#pro6" data-bs-toggle="tab" href="#pro6">
											<p>Reward Histroy </p>
										</a>
									</li>
									<li class="nav-item">
										<a class="nav-link @if($password) active @endif" data-bs-target="#pro4" data-bs-toggle="tab" href="#pro4">
											<p>Change Password</p>
										</a>
									</li>
									
									<li class="nav-item">
										<a class="nav-link" href="{{ route('logout') }}">
											<p>Logout</p>
										</a>
									</li>
								</ul>
							</div>
						</div>
						<div class="panelcontentbox  proheight">
							 <span class="ticktmenuicon"><i class="fa fa-close"></i></span>
							<div class="tab-content">
								<div id="pro1" class="tab-pane fade in @if($profile) show active @endif">
									<div class="chatbox ticketchat">
										<div class="panelcontentbox">
											<h2 class="heading-box">Basic Information</h2>
											<div class="contentpanel">
												<div class="darkprofile">
													<div class="profilebox">
														<div class="profilepic"><img src="{{ url('images/profile.svg') }}" id="profile"></div>
														<div class="profiledatainfo">
															<h4 class="h4">{{ $user->email }} <span class="verifytext">Verified</span></h4>
															<h4><span class="desc">(Upload your image like jpg,jpeg,png (MAX: 1MB))</span></h4></div>
														<div class="form-group">
															<div class="controls">
																<label for="profile_input_file" class="custom-file-upload" data-bs-toggle="modal" href="#myPicture" data-bs-target="#myPicture">Upload Image</label>
																<!-- <input id="profile_input_file" name="profile" type="file" style="display:none" > -->
																<label id="file-name3" class="custm-f"></label>
															</div>
														</div>
													</div>
												</div>
												<hr>
												<div class="profiledatainfo">
													@if (session('profilestatus'))
								                      <div class="alert alert-success success-alert alert-dismissible">				                        
								                        {{ session('profilestatus') }}
								                      </div>
								                      @endif
													<form class="siteformbg" action="{{ route('userprofile') }}" method="POST">
														{{ csrf_field() }}
														<div class="row">															
															<div class="col-md-4">
																<div class="form-group">
																	<label>First Name</label>
																	<input required="" name="first_name" class="form-control allletterwithspace" type="text" value="{{ $user->first_name }}">
																	@if ($errors->has('first_name'))
											                          <span class="help-block">
											                            <strong class="text text-danger">{{ $errors->first('first_name') }}</strong>
											                          </span>
											                          @endif 
																</div>
															</div>
															<div class="col-md-4">
																<div class="form-group">
																	<label>Last Name</label>
																	<input required="" name="last_name" class="form-control allletterwithspace" type="text" value="{{ $user->last_name }}">
																	@if ($errors->has('last_name'))
											                          <span class="help-block">
											                            <strong class="text text-danger">{{ $errors->first('last_name') }}</strong>
											                          </span>
											                          @endif 
																</div>
															</div>
															<div class="col-md-4">
																<div class="form-group">
																	<label>Phone Number</label>
																	@if($user->phone_no!=NULL)
							<input class="form-control phone phone_text" type="tel" placeholder="Enter your mobile number" id="phone" value="{{ $user->phone_no !='' ? $user->phone_no : '+49' }}" name="phone_no" onkeyup="if (/[^0-9-+]/g.test(this.value)) this.value = this.value.replace(/[^0-9-+]/g,'')"/>
							<input type="hidden" readonly name="country_code" id="country_code" value=" {{ old('country_code') != '+49' ? old('country_code') : 1 }} "/>
																	@else
																<input class="form-control phone phone_text" type="tel" placeholder="Enter your mobile number" id="phone" value="{{ old('phone_no') !='' ? old('phone_no') : '+49' }}" name="phone_no" onkeyup="if (/[^0-9-+]/g.test(this.value)) this.value = this.value.replace(/[^0-9-+]/g,'')" />
							<input type="hidden" readonly name="country_code" id="country_code" value=" {{ old('country_code') != '+49' ? old('country_code') : 1 }} "/>
																	@endif 
																	@if ($errors->has('phone_no'))
																	<span class="help-block">
																		<strong class="text text-danger">{{ $errors->first('phone_no') }}</strong>
																	</span>
																	@endif
																</div>
															</div>
															<div class="col-md-4">
																<div class="form-group">
																	<label>Date of Birth</label>
																	<div class="input-group dateinput">                                 
																		<input type="text" class="form-control allletterwithspace" name="dob"  required="required" value="{{ $user->dob }}" />
																			<span class="input-group-text" data-toggle="datepicker1" data-target-name="dob"><i class="fa fa-calendar"></i></span>
																	</div>
																	@if ($errors->has('dob'))
											                          <span class="help-block">
											                            <strong class="text text-danger">{{ $errors->first('dob') }}</strong>
											                          </span>
											                          @endif 
																</div>
															</div>
															<div class="col-md-4">
																<div class="form-group">
																	<label>Nationality</label>
																	<input required="" name="nationality" class="form-control allletterwithspace" type="text" value="{{ $user->nationality }}">
																	@if ($errors->has('nationality'))
											                          <span class="help-block">
											                            <strong class="text text-danger">{{ $errors->first('nationality') }}</strong>
											                          </span>
											                          @endif 
																</div>
															</div>
															<div class="col-md-4">
																<div class="form-group">
																	<label>Select Country</label>
																	<select name="country" required="required" class="form-control">
																		<option value>Select your country</option> 
												                            @foreach($country as $countrys)
												                            <option value="{{ $countrys->id }}" @if($countrys->id == $user->country ) selected @endif @if(old('country') == $countrys->id) selected @endif>{{ $countrys->name }}</option> 
												                            @endforeach
																	</select>
																</div>
															</div>
															
															<div class="profilebottombtn col-md-4">
																<div class="form-group"><input type="submit" name="" class="btn sitebtn" value="Submit"></div>
															</div>
														</div>
													</form>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div id="pro2" class="tab-pane fade in @if($security) show active @endif">
									<div class="panelcontentbox mt-2 securityinnerbox">
										<h2 class="heading-box">2FA Verification</h2>
										<div class="contentbox faverifybox">
											@if (session('twofasuccess'))
						                      <div class="alert alert-success success-alert alert-dismissible">				                        
						                        {{ session('twofasuccess') }}
						                      </div>
						                      @endif
						                      @if (session('twofafail'))
						                      <div class="alert alert-danger success-alert alert-dismissible">				                        
						                        {{ session('twofafail') }}
						                      </div>
						                      @endif
											<div class="profiletablebox">

												<div> <img src="{{ url('images/auth.svg') }}" class="securityiconbox"> </div>
												<div>
													<h4>Google Authentication</h4>
													<h5 class="t-gray">Used for withdrawals and security modifications</h5> </div>
													@if($user->twofa == 'google_otp' && $user->twofa_status == 1)
													<div class="text-right"><a href="{{ route('diableTwoFactor')}}" class="btn sitebtn btn-sm red-btn">Disable</a> </div>
													@else
													<div class="text-right"><a data-bs-toggle="modal" href="#auth" data-bs-target="#auth" class="btn sitebtn btn-sm green-btn">Enable</a> </div>
													@endif
											</div>
											<div class="profiletablebox optverify">
												<h4>OR</h4> </div>
											<div class="profiletablebox">
												<div> <img src="{{ url('images/email.svg') }}" class="securityiconbox"> </div>
												<div>
													<h4>Email Verification</h4>
													<h5 class="t-gray">Send 2FA code via Email</h5> </div>
													@if($user->twofa == 'email_otp' && $user->twofa_status == 1)
													<div class="text-right"><a href="{{ route('diableTwoFactor')}}" class="btn sitebtn btn-sm red-btn">Disable</a> </div>
													@else
													<div class="text-right"><a data-bs-toggle="modal" href="#emailotp" data-bs-target="#emailotp" class="btn sitebtn btn-sm green-btn">Enable</a> </div>
													@endif
											</div>
										</div>
									</div>
								</div>
								<div id="pro3" class="tab-pane fade in @if($kycv) show active @endif">
									<div class="panelcontentbox mt-2 securityinnerbox">
										<div>@if(session()->has('kycwarning'))
													<div class="alert alert-danger alert-dismissible" role="alert">
														<strong>Failed!</strong> {{ session()->get('kycwarning') }}
													</div>
													@endif</div>
										<h2 class="heading-box">KYC Verification</h2>
										<div class="contentbox faverifybox">
											<div class="profiletablebox">
												<div> <img src="{{ url('images/kyc.svg') }}" class="securityiconbox"> </div>
												
												<div>
													<h4>KYC Verification</h4>
													
													<h5 class="t-gray">Please submit your KYC for better use and usability.</h5> </div>
													@if($user->kyc_verify == 1)
								                    @php
								                      $style = "t-green";
								                      $text = "Verified";
								                      $icon = "fa-check";
								                      $link = "#";
								                      $text_color = "green";
								                    @endphp
								                    @elseif($user->kyc_verify == 2)
								                     @php
								                      $style = "t-green";
								                      $text = " KYC has been submitted successfully. Please wait for admin approval.";
								                      $icon = "fa-check";
								                      $link = "#";
								                      $text_color = "green";
								                     @endphp
								                    @else 
								                      @php
								                        $style = "t-red";
								                        $text = "Not Verified";
								                        $icon = "fa-times";
								                        $link = "kyc";
								                        $text_color = "red";
								                     @endphp
								                    @endif
								                    @if(is_object($kyc_data) && $kyc_data->status == 2)
								                    @php
								                      $style = "t-red";
								                      $text = "Admin Rejected your proof. Click to resubmit";
								                      $icon = "fa-check";
								                      $link = "kyc";
								                      $text_color = "red";
								                     @endphp
								                    @endif

								                @if($user->kyc_verify !=1)
												<div class="text-right"> <a href="{{ route('hypervergekyc') }}" class="btn sitebtn btn-sm">Update</a> </div>
												@else
												<div class="text-right"> <h4 style="color: {{$text_color}}"><i class="fa {{$icon}} f-s-14"></i> {{$text}}</h4> </div>
												@endif

											</div>
											<h3 class="heading-box" style="color: {{$text_color}}"><i class="fa {{$icon}} f-s-14"></i> {{$text}}</h3>
											
										</div>
									</div>
								</div>
								<div id="pro4" class="tab-pane fade in @if($password) show active @endif">
									<div class="panelcontentbox">
										<div class="contentpanel">
											@if(session()->has('passwordupdated'))
						                      <div class="alert alert-success alert-dismissible" role="alert">
						                      	
						                      	<strong>Success!</strong> {{ session()->get('passwordupdated') }}
						                      </div>
						                      @endif
						                      @if(session()->has('passwordnotupdated'))
						                      <div class="alert alert-danger alert-dismissible" role="alert">
						                        <strong>Failed!</strong> {{ session()->get('passwordnotupdated') }}
						                      </div>
						                      @endif   

						                      <form autocomplete="off" class="siteformbg" action="{{ url('updatePassword') }}" method="post">
						                      	 {{ csrf_field() }}  
												<div class="row">
													
														<div class="col-md-4">
															<div class="form-group">
																<label>Current Password</label>
																<input type="password" name="current_password" id="current_password" class="form-control" onkeyup="if (/\s/g.test(this.value)) this.value = this.value.replace(/\s/g,'')" required="required" /> </div>
																@if ($errors->has('current_password'))
										                        <span class="help-block">
										                          <strong class="text text-danger">{{ $errors->first('current_password') }}</strong>
										                        </span>
										                        @endif
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label>New Password</label>
																<div class="input-group">
																	<input type="password" id="password" name="new_password" class="form-control" onkeyup="if (/\s/g.test(this.value)) this.value = this.value.replace(/\s/g,'')" onkeypress="checkPasswordStrength();" required="required" />
																	<span class="input-group-text">
                                                                        <i class="fa fa-eye-slash"></i> 
                                                                    </span> </div>
                                                                    <div style="margin-top: 3%;color: red;" id="password-strength-status"></div>

											                        @if ($errors->has('new_password'))
											                        <span class="help-block">
											                          <strong class="text text-danger">{{ $errors->first('new_password') }}</strong>
											                        </span>
											                        @endif  
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label>Conform Password</label>
																<div class="input-group">
																	<input type="password" id="password-confirm" name="confirm_password" class="form-control"  onkeyup="if (/\s/g.test(this.value)) this.value = this.value.replace(/\s/g,'')" required="required" /> <span class="input-group-text">
                                                                        <i class="fa fa-eye-slash"></i> 
                                                                    </span> </div>
                                                                    <span class="error_text" id="password_match"></span>
											                        @if ($errors->has('confirm_password'))
											                        <span class="help-block">
											                          <strong class="text text-danger">{{ $errors->first('confirm_password') }}</strong>
											                        </span>
											                         @endif
															</div>
														</div>
														</div>
														<div class="form-group mt-4 pt-1">
														<input type="submit" class="btn sitebtn" value="Submit"> </div>
													
													<div class="col-xl-12 col-lg-12 col-md-12">
														<div class="notestitle mt-4 notesgray">
															<p class="content"><b>Notes :</b>
																<br/>Your password must contain at least 8 characters, one uppercase (ex: A, B, C, etc), one lowercase letter, one numeric digit (ex: 1, 2, 3, etc) and one special character (ex: @, #, $, etc).</p>
														</div>
													</div>
												
											</form>
										</div>
									</div>
								</div>
								<div id="pro5" class="tab-pane fade in @if($bankv) show active @endif">
									<div class="panelcontentbox">
										<h2 class="heading-box">Referral Information</h2>
										<div class="contentpanel">
											<!-- <hr> -->
												<div class="profiledatainfo">
													@if (session('bankstatus'))
								                      <div class="alert alert-success success-alert alert-dismissible">				                        
								                        {{ session('bankstatus') }}
								                      </div>
								                      @endif
													<form class="siteformbg" >
														{{ csrf_field() }}
														<div class="row">															
															<div class="col-md-6">
																<div class="form-group">
																	<label>URL</label>
																	<div class="copy-text">
																	<input  name="refferral-url" class="form-control" id="urladdress" type="text" value="{{ url('res/'.Auth::user()->referral_id) }}" readonly>
																	<span onclick="myCopyFunc()"><i class="fa fa-clone"></i></span>
																	</div>
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label>ID <span class="t-red">*</span></label>
																	<input  name="referral_id" class="form-control" type="text" value="{{Auth::user()->referral_id}}" disabled>
																</div>
															</div>
</div>
<div class="row">
															<div class="col-md-6">
																<div class="form-group">
																	<label>Username </label>
																	<input required="" name="username" class="form-control allletterwithspace" type="text" value="{{ $user->first_name }} {{ $user->last_name }}" disabled>
																</div>
															</div>
															
															
															@if(!empty(Auth::user()->parent_id))
															<div class="col-md-6">
																<div class="form-group">
																	<label>Referral By</label>
																	<input required="" name="swift_code" class="form-control allletterwithspace" type="text" value="{{Auth::user()->parent_id}}}">
																</div>
															</div>
															@endif
															<div class="profilebottombtn col-md-12">
																<div class="form-group referl">
																	<input type="submit" name="" class="btn sitebtn" value="Submit">
																	<a  href="{{ url('referral-info') }}"><input type="button" name="" class="btn sitebtn" value="Click to Referral Information"></a>
															</div>
															</div>

															<div class="profilebottombtn col-md-4">
																<div class="form-group"></div>
															</div>

															
														</div>
													</form>
												</div>
										</div>
									</div>
								</div>
								<div id="pro6" class="tab-pane fade in @if($paypalv) show active @endif">
									<div class="panelcontentbox">
										<h2 class="heading-box">Reward Histroy</h2>
										<div class="contentpanel">
											<!-- <hr> -->
											<div class="simplebar-content " style="padding-bottom: 17px; margin-right: -17px;overflow-x: auto !important;">
								<table class="table sitetable table-responsive-stack" id="table1">
									<thead>
										<tr>
											<th>Type</th>
											<th>Referral Name</th>
											<th>Referral Email</th>
											<th>Amount</th>
										</tr>
									</thead>
									<tbody>
										@forelse($referaldetail as $ref)
											<tr>
										     <td>{{ ucfirst($ref->type) }}</td>
											 <td>{{$ref->user->first_name }} {{$ref->user->last_name }}</td>
											 <td>{{$ref->user->email}}</td>
											 <td>{{$ref->commission}} {{$ref->coin}}</td>
											</tr>
                                        @empty
											<tr><td colspan="10" style="flex-basis: 9.09091%;"><span class="table-responsive-stack-thead" style="display: none;"></span> No Records Found</td></tr>
										@endforelse
										</tbody>
								</table>
							</div>
										</div>
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
	<div class="modal fade modalbgt" id="auth">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title">Google Authentication</h4>
<button type="button" class="close" data-bs-dismiss="modal">&times;</button>
</div>
<div class="modal-body">
<h5 class="notesh5 t-gray">Install google autheticator app in your mobile and scan QR Code (or) If you are unable to scan the QR code, please enter this code manually into the app</h5>
<form class="siteformbg" action="{{ route('google2faverify') }}" method="POST">
{{ csrf_field() }}
@if($user->google2fa_verify == 0)	
  <div class="form-group">
	<div class="input-group">
	  <input type="text" class="form-control" value="{{ $secret }}" readonly="">
	  <span class="input-group-text" id="myTooltip">Copy</span>
	</div>
  </div>
  @endif							
  <div class="form-group">
  <label class="">Enter your Code</label>			 
	  <input type="text" name="google_code" class="form-control form-control-lg" value="" />  
	  @if ($errors->has('google_code'))
    <span class="help-block">
      <strong class="text text-danger">{{ $errors->first('google_code') }}</strong>
    </span>
     @endif    
</div>
  <div class="form-group text-center qrcode">	
	<span><img src="{{$image}}"></span>                  
  </div>
  <div class="form-group text-center">
	<input type="submit" name="" class="btn sitebtn" value="Submit" />
  </div>
</form>
</div>      
</div>
</div>
</div>

<div class="modal fade modalbgt" id="emailotp">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title">Email Authentication</h4>
<button type="button" class="close" data-bs-dismiss="modal">&times;</button>
</div>
<div class="modal-body">
<h5 class="notesh5 t-gray">Send 2FA code via Email.</h5>

<form class="siteformbg" action="{{ route('emailotpverify') }}" method="POST">
@csrf	
<p>Click to <a href="{{ route('resendotp') }}"> send E-mail OTP </a></p>                						
  <div class="form-group">
  <label class="">Enter your Code</label>
  <input type="text" name="email_code" class="form-control form-control-lg" value="" /> 
@if ($errors->has('email_code'))
<span class="help-block">
  <strong class="text text-danger">{{ $errors->first('email_code') }}</strong>
</span>
 @endif			     
</div>                 
  <div class="form-group text-center">
	<input type="submit" name="" class="btn sitebtn" value="Submit" />
  </div>
</form>
</div>      
</div>
</div>
</div>

<script type="text/javascript">
$(document).ready(function() {  
    $(".success-alert").fadeTo(2000, 500).slideUp(500, function() {
      $(".success-alert").slideUp(500);
    });
  });
</script>
<div class="modal fade modalbgt" id="myPicture" role="dialog">
  <div class="modal-dialog modal-dialog-centered">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
        <h4 class="modal-title">Change Profile Picture</h4>
      </div>
      <div class="modal-body">
        <div align="center">
          <div class="controls center-btn">
            <label for="file-upload1" class="custom-file-upload"><i class="fa fa-cloud-upload"></i> Upload File</label>
            <input id="file-upload1" name="profile" type="file" style="display:none;">
            <label id="file-name3" class="custm-f"></label>
          </div>
          <br/>

          <div id="image-crop" style="display:none">
            <div id="upload-demo"></div>
          </div>  
          <br/>

          <input type="submit" value="Save" id="save_btn" class="btn sitebtn upload-result" >
        </div>
      </div>

    </div>

  </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> 
<script>

  function checkPasswordStrength() {
    var number = /([0-9])/;
    var alphabets = /([a-zA-Z])/;
    var special_characters = /([~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<])/;
    if($('#password').val().length<8) {
      $('#password-strength-status').removeClass();
      $('#password-strength-status').addClass('weak-password');
      $('#password-strength-status').html("Weak (should be atleast 8 characters,include alphabets, numbers and special characters.)");
    } else {    
      if($('#password').val().match(number) && $('#password').val().match(alphabets) && $('#password').val().match(special_characters)) {            
        $('#password-strength-status').removeClass();
        $('#password-strength-status').addClass('strong-password');
        $('#password-strength-status').html("Strong");
      } else {
        $('#password-strength-status').removeClass();
        $('#password-strength-status').addClass('medium-password');
        $('#password-strength-status').html("Medium (should include alphabets, numbers and special characters.)");
      }}}
    </script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.js"></script>

    <script type="text/javascript">

      $uploadCrop = $('#upload-demo').croppie({
        enableExif: true,
        viewport: {
          width: 200,
          height: 200,
          type: 'square'
        },
        boundary: {
          width: 300,
          height: 300
        }
      });

      $('#file-upload1').on('change', function () { 

        var a=(this.files[0].size);
        var fileExtension = ['jpg','png','jpeg'];
        if(a > 2097152) {
          alert('Allowed only size of 2 MB image');
          this.value = '';
          location.reload();
          return false;
        }

        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
          alert("Upload jpg/jpeg/png image file only.");
//$('#upload-demo').hide();
this.value = ''; // Clean field
location.reload();
return false;
}
document.getElementById("image-crop").style.display = 'block';
var reader = new FileReader();
reader.onload = function (e) {
  $uploadCrop.croppie('bind', {
    url: e.target.result
  }).then(function(){
    console.log('jQuery bind complete');
  });
}
reader.readAsDataURL(this.files[0]);
});

      $('.upload-result').on('click', function (ev) {
        $uploadCrop.croppie('result', {
          type: 'canvas',
          size: 'viewport'
        }).then(function (resp) {

          $("#save_btn")
          .val("Please Wait...")
          .attr('disabled', 'disabled');

          $.ajax({
            url: "{{  url('updateprofileimg') }}",
            type: "POST",
            data: {"image":resp,"_token": "{{ csrf_token() }}"},
            success: function (data) {
              html = '<img src="' + resp + '" />';
              $("#upload-demo-i").html(html);
              location.reload();
            }
          });
        });
      });
    </script>
<script src="{{ url('js/intlTelInput.js') }}"></script> 
<script>
 $("ul.country-list").click(function(){
var int = $('ul.country-list').find('li.active').attr('data-dial-code');
$("#country_code").val(int);
$("#phone").val('+'+int);
$(".phone_text").text('+'+int);
});
jQuery('#phone').keyup(function() {
var plus = $(this).val();
var fistchar = plus.charAt(0);
var int = $('ul.country-list').find('li.active').attr('data-dial-code');
$("#country_code").val(int);
if(fistchar != '+')
$(this).val('+'+$(this).val());

});

jQuery(document).ready(function() {
var plus = $(this).val();
var fistchar = plus.charAt(0);
var int = $('ul.country-list').find('li.active').attr('data-dial-code');
$("#country_code").val(int);
if(fistchar != '+')
$(this).val('+'+$(this).val());

});
	

</script>
<script>

	 $("#phone").intlTelInput({

  hiddenInput: "full_phone",
utilsScript: "../../build/js/utils.js?1603274336113"

});

</script>


<script>
	let copyText = document.querySelector(".copy-text");
copyText.querySelector("button").addEventListener("click", function () {
	let input = copyText.querySelector("input.text");
	input.select();
	document.execCommand("copy");
	copyText.classList.add("active");
	window.getSelection().removeAllRanges();
	setTimeout(function () {
		copyText.classList.remove("active");
	}, 2500);
});
function myCopyFunc() {
      var copyText = document.getElementById("urladdress");
      copyText.select();
      document.execCommand("Copy");
    }
</script>