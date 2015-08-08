<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="{{asset('public/frontend/css/three-quarters.css')}}" type="text/css">
	<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.min.js"></script>
	<link rel="stylesheet" href="{{asset('public/frontend/style.css')}}">
	<title>Frontpage</title>
	<script>
		var token = '<?php echo csrf_token(); ?>';
	</script>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-sm-12 text-right locale">
				<?php 
					$langs = App\Language::all();
				 ?>
				@foreach($langs as $lang) 
					<a href="#" locale="{{$lang->code}}">{{$lang->name}}</a>
				@endforeach
			</div>
			@if(Auth::check())
			<div class="col-sm-12 text-right">
				<a href="{{url('profile')}}"><strong>My Profile</strong></a>
			</div>

			@endif
			<script>
				$('.locale a').click(function(){
					var locale = $(this).attr('locale');
					$.ajax({
						type:'post',
						url:'{{url("set-locale")}}',
						data:{locale:locale,_token:token},
						success:function(x){
							window.location.reload();
						}
					});
					return false;
				});
			</script>
		</div>
		<div class="row">
			<div class="col-sm-2 text-center">
				<div class="tempBgBox">
					<a href="{{url('/')}}">logo</a>
				</div>
			</div>
			<div class="col-sm-10 ">
				<div class="row">
					<div class="col-sm-12 header">
						<div class="tempBgBox text-center">
							<a href="{{url('/')}}">topshare</a> 
						</div>
					</div>
				</div>
				@yield('content')
			</div>
		</div>
	</div>
</body>
</html>