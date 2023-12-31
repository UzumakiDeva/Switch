<!DOCTYPE html>
<html lang="en">

<head>
    <script
        src="https://hv-camera-web-sg.s3.ap-southeast-1.amazonaws.com/hyperverge-web-sdk%40demo/src/sdk.min.js"></script>
</head>

<body>
    <div>
        <button type="button" onclick="starOnboarding();">
            Start Onboarding
        </button>
    </div>
</body>
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

</html>