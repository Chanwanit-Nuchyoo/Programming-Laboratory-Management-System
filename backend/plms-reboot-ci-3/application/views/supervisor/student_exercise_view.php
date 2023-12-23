<!-- nav_body -->
<div class="col-lg-10 col-md-10 col-sm-10" style="margin-top:100px;">
	<?php 
		echo '<!-- ';
		echo "$stu_id =>	$chapter			=>	$item	=>	$exercise_id <br/>";
		echo "student_data <pre>";print_r($student_data);echo "</pre>";
		echo "lab_exercise <pre>";print_r($lab_exercise);echo "</pre>";
		echo "stu_submit <pre>";print_r($stu_submit);echo "</pre>";
		echo ' -->';
		$number_of_submit = sizeof($stu_submit);
		if ($number_of_submit>0) {
			$last_submit = $stu_submit[$number_of_submit-1];
			$submission_id = $last_submit['submission_id'];
		} else {
			$last_submit['marking']=0;
			$submission_id = -1;
		}

		
	?>

	<div class="row">
		<div class="container">
			<div class="panel panel-default">
				<div class="panel-heading">
					<img src="<?php echo $student_data['stu_avatar'] ? base_url(STUDENT_AVATAR_FOLDER.$student_data['stu_avatar']) : base_url(STUDENT_AVATAR_FOLDER.'user.png'); ?>" style="width:150px;height:180px;margin-left:20px;padding-top:20px">
					<?php 
						echo $student_data['stu_id'].' '.$student_data['stu_firstname'].' '.$student_data ['stu_lastname'].' ';
						echo $student_data['stu_nickname'];
						echo ' กลุ่มที่ :'.$student_data['group_no'].'/'.$student_data['group_name'].'<br/>';
						echo ' Chapter:'.$chapter.' item: '.$item.' submission_no: '.$number_of_submit;
						echo ' Marking: '.$last_submit['marking'];
					?>
					
				
				</div>
				<!--<div class="panel-body"><?php echo'<pre>';print_r($last_submit); echo '</pre>'; ?> -->
				<!--<div class="panel-body" style="text-align:left;tab-size:4; font-family: Courier;">
						<?php
							$sourcecode_content = $last_submit['sourcecode_content'];
							$lines_of_sourcecode = substr_count($sourcecode_content, "\n" )+4;
						?>
						<textarea readonly class="sourcecode_content" cols="120" rows="<?php echo $lines_of_sourcecode; ?>" id="sourcecode_content" name="sourcecode_content" ><?php echo $sourcecode_content; ?></textarea>
					</div>
				</div>-->
				<div class="panel-footer">
					<form method="post" action="<?php echo site_url('supervisor/remove_last_submission');?>">
						<button type="submit">Remove this submission</button>
						<input type="text" name="stu_id" value="<?php echo $stu_id; ?>" hidden></input>
						<input type="text" name="chapter" value="<?php echo $chapter; ?>" hidden></input>
						<input type="text" name="item" value="<?php echo $item; ?>" hidden></input>
						<input type="text" name="exercise_id" value="<?php echo $exercise_id; ?>" hidden></input>
						<input type="text" name="submission_id" value="<?php echo $submission_id; ?>" hidden></input>

					</form>
				</div>
			</div>
		</div>
	</div>
	<script src="<?php echo base_url('assets/summernote/summernote.js') ?>"></script>	
	<script type="text/javascript" src="<?php echo base_url('assets/codemirror-5.22.0/lib/codemirror.js')?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/codemirror-5.22.0/mode/clike/clike.js')?>"></script>
	<script>
		var editor = CodeMirror.fromTextArea(document.getElementById("sourcecode_content"), {
					lineNumbers: true,
					matchBrackets: true,
					indentUnit: 4,
					readonly: true,
					mode: "text/x-csrc"
			});
	</script>
	<script>
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
</div>
<!-- nav_body -->

<?php
	echo '<!-- ';
	echo 'lab_classinfo<pre>'; print_r($lab_classinfo); echo '</pre>';
	echo 'class_info<pre>'; print_r($class_info); echo '</pre>';
	echo 'group_permission<pre>'; print_r($group_permission); echo '</pre>';
	echo 'lab_data<pre>'; print_r($lab_data); echo '</pre>';
	echo 'student_data<pre>'; print_r($student_data); echo '</pre>';
	echo ' -->';
?>