@extends('admin.master')

@section('title')
	Dashboard
@stop

@section('content')
	<a href="{{url('admin/users/list')}}">
		<div class="col-lg-3 col-sm-6 col-xs-12">
			<div class="main-box infographic-box colored red-bg">
				<i class="fa fa-user"></i>
				<span class="headline">Users</span>
				<span class="value">{{$num_users}}</span>
			</div>
		</div>
	</a>
	<a href="{{url('admin/blog-categories')}}">
		<div class="col-lg-3 col-sm-6 col-xs-12">
			<div class="main-box infographic-box colored green-bg">
				<i class="fa fa-list"></i>
				<span class="headline">Categories</span>
				<span class="value">{{$cats}}</span>
			</div>
		</div>
	</a>
@stop