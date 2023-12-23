<!-- nav_body -->
<div class="col-lg-10 col-md-10 col-sm-10 "><div class="container-fluid">
	<?php
            /*
			
            $full_mark			= $lab_exercise['lab_2b_edit']['full_mark'];
            $added_date			= $lab_exercise['lab_2b_edit']['added_date'];
            $added_by			=$lab_exercise['added_by'];
            $lab_constrain		= $lab_exercise['lab_constrain'];
			*/
			
			$lab_chapter		= $lab_exercise['lab_chapter'];
			$lab_level			= $lab_exercise['lab_level']; 
			$lab_content		= htmlspecialchars_decode($lab_exercise['lab_content']);
			$lab_name			= $lab_exercise['lab_name'];
			$testcase			= $lab_exercise['testcase'];
			$sourcecode_name	= $lab_exercise['sourcecode'];
			$sourcecode_content	= $lab_exercise['sourcecode_content'];
			$created_by			= $lab_exercise['created_by'];
			$user_id			= $_SESSION['id'];
			$sourcecode_output	= $lab_exercise['sourcecode_output'];
			$exercise_id		= $lab_exercise['exercise_id'];
			

    ?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-4" style="text-align:center;margin-top:20px;">
				<div class="well">
					<h2 style="color:blue;">Chapter : <?php echo $lab_chapter; ?> Level : <?php echo $lab_level;?></h2>
				</div>				
			</div>
			
			<div class="col-sm-6">
				<div class="well" style="margin-top:20px;">
					<h3 style="color:blue;"> Lab name : <?php echo $lab_name; ?></h3>
				</div>
			</div>
			<div class="col-sm-2">
				<div class="well" style="margin-top:20px;">
					<form method="post" action="<?php echo site_url('supervisor/exercise_edit'); ?>" >
						<input type="text" name="exercise_id" value="<?php echo $exercise_id ?>" hidden >
						<button type="button submit" class="btn btn-primary" <?php
							if ($user_id == $created_by || $_SESSION['username']=='kanut') {
								echo ' > Edit ';
							} else {
								echo ' disabled > NO edit ';
							}					
						?>
						</button>
					</form>

				</div>
			</div>
		</div>

		
		<div class="row" >
			<div class="container" >
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 >CONTENT : </h3>
					</div>
					<div class="panel-body"  style="backgroud:AliceBlue ;">
						<div id="summernote2" type="textarea"  rows="10" cols="60" readonly><?php echo $lab_content; ?></div>
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="panel panel-default">
					
					<div class="panel-footer" style="text-align:left;tab-size:4; font-family: Courier;">
						<?php
							$lines_of_sourcecode = substr_count($sourcecode_content, "\n" )+4;
						?>
						<textarea readonly class="sourcecode_content" cols="120" rows="<?php echo $lines_of_sourcecode; ?>" id="sourcecode_content" name="sourcecode_content" ><?php echo $sourcecode_content; ?></textarea>
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 style="text-align:center;"> -- output -- </h3>						
					</div>
					<div class="panel-body">
						<?php
							if ($testcase == "no_input" || $testcase == "undefined")  { //ไม่มี testcase
								echo '
						<div>
							<div style="font-family: Courier, monospace;font-style: normal;font-size: 16px;font-variant: normal;text-align: left; white-space:pre-wrap; width:770px; background-color:rgb(100,100,100); color:white; text-align:center;" ></div>
							<div  style="font-family: Courier;font-size: 16px;border:2px blue;">
										';
								echo '<code><textarea cols="80" rows="25" style="background:black;color:white; readonly">';		
								echo $sourcecode_output.'</textarea></code>'; 
								echo '
							</div>
						</div>
									';
							} else {
								
								foreach ($testcase as $row) {
									$lines = substr_count( $row['testcase_output'], "\n" )+2;
									echo '
						<div>
							<div style="font-family: Courier, monospace;font-style: normal;font-size: 16px;font-variant: normal;text-align: left; white-space:pre-wrap; width:770px; background-color:rgb(100,100,100); color:white; text-align:center;" ></div>
							<div  style="font-family: Courier;font-size: 16px;border:2px blue;">
										';
										 
									echo '<code><textarea cols="80" rows="'.$lines.'" style="background:black;color:white;">';		
									echo $row['testcase_output'].'</textarea></code>'; 
									echo '
							</div>
						</div>
										';
										
								}
							} 
						?>
					</div>					
				</div>
			</div>
		</div>

		<div class="row">
			<?php //echo '<pre>';print_r($lab_exercise); echo '</pre>' ?>
			<?php //echo '<pre>';print_r($_SESSION); echo '</pre>' ?>
		</div>
		
	<!-- ย้ายไป header
	<script src="<?php echo base_url('assets/jquery/jquery-3.1.1.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/bootstrap-3.3.7/js/bootstrap.min.js') ?>"></script>	
	-->
	<script src="<?php echo base_url('assets/summernote/summernote.js') ?>"></script>	
	<script type="text/javascript" src="<?php echo base_url('assets/codemirror-5.22.0/lib/codemirror.js')?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/codemirror-5.22.0/mode/clike/clike.js')?>"></script>
	<!-- <script type="text/javascript" src="<?php echo base_url('assets/codemirror-5.22.0/mode/xml/xml.js')?>"></script> -->
	<!-- <script type="text/javascript" src="<?php echo base_url('assets/codemirror-5.22.0/formatting.js')?>"></script> -->
	<script>
		$(document).ready(function() {
			$('#summernote').summernote({
						
					toolbar: [
								// [groupName, [list of button]]
								['fontname', ['fontname']],
								['fontsize', ['fontsize']],
								['style', ['bold', 'italic', 'underline', 'clear']],
								['font', ['strikethrough', 'superscript', 'subscript']],
								
								['color', ['color']],
								['para', ['ul', 'ol', 'paragraph']],
								['height', ['height']]
							  ],
					height: 300,                 // set editor height
					width: 768,
					minHeight: null,             // set minimum height of editor
					maxHeight: null,             // set maximum height of editor
					focus: true,                  // set focus to editable area after initializing summernote

					//placeholder: '123',
					airmode: true
				});
			//$(document).getElementById('summernote').innerHTML=lab_content;
			
		});
	</script>

	<script>
		$(document).ready(function() {
		  $('.summernote').summernote();
		});
		var postForm = function() {
				var content = $('textarea[name="lab_content"]').html($('#summernote').code());
		}
	</script>

	<script type="text/javascript">
		function checkSourceCode(){
			var sourceCodeName = document.getElementById("userfile").value;
			if(sourceCodeName==""){
				alert("ไม่มี New Source Code");
				return true;
			}
			var extension = sourceCodeName.split(".");
			var fileName = extension[0].split('\\');
			if(/^[a-zA-Z0-9]+/.test(fileName[2]) == true)
			{

			}
			else{
				alert("ชื่อไฟล์สามารถประกอบด้วย a-z,A-Z,0-9 เท่านั้น");
				return false;
			}
			if(extension[1]!=document.getElementById("id_extension").value){
				alert("อนุญาตให้ส่งไฟล์สกุล ."+document.getElementById("id_extension").value+"เท่านั้น");
				return false;
			}
		}
	</script>
	<script>
		var editor = CodeMirror.fromTextArea(document.getElementById("sourcecode_content"), {
					lineNumbers: true,
					matchBrackets: true,
					indentUnit: 4,
					readonly: true,
					mode: "text/x-csrc"
			});
	</script>
	

</div>

