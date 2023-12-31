@forelse($closeTrades as $closeTrade)
	<tr>
	<td>{{ $closeTrade->type == 0 ? 'Limit' : 'Market'}}</td>
	<td>{{ date('d/m/Y H:i:s', strtotime($closeTrade->created_at)) }}</td>
    <td><span class="@if($closeTrade->trade_type == 'Buy') t-green @else t-red @endif">{{ $closeTrade->trade_type }}</span></td>
	<td>{{$closeTrade->pairDetail['coinone']}} / {{$closeTrade->pairDetail['cointwo']}}</td>
	<td>{{ number_format($closeTrade->volume, 8, '.', '') }}</td>
    <td>{{ $closeTrade->order_type == 2 ?  'Market price' : number_format($closeTrade->price, 8, '.', '')}}</td>
	<td>{{ $closeTrade->order_type == 2 ?  '-' : number_format($closeTrade->value, 8, '.', '')}}</td>
	<td>@if($closeTrade->status == 0 ) Pending @elseif($closeTrade->status == 100 ) Cancelled @else Completed @endif</td>											
	</tr>
@empty
	<tr><td colspan="10">No trade found!</td></tr>
@endforelse"
