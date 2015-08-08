$(document).ready(function(){
	$.ajax({
		type:'get',
		data:{full:full},
		url:url_evaluation,
		success:function(x){
			$('.result-evaluation').html(x);
		}
	});

});