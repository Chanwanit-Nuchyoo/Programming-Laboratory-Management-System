<!-- nav_body -->
<div class="col-lg-10 col-md-10 col-sm-10" style="margin-left:0px;margin-right:0px">
	<?php
		echo '<!--<pre>';print_r($lab_info);echo '</pre>-->';
		$num_chapters = sizeof($lab_info);
	?>
	<div class="container-fulid" style="background-color:PaleGoldenRod ;">
		<div class="row" >
			<div class="col-md-4 col-lg-2">
				<h2 style="color:blue;"></h2>
			</div>

			<div class="col-md-4 col-lg-2">
				<h2 style="color:blue;">Exercise list</h2>
			</div>

			<div class="col-md-3 col-lg-3">		
				<h2 style="color:blue;">
					<select id="chapter" onchange="chapterLevelFilter()" >
						<?php
							for($chapter=0;$chapter<=$num_chapters;$chapter++) {
								if($chapter==0) {
									echo '<option value="00">All Chapters</option>';
								} else if($chapter<10){
									echo '<option value="0'.$chapter.'"> Chapter '.$chapter.' </option>';
								} else {
									echo '<option value="'.$chapter.'"> Chapter '.$chapter.' </option>';
								}
							}
						?>
					
					</select>
				</h2>
			</div>
		

			<div class="col-md-3 col-lg-3">		
				<h2 style="color:blue;">
					<select id="level" onchange="chapterLevelFilter()">
						<option value="00"> All Levels </option>
						<option value="01"> Level 1 </option>
						<option value="02"> Level 2 </option>
						<option value="03"> Level 3 </option>
						<option value="04"> Level 4 </option>
						<option value="05"> Level 5 </option>				
					</select>
				</h2>
			</div>
			<div class="col-md-2 col-lg-2">	
				<h2 style="color:blue;">
					<button>123456789</button>
				</h2>
			</div>
		</div>
		<div class="row"> 
			<div class="col-md-3"></div>
			<div class="col-md-8" style="color:Blue;background-color:PaleGoldenRod ;">TIP! Sort multiple columns simultaneously by holding down the shift key and clicking a second, third or even fourth column header !...</div>
			<div class="col-md-1"></div>
		</div>
	</div>

	
	<div class="row">
	<div class="container-fluid;">
		<div class="col-md-12 col-lg-12">
			<div class="table-responsive">
				<!--<table class="table table-bordered table-hover tablesorter"  id="myTable" >-->
				<table class="table table-bordered table-hover tablesorter"  id="myTable" >
					<thead>
						<tr>
							<th style="text-align:center">NO.</th>
							<th style="text-align:center">Chapter</th>
							<th style="text-align:center">Level</th>
							<th style="text-align:center">Name</th>
							<th style="width-max:400px;text-align:center">Content</th>
							<th style="text-align:center"> View </th>
							<th style="text-align:center">Edit</th>
							
						</tr>
					</thead>
					<tbody>
						<?php $count=1; ?>
						<tr>
							<?php foreach ($query->result() as $row) { ?>
							<td style="text-align:center"> <?php echo $count; ?></td>
							
							<td style="text-align:center"><?php echo $row->lab_chapter; ?></td>
							
							<td style="text-align:center"><?php echo $row->lab_level; ?></td>

							<td style="text-align:center"><?php echo $row->lab_name; ?></td>

							<td><p class="summernote" id="summernote" type="textarea" name="lab_content" "><?php echo htmlspecialchars_decode($row->lab_content); ?></p></td>
							
							<td style="text-align:center"> 
								<form action="<?php echo site_url('supervisor/exercise_view1')?>" method="post" >
									<button type="submit" class="btn btn-info"> View </button>
									<input type="text" name="exercise_id" hidden value="<?php echo  $row->exercise_id; ?>" >					
								</form>
							</td>

							<td style="text-align:center"> 
								<form action="<?php echo site_url('supervisor/exercise_edit')?>" id="exercise_edit" method="post" name="exercise_edit">
									<button type="submit" class="btn btn-primary" 
										<?php 
											if($_SESSION['username'] != $row->added_by) 
												echo "hidden";
										?>
									>Edit</button>
									<input type="text" name="exercise_id" hidden value="<?php echo  $row->exercise_id; ?>" >
							
								</form>
							</td>

							<!--<td> 
								<form action="<?php echo site_url('supervisor/exercise_remove')?>" id="exercise_remove" method="post" name="exercise_remove">
									<button type="submit" class="btn btn-warning" 
										<?php 
											if($_SESSION['username'] != $row->added_by) 
												echo "hidden";
										?>
									>Remove</button>
									<input type="text" name="exercise_id" hidden value="<?php echo  $row->exercise_id; ?>" >
							
								</form>
							</td>
							-->
						</tr>						
						<?php $count++; } ?>

						
					</tbody>
				</table>
			</div>
		</div>
	</div>
	</div>
	<div class="row" style="margin-bottom:20px;">
		<div class="container" style="background-color:DarkSalmon;">
			<div class="row" style="margin-top:20px;margin-bottom:20px;">

			<form action="<?php echo site_url('supervisor/exercise_add_v2')?>" method="post" >
				<div class="col-md-3" style="text-align:center;">
					<select name="lab_chapter" value="" style="width:200px;">
						<!--<option value="00">Chapter 00</option>
						<option value="01">Chapter 01</option>
						<option value="02">Chapter 02</option>
						<option value="03">Chapter 03</option>
						<option value="04">Chapter 04</option>
						<option value="05">Chapter 05</option>
						<option value="06">Chapter 06</option>
						<option value="07">Chapter 07</option>
						<option value="08">Chapter 08</option>
						<option value="09">Chapter 09</option>
						<option value="10">Chapter 10</option>		-->
						<?php
							foreach($lab_info as $lab) {
								echo '<option value="'.$lab['chapter_id'].'"> Chapter '.$lab['chapter_id'].' '.$lab['chapter_name'].' </option>';
							}
						?>
					</select>
				</div>
				<div class="col-md-3">
					<select name="lab_level" value="" style="width:200px;">
						<option value="00">Level-00 Undefined</option>
						<option value="01">Level-01 Basic</option>
						<option value="02">Level-02 Middle</option>
						<option value="03">Level-03 Intermediate</option>
						<option value="04">Level-04 Expert</option>
						<option value="05">Level-05 Professtional</option>													
					</select>
				</div>
				<div class="col-md-3">
					<div>Testcase: </div>
					 <input type="radio" name="testcase" value="yes"> Yes </input>
					  <input type="radio" name="testcase" value="no" checked> No </input>					
				</div>
				<div class="col-md-3">
					<input type="text" name="user_id" hidden value="<?php echo  $_SESSION['id']; ?>" >
					<button type="submit" class="btn btn-warning" style="background-color:DeepPink;"> Add Exercise </button>
				</div>
			</form>
		</div>
	</div>
<!-- -->	
	

	<!--<script>
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
	</script>-->

	<script>
		function chapterLevelFilter() {
			
			var chapter, level, table, tr, td_chapter, td_level, i,count;
			chapter = Number(document.getElementById("chapter").value);
			level	= Number(document.getElementById("level").value);
			table = document.getElementById("myTable");
			tr = table.getElementsByTagName("tr");
			
			for (i = 1,count=1; i < tr.length; i++) {
				td_count = tr[i].getElementsByTagName("td")[0];
				td_chapter = Number(tr[i].getElementsByTagName("td")[1].innerHTML);
				td_level   = Number(tr[i].getElementsByTagName("td")[2].innerHTML);

				if ( (td_chapter == chapter || chapter == 0)   &&  (td_level == level || level ==0) ) {
					//alert('condition 1:');
					tr[i].style.display = "";
					td_count.innerHTML = count;
					count++;
				} else {
					//alert('condition 4:');
					tr[i].style.display = "none";
				}				
			}			
		}
	</script>

	<script>
		$(document).ready(function() 
			{ 
				$("#myTable").tablesorter(); 
			}); 
    
	</script>
	
</div>
<!-- nav_body -->