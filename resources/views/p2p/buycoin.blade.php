@php 
$title = "P2P - $coinOne/$coinTwo | Buy and Sell $coinOne with $coinTwo on switchExchange P2P"; 
$atitle ="market-place";
if($coinTwo == 'INR') {
if(Session::get('mode') == 'nightmode'){
$image = url('images/inr-light.svg');
}else{
$image = url('images/color/inr.svg');
}
$symbol = "<img src='".$image."' class='symbols' />";
} else{
$symbol = '';
}
@endphp
@include('layouts.header')
<link rel="stylesheet" type="text/css" href="{{url('css/buycoin.css')}}" />
<link rel="stylesheet" type="text/css" href="{{url('css/p2pbuy.css')}}" />
<style>
  .symbols {
    width: 13px;
    margin-right: 1px;
  }
  .img-res{
    width: 320px;
    height: 420px;
  }
</style>
<div class="pagecontent gridpagecontent innerpagegrid">
  @include('layouts.headermenu')
</section>
<article class="gridparentbox">
  <div class="container sitecontainer"><a class="pull-right button cancel-btn" data-bs-toggle="modal" data-bs-target="#canceltrade">Cancel Order</a><br/>
   <h5 class="sellers-head">Bank Account for {{ display_format($order->escrow_volume,$selectPair->coinone_decimal) }} {{$coinOne}} </h5>

   <p class="gray-txt">Pay-exactlty</p>
   <p class="black-txt">{!! $symbol !!}{{ display_format($order->received,$selectPair->cointwo_decimal) }}</p>
   <p class="gray-txt">(Do not round off)</p>
   <div class="ba-detil-table">
     <table class="w3-table" >
      <tr>
        <th class="name-head">Pay only from account</th>
        <th class="name-head left-txt">Details</th>

      </tr>
      @if($order->paymenttype == 'bank')
      <tr>
        <td>Name</td>
        <td>{{ $order->account_name }} <i class="fa fa-light fa-clone" style="color: #4c5057;"></i></td>

      </tr>
      <tr>
        <td>Account Number</td>
        <td>{{ $order->account_no }} <i class="fa fa-light fa-clone" style="color: #4c5057;"></i></td>

      </tr>
      <tr>
        <td>IFSC</td>
        <td>{{ $order->swift_code }} <i class="fa fa-light fa-clone" style="color: #4c5057;"></i></td>

      </tr>

      <tr>
        <td>Bank Name</td>
        <td>{{ $order->bank_name }} <i class="fa fa-light fa-clone" style="color: #4c5057;"></i></td>
      </tr>
      @elseif($order->paymenttype == 'upi')
      <tr>
        <td>UPI Name</td>
        <td>{{ $order->aliasupi }} <i class="fa fa-light fa-clone" style="color: #4c5057;"></i></td>
      </tr>
      <tr>
        <td>UPI ID</td>
        <td>{{ $order->upiid }} <i class="fa fa-light fa-clone" style="color: #4c5057;"></i></td>
      </tr>
      @if($order->qrcode !="")
      <tr>
        <td>QR CODE</td>
        <td><a href="{{ url($order->qrcode) }}" target="_blank"><img class="img-res" src="{{ url($order->qrcode) }}"></a></td>
      </tr>
      @endif
      @endif

    </table>

  </div>

@if ($message = Session::get('fail'))
  <div class="alert alert-danger alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button> 
    <strong>{!! $message !!}</strong>
  </div>
@endif
  
  @if ($message = Session::get('success'))
  <div class="alert alert-success alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button> 
    <strong>{!! $message !!}</strong>
  </div>
  @endif
<form action="{{ route('p2pproofUpload')}}" method="post" class="siteformbg" enctype="multipart/form-data">
  <div class="Neon Neon-theme-dragdropbox">
    <div class="screenshot-details">
      <p class="screenshot-note"><b>SCREENSHOT SHOULD INCLUDE</b></p>
      <ul class="screenshot-note">
        <li>Amount Transferred</li>
        <li>Transaction ID</li>
      </ul>
    </div>
    @csrf
    <input type="hidden" name="orderID" value="{{ $order->order_id }}">
    <input style="z-index: 999; opacity: 0; width: 320px; height: 200px; position: absolute; right: 0px; left: 0px; margin-right: auto; margin-left: auto;" onchange="readURL(this);" name="slipupload" id="filer_input2" type="file">

    <div class="Neon-input-dragDrop"><div class="Neon-input-inner"><div class="Neon-input-icon"><i class="fa fa-file-image-o"></i></div><div class="Neon-input-text"><h3>Drag&amp;Drop files here</h3> <span style="display:inline-block; margin: 15px 0">or</span></div><a class="Neon-input-choose-btn blue">Browse Files</a></div><div id="frames"></div></div>
    
    @error('slipupload')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
  </div>



  <div class="check-txt">
    <input type="checkbox" id="vehicle1" name="vehicle1" value="received" required>
    <label for="vehicle1"> I have transferred exactly {!! $symbol !!}{{ display_format($order->received ,$selectPair->cointwo_decimal) }} to the above account using .

    </label><br> 

    <input type="checkbox"  name="vehicle1" value="authorise" required>
    <label for="vehicle1"> I authorise Switch to share this proof with seller.
    </label><br>
  </div>
  <div class="paid">
   <button class="paid-btn">I Have Paid</button>
 </div>
</form>




</div>
</article>
<div class="modal fade modalbgt" id="canceltrade">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Are you sure you want to cancel the order? </h4>
        <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <p class="t-gray">All matched trades except the trades where you've paid or clicked <b>"Yes, I Will pay" will be cancelled.</b></p>
      <form class="siteformbg" action="{{ route('p2pcancel') }}" id="theform" method="post" autocomplete="off">
        @csrf
        <input type="hidden" name="orderID" value="{{ $order->order_id }}">
        <div class="form-group" class="form-control @error('reasons') is-invalid @enderror" >
          <select name="reasons" required="required">
            <option value="" selected>Select Reason for Cancellation</option>
            <option>I don't want trade anymore</option>
            <option>I want to modify the price</option>
            <option>Placed order by mistake</option>
            <option>Other Reasons</option>
          </select>
          @error('reasons')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror 
        </div>
        <div class="important-note ">
         <p class="note-txt"><b>Please Note</b></p>
         <p class="note-txt">Penalty for not paying after clicking "Yes, i will pay": Minimum <b>10 USDT</b>or <b>1.2%</b>of trade </p>
        
        </div>
        <div class="form-group mt-2 text-center">
          <span class="badge badge-danger" data-bs-dismiss="modal">No, Go back</span>
          <input type="submit" class="btn sitebtn" value="Cancel-order" />
        </div>  
      </form>
      </div>      
    </div>
  </div>
</div>
@include('layouts.footermenu')
</div>
@include('layouts.footer')   
<script>
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
$(document).ready(function(){
    $('#filer_input2').change(function(){
        $("#frames").html('');
        for (var i = 0; i < $(this)[0].files.length; i++) {
            $("#frames").append('<img src="'+window.URL.createObjectURL(this.files[i])+'" width="100px" height="100px"/>');
        }
    });
});
</script>






</body>
</html>