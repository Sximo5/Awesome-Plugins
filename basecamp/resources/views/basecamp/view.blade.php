<div class="sximo_tools text-right">
	<a href="javascript:void(0)" class="btn btn-sm" onclick="CrudEngine_Close('#{{ $actionId}}')"><i class="fa fa-times"></i> </a>
</div>	
<div class="basecamp">
	<div class="title text-center"> 
		<h3> {{ $row['basecamp.name'] }}</h3>
		<div class="note"> {{ $row['basecamp.note'] }} </div>
	</div>
	<div class="row m-t">
		@foreach($todo_sets as $todo)
			<div class="col-md-4">	
				<div class="todo_sets">
					<div class="title">
						<h3><i class="fa fa-bars"></i> {{ $todo->title }}</h3>
					</div>
					<div class="inner">	
					<ul class="todo_list">
						<li><input type="checkbox" class="minimal-red" /> Get Materials </li>
						<li><input type="checkbox" class="minimal-red" /> Get Materials </li>
						<li><input type="checkbox" class="minimal-red" /> Get Materials </li>
						<li><input type="checkbox" class="minimal-red" /> Get Materials </li>
						<li><input type="checkbox" class="minimal-red" /> ...... </li>
						

					</ul>
					</div>
					<div class="footer">
					<a href="{{ url('basecamp/todo?id='.$todo->set_id) }}"> View All To Do </a>
					</div>
				</div>
			</div>
		@endforeach
	</div>	



</div>
<style type="text/css">
	.basecamp {
		font-size: 13px;
	}
	.basecamp .todo_sets {
		
		border: solid 1px #eee;
		
		margin-bottom: 20px;
		background: #fff;
		
	}
	.basecamp .todo_sets .title{
		padding: 5px 20px; background: #f9f9f9;

	}
	.basecamp .todo_sets h3{
		font-size: 14px;
		margin: 0;
		padding: 0;
		font-weight: 600;
	}
	.basecamp .todo_sets .inner{
		padding: 10px 20px;
		height: 200px;
		overflow: hidden;

	}	
	.basecamp .todo_sets .footer{
		padding: 10px 20px; background: #f9f9f9;


	}	
	.basecamp  ul.todo_list {
		margin: 20px 0 0 0;
		padding: 0;
		list-style: none;
	}
	.basecamp  ul.todo_list li{ 
		padding: 2px 10px;
		font-size: 13px;
	}

</style>

