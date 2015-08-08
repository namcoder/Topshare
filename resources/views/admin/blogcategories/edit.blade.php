@extends('admin.master')

@section('title')
	Edit category
@stop

@section('content')
	<div class="col-sm-6">
		<div class="main-box">
			<header class="main-box-header clearfix">
				<h2>Edit Category</h2>
			</header>
			<div class="main-box-body clearfix">
				<form role="form" method="post" action="{{url('admin/blog-categories')}}/{{Request::segment(3)}}">
					<div class="form-group">
						<label for="">Name</label>
						<input type="text" class="form-control" name="name" required value="{{$info->name}}">
					</div>
					<div class="form-group">
						<label for="">Language code</label>
						<select name="lang_code"  class="form-control" required>
							<option value="">Select language</option>
							@foreach($lang as $l)
							<option value="{{$l->code}}" @if($info->lang_code == $l->code) selected @endif>{{$l->name}}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<input type="hidden" name="_token" value="{{csrf_token()}}">
						<button type="submit" class="btn btn-success">Save</button>
						<a href="{{url('admin/blog-categories')}}" class="btn btn-default">Cancel</a>
					</div>
				</form>
				<script>
				/// submit form
				$("form").validate({
					errorClass:'text-danger',
					errorPlacement: function(error, element) {
						element.parent().addClass('has-error') ;
						error.insertAfter(element);
					},
					success: function(label) {
					   label.parent().removeClass('has-error') ;
					   label.remove();
					 },
					 submitHandler: function(form){
					 	form.submit();
					 }
				});
			
				</script>
			</div>
		</div>
	</div>
@stop