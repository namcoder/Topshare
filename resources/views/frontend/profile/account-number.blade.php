@extends('frontend.master')

@section('content')
<link rel="stylesheet" href="{{asset('public/frontend/css/three-quarters.css')}}" type="text/css">
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.min.js"></script>
	<div class="row">
		<form id="userinfo">
			<div class="col-sm-6">
				<p class="alert alert-success saveok hide">{{trans('profile.Updated')}}</p>
			  <div class="form-group">
			    <label class="control-label" for="">Bank account number</label>
			    <input type="number" class="form-control" id="" name="bank_account_number" required value="{{Auth::user()->account_number}}">
			  </div>
			  
			  <button type="submit" class="btn btn-primary col-sm-12">{{trans('profile.update_information')}}</button>
			</div>
		</form>
	</div>

	
	<script>
	
	$("#userinfo").validate({
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
				///////////// SUBMIT when all done and OK
				var all_data = $("#userinfo").serialize();

				$.ajax({
					type:'post',
					url:'{{url("profile/account-number")}}',
					data:{data:all_data,_token:token},
					success:function(x){
						// $('#userinfo').hide();
						$('.saveok').removeClass('hide');
					}
				});
			}
		});

	</script>
@stop