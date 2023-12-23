
<!-- nav_sideleft -->
<div class="col-lg-2 col-md-2 col-sm-2 sidenav" style="background-color:HoneyDew;">
	<div class="affix" style="background-color:Pink; min-width: 15%; "><!-- -->
		<div class="panel panel-default" style="background-color:AliceBlue;text-align: center; " >
			<img src="<?php echo $_SESSION['supervisor_avatar'] ? base_url(SUPERVISOR_AVATAR_FOLDER.$_SESSION['supervisor_avatar']) : base_url(SUPERVISOR_AVATAR_FOLDER.'user.png'); ?>" style="width:200px;height:250px;margin-left:20px;padding-top:20px">
			
			<div class="row" style="text-align: center; align-content: center;color:Blue;">
				
					<h3 ><?php echo ucwords($_SESSION['role']); ?></h3>
				
			</div>
			<div class="row" style="text-align: center;color:Blue;">
				<div>
					<h4><?php echo ucwords($_SESSION['supervisor_department']); ?></h4>
				</div>
			</div>

			<div class="row" style="">
				<div class="col-sm-5" style="text-align: right;">
					<p>username :</p>
				</div>
				<div class="col-sm-7" style="text-align: left;">
					<p><?php echo $_SESSION['username'] ? $_SESSION['username'] : ""; ?></p>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-5" style="text-align: right;">
					<p>ID :</p>
				</div>
				<div class="col-sm-7" style="text-align: left;">
					<p><?php echo $_SESSION['id'] ? $_SESSION['id'] : ""; ?></p>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-5" style="text-align: right;">
					<p>เพศ</p>
				</div>
				<div class="col-sm-7" style="text-align: left;">
					<p><?php echo $_SESSION['supervisor_gender'] ? $_SESSION['supervisor_gender'] : ""; ?></p>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-5" style="text-align: right;">
					<p>ชื่อ</p>
				</div>
				<div class="col-sm-7" style="text-align: left;">
					<p><?php echo $_SESSION['supervisor_firstname'] ? $_SESSION['supervisor_firstname'] : ""; ?><p>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-5" style="text-align: right;">
					<p>นามสกุล</p>
				</div>
				<div class="col-sm-7" style="text-align: left;">
					<p><?php echo $_SESSION['supervisor_lastname'] ? $_SESSION['supervisor_lastname'] : ""; ?></p>
				</div>			
			</div>
			<div class="row btn btn-warning">
				<div id="online_students" class="" style="text-align: center;">
				online:
				</div>			
			</div>
			<div></div>

			<?php 
				$today = date('Y-m-d');	
				echo '<a href="'.site_url('supervisor/student_activity_show/').$today.'" >Student log</a>';
				
				if ($_SESSION['username']=='kanut') {
					echo '<div class="row">';
					echo '<a href="'.site_url('supervisor/process_show').'" >Process</a>';
					echo '<br/><br/>';
					
					echo '<br/><br/>';
					echo '<a href="'.site_url('supervisor/demo_sse').'" >Demo SSE</a>';
					echo '<br/><br/>';
					echo '<a href="'.site_url('supervisor/proc_open_test').'" >Proc_open_test</a>';
					echo '<br/><br/>';
					echo '</div>';
				}
			?>

			

		</div><!--  -->
	</div>

	
</div>
<!-- nav_sideleft -->
		
		

