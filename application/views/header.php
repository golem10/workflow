<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<title><?php echo "ELIZAB Workflow | ".$site_info["title"]; ?></title>
		<link rel="stylesheet" href="<?php echo base_url('/bootstrap/css/bootstrap.min.css')?>">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
		<link rel="stylesheet" href="<?php echo base_url("/dist/css/AdminLTE.min.css");?>">
		<link rel="stylesheet" href="<?php echo base_url("/dist/css/skins/skin-blue.min.css");?>">
		<link rel="stylesheet" href="<?php echo base_url("/plugins/datatables/dataTables.bootstrap.css");?>">
		<link rel="stylesheet" href="<?php echo base_url("/plugins/iCheck/all.css");?>">
		<link rel="stylesheet" href="<?php echo base_url("/plugins/datepicker/datepicker3.css");?>">
		<?php if($css)
				foreach($css as $item)
					echo '<link rel="stylesheet" href="'.base_url("css/".$item).'" type="text/css" media="screen" charset="utf-8"/>';
		 ?>
		<script src="<?php echo base_url("/plugins/jQuery/jQuery-2.1.4.min.js");?>"></script>
		<script src="<?php echo base_url("/bootstrap/js/bootstrap.min.js");?>"></script>
		<script src="<?php echo base_url("/dist/js/app.min.js");?>"></script>
		<script src="<?php echo base_url("/plugins/datatables/jquery.dataTables.js");?>"></script>
		<script src="<?php echo base_url("/plugins/datatables/dataTables.bootstrap.min.js");?>"></script>
		<script src="<?php echo base_url("/plugins/iCheck/icheck.min.js");?>"></script>
		<script src="<?php echo base_url("/plugins/datepicker/bootstrap-datepicker.js");?>"></script>
		 <?php if($js)
				foreach($js as $item)
					echo '<script type="text/javascript" language="javascript" src="'.base_url("js/".$item).'"></script>';
		 ?>
	</head>
	<body class="hold-transition skin-blue sidebar-mini">
	<div class="wrapper">

      <!-- Main Header -->
      <header class="main-header">

        <!-- Logo -->
        <a href="<?php echo base_url();?>" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>E</b>wf</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>ELIZAB</b> Workflow</span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- Messages: style can be found in dropdown.less-->
              
              <!-- User Account Menu -->
              <li class="dropdown user user-menu">
                <!-- Menu Toggle Button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <!-- The user image in the navbar-->
                  <!-- hidden-xs hides the username on small devices so only the image appears. -->
                  <span class="hidden-xs"><?php echo $this->session->userdata('user_name'); ?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- The user image in the menu -->
                  <li class="user-header" style="height:auto">                  
                    <p>
                     <?php echo $this->session->userdata('user_name'); ?>                   
                    </p>
                  </li>
                  <!-- Menu Body -->
                 
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="<?php echo base_url("users/changePassword");?>" class="btn btn-default btn-flat">Zmień hasło</a>
                    </div>
                    <div class="pull-right">
                      <a href="<?php echo base_url("login/out");?>" class="btn btn-default btn-flat">Wyloguj</a>
                    </div>
                  </li>
                </ul>
              </li>
              <!-- Control Sidebar Toggle Button -->
              <li>
                <a href="<?php echo base_url("login/out");?>" ><i class="fa  fa-power-off"></i></a>
              </li>
            </ul>
          </div>
        </nav>
      </header>

	