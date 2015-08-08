@extends('frontend.master')

@section('content')
<?php $link = json_decode($info->img_link) ?>
<link rel="stylesheet" href="{{asset('public/frontend/css/three-quarters.css')}}" type="text/css">
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.min.js"></script>
	<div class="row">
		<div class="col-sm-12">
				@if(Session::has('full'))
					<p class="alert alert-danger">
						{{Session::get('full')}}
					</p>
				@endif
			<table class="table table-bordered">
				<tr>
					<th>Keyword</th>
					<td>{{$info->keyword}}</td>
				</tr>
				<tr>
					<th>Minimum wordcount</th>
					<td>{{$info->minimum_wordcount}}</td>
				</tr>
				<tr>
					<th>Link</th>
					<td>
					@if($link)
						<table class="table table-bordered">
						@foreach($link as $l)
							<tr>
								<td width="150px">
									@if($l->img!=null)
									<img src="{{$l->img}}" alt="" class="img-responsive">
									@else
										<i>No Image</i>
									@endif
								</td>
								<td style="vertical-align: middle;">
									<p><a href="{{$l->link}}" target="_blank" >{{$l->link}}</a></p>
									@if($l->anchor_text)
									<p>Anchor text: {{$l->anchor_text}}</p>
									@endif
								</td>
							</tr>	
						@endforeach
						</table>
					@endif
					</td>
				</tr>
				<tr>
					<td colspan="2">
						@if(!$applied)
						<a href="{{url('profile/apply-assignment')}}/{{$info->id}}" class="btn btn-primary">Apply</a>
						 <a href="{{url('profile/open-assignments')}}" class="btn btn-default">Cancel</a>
						 @else
						 You have applied this assignment. <a href="{{url('profile/my-assignments')}}/{{$applied->id}}">Click here</a> to view your assignment
						 @endif
					</td>
				</tr>
			</table>
		</div>		
	</div>
@stop