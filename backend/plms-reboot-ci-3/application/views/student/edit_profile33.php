<!-- nav_body -->
<div class="col-lg-10 col-md-10 col-sm-10"> 	
	<div class="container-fluid" style="padding-top:10; blackground-color:yellow;">
  		
		<div class="row">  
			<div class="col-xs-4">
				<form class="form-inline">

					<div class="form-group">
						<label>
						<div class="radio-inline">
						<input form="student_editprofile_form" type="radio" name="gender" value="Male" > Male</input>
						</div>
						</label>
					</div>

					<div class="form-group">
					<label>
						<div class="radio-inline">
						<input form="student_editprofile_form" type="radio" name="gender" value="Female" > Female</input>
						</label>
					</div>

					<div class="form-group">
					<label>
						<div class="radio-inline">
						<input form="student_editprofile_form" type="radio" name="gender" value="other"> Other</input>
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
								<input  form="student_editprofile_form" type="text" name="stu_firstname" value="" id="stu_firstname" class="form-control" placeholder="ชื่อ" ></input>
							</div>  
						</div>

						<div class="form-group ">
							<label for="stu_lastname">Last Name</label>
							<div class="input-group">
								<span class="input-group-addon">
									<i class="glyphicon glyphicon-user"></i>
								</span>
								<input  form="student_editprofile_form" type="text" name="stu_lastname" value="" id="stu_lastname" class="form-control" placeholder="นามสกุล">
							</div>  
						</div>

						<div class="form-group ">
							<label for="stu_nickname" >Nick Name</label>
							<div class="input-group">
								<span class="input-group-addon">
									<i class="glyphicon glyphicon-user"></i>
								</span>
								<input  form="student_editprofile_form" type="text" name="stu_nickname" value="" id="stu_nickname" class="form-control" placeholder="ชื่อเล่น">
							</div>  
						</div>

						<div class="form-group ">
							<label for="stu_dob" >Date of Birth</label>
							<div class="input-group">
								<span class="input-group-addon">
									<i class="glyphicon glyphicon-user"></i>
								</span>
								<input  form="student_editprofile_form" type="date" name="stu_dob" value="" id="stu_dob" class="form-control">
							</div>  
						</div>
					</div>
				</form>
			</div>
				
			
			<div class="col-xs-4">
				<div class="panel">
					<div class="panel-header">
						<p>Edit Profile</p>
					</div>
					<form action="<?php echo site_url('student/edit_profile_action'); ?>" method="post" accept-charset="utf-8" id="student_editprofile_form">
						<div class="form-group " >
							<label for="student_id" class="sr-only"></label> 
							<div class="input-group">
								<span class="input-group-addon">
									<i class="glyphicon glyphicon-user"></i>
								</span>
								<input type="text" name="student_id" value="<?php echo 0 ? 456 : 789 ; ?>" id="student_id" class="form-control" disabled placeholder="Username/Student ID">
							</div>  
						</div>

						

						
			
							<div class="form-group">
								<label for="exampleSelect2"></label>
								<select class="form-control" id="exampleSelect2" name="student_dept">
									<option>วิศวกรรมคอมพิวเตอร์</option>
									<option>วิศวกรรมเครื่องกล</option>
									<option>วิศวกรรมเคมี</option>
									<option>วิศวกรรมอาหาร</option>
									<option>วิศวกรรมไฟฟ้า</option>
								</select>
							</div>
			

							<div class="form-group ">
								<!-- <label for="student_email">Email</label> -->
								<div class="input-group">
								<span class="input-group-addon">
									<i class="glyphicon glyphicon-envelope"></i>
								</span>
								<input type="email" name="student_email" value="" id="student_email" class="form-control" placeholder="email">
								</div>  
							</div>

							<div class="form-group ">
								<label for="student_phone" class="sr-only">Phone</label>
								<div class="input-group">
								<span class="input-group-addon">
									<i class="glyphicon glyphicon-phone"></i>
								</span>
								<input type="text" name="student_phone" value="" id="student_phone" class="form-control" placeholder="เบอร์โทรศัพท์">
								</div>  
							</div>

							<div class="form-group ">
								<label for="password" class="sr-only">Password</label>
								<div class="input-group">
								<span class="input-group-addon">
								<i class="glyphicon glyphicon-lock"></i>
								</span>
								<input type="password" name="password" id="password" class="form-control" placeholder="Password">
								</div> 
							</div>

							<div class="form-group ">
								<label for="password" class="sr-only">Password re-enter</label>
								<div class="input-group">
								<span class="input-group-addon">
								<i class="glyphicon glyphicon-lock"></i>
								</span>
								<input type="password" name="password" id="password" class="form-control" placeholder="re-enter Password">
							</div> 
						</div>				
					</form>
				</div>
			</div>
				
			<div class="col-xs-4">
				<p>space</p>
				<form form="student_editprofile_form">
						<div class="form-group ">
							<label for="student_firstname" class="sr-only">First Name</label> 
								<div class="input-group">
									<span class="input-group-addon">
										<i class="glyphicon glyphicon-user"></i>
									</span>
									<input type="text" name="student_firstname555" value="" id="student_firstname" class="form-control" placeholder="ชื่อ" ></input>
								</div>  
							</div>
				</form>
				<input type="submit" value="Submit" class="btn btn-primary" form="student_editprofile_form">
			</div>
		
			
	</div>



</div>
<!-- /nav_body -->

</div>


</div>


