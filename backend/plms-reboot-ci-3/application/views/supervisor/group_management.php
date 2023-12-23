
<!-- <?php echo "group_list: <pre>"; print_r($group_list); echo "</pre>"; ?>-->
<!-- nav_body -->
<div class="col-lg-10 col-md-10 col-sm-10" >
	<div class="container-fluid">

		<div class="row">
			<div class="col-lg-12">
				<table class="col-sm-10 table table-condensed" style="margin-top:40px;">
				
					<thead>
						<tr>
							<th style="text-align:center">รหัสกลุ่ม</th>
							<th style="text-align:center">กลุ่มที่</th>
							<th style="text-align:center">ปีการศึกษา/เทอม</th>
							<th style="text-align:center">ภาควิชา</th>
							<th style="text-align:center">ชื่อกลุ่ม</th>
							<th style="text-align:center">วัน</th>
							<th style="text-align:center">เวลา</th>
							
							<th style="text-align:center">ผู้สอน</th>
							<th style="text-align:center">ผู้ช่่วย</th>
							<th style="text-align:center">allow_login</th>
							<th style="text-align:center">allow_submit</th>
							<th style="text-align:center">pic_upload</th>
							<th style="text-align:center">ทำแบบฝึกหัด</th>
						</tr>
					</thead>

					<?php
						if(!empty($group_list)) {
							foreach ($group_list as $data) {
								echo "<tr>";
								echo '<td style="text-align:center">'.$data['group_id']."</td>";
								echo '<td style="text-align:center"><a target="_blank"  href='.site_url($_SESSION['role']).'/student_show/'.$data['group_id'].">".$data['group_no']."</a></td>";
								echo '<td style="text-align:center">'.$data['year']."/".$data['semester'].'<span class="badge">'.$data['students_in_group'].'</span>'."</td>";
								echo '<td >'.$data['dept_name']."</td>";
								echo '<td style="text-align:center">'.$data['group_name']."</td>";
								echo '<td style="text-align:center">'.$data['day_of_week']."</td>";
								echo '<td style="text-align:center">'.$data['time_start']." - ".$data['time_end']."</td>";
								$lecturer_firstname = $data['supervisor_firstname'] ? $data['supervisor_firstname'] : "";
								$lecturer_lastname = $data['supervisor_lastname'] ? $data['supervisor_lastname'] : "";

								echo '<td>'.$lecturer_firstname.' '.$lecturer_lastname."</td>";
								echo '<td style="text-align:center">';
								$staff = $data['lab_staff'];
								if (!empty($staff)) {
									foreach($staff as $person) {
										echo $person['supervisor_firstname'].' ';
									}
								}
								echo '</td>';
								echo '<td style="text-align:center">'.$data['allow_login']."</td>";
								echo '<td style="text-align:center">'.$data['allow_submit']."</td>";
								echo '<td style="text-align:center">'.$data['allow_upload_pic']."</td>";
								echo '<td style="text-align:center">'.$data['allow_exercise']."</td>";
								echo "</tr>";
							}
						}
						

					?>
				</table>
			</div>
		</div>
	</div>
	<!-- class="container-fluid" -->
	<?php //print_r($group_list); ?>
	
</div>
<!-- nav_body -->
