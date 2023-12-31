@php $title = "swap"; $atitle ="swap";
@endphp
@include('layouts.header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="{{ url('font-awesome/css/font-awesome.min.css') }}">
@include('layouts.headermenu')
<body class="buy-sell-instant-page">

  <div class="trade_main_container">
	
  </div>

<div class="buy-sell-instant">
	{{-- <div class="container">
		<div class="convert-part">
		<div class="Conversion-History"><a href="#">Conversion History<span><i class="fa-solid fa-arrow-right-long"></i></span></a></div>
	    </div>
	</div> --}}
	<div class="container ch-block-outer ch-block-outer-block">

	   <div id="buylimitmsg"></div>
	       @if(session('status'))
		      <div class="alert alert-success" role="alert">
		         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		             <span aria-hidden="true">&times;</span>
		          </button>
		       {{ session('status') }}
		      </div>
	      @endif
	   @if(session('failed'))
		      <div class="alert alert-danger" role="alert">
		         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		            <span aria-hidden="true">&times;</span>
		        </button>
		       {{ session('failed') }}
		     </div>
	    @endif
	
		<div class="Conversion-History-inner">
			
			<!-- <div class="ch-top">
				<div class="ch-top-left"><span>Wallet</span><i class="fa-solid fa-circle-info"></i></div>
				<div class="ch-top-right">


<label class="custom-checkbox">Spot
  <input type="checkbox" checked="checked" id="Spot" name="Spot">
  <span class="checkmark"></span>
</label>
<label class="custom-checkbox">Funding
  <input type="checkbox" id="Funding" name="Funding">
  <span class="checkmark"></span>
</label>

				</div>
			</div> -->

			<div class="ch-mid ch-mid-swap">
			  <form action="{{url('swapsubmit') }}" method="post" id=myForm class="innerformbg" enctype="multipart/form-data">
                  {{ csrf_field() }}

				<div class="ch-mid-top">

				 <!-- <div class="row"> -->
				 	<!-- <div class="col-lg-8 col-xl-8 col-md-12 col-sm-12 col-xs-12"> -->

					 <div class="flex-col-inner flex-col-inner-col-reverse"> 
				 		<label class="balance-label">Spend <span id="coinbalance"> </span></label>    

				 		<div class="select">      
				 			<select  onchange="upair(this)"  id="coinone" name="coinone">
				 				@foreach($list as $data )
				 				<option value="{{ $data->coinone }}"  >{{ $data->coinone }}</option>
				 				@endforeach 
				 			</select>	
				 		</div>

							 {{-- <div class="lang-select">
							<button class="btn-select" value="en"></button>
              <i class="fa-solid fa-chevron-down"></i>
							<div class="b">
							<ul id="a"></ul>
							</div>
							</div>  --}}

				 		</div>

				 	<div class="flex-col-inner"> 
				 		
                        <div class="box-input"><input type="number" step="any" name="coinoneamount" id="fromamount" onkeyup ="fromcell()" value="" placeholder="0.00"><span></span></div>
                    </div>
				 	<!-- </div> -->

				 	<!-- <div class="col-lg-4 col-xl-4 col-md-12 col-sm-12 col-xs-12">  -->
				 		
				 	<!-- </div> -->					
				 <!-- </div>	 -->

				</div>

				 <div class="ch-mid-mid">
					<div class="swapping" id="swapping"><img src={{url('img/swap-icon-switch.png')}} alt="swapping"></div>
				</div> 

				<div class="ch-mid-bottom">
					<!-- <div class="row">
				 	<div class="col-lg-8 col-xl-8 col-md-12 col-sm-12 col-xs-12"> -->

					 <div class="flex-col-inner flex-col-inner-col-reverse"> 
				 		<label class="balance-label">Receive <span></span> </label>
              
              <div class="select">
							<select onchange="tocell()" id="pairlist"  name="cointwo">
							@foreach($list as $value )
							<option value="{{$value->cointwo}}" class="test" >{{$value->cointwo}}</option>
							@endforeach
							</select>
              </div>
 
							{{-- <div class="lang-selects">
							<button class="btn-selects" value="en"></button>
              <i class="fa-solid fa-chevron-down"></i>
							<div class="d">
							<ul id="c"></ul>
							</div>
							</div>  --}}

				 		</div>

				 	<div class="flex-col-inner"> 
				 		<!-- <span class="from-to">Receive</span> -->
                        <div class="box-input"><input type="number" step="any" name="cointwoamount" onkeyup ="tocell()" id="toamount" value="" placeholder="0.00"><span></span></div>
                    </div>
				 	<!-- </div>

				 	<div class="col-lg-4 col-xl-4 col-md-12 col-sm-12 col-xs-12">  -->
				 		

				 	<!-- </div>

				 </div> -->

				</div>
			</div>

			<div class="form-group notestitle fee-percentage-block-part">															
				<h6><span class="t-gray">Fee Percentage:</span> <div><span id="fee_com"></span>%</div></h6>
				<h6><span class="t-gray">Swap Fee:</span> <div><span id="swapfee"></span> <span id="feecon"></span></div></h6>
		        </div>

      <div class="text-center form-group mb-0 col-md-12 convert-btn-bottom">
                  <button type="submit" class="btn btn-gray site-btn m-btn green-btn btn-block text-uppercase">Convert
                  </button>
                </div>

		</div>
					
              </form>  

			  	
	</div>
</div>
@include('layouts.footermenu')
@include('layouts.footer')

<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>

<script>

function upair(selectElement){
var Value = selectElement.value;
console.log(Value);
$.ajax({
    url: "{{ url('listcoin') }}/" + Value,
    type: "GET",
    async: true,
    cache: false,
    success: function(result) {
        console.log(result.pairs);
			var obj =result.pairs;
			var array =Object.values(obj);
			var res = array;

        var $dropdown = $("#pairlist"); // Select the dropdown element
        $dropdown.empty(); // Clear any existing options
        
        for (var i = 0; i < res.length; i++) {
            $dropdown.append($('<option>', {
                value: res[i],
                text: res[i]
            }));
        }
		 fromcell(document.getElementById('myForm'));
    },
    error: function(error) {
        console.log("Error:", error);
    }
});
}

// Trigger the function when the page loads

 $(document).ready(function() {
    console.log('Document is ready.');

    // Call the upair function with the coinone element
    upair(document.getElementById('coinone'));

    // Call the fromcell function
   // var formElement = document.getElementById('myForm');
   // fromcell(formElement);
});

function fromcell(){
  
   var formData = $('#myForm').serialize();
   var type = 'from';

  $.ajax({
    url: "{{ url('getbalance') }}",
    type: "POST",
    async: true,
	  data: formData+ "&type=" + type,
    cache: false,
    success: function(result) {
        console.log(result);
		   $('#swapfee').html(result.data.fees); 
		   $('#feecon').html(result.data.feecon);
		   $('#fee_com').html(result.data.comm); 		 
        var result =$('#toamount').val(result.data.paidamount);      
    },
    error: function(error) {
        console.log("Error:", error);
    }
     });

}

function tocell(){
	  var formData = $('#myForm').serialize();
      var type = 'to';

   $.ajax({
    url: "{{ url('getbalance') }}",
    type: "POST",
    data: formData+ "&type=" + type,
    async: true,
    cache: false,
    success: function(result) {
        console.log(result);
		 $('#swapfee').html(result.data.fees); 
		 $('#feecon').html(result.data.feecon); 
		 $('#fee_com').html(result.data.comm);	
        var result =$('#fromamount').val(result.data.paidamount);    
    },
    error: function(error) {
        console.log("Error:", error);
    }
});
   
}
</script>
<script>
  function balance(){
    var formData = $('#myForm').serialize();
    $.ajax({
    url: "{{ url('balance') }}/",
    type: "POST",
    async: true,
    data: formData,
    cache: false,
    success: function(result) {
      
		var balance =result.balance;
		var bal = $("#coinbalance");
	     bal.text(balance);
    },
    error: function(error) {
        console.log("Error:", error);
    }
});
  }
</script>
<!-- <script>

	$(document).ready(function(){
		$('#swapping').click(function(){
           $('.ch-mid').toggleClass('ch-mid-swap')
		});
		$('.ch-mid-top .from-to').text("From");
		$('.ch-mid-bottom .from-to').text("To");
	});

</script> -->

</body>
</html>