<!-- nav_sideleft -->

<div class="col-sm-2 sidenav text-center" style="padding-top:10px;margin-top:100px;">
	<div class="affix" style="background-color:Pink; min-width: 15%; "><!-- -->

		<div class="panel panel-default" style="background-color:AliceBlue; height:1024px;">
			<img src="<?php echo $student_data['stu_avatar'] ? base_url(STUDENT_AVATAR_FOLDER.$student_data['stu_avatar']) : base_url(STUDENT_AVATAR_FOLDER.'user.png'); ?>" style="width:180px;height:216px;padding-top:20px">
			
			<div class="row" style="margin-top:10px">
				<p>กลุ่มที่ : <?php echo $student_data['group_no']; ?> </p>
				<p>รหัสนักศึกษา : <?php echo $student_data['stu_id'] ? $student_data['stu_id'] : "      "; ?> </p>
			</div>
				

			<div class="row">
				
					<p><?php	if($student_data['stu_gender']=='male')
									echo 'นาย ';
								else if($student_data['stu_gender']=='female')
									echo 'นางสาว ';
								else
									echo ' - ';
								echo $student_data['stu_firstname'] ? $student_data['stu_firstname'] : "   "; 
								echo "  ";
								echo $student_data['stu_lastname'] ? $student_data['stu_lastname'] : "<br />   ";
								
						?>
					</p>
			</div>
			<div class="row">			
				<p><?php echo $student_data['stu_nickname'] ? $student_data['stu_nickname'] : "   "; ?></p>
			</div>

			<div class="row">			
				<p><?php 
					if(isset($student_data['stu_dept_name']))
						echo $student_data['stu_dept_name'];
					?></p>
			</div>
			<div class="row" style="padding-bottom:20px">			
				<p class="btn btn-warning" id="midterm_score" ondblclick="show_midterm_score();">คะแนนสอบกลางภาค (60) <br>xx คะแนน</p>
			</div>
			<div class="row">			
				 
			</div>
			<div id="online_students" class="btn btn-info " >Online: 0 คน</div>
			
			
			<!--
			<div class="row">			
				<p><?php /* echo "student_data : <pre> ";print_r($student_data);echo "</pre>"; */ ?></p>
			</div>
			<!---->
			

		</div>
		
	</div>
	

	

	
</div>
<!-- nav_sideleft -->
		
		

