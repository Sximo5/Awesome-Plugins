@extends('layouts.app')

@section('content')
<?php require_once(app_path() .'/Library/BasecampHelper.php');
 ?>
<section class="page-header row">
  <h3> Basecamp - Todo  </h3>
  <ol class="breadcrumb">
    <li><a href="{{ url('dashboard')}}"> Home </a></li>
    <li><a href="{{ url('basecamp')}}"> Basecamp </a></li>
    <li  class="active">{{ $todo_set->title }}  </a></li>
  </ol>
</section>
<div class="page-content row">
  <div class="page-content-wrapper no-margin">

  	<div class="col-md-8 col-sm-offset-2 basecamp" style="padding-bottom: 50px;">
  	<div class="sbox bg-gray">
	  	<div class="sbox-title clearfix">
	  		
	  		<div class="sbox-tools">
  				<a href="{{ url('basecamp/todosets?id='.$todo_set->basecamp_id)}}" class="btn btn- btn-sm"  >
					<i class="fa fa-close"></i> Back to Lists
				</a>
	  		</div>
	  	</div>
	  	<div class="sbox-content">
	  		<div class="todos" style=" min-height: ">
	  			<h3 class="text-center"> {{ $todo_set->title }}  </h3>
	  			<div style="padding: 10px 0;">
	  				{!! $todo_set->brief !!} 
	  			</div>
	  			<ul class="m-t">
	  			@foreach($todos as $todo)
	  				<li><input type="checkbox" value="{{ $todo->todo_id }}" class="minimal-green task_result" @if($todo->status =='close') checked="checked" @endif /> <a href="{{ url('basecamp/todo?id='.$todo_set->set_id.'&todo_id='.$todo->todo_id)}}"><span> {{ $todo->subject }} </span></a>

	  				<span class="teams"> 	
	  				@foreach(BasecampHelper::teams($todo->assigned ,20 ) as $key=>$val)
	  					{!! $val['avatar'] !!} <small>{!! $val['name'] !!}</small>

	  				@endforeach
	  				</span>
	  				@if(isset($access['delete']))
					<a href="{{ url('basecamp/delete_todo?id='.$todo_set->set_id.'&todo_id='.$todo->todo_id)}}"  class="btn btn- btn-sm pull-right delete_todo"  >
						<i class="fa fa-trash-o"></i>  </a>	
					@endif
					@if(isset($access['update']))	

						<a href="{{ url('basecamp/update_todo?id='.$todo_set->set_id.'&todo_id='.$todo->todo_id)}}" onclick="SximoModal(this.href,'Update To Do'); return false;" class="btn btn- btn-sm pull-right"  >
						<i class="fa fa-pencil"></i>  </a>
					@endif	
	  				</li>
	  			@endforeach
	  			@if(isset($access['update']))
	  				<li>
	  					<a href="{{ url('basecamp/update_todo?id='.$todo_set->set_id)}}" onclick="SximoModal(this.href,'New To Do'); return false;" class="btn btn-default btn-sm"  >
						<i class="fa fa-plus"></i> New To Do </a>	  						
	  				</li>
	  			@endif	
	  			</ul>

	  		</div>
	  	</div>
	  		
  	</div>

  	<div id="activities" class="basecamp_activity">


  	</div>
	</div>		
</div>
</div>
<script type="text/javascript">
	$(function(){
		$('.delete_todo').on('click',function(){
			if(confirm('Remove this item ?')){
				return true ;
			} else {
				return false;
			}
		})
		$.get('{{ url("basecamp/comments?id=".$todo_set->set_id) }}',function(data){
			$('#activities').html(data);
		})
	})
</script>
@include('basecamp.javascript')
@endsection