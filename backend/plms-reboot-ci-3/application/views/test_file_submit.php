<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>KMITL Computer Programming</title>
	
</head>

<body>
	<form action="<?php echo site_url('student/exercise_submission'); ?>" method="post" accept-charset="utf-8" id="exercise_submission" enctype="multipart/form-data"   >
			<input type="hidden"	name="stu_id"		value="123" >
			<input type="hidden"	name="chapter_id"	value="456" >
			<input type="hidden"	name="item_id"		value="789" >
			<input type="hidden"	name="exercise_id"	value="abc" >
			<input type="file"		name="uu" form="exercise_submission" >
			<span><button type="submit"  form="exercise_submission" >Submit</button></span>


		</form>
</body>

<footer class="container-fluid">
  <p>Footer Text</p>
  <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
</footer>

<pre>
	<p>$_SESSION<br/></p>
	<?php print_r($_SESSION); ?>
  </pre>

  <?php echo date("Y-m-d H:i:s"); ?>
</html>