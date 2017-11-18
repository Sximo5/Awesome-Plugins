 {!! Form::open(array('url'=>'basecamp', 'class'=>'form-vertical CrudEngineForm','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}

	<div class="form-group row " >
		<label for="Name" class=" control-label "> Name The List </label>
		<div class="">
			<input type="text" name="title" class="form-control input-sm" value="{{ $row['title'] }}" />
		</div> 
	</div>	
	<div class="form-group row " >
		<label for="Name" class=" control-label "> Detail </label>
		<div class="">
			<textarea name="brief" class="form-control input-sm CrudEngineEditor" >{{ $row['brief'] }}</textarea>
		</div> 
	</div>	
	<div class="form-group row " >
		
		<div class="">
			<button type="submit" class="btn btn-primary"> Submit Lists </button>
		</div> 
	</div>	
	<input type="hidden" name="basecamp_id" value="{{ $camp_id }}" />	
	<input type="hidden" name="set_id" value="{{ $row['set_id'] }}" />	
	<input type="hidden" name="action_task" value="save_list" />
{!! Form::close() !!}
<script type="text/javascript">
	$('.CrudEngineEditor').summernote({ height: 150});
</script>

