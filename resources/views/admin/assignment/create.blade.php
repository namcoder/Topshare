@extends('admin.master')

@section('title')
	Create Assignment
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
				<h2>Create Assignment</h2>
			</header>
			<div class="main-box-body clearfix">
					<div class="form-group">
						<label>Customer</label>
						<select class="form-control" id="customerSelect" name="customer" required>
							<option value="">Select Customer</option>
							@foreach($customerAPI as $cAPI)
								<option value="{{$cAPI->id}}" country_iso="{{$cAPI->country_iso}}">{{$cAPI->navn}}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label>Language</label>
						<select class="form-control" name="lang_code" required id="bloglang_reg">
							<option value="">Select Language</option>
							@foreach($langs as $l)
								<option value="{{$l->code}}" country_iso="{{$l->code}}">{{$l->name}}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label>Categories</label>
						<div class="row changeCat"></div>
						<div class="row hide errorcat">
							<p class="alert alert-danger">Please select category</p>
						</div>
					</div>
					<div class="form-group">
						<label for="">Keyword</label>
						<input type="text" class="form-control"  name="keyword" placeholder="" required>
						<span id="helpBlock" class="help-block">Separated by comma</span>
					</div>
					<div class="form-group">
						<label for="">Minimum wordcount</label>
						<input type="text" class="form-control"  name="minimum_wordcount" placeholder="" required>
					</div>
					<div class="form-group">
						<label for="">Max Blogger</label>
						<input type="text" class="form-control"  name="max_blogger" placeholder="" value="" required>
					</div>
					<div class="form-group">
						<label for="">Release date</label>
						
						<div class="row">
							<div class="col-xs-12 groupFieldDatePicker">
								<div class="input-group" style="margin:10px 0;">
									<input type="text"  class="form-control datepickerDate"  placeholder="mm/dd/yyyy"  name="release_date[]">
									<span class="input-group-addon">
										<a href="#" class="minusDatepicker"><i class="fa fa-minus" style="color:red"></i></a>
									</span>
								</div>
							</div>
							<div class="appendReleaseDate"></div>
							<div class="col-xs-12">
								<a href="#" class="btn btn-success addReleaseDate"><i class="fa fa-plus"></i></a>
							</div>
						</div>						
					</div>
			</div>
		</div>
	</div>
	<div class="col-lg-6">
		<div class="main-box">
			<div class="main-box-body clearfix">
				<div class="form-group">
					<br>
					<label for="">Link</label>
					<div class="row appendLink"></div>
				</div>
				<div class="form-group">
					<a href="#" class="btn btn-success addLink"><i class="fa fa-plus"></i></a>
				</div>
				<div class="form-group">
					<input type="hidden" name="customerName" id="customerName">
					<input type="hidden" id="indexImgClick">
					<input type="hidden" name="_token" value="{{csrf_token()}}">
					<button type="submit" class="btn btn-primary">Save</button>
					<a href="{{url('admin/assignments')}}" class="btn btn-default">Cancel</a>
				</div>
			</div>
		</div>
	</div>
</form>
<script src="{{asset('public/backend/js/admin/assignments.js')}}"></script>
@stop