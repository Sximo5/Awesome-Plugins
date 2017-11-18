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
	 	<div class="contact-box ">
		 	<a href="{{ url($url.'?task=update&id='.$row[$this_table.'.'.$this_key] )}}" code="view" class="ajaxCallback" title="">
			 	<div class="info  bg-primary" >
			 		<h3> <strong>{{ $row['contacts.Surname']}}</strong> </h3>
			 		<span>{{ $row['contacts.Title']}} </span>
			 		 	
			 		<div class="image ">
				 		@if(file_exists('./uploads/clients/'.$row['contacts.Avatar']) && $row['contacts.Avatar'] !='')
				 			<img src="{{ asset('uploads/clients/'.$row['contacts.Avatar']) }}" width="80" class="img-circle" />
				 		@else
				 			<img src="{{ asset('uploads/images/no-image.png') }}" width="80" class="img-circle" />
				 		@endif
				 	
				 	</div>
				</div>	 	
		 	</a> 	
		 		<div class="company m-t ">
		 			<a href="{{ url('client?task=view&id='.$row['clients.ClientID'] )}}" onclick="SximoModal(this.href,' Client Details'); return false;" >
		 				{{ $row['clients.ClientName']}}
		 			</a>
		 		</div>

		 		<div class="about m-b ">
		 			{{ $row['contacts.Address1']}} <br />
		 			{{ $row['contacts.Address2']}}
		 			<br /><br />
		 			<a class="btn btn-xs btn-default"  target="_blank">
						<i class="fa fa-phone" ></i> {{ $row['contacts.Phone']}} 
					</a>
		 		</div>

			 	
				
		 	<div class="footer">
				<div class="m-t-xs btn-group">
					<a class="btn btn-xs btn-default" href="http://twitter.com/{{ $row['contacts.Twitter']}}" target="_blank">
						<i class="fa fa-google" ></i> Google + </a>
					<a class="btn btn-xs btn-default" href="http://facebook.com/{{ $row['contacts.Facebook']}}" target="_blank">
						<i class="fa fa-facebook"></i> Facebook</a>
					<a class="btn btn-xs btn-default" href="http://gplus.com/{{ $row['contacts.Google']}}" target="_blank">
						<i class="fa fa-twitter"></i> Twitter</a>
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