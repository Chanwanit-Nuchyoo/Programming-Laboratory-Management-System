<!-- nav_body -->
<div class="col-lg-10 col-md-10 col-sm-10" style="margin-left:300px;margin-right:30px">
	

	<div class="row">
		<div class="col-lg-10">
			<h2>Exercise list for all chapters.</h2>
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th style="text-align:center;">Chapter</th>
							<th style="text-align:center;">Title</th>
							<th style="text-align:center;">Full Mark</th>
							<th style="text-align:center;">Points</th>
							<th style="text-align:center;">Submit</th>
						</tr>
					</thead>
					<tbody>
						<?php 
							$count=1; 
							
							foreach ($lab_classinfo->result() as $row) { 
								echo '<tr>';
								echo '<td>';
								echo	$row->chapter_id; 
								echo '</td>';

								echo '<td>';
								echo	$row->chapter_name; 
								echo '</td>';

								echo '<td>';
								echo	$row->chapter_fullmark; 
								echo '</td>';

								echo '<td>';								
								echo	'0';							
								echo '</td>';
							
								echo '<td>'; 
								echo	'<div class="dropdown">';
								echo		'<button class="btn btn-info dropdown-toggle" data-toggle="dropdown" type="button" title="Exercise Mangement"> Items ';
								echo		'<span class="caret"></span></button>';
								echo		'<ul class="dropdown-menu">';
								echo			'<li> <a href="#"> Item 1 </a> </li>';
								echo			'<li class="divider"></li>';
								echo			'<li> <a href="#"> Item 2 </a> </li>';							
								echo		'</ul>';
								echo	'</div>';
								echo '</td>';
								echo '</tr>';						
								$count++; 
							} 
						?>

						
					</tbody>
				</table>
			</div>
		</div>
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
</div>
<!-- nav_body -->