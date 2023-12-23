
<!--- last submit -->
<div class="row">
	<div class="container">
		<div class="panel panel-success" style="min-width:800px;text-align:left">
			<div class="panel-heading">
				 <div class="row">
					 <div class="col-xs-8 text-left">							
						<h2 style="color:blue;">Last submission :   </span></h2>
					</div>
					<div class="col-xs-4">
						<?php 
							if ($status == 'passed')
								echo '<h1 style="color:green;"><span class="glyphicon glyphicon-ok pull-right"></span> </h1>';
							else
								echo '<h1 style="color:red;"><span class="glyphicon glyphicon-remove pull-right"></span> </h1>';
						?>
					</div>		
				</div>
			</div>

			<div style="display:inline-block;"></div>

			<div class="panel-body" style="text-align:left;">
				<textarea id="sourcecode_content" class="CodeMirror" style="text-align:left;" readonly><?php echo $sourcecode_content; ?></textarea>
			</div>				
			
		</div>
	</div>
</div>
<!--- last submit -->


<!--- Testcase -->
<?php
	$count=0;
	echo "<h1> Number of testcase : $num_of_testcase</h1>";
	//echo "<h1><pre>"; print_r($testcase_array); echo"</pre></h1>";
	for($testcase_count = 0; $testcase_count < $num_of_testcase; $testcase_count++) {
		
		$testcase_row = $testcase_array[$testcase_count];
		$action = 'exercise_submission_testcase';

		if ($testcase_row['active']=="yes"  ) {
			$count++;
			$num_rows = strlen($testcase_row['output_to_show']);
			$num_rows = ceil($num_rows/80);
			$output = $testcase_row['output_to_show'];
			for($i=0; $i<strlen($output); $i++) {
				if ($output[$i]=="\n")
					$num_rows++;
			}
			

			$testcase_html ='	
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading " style="font-size:24px;color:blue;">Testcase student: #';
				$testcase_html .= $count.'/'.$num_of_testcase.' ';			
				
				$testcase_html .= '
				<span style="font-size:20px;color:blue;">';
					$testcase_html .= $testcase_row['testcase_note'];		
					$testcase_html .= '
				</span>';
				if ($testcase_row['item_pass'] == 'yes') {
					$testcase_html .= '<div style="color:green;" class="glyphicon glyphicon-ok pull-right"></div>';
				} else {
					$testcase_html .= '<div style="color:red;" class="glyphicon glyphicon-remove pull-right"></div>';
				}
				$testcase_html .= '
			</div>';

				
				if ($testcase_row['show_to_student'] == 'yes') {
			$testcase_html .= '	
			<div class="panel-body">
				<div class="row">
					<div class="col-md-6">
						<div  style="font-family: Courier;font-size: 16px;border:2px blue;">';
							$testcase_html .= '<code><textarea class="testcase testcase-sample" cols="80" rows="';
							$testcase_html .= $num_rows+2;
							$testcase_html .= '" readonly>';
							$testcase_html .= $testcase_row['testcase_output'];
							$testcase_html .='</textarea></code>'; 
							$testcase_html .= '
						</div>
					</div>
					<div class="col-md-6">
						<div  style="border:2px blue;">';
							$testcase_html .= '<code><textarea class="testcase testcase-student" cols="80" rows="';
							$testcase_html .= $num_rows+2;
							$testcase_html .= '" readonly>';
							$testcase_html .= $testcase_row['output_to_show'];
							//$testcase_html .= $testcase_row['testcase_output'];
							$testcase_html .='</textarea></code>'; 
							$testcase_html .= '
						</div>
					</div>
				</div>
			</div>';
				} else {
					$testcase_html .= '	
			<div class="panel-body">
				<div class="row">
					<div class="col-md-12" style="color:red;font-size:200%;text-align:center;">This testcase is hidden.</div>
				</div>
			</div>';
				}
			$testcase_html .='
		</div>
	</div>';
	$testcase_html .= '	
</div>';
echo $testcase_html;

		}
		

		if(isset($testcase_array[$testcase_count+1])) {
			$testcase_row = $testcase_array[$testcase_count];

			if($testcase_row['item_pass']=='no')
				break;
		}
		
	}
?>
<?php
	 echo '<!-- '.$exercise_id;
	echo ' num_of_testcase:'. $num_of_testcase.'<br/>';
	echo 'testcase_array : <pre>'; print_r($testcase_array); echo '</pre>';
	if(isset($last_submit))
		echo 'last_submit : <pre>'; print_r($last_submit); echo '</pre>';
	echo ' status: '.$status.' -->'; 
?>
<!--- Testcase End -->


	
	<script>
		var editor = CodeMirror.fromTextArea(document.getElementById("sourcecode_content"), {
					lineNumbers: true,
					matchBrackets: true,
					indentUnit: 4,
					readonly: true,
					mode: "text/python"
			});
	</script>
			



