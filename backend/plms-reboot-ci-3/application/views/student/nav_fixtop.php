<!-- <?php 
	//include_once 'application/views/plms_head.php';
	?> -->
<?php include_once 'application/views/student/stu_head.php'; ?>
<!--  NAV TOP  -->
<div class="container-fluid">
	<div class="navbar navbar-default navbar-fixed-top">
		<div class="navbar-header">
		
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>                        
			</button>
			<!-- <a class="navbar-brand" href="#">Logo</a> -->

			<img class="header-image" src="<?php echo base_url('assets/images/logo-engkmitl.png')?>" >

		</div>

		<div class="navbar-text header-text" >
			<div class="header-subject-name">Computer Programming python</div>
			<!-- <div class="header-kmitl">King Mongkut's Institute of Technolygy Ladkrabang</div> -->
		</div>
    
		<div class="collapse navbar-collapse" id="myNavbar">
			<ul class="nav navbar-nav">


			</ul>
			<ul class="nav navbar-nav navbar-right header-menu" style="padding-top:15px;">
				<li <?php if($_SESSION['selected_menu'] == 'home') echo 'class="active"'; ?>>
				<a href="<?php echo site_url('student/index'); ?>">Home</a></li>
				<li <?php if($_SESSION['selected_menu'] == 'exercise') echo 'class="active"'; ?>>
					<a href="<?php echo site_url($_SESSION['role'].'/exercise_home'); ?>">Exercise</a></li>
				<!-- <li><a href="#">Layout</a></li> -->
				<li <?php if($_SESSION['selected_menu'] == 'edit_profile') echo 'class="active"'; ?>>
					<a href="<?php echo site_url('student/edit_profile_form'); ?>">Edit profile</a></li>
				<li <?php if($_SESSION['selected_menu'] == 'instruction') echo 'class="active"'; ?>>
					<a href="<?php echo site_url('student/instruction'); ?>" title="ข้อแนะนำการใช้งาน">
					<i class="icon-list"></i>Instruction</a>
				</li>
				<li <?php if($_SESSION['selected_menu'] == 'faq') echo 'class="active"'; ?>>
					<a href="<?php echo site_url('student/faq'); ?>" title="คำถามพบบ่อย">FAQ</a></li>
				<li <?php if($_SESSION['selected_menu'] == 'practice_exam') echo 'class="active"'; ?>>
					<a href="<?php echo site_url('student/practice_exam'); ?>" title="การสอบปฏิบัติ">
					<i class="icon-list"></i>Examination</a></li>
				<li <?php if($_SESSION['selected_menu'] == 'about') echo 'class="active"'; ?>>
					<a href="<?php echo site_url('student/about'); ?>" title="about">
					<i class="icon-list"></i>About</a></li>

				<!-- <li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" title="ความช่วยเหลือ">Help <b class="caret"></b></a>
				<ul class="dropdown-menu">
				<li>
				<a href="<?php echo site_url($_SESSION['role'].'/show_lab_exercise'); ?>" title="อ่านฉันก่อน"><i class="icon-list"></i> How to use First step</a>
				</li>
				<li>
				<a href="#"><i class="icon-support"></i> Useful link</a>
				</li>
				<li>
				<a href="#"><i class="icon-support"></i> About</a>
				</li>
				</ul>
				</li> -->
				<li><a  class="btn btn-default btn-lg"  href="<?php echo site_url("auth/logout") ?>"> 
				<span class="glyphicon glyphicon-log-out"></span> Log out </a></li>
			</ul>
		</div>
  </div>
  
</div>
<!-- /. NAV TOP  -->
 

<!-- Page Contents -->
<div class="container-fluid "  style="background-color:GhostWhite">	
	<!-- row content -->
	<div class="row content">
