<script type="text/javascript">
	$(function(){
		$('.delete_list').on('click',function(){
			if(confirm('Delete this lists ?')){
				return true;
			} else {
				return false;
			}
		})
		$('.task_result').on('ifChecked', function(event) {
		   var val = $(this).val();
		   var state = $(this).data('state');
		   	$.get("{!! url('basecamp/task?id=')!!}"+ val +'&state='+ state,function(data){
		   		notyMessage(data.message);	
		   })

		});
		$('.task_result').on('ifUnchecked', function(event) {
		   var val = $(this).val();
		   var state = $(this).data('state');
		   	$.get("{!! url('basecamp/task?id=')!!}"+ val +'&state='+ state,function(data){
		   		notyMessage(data.message);	
		   })
		}); 


	})
</script>