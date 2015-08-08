@extends('frontend.master')

@section('content')
	<div class="row">
		<div class="col-sm-12">
			{{trans('profile.Welcome')}} <strong>{{Auth::user()->name}}</strong> | {{Auth::user()->userblog->blogname}} | <div class="result-evaluation" style="display: inline-block;"><i>Loading...</i></div>
		</div>
	</div>
	<div class="row marginTop">
		<div class="col-sm-3">
			<div class="btn-group-vertical" role="group" aria-label="Vertical button group">
			      <a href="{{url('/')}}" class="btn btn-default">{{trans('profile.Home')}}</a>
			      <a href="{{url('profile/my-assignments')}}" class="btn btn-default">{{trans('profile.My_Assignments')}}</a>
			    
			      <a href="{{url('profile/open-assignments')}}" class="btn btn-default">{{trans('profile.Open_Assignments')}}</a>
			      <a href="{{url('profile/my-profile')}}" class="btn btn-default">{{trans('profile.My_Profile')}}</a>
			      <a href="{{url('profile/account-number')}}" class="btn btn-default">Account number</a>
			      <a href="{{url('profile/logout')}}" class="btn btn-default">{{trans('profile.Logout')}}</a>
			  
			    </div>
		</div>
		<div class="col-sm-9">
			<p class="text-center">
				<h3>{{trans('profile.Home')}}</h3>
				<span class="row">
					<div class="col-sm-6">
						<h4>{{trans('profile.Assignments')}}</h4>
						<table class="table">
							<tr>
								<td>{{trans('profile.Applied')}}</td>
								<td>@if(isset($status['applied'])) <strong>{{count($status['applied'])}} </strong> @else 0 @endif</td>
							</tr>
							<tr>
								<td>{{trans('profile.Pending')}}</td>
								<td>@if(isset($status['pending'])) <strong>{{count($status['pending'])}} </strong> @else 0 @endif</td>
							</tr>
							<tr>
								<td>{{trans('profile.Written')}}</td>
								<td>@if(isset($status['written'])) <strong>{{count($status['written'])}} </strong> @else 0 @endif</td>
							</tr>
							<tr>
								<td>{{trans('profile.Approved')}}</td>
								<td>@if(isset($status['approved'])) <strong>{{count($status['approved'])}} </strong> @else 0 @endif</td>
							</tr>
							<tr>
								<td>{{trans('profile.Rejected')}}</td>
								<td>@if(isset($status['rejected'])) <strong>{{count($status['rejected'])}} </strong> @else 0 @endif</td>
							</tr>
							<tr>
								<td>{{trans('profile.Complete')}}</td>
								<td>@if(isset($status['complete'])) <strong>{{count($status['complete'])}} </strong> @else 0 @endif</td>
							</tr>
						</table>
					</div>
					<div class="col-sm-6">
						<h4>{{trans('profile.Payouts')}}</h4>
						<table class="table">
							<tr>
								<td>{{trans('profile.Previous_month')}}</td>
								<td>#</td>
							</tr>
							<tr>
								<td>{{trans('profile.This_month')}}</td>
								<td>#</td>
							</tr>
							<tr>
								<td>{{trans('profile.Upcoming_month')}}</td>
								<td>#</td>
							</tr>
							<tr>
								<td>{{trans('profile.All_time')}}</td>
								<td>#</td>
							</tr>
						</table>
					</div>
				</span>
			</p>
		</div>
	</div>
	<script>
		var full = false;
		var url_evaluation = '{{url("ajax-blog-evaluation")}}';
	</script>
	<script src="{{asset('public/frontend/js/blogevaluation.js')}}"></script>
@stop