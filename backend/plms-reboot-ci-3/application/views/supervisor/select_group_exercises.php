<!-- nav_body -->
<div class="col-lg-10 col-md-10 col-sm-10" style="">
	

	<div class="row" >
		<div class="panel panel-default">
			<div class="panel-body" style="color:blue;margin-right:5px;">Group : <?php 
				echo $class_schedule['group_no'].' '. $class_schedule['day_of_week'] . ' ';
				echo $class_schedule['time_start']. ' - '.$class_schedule['time_end'];
				echo ' Year : '.$class_schedule['year'].'/'. $class_schedule['semester']; ?>
			</div>
			<span><h2 style="color:blue;">Chapter : <?php echo $lab_no; ?></h2></span>
		</div>				
	</div>

	<div class="panel panel-default">
		<div class="panel-body">A Basic Panel</div>
	</div>

	<div class="row">
		<div class="col-md-12 col-lg-12">
			<div class="table-responsive">
				<table class="table table-bordered table-hover" id="myTable">
					<thead>
						<tr>
							<th>NO.</th>
							<th>Chapter</th>
							<th>Level</th>
							<th>Name</th>
							<th style="width-max:400px;">Content</th>
							
						</tr>
					</thead>
					<tbody>
						
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="row" style="margin-bottom:20px;">
		
	</div>
	
	

	<script>
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
	</script>
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
</div>
<!-- nav_body -->