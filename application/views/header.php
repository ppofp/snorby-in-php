<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
		<title>Demon</title>
		<script src="<?php echo base_url('public/js/jquery.js'); ?>"></script>
		<script src="<?php echo base_url('public/js/jquery.json.js'); ?>"></script>
		<script src="<?php echo base_url('public/js/jquery-ui-1.10.0.custom.js'); ?>"></script>
		<script src="<?php echo base_url('public/js/jquery-ui-timepicker-addon.js'); ?>"></script>
		<script src="<?php echo base_url('public/js/bootstrap.js'); ?>"></script>
		<script src="<?php echo base_url('public/js/demon.js'); ?>"></script>
		<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA9iAPk6tI86Q9R1xyV62iVZSDizha1hXk&sensor=false"></script>
		<script src="<?php echo base_url('public/js/jquery.ui.map.full.min.js'); ?>"></script>
		<link href="<?php echo base_url('public/css/bootstrap.css');?>" rel="stylesheet" media="screen">
		<link href="<?php echo base_url('public/css/jquery-ui-1.10.0.custom.css');?>" rel="stylesheet" media="screen">
		<link href="<?php echo base_url('public/css/demon.css');?>" rel="stylesheet" media="screen">
		<script type="text/javascript"> 
			siteUrl = "<?php echo site_url();?>";
		</script>
	</head>
	<body>
		<!-- header bar-->
		<div class="navbar navbar-inverse navbar-fixed-top">
			<div class="navbar-inner">
			<div class="container">
			  <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			  </button>
			  <a class="brand" href="<?php echo site_url();?>" class="active">Demon</a>
			  <div class="nav-collapse collapse">
				<ul class="nav">
				  <li class="<?php if($page == 'dashboard') echo 'active';?>">
					<a href="<?php echo site_url('dashboard');?>">仪表盘</a>
				  </li>              
				  <li class="<?php if($page == 'event') echo 'active';?>">
					<a href="<?php echo site_url('event'); ?>">事件列表</a>
				  </li>			  
				  <li class="<?php if($page == 'statistic') echo 'active';?>">
					<a href="<?php echo site_url('statistic'); ?>">统计信息</a>
				  </li>
				</ul>
				
				<ul class="nav pull-right">
					<li class="<?php if($page == 'setting') echo 'active';?>">
						<a href="<?php echo site_url('setting');?>">Settings</a>
					</li>
					<li>
						<a href="<?php echo site_url('users/logout');?>">退出</a>
					</li>
				</ul>
			  </div>
			</div>
			</div>
		</div>
		<!--end of header bar-->