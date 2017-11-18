<div class="sximo_tools text-right">
	<a href="javascript:void(0)" class="btn btn-default btn-sm" onclick="CrudEngine_Close('#{{ $actionId}}')"><i class="fa fa-times"></i> </a>
</div>	
<fieldset>
	<legend> {{ $title }}</legend>
<table class="table">
	<tbody>
		@foreach($rows as $row)
			@foreach($views as $key=>$val)
			<tr>			
				<td> {{ $val }}</td>
				<td> {!! $row[$key] !!}</td>							
			</tr>
			@endforeach	
		@endforeach
		
	</tbody>
</table>
</fieldset>
@if(is_array($subdetail))

	@foreach($subdetail as $sub)
		<fieldset>
			<legend> {{ ucwords($sub) }}</legend>
			<div class="subdetail" id="{{ $sub }}">{{ $sub }}</div>
		</fieldset>
	@endforeach

	<script type="text/javascript">
		$(function(){
			<?php foreach($subdetail as $sub) :
				$suburl = $sub."?task=sub&relation=".$this_key."&id=".$key_value;
			 ?>
			
			$.get('<?php echo $suburl ;?>',function(data){
				$('#<?php echo $sub;?>').html(data)
			})
			
			<?php endforeach;?>
		})
	</script>
@endif