<!-- nav_body -->
<div class="col-lg-10 col-md-10 col-sm-10" style="margin-left:300px;margin-right:30px">
	<!--
	<?php echo "<pre>"; print_r($class_schedule); echo "</pre>"; ?>
	<?php echo "<pre>"; print_r($lab_status); echo "</pre>"; ?>
	<?php echo "<pre>"; print_r($lab_info); echo "</pre>"; ?>
	-->

	<div class="row">
		<div class="col-lg-12">
			<h2><?php 
				echo "กลุ่มที่ : ".$class_schedule['group_no'];
				?>
				<form id="student_add" method="post" action="<?php echo site_url('supervisor/student_add_action'); ?>" accept-charset="utf-8">
<textarea name="student_data" form="student_add" rows="50" cols="50" placeholder="Copy from excel and paste here . . . &#10 1 59581234 นายศัญญา สายันต์ &#10 2 56480012 นางสาวชุติมา อ้อมน้อย &#10 3 59580034 นายสุรศักดิ์ โคกหรรษา &#10 4 56481012 นางสาวเอื้อมดาว คว้ามาเชย &#10 . . ."></textarea><br />
					<input type="submit" form="student_add" value="submit"></input>
					<input type="text" form="student_add" name="group_id" value ="<?php echo $class_schedule['group_id']; ?>" hidden>

				</form>

			</div>
		</div>
	</div>
		
	

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