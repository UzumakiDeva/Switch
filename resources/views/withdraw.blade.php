@php $title = $coin." Withdraw"; $atitle ="wallet";
@endphp
@include('layouts.header')
<div class="pagecontent gridpagecontent innerpagegrid">
@include('layouts.headermenu')
			</section>
			<article class="gridparentbox">
				<div class="container sitecontainer walletpagebg">
					
					    <div id="deposit" class="depositbg">
							<div class="panelcontentbox">
								<h2 class="heading-box">Withdraw</h2>
								<div class="contentpanel">

										<div id="cryptodpst" class="tab-pane fade in show active">
											<form class="siteformbg"  method="POST" action="{{ url('verifywithdraw') }}">
												<div class="row">
													@if (session('success'))
						                              <div class="alert alert-success">
						                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						                                {{ session('success') }}
						                            </div>
						                            @endif
						                            @if (session('fail'))
						                            <div class="alert alert-danger">
						                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						                                {{ session('fail') }}
						                            </div>
						                            @endif
						                            @if($errors->any())
													    {!! implode('', $errors->all('<div class="alert alert-danger">:message</div>')) !!}
													@endif
													@csrf
													<div class="col-xl-5 col-lg-6 col-md-6">
														<div class="form-group">
															<label class="form-label">Select Crypto <span class="text text-danger">*</span></label>
															<select class="form-control" name="coin" onchange="pageredirect(this)">
															@forelse($coinLists as $coinlist)
															<option value="{{ $coinlist->source }}" @if($coinlist->source == $coin) selected @endif>{{ $coinlist->source }} </option>
															@empty
															<option value="">No Coin list</option>
															@endforelse
															</select>
															@error('coin')
				                                                <span class="invalid-feedback" role="alert">
				                                                    <strong>{{ $message }}</strong>
				                                                </span>
				                                            @enderror
														</div>
														<div class="form-group">
															<label>To Address</label>
															<div class="input-group">
																<input class="form-control" value="" name="address" id="" > 
															</div>
															@error('address')
				                                                <span class="text-danger" role="alert">
				                                                    <strong>{{ $message }}</strong>
				                                                </span>
				                                            @enderror
														</div>
														@if($coin == 'XRP')
														<div class="form-group">
															<label>DESTINATION TAG</label>
															<div class="input-group">
																<input class="form-control" value="" name="destination_tag" id="" > 
															</div>
															@error('destination_tag')
				                                                <span class="text-danger" role="alert">
				                                                    <strong>{{ $message }}</strong>
				                                                </span>
				                                            @enderror
														</div>
														@endif
														<div class="form-group  has-feedback">
						                                    <label>Network</label>
						                                    <select id='purpose' class="form-control" name="network">
						                                    @forelse($tokenLists as $tokenList)
						                                    	@if($tokenList->type == 'token' || $tokenList->type == 'erctoken')
						                                        <option value="{{ $tokenList->type }}" data-rc="{{ $tokenList->withdraw }}" data-mw="{{ $tokenList->min_withdraw}}"  data-rt="{{ $tokenList->com_type }}">Ethereum (ERC20)</option>
						                                        @elseif($tokenList->type == 'trxtoken')
						                                        <option value="{{ $tokenList->type }}" data-rc="{{ $tokenList->withdraw }}" data-mw="{{ $tokenList->min_withdraw}}"  data-rt="{{ $tokenList->com_type }}">Tron (TRC20)</option>
						                                        @elseif($tokenList->type == 'bsctoken')
						                                        <option value="{{ $tokenList->type }}" data-rc="{{ $tokenList->withdraw }}" data-mw="{{ $tokenList->min_withdraw}}"  data-rt="{{ $tokenList->com_type }}">BSC (BEP20)</option>
						                                        @elseif($tokenList->type == 'polytoken')
						                                        <option value="{{ $tokenList->type }}" data-rc="{{ $tokenList->withdraw }}" data-mw="{{ $tokenList->min_withdraw}}"  data-rt="{{ $tokenList->com_type }}">MATIC (ERC20)</option>
						                                        @else
						                                        <option value="{{ $tokenList->type }}" data-rc="{{ $tokenList->withdraw }}" data-mw="{{ $tokenList->min_withdraw}}"  data-rt="{{ $tokenList->com_type }}">{{ $coindetails->coinname }}</option>
						                                        @endif
						                                    @empty
						                                        <option value="{{ $coindetails->type }}" data-rc="{{ $coindetails->withdraw }}" data-mw="{{ $tokenList->min_withdraw}}"  data-rt="{{ $coindetails->com_type }}">{{ $coindetails->coinname }}</option>
						                                    @endforelse
						                                    </select>
						                                    @error('network')
				                                                <span class="text-danger" role="alert">
				                                                    <strong>{{ $message }}</strong>
				                                                </span>
				                                            @enderror
						                                 </div> 
														<div class="form-group">
															<label>Amount</label>
															<div class="input-group">
																<input class="form-control" id="crypto_withdraw_amount" value="" name="amount"  > 
																<p class="balance-t"><span class="t-gray">Available Balance</span> : {{$balance}} {{ $coin }}</p>
															
															</div>
															<small id="balance-alert" class="bluetrade"></small>
															<p><br/><span class="t-gray">Minimum Withdrawal Limit</span> :<span id="min_w"> {{$coindetails->min_withdraw}} </span> {{ $coin }}</p>
															@error('amount')
				                                                <span class="text-danger" role="alert">
				                                                    <strong>{{ $message }}</strong>
				                                                </span>
				                                            @enderror
														</div>
														<div class="form-group notestitle">
															
															<p><span class="t-gray">Withdraw Fee</span> : <span id="w_com">{{ $coindetails->withdraw }} @if($coindetails->com_type == 'Percentage') % @endif</span> {{ $coin }}</p>
															<p><span class="t-gray">You Receive</span> :<span id="withdraw_total">0.00000000</span> {{ $coin }}</p>
															<p class="text text-danger">Disclaimer</p>
															<p class="text text-danger" >Please cross-check the destination address.Withdrawals to Smart Contract Addresses,payments or participations in ICOs/Airdrops are not supported and will be lost forever.Withdrawals cannot be cancelled after submission.Withdrawals are only supported for ERC-20 wallets,OMNI wallets are not supported.</p>
														</div>
														<div class="form-group text-center">
															<input type="submit" name="" class="btn sitebtn" value="Submit" /> 
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
<script>

    $('#crypto_withdraw_amount').on('keyup', function(){
        var amount   = parseFloat($('#crypto_withdraw_amount').val());
        var mySelect = document.querySelector('#purpose');
        var  withdrawfee =  parseFloat(mySelect.selectedOptions[0].getAttribute("data-rc"));
        var  withdrawtype =  mySelect.selectedOptions[0].getAttribute("data-rt");
        if(withdrawtype == 'Percentage'){
        	var adminfee = parseFloat(amount) * parseFloat( withdrawfee / 100);
        }else{
        	var adminfee = withdrawfee;
        }
        var total    = parseFloat(amount) - parseFloat(adminfee).toFixed(8);
        var balance = parseFloat({{ $balance }}).toFixed(8);
        if(balance < amount){
        	$('#balance-alert').html('Insufficent fund!');
        } else {
        	$('#balance-alert').html('');
        }
        if(total > 0){
            $('#w_com').html(adminfee.toFixed(8));
            $('#withdraw_total').html(total.toFixed(8));
        } else {
            $('#w_com').html('0.00000000');
            $('#withdraw_total').html('0.00000000');
        }
    });
    $('#purpose').on('change', function(){
        var amount   = parseFloat($('#crypto_withdraw_amount').val());
        var mySelect = document.querySelector('#purpose');
        var  withdrawfee =  parseFloat(mySelect.selectedOptions[0].getAttribute("data-rc"));
        var  withdrawtype =  mySelect.selectedOptions[0].getAttribute("data-rt");
        if(withdrawtype == 'Percentage'){
        	var adminfee = parseFloat(amount) * parseFloat( withdrawfee / 100);
        }else{
        	var adminfee = withdrawfee;
        }
        var total    = parseFloat(amount) - parseFloat(adminfee).toFixed(8);
        var balance = parseFloat({{ $balance }}).toFixed(8);
        if(balance < amount){
        	$('#balance-alert').html('Insufficent fund!');
        } else {
        	$('#balance-alert').html('');
        }
        if(total > 0){
            $('#w_com').html(adminfee.toFixed(8));
            $('#withdraw_total').html(total.toFixed(8));
        } else {
            $('#w_com').html('0.00000000');
            $('#withdraw_total').html('0.00000000');
        }
    });
	$('#purpose').on('change', function(){
        var mySelect = document.querySelector('#purpose');
        var  min_withdraw =  parseFloat(mySelect.selectedOptions[0].getAttribute("data-mw"));

        if(min_withdraw > 0){
            $('#min_w').html(min_withdraw.toFixed(4));
        } else {
            $('#min_w').html('0.00000000');
        }
    });
</script>