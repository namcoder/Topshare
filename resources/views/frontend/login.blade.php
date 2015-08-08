@extends('frontend.master')

@section('content')
	<div class="row">
		<div class="col-sm-12" >
			<form style="margin:0 auto; width:50%" method="post">
			  <div class="form-group">
			    <label for="">{{trans('home.email')}}</label>
			    <input type="text" class="form-control" id="" placeholder="{{trans('home.enter_email')}}" name="email" autofocus>
			  </div>
			  <div class="form-group">
			    <label for="">{{trans('home.password')}}</label>
			    <input type="password" class="form-control" id="" placeholder="{{trans('home.password')}}" name="password" >
			  </div>
			  <p class="text text-danger error hide">{{trans('home.The_Username_or_Password_does_not_match')}}</p>
			  <button type="submit" class="btn btn-primary col-sm-12 lgHeightBtn">{{trans('home.login')}}</button>
			  <p><a href="{{url('forgot-password')}}">{{trans('home.forgot_password')}}</a></p>
			  <p>
			 	 <a href="{{url('sign-up')}}" class="btn btn-success col-sm-12">{{trans('home.new_blogger_register_here')}}</a>
			  </p>
			</form>
		</div>
	</div>
	<script>
	$('form').submit(function(){
		var data = $(this).serialize();
		$('.error').addClass('hide');
		$.ajax({
			type:'post',
			url:'{{url("login")}}',
			data:{data:data,_token:token},
			success:function(x){
				if(x=='false'){
					$('.error').removeClass('hide');
				}else{
					window.location.href='{{url("profile")}}';
				}
			}
		});
		return false;
	});
	
	</script>
@stop