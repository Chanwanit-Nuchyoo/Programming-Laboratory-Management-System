<!-- nav_body -->
<div class="col-lg-10 col-md-10 col-sm-10" style="margin-top:40px;"> 	
	<div class="container-fluid" >
  		<div class="row">
			<div class="col-sm-8">
				<div class="panel panel-default" style="background-color:AliceBlue;">
					<h2>Edit Profile</h2>
				</div>
			</div>
			<div class="col-sm-4">
				<?php 
					$error = $this->session->flashdata("error");
					$status = $this->session->flashdata("status"); 
					if($error) {
						$tag="alert-warning";
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
										<input form="supervisor_editprofile_form" type="radio" name="supervisor_gender" value="male" <?php if($_SESSION['supervisor_gender']=="male") echo "checked"; ?>> Male</input>
									</div>
								</label>
							</div>

							<div class="form-group">
								<label>
									<div class="radio-inline">
										<input form="supervisor_editprofile_form" type="radio" name="supervisor_gender" value="female" <?php if($_SESSION['supervisor_gender']=="female") echo "checked"; ?> > Female</input>
									</div>
								</label>
							</div>

							<div class="form-group">
								<label>
									<div class="radio-inline">
										<input form="supervisor_editprofile_form" type="radio" name="supervisor_gender" value="other" <?php if($_SESSION['supervisor_gender']=="other") echo "checked"; ?> > Other</input>
									</div>
								</label>
							</div>
							
						</form>

						<form class="form-vertical">		
				
							<div class="form-group ">
								<label for="supervisor_firstname">First Name</label> 
								<div class="input-group">
									<span class="input-group-addon">
										<i class="glyphicon glyphicon-user"></i>
									</span>
									<input  form="supervisor_editprofile_form" type="text" name="supervisor_firstname" value="<?php echo $_SESSION['supervisor_firstname']; ?>" id="supervisor_firstname" class="form-control" placeholder="ชื่อ" ></input>
								</div>  
							</div>

							<div class="form-group ">
								<label for="supervisor_lastname">Last Name</label>
								<div class="input-group">
									<span class="input-group-addon">
										<i class="glyphicon glyphicon-user"></i>
									</span>
									<input  form="supervisor_editprofile_form" type="text" name="supervisor_lastname" value="<?php echo $_SESSION['supervisor_lastname']; ?>" id="supervisor_lastname" class="form-control" placeholder="นามสกุล">
								</div>  
							</div>

							<div class="form-group ">
								<label for="supervisor_nickname" >Nick Name</label>
								<div class="input-group">
									<span class="input-group-addon">
										<i class="glyphicon glyphicon-user"></i>
									</span>
									<input  form="supervisor_editprofile_form" type="text" name="supervisor_nickname" value="<?php echo $_SESSION['supervisor_nickname']; ?>" id="supervisor_nickname" class="form-control" placeholder="ชื่อเล่น">
								</div>  
							</div>

							<div class="form-group ">
								<label for="supervisor_dob" >Date of Birth</label>
								<div class="input-group">
									<span class="input-group-addon">
										<i class="glyphicon glyphicon-time"></i>
									</span>
									<!--
									<input  form="supervisor_editprofile_form" type="date" name="supervisor_dob" value="<?php echo $_SESSION['supervisor_dob']; ?>" id="supervisor_dob" class="form-control">
									-->
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
									<label for="supervisor_department"></label>
									<select class="form-control" id="supervisor_department" name="supervisor_department" form="supervisor_editprofile_form">
										<option>วิศวกรรมคอมพิวเตอร์</option>
										<option>วิศวกรรมการวัดคุม</option>
										<option>วิศวกรรมเกษตร</option>
										<option>วิศวกรรมอาหาร</option>
										<option>วิศวกรรมโทรคมนาคม</option>
										<option>วิศวกรรมแมคคาทรอนิกส์</option>
										<option>วิศวกรรมเครื่องกล</option>
										<option>วิศวกรรมเคมีสารสนเทศ</option>
										<option>วิศวกรรมอิเลกทรอนิกส์</option>
										<option>วิศวกรรมอัตโนมัติ</option>
										<option>วิศวกรรมเกษตร</option>
										<option>วิศวกรรมปิโตรเคมี</option>
										<option>วิศวกรรมโยธา</option>
										<option>วิศวกรรมอุตสาหการ</option>
										<option>วิศวกรรมออกแบบการผลิตและวัสดุ</option>
									</select>
								</div>

								
				

								<div class="form-group ">
									<label for="supervisor_email">Email</label>
									<div class="input-group">
										<span class="input-group-addon">
											<i class="glyphicon glyphicon-envelope"></i>
										</span>
										<input type="email" name="supervisor_email" value="<?php echo $_SESSION['supervisor_email']; ?>" id="supervisor_email" class="form-control" placeholder="email" form="supervisor_editprofile_form">
									</div>  
								</div>

								<div class="form-group ">
									<label for="supervisor_tel" class="sr-only">Phone</label>
									<div class="input-group">
										<span class="input-group-addon">
											<i class="glyphicon glyphicon-phone"></i>
										</span>
										<!--
										<input type="number" name="supervisor_tel" value="<?php echo $_SESSION['supervisor_tel']; ?>" id="supervisor_tel" class="form-control" placeholder="เบอร์โทรศัพท์" form="supervisor_editprofile_form">
										-->
									</div>  
								

								</div>

								<div class="form-group">
									<div class="row">
										<div class="col-4">
											<label for="supervisor_avatar">Upload your picture</label>
										</div>
										<div class="col-8">
											<div class="input-group">
												<input style="margin-top:20px;" type="file" name="supervisor_avatar" value="" id="supervisor_avatar" class="form-control" form="supervisor_editprofile_form">
											</div>
										</div>
									</div>
								</div>
									

									<!--<label class="btn btn-default btn-file" style="position: relative;  overflow: hidden;">
										Browse <input type="file" style="display: none;" form="supervisor_editprofile_form"  style="position: absolute; top: 0; right: 0; min-width: 100%;  min-height: 100%; font-size: 100px; text-align: right; filter: alpha(opacity=0); opacity: 0; outline: none; background: white;    cursor: inherit; display: block;">
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
							<form action="<?php echo site_url('supervisor/edit_profile_action'); ?>" method="post" accept-charset="utf-8" id="supervisor_editprofile_form" enctype="multipart/form-data">
								<div class="form-group " >
									<label for="supervisor_id" class="sr-only">supervisor ID</label> 
									<div class="input-group">
										<span class="input-group-addon">
											<i class="glyphicon glyphicon-user"></i>
										</span>
									<input type="text" name="supervisor_id" value="<?php echo $_SESSION['supervisor_id']; ?>" id="supervisor_id" class="form-control" readonly>
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

								
							</form>
						</div>
						

							

							
					</div>

				
				<input type="submit" value="Submit" class="btn btn-primary" form="supervisor_editprofile_form">
			</div>
		
			
	</div>



</div>
<!-- /nav_body -->

<!--
<div class="row">			
			
				<p><?php echo '$supervisor_data : <pre> ';print_r($supervisor_data);echo "</pre>"; ?></p>
				<p><?php echo '$_SESSION : <pre> ';print_r($_SESSION);echo "</pre>"; ?></p>
</div>
<!---->

</div>


</div>


