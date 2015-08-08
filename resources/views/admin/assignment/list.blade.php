@extends('admin.master')

@section('title')
	Assignments
@stop
@section('content')
	@if(Session::has('ok'))		
		<div class="row">
			<div class="col-sm-12">
				<p class="alert alert-success">{{Session::get('ok')}}</p>
			</div>
		</div>
	@endif
	<div class="col-lg-12 errorDelete">
		
	</div>
	<div class="col-lg-12">
	<p><a href="{{url('admin/assignments/create')}}" class="btn btn-primary">Create Assignment</a></p>
	<div class="row">
		<div class="col-md-12">
			<p>
				<form class="form-inline">
				  <div class="form-group">
				    <label for="exampleInputName2">Status</label>
				    <select name="" id="filterStatus" class="form-control">
				    	<option value="open" @if(Request::input('status')=='open') selected @endif>Open</option>
				    	<option value="closed" @if(Request::input('status')=='closed') selected  @endif>Closed</option>
				    	<option value="all" @if(Request::input('status')=='all') selected @endif>All</option>
				    </select>
				  </div>
				</form>
			</p>
		</div>
	</div>
		<div class="main-box clearfix">
			<header class="main-box-header clearfix">
				<h2 class="pull-left">List Assignments</h2>
			</header>
			<div class="main-box-body clearfix">
				<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th width="40px" class="text-center"><input type="checkbox" id="select_all"></th>
								<th><span>Customer</span></th>
								<th><span>Status</span></th>
								<th><span>Created at</span></th>
								<th><span>Release date</span></th>
							</tr>
						</thead>
						<tbody>
						@foreach($lists as $l)
						
							<tr class="header">
								<td class="text-center"><input type="checkbox" name="" value="{{$l->id}}" class="select_all"></td>
								<td>  <strong><h2  style="margin:0 10px;display:inline"><span class="label  label-success">{{count($l->userassignment)}} / {{$l->max_blogger}}</span></h2></strong> <a href="#" class="btn btn-xs btn-warning expandTr fa fa-plus" expand="0"></a> <a href="{{url('admin/assignments')}}/{{$l->id}}">{{$l->customer_name}}</a></td>
								<td>
									<input type="radio" class="assignStatus" value="1" alt="{{$l->id}}" name="statusAssign_{{$l->id}}" @if($l->status==1) checked @endif> Open
									<input type="radio" class="assignStatus" value="0" alt="{{$l->id}}" name="statusAssign_{{$l->id}}" @if($l->status==0) checked @endif> Closed
								</td>
								<td>
									{{date('M-d-Y',strtotime($l->created_at))}}
								</td>
								<td>
									{{date('M-d-Y',strtotime($l->release_date))}}
								</td>
							</tr>
							<tr style="display:none">
							 	<td></td>
								<td colspan="5">
									<table class="table table-bordered">
										<tr style="background:green;color:#fff">
											<th>Name</th>
											<th>Blog name</th>
											<th>Email</th>
											<th>Link</th>
											<th>Status</th>
											<th>Created at</th>
										</tr>
										@foreach($l->userassignment as $userAssign)
										<tr>
											<td>{{$l->getUserInfo($userAssign->user_id)->name}}</td>
											<td>{{$l->getUserBlog($userAssign->user_id)->blogname}}</td>
											<td><a href="mailto:{{$l->getUserInfo($userAssign->user_id)->email}}">{{$l->getUserInfo($userAssign->user_id)->email}}</a></td>
											<td><a href="{{$userAssign->link}}" target="_blank">{{$userAssign->link}}</a></td>
											<td>
												<input type="radio" class="userAssignStatus" alt="{{$userAssign->id}}" value="1" name="userAssignStatus_{{$userAssign->assignment_id}}_{{$userAssign->user_id}}" @if($userAssign->status==1) checked @endif> Pending
												<input type="radio" class="userAssignStatus" alt="{{$userAssign->id}}" value="2" name="userAssignStatus_{{$userAssign->assignment_id}}_{{$userAssign->user_id}}" @if($userAssign->status==2) checked @endif> Written
												<input type="radio" class="userAssignStatus" alt="{{$userAssign->id}}" value="3" name="userAssignStatus_{{$userAssign->assignment_id}}_{{$userAssign->user_id}}" @if($userAssign->status==3) checked @endif> Approved
												<input type="radio" class="userAssignStatus" alt="{{$userAssign->id}}" value="4" name="userAssignStatus_{{$userAssign->assignment_id}}_{{$userAssign->user_id}}" @if($userAssign->status==4) checked @endif> Rejected
												<input type="radio" class="userAssignStatus" alt="{{$userAssign->id}}" value="5" name="userAssignStatus_{{$userAssign->assignment_id}}_{{$userAssign->user_id}}" @if($userAssign->status==5) checked @endif> Complete
											</td>	
											<td>
												{{date('M-d-Y',strtotime($userAssign->created_at))}}
											</td>	
										</tr>
										@endforeach
									</table>
								</td>
								
								
							</tr>
						
						@endforeach
						</tbody>
					</table>
					<a href="#" class="btn btn-danger delete">Delete</a>
				</div>
				<?php //echo $users->render(); ?>
			</div>
		</div>
	</div>
	<script>
	/// filter status
	$('#filterStatus').change(function(){
		var num = $(this).val();
		window.location.href = "{{url('admin/assignments')}}?status="+num;
	});

		///collapse row
		$('.expandTr').click(function(){
			 var expand = $(this).attr('expand');
			 if(expand==1){
			 	 $(this).attr('expand',0);
			     $(this).removeClass('fa-minus').addClass('fa-plus').parent().parent().nextUntil('.header').slideToggle(0);
			 }
			 else{
			 	 $(this).attr('expand',1);
			     $(this).removeClass('fa-plus').addClass('fa-minus').parent().parent().nextUntil('.header').slideToggle(0);
			 }
		});


		/// change status of assignment

		$('.assignStatus').change(function(){
			var val = $(this).val();
			var assignID = $(this).attr('alt');
			$.ajax({
				url:'{{url("admin/assignments/change-status")}}',
				type:'post',
				data:{val:val,_token:token,assignID:assignID},
			});
		});


		/// change status of User's Assigment

		$('.userAssignStatus').change(function(){
			var cu = $(this);
			var val = $(this).val();
			var assignID = $(this).attr('alt');
			$.ajax({
				url:'{{url("admin/assignments/change-status-user-assignment")}}',
				type:'post',
				data:{val:val,_token:token,assignID:assignID},
			});
			
		});




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
					dataType:'json',
					url:'{{url("admin/assignments")}}',
					data:{data:val,_token:token},
					success:function(x){
						if(x.error=='user_applied'){
							$('.errorDelete').addClass('alert alert-danger');
							$('.errorDelete').html('Cannot delete because Users had applied:<br>'+x.name);
							$("html, body").animate({ scrollTop: 0 }, 0);
							return false;
						}
						else{
							$('.errorDelete').removeClass('alert alert-danger');
							$('.errorDelete').html('');
							$('.select_all:checked').parent().parent().remove();
							$('#select_all').prop('checked',false);
						}
					}
				});
				return false;
			}
		});
	</script>

@stop