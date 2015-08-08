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

@if(Auth::user()->userblog->status!=0)
<?php 
	$half_star = (Auth::user()->userblog->star/2)*16;
 ?>
		<span class="stars">
		    <span style="width:{{$half_star}}px"></span>
		</span>

		@if($full!='false')
			<div class="clearfix"></div>
			<div class="text-left" style="margin-top:20px">
				<?php 
					$domainAge = explode(',', Auth::user()->userblog->domain_age);
				 ?>
				<ul>
					<li>Domain age: <strong>{{$domainAge[0]}}</strong> year <strong>{{$domainAge[1]}}</strong> months</li>
					<li>Inbound link: <strong>{{Auth::user()->userblog->inbound_link}}</strong></li>
					<li>Stars achieved: <strong>{{Auth::user()->userblog->star/2}}</strong></li>
				</ul>
			</div>
			
		@endif
	
@else
		<i class="text-muted">Blog under evaluation, this can take a while, please have patience</i>
@endif
<script>
	$.fn.stars = function() {
	    return $(this).each(function() {
	        $(this).html($('<span />').width(Math.max(0, (Math.min(5, parseFloat($(this).html())))) * 16));
	    });
	}
</script>