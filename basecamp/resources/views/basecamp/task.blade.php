@extends('layouts.app')

@section('content')
<?php require_once(app_path() .'/Library/BasecampHelper.php');?>
<section class="page-header row">
  <h3> Basecamp - Todo  </h3>
  <ol class="breadcrumb">
    <li><a href="{{ url('dashboard')}}"> Home </a></li>
    <li><a href="{{ url('basecamp')}}"> Basecamp </a></li>
    <li  class="active">{{ $todo->title }}  </a></li>
    <li  class="active">{{ $todo->subject }}  </a></li>
  </ol>
</section>
<div class="page-content row">
  <div class="page-content-wrapper no-margin">

  	<div class="col-md-8 col-sm-offset-2 basecamp" style="padding-bottom: 30px;">
  	<div class="sbox bg-gray">
	  	<div class="sbox-title clearfix">
	  		
	  		<div class="sbox-tools">
	  			<a href="{{ url('basecamp/todo?id='.$todo->set_id)}}" class="btn btn- btn-sm"  >
					<i class="fa fa-close"></i> Back to Lists
				</a>
				@if(isset($access['update']))	
				<a href="{{ url('basecamp/update_todo?id='.$todo->set_id.'&todo_id='.$todo->todo_id)}}" onclick="SximoModal(this.href,'Update To Do'); return false;" class="btn btn- btn-sm pull-right"  >
				<i class="fa fa-pencil"></i> Edit </a>
				@endif
  				
	  		</div>
	  	</div>
	  	<div class="sbox-content" style="background: #fff;">
	  		<div class="text-center">
		  		<h3 class="text-center"> {{ $todo->subject }}  </h3>
		  		Completed Tuesday at 2:31pm by Chris J. 
		  	</div>	
	  		<hr />
	  		<div class="todos form-horizontal" style=" min-height: 200px; padding-bottom: 20px;">
	  			<div class="form-group">
	  				<label class="col-md-3 text-right"> Assigned To </label>
	  				<div class="col-md-9">	
		  				@foreach(\BasecampHelper::teams($todo->assigned ,30 ) as $key=>$val)
		  					{!! $val['avatar'] !!} <small>{!! $val['name'] !!}</small>

		  				@endforeach	
	  				</div>
	  			</div>	
	  			<div class="form-group">
	  				<label class="col-md-3 text-right"> Due On </label>
	  				<div class="col-md-9">	
		  				--
	  				</div>
	  			</div>	

	  			<div class="form-group">
	  				<label class="col-md-3 text-right"> Note </label>
	  				<div class="col-md-9">	
		  				{!! $todo->note !!} 
	  				</div>
	  			</div>
	  			<div class="form-group">
	  				<label class="col-md-3 text-right"> Completed this ? </label>
	  				<div class="col-md-9">	
		  				<input type="checkbox" name="" value="{{ $todo->todo_id }}" 
		  					@if($todo->status =='close') checked @endif
		  				 data-state="{{ $todo->status }}" class="minimal-green task_result"> Yes 
	  				</div>
	  			</div>		  				
	  		</div>
	  		<hr />


	  	</div>
	  		
  	</div>
  	<div id="activities" class="basecamp_actvity">

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
		$.get('{{ url("basecamp/comments?todo_id=".$todo->todo_id) }}',function(data){
			$('#activities').html(data);
		})
	})
</script>
@include('basecamp.javascript')
@endsection