
<!-- nav_body -->
<!--<div class="row">			
				<p><?php echo "student_data : <pre> ";print_r($student_data);echo "</pre>"; ?></p>
	</div>-->
<div class="col-lg-10 col-md-10 col-sm-10" style="margin-top:100px;"> 	
	<div class="container-fluid" style="padding-top:10; blackground-color:yellow;margin-top:20px">
  		<div class="row">
			<div class="col-sm-8">
				<div class="panel panel-default" style="background-color:AliceBlue;">
					<h2> <button type="button" class="btn btn-lg btn-info"><?php echo $student_data['stu_id']; ?></button> Edit Profile </h2>
				</div>
			</div>
			<div class="col-sm-4">
				<?php 
					$error = $this->session->flashdata("error");
					$status = $this->session->flashdata("status"); 
					if($error) {
						$tag="alert-danger";
						$message=$error;

					} else if($status) {
						$tag="alert-success";
						$message=$status;
					} else {
						$tag="alert-info";
						$message='Enter your current password';
					}
				?>
				<div class="alert <?php echo $tag ?> alert-dismissible" role="alert">
  					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  					<?php echo $message;  ?>
  				</div>
			</div>

		</div>

		<div class="row">  
			<!-- left panel -->
			<div class="col-xs-4">
				<div class="panel panel-default" style="background-color:AliceBlue;">
					<div class="panel-header">
						<h3>Personal Information</h3>
					</div>

					<div class="panel-body">
						<form class="form-inline">
							<div class="form-group">
								<label>
									<div class="radio-inline">
										<input form="student_editprofile_form" type="radio" name="stu_gender" value="male" <?php if($student_data['stu_gender']=="male") echo "checked"; ?>> Male</input>
									</div>
								</label>
							</div>

							<div class="form-group">
								<label>
									<div class="radio-inline">
										<input form="student_editprofile_form" type="radio" name="stu_gender" value="female" <?php if($student_data['stu_gender']=="female") echo "checked"; ?> > Female</input>
									</div>
								</label>
							</div>

							<div class="form-group">
								<label>
									<div class="radio-inline">
										<input form="student_editprofile_form" type="radio" name="stu_gender" value="other" <?php if($student_data['stu_gender']=="other") echo "checked"; ?> > Other</input>
									</div>
								</label>
							</div>
							
						</form>

						<form class="form-vertical">		
				
							<div class="form-group ">
								<label for="stu_firstname">First Name</label> 
								<div class="input-group">
									<span class="input-group-addon">
										<i class="glyphicon glyphicon-user"></i>
									</span>
									<input  form="student_editprofile_form" type="text" name="stu_firstname" value="<?php echo $student_data['stu_firstname']; ?>" id="stu_firstname" class="form-control" placeholder="ชื่อ" ></input>
								</div>  
							</div>

							<div class="form-group ">
								<label for="stu_lastname">Last Name</label>
								<div class="input-group">
									<span class="input-group-addon">
										<i class="glyphicon glyphicon-user"></i>
									</span>
									<input  form="student_editprofile_form" type="text" name="stu_lastname" value="<?php echo $student_data['stu_lastname']; ?>" id="stu_lastname" class="form-control" placeholder="นามสกุล">
								</div>  
							</div>

							<div class="form-group ">
								<label for="stu_nickname" >Nick Name</label>
								<div class="input-group">
									<span class="input-group-addon">
										<i class="glyphicon glyphicon-user"></i>
									</span>
									<input  form="student_editprofile_form" type="text" name="stu_nickname" value="<?php echo $student_data['stu_nickname']; ?>" id="stu_nickname" class="form-control" placeholder="ชื่อเล่น">
								</div>  
							</div>

							<div class="form-group ">
								<label for="stu_dob" >Date of Birth</label>
								<div class="input-group">
									<span class="input-group-addon">
										<i class="glyphicon glyphicon-time"></i>
									</span>
									<input  form="student_editprofile_form" type="date" name="stu_dob" value="<?php echo $student_data['stu_dob']; ?>" id="stu_dob" class="form-control">
								</div>  
							</div>						
						</form>
					</div>
				</div>
			</div>
			<!-- left panel -->	


			<!-- middle panel -->	
			<div class="col-xs-4">
				<div class="row">
					<div class="panel panel-default" style="background-color:AliceBlue;">
						<div class="panel-header" >
							<h2>Contact</h2>
						</div>
						<div class="panel-body">
							
							<form>					
			
								<div class="form-group">
									<label for="stu_department"></label>
									<select class="form-control" id="stu_department" name="stu_department" form="student_editprofile_form">
										<?php 
											foreach ($departments as $row) {
												echo '<option value="'.$row['dept_id'].'" ';
												if(!empty($student_data['stu_dept_id']) ) {

													if ( $row['dept_id'] == $student_data['stu_dept_id'] )
														echo "selected";
												}
												echo '  >'.$row['dept_name'].'</option>';
											}

										?>
									</select>
								</div>

								<div class="form-group">
									<label for="stu_group"></label>
									<select disabled class="form-control" id="stu_group" name="stu_group" form="student_editprofile_form" value="">
										<?php 
											foreach ($class_schedule as $row) {
												echo '<option value="'.$row['group_id'].'" ';
												if ($row['group_id']== $student_data['group_id'])
													echo "selected";
												echo ' > กลุ่มที่  '.$row['group_no'].'</option>';
											}

										?>									
									</select>
								</div>
				

								<div class="form-group ">
									<label for="stu_email">Email</label>
									<div class="input-group">
										<span class="input-group-addon">
											<i class="glyphicon glyphicon-envelope"></i>
										</span>
										<input type="email" name="stu_email" value="<?php echo $student_data['stu_email']; ?>" id="stu_email" class="form-control" placeholder="email" form="student_editprofile_form">
									</div>  
								</div>

								<div class="form-group ">
									<label for="stu_tel" class="sr-only">Phone</label>
									<div class="input-group">
										<span class="input-group-addon">
											<i class="glyphicon glyphicon-phone"></i>
										</span>
										<input type="number" name="stu_tel" value="<?php echo $student_data['stu_tel']; ?>" id="stu_tel" class="form-control" placeholder="เบอร์โทรศัพท์" form="student_editprofile_form">
									</div>  
								

								</div>

								<div class="form-group">
									<div class="row">
										<div class="col-4">
											<label for="stu_avatar">Upload your picture</label>
										</div>
										<div class="col-8">
											<div class="input-group">
												<input style="margin-top:10px;" type="file" name="stu_avatar" value="" id="stu_avatar" class="form-control" form="student_editprofile_form" 
												<?php 
													if ($class_info['allow_upload_pic']=='no')
														echo "disabled ";
														
												?>
												>
											</div>
										</div>
									</div>
								</div>
									

									<!--<label class="btn btn-default btn-file" style="position: relative;  overflow: hidden;">
										Browse <input type="file" style="display: none;" form="student_editprofile_form"  style="position: absolute; top: 0; right: 0; min-width: 100%;  min-height: 100%; font-size: 100px; text-align: right; filter: alpha(opacity=0); opacity: 0; outline: none; background: white;    cursor: inherit; display: block;">
									</label>
									-->
							</form>	
						</div>
					</div>							
				</div>
			</div>
			<!-- middle panel -->	
				
			
			<!-- right panel -->
			<div class="col-xs-4">
				<div class="row">
					<div class="panel panel-default" style="background-color:AliceBlue;">
						<div class="panel-head">
							<h3>Submit</h3>
						</div>

						<div class="panel-body">
							<form action="<?php echo site_url('student/edit_profile_action'); ?>" method="post" accept-charset="utf-8" id="student_editprofile_form" enctype="multipart/form-data">
								
								

								<div class="form-group ">
									<label for="password_new">New Password</label>
									<div class="input-group">
										<span class="input-group-addon">
											<i class="glyphicon glyphicon-lock"></i>
										</span>
										<input type="password" name="password_new" id="password_new" class="form-control" placeholder="New Password">
									</div> 
								</div>

								<div class="form-group ">
									<label for="password_confirm">Password re-enter</label>
									<div class="input-group">
										<span class="input-group-addon">
											<i class="glyphicon glyphicon-lock"></i>
										</span>
										<input type="password" name="password_confirm" id="password_confirm" class="form-control" placeholder="re-enter Password">
									</div> 
								</div>

								<div class="form-group" style="visibility:hidden;">								
									<label for="stu_id" class="sr-only">Student ID</label> 
									<div class="input-group">
										<span class="input-group-addon">
											<i class="glyphicon glyphicon-user"></i>
										</span>
										<input type="text" name="stu_id" value="<?php echo $student_data['stu_id']; ?>" id="stu_id" class="form-control" readonly >
									</div>
								</div> 

								<div class="form-group ">
									<label for="current_password" >Currrent Password</label>
									<div class="input-group">
										<span class="input-group-addon">
											<i class="glyphicon glyphicon-lock"></i>
										</span>
										<input type="password" name="current_password" id="current_password" class="form-control" placeholder="Current Password" required>
									</div> 
								</div>
							</form>
						</div>
						

							

							
					</div>

				
				<input type="submit" value="Submit" class="btn btn-primary" form="student_editprofile_form">
			</div>
		
			
	</div>




</div>
<!-- /nav_body -->

</div>

<!--<div class="row">			
				<p><?php echo "departments : <pre> ";print_r($departments);echo "</pre>"; ?></p>
				<p><?php echo "$student_data : <pre> ";print_r($student_data);echo "</pre>"; ?></p>
</div>
<!---->
</div>


