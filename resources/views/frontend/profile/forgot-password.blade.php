@extends('frontend.master')

@section('content')
	<div class="row">
		<div class="col-sm-12" >
			<div class="ok hide">
				<p class="alert alert-success">Successful. Please check your email</p>
			</div>
			<form style="margin:0 auto; width:50%" method="post">
			  <div class="form-group">
			    <label for="">{{trans('home.email')}}</label>
			    <input type="text" class="form-control" id="" placeholder="{{trans('home.enter_email')}}" name="email" autofocus>
			  </div>
			  <p class="text text-danger error hide">{{trans('profile.This_email_does_not_exist')}}</p>
			  <button type="submit" class="btn btn-primary col-sm-12 lgHeightBtn">{{trans('profile.Send_email_reset_Password')}}</button>
			 <p class="hide load">Loading...</p>
			</form>
		</div>
	</div>
	<script>
	$('form').submit(function(){
		var data = $(this).serialize();
		$('.error').addClass('hide');
		$('.load').removeClass('hide');

		$.ajax({
			type:'post',
			url:'{{url("forgot-password")}}',
			data:{data:data,_token:token},
			success:function(x){
				if(x=='not_exist'){
					$('.error').removeClass('hide');
					$('.load').addClass('hide');
				}else{
				$('.load').addClass('hide');
					
					$('form').remove();
					$('.ok').removeClass('hide');
				}
			}
		});
		return false;
	});
	
	</script>
@stop