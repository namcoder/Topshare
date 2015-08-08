<div class="col-sm-12" style="margin-bottom:10px">
	@for($i=0;$i<$data['star'];$i++)
		@if($i<5)
			<img src="{{asset('public/frontend/img/star.png')}}" alt="">
		@endif
		
	@endfor
	<?php 
			if($data['star'] > 5){
				$num_real_star = 5;
			}
			else{
				$num_real_star = $data['star'];
			}
			if($num_real_star<0){
				$num_real_star = 0;
			}
			$num_grey_star = 5-$num_real_star;
	?>
	@for($i=0;$i<$num_grey_star;$i++)
		<img src="{{asset('public/frontend/img/star_grey.png')}}" alt="">
	@endfor
</div>
<div class="col-sm-12">
	<ul>
		@if($data['domain_age']==0)
			<li>Domain age: <strong>0</strong></li>
		@else
			@if($data['domain_age']>1)
				<li>Domain age: <strong>{{$data['domain_age']}} </strong> years</li>
			@else
				<li>Domain age: <strong>{{$data['domain_age']}} </strong> year</li>
			@endif
		@endif
		
		
		<li>You have selected: <strong>{{$data['num_category']}}</strong> category</li>
		@if($data['domain_type']==0)
			<li>You have used <strong>personal</strong> domain</li>
		@else
			<li>You have used <strong>blogspot</strong> domain</li>
		@endif
		<li>Number of visitors per month: <strong>{{$data['num_of_visitor']}}</strong></li>
		<li>Number of inbound links: <strong>{{$data['num_of_backlink']}}</strong></li>
		<li>Page rank: <strong>{{$data['num_of_page_rank']}}</strong></li>
		<li>Number of domain in your domain IP: <strong>{{$data['num_of_domain_on_IP']}}</strong></li>
		@if($data['outboundBiger']==1)
			<li>Your domain have outbound link <strong>more</strong> than inbound link in</li>
		@endif
	</ul>
	
</div>