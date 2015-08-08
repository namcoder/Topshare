@extends('admin.master')

@section('title')
	Blog Categories
@stop

@section('content')
	<div class="col-lg-12">
	@if(Session::has('ok'))
	<p class="alert alert-success">
		{{Session::get('ok')}}
	</p>
	@endif
	<p><a href="{{url('admin/blog-categories/create')}}" class="btn btn-primary">Create Category</a></p>
		<div class="main-box clearfix">
			<header class="main-box-header clearfix">
				<h2 class="pull-left">Categories</h2>
			</header>
			<div class="main-box-body clearfix">
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th><input type="checkbox" id="select_all"></th>
								<th>Name</th>
								<th>Language Code</th>
							</tr>
						</thead>
						<tbody>
						@foreach($cats as $cat)
							<tr>
								<td width="50px"><input type="checkbox" value="{{$cat->id}}" class="select_all"></td>
								<td width="250px">
									<a href="{{url('admin/blog-categories')}}/{{$cat->id}}">{{$cat->name}}</a>
								</td>
								<td >
									<a href="{{url('admin/blog-categories')}}/{{$cat->id}}">{{$cat->language->code}}</a>
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
			var c = confirm('Are you sure to Delete ?');
			if(c==false){
				return false;
			}
			else{
				$.ajax({
					type:'delete',
					url:'{{url("admin/blog-categories")}}',
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