			</div>
			<!-- row content -->

		</div>
		<!-- Page content -->
		
		<div class="clearfix"></div>
		
		<!-- footer start -->
		<footer class="container-fluid" style="background-color:LightSteelBlue;border:2px blue;  margin-right:2px;margin-left:300px; ">
			<div style="display:inline";>
			
			<p style="text-align:center;">
				<marquee behavior=alternate direction=left scrollAmount=3 width="4%"> <font face=Webdings> 3</font> </marquee> <marquee scrollAmount=1 direction=left width="2%"> | | |</marquee> Department of Computer Engineering, KMITL 2017 <marquee scrollAmount=1 direction=right width="2%"> | | |</marquee><marquee behavior=alternate direction=right scrollAmount=3 width="4%"> <font face=Webdings> 4</font> </marquee>
			</p>
			<p style="color:darkblue;">
				Page rendered in <strong>{elapsed_time}</strong> seconds. 
				<?php 
					echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '';
					echo '<br/>'.date("l jS \of F Y h:i:s A");
				?>
			</p>
			
			</div>		 
		</footer>
		<!-- footer end -->

	
	
		<script>
			var baseurl = "<?php echo base_url(); ?>";
			var user_role  = "<?php echo $_SESSION['role']; ?>";
			var infoForTracking = {
			server: 	<?php echo json_encode($_SERVER); ?>,
			session: 	<?php echo json_encode($_SESSION); ?>,
			elapsed_time: {elapsed_time}
		};
	</script>

		<script src="<?php echo base_url('/assets/js/plms_python.js'); ?>";></script>

	</body>
</html>
