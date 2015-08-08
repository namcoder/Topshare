@extends('admin.master')

@section('title')
	Languages
@stop

@section('content')

	<div class="col-lg-6">
		<div class="main-box">
			<header class="main-box-header clearfix">
				<h2>Create Language</h2>
			</header>
			
			<div class="main-box-body clearfix">
				<form role="form" method="post">
					<div class="form-group">
						<label for="">Name</label>
						<input type="text" class="form-control" id="name" name="name" placeholder="Name" autofocus >
					</div>
					<div class="form-group">
						<label for="">Language Code</label>
						<input type="text" class="form-control" id="code" name="code" placeholder="en"  >
						<span id="helpBlock" class="help-block">
							Example: en (English) - da (Danish)
							<br>
							<a href="http://www.w3schools.com/tags/ref_language_codes.asp" target="_blank">The code here</a>
						</span>

					</div>
					
					<div class="form-group">
						<button type="submit" class="btn btn-success">Save</button>
					</div>
				</form>
				<div class="error-folder hide">
					<p class="alert alert-danger">This Language code already exist</p>
				</div>
				<script>
				$('form').submit(function(){
					var name = $('#name').val();
					var code = $('#code').val();
					var token = '{{ csrf_token() }}';

					if(name=='' || name==null){
						block_error_input($('#name'),'Please enter the Name',true);
						return false;
					}
					else{
						block_ok_input($('#name'));
					}
					if(code=='' || code==null){
						block_error_input($('#code'),'Please enter the code',true);
						return false;
					}
					else{
						block_ok_input($('#code'));
					}

					$.ajax({
						type:'post',
						url:'{{url("admin/languages")}}',
						data:{name:name,code:code,_token:token},
						success:function(x){
							if(x=='exist_folder'){
								$('.error-folder').removeClass('hide');
								return false;
							}
							window.location.reload();
						}
					});
					return false;
				});

				</script>
			</div>
		</div>
	</div>

	<div class="col-lg-12">
		<div class="main-box clearfix">
			<header class="main-box-header clearfix">
				<h2 class="pull-left">Languages</h2>
			</header>
			<div class="main-box-body clearfix">
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th><input type="checkbox" id="select_all"></th>
								<th><span>Name</span></th>
								<th><span>Code</span></th>
								<th><span>Action</span></th>
							</tr>
						</thead>
						<tbody>
						@foreach($langs as $lang)
							<tr>
								@if($lang->id==1)
								<td><input type="checkbox"   disabled></td>
								@else
								<td><input type="checkbox" value="{{$lang->id}}" class="select_all"></td>
								@endif
								
								<td>
									{{$lang->name}}
								</td>
								<td>
									{{$lang->code}}
								</td>
								<td>
									@if($lang->id!=1)
									<a href="{{url('admin/languages/translate')}}/{{$lang->code}}" class="btn btn-primary">Translate</a>
									@else
									Default
									@endif
								</td>
							</tr>
						@endforeach
						</tbody>
					</table>
					<a href="#" class="btn btn-danger delete">Delete</a>
				</div>
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
			var c = confirm('Are you sure to Delete this language ? This will delete all translated files too');
			if(c==false){
				return false;
			}
			else{
				$.ajax({
					type:'post',
					url:'{{url("admin/languages/delete")}}',
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