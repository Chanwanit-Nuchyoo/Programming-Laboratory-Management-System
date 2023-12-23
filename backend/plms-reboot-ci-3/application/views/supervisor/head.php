<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>cePython Supervisor</title>
	
	
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<link rel="stylesheet" href="<?php echo base_url('assets/bootstrap-3.3.7/css/bootstrap.min.css') ?>" >
	<link href="<?php echo base_url('assets/summernote/summernote.css') ?>" rel="stylesheet" >
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/codemirror-5.22.0/lib/codemirror.css')?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/codemirror-5.22.0/theme/monokai.css')?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style_k.css')?>">

	
	
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="assets/js/jquery.min.js"><\/script>')</script> -->
	<script src="<?php echo base_url('assets/jquery/jquery-3.1.1.min.js') ?>"></script>
	<!-- <script src="<?php echo base_url('assets/bootstrap-3.3.7/js/bootstrap.min.js') ?>"></script> -->
    
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo base_url('assets/bootstrap-3.3.7/js/bootstrap.min.js') ?>" ></script>

	<script type="text/javascript" src="<?php echo base_url('assets/jquery/jquery.tablesorter.min.js')?>"></script>

	

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
			background-color: light-yellow;
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
		.kpanel_top {
			position: fix;
		}
		.kpanel_left {
			position: fix;
		}
		.kpanel_body {
			margin-left: 300px;
		}
		.nav , .mynavbar {
			background-color: LightYellow;
		}
	</style>
</head>


<body style="background-color:light-yellow;">
<!-- end tag in footer -->