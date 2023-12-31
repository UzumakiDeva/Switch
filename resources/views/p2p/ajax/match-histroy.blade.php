@forelse($histroys as $histroy)  
  @if($histroy->type == 'Buy')
  <tr class="total-green">
    <td data-label="Price" class="green-num"><i class="fa fa-arrow-up" style="color: #23c754;"></i>{{ $histroy->price }}</td>
    <td data-label="Volume">{{ $histroy->volume }}</td>
    <td data-label="Time">{{ date('h:i:s',strtotime($histroy->created_at)) }}</td>
  </tr>
  @else
  <tr class="total-red">
    <td data-label="Price" class="red-num"><i class="fa fa-arrow-down" style="color: #f50000;"></i>{{ $histroy->price }}</td>
    <td data-label="Volume">{{ $histroy->volume }}</td>
    <td data-label="Time">{{ date('h:i:s',strtotime($histroy->created_at)) }}</td>
  </tr>
  @endif    
@empty  
<tr> <td colspan="5"> No record found!</td></tr>
@endforelse