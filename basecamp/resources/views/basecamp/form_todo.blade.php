 {!! Form::open(array('url'=>'basecamp', 'class'=>'form-vertical CrudEngineForm','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}

	<div class="form-group row " >
		<label for="Name" class=" control-label "> Todo Name  </label>
		<div class="">
			<input type="text" name="subject" class="form-control input-sm" value="{{ $row['subject'] }}" required="true" />
		</div> 
	</div>	
	<div class="form-group row " >
		<label for="Name" class=" control-label "> Assign To   </label>
		<div class="">
		<?php $user_opt = explode(",",$row['assigned']);?>
		@foreach($users as $key => $user)
			<div class="checkbox-inline">
				<input type="checkbox" value="{{ $key }}" name="assigned[]" 
				@if(in_array($key,$user_opt)) checked="checked" @endif 
				class="minimal-green"> {!! $user!!}
			</div>	

		@endforeach
		</div> 
	</div>	
	<div class="form-group row " >
		<label for="Name" class=" control-label "> Due Date  </label>
		<div class="">
			<div class="input-group input-group-sm" style="width: 30%;">
				<input type="text" name="duedate" required="true"  class="form-control input-sm CrudEngineDate" value="{{ $row['duedate'] }}" />
				<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
			</div>	
		</div> 
	</div>		
	<div class="form-group row " >
		<label for="Name" class=" control-label "> Extra details ( <i> Optional </i> )</label>
		<div class="">
			<textarea name="note" class="form-control input-sm CrudEngineEditor" >{{ $row['note'] }}</textarea>
		</div> 
	</div>	
	<div class="form-group row " >
		
		<div class="">
			<button type="submit" class="btn btn-primary"> Submit Lists </button>
		</div> 
	</div>	
	<input type="hidden" name="set_id" value="{{ $set_id }}" />	
	<input type="hidden" name="todo_id" value="{{ $row['todo_id'] }}" />	
	<input type="hidden" name="action_task" value="save_todo" />
{!! Form::close() !!}
<script type="text/javascript">
$(function(){
	$('.CrudEngineForm').parsley();
	$('.CrudEngineEditor').summernote({ height: 150});
	$('input[type="checkbox"].minimal-green, input[type="radio"].minimal-green').iCheck({
      checkboxClass: 'icheckbox_square-green',
      radioClass: 'iradio_square-green'
    });
    $('.CrudEngineDate').datepicker({format:'yyyy-mm-dd',autoClose:true}) 
})    
</script>
