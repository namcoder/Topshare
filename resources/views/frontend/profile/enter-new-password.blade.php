@extends('frontend.master')

@section('content')
	<div class="row">
		<div class="col-sm-12" >
			<div class="ok hide">
				<p class="alert alert-success">{{trans('profile.Change_password_successful')}}</p>
			</div>
			<form style="margin:0 auto; width:50%" method="post">
			  <div class="form-group">
			    <label for="">{{trans('home.password')}}</label>
			    <input type="password" class="form-control" id="pass"  name="password" autofocus required>
			  </div>
			  <div class="form-group">
			    <label for="">{{trans('profile.Re-type_password')}}</label>
			    <input type="password" class="form-control" id="pass2"  name="password2"  required>
			  </div>
			  <input type="hidden" name="email" value="{{Request::segment(2)}}">
			  <input type="hidden" name="key" value="{{Request::segment(3)}}">
			  <p class="text text-danger error hide">{{trans('profile.Password_does_not_match')}}</p>
			  <button type="submit" class="btn btn-primary col-sm-12 lgHeightBtn">{{trans('profile.Change')}}</button>
			  <p class="hide load">Loading...</p>
			</form>
		</div>
	</div>
	<script>
	$('form').submit(function(){
		var data = $(this).serialize();
		$('.error').addClass('hide');
		var pass = $('#pass').val();
		var pass2 = $('#pass2').val();
		if(pass!=pass2){
			$('.error').removeClass('hide');
			return false;
		}
		$('.load').removeClass('hide');
		$.ajax({
			type:'post',
			url:'{{url("update-password")}}',
			data:{data:data,_token:token},
			success:function(x){
				$('.load').addClass('hide');
				$('form').remove();
				$('.ok').removeClass('hide');
			}
		});
		return false;
	});
	
	</script>
@stop