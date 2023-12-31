@include('email.header')
<tr><td colspan='3' align='center' height='1' style='padding:0px;'></td></tr>
<tr><td align='left' style='padding-top:0px;'>&nbsp;</td><td style='text-align:left;font-size:15px;color:#000;padding-top:0px;'>Hello  {{ $data['name'] }},</td><td align='left' style='padding-top:0px;'>&nbsp;</td></tr>
<tr><td colspan='3' align='center' height='1' style='padding:0px;'></td></tr>

<tr>
	<td align='left' style='padding-top:0px;'>&nbsp;</td>
	<td style='text-align:left;font-size:15px;color:#000;padding-top:0px;'>OTP For Confirm Your Withdraw Request!</td>
	<td align='left' style='padding-top:0px;'>&nbsp;</td>
</tr>
<tr><td align='left' style='padding-top:0px;'>&nbsp;</td><td colspan='3'>
	<table align='center' width="90%" style="border-collapse:collapse;margin-left:auto;margin-right:auto">
		<tr style="border-bottom:1px dashed #d7d7d7"><td>Asset 		:</td><td>{{ $data['currency'] }}</td></tr>
		<tr style="border-bottom:1px dashed #d7d7d7"><td>Network	:</td><td>{{ $data['network'] }}</td></tr>
		<tr style="border-bottom:1px dashed #d7d7d7"><td>To Address :</td><td>{{ $data['toaddress'] }}</td></tr>
		<tr style="border-bottom:1px dashed #d7d7d7"><td>Withdraw Amount :</td><td>{{ display_format($data['amount']) }}</td></tr>
		<tr style="border-bottom:1px dashed #d7d7d7"><td>Fee :</td><td>{{ display_format($data['fee']) }}</td></tr>
		<tr style="border-bottom:1px dashed #d7d7d7"><td>Received Amount :</td><td>{{ display_format($data['receive_amount']) }}</td></tr>
	</table>
</td><td align='left' style='padding-top:0px;'>&nbsp;</td></tr>
<tr><td align='left' style='padding-top:0px;'>&nbsp;</td><td style='text-align:left;font-size:15px;color:#000;padding-top:0px;'>Your Verification Code</td><td align='left' style='padding-top:0px;'>&nbsp;</td></tr>
<tr><td align='left' style='padding-top:0px;'>&nbsp;</td><td style='text-align:center;font-size:29px;color:#000;padding-top:0px;'> {{ $otp }}</td><td align='left' style='padding-top:0px;'>&nbsp;</td></tr>
<tr><td colspan='3' align='center' height='30' style='padding:0px;'></td></tr>

@include('email.footer')