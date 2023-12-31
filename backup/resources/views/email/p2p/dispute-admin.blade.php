@include('email.header')

<tr><td align='left'>&nbsp;</td><td style='text-align:left;font-size: 15px;color:#000;'>Hi Sir/Madam,</td><td align='left'>&nbsp;</td></tr>
<tr><td colspan='3' align='center' height='1' style='padding:0px;'></td></tr>

<tr><td align='left' style='padding-top:0px;'>&nbsp;</td><td style='text-align:left;font-size:15px;color:#000;padding-top:0px;'>{{ $user->first_name.' '.$user->last_name }} Submitted Rise dispute. Kindly login your admin panel and check Rise dispute details. </td><td align='left' style='padding-top:0px;'>&nbsp;</td></tr>

<tr><td colspan='3' align='center' height='30' style='padding:0px;'></td></tr>

@include('email.footer')