@extends('frontend.master')

@section('content')
<?php $link = json_decode($info->assignment->img_link) ?>
	<div class="row">
		<div class="col-sm-12">
			<table class="table table-bordered">
				<tr>
					<th width="200px">Assignment</th>
					<td>{{$info->assignment->customer_name}}</td>
				</tr>
				<tr>
					<th>Keyword</th>
					<td>{{$info->assignment->keyword}}</td>
				</tr>
				<tr>
					<th>Minimum wordcount</th>
					<td>{{$info->assignment->minimum_wordcount}}</td>
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
										<a href="{{$l->img}}" target="_blank" download><img src="{{$l->img}}" alt="" class="img-responsive"></a>
										@else
											<i>No Image</i>
										@endif
									</td>
									<td style="vertical-align: middle;">
										<p>Link: <a href="{{$l->link}}" target="_blank" >{{rtrim($l->link, "/")}}</a></p>
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
				@if($info->status<3)
				<tr>
					<th>Time to report</th>
					<td>
						<strong>{{$time_to_report}}</strong> minutes <br>
						You have <strong>{{round(((($info->minute_to_report_assignment*60) + strtotime($info->created_at))-time())/60,1)}} </strong>minutes left
					</td>
				</tr>
				@endif
				@if($info->status==0)
					<tr>
						<th>
							Status
						</th>
						<td>
							@include('frontend.profile.assignment-status',['no'=>$info->status])
						</td>
					</tr>
				@elseif($info->status==1)
					<tr>
						<th>
							Status
						</th>
						<td>
							@include('frontend.profile.assignment-status',['no'=>$info->status])
						</td>
					</tr>
				@elseif($info->status==2)
					<tr>
						<th>
							Status
						</th>
						<td>
							@include('frontend.profile.assignment-status',['no'=>$info->status])
						</td>
					</tr>
					@elseif($info->status==3)
					<tr>
						<th>
							Status
						</th>
						<td>
							@include('frontend.profile.assignment-status',['no'=>$info->status])
						</td>
					</tr>
					
					@elseif($info->status==4)
					<tr>
						<th>
							Status
						</th>
						<td>
							@include('frontend.profile.assignment-status',['no'=>$info->status])
						</td>
					</tr>
					<tr>	
						<td colspan="2">
							<strong>Reason:</strong>  {{$info->reason}}
						</td>
					</tr>
					<tr>	
						<td colspan="2">
							<a href="{{url('profile/re-completed-assignment')}}/{{$info->id}}" class="btn btn-primary">Re-Complete</a>
						</td>
					</tr>
					@elseif($info->status==5)
					<tr>
						<th>
							Status
						</th>
						<td>
							@include('frontend.profile.assignment-status',['no'=>$info->status])
						</td>
					</tr>
				@endif
					<tr>
						<th>URL to report</th>
						<td>
							<form method="post"  action="{{url('profile/completed-assignment')}}/{{$info->id}}">
							  <div class="form-group">
							    <input type="text" class="form-control" name="link" id="link" placeholder="Enter link" required value="{{$info->link}}" @if($info->status==3 || $info->status==5) disabled @endif>
							  </div>
							  <input type="hidden" name="_token" value="{{csrf_token()}}">
							  <input type="hidden" id="user_assignment_id" value="{{$info->id}}">
							  @if($info->status<3) <button type="submit" class="btn btn-primary" id="submitbut" >Submit</button>  @endif
							  <p>
							  	<div class="three-quarters-loader loading hide"></div>
							  </p>
							  <p class="result-validate"></p>
							</form>
						</td>
					</tr>
			</table>
		</div>		
	</div>
	<script>
		$("form").validate({
			rules:{
				link:{
					url:true
				}
			},
			errorClass:'text-danger',
			errorPlacement: function(error, element) {
				element.parent().addClass('has-error') ;
				error.insertAfter(element);
			},
			success: function(label) {
			   label.parent().removeClass('has-error') ;
			   label.remove();
			 },
			submitHandler: function(form){
				var data = $('#link').val();
				var user_assignment_id = $('#user_assignment_id').val();
				$('.loading').removeClass('hide');
				$('.result-validate').html('');
				$.ajax({
					type:'post',
					dataType:'json',
					url:'{{url("profile/validate-user-assignment-link")}}',
					data:{data:data,_token:token,user_assignment_id:user_assignment_id},
					success:function(x){
						if(x.statusCode==200){
							$('.loading').addClass('hide');
							$('.result-validate').html('<div class="alert alert-success">Thank you for your report. We will check your link and reply you soon</div>');
							$('#submitbut').attr('disabled',true);
							$('#link').attr('disabled',true);
						}
						else if(x.statusCode==500){
							$('.loading').addClass('hide');
							if(x.content=='not_exist'){
								window.location.href='{{url("profile/my-assignments")}}';
								return false;
							}
							if(x.overtime){
								$('#submitbut').attr('disabled',true);
								$('#link').attr('disabled',true);
							}
							$('.result-validate').html('<div class="alert alert-danger">'+x.content+'</div>');
						}
					},
					error:function(y){
						$('.loading').addClass('hide');
						$('.result-validate').html('<div class="alert alert-danger"><strong>'+data+'</strong> is not valid. Please check again</div>');
					},
				});
			}
		});
	</script>
@stop