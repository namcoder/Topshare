@extends('admin.master')

@section('title')
	Add new User
@stop

@section('content')
	<div class="col-lg-6">
		<div class="main-box">
			<header class="main-box-header clearfix">
				<h2>Create new user</h2>
			</header>
			
			<div class="main-box-body clearfix">
				<form role="form" method="post">
					<div class="form-group">
						<label for="">Name</label>
						<input type="text" class="form-control" id="name" name="name" placeholder="Name" autofocus required>
					</div>
					<div class="form-group">
						<label for="">Password</label>
						<input type="password" class="form-control" id="pass" name="password" placeholder="Password"  required>
					</div>
					<div class="form-group">
						<label for="">Re-type Password</label>
						<input type="password" class="form-control" id="pass2"  placeholder="Password"  required>
					</div>
					<div class="form-group">
						<label for="">Email</label>
						<input type="email" class="form-control" id="email" name="email" placeholder="Email"  required>
					</div>
					<div class="form-group">
						<label>Role</label>
						<select class="form-control" name="role" required>
							@foreach($roles as $role)
							<option value="{{$role->id}}">{{$role->name}}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-success">Save</button>
					</div>
				</form>
				<script>
				$('form').submit(function(){
					var pass = $('#pass').val();
					var pass2 = $('#pass2').val();
					if(pass!=pass2){
						block_error_input($('#pass'),'Password not match, please type again',false);
						$('#pass2').val('');
						return false;
					}
					else{
						block_ok_input($('#pass'));
					}
					var data = $(this).serialize();
					var token = '{{ csrf_token() }}';
					$.ajax({
						type:'post',
						url:'{{url("admin/users/add-new")}}',
						data:{data:data,_token:token},
						success:function(x){
							block_ok_input($('#email'));
							if(x=='exist_email'){
								block_error_input($('#email'),'This Email is already taken',true);
							}
							else{
								form_action_ok($('form'),'Create User successful');
							}
						}
					});
					return false;
				});

				</script>
			</div>
		</div>
	</div>

@stop