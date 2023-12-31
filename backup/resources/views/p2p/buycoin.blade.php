@php 
$title = "P2P - $coinOne/$coinTwo | Buy and Sell $coinOne with $coinTwo on PantherExchange P2P"; 
$atitle ="market-place";
if($coinTwo == 'INR') { 
  $image = url('images/color/inr.svg');
  $symbol = "<img src='".$image."' class='symbols' />";
} else{ 
  $symbol = ''; 
}
@endphp
@include('layouts.header')
<link rel="stylesheet" type="text/css" href="{{url('css/buycoin.css')}}" />
<style>
  .symbols {
    width: 13px;
    margin-right: 1px;
  }
</style>
<div class="pagecontent gridpagecontent innerpagegrid">
  @include('layouts.headermenu')
</section>
<article class="gridparentbox">
  <div class="container sitecontainer">
   <h5 class="sellers-head">Bank Account for {{ $order->remaining }} {{$coinOne}}</h5>
   <p class="gray-txt">Pay-exactlty</p>
   <p class="black-txt">{!! $symbol !!}{{ $order->received }}</p>
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
      <tr>
        <td>QR CODE</td>
        <td><img src="{{ url('storage/'.$order->qrcode) }}"></td>
      </tr>
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
    <input style="z-index: 999; opacity: 0; width: 320px; height: 200px; position: absolute; right: 0px; left: 0px; margin-right: auto; margin-left: auto;" name="slipupload" id="filer_input2" type="file">
    <div class="Neon-input-dragDrop"><div class="Neon-input-inner"><div class="Neon-input-icon"><i class="fa fa-file-image-o"></i></div><div class="Neon-input-text"><h3>Drag&amp;Drop files here</h3> <span style="display:inline-block; margin: 15px 0">or</span></div><a class="Neon-input-choose-btn blue">Browse Files</a></div></div>
    @error('slipupload')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
  </div>



  <div class="check-txt">
    <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
    <label for="vehicle1"> I have transferred exactly 1,000 to the above account using .

    </label><br> 

    <input type="checkbox"  name="vehicle1" value="Bike">
    <label for="vehicle1"> I authorise Panther Exchange to share this proof with seller.
    </label><br>
  </div>
  <div class="paid">
   <button class="paid-btn">I Have Paid</button>
 </div>
</form>




</div>
</article>
@include('layouts.footermenu')
</div>
@include('layouts.footer')   







</body>
</html>