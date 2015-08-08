@extends('frontend.master')

@section('content')
	<h3 class="text-center marginBot">{{trans('home.Sign_up_a_new_blogger')}}</h3>
	<div class="row" style="margin-bottom:40px" id="whenDone">
			<div class="col-sm-6" >
				<form id="userinfo">
				  <div class="form-group">
				    <label class="control-label" for="">{{trans('home.email')}}</label>
				    <input type="email" class="form-control" id="email" name="email"  required autofocus>
				  </div>
				  <div class="form-group">
				    <label class="control-label" for="">{{trans('home.password')}}</label>
				    <input type="password" class="form-control" id="" name="password" required>
				  </div>
				  <div class="form-group">
				    <label class="control-label" for="">{{trans('home.name')}}</label>
				    <input type="text" class="form-control" id="" name="name" required>
				  </div>
				  <div class="form-group">
				    <label class="control-label" for="">{{trans('home.address')}}</label>
				    <input type="text" class="form-control" id="" name="address" required>
				  </div>
				  <div class="row">
				  	<div class="col-sm-6">
				  		<div class="form-group">
				  		  <label class="control-label" for="">{{trans('home.zipcode')}}</label>
				  		  <input type="text" class="form-control" id="" name="zipcode" required>
				  		</div>
				  	</div>
				  	<div class="col-sm-6">
				  		<div class="form-group">
				  		  <label class="control-label" for="">{{trans('home.city')}}</label>
				  		  <input type="text" class="form-control" id="" name="city" required>
				  		</div>
				  	</div>
				  </div>
				  <div class="form-group">
				    <label class="control-label" for="">{{trans('home.Phone_number')}}</label>
				    <input type="text" class="form-control" id="" name="phone" required>
				  </div>
				  <div class="form-group">
				    <label class="control-label" for="">{{trans('home.CPR')}}</label>
				    <input type="text" class="form-control" id="" name="cpr" required>
				  </div>
				  <input type="hidden" name="evaluate" id="evaluate" value="0">
				  <input type="hidden" name="domain_age" id="domain_age">
				  <input type="hidden" name="domain_type" id="domain_type">
				  <input type="hidden" name="blog_categories" id="blog_categories">
				  <input type="hidden" name="blogname" id="blogname_save">
				  <input type="hidden" name="domain" id="domain_save">
				  <input type="hidden" name="star" id="star">
				  <input type="hidden" name="lang_code" id="lang_code">
				  <input type="hidden" name="report_id" id="report_id">
			 	 <button type="submit" class="btn btn-primary col-sm-12">{{trans('home.create')}}</button>
				  </form>
				  
			</div>
			<div class="col-sm-6">
				<form action="" id="evaluateBlog">
					<div class="form-group">
				    	<label class="control-label" for="">{{trans('home.Blog_name')}}</label>
				    	<input type="text" class="form-control" id="blogname" name="blogname" required>
				 	</div>
				 	<div class="form-group">
				    	<label class="control-label" for="">{{trans('home.Blog_URL')}}</label>
				    	<input type="text" class="form-control" name="blogurl" id="blogurl" required>
				 	</div>
				 	<div class="form-group">
				    	<label class="control-label" for="">{{trans('home.Blog_Language')}}</label>
				    	<select name="lang_code" id="bloglang_reg" class="form-control" required>
					    	<option value="">{{trans('home.Select_language')}}</option>
					    	@foreach($langs as $l)
					    		<option value="{{$l->code}}">{{$l->name}}</option>
					    	@endforeach
				    	</select>
				 	</div>
				 	<div class="form-group">
				 	  <div class="col-sm-12">
				 	   	<div class="checkbox">
				 	   	  <div class="row changeCat"></div>
				 	   	  <div class="row">
				 	   	  	<div class="col-sm-12">
					 	   	  	<div class="alert alert-danger error_cate hide">{{trans('home.Please_select_Blog_category')}}</div>
					 	   	  	<div class="alert alert-danger error_evaluate hide">{{trans('home.Please_Evaluate_Blog')}}</div>
					 	   	  	<div class="alert alert-danger error_select_cat hide">{{trans('home.Please_select_Blog_category')}}</div>
				 	   	  	</div>
				 	   	  </div>
				 	   	</div>
				 	  </div>
				 	</div>
			 	 	<button type="submit" class="btn btn-success col-sm-12">{{trans('home.evaluate_blog')}}</button>
			 	</form>
			</div>
			<div class="col-sm-2">
				<div class="row">
					<div class="col-sm-4 text-center marginTop">
						<div class="three-quarters-loader loading hide"></div>
					</div>
				</div>
			</div>
			<div class="col-sm-6 result"></div>
	</div>
	<script>
	/// change Cat language by select 
	$('#bloglang_reg').change(function(){
		var lang_code = $(this).val();
		$.ajax({
			type:'get',
			url:'{{url("ajax-get-categories")}}',
			data:{lang_code:lang_code},
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

			//// check user have evaluate blog

			var do_evaluate = $('#evaluate').val();
			if(do_evaluate==0){ /// if no
				$('.error_evaluate').removeClass('hide');
				return false;
			}
			else{ // if ok
				$('.error_evaluate').addClass('hide');
				///////////// SUBMIT when all done and OK
				var all_data = $("#userinfo").serialize();
				$('#email').parent().removeClass('has-error');
				$('#email').next().remove();
				$.ajax({
					type:'post',
					url:'{{url("sign-up")}}',
					data:{data:all_data,_token:token},
					success:function(x){
						if(x=='email_exist'){
							$('#email').parent().addClass('has-error');
							$('#email').after('<label id="email-error" class="text-danger" for="email">{{trans("home.This_email_already_exist")}}</label>');
							$('#email').focus();
							return false;
						}
						else{
							$('#whenDone').html('<p class="alert alert-success">{{trans("home.Sign_up_successful")}}. <a href="{{url("login")}}">{{trans("home.Click_here_to_login")}}</a></p>');
						}
					}
				});
			}
		}
	});

	/////////////// EVALUATE BLOG

	$("#evaluateBlog").validate({
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
		 	$('.error_evaluate').addClass('hide');
	 		var select_cat = $('.category:checked').length;
	 	 	if(select_cat==0){
	 	 		$('.error_select_cat').removeClass('hide');
	 			return false;
	 	 	}
	 	 	else{
	 	 		$('.error_select_cat').addClass('hide');
	 	 	}
		 	var val = [];
		 	$('.category:checked').each(function(i){
		 		val[i] = $(this).val();
		 	});

		 	$('.loading').removeClass('hide');

		 	var domain = $('#blogurl').val();
		 	var blogname = $('#blogname').val();
		 	var bloglang = $('#bloglang_reg').val();
		 	$('.result').html('');
			$.ajax({
				type:'post',
				url:'{{url("check-domain")}}',
				data:{lang_code:bloglang,blogname:blogname,domain:domain,category:val,_token:token,signup:'yes'},
				success:function(x){
					$('.loading').addClass('hide');
					
					if(x=='error_cantget'){
						$('.result').html('<div class="text-danger col-sm-12">{{trans("home.Cannot_get_information_from_this_domain")}}</div>');
					}
					else if(x=='domain_exist'){
						$('.result').html('<div class="text-danger col-sm-12">{{trans("home.This_domain_already_exist")}}</div>');
					}
					else{
						$('.result').html(x);
					}
				}
			});		 	
		 }
		
	});
	</script>
@stop