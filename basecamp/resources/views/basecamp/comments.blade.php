<ul class="activity-lists">
@foreach($rows as $row)
	<li>
		{!! AppHelper::avatar('30',$row->user_id)!!} <b> {{ $row->username }}</b> {!! $row->comment !!} <br />
		<span class="date"> {{  AppHelper::get_time_ago(strtotime($row->posted)) }}</span>
	</li>
@endforeach

</ul>