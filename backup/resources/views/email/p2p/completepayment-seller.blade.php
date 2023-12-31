@include('email.header')
<tr><td colspan='3' align='center' height='1' style='padding:0px;'></td></tr>
<tr><td align='left' style='padding-top:0px;'>&nbsp;</td><td style='text-align:left;font-size:15px;color:#000;padding-top:0px;'>Hello  {{ $sellername }},</td><td align='left' style='padding-top:0px;'>&nbsp;</td></tr>
<tr><td colspan='3' align='center' height='1' style='padding:0px;'></td></tr>

<tr><td align='left' style='padding-top:0px;'>&nbsp;</td><td style='text-align:left;font-size:15px;color:#000;padding-top:0px;'>Your P2P sell trade of {{ $relasecoin }} has been completed successfully.
</td><td align='left' style='padding-top:0px;'>&nbsp;</td></tr>

<tr><td colspan='3' align='center' height='30' style='padding:0px;'></td></tr>


@include('email.footer')