<!-- Demon - Version: 1.0 -->

<html class='login'>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
		<title>Snorby - Please log in to continue...</title>
		<link href="<?php echo base_url('css/login.css');?>" media="all" rel="stylesheet" type="text/css" />
		<script src="<?php echo base_url('js/login.js');?>" type="text/javascript"></script>
	</head>
  
	<body class='login'>
		<div id="login">
			<div id="wrapper">
				<div id="content">
					<div id="title">
						<div class="grid" id="title-header">Please log in to continue...</div>
					</div>
					
					<div id="signin">
						<form accept-charset="UTF-8" action="<?php echo site_url(); ?>/users/login" class="validate" id="user_new" method="post">	
							<p>
								<label for="user_email">Email</label>
								<br />
								<input autocomplete="off" class="required email" id="user_email" name="user[email]" placeholder="example@example.com" size="30" type="text" value="" />
							</p>

							<p>
								<label for="user_password">Password</label>
								<br />
								<input autocomplete="off" class="required password" id="user_password" name="user[password]" placeholder="P@ssw0rd" size="30" type="password" />
							</p>
							
							<div id="form-actions">
								<button class="success default"><span>登录</span></button>
							</div>
						</form>	
					</div>
				</div>
			</div>
		</div>
	</body> 
</html> 
