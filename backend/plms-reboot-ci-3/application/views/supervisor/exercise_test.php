<!-- nav_body -->
<div class="col-lg-10 col-md-10 col-sm-10 kpanel_body">

	<form action="<?php echo site_url('supervisor/add_exercise_action')?>" id="add_lab_exercise" method="post" name="what">
		<div class="row" style="display:inline;">
			<div class="form-group col-md-2">
				<label for="lab_chapter" hidden>Chapter</label>
				<select class="form-control" id="lab_chapter" name="lab_chapter" form="add_lab_exercise" value="" style="width:150px;">
					<option value="01">Chapter 01</option>
					<option value="02">Chapter 02</option>
					<option value="03">Chapter 03</option>
					<option value="04">Chapter 04</option>
					<option value="05">Chapter 05</option>
					<option value="06">Chapter 06</option>
					<option value="07">Chapter 07</option>
					<option value="08">Chapter 08</option>
					<option value="09">Chapter 09</option>
					<option value="10">Chapter 10</option>										
				</select>
			</div>

			<div class="form-group  col-md-2">
				<label for="lab_level" hidden>Level</label>
				<select class="form-control" id="lab_level" name="lab_level" form="add_lab_exercise" value="" style="width:200px;">
					<option value="00">Level-00 Undefined</option>

					<option value="01">Level-01 Basic</option>
					<option value="02">Level-02 Middle</option>
					<option value="03">Level-03 Intermediate</option>
					<option value="04">Level-04 Expert</option>
					<option value="05">Level-05 Professtional</option>
													
				</select>
			</div>

			<div class="form-group col-md-8" ">
				<label for="lab_name">lab name</label>
				<input type="text" name="lab_name" form="add_lab_exercise" style="width:300px;height:40px"></input>
			</div>
		</div>

		<textarea type="textarea" id="summernote" name="lab_content" form="add_lab_exercise" placeholder="Enter your text..."></textarea>
		<button type="submit" form="add_lab_exercise">Submit</button> 
	
	</form>

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

				placeholder: '. . .    พิมพ์รายละเอียด ของโจทย์ ที่นี่     ...',
				airmode: true
			});
    });
  </script>

  <script type="text/javascript">
	function checkSourceCode(){
		var sourceCodeName = document.getElementById("userfile").value;
		if(sourceCodeName==""){
			alert("คุณยังไม่ได้เลือกซอร์สโค้ดที่ต้องการส่ง");
			return false;
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
</div>