<!-- nav_body -->
<div class="col-sm-10 text-center"> 	
	<h1>Welcome to Computer Programming</h1>
	<h3>The heart concept is "Learning by doing"</h3>
	<video width="852" height="480" controls>
		<source src="<?php echo base_url('assets/video/how_2b_a_good_programmer.mp4')?>"> type="video/mp4">
		<source src="movie.ogg" type="video/ogg"> Your browser does not support the video tag.
	</video>
	<div class="container">
	<h3>Available Groups :</h3>
	<div class="table-responsive">          
		<table class="table" style="text-align:center;">
			<tr>
				<th style="text-align:center;">รหัสกลุ่ม</th>
				<th style="text-align:center;">กลุ่มที่</th>
				<th style="text-align:center;">ปีการศึกษา</th>
				<th style="text-align:center;">เทอม</th>
				<th style="text-align:center;">ชื่อ</th>
				<th style="text-align:center;">วัน</th>
				<th style="text-align:center;">เวลา</th>
				<th  style="text-align:center;">จำนวนนักศึกษา</th></tr>
<?php 
	foreach ($class_schedule as $data) {
		echo "<tr>";
		echo "<td>".$data['group_id']."</td>";
		echo "<td>".$data['group_no']."</td>";
		echo "<td>".$data['year']."</td>";
		echo "<td>".$data['semester']."</td>";
		echo "<td>".$data['group_name']."</td>";
		echo "<td>".$data['day_of_week']."</td>";
		echo "<td>".$data['time_start']." - ".$data['time_end'];
		echo "</td><td>".$data['num_students']."</td>";
		echo "</tr>";
	}
?>
		</table>
	</div>
	</div>


</div><!-- <div class="col-sm-10 text-center"> -->
<!-- /nav_body -->
<!-- <?php echo 'class_schedule : <pre>'; print_r($class_schedule); echo '</pre>'; ?> -->

