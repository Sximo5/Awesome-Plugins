@include( 'CrudEngine.default.toolbar')
<?php
	$pages = array(10,20,30,40,50);
?>
<div style="padding-bottom: 50px;">
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
 <div class="row">
@foreach($rows as $row)
	<div class="col-md-3">
	 	<div class="contact-box">
	 	<a href="{{ url($url.'?task=update&id='.$row[$this_table.'.'.$this_key] )}}" code="view" class="ajaxCallback" title="">
		 	<div class="image">
		 		@if(file_exists('./uploads/clients/'.$row['clients.ClientLogo']) && $row['clients.ClientLogo'] !='')
		 			<img src="{{ asset('uploads/clients/'.$row['clients.ClientLogo']) }}" width="100" />
		 		@else
		 			<img src="{{ asset('uploads/images/no-image-rounded.png') }}" width="100" />
		 		@endif
		 	
		 	</div>
		 	<div class="info m-b">
		 		<h3> <strong>{{ $row['clients.ClientName']}}</strong> </h3>
		 		<span>{{ $row['clients.ClientAddress']}}</span>


		 	</div>
		</a> 	
		 	<div class="footer">
				<div class="m-t-xs">
					<a class="btn btn-xs "><i class="fa fa-phone"></i>  {{ $row['clients.ClientPhone']}} </a>
					<a class="btn btn-xs "><i class="fa fa-envelope"></i>  {{ $row['clients.ClientEmail']}}</a>
				</div>
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
@include( 'CrudEngine.default.table_footer')