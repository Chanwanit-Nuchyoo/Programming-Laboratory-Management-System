
<div class="navbar navbar-fixed-top navbar-default mynavbar">
  	<div class="container-fulid" >
			
		<a href="<?php echo site_url()?>" class="navbar-left"><img height="80px" width="80px" src="<?php echo base_url('assets/images/logo1.png')?>" style="padding-top:5px;padding-bottom:5px;"></a>

		<div class="navbar-text" >
			<div class="navbar-text1">Programming Lab Management System</div>
			<div class="navbar-text2"> (Computer Programming python)</div>
			<div class="navbar-text3">King Mongkut's Institute of Technolygy Ladkrabang</div>
		</div>
		<div class="nav navbar-nav navbar-right" style="margin-top:15px;margin-right:15px;" >
			<li <?php if($_SESSION['selected_menu'] == 'home') echo 'class="active"'; ?> >
				<a href="<?php echo site_url('supervisor/index'); ?>">Home</a>
			</li>
			<?php if($_SESSION['id'] == '900009') { ?>
			<li><a href="<?php echo site_url($_SESSION['role'].'/exercise_show'); ?>" title="Exercise Management">Exercise</a></li>	
			<?php } ?>

			<li <?php if($_SESSION['selected_menu'] == 'grp_management') echo 'class="active"'; ?> >
				<a href="<?php echo site_url($_SESSION['role'].'/group_management'); ?>" title="Group Mangement"> Group Management </a>
			</li>

			<li <?php if($_SESSION['selected_menu'] == 'instruction') echo 'class="active"'; ?>>
				<a href="<?php echo site_url($_SESSION['role'].'/instruction'); ?>" title="ข้อแนะนำการใช้งาน">
					<i class="icon-list"></i>Readme</a>
			</li>

			<li <?php if($_SESSION['selected_menu'] == 'faq') echo 'class="active"'; ?> >
				<a href="<?php echo site_url($_SESSION['role'].'/faq'); ?>" title="คำถามพบบ่อย">FAQ</a>
			</li>

			<li <?php if($_SESSION['selected_menu'] == 'practice_exam') echo 'class="active"'; ?> >
				<a href="<?php echo site_url($_SESSION['role'].'/practice_exam'); ?>" title="การสอบปฏิบัติ">
				<i class="icon-list"></i>Examination</a>
			</li>

			<li <?php if($_SESSION['selected_menu'] == 'edit_profile') echo 'class="active"'; ?>>
				<a href="<?php echo site_url($_SESSION['role'].'/edit_profile_form'); ?>"  title="แก้ไขข้อมูลส่วนตัว">Edit profile</a></li>
			<li <?php if($_SESSION['selected_menu'] == 'help') echo 'class="active"'; ?> >
			</li>
				
			<li <?php if($_SESSION['selected_menu'] == 'about') echo 'class="active"'; ?>>
				<a href="<?php echo site_url($_SESSION['role'].'/about'); ?>" >About</a>
			</li>			
			<li class="btn-logout">
				<a href="<?php echo site_url("auth/logout") ?>" class="btn btn-default btn-lg"> Log out. <span class="glyphicon glyphicon-log-out"></span> </a></li> 
		</div>
      
        <!--/.navbar-collapse -->
    </div>
</div>
<div class="container-fluid"  style="background-color:HoneyDew;">	
	<div class="panel panel-default">
		<div class="panel-body">A Basic Panel</div>
	</div>
</div>
<div class="clear-fix"></div> 
<!-- Page Contents -->
<div class="container-fluid"  style="background-color:HoneyDew ;margin-top:10px;">	
	<!-- row content -->
	<div class="row">
