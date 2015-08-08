@extends('admin.master')

@section('title')
	Translate
@stop

@section('content')

	<div class="col-lg-12">
	@if(Session::has('ok'))
		<p class="alert alert-success">{{Session::get('ok')}}</p>
	@endif
		<div class="main-box">
			<!-- <p class="text-center"><span class="text-danger"><strong>IMPORTANT:</strong> DO NOT using <span class="text-danger"> &nbsp;&nbsp;&nbsp;'&nbsp;&nbsp;&nbsp; </span> key for translate</span></p> -->
			<header class="main-box-header clearfix">
				<h2>Translate</h2>
			</header>
			
			<div class="main-box-body clearfix">
			<form action="" method="post">
				<table class="table table-bordered">
					<tr>
						<td></td>
						<th width="460px">English</th>
						<th>{{$lang_name->name}}</th>
					</tr>
					@foreach($rows as $key => $r)
					<tr>
						<td><input type="hidden" name="key[]" value="{{$r[0]}}"></td>
						<td>{{$r[1]}}</td>
						@if(isset($rows_lang[$key][1]))
						<td><input type="text" class="form-control" name="tranfield[]" value="{{trim($rows_lang[$key][1])}}"></td>
						@else
						<td><input type="text" class="form-control" name="tranfield[]"></td>
						@endif
					</tr>
					@endforeach
					<tr>
						<td colspan="3">
							<div class="pull-right">
								<input type="hidden" name="_token" value="{{csrf_token()}}">
								<input type="submit" class="btn btn-primary" value="Save">
								 <a href="{{url('admin/languages/translate')}}/{{Request::segment(4)}}" class="btn btn-default">Cancel</a>
							</div>
						</td>
					</tr>
				</table>
			</form>			
			</div>
		</div>
	</div>
@stop