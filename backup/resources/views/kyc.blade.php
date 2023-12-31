@php $title = "KYC"; $atitle ="kyc";
@endphp
@include('layouts.header')
<div class="pagecontent gridpagecontent innerpagegrid">
@include('layouts.headermenu')
    
</section>
    <article class="gridparentbox"> 
    <div class="container sitecontainer profilepagebg">
        <div class="innerpagecontent">
            <h2 class="h2">KYC Verification</h2>
        </div>
        
        <div class="panelcontentbox">
            <div class="contentbox">
                <div class="kyctablebox kycpagebg">
                    <div class="kycboxleft">

                        <div class="mlmwizardform">
                            @if ($message = Session::get('error'))
                                <div class="alert alert-danger alert-block">
                                    <button type="button" class="close" data-dismiss="alert">×</button> 
                                    <strong>{!! $message !!}</strong>
                                </div>
                            @endif
                            <form id="msform" class="siteformbg" action="{{ route('uploadkyc') }}" enctype="multipart/form-data" method="POST" autocomplete="off">                              
                                <div class="progressbg whiteboxbg">
                                <ul id="progressbar">
                                    <!--<li class="active" id="account"><strong>01</strong><span class="infot">Personal</span></li>
                                    <li id="personal"><strong>02</strong><span class="infot">ID Proof Info</span></li>
                                    <li id="proof"><strong>03</strong><span class="infot">Attachment</span></li> !-->
                                </ul>
                            </div>
                            <div class="kycformright">
                                <fieldset>
                            <div class="form-card">
                                <h5 class="subheading">Personal Information</h5>
                                @csrf
                                <hr/>
                                <div class="row">
                                    
                                    <div class="col-md-6">
                                    <div class="form-group">     
                                        <label>First Name(Please use Real Name)<span class="t-red">*</span></label>                                   
                                        <input name="first_name" class="form-control allletterwithspace" type="text" required="required" value="{{ old('first_name') }}"> 
                                        @if ($errors->has('first_name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                        </span>
                                        @endif
                                </div>  
                                <p class ="text text-blue">Note:                            
                                   Name must match the information in the ID Card/Passport
                                </p>
                                </div>      
                                <div class="col-md-6">              
                                    <div class="form-group">
                                        <label>Last Name<span class="t-red">*</span></label>
                                        <input name="last_name" required="required" class="form-control allletterwithspace" type="text" value="{{ old('last_name') }}">
                                        @if ($errors->has('last_name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                        </span>
                                        @endif
                                </div>
                                </div>                                
                            </div>
                            <div class="row">
                                    <div class="col-md-6">
                                    <div class="form-group">     
                                        <label>Phone Number</label>                                   
                                        <input name="phone_no" class="form-control allletterwithspace" type="text"  value="{{ old('phone_no') }}"> 
                                        @if ($errors->has('phone_no'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('phone_no') }}</strong>
                                        </span>
                                        @endif
                                </div>  
                                </div>      
                                <div class="col-md-6">              
                                    <div class="form-group">
                                <label>Gender<span class="t-red">*</span></label>
                                    <select name="gender_type" class="country-text form-control" required>
                                        <option value="">Select Gender Type</option> 
                                        <option value="Female"  {{ old('gender_type') == 'Female' ? 'selected' : '' }}>Female</option>
                                        <option value="Male" {{ old('gender_type') == 'Male' ? 'selected' : '' }}>Male</option>
                                        <option value="Other" {{ old('gender_type') == 'Other' ? 'selected' : '' }}>Other</option>
                                        </select>

                                        @if ($errors->has('gender_type'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('gender_type') }}</strong>
                                        </span>
                                        @endif
                                </div>
                                </div>                                
                            </div>
                            <div class="row">
								<div class="col-md-6">
                                    <div class="form-group">
                                     <label>Date of Birth<span class="t-red">*</span></label>
                                    <div class="input-group dateinput">                                 
                                        <input type="text" class="form-control" name="dob"   value="{{ old('dob') }}" required/>
                                            <span class="input-group-text" data-toggle="datepicker1" data-target-name="dob"><i class="fa fa-calendar"></i></span>
                                    </div>
                                      @if ($errors->has('dob'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('dob') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                    
                                <div class="col-md-6">              
                                    <div class="form-group">
                                        <label>Country <span class="t-red">*</span></label>
                                        <select name="country" required="required" class="form-control">
                                            <option value>Select your country</option> 
                                                @foreach($country as $countrys)
                                                <option value="{{ $countrys->name }}">{{ $countrys->name }}</option> 
                                                @endforeach
                                        </select>
                                        @if ($errors->has('country'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('country') }}</strong>
                                        </span>
                                        @endif
                                </div>
                                </div>                                
                            </div>
                            <div class="row">
                                    <div class="col-md-6">
                                    <div class="form-group">     
                                        <label>State<span class="t-red">*</span></label>                                   
                                        <input name="state" class="form-control allletterwithspace" type="text" required="required" value="{{ old('state') }}"> 
                                        @if ($errors->has('state'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('state') }}</strong>
                                        </span>
                                        @endif
                                </div>  
                                </div>      
                                <div class="col-md-6">
                                    <div class="form-group">
                                       <label>City <span class="t-red">*</span></label>
                                        <input name="city" class="form-control allletterwithspace" type="text" required="required" value="{{ old('city') }}" >
                                        @if ($errors->has('city'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('city') }}</strong>
                                        </span>
                                        @endif
                                   </div>
                                </div>                            
                            </div>
                            
                            <div class="row">
                            <div class="col-md-6">              
                                    <div class="form-group">
                                        <label>Zip / Postal Code <span class="t-red">*</span>  </label>
                                        <input name="zip_code" required="required" class="form-control allletterwithspace" type="text" value="{{ old('zip_code') }}">
                                        @if ($errors->has('zip_code'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('zip_code') }}</strong>
                                        </span>
                                        @endif
                                </div>
                                </div>      
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                       <label>Telegram Username </label>
                                        <input name="telegram_name" class="form-control allletterwithspace" type="text"  value="{{ old('telegram_name') }}">
                                        @if ($errors->has('telegram_name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('telegram_name') }}</strong>
                                        </span>
                                        @endif
                                   </div>
                                </div>
                            </div>
                        
                            <div class="row">
                                    <div class="col-md-6">
                                    <div class="form-group textareabox">
                                        <label>Address Line 1 <span class="t-red">*</span></label>
                                        <textarea name="address_line1" class="form-control" rows="5" required="required">{{old('address_line1')}}</textarea>
                                        @if ($errors->has('address_line1'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('address_line1') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    </div>
                            
                            <div class="col-md-6">
                                    <div class="form-group textareabox">
                                        <label>Address Line 2 </label>
                                        <textarea name="address_line2" class="form-control" rows="5" >{{old('address_line2')}}</textarea>
                                        @if ($errors->has('address_line2'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('address_line2') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    </div>
                            
                            </div>
</div>
                            
                            
                                
                                <p  class="text text-blue"> Note: 
                                Please type carefully and fill out the form with your personal details. You are not allowed to edit the details once you have submitted the application.</p>
                                <div class="form-card">
                                
                            <h5 class="subheading">ID Proof Details</h5>
                                <hr/>
                                <div class="row">
                                    <p  class="text text-blue">Upload here your Passport (your photo and all 4 corners of your ID / Passport must be visible.
There is no light glare or reflections on the card.</p>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                <div class="form-group">
                                <label>ID document type<span class="t-red">*</span></label>
                                <select name="id_type" class="country-text form-control" required="required" >
                                    <option value="">Select ID Type</option> 
                                    <option value="Passport"  {{ old('id_type') == 'Passport' ? 'selected' : '' }}>Passport</option>
                                    <option value="National Identity Card" {{ old('id_type') == 'National Identity Card' ? 'selected' : '' }}>National Identity Card</option>
                                    <option value="Driving License" {{ old('id_type') == 'Driving License' ? 'selected' : '' }}>Driving License</option>
                                    <option value="Government issue Id" {{ old('id_type') == 'Government issue Id' ? 'selected' : '' }}>Government issue Id</option>
                                    <option value="Others" {{ old('id_type') == 'Others' ? 'selected' : '' }}>Others</option>
                                </select> 
                                @if ($errors->has('id_type'))
                                <span class="help-block">
                                <strong>{{ $errors->first('id_type') }}</strong>
                                </span>
                                @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>ID document number<span class="t-red">*</span></label>
                                    <input name="id_number" class="form-control allletterwithnumber" type="text" required="required" value="{{ old('id_number') }}" >
                                    @if ($errors->has('id_number'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('id_number') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
							<div class="col-md-6">
								<div class="form-group">
								 <label>Expiry Date</label>
								<div class="input-group dateinput">                                 
									<input type="text" class="form-control" name="id_exp"   value="{{ old('id_exp') }}" />
										<span class="input-group-text" data-toggle="datepicker2" data-target-name="id_exp"><i class="fa fa-calendar"></i></span>
								</div>
								  @if ($errors->has('id_exp'))
									<span class="help-block">
									<strong>{{ $errors->first('id_exp') }}</strong>
									</span>
									@endif
								</div>
							</div>
                        </div>
                        <div class="form-card">
                            
                            <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group kycupload">
                                        <label>ID Front Document <span class="t-red">*</span></label><br/>
                                            <img id="blah" src="{{ url('images/frontpage.png')}}" class="img-responsive"><br/>   
                                            <label for="file-upload1" class="custom-file-upload customupload">
                                            Upload here..</label>
                                            <input id="file-upload1" onchange="readURL(this);" name="front_upload_id" type="file" style="display:none;" required>
                                            <label id="file-name1" class="customupload1"></label>
                                            @if ($errors->has('front_upload_id'))
                                                <span class="text-danger">
                                                <strong>{{ $errors->first('front_upload_id') }}</strong>
                                                </span>
                                                @endif
                                        </div>
                                    </div>      
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group kycupload">
                                            <label>ID Back Document <span class="t-red">*</span></label><br/>
                                            <img id="upload" src="{{ url('images/vector-id-back.png')}}" class="img-responsive"><br/>
                                                <label for="file-upload2" class="custom-file-upload customupload">
                                                Upload here..</label>
                                               
                                                <input id="file-upload2" onchange="readUpload(this);" name="back_upload_id" type="file" style="display:none;"  required    >
                                                <label id="file-name2" class="customupload1"></label>
                                               
                                            @if ($errors->has('back_upload_id'))
                                            <span class="text-danger">
                                            <strong>{{ $errors->first('back_upload_id') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div> 
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group kycupload">
                                            <label>Selfie with an ID document <span class="t-red">*</span></label><br/>

                                            <img id="upload4" src="{{ url('images/selfie-hand.png') }}" class="img-responsive"><br/>
                                                <label for="file-upload4" class="custom-file-upload customupload">
                                                Upload here..</label>
                                               
                                                <input id="file-upload4" onchange="readURL4(this);" name="selfie_upload_id" type="file" style="display:none;"  required    >
                                                <label id="file-name4" class="customupload4"></label>
                                               <p class ="text text-blue">Hold the front of the badge next to your face. If the ID is very clear, take a picture. Check the photo to see if you can read the ID on it. The badge must be legible when you zoom in 1X</p>
                                            @if ($errors->has('back_upload_id'))
                                            <span class="text-danger">
                                            <strong>{{ $errors->first('back_upload_id') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>                                 
                                </div>
                            </div>
                        <div class="row">
                            <h5 class="subheading">Proof Adddress</h5>
                                <hr/>
                                    <div class="col-md-6">

                                <div class="form-group">
                                    <label>Proof of address<span class="t-red">*</span> </label>

                                    <select name="residencetype" class="country-text form-control" required="required" >
                                        <option value="Bank Statement"  {{ old('residencetype') == 'Bank Statement' ? 'selected' : '' }}>Bank Statement</option>
                                        <option value="Tax Bill" {{ old('residencetype') == 'Tax statement' ? 'selected' : '' }}>Tax statement</option>
                                        <option value="Electriccity Bill" {{ old('residencetype') == 'Utility bills (gas, electricity, water)' ? 'selected' : '' }}>Utility bills (gas, electricity, water)</option>
                                        <option value="Phone Statement" {{ old('residencetype') == 'Telephone / Internet bill (no cell phone bill)' ? 'selected' : '' }}>Telephone / Internet bill (no cell phone bill)</option>
                                        <option value="Phone Statement" {{ old('residencetype') == 'Pension statement' ? 'selected' : '' }}>Pension statement</option>
                                        <option value="Phone Statement" {{ old('residencetype') == 'Certificate of registration' ? 'selected' : '' }}>Certificate of registration</option>
                                        <option value="Phone Statement" {{ old('residencetype') == 'Bank confirmation' ? 'selected' : '' }}>Bank confirmation</option>
                                        </select>
                                        <small>The following documents (not older than 2 months) are accepted:</small>
                                        <ul class="text text-white">
                                        <li> Utility bills (gas, electricity, water)</li>
                                        <li>Telephone / Internet bill (no cell phone bill)</li>
                                        <li> Pension statement</li>
                                        <li>Tax statement</li>
                                        <li> Certificate of registration</li>
                                        <li>Bank confirmation</li>
                                        Advertising letters are not accepted!
                                        </ul>
                                        @if ($errors->has('residencetype'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('residencetype') }}</strong>
                                        </span>
                                        @endif
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                        <div class="form-group kycupload">
                                        <label>Residential document or phone document upload  <span class="t-red">*</span></label><br/>
                                            <img id="upload3" src="images/document.png" class="img-responsive"><br/>   
                                            <label for="file-upload3" class="custom-file-upload customupload">
                                            Upload here..</label>
                                            <input id="file-upload3" onchange="readURL3(this);" name="resident_upload_id" type="file" style="display:none;" required>
                                            <label id="file-name3" class="customupload3">Please photograph the complete document (all 4 corners must be visible). The document must contain the same address as your ID card</label>
                                            @if ($errors->has('front_upload_id'))
                                            <span class="text-danger">
                                            <strong>{{ $errors->first('front_upload_id') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div> 
                            <div class="form-card">
                            
                            <div class="row">
                                         
                                                                      
                                </div>
                            </div>
                                </div>      
                    
                            </div>
                            <br>
                            <p class ="text text-blue">Note:
                            
                                To avoid delays with verification process, please double-check to ensure the above requirements are fully met.

                            Chosen credential must not be expired.
                            </p>
                            <ul class="text text-white">
                                <li>I have read the Terms and Condition and AML-KYC.</li>
                                <li>All the personal information I have entered is correct.</li>
                                <li>I certify that, I am registering to participate in the Panther Exchange distribution event(s) in the capacity of an individual (and
                            beneficial owner) and not as an agent or representative of a third party corporate entity.</li>

                                                       </ul><br>

                            
                            <input type="submit" name="" class="btn sitebtn" value="Submit" />
                           
                        </fieldset>
                        <fieldset>
                            
</fieldset>                         
                        <fieldset>
                            
                        </fieldset>
        
</div>

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
    $(document).ready(function() {
        var current_fs, next_fs, previous_fs; 
        var opacity;
        $(".next").click(function() {
            current_fs = $(this).parent();
            next_fs = $(this).parent().next();
            $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
            next_fs.show();
            current_fs.animate({
                opacity: 0
            }, {
                step: function(now) {
                    opacity = 1 - now;
                    current_fs.css({
                        'display': 'none',
                        'position': 'relative'
                    });
                    next_fs.css({
                        'opacity': opacity
                    });
                },
                duration: 600
            });
        });
        $(".previous").click(function() {
            current_fs = $(this).parent();
            previous_fs = $(this).parent().prev();
            $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
            previous_fs.show();
            current_fs.animate({
                opacity: 0
            }, {
                step: function(now) {
                    opacity = 1 - now;
                    current_fs.css({
                        'display': 'none',
                        'position': 'relative'
                    });
                    previous_fs.css({
                        'opacity': opacity
                    });
                },
                duration: 600
            });
        });
        $('.radio-group .radio').click(function() {
            $(this).parent().find('.radio').removeClass('selected');
            $(this).addClass('selected');
        });
        $(".submit").click(function() {
            return false;
        })
    });
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blah')
                    .attr('src', e.target.result)
                    //.width(150)
                    //.height(200);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
    function readURL3(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#upload3')
                    .attr('src', e.target.result)
                    //.width(150)
                    //.height(200);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
    function readURL4(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#upload4')
                    .attr('src', e.target.result)
                    //.width(150)
                    //.height(200);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    function readUpload(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#upload')
                    .attr('src', e.target.result)
                    //.width(150)
                    //.height(200);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>  