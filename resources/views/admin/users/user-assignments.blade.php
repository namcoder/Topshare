@extends('admin.master')

@section('title')
	User Assignments
@stop

@section('content')
	<div class="col-lg-12">
	@if(Session::has('ok'))
		<p class="alert alert-success">{{Session::get('ok')}}</p>
	@endif
		<div class="main-box clearfix">
			<header class="main-box-header clearfix">
				<h2 class="pull-left">User Assignments</h2>
			</header>
			<div class="main-box-body clearfix">
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th><input type="checkbox" id="select_all"></th>
								<th><span>User's Name</span></th>
								<th><span>Email</span></th>
								<th><span>Assignment Name</span></th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>
						@foreach($list as $l)
							<tr>
								<td><input type="checkbox" name="idUserAssign[]" value="{{$l->id}}" class="select_all"></td>
								<td>
									<a href="{{url('admin/user-assignments')}}/{{$l->id}}">{{$l->user->name}}</a>
								</td>
								<td>
									<a href="{{url('admin/user-assignments')}}/{{$l->id}}">{{$l->user->email}}</a>
								</td>
								<td>
									{{$l->assignment->name}}
								</td>	
								<td>
									@include('frontend.profile.assignment-status',['no'=>$l->status])
								</td>
								
							</tr>
						@endforeach
						</tbody>
					</table>
						<div class="col-sm-2">
							<select name="action" id="action" class="form-control">
								<option value="">---</option>
								<option value="1">Assign</option>
								<option value="2">Delete</option>
							</select>
						</div>
					    <a href="#" class="btn btn-primary apply">Apply</a>
				</div>
				<?php echo $list->render(); ?>
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
		$('.apply').click(function(){
			var token = '{{ csrf_token() }}';
			var val = [];
			var action = $('#action').val();
			if(action==''){
				return false;
			}
			$('.select_all:checked').each(function(i){
	          val[i] = $(this).val();
	        });
	        if(val==''){
	        	alert('Please select item to apply');
	        	return false;
	        }
			
			$.ajax({
				type:'post',
				url:'{{url("admin/user-assignments")}}',
				data:{data:val,action:action,_token:token},
				success:function(x){
					window.location.reload();
				}
			});
			return false;
		});
	</script>

@stop