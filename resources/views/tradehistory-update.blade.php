@forelse($completes as $complete)
		<tr class="tr-div">
		<td><span class="@if($complete->type == 'Buy') t-green @else t-red @endif">{{$complete->price}}</span></td>
		<td>{{$complete->volume}}</td>
		<td>{{$complete->value}}</td>
		<td>{{ date('d-m-Y H:i:s',strtotime($complete->created_at))	}}</td>
		</tr>
	@empty
	@if(count($bots->data) > 0)
		@foreach($bots->data as $bot)
		<tr class="tr-div">
		<td><span class="@if($bot->type == 'BUY') t-green @else t-red @endif">{{$bot->rate}}</span></td>
		<td>{{$bot->volume}}</td>
		<td>{{$bot->price}}</td>
		<td>{{ date('d-m-Y H:i:s',$bot->timestamp)	}}</td>
		</tr>
		@endforeach
	@else
	<tr id="norecord">
		<td>No record found!</td>
	</tr>
	@endif
		
@endforelse
