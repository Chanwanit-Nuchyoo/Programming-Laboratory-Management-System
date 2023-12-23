	<footer> 
        <p class="text-center" style="color:white">&copy; 2017 Computer Engineering KMITL</p>         
		<div class="plms_footer">  
			<span class="footer_left">Page rendered in <strong>{elapsed_time}</strong> seconds.</span>
			<span class="footer_mid">
				<?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?>
			</span> 			
			<span  class="footer_right"><?php echo date("Y-m-d H:i:s"); ?></span>
		</div>
    </footer>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="assets/js/jquery.min.js"><\/script>')</script>-->
    
    <!-- Include all compiled plugins (below), or include individual files as needed
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script> -->
	<!-- <pre>
	<?php echo "<pre>".print_r($_SESSION)."</pre>" ?>
	</pre> -->

	<script type="text/javascript">
		Message= 'การแจ้งข่าวสาร';
		$(document).ready(function() {
			
			var Str='<table width="100%" border="0" cellspacing="0" cellpadding="0">';
			Str+='<tr>';
			Str+='<a href="images/211218_full.jpg" target="_blank"><img src="images/popup/211261_2.jpg" width="100%"></a>';
			Str+='</tr>';
			Str+='</table>';
			
			$.jAlert({
				'title': '<div style="font-family: \'Prompt\', sans-serif; font-size:20px; text-align:center;">ประกาศสำคัญ</div>',
				'content': Str,
				'theme': 'green',
				'size': 'auto',
				'btns': { 'text': '<span style="font-family: \'Prompt\', sans-serif; font-size:16px; text-align:center;">Close</span>' },
				'closeOnClick': true
				});					
		});
	</script>

	
  </body>
  

  

</html>
<!--
<pre>
	<?php print_r($_SERVER); ?>
</pre>
<pre>
	<?php print_r($_SESSION); ?>
</pre>
	-->
