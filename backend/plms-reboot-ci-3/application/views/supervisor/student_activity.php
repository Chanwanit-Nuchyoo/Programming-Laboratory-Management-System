<!-- nav_body -->
<div class="col-lg-10 col-md-10 col-sm-10" style="">
	

	<div class="row" style="margin-top:20px;">
		<div class="well" style="text-align:center;color:Blue;background-color:Cornsilk;">
			<h1><?php 
				$today = date('Y-m-d');
				echo date('D F j, Y'); 
			?></h1>
			<!-- Left and right controls -->
			<a class="left carousel-control" href="<?php echo site_url('supervisor/student_activity_previous/'.$log_date) ?>" data-slide="prev">
				<span class="glyphicon glyphicon-chevron-left"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="right carousel-control" href="<?php echo site_url('supervisor/student_activity_next/'.$log_date) ?>" data-slide="next">
				<span class="glyphicon glyphicon-chevron-right"></span>
				<span class="sr-only">Next</span>
			</a>
		</div>
		<div class="well" style="text-align:left;color:Blue;background-color:Cornsilk;">
			<div><?php echo $message; ?></div>
		</div>
	</div>
			
</div>
<!-- nav_body -->