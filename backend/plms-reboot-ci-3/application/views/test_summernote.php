<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Summernote</title>

  <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap-3.3.7/css/bootstrap.min.css') ?>" >
  <!-- <link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.css" rel="stylesheet"> -->

  <script src="<?php echo base_url('assets/jquery/jquery-3.1.1.min.js') ?>"></script>
  <!-- <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.js"></script>  -->

  <script src="<?php echo base_url('assets/bootstrap-3.3.7/js/bootstrap.min.js') ?>"></script>
  <!-- <script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script>  -->

  <link href="<?php echo base_url('assets/summernote/summernote.css') ?>" rel="stylesheet" >
  <!-- <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.css" rel="stylesheet"> -->

	<script src="<?php echo base_url('assets/summernote/summernote.js') ?>"></script>
  <!-- <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.js"></script> -->

	<!-- include codemirror (codemirror.css, codemirror.js, xml.js, formatting.js) -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/codemirror-5.22.0/lib/codemirror.css')?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/codemirror-5.22.0/theme/monokai.css')?>">
	<script type="text/javascript" src="<?php echo base_url('assets/codemirror-5.22.0/lib/codemirror.js')?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/codemirror-5.22.0/mode/xml/xml.js')?>"></script>
	<!-- <script type="text/javascript" src="<?php echo base_url('assets/codemirror-5.22.0/formatting.js')?>"></script> -->
</head>
<body>
	<form action="<?php echo site_url('welcome/show')?>" method="post" name="what">
	
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
</body>
</html>
