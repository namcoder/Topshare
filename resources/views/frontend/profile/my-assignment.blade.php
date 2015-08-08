@extends('frontend.master')

@section('content')
<link rel="stylesheet" href="{{asset('public/frontend/css/three-quarters.css')}}" type="text/css">
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.min.js"></script>
	<div class="row">
		<div class="col-sm-12">
			
				@if($list)
					<h3>My Assignments</h3>
					<table class="table table-bordered">
						<tr>
							<th>Assignment</th>
							<th>Time to report</th>
							<th>Applied at</th>
							<th>Status</th>
						</tr>
					@foreach($list as  $l)
						<tr>
							<td>
								<a href="{{url('profile/my-assignments')}}/{{$l->id}}">{{$l->assignment->customer_name}}</a>
							</td>
							<td>
								@if($l->status<3)
									<strong>{{$time_to_report}}</strong> minutes
									<br>
									You have <strong>{{round(((($l->minute_to_report_assignment*60) + strtotime($l->created_at))-time())/60,1)}} </strong>minutes left
								@else
									Completed
								@endif
							</td>
							<td>
								{{$l->created_at}}
							</td>
							<td>
								@include('frontend.profile.assignment-status',['no'=>$l->status])
							</td>
						</tr>
					@endforeach
					</table>
				@else
					<p class="alert alert-warning">Not have any Assignment with your Blog language and your Blog categories</p>
				@endif
			
		</div>		
	</div>
@stop