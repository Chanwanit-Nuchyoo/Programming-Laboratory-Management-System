<!-- nav_body -->
<div class="col-lg-10 col-md-10 col-sm-10">

	<form action="<?php echo site_url('supervisor/add_exercise_action')?>" method="post" name="add_exercise">
		<textarea type="textarea" id="summernote" name="summernote-text">Hello Ssssssummernote</textarea>
		<button type="submit">Submit</button> 
		<input type="text" name="uuname">uuname</input>
	</form>

  <script>
    $(document).ready(function() {
        $('#summernote').summernote({
			  height: 300,                 // set editor height
			  minHeight: null,             // set minimum height of editor
			  maxHeight: null,             // set maximum height of editor
			  focus: true,                  // set focus to editable area after initializing summernote
			  airmode: true
			});
    });
  </script>
</div>
