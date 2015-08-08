<div class="col-sm-12">
	<h4 class="text-success">Done</h4>
	<script>
		/// append value to curren User information form
		$(document).ready(function(){
			$('#evaluate').val('1');
			$('#domain_age').val('{{$data["domain_age"]}}');
			$('#domain_type').val('{{$data["domain_type"]}}');
			$('#blog_categories').val('{{$data["category"]}}');
			$('#blogname_save').val('{{$data["blogname"]}}');
			$('#domain_save').val('{{$data["domain"]}}');
			$('#star').val('{{$data["star"]}}');
			$('#lang_code').val('{{$data["lang_code"]}}');
			$('#report_id').val('{{$data["report_id"]}}');
		});
	</script>
</div>