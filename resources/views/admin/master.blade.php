<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>@yield('title')</title>
	<link rel="stylesheet" type="text/css" href="{{asset('public/backend/css/bootstrap/bootstrap.min.css')}}" />
	<link rel="stylesheet" type="text/css" href="{{asset('public/backend/css/libs/font-awesome.min.css')}}" />
	<link rel="stylesheet" type="text/css" href="{{asset('public/backend/css/libs/nanoscroller.css')}}" />
	<link rel="stylesheet" type="text/css" href="{{asset('public/backend/css/compiled/theme_styles.css')}}" />
	<link rel="stylesheet" type="text/css" href="{{asset('public/backend/css/libs/datepicker.css')}}" />
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,300|Titillium+Web:200,300,400' rel='stylesheet' type='text/css'>
	<link type="image/x-icon" href="{{asset('public/backend/favicon.png')}}" rel="shortcut icon"/>
	<script src="{{asset('public/backend/js/jquery.js')}}"></script>
	<script src="{{asset('public/backend/js/bootstrap.js')}}"></script>
	<script src="{{asset('public/backend/js/jquery.nanoscroller.min.js')}}"></script>
	<script src="{{asset('public/backend/js/bootstrap-datepicker.js')}}"></script>
	<script src="{{asset('public/backend/js/scripts.js')}}"></script>
	<script src="{{asset('public/frontend/js/jquery.validate.min.js')}}"></script>
	<script src="{{asset('public/backend/js/nam.js')}}"></script>

	<style>
		a.btn:focus{
			color: #fff !important;
		}
	</style>
	<script>
	 var token = '<?php echo csrf_token(); ?>';
	</script>
</head>
<body>
	<div id="theme-wrapper">
		<header class="navbar" id="header-navbar">
			<div class="container">
				<a href="{{url('admin')}}" id="logo" class="navbar-brand">
					Administrator
				</a>
				
				<div class="clearfix">
				<button class="navbar-toggle" data-target=".navbar-ex1-collapse" data-toggle="collapse" type="button">
					<span class="sr-only">Toggle navigation</span>
					<span class="fa fa-bars"></span>
				</button>
				
				
				<div class="nav-no-collapse pull-right" id="header-nav">
					<ul class="nav navbar-nav pull-right">
						
						<li class="dropdown profile-dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<img src="{{asset('public/backend/img/samples/scarlet-159.png')}}" alt=""/>
								<span class="hidden-xs">{{Auth::user()->username}}</span> <b class="caret"></b>
							</a>
							<ul class="dropdown-menu dropdown-menu-right">
								<li><a href="{{url('admin/profile')}}"><i class="fa fa-user"></i>Profile</a></li>
								<li><a href="#"><i class="fa fa-cog"></i>Settings</a></li>
								<li><a href="#"><i class="fa fa-envelope-o"></i>Messages</a></li>
								<li><a href="{{url('admin/logout')}}"><i class="fa fa-power-off"></i>Logout</a></li>
							</ul>
						</li>
						<li class="hidden-xxs">
							<a class="btn" href="{{url('admin/logout')}}">
								<i class="fa fa-power-off"></i>
							</a>
						</li>
					</ul>
				</div>
				</div>
			</div>
		</header>
		<div id="page-wrapper" class="container">
			<div class="row">
				<div id="nav-col">
					<section id="col-left" class="col-left-nano">
						<div id="col-left-inner" class="col-left-nano-content">
							
							<div class="collapse navbar-collapse navbar-ex1-collapse" id="sidebar-nav">	
								@include('admin.leftMenu')
							</div>
						</div>
					</section>
					<div id="nav-col-submenu"></div>
				</div>
				<div id="content-wrapper">
					<div class="row">
						<div class="col-lg-12">
							<div class="row">
								<div class="col-lg-12">
									<div id="content-header" class="clearfix">
										<div class="pull-left">
											<h1>@yield('title')</h1>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
							
								@yield('content')

							</div>
						</div>
					</div>
					
					<footer id="footer-bar" class="row">
						<p id="footer-copyright" class="col-xs-12">
							Developed by: <a href="mailto:nam@namcoder.com">Nam Le</a>
						</p>
					</footer>
				</div>
			</div>
		</div>
	</div>
	
	
	
</body>
</html>