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
                  <form action="{{ route('ppsellupdate')}}" method="post" class="siteformbg" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="id"   value="{{ Crypt::encrypt($sellorder->id) }}" required="required" />
                        <input type="hidden" name="type"   value="{{ $type =='fiat' ? 'fiat' : 'crypto' }}" required="required" />
                        <div class="row">
                        <div class="col-xl-5 col-lg-6 col-md-6">                          
                           <div class="form-group">
                              <table style="color:white" class="table table-borderless">
                                    <tr>
                                       <td colspan="3"><h3 class="title-header white">Order details:-</h3></td>
                                    </tr>
                                    <tr>
                                       <td>Purchase price : </td>
                                       <td>{{ $sellorder->price }} {{ $coinTwo }}</td>
                                    </tr>
                                    <tr>
                                       <td>Purchase Amount : </td>
                                       <td> {{$sellorder->remaining}} {{ $coinOne }}</td>
                                    </tr>
                                    <tr>
                                       <td>Payment Type : </td>
                                       <td> {{ $sellorder->paymenttype }} </td>
                                    </tr>
                                    
                                    <tr>
                                       <td>Status : </td>
                                       <td>{{ $sellorder->status_text }}  </td>
                                    </tr>
                                    
                                    <tr>
                                       <td>Remarks : </td>
                                       <td>{{ $sellorder->remarks }}  </td>
                                    </tr>
                                    
                                 </table>  
                           </div>
                           @if($sellorder->status != 100 && $sellorder->status != 7 && $sellorder->status != 5 && $sellorder->status != 6)
                           @if($is_owner == 1)
                           <div class="form-group">
                              <label>Action</label>
                              <div class="input-group">
                                 <select class="form-control" name="status" required> 
                                 <option disabled>Select option</option>
                                    <option {{ old('status') == 100 ? 'selected' : '' }} value="100">Release Fund</option>
                                    <option {{ old('status') == 4 ? 'selected' : '' }} value="4">Cancel</option>
                                    <option {{ old('status') == 6 ? 'selected' : '' }} value="6">Dispute query</option>
                                 </select>                                    
                              </div>
                              @if ($errors->has('status'))
                                    <span class="help-block">
                                    <strong class="text text-danger">{{ $errors->first('status') }}</strong>
                                    </span>
                              @endif  
                           </div>
                           @else
                              @if($type == 'fiat')
                              <div class="form-group">
                                 <label>Upload Proof</label>
                                 <div class="input-group">
                                    <input type="file" id="proof" name="slipupload" class="form-control " required="required" />                                    
                                 </div>
                                 @if ($errors->has('proof'))
                                    <span class="help-block">
                                       <strong class="text text-danger">{{ $errors->first('proof') }}</strong>
                                    </span>
                                 @endif
                              </div>
                             @endif
                           <div class="form-group">
                              <label>Action</label>
                              <div class="input-group">
                                 <select class="form-control" name="status" required> 
                                 <option disabled>Select option</option>                      
                                    <option {{ old('status') == 100 ? 'selected' : '' }} value="100">Request to Release Fund</option>
                                    <option {{ old('status') == 4 ? 'selected' : '' }} value="4">Cancel</option>
                                    @if($sellorder->status == 4)
                                    <option {{ old('status') == 6 ? 'selected' : '' }} value="6">Dispute query</option>
                                    @endif
                                 </select>                                    
                              </div>
                              @if ($errors->has('status'))
                                    <span class="help-block">
                                    <strong class="text text-danger">{{ $errors->first('status') }}</strong>
                                    </span>
                              @endif  
                           </div>
                           @endif
                           <div class="form-group">
                              <label>Remark<span class="t-red">*</span></label>
                              <div class="input-group">
                                 <textarea class="form-control" name="remarks" required></textarea>                
                              </div>
                              @if ($errors->has('status'))
                                    <span class="help-block">
                                    <strong class="text text-danger">{{ $errors->first('status') }}</strong>
                                    </span>
                              @endif  
                           </div>
                           
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
                                       <td>{{$sellorder->account_name}} </td>
                                    </tr>
                                    <tr>
                                       <td>IBAN/Account Number : </td>
                                       <td> {{$sellorder->account_no}} </td>
                                    </tr>
                                    <tr>
                                       <td>Bank Account Information : </td>
                                       <td> {{$sellorder->bank_name}} </td>
                                    </tr>
                                    
                                    <tr>
                                       <td>BIC/SORT Code : </td>
                                       <td>{{$sellorder->swift_code}}  </td>
                                    </tr>
                                    @if($sellorder->paypal_id !="")
                                    <tr>
                                       <td colspan="2"><h3 class="title-header white">Seller Paypal details:-</h3></td>
                                    </tr>
                                    <tr>
                                       <td>Paypal ID : </td>
                                       <td>{{ $sellorder->paypal_id }} </td>
                                    </tr>
                                   @endif
                                    
                                 </table>
                              </div>
                              @if($sellorder->slipupload != "")
                              <div class="form-group">
                                 <label>Uploaded Proof</label>
                                 <div class="input-group">
                                    <a href="{{ $sellorder->slipupload }}" target="_blank"><img src="{{ $sellorder->slipupload }}" style="width: 420px;">  </a>                                  
                                 </div>
                              </div>
                              @endif
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