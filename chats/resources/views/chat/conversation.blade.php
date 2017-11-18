				
@foreach($conversation as $chat)
<article class="chat-content @if($chat->user_id == session('uid')) me @endif clearfix">
	
	<div class="message">
		<div class="avatar-small">
			{!! SiteHelpers::avatar('50',$chat->user_id) !!}
			
		</div>
		
		{!! $chat->message !!}
		<div class="date crearfix"> {!! $chat->posted !!} </div>
	</div>
	
</article>
@endforeach

