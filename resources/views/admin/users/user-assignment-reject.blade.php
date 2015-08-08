@extends('admin.master')

@section('title')
	Reject Assignment
@stop

@section('content')
	<div class="col-sm-6">
		<div class="main-box">
			<header class="main-box-header clearfix">
				<h2>Reject Assignment</h2>
			</header>
			
			<div class="main-box-body clearfix">
				<form role="form" method="post">
					<div class="form-group">
						<label for="">Reason</label>
						<input type="text" class="form-control" name="reason" required autofocus>
					</div>
					<div class="form-group">
						<input type="hidden" name="_token" value="{{csrf_token()}}">
						<button type="submit" class="btn btn-success">OK</button>
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