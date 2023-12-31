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
            <h2 class="heading-box ">SELL {{ $coinOne }}</h2>
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
                 <form action="{{ route('ppsellsubmit')}}" method="post" class="siteformbg" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="id"   value="{{ Crypt::encrypt($sellorder->id) }}" required="required" />
                        <input type="hidden" name="type"   value="{{ $type =='fiat' ? 'fiat' : 'crypto' }}" required="required" />
                        <div class="row">
                        <div class="col-xl-5 col-lg-6 col-md-6">                          
                           <div class="form-group">
                              <label>PRICE</label>
                              <div class="input-group">
                                    <input class="form-control" value="{{$sellorder->price}}" id="sellprice" disabled>                                               
                              </div>
                           </div>
                           <div class="form-group">
                              <label>AVAILABLE QUANTITY</label>
                              <div class="input-group">
                              <input class="form-control" value="{{$sellorder->remaining}}"  disabled>
                              </div> 
                           </div>
                           <div class="form-group">
                              <label>Request Payment Type</label>
                              <div class="input-group">
                                 <select class="form-control" name="paymenttype">
                                    @if($type == 'fiat')
                                    <option {{ old('paymenttype') == 'Bank' ? 'selected' : '' }}>Bank</option>
                                    <option {{ old('paymenttype') == 'Paypal' ? 'selected' : '' }}>Paypal</option>
                                    <option {{ old('paymenttype') == 'Both' ? 'selected' : '' }}>Both</option>
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
                           <div class="form-group">
                              <label>YOUR ORDER</label>
                              <div class="input-group">
                                 <input type="number" name="amount" id="sellvolume" class="form-control" required="required" />
                                   
                              </div>
                              <span id="warning-alert" class="text-warning"></span>
                              @if ($errors->has('amount'))
                                    <span class="help-block">
                                    <strong class="text text-danger">{{ $errors->first('amount') }}</strong>
                                    </span>
                              @endif  
                           </div>
                           <div class="form-group">													
										<div class="commision">You Will Received: <span class="feeamt" id="selltotal">0.0000000 </span>{{$coinTwo}}</div>
										</span>
									</div>
                           @if($sellorder->status == 0)
                           <div class="text-center form-group">
                                 <input type="submit" class="btn btn-gray site-btn m-btn mt-20  text-uppercase nova-font-bold" value="Submit" id="submitsell">
                           </div>
                           @endif
                        </div>
                        <div class="col-xl-5 col-lg-6 col-md-6 pl-4 pr-4">
                           <div class="form-group">
                                 <table style="color:white" class="table table-borderless">
                                    <tr>
                                       <td colspan="2"><h3 class="title-header white"> Your Bank details:-</h3></td>
                                    </tr>
                                    <tr>
                                       <td>Account Holder Name:  </td>
                                       <td>{{$bankuser->account_name}} </td>
                                    </tr>
                                    <tr>
                                       <td>IBAN/Account Number: </td>
                                       <td> {{$bankuser->account_no}} </td>
                                    </tr>
                                    <tr>
                                       <td>Bank Account Information: </td>
                                       <td> {{$bankuser->bank_name}} </td>
                                    </tr>
                                    
                                    <tr>
                                       <td>BIC/SORT Code: </td>
                                       <td>{{$bankuser->swift_code}}  </td>
                                    </tr>
                                   @if($bankuser->paypal_id !="")
                                    <tr>
                                       <td colspan="2"><h3 class="title-header white">Your Paypal details:-</h3></td>
                                    </tr>
                                    <tr>
                                       <td>Paypal ID : </td>
                                       <td>{{ $bankuser->paypal_id }} </td>
                                    </tr>
                                   @endif
                                    
                                 </table>
                              </div>
                           
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
   
$('#sellvolume').on('keyup', function(){
	sellcal();
});
   function sellcal(){
	var sellprice = parseFloat($('#sellprice').val());
	var sellvolume = parseFloat($('#sellvolume').val());
   var available = parseFloat({{ $sellorder->remaining }});
	var selltotal = parseFloat(sellprice) * parseFloat(sellvolume);
   selltotal = parseFloat(selltotal);
   
   if(selltotal > 0){
      if(sellvolume > available){
         $("#submitsell").hide();
         $("#warning-alert").html('Avilable only '+available);
      } else{
         $("#submitsell").show();
         $("#warning-alert").html('');
      }
		document.getElementById('selltotal').value = selltotal;
		
		$('#selltotal').html(selltotal);
	} else {
		$('#selltotal').html(0);
		document.getElementById('selltotal').value = 0;
	}
}
</script>
