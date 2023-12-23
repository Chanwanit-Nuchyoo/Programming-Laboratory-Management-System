<!-- nav_body -->
<div class="col-lg-10 col-md-10 col-sm-10" style="">
	

	<div class="container-fluid" style="margin-top:20px;">
		<div class="well" style="text-align: ;color:Blue;background-color:Cornsilk;">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div style="font-size:300% ;color:Blue;background-color:Cornsilk;">Getting server updates</div><a href=<?php echo '"'.site_url('supervisor/process_show/').'"'; ?>  class="btn btn-info pull-right" role="button">Refresh</a>
				</div>
				<div class="panel-body">
					<table class="table" id="showProcess">
						<?php 
							//echo $processes;
							$line_no =1;
							$pid=99999;
							
							echo '<thead><tr><th>NO.</th>';
							echo "<th>User</th>";
							echo "<th>PID</th>";
							echo "<th>%CPU</th>";
							echo "<th>%MEM</th>";
							echo "<th>VSZ</th>";
							echo "<th>TTY</th>";
							echo "<th>RSS</th>";
							echo "<th>STAT</th>";
							echo "<th>Start</th>";
							echo "<th>Time</th>";
							echo "<th>Command</th>";
							echo "<th>Kill Process</th>";
							echo '</tr></thead><tbody>';
								
							foreach ($process as $p) {
								if ($p['user']!='daemon')
									continue;
								if (substr($p['command'],0,12) != 'student_data')
									continue;
								echo '<tr><td>'.$line_no.'</td>';								
								echo "<td>".$p['user']."</td>";
								echo "<td>".$p['pid']."</td>";
								echo "<td>".$p['cpu']."</td>";
								echo "<td>".$p['mem']."</td>";
								echo "<td>".$p['vsz']."</td>";
								echo "<td>".$p['tty']."</td>";
								echo "<td>".$p['rss']."</td>";
								echo "<td>".$p['stat']."</td>";
								echo "<td>".$p['start']."</td>";
								echo "<td>".$p['time']."</td>";
								echo "<td>".$p['command']."</td>";								
								echo "<td>";
								echo "	<form method='post' formtarget='_blank' action=".site_url('supervisor/process_kill/').'" >';
								echo "		<button type='submit'  >";								
								echo "Kill Process<br/>".$p['pid']."</button>";
								echo "		<input type='text' name='pid' hidden value='".$p['pid']."' ></input>";
								echo "		<input type='text' name='command' hidden value='".$p['command']."' ></input>";
								echo " </form>";
								echo "</td></tr>";
							
								$line_no++;
							}
							echo '</tbody>';
						?>
					</table>
					

					<!--<?php 
						//echo $processes;
						foreach(preg_split("/((\r?\n)|(\r\n?))/", $processes) as $line){
							// do stuff with $line
							echo $line.'<br/>';
						} 
						//echo '<pre>';print_r($processes); echo '</pre>'; 
					?>-->
				</div>
		</div>
	</div>
			
</div>
<script>
	if(typeof(EventSource) !== "undefined") {
		var source = new EventSource("demo_sse");
		source.onmessage = function(event) {
			document.getElementById("result").innerHTML = event.data + "<br>";
		};
	} else {
		document.getElementById("result").innerHTML = "Sorry, your browser does not support server-sent events...";
	}
</script>

<script>
		$(document).ready(function() { 
					$("#showProcess").tablesorter(); 
				} 
			); 
	</script>
<!-- nav_body -->