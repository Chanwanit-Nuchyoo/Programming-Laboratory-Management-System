<header>  
	<!-- -- Header Part -- -- -->
	<div class="container" style="padding:5px 0 5px 0; margin:0 auto; height:110px; width:990px; border:0px solid #000;" >
	 
        <div class="logo" style="float:left; height:108px; width:108px;">
        	<img src="<?php echo base_url('assets/images/logo1.jpg')?>"  width="100" height="100">
        </div>

        <div class="page-header">
            <div class="title_top" style="padding: 20px 0px 2px 0px; font-family:Myriad Pro; font-size:22px; 
            			font-weight: 700; height:28px;	width:500px; border: 0px solid #000;">
                <h2>Programming Lab Management System</h2>
            </div>  
            <div class="title_btm" style="font-family:Century Gothic; font-size:18px; font-weight: 650;  color:#ccc;
    				height:50px; width:500px; border: 0px solid #000;">
                King Mongkut's Institute of Technology Ladkrabang
            </div>  
        </div> 

        <div class="sign" style="margin:10px 35px 0 0; text-align:right; float:right; color:#ccc; 
        						height:50px; width:300px;">
             
			<form method="post" id="signin" action="<?php echo site_url(MY_CONTROLLER).'/verify' ?>">
				<label for="username">Username/Student ID</label>
				<input id="username" name="username" placeholder="Username/Student ID" value="" title="username" tabindex="4" type="text">
				</p>
				<p>
				<label for="password">Password</label>
				<input id="password" name="password" placeholder="password" value="" title="password" tabindex="5" type="password">
				</p>
				<p class="remember" valign="bottom">
				<input id="signin_submit" value="Sign in" tabindex="6" type="submit" onclick="formsubmit()"> 
				</p>
			</form>
           
        </div>
<!--
        <form class="form-group">
			<div class="form-group">
				<label class="control-label col-sm-2" for="user">Username2/Student ID</label>
				<div class="col-sm-2">
					<input type="text" class="form-control" id="user" placeholder="Enter email">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2" for="pwd">Password:</label>
				<div class="col-sm-2"> 
					<input type="password" class="form-control" id="pwd" placeholder="Username/Student ID">
				</div>
			</div>
			<div class="form-group"> 
				<div class="col-sm-offset-2 col-sm-10">
				<div class="checkbox">
					<label><input type="checkbox"> Remember me</label>
				</div>
				</div>
			</div>
			<div class="form-group"> 
			<div class="col-sm-offset-2 col-sm-1">
				<button type="submit" class="btn btn-default">Submit</button>
			</div>
			</div>
		</form>
-->
    <!-- ------ End of Head Part ----- --> 

</div>
</header>
<hr>