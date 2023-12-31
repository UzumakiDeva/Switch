@php $title = "KYC Verfication"; $atitle ="kyc";
@endphp
@include('layouts.header')
<link rel="stylesheet" type="text/css" href="{{ url('css/kycverfication.css') }}" />
<script
        src="https://hv-camera-web-sg.s3-ap-southeast-1.amazonaws.com/hyperverge-web-sdk@6.1.1/src/sdk.min.js"></script>
<div class="pagecontent gridpagecontent innerpagegrid">
@include('layouts.headermenu')
			</section>
			<article class="gridparentbox">
				<div class="container sitecontainer">

             <div class="kyc-heading">
                  <h3 class="verification-title">KYC Verfication</h3>
             </div>
            
             <div class="total-verification">
                 <div class="row">
                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                            <div class="manual-verification">
                                 <h5 class="manual-verify-txt">Manual Verification</h5>
                                <a href="{{ route('kyc') }}"><button class="verification-btn">Click to proceed</button></a> 
                            </div>
                    </div>

                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                            <div class="manual-verification">
                                 <h5 class="manual-verify-txt">Quick Verification KYC</h5>
                                 <button class="verification-btn" onclick="starOnboarding();">Click to proceed</button> 
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
    function starOnboarding() {
        const accessToken = "{{ $bearToken }}"
        const hyperKycConfig = new HyperKycConfig(
            accessToken,
            "workflow_mh5lOrK",
            "{{ TransactionString(20) }}"
        );
        HyperKYCModule.launch(hyperKycConfig, handler);
    }
    const handler = (HyperKycResult) => {
        console.log('HyperKycResult',HyperKycResult);
        switch(HyperKycResult.status) {
          case "user_cancelled":
              // user cancelled
          break;
          case "error":
            // failure
          break;
          case "auto_approved":
          case "auto_declined":
          case "needs_review":
            // workflow success
          break;          
        }
        if (HyperKycResult.Cancelled) {
          // user cancelled
            console.log('Cancelled',HyperKycResult.Cancelled);
        } else if (HyperKycResult.Failure) {
          // failure
            console.log('Failure',HyperKycResult.Failure);
        } else if (HyperKycResult.Success) {
          // success
            console.log('Success',HyperKycResult.Success);
        }
    }
</script>   
</body>
</html>