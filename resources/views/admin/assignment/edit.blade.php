@extends('admin.master')

@section('title')
	Edit Assignment
@stop

@section('content')
<style>
	.imgpreview{
		width:80px;
		margin-top: 15px;
		margin-bottom: 10px;
		  margin-right: 20px;
		/*height: 80px*/
		-webkit-box-shadow: -1px 1px 14px -1px rgba(0,0,0,0.5);
		-moz-box-shadow: -1px 1px 14px -1px rgba(0,0,0,0.5);
		box-shadow: -1px 1px 14px -1px rgba(0,0,0,0.5);
	}
	.listCustomerImage img{
		height: 80px;
		margin: 5px 0;
		border:1px solid #ccc;
	}
	.listCustomerImage img:hover{
		opacity: 0.3;
	}
</style>
<div class="modal fade modal-customer-image" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
      	 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      	 <h4 class="modal-title" id="myModalLabel">Select Customer Image</h4>
      </div>
      <div class="modal-body">
          <ul class="list-inline listCustomerImage"></ul>
      </div>
    </div>
  </div>
</div>
<div class="contentAppend hide">
	<div class="row" style="margin-bottom:10px">
		<div class="col-sm-offset-1 col-sm-11 form-inline">
			<div class="form-group">
				<a href="#" data-toggle="modal" data-target=".modal-customer-image" class="btn btn-default clickImg"><img src="" alt="" class="hide imgpreview"><i class="fa fa-picture-o"></i></a> 
				<input type="hidden" name="img[]">
			</div>
			<br>
			<select name="link[]" class="form-control listURLfromCustomer" style="width:60%;margin:10px 0"></select>
			<input type="text" style="width:60%" placeholder="Anchor Text" class="form-control"  name="anchor_text[]">
			<a href="#" class="btn btn-danger minusLink"><i class="fa fa-minus"></i></a> 
		</div>
	</div>
</div>
<form role="form" method="post" enctype="multipart/form-data">
	<div class="col-lg-6">
		<div class="main-box">
			<header class="main-box-header clearfix">
				<h2>Edit Assignment</h2>
			</header>
			<div class="main-box-body clearfix">
					<div class="form-group">
						<label>Customer</label>
						<select class="form-control" name="customer" required id="customerSelect">
							<option value="">Select Customer</option>
							@foreach($customerAPI as $cAPI)
								<option value="{{$cAPI->id}}" country_iso="{{$cAPI->country_iso}}" @if($cAPI->id==$in->customer_id) selected @endif>{{$cAPI->navn}}</option>
							@endforeach
							
						</select>
					</div>
					<div class="form-group">
						<label>Language</label>
						<select class="form-control" name="lang_code" required id="bloglang_reg">
							<option value="">Select Language</option>
							@foreach($langs as $l)
								<option value="{{$l->code}}" country_iso="{{$l->code}}" @if($l->code == $in->lang_code) selected @endif>{{$l->name}}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label>Categories</label>
						<div class="row changeCat">
						<?php 
							$assignCat = explode(',', $in->blog_categories);
						 ?>
							@foreach($cats as $cat)
								<div class="col-sm-5">
									<label class="control-label">
									  <input type="checkbox" class="category" name="category[]" value="{{$cat->id}}" @if(in_array($cat->id,$assignCat)) checked @endif> {{$cat->name}}
									</label>
								</div>
							@endforeach
						</div>
						<div class="row hide errorcat">
							<p class="alert alert-danger">Please select category</p>
						</div>
					</div>
					<div class="form-group">
						<label for="">Keyword</label>
						<input type="text" class="form-control"  name="keyword" placeholder="" required value="{{$in->keyword}}">
						<span id="helpBlock" class="help-block">Separated by comma</span>
					</div>
					<div class="form-group">
						<label for="">Minimum wordcount</label>
						<input type="text" class="form-control"  name="minimum_wordcount" placeholder="" required value="{{$in->minimum_wordcount}}">
					</div>
					<div class="form-group">
						<label for="">Max Blogger</label>
						<input type="text" class="form-control"  name="max_blogger" placeholder="" value="{{$in->max_blogger}}" required>
					</div>
					<div class="form-group">
						<label for="">Release date</label>
						
						<div class="row">
							<div class="col-xs-12 groupFieldDatePicker">
								<div class="input-group" style="margin:10px 0;">
									<input type="text"  class="form-control datepickerDate"  placeholder="mm/dd/yyyy"  name="release_date" value="{{$in->release_date}}">
									<span class="input-group-addon">
										<a href="#" class="minusDatepicker"><i class="fa fa-minus" style="color:red"></i></a>
									</span>
								</div>
							</div>
							<div class="appendReleaseDate"></div>
							<!-- <div class="col-xs-12">
								<a href="#" class="btn btn-success addReleaseDate"><i class="fa fa-plus"></i></a>
							</div> -->
						</div>						
					</div>
			</div>
		</div>
	</div>
	<div class="col-lg-6">
		<div class="main-box">
			<div class="main-box-body clearfix">
				<div class="form-group">
					<label for="">Link</label>
					<div class="row appendLink">
					<?php 
						$imgLink = json_decode($in->img_link);
					 ?>
					 @if($imgLink)
						 @foreach($imgLink as $key => $il)
							<div class="row" style="margin-bottom:10px" index="{{$key}}">
								<div class="col-sm-offset-1 col-sm-11 form-inline">
									<div class="form-group">
									    <!-- if img is not avaliable - print the default empty img -->
											@if($il->img!=null)
												<a href="#" data-toggle="modal" data-target=".modal-customer-image" class="clickImg"><img src="{{$il->img}}" alt="" class="imgpreview"></a> 
												<input type="hidden" name="img[]" value="{{$il->img}}">
											@else
											<a href="#" data-toggle="modal" data-target=".modal-customer-image" class="btn btn-default clickImg"><img src="" alt="" class="hide imgpreview"><i class="fa fa-picture-o"></i></a>
											<input type="hidden" name="img[]">
											@endif
										</a> 
									</div>
									<br>
									<select name="link[]" class="form-control listURLfromCustomer2" style="width:60%;margin:10px 0">
										<option value="{{$il->link}}">{{$il->link}}</option>
									</select>
									<input type="text" style="width:60%" placeholder="Anchor Text" class="form-control"  name="anchor_text[]" value="{{$il->anchor_text}}">
									<a href="#" class="btn btn-danger minusLink"><i class="fa fa-minus"></i></a> 
								</div>
							</div>
						@endforeach
					@endif
					</div>
					
				</div>
				<div class="form-group">
					<a href="#" class="btn btn-success addLink"><i class="fa fa-plus"></i></a>
				</div>
				<div class="form-group">
					<input type="hidden" id="indexImgClick">
					<input type="hidden" name="customerName" id="customerName" value="{{$in->customer_name}}">
					<input type="hidden" name="_token" value="{{csrf_token()}}">
					<button type="submit" class="btn btn-primary">Save</button>
					<a href="{{url('admin/assignments')}}" class="btn btn-default">Cancel</a>

				</div>
			</div>
		</div>
	</div>
</form>


<script src="{{asset('public/backend/js/admin/assignments.js')}}"></script>
<script>
	///when document ready, autoload link by customer ID. Remove duplicate links
	var cus_id = $('#customerSelect').val();

	///check if current link in new loaded link, not append into html
	$.ajax({
		type:'get',
		url:'http://api.riversystem.dk/getLinkByCustomerID?key=OLE8hx3BCwRisEW1QYRhijn84izZyw&customerID='+cus_id,
		success:function(res){
			$('.listURLfromCustomer').html('<option value="">Select links</option>');
			$.each(res,function(key,val){
				$('.listURLfromCustomer').append('<option value="'+val.url+'">'+val.url+'</option>');
				$('.listURLfromCustomer2').append('<option value="'+val.url+'">'+val.url+'</option>');
			});
		}
	});
	///when document ready, autoload IMAGE by customer ID
	$.ajax({
		type:'get',
		url:'http://api.riversystem.dk/getCustomerImageBank?key=OLE8hx3BCwRisEW1QYRhijn84izZyw&customerID='+cus_id,
		success:function(resImg){
			$.each(resImg,function(keyImg,valImg){
				$('.listCustomerImage').append('<li><a href="#"><img src="http://www.riversystem.dk/public/application/riverupload/uploads/'+cus_id+'/'+valImg+'"></a></li>');
			});
		}
	});
</script>
@stop