
<!-- Output -->
	
	<div class="row" style="">
		<div class="container">
		<div class="panel panel-success" style="">
			<h3>Output : </h3>
			<!-- <div style="font-family: Courier, monospace;font-style: normal;font-size: 16px;font-variant: normal;text-align: left; white-space:pre-wrap; width:770px; background-color:rgb(100,100,100); color:white; align:center;" ></div>20/1/2560 -->
			<div  style="font-family: Courier;font-size: 16px;border:2px blue;">
			<?php echo '<code><textarea cols="80" rows="25" style="background:black;color:white;">'.$sourcecode_output.'</textarea></code>'; ?>
			</div>
				
		
		</div>
		</div>
		<div>
			<button class="btn btn-lg" type="submit" form="testcase_add" >Add Test Case</button>
			<form method="post" id="testcase_add" name="testcase_add" action="<?php echo site_url('supervisor/exercise_testcase_add'); ?>">
				<input type="text" form="testcase_add" hidden name="exercise_id" value="<?php echo $exercise_id; ?>" ></input>
			</form>
		</div>
	</div>
<!-- Output -->


		

	