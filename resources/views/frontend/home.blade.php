@extends('frontend.master')

@section('content')

	<div class="row twoButLg">
		<div class="col-sm-6">
			<a href="{{url('profile')}}" class="col-sm-12 btn btn-primary">blogger</a>
		</div>
		<div class="col-sm-6">
			<a href="#" class="col-sm-12 btn btn-success">{{trans('home.company')}}</a>
		</div>
	</div>
	<div class="row twoButLg">
		<div class="col-sm-6">
			<p>{{trans('home.description_bellow_blogger')}}</p>
		</div>
		<div class="col-sm-6">
			<p>{{trans('home.description_bellow_company')}}</p>
		</div>
	</div>
@stop