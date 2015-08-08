@extends('admin.master')

@section('title')
	Translate
@stop

@section('content')

	<div class="col-lg-6">
		<div class="main-box">
			<header class="main-box-header clearfix">
				<h2>Select a file to translate</h2>
			</header>
			
			<div class="main-box-body clearfix">
				<ul>
					@foreach($lists as $list)
					<li><a href="{{url('admin/languages/translate')}}/{{$code}}/{{$list}}">{{$list}}</a></li>
					@endforeach
				</ul>				
			</div>
		</div>
	</div>
@stop