@extends('admin.master')

@section('title')
	User Assignment
@stop

@section('content')
	<div class="col-lg-12">
	@if(Session::has('ok'))
		<p class="alert alert-success">{{Session::get('ok')}}</p>
	@endif
		<div class="main-box clearfix">
			<header class="main-box-header clearfix">
				<h2 class="pull-left">User Assignment</h2>
			</header>
			<div class="main-box-body clearfix">
				<div class="table-responsive">
					<table class="table">
						<tr>
							<th width="200px">User's Name</th>
							<td>{{$info->user->name}}</td>
						</tr>
						<tr>
							<th>Email</th>
							<td>{{$info->user->email}}</td>
						</tr>
						<tr>
							<th>Assignment Name</th>
							<td>{{$info->assignment->name}}</td>
						</tr>
						<tr>
							<th>Link</th>
							<td><a href="{{$info->link}}" target="_blank">{{$info->link}}</a></td>
						</tr>	
						@if($info->message_update)
						<tr>
							<th>User's message</th>
							<td>{{$info->message_update}}</td>
						</tr>
						@endif
						<tr>
							<th>Status</th>
							<td>
								@include('frontend.profile.assignment-status',['no'=>$info->status])
							</td>
						</tr>
						<tr>
							<th>Reason reject</th>
							<td>
								{{$info->reason}}
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<a href="{{url('admin/user-assignments/approve')}}/{{$info->id}}" class="btn btn-success">Approve</a>
								<a href="{{url('admin/user-assignments/reject')}}/{{$info->id}}" class="btn btn-danger">Reject</a>
								<a href="{{url('admin/user-assignments/complete')}}/{{$info->id}}" class="btn btn-info">Complete</a>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
		
@stop