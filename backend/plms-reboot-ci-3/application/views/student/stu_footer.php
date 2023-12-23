			</div>
			<!-- row content -->

		</div>
		<!-- Page content -->
		
		<div class="clearfix"></div>

		<!-- footer start -->
		<footer class="container-fluid" style="background-color:LightSteelBlue;border:2px blue;margin-left:320px;margin-right:15px;">
		  <p>Page rendered in <strong>{elapsed_time}</strong> seconds. 
				<?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong> '. date('D M j h:i:s') : '' ; ?></p>
		  
		</footer>
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="assets/js/jquery.min.js"><\/script>')</script> -->
	<script src="<?php echo base_url('assets/jquery/jquery-3.1.1.min.js') ?>"></script>
	<!-- <script src="<?php echo base_url('assets/bootstrap-3.3.7/js/bootstrap.min.js') ?>"></script> -->
    
    <script>
			var baseurl = "<?php echo base_url(); ?>";
			var user_role  = "<?php echo $_SESSION['role']; ?>";
			var user_id  = "<?php echo $_SESSION['stu_id']; ?>";
			var infoForTracking = {
			server: 	<?php echo json_encode($_SERVER); ?>,
			session: 	<?php echo json_encode($_SESSION); ?>,
			elapsed_time: {elapsed_time}
		};
	</script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo base_url(); ?>assets/bootstrap-3.3.7/js/bootstrap.min.js"></script>
	<!-- <script src="<?php echo base_url('/assets/js/plms_python.js'); ?>";></script> -->

	</body>
</html>
