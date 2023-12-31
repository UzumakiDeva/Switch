@php $title = $coin." Deposit"; $atitle ="wallet";
@endphp
@include('layouts.header')
<div class="pagecontent gridpagecontent innerpagegrid">
@include('layouts.headermenu')
</section>
<article class="gridparentbox">
	<div class="container sitecontainer walletpagebg">
		<div id="deposit" class="depositbg">
			
			<div class="panelcontentbox">
				<h2 class="heading-box">Deposit</h2>
				<div class="contentpanel">
					<div id="cryptodpst" class="tab-pane fade in show active">
						<form class="siteformbg">
							<div class="row">
								<div class="col-xl-5 col-lg-6 col-md-6">
									<div class="form-group">
									@if($payment_id !='')
									<p  class="alert alert-warning">• {{ $coinname }} network requires you to enter both Destination Address and a Destination Tag.<br>

									• Failure of adding the Destination Tag will result in irrecoverable loss of funds while depositing.</p>
									@else
									<p  class="alert alert-warning">Please ensure to select <span class="netchain">{{ $coinname }} </span>network at sender's wallet</p>
									@endif 
										<label class="form-label">Select Crypto <span class="text text-danger">*</span>
										</label>
										<select class="form-control" name="coin" onchange="pageredirect(this)">
											@forelse($coinLists as $coinlist)
											<option value="{{ $coinlist->source }}" @if($coinlist->source == $coin)selected @endif>{{ $coinlist->source }} </option>
											@empty
											<option value="">No Coin list</option>
											@endforelse
										</select>
									</div>
									@if(count($tokenLists) == 0)
									<div class="form-group">
										<label>DESTINATION ADDRESS</label>
										<div class="input-group ERC20">
											<input class="form-control" value="{{ $address }}" id="coinaddress" readonly>
											<span class="input-group-text" id="myTooltip" onclick="myCopyFunc('{{ $coin }}')">Copy</span>
										</div>
									</div>
									@endif
									@if($payment_id !='')
									<div class="form-group">
										<label>DESTINATION TAG</label>
										<div class="input-group">
											<input class="form-control" value="{{ $payment_id }}"  readonly>
										</div>
									</div>
									@endif
									@if(count($tokenLists) > 0)
									<div class="form-group">
										<label>DESTINATION ADDRESS</label>
										@if($tokenLists[0]['type'] != 'trxtoken')
										<div class="input-group ERC20">
											<input class="form-control" value="{{ $ethaddress }}" id="coinaddress" readonly>
											<span class="input-group-text" id="myTooltip" onclick="myCopyFunc('{{ $coin }}')">Copy</span>
										</div>
										@else
										<div class="input-group TRC20">
											<input class="form-control" value="{{ $trxaddress }}" id="coinaddress1" readonly>
											<span class="input-group-text" id="myTooltip1" onclick="myCopyFunc1('{{ $coin }}')">Copy</span>
										</div>
										@endif
										<div class="input-group TRC20"  style='display:none;'>
											<input class="form-control" value="{{ $trxaddress }}" id="coinaddress1" readonly>
											<span class="input-group-text" id="myTooltip1" onclick="myCopyFunc1('{{ $coin }}')">Copy</span>
										</div>
									</div>
									<div class="form-group  has-feedback">
                                    <label>Network</label>
                                       <select id='purpose' class="form-control" onChange="changeNetwork(this);">
                                       	@forelse($tokenLists as $tokenList)
                                       	@if($tokenList->type == 'token' || $tokenList->type == 'erctoken')
                                       	<option value="{{ $tokenList->type }}" >Ethereum (ERC20)</option>
                                       	@elseif($tokenList->type == 'trxtoken')
                                       	<option value="1">Tron (TRC20)</option>
                                       	@elseif($tokenList->type == 'bsctoken')
                                       	<option value="{{ $tokenList->type }}">BSC (BEP20)</option>
                                       	@elseif($tokenList->type == 'polytoken')
                                       	<option value="{{ $tokenList->type }}">Polygon (ERC20)</option>
                                       	@endif
                                       	@empty
                                       	<option value="0">Ethereum (ERC20)</option>
                                       	@endforelse
                                       </select>
                                 </div> 
									@endif
									<div class="form-group notestitle">
																				
										<p class="text text-danger">Disclaimer</p>
											<ul>
											@if($type == 'trxtoken')
											<li>Please deposit 1.1 TRX for activate tron Wallet</li>
											@endif
											<li class=""> Send only using the <span class="netchain">{{ $coinname }}</span> Network.Using any other network will result in loss of funds</li>
											<li>Deposit only {{ $coindetails->source }} to this deposit address.Deposting any other asset will result in loss of funds</li>
											@if($payment_id !='')
											<li>Adding Destination Tag with the deposit address is mandatory. Failure to add Destination Tag will lead to a loss of funds</li>
											@endif

										</ul>

											
									</div>
								</div>
								<div class="col-xl-5 col-lg-6 col-md-6 pl-4 pr-4">
									<div class="form-group mt-4 ERC20">
										<img src="https://chart.googleapis.com/chart?chs=250x250&cht=qr&chl={{ $address }}" class="qrcode-bg"/>
										<a href="https://chart.googleapis.com/chart?chs=250x250&cht=qr&chl={{ $address }}" class="btn sitebtn mx-2" download>Download</a>
									</div>
									<div class="form-group mt-4 TRC20" style='display:none;'>
										<img src="https://chart.googleapis.com/chart?chs=250x250&cht=qr&chl={{ $trxaddress }}" class="qrcode-bg"/>
										<a href="https://chart.googleapis.com/chart?chs=250x250&cht=qr&chl={{ $trxaddress }}" class="btn sitebtn mx-2" download>Download</a>
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
	function pageredirectTo(self){
		window.location.href = self.value;
	}
	function myCopyFunc(copyText) {
      var copyText = document.getElementById("coinaddress");
      copyText.select();
      document.execCommand("Copy");
      var tooltip = document.getElementById("myTooltip");
      tooltip.innerHTML = "<strong class='text-danger'>Copied!</strong>";
   }
   function myCopyFunc1(copyText) {
      var copyText = document.getElementById("coinaddress1");
      copyText.select();
      document.execCommand("Copy");
      var tooltip = document.getElementById("myTooltip1");
      tooltip.innerHTML = "<strong class='text-danger'>Copied!</strong>";
   }
   function changeNetwork(sel) {
   	$('.netchain').html(sel.options[sel.selectedIndex].text);
	}
   $('#purpose').on('change', function() {
      if ( this.value == '1')
      {
        $(".TRC20").show();
        $(".TRC201").show();
        $(".ERC20").hide();
        $(".ERC201").hide();
      }
      else
      {
       	$(".ERC20").show();
        $(".TRC20").hide();
        $(".ERC201").show();
        $(".TRC201").hide();
      }
    });
</script>