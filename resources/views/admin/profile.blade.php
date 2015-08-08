@extends('admin.master')

@section('title')
	Edit Profile
@stop

@section('content')
	<div class="col-lg-6">
		<div class="main-box">
			<header class="main-box-header clearfix">
				<h2>Edit Profile</h2>
			</header>
			
			<div class="main-box-body clearfix">
				<form role="form" method="post">
					<div class="form-group">
						<label for="">Name</label>
						<input type="text" class="form-control" id="name" name="name" placeholder="Name"  required value="{{Auth::user()->name}}">
					</div>
					<div class="form-group">
						<label for="">New Password</label>
						<input type="password" class="form-control" id="pass" name="password" placeholder="Password" >
					</div>
					<div class="form-group">
						<label for="">Email</label>
						<input type="email" disabled class="form-control" id="email" name="email" placeholder="Email"   value="{{Auth::user()->email}}" disabled="">
					</div>
					
					<div class="form-group">
						<button type="submit" class="btn btn-success">Save</button>
					</div>
				</form>
				<script>
				$('form').submit(function(){
					var data = $(this).serialize();
					var token = '{{ csrf_token() }}';
					$.ajax({
						type:'post',
						url:'{{url("admin/profile")}}',
						data:{data:data,_token:token},
						success:function(x){
							form_action_ok($('form'),'Saved');
						}
					});
					return false;
				});

				</script>
			</div>
		</div>
	</div>

@stop