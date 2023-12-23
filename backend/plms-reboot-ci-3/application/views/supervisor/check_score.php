<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Python_compro</title>
    
    <link href="<?php echo base_url('assets/bootstrap-5.0.2-dist/css/bootstrap.min.css');?>" rel="stylesheet">
    <!--<link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css"
    /> -->
    <!-- <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x"
      crossorigin="anonymous"
    /> -->
    <!-- <link href="<?php echo base_url('assets/boostrap-icon@1.3.0/boostrap-icons.css');?>" rel="stylesheet"> -->
    <!-- <link rel="stylesheet" href="assets/datatables/DataTables-1.12.1/css/dataTables.bootstrap5.css">     -->
    <!-- <link rel="stylesheet" href="assets/datatables/DataTables-1.12.1/css/jquery.dataTables.min.css"> -->
    
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css"> -->
    <link href="<?php echo base_url('assets/datatables/DataTables-1.12.1/css/jquery.dataTables.css');?>" rel="stylesheet">

    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css"> -->
    <link href="<?php echo base_url('assets/datatables/Buttons-2.2.3/css/buttons.bootstrap5.min.css');?>" rel="stylesheet">
   
</head> 
<body>
    
    <?php //include('application/views/nav_bar.php'); ?>
    <?php 
        include('application/views/supervisor/student_score.php');
     ?>
    <?php 
        //include('application/views/footer2.php'); 
    ?>
  
    
    <script src="<?php echo base_url('assets/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js');?>"></script>
</body>
</html>