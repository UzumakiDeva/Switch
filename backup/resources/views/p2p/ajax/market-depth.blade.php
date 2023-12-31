@forelse($marketdepth_B as $marketdep_B)  
  <tr class="total-green">
    <td data-label="Volume"> {{ $marketdep_B->remaining}} </td> 
    <td data-label="Price" class="green-num"><i class="fa fa-arrow-up" style="color: #23c754;"></i>{{ $marketdep_B->price }}</td>
  </tr>
@empty  
<tr> 
<td colspan="5"> No record found!</td>
</tr>
@endforelse