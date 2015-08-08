@extends('frontend.master')

@section('content')
<link rel="stylesheet" href="{{asset('public/frontend/css/three-quarters.css')}}" type="text/css">
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.min.js"></script>
	<div class="row">
		<div class="col-sm-12">
		@if(!Session::has('ok'))
			<form method="post">
			  <div class="form-group">
			    <label for="">Link Assignment</label>
			    <input type="text" class="form-control" name="link" id="" placeholder="Enter link">
			  </div>
			  <div class="form-group">
			    <label for="">Message</label>
			    <input type="text" class="form-control" name="message" id="">
			  </div>
			  <input type="hidden" name="_token" value="{{csrf_token()}}">
			  <button type="submit" class="btn btn-default">Submit</button>
			</form>
		@else
			<p class="alert alert-success">Your link has been sent. We will review your link and email you soon. <a href="{{url('profile/my-assignments')}}/{{$info->id}}">Click here</a> to go to your assignment</p>
		@endif
		</div>		
	</div>
@stop