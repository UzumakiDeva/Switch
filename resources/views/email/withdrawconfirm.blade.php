@include('email.header')

<tr><td align='left'>&nbsp;</td><td style='text-align:center;font-size:20px;color:#515151;font-weight:600;'> Otp For Confirm Your Withdraw Request</td><td align='left'>&nbsp;</td></tr>
<tr><td colspan='3' align='center' height='1' style='padding:0px;'></td></tr>
<tr><td align='left' style='padding-top:0px;'>&nbsp;</td><td style='text-align:left;font-size:15px;color:#000;padding-top:0px;'>For {{$coin}} To address {{$address}} amount {{$amount}}</td><td align='left' style='padding-top:0px;'>&nbsp;</td></tr>
<tr><td colspan='3' align='center' height='1' style='padding:0px;'></td></tr>
<tr><td align='left' style='padding-top:0px;'>&nbsp;</td><td style='text-align:left;font-size:15px;color:#000;padding-top:0px;'>Your Verification Code</td><td align='left' style='padding-top:0px;'>&nbsp;</td></tr>
<tr><td align='left' style='padding-top:0px;'>&nbsp;</td><td style='text-align:center;font-size:29px;color:#000;padding-top:0px;'> {{ $otp }}</td><td align='left' style='padding-top:0px;'>&nbsp;</td></tr>
<tr><td colspan='3' align='center' height='30' style='padding:0px;'></td></tr>

@include('email.footer')
