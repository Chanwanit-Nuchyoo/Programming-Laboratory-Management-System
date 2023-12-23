<!-- nav_body -->
<div class="col-lg-10 col-md-10 col-sm-10 kpanel_body" style="margin-left:300px;padding-top:40px;">
	<div class="row">
		<div class="col-lg-1">
		</div> 
		
		<div class="col-lg-10">
			<div class="panel panel-primary" style="min-width:800px;">
				<div class="panel-heading">
					 <div class="row">
						<div class="col-xs-1">
							<div> </div>
						</div>

						<div class="col-xs-7">
							<h2>Chapter : <?php echo $lab_chapter; ?> - item : <?php echo $lab_item ?> - <?php echo $lab_name; ?></h2>
						</div>
						
						<div class="col-xs-4">
							<button class="btn btn-info btn-lg">คะแนน : <?php echo $marking,' / ',$full_mark; ?></button>
							<p class="badge">ส่งมาแล้ว <?php echo $submitted_count; ?> ครั้ง</p>
						</div>						

					</div>
				</div>

				<div style="display:inline-block;"></div>

				<div class="panel-body">
					<p><?php echo $lab_content; ?></p>
				</div>
				<div class="panel-footer" style= "align:center;">
					<div style="font-family: Courier, monospace;font-style: normal;font-size: 16px;font-variant: normal;text-align: left; white-space:pre-wrap; width:770px; background-color:rgb(10,10,10); color:white; align:center;"><?php echo $output; ?>
					</div>
				</div>
				<!--
				<div class="panel-footer">
					<textarea style="font-family: Courier, monospace;font-style: normal;font-size: 16px;font-variant: normal;text-align: left; white-space:pre-wrap; width:680px; background-color:rgb(100,100,100); color:white;width:800px;height:400px;"><?php echo $output; ?></textarea>
				</div>
				-->
			</div>
		</div>
		<div class="col-lg-1">
		</div>
	</div>
	
	<div class="row">
		<form action="<?php echo site_url('student/exercise_submission'); ?>" method="post" accept-charset="utf-8" id="exercise_submission" enctype="multipart/form-data"  onsubmit="return checkSourceCode()" >
			<input type="hidden"	name="stu_id"		value="<?php echo $_SESSION['stu_id'];	?>" >
			<input type="hidden"	name="chapter_id"	value="<?php echo $lab_chapter;			?>" >
			<input type="hidden"	name="item_id"		value="<?php echo $lab_item;			?>" >
			<input type="hidden"	name="exercise_id"	value="<?php echo $exercise_id;			?>" >
			


			<?php	if($marking<$full_mark) {
						echo '<input type="file" name="submitted_file" id="userfile" onchange="validate_fileupload(this.value);">';
						echo '<span><button type="submit"   >Submit</button></span>';
					} else {
						echo '<button class="btn btn-success btn-lg " readonly> You have got full mark !!! </button>';
					}
			?>

		</form>
	</div>
	
</div>

  

  <script type="text/javascript">
	function checkSourceCode(){
		//alert("checking source code");

		var sourceCode = document.getElementById("userfile");
		var sourceCodeName = sourceCode.value;
		
		if(sourceCodeName==""){
			alert("คุณยังไม่ได้เลือกซอร์สโค้ดที่ต้องการส่ง");
			return false;
		}
		var extension = sourceCodeName.split(".");
		if(extension[1]!=document.getElementById("id_extension").value) {
			alert("อนุญาตให้ส่งไฟล์สกุล ."+document.getElementById("id_extension").value+"เท่านั้น");
			return false;
		}
		/*
		var fileName = extension[0].split('\\');
		if(/^[a-zA-Z0-9]+/.test(fileName[2]) == true) {
			
		} else {
			alert("ชื่อไฟล์สามารถประกอบด้วย a-z,A-Z,0-9 เท่านั้น");
			return false;
		}
		
		var soruceCodeFileSize = parseInt(sourceCode.files[0].size);
		if (sourceCodeFileSize > 4096) {
			alert("File size is too big : "+sourceCodeFileSize+" bytes.");
			return false;
		}
		*/
		alert("File name : "+sourceCodeName+" "+soruceCodeFileSize);
	}
	function validate_fileupload(fileName)
	{
		/*
		var allowed_extensions = new Array("jpg","png","gif");
		var file_extension = fileName.split('.').pop().toLowerCase(); // split function will split the filename by dot(.), and pop function will pop the last element from the array which will give you the extension as well. If there will be no extension then it will return the filename.

		for(var i = 0; i <= allowed_extensions.length; i++)
		{
			if(allowed_extensions[i]==file_extension)
			{
				return true; // valid file extension
			}
		}
		*/
		return filename.trim().endswitch("py");

		
	}

	
	</script>
