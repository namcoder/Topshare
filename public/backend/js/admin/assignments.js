/*
	when change customer:
		- change language by customer country iso code by API
		- change categories by language
		- get list of customer's link by customer ID
		- action for append link - remove...upload image...
*/
		
		/*  
			CUSTOMER CHANGE EVENT
		*/

		$('#customerSelect').change(function(){

			$('.listCustomerImage').html('');
			var country_iso = $('option:selected',this).attr('country_iso');
			var cus = $(this).find('option:selected').text();

			$('#customerName').val(cus);
			$('#bloglang_reg').find('option[country_iso="'+country_iso+'"]').prop('selected', true);
			$('#bloglang_reg').change();

			var cus_id = $(this).val();

			if(cus_id==''){
				return false;
			}
			$('.appendLink').html('');
			
			/// ajax to get LINK by customer id
			$.ajax({
				type:'get',
				url:'http://api.riversystem.dk/getLinkByCustomerID?key=OLE8hx3BCwRisEW1QYRhijn84izZyw&customerID='+cus_id,
				success:function(res){
					$('.listURLfromCustomer').html('<option value="">Select links</option>');
					$.each(res,function(key,val){
						$('.listURLfromCustomer').append('<option value="'+val.url+'">'+val.url+'</option>');
					});
				}
			});

			/// ajax to get IMAGE
			$.ajax({
				type:'get',
				url:'http://api.riversystem.dk/getCustomerImageBank?key=OLE8hx3BCwRisEW1QYRhijn84izZyw&customerID='+cus_id,
				success:function(resImg){
					$.each(resImg,function(keyImg,valImg){
						$('.listCustomerImage').append('<li><a href="#"><img src="http://www.riversystem.dk/public/application/riverupload/uploads/'+cus_id+'/'+valImg+'"></a></li>');
					});
				}
			});

			/// AJAX to get Admin Setting
			$.post('/admin/ajax-get-setting-variable-by-customer-language',{_token:token,country_iso:country_iso},function(x){
				$.each(x,function(k,v){
					var varName = v.name;
					var varValue = v.value;

					//set wordcount value
					if(varName=='word_count'){  /// filter 
						if(v.lang_code==country_iso){
							$('input[name="minimum_wordcount"]').val(varValue);
						}
						else if(v.lang_code=='en'){
							$('input[name="minimum_wordcount"]').val(varValue);
						}
					}

					//set maxblogger
					if(varName=='max_blogger'){
						if(v.lang_code==country_iso){
							$('input[name="max_blogger"]').val(varValue);
						}
						else if(v.lang_code=='en'){
							$('input[name="max_blogger"]').val(varValue);
						}
					}
				});
			});
		});
		


		/*
			WHEN CLICK INTO OPEN IMGBANK - GET THIS INDEX
		*/
		$(document).on('click','.appendLink a',function(){
			var indexImgPreview = $(this).parent().parent().parent().index();
			$('#indexImgClick').val(indexImgPreview);
		});



		/*===================================================
			WHEN CLICK CUSTOMER IMAGE - INSERT INTO IMGPREVIEW
		====================================================*/
		$(document).on('click','.listCustomerImage a',function(){
			var img = $(this).find('img').attr('src');
			var indexToInsert = $('#indexImgClick').val();
			$('.appendLink div.row:eq('+indexToInsert+')').find('a.clickImg').removeClass('btn btn-default').next().val(img);
			$('.appendLink div.row:eq('+indexToInsert+')').find('img').removeClass('hide').attr('src',img).next().remove();
			$('.modal-customer-image').modal('hide');
			return false;
		});


		/*===================================================
			CHANGE CAT LANGUAGE BY SELECT
		=====================================================*/
		$('#bloglang_reg').change(function(){
			var lang_code = $(this).val();

			$.ajax({
				type:'get',
				url:'http://'+document.domain+'/ajax-get-categories',
				data:{lang_code:lang_code},
				success:function(x){
					$('.changeCat').html(x);
				}
			});
		});
		
		var listFile = [];
		$(document).on('change','.imglink',function(event){
			var nextImg = $(this).next().find('img');
			var thisVal = $(this).val();
			var file = this.files[0];
			var reader = new FileReader();
			reader.onload = function (e) {
			           var img64 = e.target.result;        	
			           nextImg.removeClass('hide');
			           nextImg.parent().removeClass('btn btn-default');
			           nextImg.next().remove();
			           nextImg.attr('src',img64);
			        }        
			        reader.readAsDataURL(file);
			listFile.push(event.target.files);
		});
		
		/*===================================================
			click add more link
		===================================================*/
		$('.addLink').click(function(){
			var cus_have_selected = $('#customerSelect').val();
			var contentAppend = $('.contentAppend').html();
			$('.appendLink').append(contentAppend);
			return false;
		});


		/*===================================================
			click remove a link
		===================================================*/
		$(document).on('click','.minusLink',function(){
			$(this).parent().parent().remove();
			return false;
		});


		/*===================================================
			submit form
		===================================================*/
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
			 	var arr = [];
			 	var select_cat = $('.category:checked').length;
			 	if(select_cat==0){
 			 		$('.errorcat').removeClass('hide');
 			 		return false;
 			 	}
 			 	else{
 			 		$('.errorcat').addClass('hide');
 			 	}


 			 	$('.datepickerDate').each(function(){
 			 		if($(this).val()==""){
 			 			$(this).parent().addClass('has-error');
 			 			$(this).focus();
 			 			arr.push(1);
 			 			return false;
 			 		}
 			 		else{
 			 			arr = [];
 			 			$(this).parent().removeClass('has-error');
 			 		}
 			 	});

 			 	console.log(arr);

 			 	if(arr!=""){
 			 		return false;
 			 	}
 			 	else{
 			 		form.submit();
 			 	}
 			 	
 			 	

			 	
			 }
		});
/// Append release date
	function datepicker_init(){
		$('.datepickerDate').datepicker({
			startDate: '-0d',
		}).on('changeDate',function(){
			$(this).datepicker('hide');
		});
	}
	$(document).on('ready',function(e){
		datepicker_init();
	});
		
	$('.addReleaseDate').on('click',function(e){
		var inputDatepicker = $('.datepickerDate:eq(0)').parent().parent().clone();
			inputDatepicker.children().children().val('');
		$('.appendReleaseDate').append(inputDatepicker);
			datepicker_init();
		return false;
	});

	$(document).on('click','.groupFieldDatePicker:gt(0) .minusDatepicker',function(){
		$(this).parent().parent().parent().remove();
		return false;
	});
	$('.groupFieldDatePicker:eq(0) .minusDatepicker').click(function(){
		return false;
	});

/////////////////		