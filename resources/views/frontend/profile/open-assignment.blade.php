@extends('frontend.master')

@section('content')
<link rel="stylesheet" href="{{asset('public/frontend/css/three-quarters.css')}}" type="text/css">
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.min.js"></script>
	<div class="row">
		<div class="col-sm-12">
			
					<h3>List Assignments</h3>
					<table class="table table-bordered">
						<tr>
							<th>Name</th>
							<th>Minimum wordcount</th>
							<th>Keyword</th>
							<th>Your value</th>
						</tr>
					@foreach($lists as $key => $l)
						<tr>
							<td>
								<a href="{{url('profile/apply-assignment')}}/{{$l->id}}" class="btn btn-primary btn-sm" @if(in_array($l->id,$userAssignment)) disabled @endif>APPLY</a>
								{{$l->customer_name}}
								 @if(in_array($l->id,$userAssignment)) <span class="label label-success">Applied</span> @endif
							</td>
							<td>
								{{$l->minimum_wordcount}}
							</td>
							<td>
								{{$l->keyword}}
							</td>
							<td>
								<strong>{{(Auth::user()->userblog->star+$extra_star)*$star_value}}</strong> Kr.
							</td>
						</tr>
						
					@endforeach
					</table>
					<!-- <p class="alert alert-warning">Not have any Assignment with your Blog language and your Blog categories</p> -->
		</div>		
	</div>
@stop