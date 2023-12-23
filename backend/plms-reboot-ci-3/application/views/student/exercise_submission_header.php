<!-- nav_body -->
<div class="col-lg-10 col-md-10 col-sm-10 kpanel_body" style="margin-top:120px;">
	<div class="row">
		<div class="col-lg-1">
		</div> 
		<?php
			echo '<!-- <pre>';print_r($_SESSION);echo '</pre> -->'; 
			if ($_SESSION['role']=='supervisor')
				$mode = 'supervisor';
			else
				$mode = 'student';
			if (!isset($stu_id))
				$stu_id = $_SESSION['stu_id'];
				
		?> 
		
		<div class="col-lg-10">
			<div class="panel panel-primary" style="min-width:800px;">
				<div class="panel-heading">
					 <div class="row">
						<div class="col-xs-1">
							<div><?php if($group_permission[$lab_chapter]['allow_submit']=='no'  && $group_permission[$lab_chapter]['allow_access']=='yes')
										echo '<button type="button" class="btn btn-warning">ไม่สามารถส่งได้</button>';?></div>
						</div>

						<div class="col-xs-7">
							<h2>Chapter : <?php echo $lab_chapter; ?> - item : <?php echo $lab_item ?> - <?php echo $lab_name; ?></h2>
						</div>
						
						<div class="col-xs-4">
							<button class="btn btn-info btn-lg no_pointer">คะแนน : <?php echo $marking,' / ',$full_mark; ?></button>
							<p class="badge">ส่งมาแล้ว <?php echo $submitted_count; ?> ครั้ง</p>
						</div>						

					</div>
				</div>

				<div style="display:inline-block;"></div>

				<div class="panel-body">
					<p><?php echo htmlspecialchars_decode($lab_content); ?></p>
				</div>
				<?php if(!empty($output) && $output != 'Not Avialable' && is_string($output) ) {
					$output_html = '
				<div class="panel-footer pull-left" style="text-align:left;">
					<h3>Output : </h3>
					<div  style="font-family: Courier;font-size: 16px;border:2px blue;">';
					$output_html .= '<code><textarea cols="80" rows="25" style="background:black;color:white;">';
					$output_html .= $output;
					
					$output_html .= '</textarea></code>
					</div>						
				</div>';
					echo $output_html;
					//.'<!--- เจอ xml มาจากไหนไม่รู้ Lab 2561-1 กลุ่ม 9 ข้อ 1a ป้องกันการแสดงผล ปุ่ม submit หาย --->';
				} ?>
				
				
			</div>
		</div>
		<div class="col-lg-1">
		</div>
	</div>
	<!--- --->
	<div class="row" style="display:inline-block;">
		<?php if ($mode=='supervisor') echo '<!-- '; ?>
		<form action="<?php echo site_url('student/exercise_submission'); ?>" method="post" accept-charset="utf-8" id="exercise_submission" enctype="multipart/form-data"  onsubmit="return checkSourceCode()" <?php if($group_permission[$lab_chapter]['allow_submit']=='no')
										echo 'disabled';?> >
			<input type="hidden"	name="stu_id"		value="<?php echo $stu_id;	?>" >
			<input type="hidden"	name="chapter_id"	value="<?php echo $lab_chapter;			?>" >
			<input type="hidden"	name="item_id"		value="<?php echo $lab_item;			?>" >
			<input type="hidden"	name="exercise_id"	value="<?php echo $exercise_id;			?>" >
			


			<?php	if($group_permission[$lab_chapter]['allow_submit']=='no') {
						echo '<button disabled class="btn btn-warning btn-lg " readonly> Not allow to submit !!! </button>';
					} else 	if($marking<$full_mark) {
						echo '<input type="file" name="submitted_file" value="" id="userfile" accept=".py" onchange="checkSourceCode(this);">';
						echo '<span><button  type="button"  name="submit_button" onclick="return form_submit(this);" >Submit</button></span>';
					} else {
						echo '<button disabled class="btn btn-success btn-lg " readonly> You have got full mark !!! </button>';
					}
			?>
			

		</form>
		<?php if ($mode=='supervisor') echo ' --> '; ?>
	</div>
	


  

<script type="text/javascript">



	
</script>
