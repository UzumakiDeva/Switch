@include('email.header')

<tr><td align='left'>&nbsp;</td><td style='text-align:left;font-size: 15px;color:#000;'>Hi {{ Auth::user()->first_name}} {{ Auth::user()->last_name}},</td><td align='left'>&nbsp;</td></tr>
<tr><td colspan='3' align='center' height='1' style='padding:0px;'></td></tr>
<tr>
	<td align='left' style='padding-top:0px;'>&nbsp;</td>
	<td style='text-align:left;font-size:15px;color:#000;padding-top:0px;'>Confirm Your Withdrawal Request for <b>{{ $data['amount'] }} {{ $data['currency'] }}</td>
	<td align='left' style='padding-top:0px;'>&nbsp;</td>
</tr>
<tr><td align='left' style='padding-top:0px;'>&nbsp;</td><td colspan='3'>
	<table align='center' width="90%" style="border-collapse:collapse;margin-left:auto;margin-right:auto">
		<tr style="border-bottom:1px dashed #d7d7d7"><td><b>Withdraw Details</b></td><td></td></tr>
		<tr style="border-bottom:1px dashed #d7d7d7"><td>Total Amount :</td><td>{{ $data['amount'] }} {{ $data['currency'] }}</td></tr>
		<tr style="border-bottom:1px dashed #d7d7d7"><td>Fee :</td><td>{{ $data['fee'] }} {{ $data['currency'] }}</td></tr>
		<tr style="border-bottom:1px dashed #d7d7d7"><td>Amount You Receive :</td><td>{{ $data['receive_amount'] }} {{ $data['currency'] }}</td></tr>
		<tr style="border-bottom:1px dashed #d7d7d7"><td>Destination Address :</td><td>{{ $data['toaddress'] }}</td></tr>
		<tr style="border-bottom:1px dashed #d7d7d7"><td>Network :</td><td>{{ $data['currency'] }} {{ $data['network'] }}</td></tr>
	</table>
</td><td align='left' style='padding-top:0px;'>&nbsp;</td></tr>
<tr><td align='left' style='padding-top:0px;'>&nbsp;</td><td style='text-align:left;font-size:15px;color:#000;padding-top:0px;line-height: 30px'>Double check the address before confirming the withdrawal.  </td><td align='left' style='padding-top:0px;'>&nbsp;</td></tr>
<tr><td colspan='3' align='center' height='30' style='padding:0px;'></td></tr>
<tr><td align='center'>&nbsp;</td><td align='center'><a href="{{route('approvewithdraw', ['email' => \Crypt::encryptString(Auth::user()->email), 'toaddress' => $data['toaddress']] )}}" style='color:#fff;padding:14px 22px;text-decoration:none;background-color:#0099a9;text-transform:uppercase;font-size:15px;font-weight:600;'>Approve this Withdraw</a></td><td align='center'>&nbsp;</td></tr>

<tr><td colspan='3' align='center' height='30' style='padding:0px;'>If it's not you, please contact us as soon as possible.</td>
</tr>
<tr><td colspan='3' align='center' height='30' style='padding:0px;'></td></tr>

@include('email.footer')