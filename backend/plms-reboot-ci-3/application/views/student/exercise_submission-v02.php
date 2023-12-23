<!-- nav_body -->
<div class="col-lg-10 col-md-10 col-sm-10 kpanel_body" style="margin-left:300px">
	
	<div class="row" style="display:inline;">	
		<div>
			<div class="form-group col-md-2">
				<label >Chapter : <?php echo $lab_content['lab_chapter']; ?></label>
				
			</div>
			<div class="form-group col-md-2">
				<label >Item : <?php echo $_SESSION['lab_item']; ?></label>				
			</div>

			<div class="form-group col-md-2">
				<label >Name : <?php echo $lab_content['lab_name']; ?></label>				
			</div>

			
		</div>
	</div>
	<div>
		<div class="row">
			<div class="panel panel-default" style="margin-left:100px;">
				<div class="panel-body">
				<?php echo $lab_content['lab_content']; ?>
				</div>				
			</div>			
		</div>
		<div class="row">
			<div class="panel panel-default" style="margin-left:100px;">
				<div class="panel-head" >
					<code style="text-align:left;width:880px;background-color:lightblue;foreground-color:white;">
						<pre style="text-align:left;width:880px;background-color:black;foreground-color:white;color:blue;">
							123456
						</pre>
					</code>
				</div>
				<div class="panel-body" >
					<code style="text-align:left;width:880px;background-color:gray;foreground-color:white;">
						<pre style="text-align:left;width:880px;background-color:gray;foreground-color:white;color:blue;">
							<?php echo $output; ?>
						</pre>
					</code>
				</div>				
			</div>
		</div>
		<div class="col-lg-6">
		<div class="panel panel-primary">
			<div class="panel-heading">
				Chapter : <?php echo $lab_content['lab_chapter']; ?> - item : <?php echo $_SESSION['lab_item'] ?> - <?php echo $lab_content['lab_name']; ?>
			</div>
			<div class="panel-body">
				<p><?php echo $lab_content['lab_content']; ?></p>
			</div>
			<div class="panel-footer">
				<pre>
				
					<!-- <code style="text-align:left;"> -->
						<?php echo $output; ?>
					<!-- </code> -->
				
				</pre>
			</div>
			</div>
		</div>
		<form>
			
			<button type="submit" form="add_lab_exercise">Submit</button> 
		</form>
	</div>

  

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