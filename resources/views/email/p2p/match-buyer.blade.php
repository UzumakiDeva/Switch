@include('email.header')
<tr><td colspan='3' align='center' height='1' style='padding:0px;'></td></tr>
<tr><td align='left' style='padding-top:0px;'>&nbsp;</td><td style='text-align:left;font-size:15px;color:#000;padding-top:0px;'>Hello  {{ $name }},</td><td align='left' style='padding-top:0px;'>&nbsp;</td></tr>
<tr><td colspan='3' align='center' height='1' style='padding:0px;'></td></tr>

<tr>
	<td align='left' style='padding-top:0px;'>&nbsp;</td>
	<td style='text-align:left;font-size:15px;color:#000;padding-top:0px;'>Seller matched for your Buy Order!</td>
	<td align='left' style='padding-top:0px;'>&nbsp;</td>
</tr>
<tr><td align='left' style='padding-top:0px;'>&nbsp;</td><td colspan='3'>
	<table align='center' width="90%" style="border-collapse:collapse;margin-left:auto;margin-right:auto">
		<tr style="border-bottom:1px dashed #d7d7d7"><td>Order Volume :</td><td>{{ display_format($order->volume ,$selectPair->coinone_decimal) }} {{ $selectPair->coinone }}</td></tr>
		<tr style="border-bottom:1px dashed #d7d7d7"><td>Order Price	 :</td><td>{{ display_format($order->price ,$selectPair->cointwo_decimal) }} {{ $selectPair->cointwo }}</td></tr>
		<tr style="border-bottom:1px dashed #d7d7d7"><td>Matched Trade :</td><td>{{ display_format($order->escrow_volume ,$selectPair->coinone_decimal) }} {{ $selectPair->coinone }}</td></tr>
		<tr style="border-bottom:1px dashed #d7d7d7"><td>Fee to be deducted :</td><td>{{ display_format($order->fees ,$selectPair->coinone_decimal) }} {{ $selectPair->coinone }}</td></tr>
		<tr style="border-bottom:1px dashed #d7d7d7"><td>Net :</td><td>{{ display_format($order->escrow_volume ,$selectPair->coinone_decimal) }} {{ $selectPair->coinone }}</td></tr>
		<tr style="border-bottom:1px dashed #d7d7d7"><td>Status :</td><td>Waiting for payment</td></tr>
		<tr style="border-bottom:1px dashed #d7d7d7"><td>Time :</td><td>10 minutes</td></tr>
	</table>
</td><td align='left' style='padding-top:0px;'>&nbsp;</td></tr>
<tr><td align='center'>&nbsp;</td><td align='center'><a href="{{url('p2p-matchorder/'.$order->order_id)}}" style='color:#fff;padding:14px 22px;text-decoration:none;background-color:#0099a9;text-transform:uppercase;font-size:15px;font-weight:600;'>Make Payment</a></td><td align='center'>&nbsp;</td></tr>
<tr><td colspan='3' align='center' style='padding:0px;'>{{ $order->order_id }}</td></tr>
<tr><td colspan='3' align='center' height='30' style='padding:0px;'></td></tr>


@include('email.footer')