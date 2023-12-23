<!DOCTYPE html>
<html>
<head>
	<title>Bootstrap Example</title>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	<style>
		/* Remove the navbar's default margin-bottom and rounded borders */ 
		.navbar {
			margin-bottom: 0;
			border-radius: 0;
		}
    
    /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
    .row.content {height: 450px}
    
    /* Set gray background color and 100% height */
    .sidenav {
      padding-top: 20px;
      background-color: #f1f1f1;
      height: 100%;
    }
    
    /* Set black background color, white text and some padding */
    footer {
      background-color: #555;
      color: white;
      padding: 15px;
    }
    
    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height:auto;} 
    }
	#page-content {
		margin-top:95px;
	}
  </style>
</head>
<body>

<!--  NAV TOP  -->
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    
	<div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <!-- <a class="navbar-brand" href="#">Logo</a> -->
	  
	  <img height="80px" width="80px" src="<?php echo base_url('assets/images/logo1.png')?>" >
	  
    </div>
	<div class="navbar-text" style="margin-top:0px;padding-top:0px">
		<h3>Programming Lab Management System</h3>
		<h5>King Mongkut's Institute of Technolygy Ladkrabang</h5>
	</div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        
        
      </ul>
      <ul class="nav navbar-nav navbar-right" style="padding-top:15px;">
		<li class="active"><a href="#">Home</a></li>
        <li><a href="#">Exercise</a></li>
        <li><a href="#">Layout</a></li>
		<li><a href="#">Edit profile</a></li>
	    <li><a href="#">Help</a></li>
		<li><a href="#">About</a></li>
        <li><a  class="btn btn-default btn-lg"  href="<?php echo site_url("auth/logout") ?>"> 
          <span class="glyphicon glyphicon-log-out"></span> Log out </a></li>
      </ul>
    </div>
  </div>
  
</nav>
<!-- /. NAV TOP  -->
  
<div class="container-fluid text-center" id="page-content">    
  <div class="row content">
    <div class="col-sm-2 sidenav">
	<img src="<?php echo base_url('assets/images/find_user.png'); ?>">
      <p><?php echo $_SESSION['username']; ?></p>
      <p>กลุ่ม</p>
      <p><a href="#">Link</a></p>
    </div>
    <div class="col-sm-10 text-left"> 
		
      <h1>Welcome</h1>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
      <hr>
      <h3>Test</h3>
      <p>Lorem ipsum...</p>
    </div>
    
  </div>
</div>

<footer class="container-fluid text-center">
  <p>Page rendered in <strong>{elapsed_time}</strong> seconds. 
		<?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
  <pre>
	<?php print_r($_SESSION); ?>
	</pre>
</footer>

</body>
</html>
