@extends('admin.master')

@section('title')
	Payment List
@stop
@section('content')
	@if(Session::has('ok'))		
		<div class="row">
			<div class="col-sm-12">
				<p class="alert alert-success">{{Session::get('ok')}}</p>
			</div>
		</div>
	@endif
	<div class="col-lg-12 changeStatusArea"></div>
	<div class="col-lg-12">
	<div class="row">
		<div class="col-md-12">
			<p>
				<form class="form-inline" id="filterForm">
				  <div class="form-group">
				  	<label>Language: </label>
				    <select name="lang" class="form-control">
				    	<option value="all" @if(Request::input('lang')=='all') selected @endif>All</option>
				    	@foreach($langs as $lang)
							<option value="{{$lang->code}}" @if(Request::input('lang')==$lang->code) selected @endif>{{$lang->name}}</option>	
				    	@endforeach
				    </select>
				  </div>
				  <div class="form-group">
				  	<label>Status: </label>
				    <select name="status" id="filterStatus"  class="form-control">
				    	<option value="all" @if(Request::input('status')=='') selected @endif>All</option>
				    	<option value="3" @if(Request::input('status')=='3') selected @endif>Approved</option>
				    	<option value="5" @if(Request::input('status')=='5') selected @endif>Completed</option>
				    </select>
				  </div>
				  <div class="form-group">
				  	<label>Period: </label>
				    <input type="text" name="period" class="form-control" data-provide="datepicker" value="{{Request::input('period')}}">
				  </div>
				  <div class="form-group">
				  	<label>To: </label>
				    <input type="text" name="period_to" class="form-control" data-provide="datepicker" value="{{Request::input('period_to')}}">
				  </div>
				  <div class="form-group">
				    <input type="submit"  class="btn btn-primary" value="Filter">
				  </div>
				</form>
			</p>
		</div>
	</div>
		<div class="main-box clearfix">
			<br>	
			<div class="main-box-body clearfix">
				<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th width="40px" class="text-center"><input type="checkbox" id="select_all"></th>
								<th><span>Name</span></th>
								<th><span>CPR</span></th>
								<th><span>Reg. Account</span></th>
								<th><span>Amount</span></th>
							</tr>
						</thead>
						<tbody>
					 @if(isset($users))
						@foreach($users as $u)
							<tr class="header">
								<td class="text-center"><input type="checkbox" name="" value="{{$u['id']}}" class="select_all"></td>
								<td><a href="#" class="btn btn-xs btn-warning expandTr fa fa-plus" expand="0"></a> {{$u['name']}}</td>
								<td>{{$u['cpr']}}</td>
								<td>{{$u['account_number']}}</td>
								<td>{{$u['total_amount']}} Kr.</td>
							</tr>
							
							<tr style="display:none">
								<td></td>
								<td colspan="5">
									<table class="table table-bordered">
										<tr style="background:green;color:#fff">
											<th style="width:250px">Status</th>
											<th>Link</th>
											<th>Created</th>
											<th>Approved</th>
											<th>Amount</th>
										</tr>
										@if(isset($u['user_assignment']))
											@foreach($u['user_assignment'] as $ua)
											<tr>
												<td>
													<input type="radio" class="assignStatus" value="3" alt="{{$ua['id']}}" name="statusAssign_{{$ua['id']}}" @if($ua['status']==3) checked @endif> Approved
													<input type="radio" class="assignStatus" value="5" alt="{{$ua['id']}}" name="statusAssign_{{$ua['id']}}" @if($ua['status']==5) checked @endif> Completed
												</td>
												<td>{{$ua['link']}}</td>
												<td>{{date('M-d-Y',strtotime($ua['created_at']))}}</td>
												<td>{{date('M-d-Y',strtotime($ua['approved_at']))}}</td>
												<td>{{ $ua['amount']  }} Kr.</td>
											</tr>
											@endforeach
										@endif
									</table>
								</td>
							</tr>
						@endforeach
					@endif
						</tbody>
					</table>
					<a href="#" class="btn btn-success complete">Complete</a>
					<a href="#" class="btn btn-info export_excel">Export to Excel</a>
				</div>
				<?php 
				$url_path = '';
				foreach ($_GET as $key => $value) {
					$url_path .= $key.'='.$value.'&';
				}
				 $final_url =  rtrim($url_path,'&');
				 ?>
			</div>
		</div>
	</div>
	<script>

	// set URL for export excel
	// $('.export_excel').attr('href','{{url("admin/payment-list")}}?exportExcel%3Dtrue%26{{urlencode($final_url)}}');
	$('.export_excel').attr('href','{{url("admin/payment-list")}}?exportExcel=true&{{$final_url}}');

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
				data:{val:val,_token:token,assignID:assignID,userAssignment:1},
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

		$('.complete').click(function(){
			var token = '{{ csrf_token() }}';
			var val = [];
			$('.select_all:checked').each(function(i){
	          val[i] = $(this).val();
	        });
	        if(val==''){
	        	return false;
	        }
			
			$.ajax({
				type:'post',
				url:'{{url("admin/assignments/change-status")}}',
				data:{data:val,_token:token,complete_all_assignment:1},
				success:function(x){
					$('.changeStatusArea').addClass('alert alert-success');
					$('.changeStatusArea').html('Status updated. Please <a href="#" onclick="window.location.reload()">Reload</a> to see changes');
					$("html, body").animate({ scrollTop: 0 }, 0);
				}
			});
			return false;
		});

		$('#filterForm').submit(function(){
			var period = $('input[name="period"]').val();
			var period_to = $('input[name="period_to"]').val();
			if(period!='' && period_to==''){
				alert('Please choose Period to');
				$('input[name="period_to"]').focus();
				return false;
			}
			else if(period=='' && period_to!=''){
				alert('Please choose Period');
				$('input[name="period"]').focus();
				return false;
			}

		});

		$('.export_excel').click(function(){

		});

	</script>

@stop