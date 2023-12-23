<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>KMITL Computer Programming</title>
	
	<link rel="stylesheet" href="<?php echo base_url('assets/bootstrap-3.3.7/css/bootstrap.min.css') ?>" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	
	
<style>
body {
		padding:0;
		margin:0;
		height:100%;
		font-family:arial;
		font-size:12px;
		background:url(images/c.jpg) no-repeat scroll center 0px  transparent;
}

.head00{
   
}

.logo {
    float:left;
    height:108px;
    width:108px;
    background: url(images/logo1.png) no-repeat;
}

.title{
    margin:0 0 0 20px;
    float:left;
    height:108px;
    width:500px;
}
.title_top{
    padding: 20px 0px 2px 0px;
    font-family:Myriad Pro;
    font-size:22px;
    font-weight: 700;
    height:28px;
    width:500px;
    border: 0px solid #000;
	text-align: left;
	position: relative;
    top:8px;
    left:150px;
    width: 600px;
    height: 30px;
    border: 0px solid #73AD21;
}
.title_btm{
	text-align: left;
    font-family:Century Gothic;
    font-size:18px;
    font-weight: 650;
    color:#ccc;
    
    position: relative;
    top:40px;
    left:150px;
    width: 600px;
    height: 30px;
    border: 0px solid #73AD21;
}
.sign{
    margin:1px 35px 0 0;
    text-align:right;
    float:right;
    color:#ccc;
   
    position: relative;

    width: auto;
    height: auto;
    border: 1px solid #73AD21;
}
</style>	
	
</head>

<body>
	<div class="container" style="background-color:grey;">  
		<!-- -- Header Part -- -- -->
		<div class="head">
		    <div class="logo">
	        	<img src="<?php echo base_url('assets/images/logo1.jpg')?>" >
		    </div>
			
			<div class="title_top" >Programming Lab Management System</div>
	        <div class="title_btm" >King Mongkut's Institute of Technology Ladkrabang</div> 
	        
	        <div class="nav-form sign">
	             
				<form method="post" id="signin" action="<?php echo site_url(MY_CONTROLLER).'/verify' ?>">
					<div>
						<label for="username">Username/Student ID</label>
						<input id="username" name="username" placeholder="Username/Student ID" value="" title="username" 
								 type="text">
					</div>
					<div>
						<label for="password">Password</label>
						<input id="password" name="password" placeholder="password" value="" title="password" type="password">
					</div>
					<div class="remember" valign="bottom">
						<input id="signin_submit" value="Sign in"  type="submit" > 
					</div>
				</form>
	           
	        </div>
	    </div>

	<!-- ------ End of Head Part ----- --> 
	</header>
	<script src="<?php echo base_url('assets/jquery/jquery-3.1.1.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/bootstrap-3.3.7/js/bootstrap.min.js') ?>"></script>

</body>

<footer>
</footer>