@extends('layouts.app')

@section('content')
<section class="page-header row">
  <h3> {{ $title }} </h3>
  <ol class="breadcrumb">
    <li><a href="{{ url('dashboard')}}"> Home </a></li>
    <li  class="active"> {!! $title !!}   </li>
  </ol>
</section>
<div class="page-content row">
  	
		<div class="list_view">
			<div class="newchat">
				<a href="javascript://ajax" onclick="SximoModal('{{ url("chat/new") }}','New Conversation');" class="btn btn-default btn-block  btn-sm"> Start New Chat </a>
			</div>
			<div class="chat-active">
				<div class="inner">

				<ul>
					@foreach($chats as $row)
					<li>
						<a href="{{ url('chat?start='.$row['chat_id']) }}">
						<div class="avatar" id="{{ $row['chat_id'] }}">
						@foreach($row['users'] as $user)
							{!! SiteHelpers::avatar('20',$user['id']) !!}
							{{ $user['name']}}
						@endforeach
						
							
							<b></b>
						</div>
						</a>
					</li>
					@endforeach
				</ul>
				</div>
			</div>	
		</div>
		<div class="content_view">
			@if($active !='false')
			<div class="chat-box">
				<div class="chat-box-tools text-right ">

						<a href="javascript://ajax" class="btn tips  btn-sm" title="Clear Chats" onclick="loadMsg()"> <i class="fa fa-trash-o"></i> </a>
						<a href="javascript://ajax" class="btn  btn-sm" onclick="loadMsg()"> <i class="fa fa-refresh"></i> </a>
					
					
				</div>
				<div class="chat-box-content">		

				</div>	
				<div class="textarea">
					<input type="text" class="form-control input-sm onchat" id="onchat" value="">
				</div>			
			</div>
			@endif
		</div>	

		
</div>
<script type="text/javascript">

$(function() {
<?php if($active !='false'){ ?>
	loadMsg();
	$('#onchat').on('keyup',function(e){
		if (e.keyCode === 13) {
	       var value = $(this).val();	       
	      	$.post('<?php echo url('chat');?>',{'msg':value ,'chat_id': <?php echo $active;?>  } ,function( callback ){
	      		$('#onchat').val(' ');
	      	loadMsg();
	      },'json');
	    }
	})  

	if (!document.hidden) {
		 setInterval(function(){ 
	   		loadMsg()
	  	}, 10000);  
	}	
	
<?php } ?>	
	chat_sidebar()
	$(window).bind("load resize", function() {
		chat_sidebar()
	})	

 		
})	



function chat_sidebar() {
	var list_view = $( window ).height() - 180;
	var chat_active = $( window ).height() - 300;
	$('.list_view').css('height',list_view+ 'px')
	$('.chat-active').css('height',chat_active + 'px')
	$(' .chat-active').scrollbar(); 	
}
function loadMsg(){
	$.get("<?php echo url('chat/room?id='.$active );?>" ,function(data){
		$('.chat-box-content').html(data,function(){
		});
		jQuery('.chat-box-content').animate({scrollTop: $(".chat-box-content")[0].scrollHeight  }, 1000);
		
	})
}
</script>

  
@endsection