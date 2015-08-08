@extends('admin.master')

@section('title')
	Settings
@stop

@section('content')
<script src="{{asset('public/backend/js/bootstrap-editable.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('public/backend/css/libs/bootstrap-editable.css')}}">
	<div class="col-lg-12">
		<div>

		  <!-- Nav tabs -->
		  <ul class="nav nav-tabs" role="tablist">
		    <li role="presentation" class="active"><a href="#global-variable" aria-controls="global-variable" role="tab" data-toggle="tab">Global Variable</a></li>
		    <li role="presentation"><a href="#other" aria-controls="other" role="tab" data-toggle="tab">Other</a></li>
		  </ul>
		  <div class="tab-content">
		    <div role="tabpanel" class="tab-pane active" id="global-variable">
		    	<div class="main-box">
		    		<div class="main-box-body clearfix">
			    		<br>
			    		<h2>Create</h2>
		    			<div class="row">
		    				<div class="col-lg-4">
		    					<form role="form" method="post">
		    						<div class="form-group">
		    							<label for="">Variable name</label>
		    							<select name="name" id="" class="form-control">
		    								<option value="">---</option>
		    								<option value="wordcount">wordcount</option>
		    								<option value="maxblogger">maxblogger</option>
		    								<option value="minute_to_report_assignment">minute_to_report_assignment</option>
		    								<option value="minute_to_repost_time">minute_to_repost_time</option>
		    								<option value="time_to_repost">time_to_repost</option>
		    								<option value="star_value">star_value</option>
		    							</select>
		    						</div>
		    						<div class="form-group">
		    							<label for="">Language</label>
		    							<select name="lang_code" id="" class="form-control">
		    								<option value="">Select Language</option>
		    								@foreach($langs as $lang)
		    								<option value="{{$lang->code}}">{{$lang->name}}</option>
		    								@endforeach
		    							</select>
		    						</div>
		    						<div class="form-group">
		    							<label for="">Value</label>
		    							<input type="text" class="form-control"  name="value" placeholder="Enter value">
		    						</div>
		    						<div class="form-group">
		    							<input type="hidden" name="_token" value="{{csrf_token()}}">
		    							<button type="submit" class="btn btn-primary">Save</button>
		    						</div>
		    					</form>
		    				</div>
		    			</div>
		    			<div class="row">
		    				<div class="col-lg-6">
					    		<table class="table table-bordered">
					    			<tr>
					    				<th width="40px"><input type="checkbox" id="select_all"></th>
					    				<th width="300px">Name</th>
					    				<th width="200px">Value</th>
					    				<th >Language</th>
					    			</tr>
					    			@foreach($settings as $setting)
									<tr>
										<td><input type="checkbox" value="{{$setting->id}}" class="select_all"></td>
										<!-- <td><a href="#" data-type="text" id="name" data-pk="{{$setting->id}}" data-url="{{url('admin/settings/ajax-variable')}}" class="variableName">{{$setting->name}}</a></td> -->
										<td>{{$setting->name}}</td>
										<td><a href="#" data-type="text" id="value" data-pk="{{$setting->id}}" data-url="{{url('admin/settings/ajax-variable')}}" class="variableName">{{$setting->value}}</a></td>
										<td>
											<select class="form-control changeLangVariable">
												@foreach($langs as $lang)
													<option variableID="{{$setting->id}}" value="{{$lang->code}}" @if($lang->code==$setting->lang_code) selected @endif>{{$lang->name}}</option>
												@endforeach
											</select>
										</td>
									</tr>
					    			@endforeach
					    		</table>
								<a href="#" class="btn btn-danger delete">Delete</a>
		    				</div>
		    			</div>
		    		</div>
		    	</div>
		    </div>
		    <div role="tabpanel" class="tab-pane" id="other">
		    	<div class="main-box">
		    		<div class="main-box-body clearfix">
		    		<br>
		    		Under construction
		    		</div>
		    	</div>
		    </div>
		  </div>

		</div>
		
	</div>
	<script>
		$.fn.editable.defaults.mode = 'inline';
		$.fn.editable.defaults.ajaxOptions = {type: "POST"};
		$.fn.editable.defaults.send = "always";
		$.fn.editable.defaults.params = function (params) {
		       params._token = token;
		       return params;
		   };
		$(document).ready(function() {
		    $('.variableName').editable();


		    $('.changeLangVariable').change(function(){
		    	var lang_id = $(this).val();
		    	var variableID = $('option:selected',this).attr('variableID');
		    	$.post('{{url("admin/settings/ajax-variable")}}',{_token:token,pk:variableID,lang_code:lang_id,name:'changeLang'});
		    	$(this).css('background', 'yellowgreen');
		    	$(this).fadeOut(200,function(){
		    		$(this).css('background', 'none').fadeIn();
		    	});
		    	
		    });
		});

		/// select all 
		$('#select_all').change(function() {
		    var checkboxes = $('.select_all');
		    if($(this).is(':checked')) {
		        checkboxes.prop('checked', true);
		    } else {
		        checkboxes.prop('checked', false);
		    }
		});
			$('.delete').click(function(){
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
						url:'{{url("admin/settings/ajax-delete-variable")}}',
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