@include( 'CrudEngine.default.toolbar')
<?php
	$pages = array(10,20,30,40,50);
	require_once(app_path() .'/Library/BasecampHelper.php');

?>
<div class="clearfix" style="padding-bottom: 50px;">
<div class=" m-b">
	
	Show 
	<select class="form-control input-sm" id="perpage" style="display: inline-block; width: 75px;">
		@foreach($pages as $page)
		<option value="{{ $page }}" @if(isset($_GET['rows']) && $_GET['rows'] == $page) selected @endif >{{ $page }}</option>
		@endforeach		
	</select>
	entries
	

</div> 

 {!! Form::open(array('url'=> $url, 'class'=>'form-vertical','files' => true ,'id'=> $actionId .'table')) !!}
 <div class="basecamp">
@foreach($rows as $row)
		 	<?php
		 		$progress = \BasecampHelper::progress($row['basecamp.camp_id']);

		 	?>
	<div class="col-md-4">
	 	<div class="projects">
	 	<a href="{{ url($url.'/todosets?id='.$row[$this_table.'.'.$this_key] )}}" >
		 	<div class="info m-b" >
		 		<h3> <strong>{{ $row['basecamp.name']}}</strong> </h3>

			 	<div class="teams" style="padding: 10px">
			 			 @foreach(BasecampHelper::teams($row['basecamp.teams'] ,30 ) as $key=>$val)
		  					{!! $val['avatar'] !!} 

		  				@endforeach

			 	</div>		 		
		 		<div class="note">{{ $row['basecamp.note']}}</div>

				<div class="summary">
					<span>Status of current project:</span>
					<div class="stat-percent">{{ $progress['progress'] }}%</div>
					<div class="progress progress-mini">
					    <div style="width: {{ $progress['progress'] }}%;" class="progress-bar"></div>
					</div>
				</div>

		 	</div>

		</a> 	
		 	<div class="footers clearfix summary">

		 		<div class="col-md-4"> Tasks <span> {{ $progress['tasks'] }}</span> </div>
		 		<div class="col-md-4">Opened  <span> {{ $progress['opened'] }}</span></div>
		 		<div class="col-md-4">Closed  <span> {{ $progress['closed'] }}</span></div>
				
		 	</div>
	 	</div>
 	</div>
@endforeach
</div>
<input type="hidden" name="task" value="copy" id="task" />
{!! Form::close() !!}
</div>

<div class="Page navigation example">	
	<div class="row">
		<div class="col-md-4">
			<div style="vertical-align: middle; line-height: 1.7em; height: 30px; padding: 10px 0;">
				

				Showing {{ ($paginator->currentpage()-1) * $paginator->perpage()+1 }} to {{$paginator->currentpage()*$paginator->perpage()}}
    of  {{$paginator->total()}} entries

			</div>	
		</div>
		<div class="col-md-8 text-right">
			{!! $paginator->links() !!}
		</div>
	</div>
	
</div>	
<script type="text/javascript">

</script>
@include( 'CrudEngine.default.table_footer')