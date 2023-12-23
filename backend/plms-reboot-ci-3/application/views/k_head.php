<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>KMITL Computer Programming</title>
	
	<link rel="stylesheet" href="<?php echo base_url('assets/bootstrap-3.3.7/css/bootstrap.min.css') ?>" >
	


  <style>
    /* Remove the navbar's default margin-bottom and rounded borders */ 
    .navbar {
      margin-bottom: 0;
      border-radius: 0;
	  height:auto;
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
	#sidebar-wrapper {
		margin-top:95px;
		margin-left: -250px;
		left: 250px;
		width: 250px;
		background: gainsboro;
		position: fixed;
		height: 100%;
		overflow-y: auto;
		z-index: 1000;
		transition: all 0.4s ease 0s;
	}
	#page-wrapper {
		margin-top:80px;
		margin-left: 250px;
		
		position: fixed;
		height: 100%;
		overflow-y: auto;
		z-index: 1000;
		transition: all 0.4s ease 0s;
	}
  </style>
</head>
<body>
	<div id="wrapper">