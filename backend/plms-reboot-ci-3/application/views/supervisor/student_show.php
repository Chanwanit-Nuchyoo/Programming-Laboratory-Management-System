<?php
	$group_id = $class_schedule['group_id'];
	$group_number = $class_schedule['group_no'];
	$group_dept = $class_schedule['dept_name'];
?>
<!-- nav_body -->
<div class="col-lg-10 col-md-10 col-sm-10" style="margin-top:10px;">
	<?php
		$number_of_chapters = sizeof($lab_info);
		echo '<!-- '.'<pre>';print_r($students_data);echo '</pre> -->';
	?>
	<!--
	<div class="row">
		<div class="col-sm-6">.col-sm-4
			<div class="panel panel-default">
				<div class="panel-heading">Panel Heading</div>
				<div class="panel-body">A Basic Panel</div>
			</div>
		</div>
		<div class="col-sm-3">
			<div class="panel panel-default">
				<div class="panel-heading">อนุญาติ ดูโจทย์</div>
				<div class="panel-body">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th style="text-align:center;">lab</th>
								<th style="text-align:center;">การดูโจทย์</th>
								<th style="text-align:center;">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php for($no=1;$no<=$number_of_chapters;$no++) { ?>
							<form action="<?php echo site_url('supervisor/browse_exercise'); ?>" method="post" id="browse_exercise">
							<tr>
								<td style="text-align:center;"><?php echo $no; ?></td>
								<td style="text-align:center;">
									<input type="radio" name="browse_exercise" value="yes" 
										<?php if ($group_permission[$no]['allow_access']=='yes') echo 'checked';  ?> > Yes 
									<input type="radio" name="browse_exercise" value="no" 
										<?php if ($group_permission[$no]['allow_access']=='no') echo 'checked';  ?>> NO
									<input type="hidden" name="chapter_id" value="<?php echo $no; ?>"></input>
									<input type="hidden" name="group_id" value="<?php echo $class_schedule['group_id']; ?>"></input>
								<td style="text-align:center;"><input type="submit"></td>
							</tr>
							</form> 
							<?php } ?>
						<tr>
						
						</tbody>
					</table>
				</div>
			</div>
		</div>		
		<div class="col-sm-3">
			<div class="panel panel-default">
				<div class="panel-heading">อนุญาติ การส่งงาน</div>
				<div class="panel-body">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th style="text-align:center;">lab</th>
								<th style="text-align:center;">การส่งงาน</th>
								<th style="text-align:center;">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php for($no=1;$no<=$number_of_chapters;$no++) { ?>
							<form action="<?php echo site_url('supervisor/allow_submit_class_chapter'); ?>" method="post" id="allow_submit_class_chapter">
							<tr>
								<td style="text-align:center;"><?php echo $no; ?></td>
								<td style="text-align:center;">
									<input type="radio" name="allow_submit" value="yes" 
										<?php if ($group_permission[$no]['allow_submit']=='yes') echo 'checked';  ?> > Yes 
									<input type="radio" name="allow_submit" value="no" 
										<?php if ($group_permission[$no]['allow_submit']=='no') echo 'checked';  ?>> NO
									<input type="hidden" name="chapter_id" value="<?php echo $no; ?>"></input>
									<input type="hidden" name="group_id" value="<?php echo $class_schedule['group_id']; ?>"></input>
								<td style="text-align:center;"><input type="submit"></td>
							</tr>
							</form> 
							<?php } ?>
						<tr>
						
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	-->

	<div class="row">
		<div class="col-sm-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h1>กลุ่มที่ : <?php echo $class_schedule['group_no']; ?><h1>
					<h3>ภาควิชา : <?php echo $class_schedule['dept_name']; ?><h3>
					<h3><?php echo $class_schedule['day_of_week'].' เวลา : '.$class_schedule['time_start'].' - '.$class_schedule['time_end']; ?><h3>
					
				</div>
				<div class="panel-body">
					<h3>ผู้สอน : <?php echo $class_schedule['supervisor_firstname']." ".$class_schedule['supervisor_lastname']; ?><h3>
					<h3>จำนวนนักศึกษา : <?php echo sizeof($students_data); ?> คน<h3>
					<h3><span onclick="logoutStudentGroup()" title="Logout all students" class="glyphicon glyphicon-log-out"></span> Online : <span id="stu_in_group"><?php 
									$student_online = 0;
									foreach($students_data as $student) {
										if($student['status']=='online')
											$student_online ++;
									}
									echo $student_online; ?></span> คน<h3>
				</div>
				<div class="panel-footer">
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
		</div>

		<div class="col-sm-8">
			<div class="panel panel-default">
				<!--<div class="panel-heading">
					<div><?php 
						echo $class_schedule['year']." / ".$class_schedule['semester']." "; 
						echo 'กลุ่มที่ : '.$class_schedule['group_no']." ".$class_schedule['dept_name']." "; 
						echo $class_schedule['day_of_week']." ".$class_schedule['time_start'].' - '.$class_schedule['time_end']; 
						
						echo 'Allow submit : '.$class_schedule['allow_submit'].' '; 
						echo 'Allow login : '.$class_schedule['allow_login'].' '; 
						echo 'Upload picture : '.$class_schedule['allow_upload_pic'].' '; 
						echo 'Browse exercise : '.$class_schedule['allow_exercise'].' '; 
						echo '<br />ผู้สอน : '.$class_schedule['supervisor_firstname']." ".$class_schedule['supervisor_lastname'];
						echo ' staff : ';
						foreach ($class_schedule['lab_staff'] as $staff) {
							echo $staff['supervisor_firstname'].' ';
						}
						echo date('l dS \o\f F Y h:i:s A', strtotime("now"));


						?>
					</div>
					<!--<?php echo " class_schedule <pre>"; print_r($class_schedule); echo "</pre>"; ?>
				</div>-->
				<!--<?php echo "assigned_group_item<pre>"; print_r($assigned_group_item); echo "</pre>"; ?> -->
				
				
				<div class="panel-body">
					<table class="table table-bordered">
						<thead>
							<tr>
								<?php 
									$keys = array_keys($lab_info[0]);
									//echo "keys<pre>"; print_r($keys); echo "</pre>";
									echo '<td style="text-align:center">'.'บทที่'.'</td>';
									echo '<td style="text-align:center">'.'บทเรียน'.'</td>';
									echo '<td style="text-align:center">'.'คะแนนเต็ม'.'</td>';
									echo '<td style="text-align:center">'.'จำนวนข้อ'.'</td>';
									echo '<td style="text-align:center">'.'ดูแบบฝึกหัด'.'</td>';
									echo '<td style="text-align:center">'.'ส่งแบบฝึกหัด'.'</td>';
								?>
							
							</tr>
						</thead>
						<tbody>
							<?php
								$count = 0;
								$user_id = substr($_SESSION['id'],0,2);
								$user_name = substr($_SESSION['username'],2);

								foreach ($group_permission as $row) {
									$count++;
									echo '<tr>';
									 
									echo '<td align="center">';
										echo '<form action='.site_url('supervisor/select_exercise_for_group');
										echo ' id="select_exercise_for_group" method="post" id="set_group_status">';
										echo '<input type="text" hidden name="lab_no" value='.$row['chapter_id'].' >';
										echo '<input type="text" hidden name="group_id" value='.$class_schedule['group_id'].'>';
										echo '<button type="button submit" class="btn btn-primary">'.$row['chapter_id'].'</button>';
										echo '</form>';
									echo '</td>';
								
									echo '<td style="text-align:center">'.$row['chapter_name'].'</td>';
									echo '<td style="text-align:center">'.$row['chapter_fullmark'].'</td>';
									echo '<td style="text-align:center">'.$row['no_items'].'</td>';
									echo '<form action="'.site_url('supervisor/allow_access_class_chapter').'" id="toggle_allow_access" method="post" >';
									echo '<input type="text" name="chapter_id" value="'.$row['chapter_id'].'" hidden>';
									echo '<input type="text" name="class_id" value="'.$row['class_id'].'" hidden>';

									if ($row['allow_access']=='yes') {
										echo '<td style="text-align:center"><button type="submit" class="btn btn-info"> Yes </button></td>';
										echo '<input type="text" name="allow_access" value="no" hidden>';
									} else {
										echo '<td style="text-align:center"><button type="submit" class="btn btn-warning"> No </button></td>';
										echo '<input type="text" name="allow_access" value="yes" hidden>';
									}
									echo '</form>';


									/*
									echo '<td style="text-align:center">'.$row['chapter_name'].'</td>';
									echo '<td style="text-align:center">'.$row['chapter_fullmark'].'</td>';
									echo '<td style="text-align:center">'.$row['no_items'].'</td>';
									echo '<form action="'.site_url('supervisor/allow_access_class_chapter').'" id="toggle_allow_access" method="post" >';
									echo '<input type="text" name="chapter_id" value="'.$row['chapter_id'].'" hidden>';
									echo '<input type="text" name="class_id" value="'.$row['class_id'].'" hidden>';

									if ($row['allow_access']=='yes') {
										echo '<td style="text-align:center"><button type="submit" class="btn btn-info"> Yes </button></td>';
										echo '<input type="text" name="allow_access" value="no" hidden>';
									} else {
										echo '<td style="text-align:center"><button type="submit" class="btn btn-warning"> No </button></td>';
										echo '<input type="text" name="allow_access" value="yes" hidden>';
									}
									echo '</form>';*/
									
									echo '<form action="'.site_url('supervisor/allow_submit_class_chapter').'" id="toggle_allow_access" method="post" >';
									echo '<input type="text" name="chapter_id" value="'.$row['chapter_id'].'" hidden>';
									echo '<input type="text" name="class_id" value="'.$row['class_id'].'" hidden>';
									if ($row['allow_submit']=='yes') {
										echo '<td style="text-align:center"><button type="submit" class="btn btn-info"> Yes </button></td>';
										echo '<input type="text" name="allow_submit" value="no" hidden>';
									} else {
										echo '<td style="text-align:center"><button type="submit" class="btn btn-warning"> No </button></td>';
										echo '<input type="text" name="allow_submit" value="yes" hidden>';
									}
									echo '</form>';
									
									echo '</tr>';
									if ($count >= 12 && ( $user_id == '88'))
										break;
								}
								
								

								
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<!--<div class="col-sm-6">
			<div class="panel panel-default">
				<div class="panel-heading">

						<table class="table table-bordered">
							<thead><tr>
							<?php 
								$keys = array_keys($assigned_group_item[0]);
								//echo "keys<pre>"; print_r($keys); echo "</pre>";
								foreach ($keys as $row) { 
									echo '<td>'.$row.'</td>';
								}
							?>
								
							</tr></thead>
							<tbody>
							<?php 
								foreach ($assigned_group_item as $row) {
									echo '<tr>';
									 
									foreach ($row as $value) {
										echo '<td>'.$value.'</td>';
									}					
									
									echo '</tr>';
								}
							?>
							</tbody>
						</table>
					</div>


					
					
				</div>
			</div>
		</div>
		<div class="col-sm-3">sdf</div>
		<div class="col-sm-3">23</div>-->
	</div>
	

	<div class="row">
		<div class="container-fluid">
			<h2><?php 
				echo "กลุ่มที่ : ".$class_schedule['group_no'];
				echo " ผู้สอน : ".$class_schedule['supervisor_firstname']." ".$class_schedule['supervisor_lastname'];
				echo ' <a style="color:Blue;font-size:0.5em;">TIP! Sort multiple columns simultaneously by holding down the shift key and clicking a second, third or even fourth column header!</a>';
				echo '<h6>
				<button onclick="hideColumn(this,3)">Name</button>
				<button onclick="hideColumn(this,4)">Reset passoword</button>
				<button onclick="hideColumn(this,5)">Nickname</button>
				
				 
				<button onclick="hideColumn(this,6)">Avarta</button> ';
				$column_offset = 6;
				foreach ($lab_info as $row) { 
					echo '<button onclick="hideColumn(this,'.($column_offset+$row['chapter_id']).')">'.$row['chapter_id'].'</button> ';	
				}
				
				echo '</h6>';
				/*echo '<form action="';
				echo site_url('supervisor/close_lab_group');
				echo '" id="close_lab_group" method="post" id="close_lab_group" >';
				echo '<input type="text" hidden name="group_id" value="'.$class_schedule['group_id'].'" >';

				echo ' <button type="button submit" class="btn btn-warning" action="close_lab_group">Close All Labs</button>';
				echo '</form>';*/
			?></h2>

			<div class="table-responsive">
				<table class="table table-bordered table-hover tablesorter" style="" id="studentShow">
					<!--<nav class="navbar navbar-inverse" data-spy="affix" data-offset-top="497">-->
						<thead>
							<tr>
								<th style="width:60px;">NO.</th>
								<th style="width:110px;" >Student ID</th>
								<th style="width:200px;text-align:center;" >Name Surname</th>
								
								<th style="width:60px;" >Reset password</th>
								<th style="width:60px;" >ชื่อเรียก</th>
								<th style="text-align:center;width:60px;" >Avatar</th>
								<?php 
									$total_mark = 0;
									$item_no = 0;
									foreach ($lab_info as $row) { 
										$status = $assigned_group_item[$item_no]['status'];
										echo '<th style="text-align:center">';														
										echo ' Lab '.$row['chapter_id']."<br />(".$row['chapter_fullmark'].")"; 
									}
								?>
																
								<th style="text-align:center">TOTAL<br />(<?php echo $total_mark;?>)</th>
								<th style="text-align:center">Mid<br />(<?php echo "60";?>)</th>

															
							</tr>
						</thead>
					<!--</nav>-->
					<tbody>
						<?php for($count=0; $count<sizeof($students_data); $count++) { ?>
						<tr stu_id="<?php echo  $students_data[$count]['stu_id']; ?>" class="student_row" >
							
							<td>
								<?php 
									echo '<div class="well" style="color:#fff;background-color:';;
									if($students_data[$count]['status']=='online')
										echo '#99ffff;">'; 
									else
										echo '#ff6600;">'; 
									echo ($count+1).'</div>'
								?>
							</td>
							
							<td>
								<form action="<?php echo site_url('supervisor/student_info')?>" method="post">
									<button type="submit" class="btn btn-sm" ><?php echo $students_data[$count]['stu_id']; ?></button>
									<input type="text" name="stu_id" hidden value="<?php echo  $students_data[$count]['stu_id']; ?>" >
									<input type="text" name="stu_group" hidden value="<?php echo  $students_data[$count]['stu_group']; ?>" >
							
								</form>
								<br/>
							</td>

							
							
							<td style="text-align:left;">
								<?php echo $students_data[$count]['stu_firstname']," ", $students_data[$count]['stu_lastname'],"<br>";	?>
							</td>

							<td>
								<form action="<?php echo site_url('supervisor/student_password_reset')?>" id="student_password_reset" method="post" name="student_password_reset">
									<button type="submit" class="btn btn-sm" onclick="window.alert('Password will be reset to student id !!!');">reset<br />password</button>
									<input type="text" name="stu_id" hidden value="<?php echo  $students_data[$count]['stu_id']; ?>" >
									<input type="text" name="stu_group" hidden value="<?php echo  $students_data[$count]['stu_group']; ?>" >
							
								</form>
							</td>

							<td style="text-align:center;">
								<?php 	echo  $students_data[$count]['stu_nickname']; ?>
							</td>

							<td>
								<img src="<?php echo $students_data[$count]['stu_avatar'] ? base_url(STUDENT_AVATAR_FOLDER.$students_data[$count]['stu_avatar']) : base_url(STUDENT_AVATAR_FOLDER.'user.png'); ?>" style="width:90px;height:108px;">
							</td>
							<?php
								$sum_marking = 0;
								for($num=1;$num<=$number_of_chapters;$num++ ){
									echo '<td style="text-align:center;">';
									echo $students_data[$count][$num];
									$sum_marking += $students_data[$count][$num];
									echo '</td>';

								}
							?>

							<!--
							<td style="text-align:center;"><?php echo $students_data[$count][1]; $total=$students_data[$count][1]; ?></td>
							<td style="text-align:center;"><?php echo $students_data[$count][2]; $total+=$students_data[$count][2]; ?></td>
							<td style="text-align:center;"><?php echo $students_data[$count][3]; $total+=$students_data[$count][3]; ?></td>
							<td style="text-align:center;"><?php echo $students_data[$count][4]; $total+=$students_data[$count][4]; ?></td>
							<td style="text-align:center;"><?php echo $students_data[$count][5]; $total+=$students_data[$count][5]; ?></td>
							<td style="text-align:center;"><?php echo $students_data[$count][6]; $total+=$students_data[$count][6]; ?></td>
							<td style="text-align:center;"><?php echo $students_data[$count][7]; $total+=$students_data[$count][7]; ?></td>
							<td style="text-align:center;"><?php echo $students_data[$count][8]; $total+=$students_data[$count][8]; ?></td>
							<td style="text-align:center;"><?php echo $students_data[$count][9]; $total+=$students_data[$count][9]; ?></td>
							<td style="text-align:center;"><?php echo $students_data[$count][10]; $total+=$students_data[$count][10]; ?></td>
							
							<td style="text-align:center;"><?php echo $students_data[$count][11]; $total+=$students_data[$count][11]; ?></td>
							-->

							<td style="text-align:center;"><?php echo $sum_marking; ?></td>			
							<td style="text-align:center;"><?php 
								$stu_id = $students_data[$count]['stu_id'];
								$mid_score = $_SESSION['mid_score'];
								$score = $mid_score[$count];
								echo $score['mid_score']; ?></td>						
						</tr>						
						<?php  } ?>

						
					</tbody>
				</table>

				<a href="<?php echo site_url('supervisor/student_add/').$class_schedule['group_id']; ?>" class="btn btn-warning" role="button">เพิ่มนักศึกษา</a>

			</div>
		</div>
	</div>
	
	<!--<div class="row">
		<table class="table table-bordered table-hover" style="">
			<thead>
				<tr>
					<?php 
						foreach ($students_data[0] as $key=>$student) {
							echo '<td>'.$key.'</td>';
						}
					?>															
				</tr>
			</thead>
			<tbody>
				<?php 
					foreach ($students_data as $stu) { 
						echo '<tr>';
						foreach ($stu as $row) {
							echo '<td>'.$row.'</td>';
						}
						echo '</tr>';
					}
				?>															
				
			</tbody>
		</table>
	</div>
	<div class="row">
		<table class="table table-bordered table-hover" style="">
			<thead>
				<tr>
					<?php 
						foreach ($students_data[0] as $key=>$student) {
							echo '<td>'.$key.'</td>';
						}
					?>															
				</tr>
			</thead>
			<tbody>
				<?php 
					foreach ($students_data as $stu) { 
						echo '<tr>';
						foreach ($stu as $row) {
							echo '<td>'.$row.'</td>';
						}
						echo '</tr>';
					}
				?>															
				
			</tbody>
		</table>
	</div>
	 -->
		
	

	<!--<script>
		$(document).ready(function() {
			$('#summernote').summernote({
				height: 500,                 // set editor height
				width:240,					// set editor height
				minHeight: null,             // set minimum height of editor
				maxHeight: null,             // set maximum height of editor
				focus: true,                  // set focus to editable area after initializing summernote
				airmode: true
			});
		});
	</script>
	-->

	<script>
		$(document).ready(function() { 
					$("#studentShow").tablesorter(); 
				} 
			); 
		function hideColumn0(v) {
			var tbl = document.getElementById('studentShow');
			//var v = $('#number').val() || 0;
			
			$('#studentShow tr > *:nth-child('+v+')').toggle(); //http://jsfiddle.net/d6JWV/575/

		}

		function hideColumn(ele,v) {
			var tbl = document.getElementById('studentShow');
			//var v = $('#number').val() || 0;
			
			$('#studentShow tr > *:nth-child('+v+')').toggle(); //http://jsfiddle.net/d6JWV/575/
			if( ele.style.background=="lightpink")
				ele.style.background = "lightgray";
			else
				ele.style.background = "lightpink";

		}

		// 2565-10-20
		function logoutStudentGroup() {
			let baseurl = "<?php echo base_url();?>";
			let URL_ = baseurl+"index.php/supervisor/logoutStudentGroup/"+<?php echo $group_id;?>;
			console.log(URL_);
			
			// let test = <?php echo json_encode($_SESSION);?>;
			// console.log(test);
			fetch(URL_)
			.then( res => {
				// console.log(res);
				let x = res.json();
				// console.log(x);
				return x;
			}).then( data => {
				// console.log("xxx");
				// console.log(data);
			})
			
			window.location.reload(false);
			return true;
		}
	</script>


</div>
<!-- nav_body -->