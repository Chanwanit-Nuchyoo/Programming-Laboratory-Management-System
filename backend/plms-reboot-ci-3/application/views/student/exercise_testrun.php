<!-- nav_body -->
<div class="col-lg-10 col-md-10 col-sm-10 kpanel_body" style="margin-left:300px;padding-top:40px;">
	<div class="row">
		<div class="col-lg-1">
		</div> 
		
		<div class="col-lg-10">
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
					<textarea id="sourcecode_content_testrun" style="text-align:left;" readonly><?php echo $sourcecode_content; ?></textarea>
				</div>
				<div class="panel-footer" style= "align:center;">
					<div style="font-family: Courier, monospace;font-style: normal;font-size: 16px;font-variant: normal;text-align: left; white-space:pre-wrap; width:770px; background-color:rgb(10,10,10); color:white; align:center;"><?php echo $sourcecode_output; ?>
					</div>
				</div>
				
			</div>
		</div>
		<div class="col-lg-1">
		</div>
	</div>
	
	
</div>
	<script type="text/javascript" src="<?php echo base_url('assets/codemirror-5.22.0/lib/codemirror.js')   ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/codemirror-5.22.0/mode/clike/clike.js') ?>"></script>
	<script>
		var testrun_output = CodeMirror.fromTextArea(document.getElementById("sourcecode_content_testrun"), {
					lineNumbers: true,
					tabSize:		4,
					matchBrackets: true,
					readOnly:		true,
					mode: "text/python"
			});
	</script>
  

