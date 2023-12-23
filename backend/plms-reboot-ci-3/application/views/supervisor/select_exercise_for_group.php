<!-- nav_body -->
<div class="col-lg-10 col-md-10 col-sm-10" style="margin-top:10px;">
	<?php
		$group_no = $class_schedule['group_no'];
		$lecturer_id = $class_schedule['supervisor_id'];
		$user_id = $_SESSION['id'];
		$class_id =  $class_schedule['group_id'];
		// $lab_no , $group_id passed from controller
	?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-4"> <!-- Left panel -->
				<div class="panel panel-default">
					<div class="panel-heading">
						<h1>กลุ่มที่ : <?php echo $class_schedule['group_no']; ?><h1>
						<h3>ภาควิชา : <?php echo $class_schedule['dept_name']; ?><h3>
						<h3><?php echo $class_schedule['day_of_week'].' เวลา : '.$class_schedule['time_start'].' - '.$class_schedule['time_end']; ?><h3>
						
					</div>
				</div>
			</div> <!-- Left panel -->

			<div class="col-sm-4"> <!-- middle panel -->
				<div class="panel panel-default">
					<div class="panel-body">
						<h3>ผู้สอน : <?php echo $class_schedule['supervisor_firstname']." ".$class_schedule['supervisor_lastname']; ?><h3>
						<h3>จำนวนนักศึกษา : <?php echo sizeof($students_data); ?> คน<h3>
						<h3>Online : <?php 
										$student_online = 0;
										foreach($students_data as $student) {
											if($student['status']=='online')
												$student_online ++;
										}
										echo $student_online; ?> คน<h3>
					</div>
				</div>
			</div><!-- middle panel -->

			<div class="col-sm-4"><!-- right panel -->
				<div class="panel panel-default">
					<div class="panel-footer" style="text-align:center;">
						<form action="<?php echo site_url('supervisor/allow_class_login'); ?>" id="toggle_allow_login" method="post" >
							<input type="text" name="group_id" value="<?php echo $class_schedule['group_id']; ?>" hidden >
							<input type="text" name="lecturer" value="<?php echo $class_schedule['lecturer']; ?>" hidden >
							<?php
								if ($class_schedule['allow_login']=='yes') {
									echo '<button class="btn btn-success" style="text-align:center;" type="submit">Allow student to log in.</button>';
									echo '<input type="text" name="allow_login" value="no" hidden>';
								} else {
									echo '<button class="btn btn-danger" style="text-align:center;" type="submit">Student CANNOT  log in.</button>';
									echo '<input type="text" name="allow_login" value="yes" hidden>';
								}
							?>
						</form>

						<br />

						<span><form action="<?php echo site_url('supervisor/allow_upload_pic'); ?>" id="toggle_allow_upload_pic" method="post" >
							<input type="text" name="group_id" value="<?php echo $class_schedule['group_id']; ?>" hidden >
							<input type="text" name="lecturer" value="<?php echo $class_schedule['lecturer']; ?>" hidden >
							<?php
								if ($class_schedule['allow_upload_pic']=='yes') {
									echo '<button class="btn btn-success" style="text-align:center;" type="submit">UPLOAD Picture -> OK</button>';
									echo '<input type="text" name="allow_upload_pic" value="no" hidden>';
								} else {
									echo '<button class="btn btn-danger" style="text-align:center;" type="submit">UPLOAD Picture -> Not allow.</button>';
									echo '<input type="text" name="allow_upload_pic" value="yes" hidden>';
								}
							?>
						</form></span>
						

						 
					</div>
				</div>
			</div><!-- right panel -->
		</div>
	</div>
		

	
	<div class="container-fulid" style="background-color:#ffb366;">
	
		<div class="row" style="color:Blue;text-align:center;background-color:Khaki ;font-size: 200%;padding-top:20px;padding-bottom:20px;"><div class="container">
			<div class="col-md-1"></div>
			<div class="col-md-6">Lab <?php echo $lab_no.' '.$chapter_permission['chapter_name'] ?>
			</div>
			<div class="col-md-2">
				<?php
							echo '<form action="'.site_url('supervisor/allow_access_class_chapter_v2').'" id="toggle_allow_access" method="post" >';
							echo '<input type="text" name="chapter_id" value="'.$lab_no.'" hidden>';
							echo '<input type="text" name="class_id" value="'.$class_id.'" hidden>';

							if ($chapter_permission['allow_access']=='yes') {
								echo '<td style="text-align:center"><button type="submit" class="btn btn-info">Access to Exercise : Yes </button></td>';
								echo '<input type="text" name="allow_access" value="no" hidden>';
							} else {
								echo '<td style="text-align:center"><button type="submit" class="btn btn-warning">Access to Exercise : No </button></td>';
								echo '<input type="text" name="allow_access" value="yes" hidden>';
							}
							echo '</form>';
				?>

						
			</div>
			<div class="col-md-2">
				<?php
					echo '<form action="'.site_url('supervisor/allow_submit_class_chapter_v2').'" id="toggle_allow_access" method="post" >';
					echo '<input type="text" name="chapter_id" value="'.$lab_no.'" hidden>';
					echo '<input type="text" name="class_id" value="'.$class_id.'" hidden>';
					if ($chapter_permission['allow_submit']=='yes') {
						echo '<td style="text-align:center"><button type="submit" class="btn btn-info"> Submit: Yes </button></td>';
						echo '<input type="text" name="allow_submit" value="no" hidden>';
					} else {
						echo '<td style="text-align:center"><button type="submit" class="btn btn-warning"> Submit:  No </button></td>';
						echo '<input type="text" name="allow_submit" value="yes" hidden>';
					}
					echo '</form>';
				?>
			</div>
			<div class="col-md-1"></div>

		</div></div>

		<table class="table table-striped">
			<!--<thead>
				<tr>
					<th>ข้อ 1 <?php echo "(".sizeof($lab_list[1]).")"; ?></th>
					<th>ข้อ 2 <?php echo "(".sizeof($lab_list[2]).")"; ?></th>
					<th>ข้อ 3 <?php echo "(".sizeof($lab_list[3]).")"; ?></th>
					<th>ข้อ 4 <?php echo "(".sizeof($lab_list[4]).")"; ?></th>
					<th>ข้อ 5 <?php echo "(".sizeof($lab_list[5]).")"; ?></th>
				</tr>
			</thead>-->
			<tbody>
				<tr>
					<?php 
						$no_of_items = sizeof($lab_list);
						$level = 1;
						foreach ($lab_list as $lab_level) {
					?>
					<td>						
						<div class="panel panel-default">
							<?php $no_of_item_list = sizeof($lab_level); ?>
							
							<div class="panel-heading"><?php echo "ข้อ $level($no_of_item_list)"; ?></div>
							<div class="panel-body">
								<?php
									echo '<form method="post" action="'.site_url('supervisor/update_selected_exercise/').'">';
									
									echo '<input type="text" name="user_id" value="'.$user_id.'" hidden >';
									echo '<input type="text" name="group_id" value="'.$group_id.'" hidden >';
									echo '<input type="text" name="chapter" value="'.$lab_no.'" hidden >';
									echo '<input type="text" name="level" value="'.$level.'" hidden >';
									$i=1;
									foreach($lab_level as $row) {
										$exercise_id = $row['exercise_id'];										
										echo '<input type="checkbox" name="selected_id_'.$i.'" value="'.$exercise_id.'" ';
										foreach($group_lab_list as $list) { 
											foreach($list as $item) {
												if($exercise_id==$item) {
													echo " checked ";
													break;
												}
											}
										}
										$i++;

										echo ' >';
										echo ' '.$row['lab_name'].' ';
										echo '<span><a type="button" href="'.site_url('supervisor/exercise_view/'.$row['exercise_id']).'"';
										echo '>view</a></span><br/>';
										
										
									}
									echo '<button type="submit"  >Update</button>';
									echo '</form>';
								?>
								<form>
								</form>
							</div>
							<div class="panel-footer">
								<!--
								<form method="post" action="<?php echo site_url('supervisor/exercise_add_chapter_item'); ?>" style="text-align:center;">
									<button type="submit" class="btn btn-info">Add NEW Exercise5: Lab <?php 
										echo "$lab_no / Level $level"; ?>
									</button>
									<input type="text" name="group_id" value="<?php echo $group_id; ?>" hidden >
									<input type="text" name="lab_no" value="<?php echo $lab_no; ?>" hidden >
									<input type="text" name="level" value="<?php echo $level; ?>" hidden >
									<input type="text" name="lecturer_id" value="<?php echo $lecturer_id; ?>" hidden >
									<input type="text" name="user_id" value="<?php echo $user_id; ?>" hidden >
								</form>
								<br/>
								-->
								<form method="post" action="<?php echo site_url('supervisor/exercise_add_chapter_item_python'); ?>" style="text-align:center;">
									<button type="submit" class="btn btn-info">python Add : Lab <?php 
										echo "$lab_no / Level $level"; ?>
									</button>
									<input type="text" name="group_id" value="<?php echo $group_id; ?>" hidden >
									<input type="text" name="lab_no" value="<?php echo $lab_no; ?>" hidden >
									<input type="text" name="level" value="<?php echo $level; ?>" hidden >
									<input type="text" name="lecturer_id" value="<?php echo $lecturer_id; ?>" hidden >
									<input type="text" name="user_id" value="<?php echo $user_id; ?>" hidden >
								</form>
							</div>
						</div>
					</td>
					<?php $level++; } ?>
				
				</tr>
		
			</tbody>
		</table>
	</div>


	<!--	
	<div class="row">
		<div class="panel panel-default">
			<div class="panel-heading">
				<?php 
					//echo '<h4>$chapter_permission <pre>'; print_r($chapter_permission); echo "</pre>";
					//echo '<h4>$lab_list <pre>'; print_r($lab_list); echo "</pre>";
					//echo '<h4>$group_lab_list <pre>'; print_r($group_lab_list); echo "</pre>";
					//echo '<h4>$group_exercise_chapter <pre>'; print_r($group_exercise_chapter); echo "</pre>";
					//echo '<h4>$class_schedule <pre>'; print_r($class_schedule); echo "</pre>";
					//echo '<h4>$_SESSION <pre>'; print_r($_SESSION); echo "</pre>";
				?>
		
			<div>
			

		</div>
	</div>
	-->
	
	
	

	
</div>
<!-- nav_body -->