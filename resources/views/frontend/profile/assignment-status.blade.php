@if($no==0)
	<span class="label label-warning">Applied</span>
@elseif($no==1)
	<span class="label label-success">Pending</span>
@elseif($no==2)
<span class="label label-info ">Written</span>
@elseif($no==3)
<span class="label label-success ">Approved</span>
@elseif($no==4)
<span class="label label-danger ">Rejected</span>
@elseif($no==5)
<span class="label label-success ">Complete</span>
@endif