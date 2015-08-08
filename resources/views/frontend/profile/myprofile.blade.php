@extends('frontend.master')

@section('content')
<link rel="stylesheet" href="{{asset('public/frontend/css/three-quarters.css')}}" type="text/css">
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.min.js"></script>
	<div class="row">
		<form id="userinfo">
			<div class="col-sm-6">
				<p class="alert alert-success saveok hide">{{trans('profile.Updated')}}</p>
			  <div class="form-group">
			    <label class="control-label" for="">{{trans('profile.Email')}}</label>
			    <input type="email" class="form-control" id="email" name="email"  disabled value="{{Auth::user()->email}}">
			  </div>
			  <div class="form-group">
			    <label class="control-label" for="">{{trans('profile.New_password')}}</label>
			    <!-- <span id="helpBlock" class="help-block">Keep blank to if you dont want to change</span> -->
			    <input type="password" class="form-control" id="" name="password" >
			  </div>
			  <div class="form-group">
			    <label class="control-label" for="">{{trans('profile.Name')}}</label>
			    <input type="text" class="form-control" id="" name="name" required value="{{Auth::user()->name}}">
			  </div>
			  <div class="form-group">
			    <label class="control-label" for="">{{trans('profile.Address')}}</label>
			    <input type="text" class="form-control" id="" name="address" required value="{{Auth::user()->address}}">
			  </div>
			  <div class="row">
			  	<div class="col-sm-6">
			  		<div class="form-group">
			  		  <label class="control-label" for="">{{trans('profile.Zipcode')}}</label>
			  		  <input type="text" class="form-control" id="" name="zipcode" required value="{{Auth::user()->zipcode}}">
			  		</div>
			  	</div>
			  	<div class="col-sm-6">
			  		<div class="form-group">
			  		  <label class="control-label" for="">{{trans('profile.City')}}</label>
			  		  <input type="text" class="form-control" id="" name="city" required value="{{Auth::user()->city}}">
			  		</div>
			  	</div>
			  </div>
			  <div class="form-group">
			    <label class="control-label" for="">{{trans('profile.Phone_number')}}</label>
			    <input type="text" class="form-control" id="" name="phone" required value="{{Auth::user()->phone}}">
			  </div>
			  <div class="form-group">
			    <label class="control-label" for="">{{trans('profile.CPR')}}</label>
			    <input type="text" class="form-control" id="" name="cpr" required value="{{Auth::user()->cpr}}">
			  </div>
			  <button type="submit" class="btn btn-primary col-sm-12">{{trans('profile.update_information')}}</button>
			</div>
		</form>
		<div class="col-sm-6">
		<form id="evaluate">
			<div class="form-group">
		    	<label class="control-label" for="">{{trans('profile.Blog_name')}}</label>
		    	<input type="text" class="form-control" id="blogname" name="blogname" required value="{{Auth::user()->userblog->blogname}}">
		 	</div>
		 	<div class="form-group">
		    	<label class="control-label" for="">{{trans('profile.Blog_URL')}}</label>
		    	<input type="text" class="form-control" name="blogurl" id="blogurl" disabled value="{{Auth::user()->userblog->domain}}">
		 	</div>
	 	 	<div class="form-group">
	 	    	<label class="control-label" for="">{{trans('home.Blog_Language')}}</label>
	 	    	<select name="lang_code" id="bloglang_reg" class="form-control" required disabled>
	 		    	<option value="">{{trans('home.Select_language')}}</option>
	 		    	@foreach($langs as $l)
	 		    		<option value="{{$l->code}}" @if(Auth::user()->userblog->lang_code==$l->code) selected @endif>{{$l->name}}</option>
	 		    	@endforeach
	 	    	</select>
	 	 	</div>
		 	<div class="form-group">
		 	  <div class="col-sm-12">
		 	   	<div class="checkbox">
		 	   	  <div class="row changeCat">
		 	   	  	<?php
		 	   	  		$userCat = explode(',', Auth::user()->userblog->blog_categories);
		 	   	  	 ?>
		 	   	  	@foreach($cats as $cat)
		 	   	  		<div class="col-sm-5">
		 	   	  			<label class="control-label">
		 	   	  			  <input type="checkbox" class="category" name="category[]" value="{{$cat->id}}" @if(in_array($cat->id,$userCat)) checked @endif> {{$cat->name}}
		 	   	  			</label>
		 	   	  		</div>
		 	   	  	@endforeach
		 	   	  </div>
		 	   	  <div class="row">
		 	   	  	<div class="col-sm-12">
			 	   	  	<div class="alert alert-danger error_cate hide">{{trans('profile.Please_select_Blog_category')}}</div>
		 	   	  	</div>
		 	   	  </div>
		 	   	</div>
		 	  </div>
		 	</div>
			<button type="submit" class="btn btn-success col-sm-12" @if(Auth::user()->userblog->status==0) disabled @endif>{{trans('profile.update_blog_information')}}</button>
		</form> 
		<div class="clearfix"></div>
		<div class="row">
			<div class="result-evaluation" style="margin:15px 0;padding:0 15px;">
				<i>Loading...</i>
			</div>
		</div>

		 <div class="row">
		 	<div class="col-sm-2">
		 		<div class="row">
		 			<div class="col-sm-4 text-center marginTop">
		 				<div class="three-quarters-loader loading hide"></div>
		 			</div>
		 		</div>
		 	</div>
		 </div>	
		</div>
	</div>

	<script>
		var full = true;
		var url_evaluation = '{{url("ajax-blog-evaluation")}}';
	</script>
	<script src="{{asset('public/frontend/js/blogevaluation.js')}}"></script>

	<script>
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
	$("#userinfo").validate({
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
				///////////// SUBMIT when all done and OK
				var all_data = $("#userinfo").serialize();

				$.ajax({
					type:'post',
					url:'{{url("profile/my-profile")}}',
					data:{data:all_data,_token:token},
					success:function(x){
						// $('#userinfo').hide();
						$('.saveok').removeClass('hide');
					}
				});
			}
		});

	/////// UPDATE BLOG

	$("#evaluate").validate({
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
		 	$('.loading').removeClass('hide');
		 	var domain = $('#blogurl').val();
		 	var blogname = $('#blogname').val();
		 	var bloglang = $('#bloglang_reg').val();
		 	$('.result-evaluation').html('');
			$.ajax({
				type:'post',
				url:'{{url("profile/update-blog-domain")}}',
				data:{lang_code:bloglang,blogname:blogname,domain:domain,category:val,_token:token},
				success:function(x){
					$('.loading').addClass('hide');
					if(x=='error_cantget'){
						$('.result-evaluation').html('<div class="text-danger col-sm-12">{{trans("profile.Cannot_get_information_from_this_domain")}}</div>');
					}
					else{
						$('.result-evaluation').html(x);
					}
				}
			});		 	
		 }
		
	});


	</script>


@stop