@extends('layouts.app')

@section('content')

<section class="page-header row">
  <h3> Basecamp  </h3>
  <ol class="breadcrumb">
    <li><a href="{{ url('dashboard')}}"> Home </a></li>
    <li><a href="{{ url('basecamp')}}"> Basecamp </a></li>
    <li  class="active">  {{ $bcamp->name }} </a></li>
  </ol>
</section>
<div class="page-content row">
  <div class="page-content-wrapper no-margin">

  	<div class="basecamp">
  	<div class="sbox bg-gray">
	  	<div class="sbox-title clearfix">
	  		<div class="sbox-tools">
	  			@if(isset($access['update']))
	  			<a href="" class="btn btn- btn-sm" onclick="SximoModal('{{ url('basecamp?task=update&id='.$bcamp->camp_id)}}','Edit Basecamp'); return false;"  >
					<i class="fa fa-pencil"></i> Edit
				@endif	
				</a>
  				<a href="{{ url('basecamp')}}" class="btn btn- btn-sm"  >
					<i class="fa fa-close"></i> Back to Basecamp
				</a>
	  		</div>
	  	</div>
	  	<div class="sbox-content clearfix">
	  		<div style="padding: 0px 0 20px; text-align: center;">
	  			<h3> {{ $bcamp->name }} </h3>
	  			<div>{{ $bcamp->note }} </div>
	  			<div class="m-t m-b"> {!! $bcamp->teams !!} </div> 
	  		
	  			@if(isset($access['create']))
	  			<a href="javascript://ajax" onclick="SximoModal('<?php echo url('basecamp/update_list?id='.$bcamp->camp_id);?>','New Lists')" class="btn btn-sm btn-default "><i class="fa fa-plus"></i> Create New Todo List </a>
	  			@endif
	  		</div>	
	  		@if(count($todo_sets) >=1)
	  		<div class="row m-t">
		  		@foreach($todo_sets as $todo)
				<div class="col-md-4">	
					<div class="todo_sets">
						<div class="title">
							<h3><i class="fa fa-bars"></i> {{ $todo['row']['title'] }}</h3>
							<div class="sbox-tools">
							@if(isset($access['update']))	
								<a href="javascript://ajax" onclick="SximoModal('<?php echo url('basecamp/update_list?id='.$bcamp->camp_id.'&set_id='.$todo['row']['set_id']);?>','New Lists')" class="btn btn-sm  "><i class="fa fa-pencil"></i> </a>
							@endif
							@if(isset($access['delete']))	
								<a href="<?php echo url('basecamp/delete_list?id='.$bcamp->camp_id.'&set_id='.$todo['row']['set_id']);?>"  class="btn btn-sm delete_list "><i class="fa fa-trash-o"></i> </a>
							@endif	
							</div>	
						</div>
						<div class="inner">	
						@if(count($todo['todos']))
						<ul class="todo_list">
							@foreach($todo['todos'] as $item)
								<li><input type="checkbox" class="minimal-green task_result" @if($item['status'] =='close') checked="checked" @endif value="{{ $item['todo_id'] }}" /> {{ $item['subject']}} </li>
								
							@endforeach	
							<li><input type="checkbox" class="minimal-green" /> ...... </li>
							

						</ul>
						@else
							<div style="padding: 50px 0; text-align: center;">

							@if(isset($access['create']))	
								<a href="{{ url('basecamp/update_todo?id='.$todo['row']['set_id'])}}" onclick="SximoModal(this.href,'Create To Do Task'); return false;" class="btn btn- btn-sm btn-default"  ><i class="fa fa-pencil"></i> Create First Todo  </a>
							@endif	

							</div>

						@endif
						</div>
						<div class="footer">
						<a href="{{ url('basecamp/todo?id='.$todo['row']['set_id']) }}"> View All To Do </a>
						</div>
					</div>
				</div>
				@endforeach
			</div>	
			@else
			<div style="padding: 50px 0; text-align: center;">
				<p> No to do task found ! <br /></p>
			
			</div>

			@endif
	  	</div>
	  		
  	</div>
				

	</div>		
</div>
@include('basecamp.javascript')
@endsection