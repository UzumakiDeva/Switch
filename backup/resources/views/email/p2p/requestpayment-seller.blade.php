@include('email.header')
<tr><td colspan='3' align='center' height='1' style='padding:0px;'></td></tr>
<tr><td align='left' style='padding-top:0px;'>&nbsp;</td><td style='text-align:left;font-size:15px;color:#000;padding-top:0px;'>Hello  {{ $sellername }},</td><td align='left' style='padding-top:0px;'>&nbsp;</td></tr>
<tr><td colspan='3' align='center' height='1' style='padding:0px;'></td></tr>

<tr><td align='left' style='padding-top:0px;'>&nbsp;</td><td style='text-align:left;font-size:15px;color:#000;padding-top:0px;'>Trade initiated successfully. Please make the payment of {{ $relasecoin }} to complete the trade
</td><td align='left' style='padding-top:0px;'>&nbsp;</td></tr>

<tr><td colspan='3' align='center' height='30' style='padding:0px;'></td></tr>


@include('email.footer')