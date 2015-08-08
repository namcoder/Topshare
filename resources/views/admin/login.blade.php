<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Administrator Login</title>
	<link rel="stylesheet" type="text/css" href="{{asset('public/backend/css/bootstrap/bootstrap.min.css')}}" />
	<link rel="stylesheet" type="text/css" href="{{asset('public/backend/css/libs/font-awesome.min.css')}}" />
	<link rel="stylesheet" type="text/css" href="{{asset('public/backend/css/libs/nanoscroller.css')}}" />
	<link rel="stylesheet" type="text/css" href="{{asset('public/backend/css/compiled/theme_styles.css')}}" />
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,300|Titillium+Web:200,300,400' rel='stylesheet' type='text/css'>
	<link type="image/x-icon" href="{{asset('public/backend/favicon.png')}}" rel="shortcut icon"/>
</head>
<body id="login-page">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<div id="login-box">
					<div id="login-box-holder">
						<div class="row">
							<div class="col-xs-12">
								<header id="login-header">
									<div id="login-logo">
										Login
									</div>
								</header>
								<div id="login-box-inner">
									<form role="form" action="{{url('admin-login')}}" method="post">
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-user"></i></span>
											<input class="form-control" type="text" name="email" autofocus placeholder="Email">
										</div>
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-key"></i></span>
											<input type="password" class="form-control" name="password" placeholder="Password">
										</div>
										<div id="remember-me-wrapper">
											<div class="row">
												<div class="col-xs-6">
													<div class="checkbox-nice">
														<input type="checkbox" id="remember-me" checked="checked" />
														<label for="remember-me">
															Remember me
														</label>
													</div>
												</div>
												<a href="#" id="login-forget-link" class="col-xs-6">
													Forgot password?
												</a>
											</div>
										</div>
										<div class="row">
											<div class="col-xs-12">
												<input type="hidden" name="_token" value="{{ csrf_token() }}">
												<button type="submit" class="btn btn-success col-xs-12">Login</button>
											</div>
										</div>
										@if(Session::has('error'))
										<div class="row">
											<div class="col-xs-12">
												<p class="social-text text-danger">
														{{Session::get('error')}}	
												</p>
											</div>
										</div>
										@endif
									</form>
								</div>
							</div>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</div>
	
	<script src="{{asset('public/backend/js/jquery.js')}}"></script>
	<script src="{{asset('public/backend/js/bootstrap.js')}}"></script>
	<script src="{{asset('public/backend/js/jquery.nanoscroller.min.js')}}"></script>
	<script src="{{asset('public/backend/js/scripts.js')}}"></script>
	
</body>
</html>