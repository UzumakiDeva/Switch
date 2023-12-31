@include('layouts.header')
<div class="pagecontent gridpagecontent innerpagegrid">
@include('layouts.headermenu')
</section>
<style type="text/css">
   input::-webkit-outer-spin-button,
   input::-webkit-inner-spin-button {
     -webkit-appearance: none;
     margin: 0;
   }
</style>
<article class="gridparentbox">
   <div class="container sitecontainer walletpagebg">
      <div id="deposit" class="depositbg">
         
         <div class="panelcontentbox">
            <h2 class="heading-box ">BUY {{ $coinOne }}</h2>
            <div class="contentpanel">
               <!-- <a href=""><i class="fa fa-arrow-left"></i></a><br/> -->
               <div id="cryptodpst" class="tab-pane fade in show active">
                   @if(session()->has('failed'))
                     <div class="alert alert-danger alert-dismissible" role="alert">
                        <strong>@lang('common.Failed')!</strong> {{ session()->get('failed') }}
                     </div>
                     @endif  
                     @if(session()->has('success'))
                     <div class="alert alert-success alert-dismissible" role="alert"><strong>@lang('common.Success')!</strong> {{ session()->get('success') }}
                     </div>
                     @endif
                  <form action="{{ route('ppbuysubmit')}}" method="post" class="siteformbg" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="id"   value="{{ Crypt::encrypt($buyorder->id) }}" required="required" />
                        <input type="hidden" name="type"   value="{{ $type =='fiat' ? 'fiat' : 'crypto' }}" required="required" />
                        <div class="row">
                        <div class="col-xl-5 col-lg-6 col-md-6">                          
                           <div class="form-group">
                              <label>PRICE</label>
                              <div class="input-group">
                                    <input class="form-control" value="{{$buyorder->price}}" id="buyprice" disabled>                                
                                                 
                              </div>
                              @if ($errors->has('amount'))
                                    <span class="help-block">
                                    <strong class="text text-danger">{{ $errors->first('amount') }}</strong>
                                    </span>
                              @endif  
                           </div>
                           <div class="form-group">
                              <label>AVAILABLE QUANTITY</label>
                              <div class="input-group">
                              <input class="form-control" value="{{$buyorder->remaining}}" id="" disabled>
                              </div>
                              @if ($errors->has('amount'))
                                    <span class="help-block">
                                    <strong class="text text-danger">{{ $errors->first('amount') }}</strong>
                                    </span>
                              @endif  
                           </div>
                           <div class="form-group">
                              <label>YOUR ORDER</label>
                              <div class="input-group">
                                 <input type="number" name="amount" step="any" id="buyvolume" class="form-control" value="{{ old('amount') }}" required="required" />
                                    
                              </div>
                              <span id="warning-alert" class="text-warning"></span>
                              @if ($errors->has('amount'))
                                    <span class="help-block">
                                    <strong class="text text-danger">{{ $errors->first('amount') }}</strong>
                                    </span>
                              @endif  
                           </div>
                           <div class="form-group">													
										<div class="commision">You Paid: <span class="feeamt" id="buytotal">0.0000000 </span> {{ $coinTwo }}</div>
										</span>
									</div>
                           <div class="form-group">
                              <label>Payment Type</label>
                              <div class="input-group">
                                 <select class="form-control" name="paymenttype" >
                                    @if($type == 'fiat')
                                    <option {{ old('paymenttype') == 'Bank' ? 'selected' : '' }}>Bank</option>
                                    <option {{ old('paymenttype') == 'Paypal' ? 'selected' : '' }}>Paypal</option>
                                    @else
                                    <option>Crypto</option>
                                    @endif
                                 </select>                                    
                              </div>
                              @if ($errors->has('paymenttype'))
                                    <span class="help-block">
                                    <strong class="text text-danger">{{ $errors->first('paymenttype') }}</strong>
                                    </span>
                              @endif  
                           </div>
                           @if($type == 'fiat')
                           <div class="form-group">
                              <label>Upload Proof</label>
                              <div class="input-group">
                                 <input type="file" id="proof" name="slipupload" class="form-control " required="required" />                                    
                              </div>
                              @if ($errors->has('slipupload'))
                                 <span class="help-block">
                                    <strong class="text text-danger">{{ $errors->first('slipupload') }}</strong>
                                 </span>
                              @endif
                           </div>
                          @endif
                          @if($buyorder->status == 0)
                           <div class="text-center form-group">
                                 <input type="submit" class="btn btn-gray site-btn m-btn mt-20  text-uppercase nova-font-bold" value="Submit" id="submitbuy">
                           </div>
                           @endif
                        </div>
                        <div class="col-xl-5 col-lg-6 col-md-6 pl-4 pr-4">
                           @if($type == 'fiat')
                        <div class="form-group">
                                 <table style="color:white" class="table table-borderless">
                                    <tr>
                                       <td colspan="2"><h3 class="title-header white">Seller Bank details:-</h3></td>
                                    </tr>
                                    <tr>
                                       <td>Account Holder Name : </td>
                                       <td>{{$buyorder->account_name}} </td>
                                    </tr>
                                    <tr>
                                       <td>IBAN/Account Number : </td>
                                       <td> {{$buyorder->account_no}} </td>
                                    </tr>
                                    <tr>
                                       <td>Bank Account Information : </td>
                                       <td> {{$buyorder->bank_name}} </td>
                                    </tr>
                                    
                                    <tr>
                                       <td>BIC/SORT Code : </td>
                                       <td>{{$buyorder->swift_code}}  </td>
                                    </tr>
                                    @if($buyorder->paypal_id !="")
                                    <tr>
                                       <td colspan="2"><h3 class="title-header white">Seller Paypal details:-</h3></td>
                                    </tr>
                                    <tr>
                                       <td>Paypal ID : </td>
                                       <td>{{ $buyorder->paypal_id }} </td>
                                    </tr>
                                   @endif
                                    
                                 </table>
                              </div>
                           @endif
                        </div>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</article>
@include('layouts.footermenu')
</div>
@include('layouts.footer')
</div>
<script>
   
$('#buyvolume').on('keyup', function(){
	buycal();
});
   function buycal(){
	var buyprice = parseFloat($('#buyprice').val());
	var buyvolume = parseFloat($('#buyvolume').val());
   var available = parseFloat({{ $buyorder->remaining }});
	var buytotal = parseFloat(buyprice) * parseFloat(buyvolume );
   buytotal = parseFloat(buytotal);
   
   if(buyvolume > 0){
      if(buyvolume > available){
         $("#submitbuy").hide();
         $("#warning-alert").html('Avilable only '+available);
      } else{
         $("#submitbuy").show();
         $("#warning-alert").html('');
      }
		document.getElementById('buytotal').value = buytotal;      	
		$('#buytotal').html(buytotal);
	} else {
		$('#buytotal').html(0);
		document.getElementById('buytotal').value = 0;
	}
}
</script>

