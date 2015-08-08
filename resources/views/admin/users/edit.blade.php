@extends('admin.master')

@section('title')
	Edit User: {{$info->name}}
@stop

@section('content')
<style>
	span.stars, span.stars span {
	    background: url({{asset('public/frontend/img/stars.png')}}) 0 -15px repeat-x;
	    width: 160px;
	    height: 15px;
	    display:inline-block
	}

	span.stars span {
	    background-position: 0 0;
	}
</style>
<form role="form" method="post">
	<div class="col-lg-6">
		<div class="main-box">
			<header class="main-box-header clearfix">
				<h2>Edit user</h2>
			</header>
			
			<div class="main-box-body clearfix">
				
					<div class="form-group">
						<label for="">Email</label>
						<input type="email" disabled class="form-control" id="email" name="email" placeholder="Email"   value="{{$info->email}}">
					</div>
					<div class="form-group">
						<label for="">Name</label>
						<input type="text" class="form-control" id="name" name="name" placeholder="Name"  required value="{{$info->name}}">
					</div>
					
					<div class="form-group">
						<label for="">Password</label>
						<input type="password" class="form-control" id="pass" name="password" placeholder="Password"   >
					</div>
					<div class="form-group">
						<label for="">Re-type Password</label>
						<input type="password" class="form-control" id="pass2"  placeholder="Password"  >
					</div>
					
					<div class="form-group">
						<label for="">Address</label>
						<input type="text" class="form-control" id="address" name="address" placeholder="Address"  required value="{{$info->address}}">
					</div>
					<div class="form-group">
						<label for="">Zipcode</label>
						<input type="text" class="form-control" id="zipcode" name="zipcode" placeholder="Zipcode"  required value="{{$info->zipcode}}">
					</div>
					<div class="form-group">
						<label for="">City</label>
						<input type="text" class="form-control" id="city" name="city" placeholder="City"  required value="{{$info->city}}">
					</div>
					<div class="form-group">
						<label for="">Phone number</label>
						<input type="text" class="form-control" id="phone" name="phone" placeholder="Phone"  required value="{{$info->phone}}">
					</div>
					<div class="form-group">
						<label for="">CPR</label>
						<input type="text" class="form-control" id="cpr" name="cpr" placeholder="cpr"  required value="{{$info->cpr}}">
					</div>
					<div class="form-group">
						<label>Role</label>
						<select class="form-control" name="role" required>
							@foreach($roles as $role)
							<option value="{{$role->id}}" @if($role->id==$info->role) selected @endif>{{$role->name}}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label>Account number</label>
						<input type="text" class="form-control" id="account_number" name="account_number" placeholder="account number"   value="{{$info->account_number}}">
					</div>
			
			</div>
		</div>
	</div>
	<div class="col-lg-6">
		<div class="main-box">
			<header class="main-box-header clearfix">
				<h2>Blog</h2>
			</header>
			<div class="main-box-body clearfix">
				<div class="form-group">
					<label for="">Blog name</label>
					<input type="text" class="form-control" id="blogname" name="blogname" placeholder="blogname"  required value="{{$info->userblog->blogname}}">
				</div>
				<div class="form-group">
					<label for="">Blog URL</label>
					<input type="text" class="form-control" id="blogurl" name="blogurl" placeholder="blogurl"  required value="{{$info->userblog->domain}}">
				</div>
			 	<div class="form-group">
			    	<label class="control-label" for="">Blog Language</label>
			    	<select name="lang_code" id="bloglang_reg" class="form-control" required>
				    	<option value="">Select language</option>
				    	@foreach($langs as $l)
				    		<option value="{{$l->code}}" @if($info->userblog->lang_code==$l->code) selected @endif>{{$l->name}}</option>
				    	@endforeach
			    	</select>
			 	</div>
		 	 	<div class="form-group">
		 	 	  <div class="col-sm-12">
		 	 	   	<div class="checkbox">
		 	 	   	  <div class="row changeCat">
	 		 	   	  	@foreach($cats as $cat)
	 		 	   	  	<?php
	 		 	   	  		$userCat = explode(',', $info->userblog->blog_categories);
	 		 	   	  	  ?>
	 		 	   	  		<div class="col-sm-5">
	 		 	   	  			<label class="control-label">
	 		 	   	  			  <input type="checkbox" class="category" name="category[]" value="{{$cat->id}}" @if(in_array($cat->id,$userCat)) checked @endif > {{$cat->name}}
	 		 	   	  			</label>
	 		 	   	  		</div>
	 		 	   	  	@endforeach
		 	 	   	  </div>
		 	 	   	  <div class="row">
		 	 	   	  	<div class="alert alert-danger error_cate hide">{{trans('profile.Please_select_Blog_category')}}</div>
		 	 	   	  </div>
		 	 	   	</div>
		 	 	  </div>
		 	 	</div>
		 	 	<div class="form-group">
		 	 		@if($info->userblog->status!=0)
		 	 			<?php 
		 	 				$half_star = ($info->userblog->star/2)*16;
		 	 			 ?>	
		 	 			 <span class="stars">
		 	 			     <span style="width:{{$half_star}}px"></span>
		 	 			 </span>
		 	 					<div class="clearfix"></div>
		 	 					<div class="text-left" style="margin-top:20px">
		 	 						<?php 
		 	 							$domainAge = explode(',', $info->userblog->domain_age);
		 	 						 ?>
		 	 						<ul>
		 	 							<li>Domain age: <strong>{{$domainAge[0]}}</strong> year <strong>{{$domainAge[1]}}</strong> months</li>
		 	 							<li>Inbound link: <strong>{{$info->userblog->inbound_link}}</strong></li>
										<li>Stars achieved: <strong>{{$info->userblog->star/2}}</strong></li>
		 	 							
		 	 						</ul>
		 	 					</div>
		 	 					
		 	 			
		 	 		@else
		 	 				<i class="text-muted">Collecting information</i>
		 	 		@endif
		 	 	</div>
		 	 	
			 	<div class="form-group">
			 		<button type="submit" class="btn btn-success">Save</button>
					<a href="{{url('admin/users/list')}}" class="btn btn-default">Cancel</a>
			 	</div>
			</div>
		</div>
	</div>
</form>
<script>
/// display stars
	$.fn.stars = function() {
	    return $(this).each(function() {
	        $(this).html($('<span />').width(Math.max(0, (Math.min(5, parseFloat($(this).html())))) * 16));
	    });
	}

	/// change Cat language by select 
	$('#bloglang_reg').change(function(){
		var id = $(this).val();
		$.ajax({
			type:'get',
			url:'{{url("ajax-get-categories")}}',
			data:{lang_code:id},
			success:function(x){
				$('.changeCat').html(x);
			}
		});
	});
	$("form").validate({
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
	 		var select_cat = $('.category:checked').length;
	 	 	if(select_cat==0){
	 	 		$('.error_cate').removeClass('hide');
	 			return false;
	 	 	}
	 	 	else{
	 	 		$('.error_cate').addClass('hide');
	 	 	}
		 	var val = [];
		 	$('.category:checked').each(function(i){
		 		val[i] = $(this).val();
		 	});
			var data = $("form").serialize();
			var token = '{{ csrf_token() }}';
			$.ajax({
				type:'post',
				url:'{{url("admin/users/edit")}}/{{$info->id}}',
				data:{data:data,_token:token},
				success:function(x){
					form_action_ok($('form'),'Edit User successful');
				}
			});
			return false;
		 }
	});
</script>
@stop