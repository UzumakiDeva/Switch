@forelse($openTrades as $openTrade)
		<tr>
		    <td>{{ $openTrade->type == 0 ? 'Limit' : 'Market'}}</td>
			<td>{{ date('d/m/Y H:i:s', strtotime($openTrade->created_at)) }}</td>
		    <td><span class="@if($openTrade->trade_type == 'Buy') t-green @else t-red @endif">{{ $openTrade->trade_type }}</span></td>
			<td>{{$openTrade->pairDetail['coinone']}} / {{$openTrade->pairDetail['cointwo']}}</td>
		    <td>{{ number_format($openTrade->volume, 8, '.', '') }}</td>
			<td>{{ $openTrade->order_type == 2 ?  'Market price' : number_format($openTrade->price, 8, '.', '')}}</td>
			<td>{{ number_format($openTrade->remaining, 8, '.', '') }}</td>
		    <td>{{ number_format($openTrade->fees, 8, '.', '') }}</td>
			<td>{{ $openTrade->order_type == 2 ?  '-' : number_format($openTrade->value, 8, '.', '')}}</td>
			<td>@if($openTrade->status == 0 ) Pending @elseif($openTrade->status == 100 ) Cancelled @else Completed @endif</td>
											
			<td><a href="{{ url('/cancelorder/'.\Crypt::encrypt($openTrade->id) ) }}" class="btn sitebtn viewbtn">Cancel</a></td>
		</tr>
			@empty
		<tr><td colspan="10">No open orders found!</td></tr>
@endforelse
