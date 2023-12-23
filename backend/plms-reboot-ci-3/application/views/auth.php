	<div class="container" style="background-color: transparent; border: 0px solid red;margin-top:20px;">
		<div class="alert alert-info blink_me" style="text-align:center;">
			<div>
				Tutor Class จันทร์ อังคาร พุธ พฤหัสบดี ศุกร์ เวลา 18.00-20.00 ห้อง ECC-706 <br>
				นักศึกษาสามารถมาปรึกษาพี่ TA ได้เกี่ยวกับบทเรียน และ แบบฝึกหัด

			</div>
		</div>
  		<div> <!-- class="row login-wrapper" style="border: 2px solid red;"> -->
  			<div class="col-md-4 col-xs-6 col-md-offset-4 col-xs-offset-3"> 
			
  				<div class="panel panel-default">
  					<div class="panel-heading">
  						
						<h5 class="subject_heading">01006012 Computer Programming</h5>
  					</div>
  					<div class="panel-body">  
              		<?php $error = $this->session->flashdata("error"); ?>
  						<div class="alert alert-<?php echo $error ? 'warning' : 'info' ?> alert-dismissible" role="alert">
  						  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  						  <?php echo $error ? $error : 'Enter your username and password' ?>
  						</div>

  						<?php echo form_open(); ?>  
                <?php $error = form_error("username", "<p class='text-danger'>", '</p>'); ?>              
  							<div class="form-group <?php echo $error ? 'has-error' : '' ?>">
  								<label for="username">Username</label>
  								<div class="input-group">
  									<span class="input-group-addon">
  										<i class="glyphicon glyphicon-user"></i>
  									</span>
  									<input type="text" name="username" value="<?php echo set_value("username") ?>" id="username" class="form-control">
  								</div>  
                  <?php echo $error; ?>
  							</div>
                <?php $error = form_error("password", "<p class='text-danger'>", '</p>'); ?>
  							<div class="form-group <?php echo $error ? 'has-error' : '' ?>">
  								<label for="password">Password</label>
  								<div class="input-group">
  									<span class="input-group-addon">
  										<i class="glyphicon glyphicon-lock"></i>
  									</span>
  									<input type="password" name="password" id="password" class="form-control">
  								</div> 
                  <?php echo $error; ?>
  							</div>
  							<input type="submit" value="Login" class="btn btn-primary">
  						<?php echo form_close(); ?>
  					</div>
  				</div>
  			</div>
			  
			
  		</div>
		  
  	</div>
	


