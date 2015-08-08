@extends('admin.master')

@section('title')
	List Users
@stop

@section('content')
	<div class="col-lg-12">
	<!-- <p><a href="{{url('admin/users/add-new')}}" class="btn btn-primary">Add User</a></p> -->
		<div class="main-box clearfix">
			<header class="main-box-header clearfix">
				<h2 class="pull-left">Users</h2>
			</header>
			<div class="main-box-body clearfix">
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th><input type="checkbox" id="select_all"></th>
								<th><span>Name</span></th>
								<th><span>Email</span></th>
								<th><span>Role</span></th>
							</tr>
						</thead>
						<tbody>
						@foreach($users as $user)
							<tr>
								@if($user->id==1)
									<td><input type="checkbox" disabled=""></td>
								@else
									<td><input type="checkbox" name="idUser[]" value="{{$user->id}}" class="select_all"></td>
								@endif
								
								<td>
									<a href="{{url('admin/users/edit')}}/{{$user->id}}">{{$user->name}}</a>
								</td>
								<td>
									<a href="{{url('admin/users/edit')}}/{{$user->id}}">{{$user->email}}</a>
								</td>
								<td>
									@if($user->userrole->id==1)
									   <span class="label label-danger">{{$user->userrole->name}}</span>
									@elseif($user->userrole->id==2)
									   <span class="label label-warning">{{$user->userrole->name}}</span>
									@else
										<span class="label label-success">{{$user->userrole->name}}</span>
									@endif
								</td>
							</tr>
						@endforeach
						</tbody>
					</table>
					<a href="#" class="btn btn-danger delete">Delete</a>
				</div>
				<?php echo $users->render(); ?>
			</div>
		</div>
	</div>
	<script>
		$('#select_all').change(function() {
		    var checkboxes = $('.select_all');
		    if($(this).is(':checked')) {
		        checkboxes.prop('checked', true);
		    } else {
		        checkboxes.prop('checked', false);
		    }
		});
		$('.delete').click(function(){
			var token = '{{ csrf_token() }}';
			var val = [];
			$('.select_all:checked').each(function(i){
	          val[i] = $(this).val();
	        });
	        if(val==''){
	        	return false;
	        }
			var c = confirm('Are you sure to Delete ?');
			if(c==false){
				return false;
			}
			else{
				$.ajax({
					type:'post',
					url:'{{url("admin/users/list")}}',
					data:{data:val,_token:token},
					success:function(x){
						$('.select_all:checked').parent().parent().remove();
						$('#select_all').prop('checked',false);
					}
				});
				return false;
			}
		});
	</script>

@stop