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
                  <form action="{{ route('ppbuyupdate')}}" method="post" class="siteformbg" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="id"   value="{{ Crypt::encrypt($buyorder->id) }}" required="required" />
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
                                       <td>{{ $buyorder->price }} {{ $coinTwo }}</td>
                                    </tr>
                                    <tr>
                                       <td>Purchase Amount : </td>
                                       <td> {{$buyorder->remaining}} {{ $coinOne }}</td>
                                    </tr>
                                    <tr>
                                       <td>Payment Type : </td>
                                       <td> {{ $buyorder->paymenttype }} </td>
                                    </tr>
                                    
                                    <tr>
                                       <td>Status : </td>
                                       <td>{{ $buyorder->status_text }}  </td>
                                    </tr>
                                    
                                    <tr>
                                       <td>Remarks : </td>
                                       <td>{{ $buyorder->remarks }}  </td>
                                    </tr>
                                    
                                 </table>  
                           </div>
                           @if($buyorder->status != 100 && $buyorder->status != 7 && $buyorder->status != 5 && $buyorder->status != 6)
                           @if($is_owner == 1)
                           <div class="form-group">
                              <label>Action</label>
                              <div class="input-group">
                                 <select class="form-control" name="status" required> 
                                 <option disabled>Select option</option>                      
                                    <option {{ old('status') == 7 ? 'selected' : '' }} value="7">Cancel</option>
                                    <option {{ old('status') == 5 ? 'selected' : '' }} value="5">Dispute query</option>
                                 </select>                                    
                              </div>
                              @if ($errors->has('status'))
                                    <span class="help-block">
                                    <strong class="text text-danger">{{ $errors->first('status') }}</strong>
                                    </span>
                              @endif  
                           </div>
                           @else
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
                              <div class="form-group">
                                 <label>Uploaded Proof</label>
                                 <div class="input-group">
                                    <a href="{{ $buyorder->slipupload }}" target="_blank"><img src="{{ $buyorder->slipupload }}" style="width: 420px;">  </a>                                  
                                 </div>
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