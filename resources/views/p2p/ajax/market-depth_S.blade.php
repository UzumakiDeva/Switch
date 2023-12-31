@forelse($marketdepth_S as $marketdep_S) 
  <tr class="total-red" onclick="javascript:sellRow('{{ $marketdep_S->price }}','{{ $marketdep_S->remaining }}');">
    <span class="static-style" style="width: {{ $marketdep_S->remaining }}% !important"></span>
    <td data-label="Price" class="red-num"><i class="fa fa-arrow-down" style="color: #f50000;"></i>{{ $marketdep_S->price }}</td>
    <td data-label="Volume">{{ $marketdep_S->remaining }}</td>
  </tr> 
@empty  
<tr> 
<td colspan="5"> No record found!</td>
</tr>
@endforelse