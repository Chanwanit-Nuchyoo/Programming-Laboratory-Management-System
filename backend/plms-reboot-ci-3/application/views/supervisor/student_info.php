<?php
	echo '<!-- ';
	echo 'lab_classinfo<pre>'; print_r($lab_classinfo); echo '</pre>';
	echo 'class_info<pre>'; print_r($class_info); echo '</pre>';
	echo 'group_permission<pre>'; print_r($group_permission); echo '</pre>';
	echo 'lab_data<pre>'; print_r($lab_data); echo '</pre>';
	echo 'student_data<pre>'; print_r($student_data); echo '</pre>';
	echo ' -->';
?>
<!-- nav_body -->
<div class="col-lg-10 col-md-10 col-sm-10" style="margin-top:100px;">
	<?php 
		$stu_id = $class_info['stu_id'];
		
	?>

	<div class="row">
		<div class="container">
			 <button type="button" class="btn btn-info btn-lg"  style="background-color:Tomato;margin:10px 10px;"><?php 
				echo $class_info['stu_id'].' : '. $class_info['stu_firstname'].' '.$class_info['stu_lastname'].' ';
				echo $class_info['stu_nickname'].'<br/>';
				echo 'กลุ่มที่: '.$class_info['group_no'].' - '.$class_info['group_name'];
			?></button>
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th style="text-align:center;">Chapter</th>
							<th style="text-align:center;">Title</th>
							<th style="text-align:center;">Status</th>
							<th style="text-align:center;">Full Mark</th>
							<th style="text-align:center;">Items</th>
							<th style="text-align:center;">Your mark</th>
						</tr>
					</thead>
					<tbody>
						<?php 
							$all_chapters_marking = 0;
							foreach ($group_permission as $row) {
								$chapter_id = $row['chapter_id']; 
								$chapter_name = $row['chapter_name'];
								$chapter_fullmark = $row['chapter_fullmark'];
								$chapter_mark = 0;
						?>
						<tr>
							<td style="text-align:center;">
								<?php echo $chapter_id; ?>
							</td>
							<td style="text-align:left; width-min:400px;width-max:600px;">
								<?php echo $chapter_name.' '; 
									if($row['allow_submit']=='no'  && $row['allow_access']=='yes')
										echo '<button type="button" class="btn btn-warning">ไม่สามารถส่งได้</button>';
								?>
							</td>

							<td style="text-align:center; ;width-max:600px;">
								<?php 
										
										if ($row['allow_access']=='yes')
											echo '<button class="btn btn-success btn-sm">'.' open '.'</button>';
										else
											echo '<button class="btn btn-danger btn-sm">'.' closed '.'</button>';

										
								?>
							</td>
							
							<td style="text-align:center;"><?php echo $chapter_fullmark; ?></td>

							<td>
								<?php
									$no_items=0;
									foreach( $lab_classinfo as $lab) {
										if($lab['chapter_id']==$chapter_id) {
											$no_items = $lab['no_items'];
											break;
										}
									}
									$count=1;

									foreach ($lab_data[$chapter_id] as $stu_lab_item) {
										//echo '<pre>';print_r($stu_lab_item);echo '</pre>';
								
										$item = $stu_lab_item['item_id'];
										$item_marking = $stu_lab_item['stu_lab']['marking'];
										$item_fullmark = $stu_lab_item['stu_lab']['full_mark'];
										$chapter_mark += $item_marking;

										echo '<a type="button" class="btn btn-default ';
										if ($row['allow_access']!="yes") 
											echo ' disabled "'; 
										else
											echo ' " ';
										if ($item_marking<$item_fullmark)
											echo 'style="background-color:Thistle ;"';
										else
											echo 'style="background-color:LightGreen ;"';
										echo 'href="'.site_url($_SESSION['role'].'/student_exercise_view/'.$stu_id.'/'.$chapter_id.'/'.$item).'" >';
										echo 'ข้อ '.$item.'<br/>'.$item_marking.'/'.$item_fullmark.'</a> ';
										/**/
										$count++;
										if($count>$no_items) {
											break;
										}

									}
								?>                               
                            </td>

							<td class="text-center">
								<?php echo $chapter_mark; 
									$all_chapters_marking += $chapter_mark;
								?>
							</td>
						</tr>
						
						<?php } ?>
						<tr>
							<td colspan="5" style="text-align:center;background-color:Plum;">Total Marking</td>
							<td style="text-align:center;background-color:Plum;"><?php echo $all_chapters_marking; ?></td>
							
						</tr>
					
								

						
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

