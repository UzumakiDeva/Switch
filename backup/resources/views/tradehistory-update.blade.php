@forelse($completes as $complete)
		<tr class="tr-div">
		<td><span class="@if($complete->type == 'Buy') t-green @else t-red @endif">{{$complete->price}}</span></td>
		<td>{{$complete->volume}}</td>
		<td>{{$complete->value}}</td>
		<td>{{ date('d-m-Y H:i:s',strtotime($complete->created_at))	}}</td>
		</tr>
	@empty
		<tr id="norecord">
		<td>No record found!</td>
		</tr>
@endforelse
