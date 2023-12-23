<!DOCTYPE html>
<html lang="en">
<!-- include libries(jQuery, bootstrap, fontawesome) -->
<script src="//code.jquery.com/jquery-1.9.1.min.js"></script> 
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.no-icons.min.css" rel="stylesheet"> 
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script> 
<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css" rel="stylesheet">

<!-- include summernote css/js-->
<link href="build/summernote.css" / rel="stylesheet">
<script src="build/summernote.min.js"></script>
<body>
<div class="summernote container">
	<div class="row">
		<div class="span12">
			<h2>POST DATA</h2>
			<pre>
			<?php echo isset($_POST) ? print_r($_POST) : "nothing in $_POST" ; ?>
			</pre>
			<pre>
			<?php echo isset($_POST['content']) ? htmlspecialchars($_POST['content']) : "POST['content']"; ?>
			</pre>
		</div>
	</div>
	<div class="row">
		<form class="span12" id="postForm" action="/summernote.php" method="POST" enctype="multipart/form-data" onsubmit="return postForm()">
			<fieldset>
				<legend>Make Post</legend>
				<p class="container">
					<textarea class="input-block-level" id="summernote" name="content" rows="18">
					</textarea>
				</p>
			</fieldset>
			<button type="submit" class="btn btn-primary">Save changes</button>
			<button type="button" id="cancel" class="btn">Cancel</button>
		</form>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function() {
	$('#summernote').summernote({
		height: "500px"
	});
});
var postForm = function() {
	var content = $('textarea[name="content"]').html($('#summernote').code());
}
</script>
</body>
</html>