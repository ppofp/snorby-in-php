<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
		<title>Demon - Dashboard</title>
		<meta http-equiv="X-UA-Compatible" content="chrome=1">
		<meta name="description" content="Snorby - All About Simplicity" />
		<link rel="icon" href="/images/favicon.png" type="image/png" />
		<script type="text/javascript" src="/js/jqueryallinone.js"></script>
		<script type="text/javascript" src="/js/snorby.js"></script>
		<link href="/css/snorby.css" media="all" rel="stylesheet" type="text/css" />
		
				<style type="text/css">
        ul.table li div.small span.severity.sev1,
        span.severity.sev1{
					background-color: #eb0000;
					color: #ffffff;
				}
        ul.table li div.small span.severity.sev2,
        span.severity.sev2{
					background-color: #ffab2e;
					color: #ffffff;
				}
        ul.table li div.small span.severity.sev3,
        span.severity.sev3{
					background-color: #00ab00;
					color: #ffffff;
				}
		</style>
		
	</head>
  
	<body>
		
		<div id="header">
			<div id="header-inside">
				<div id="header-content">
					<div id="header-top" class='container_12'>
						<div id="logo" class='grid_6'>
						<a href="/">Snorby</a>
						</div>
						
						<div id="user-menu" class=''>
							<ul>
								<li class='first'>Welcome Demo</li>
								<li><a href="/users/edit">Settings</a></li>
								<li class='last'><a href="/users/logout">Log out</a></li>
							</ul>
						</div>
					</div>
				</div>
		
				<div id="menu">
					<ul class='container_12'>
						<li class='item blank first'></li>
						<li class='item'><a href="/dashboard">Dashboard</a></li>
						<li class='item'><a href="/events/queue">My Queue (<span class='queue-count'>27</span>)</a></liü>
						<li class='item'><a href="/events">Events</a></li>
						<li class='item'><a href="/sensors">Sensors</a></li>
						<li class='item'><a href="/search">Search</a></li>
						<li class='item blank last'></li>
						<li class='administration right'><a href="/settings">Administration</a></li>
						<dl id="admin-menu" style='display:none;'>
					  
						  <dd>
							<a href="/settings">General Settings</a>
						  </dd>

							<div class="admin-arrow"></div>

						  <dd>
							<a href="/classifications">Classifications</a>
						  </dd>

						  <dd>
							<a href="/sensors">Sensors</a>
						  </dd>

						  <dd>
							<a href="/lookups">Lookup Sources</a>
						  </dd>

						  <dd>
							<a href="/severities">Severities</a>
						  </dd>

						  <dd>
							<a href="/signatures">Signatures</a>
						  </dd>

						  <dd>
							<a href="/users">Users</a>
						  </dd>

						  <dd>
							<a href="/jobs">Worker & Job Queue <span class='shortcut'>ctrl+3</span></a>
						  </dd>
			
						</dl>
					</ul>
					
				</div>
		
			</div>
		</div>