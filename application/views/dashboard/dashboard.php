<div id="wrapper">
	<div id="content" class="container_12">
		<div id="title">
		
		
		
		<div class="grid_6" id="title-header">Dashboard</div>
		<ul class="" id="title-menu-holder">
			<ul id="title-menu">
				<li>&nbsp;</li>
				<li>
					<a href="#" class="has_dropdown right-more" id="options"><img alt="Filter" height="16" src="/images/icons/filter.png" width="16" /> More Options</a>
					<dl class="drop-down-menu" id="options" style="display:none;">
						<dd><a href="/dashboard?range=last_week" class="dashboard">Last Week</a></dd>
						<dd><a href="/dashboard?range=last_month" class="dashboard">Last Month</a></dd>
						<dd><a href="/dashboard.pdf?range=year" class="dashboard">Export To PDF</a></dd>
						<dd><a href="/force/cache" class="force-cache-update">Force Cache Update</a></dd>
					</dl>
				</li>
				<li>&nbsp;</li>
			</ul>
		</ul>
		
		
		
		</div>
		
		<div id="dashboard">
			<div class="main grid_9">
				<div class="dashboard-menu">
					<ul>
						<li class=' <?php if($range == "last_24") echo "active "; ?> add_tipsy' title=""><a href="<?php echo site_url('/dashboard?range=last_24'); ?>">Last 24</a></li>		
						<li class=' <?php if($range == "today") echo "active "; ?>add_tipsy' title="Saturday, January 19, 2013"><a href="<?php echo site_url('/dashboard?range=today');?>">Today</a></li>	
						<li class=' <?php if($range == "yesterday") echo "active "; ?>add_tipsy' title="Friday, January 18, 2013"><a href="<?php echo site_url('/dashboard?range=yesterday');?>">Yesterday</a></li>
						<li class=' <?php if($range == "week") echo "active "; ?>add_tipsy' title=""><a href="<?php echo site_url('/dashboard?range=week');?>">This Week</a></li>  
						<li class=' <?php if($range == "month") echo "active "; ?>add_tipsy' title="January"><a href="<?php echo site_url('/dashboard?range=month');?>">This Month</a></li>		
						<li class=' <?php if($range == "quarter") echo "active "; ?>add_tipsy' title=""><a href="<?php echo site_url('/dashboard?range=quarter');?>">This Quarter</a></li>
						<li class=' <?php if($range == "year") echo "active "; ?>add_tipsy' title="2013"><a href="<?php echo site_url('/dashboard?range=year');?>">This Year</a></li>		
						<li class='right last-cache-time'>
						<i>Updated: </i>
						</li>
					</ul>
				</div>
				
				<div id="box-holder">

					
					<!-- high severity graph -->
					<div class='box grid_3 alpha shadow round'>
	
						<div class='content shadow-in'>
							<div class='data'>
								
								<div id='box-count'>
									<?php echo array_sum($high); ?>
								</div>
								
								<div id="box-title">
									High Severity
								</div>
								
								<div class='box-graph' id='sev1-graph'></div>
								
							</div>
						</div>
					
						<div class='footer'>
							<span><?php echo array_sum($high); ?> / <?php echo $event_count; ?></span> 
						</div>
					</div>
					
					<!-- medium severity graph -->
					<div class='box grid_3 alpha shadow round'>
	
						<div class='content shadow-in'>
							<div class='data'>
								
								<div id='box-count'>
									<?php echo array_sum($medium); ?>
								</div>
								
								<div id="box-title">
									Medium Severity
								</div>
								
								<div class='box-graph' id='sev2-graph'></div>
								
							</div>
						</div>
					
						<div class='footer'>
							<span><?php echo array_sum($medium); ?> / <?php echo $event_count; ?></span> 
						</div>
					</div>
					
					<!-- low severity graph -->
					<div class='box grid_3 alpha shadow round'>
	
						<div class='content shadow-in'>
							<div class='data'>
								
								<div id='box-count'>
									<?php echo array_sum($low); ?>
								</div>
								
								<div id="box-title">
									Low Severity
								</div>
								
								<div class='box-graph' id='sev3-graph'></div>
								
							</div>
						</div>
					
						<div class='footer'>
							<span><?php echo array_sum($low); ?> / <?php echo $event_count; ?></span> 
						</div>
					</div>
					
				</div>
				

				
				<div id="box-tabs">
					<ul id="box-menu">
						<li class="active"><a href="#" class="show_events_graph">Sensors</a></li>
						<li><a href="#" class="show_severities_graph">Severities</a></li>
						<li><a href="#" class="show_protocol_graph">Protocols</a></li>
						<li><a href="#" class="show_signature_graph">Signatures</a></li>
						<li><a href="#" class="show_source_ips_graph">Sources</a></li>
						<li><a href="#" class="show_destination_ips_graph">Destinations</a></li>
					</ul>
				</div>
				
				<div class="box-large round">
					<div class='box-large-inside'>
						<div id='events-graph' class='dashboard-graph'></div>
						<div id='severity-graph' style='display:none;' class='dashboard-graph'></div>
						<div id='protocol-graph' style='display:none;' class='dashboard-graph'></div>
						<div id='signature-graph' style='display:none;' class='dashboard-graph'></div>
						<div id='source-ips-graph' style='display:none;' class='dashboard-graph'></div>
						<div id='destination-ips-graph' style='display:none;' class='dashboard-graph'></div>
					</div>
				</div>
			</div>
			<div id="secondary">
			</div>
		</div>
	</div>
</div>

<script type="text/javascript" src="/js/jquery.sparkline.js"></script>
<script type="text/javascript" src="/js/highcharts.js"></script>
<script type="text/javascript">
var sev1_bg_color = '#eb0000';
var sev2_bg_color = '#ffab2e';
var sev3_bg_color = '#00ab00';

//severity的三张柱状图
$('#sev1-graph').sparkline([<?php echo implode($high, ",")?>],{barWidth: 6, height: 40, type: 'bar', barColor: sev1_bg_color} );
$('#sev2-graph').sparkline([<?php echo implode($medium, ",")?>],{barWidth: 6, height: 40, type: 'bar', barColor: sev2_bg_color} );
$('#sev3-graph').sparkline([<?php echo implode($low, ",")?>],{barWidth: 6, height: 40, type: 'bar', barColor: sev3_bg_color} );

//event graph
chart = new Highcharts.Chart({
	  chart: {
		 renderTo: 'events-graph',
		 defaultSeriesType: 'spline',
		 marginRight: 80,
					marginLeft: 80,
					marginTop: 50,
		 marginBottom: 50
	  },
  credits: {
	enabled: false
  },
	  title: {
		 text: 'Event Count vs Time By Sensor',
		 x: -20 //center
	  },
	  xAxis: {
	categories: [<?php echo implode( ",",$axis); ?>],
		title: {
						margin: 10,
						<?php if ($range == 'year' || $range == 'quarter'): ?>
							text: 'Month of Year'
						<?php elseif ($range == 'month' || $range == 'last_month'): ?>
							text: 'Date of Month'
						<?php elseif ($range == 'week' || $range == 'last_week'): ?>
							text: 'Date Of Week'
						<?php elseif ($range == 'last_24'): ?>
							text: 'Last 24 Hours'
						<?php else: ?>
							text: 'Hour of Day'
						<?php endif; ?>
		 }
	  },
	  yAxis: {
		 title: {
			text: 'Event Count'
		 },
		 plotLines: [{
			value: 0,
			width: 1,
			color: '#808080'
		 }]
	  },
	  tooltip: {
		   formatter: function() {
				   return '<b>'+ this.series.name +'</b><br/>'+ this.y + ' Events';
		 }
	},
	  legend: {
		 layout: 'vertical',
		 align: 'right',
		 verticalAlign: 'top',
		 x: 0,
		 y: 0,
		 borderWidth: 0,
				 borderRadius: 0,
				 borderColor: '#ddd',
				 backgroundColor: '#fff'
	  },
	  series: [<?php foreach($sensor_metrics as $key=>$value): ?>
				{
					name:'<?php echo $key;?>',
					data:[<?php echo implode(",", $value);?>]
				},
				<?php endforeach;?>
				]
   });
   
//severity graph
chart = new Highcharts.Chart({
	  chart: {
		 renderTo: 'severity-graph',
		 defaultSeriesType: 'spline',
		 marginRight: 80,
					marginLeft: 80,
					marginTop: 50,
		 marginBottom: 50
	  },
  credits: {
	enabled: false
  },
	  title: {
		 text: 'Severity Count vs Time',
		 x: -20 //center
	  },
	  xAxis: {
	categories: [<?php echo implode(",", $axis); ?>],
		title: {
						margin: 10,
						<?php if ($range == 'year' || $range == 'quarter'): ?>
							text: 'Month of Year'
						<?php elseif ($range == 'month' || $range == 'last_month'): ?>
							text: 'Date of Month'
						<?php elseif ($range == 'week' || $range == 'last_week'): ?>
							text: 'Date Of Week'
						<?php elseif ($range == 'last_24'): ?>
							text: 'Last 24 Hours'
						<?php else: ?>
							text: 'Hour of Day'
						<?php endif; ?>
		 }
	  },
	  yAxis: {
		 title: {
			text: 'Severity Count'
		 },
		 plotLines: [{
			value: 0,
			width: 1,
			color: '#808080'
		 }]
	  },
	  tooltip: {
		 formatter: function() {
				   return '<b>'+ this.series.name +'</b><br/>'+ this.y + ' Events';
		 }
	  },
	  legend: {
		 layout: 'vertical',
		 align: 'right',
		 verticalAlign: 'top',
		 x: 0,
		 y: 0,
		 borderWidth: 0,
				 borderRadius: 0,
				 borderColor: '#ddd',
				 backgroundColor: '#fff'
	  },
	  series: [{
	name: 'High Severity',
	color: sev1_bg_color,
				data: [<?php echo implode(',', $high);?>]
			},{
				name: 'Medium Severity',
	color: sev2_bg_color,
				data: [<?php echo implode(',', $medium);?>]
			},{
	name: 'Low Severity',
	color: sev3_bg_color,
				data: [<?php echo implode(',', $low);?>]
			}]
   });
   
//protocol graph
chart = new Highcharts.Chart({
	  chart: {
		 renderTo: 'protocol-graph',
		 defaultSeriesType: 'spline',
		 marginRight: 80,
					marginLeft: 80,
					marginTop: 50,
		 marginBottom: 50
	  },
  credits: {
	enabled: false
  },
	  title: {
		 text: 'Protocol Count vs Time',
		 x: -20 //center
	  },
	  xAxis: {
	categories: [<?php echo implode(",", $axis); ?>],
		title: {
						margin: 10,
						<?php if ($range == 'year' || $range == 'quarter'): ?>
							text: 'Month of Year'
						<?php elseif ($range == 'month' || $range == 'last_month'): ?>
							text: 'Date of Month'
						<?php elseif ($range == 'week' || $range == 'last_week'): ?>
							text: 'Date Of Week'
						<?php elseif ($range == 'last_24'): ?>
							text: 'Last 24 Hours'
						<?php else: ?>
							text: 'Hour of Day'
						<?php endif; ?>
		 }
	  },
	  yAxis: {
		 title: {
			text: 'Protocol Count'
		 },
		 plotLines: [{
			value: 0,
			width: 1,
			color: '#808080'
		 }]
	  },
	  tooltip: {
		 formatter: function() {
				   return '<b>'+ this.series.name +'</b><br/>'+ this.y + ' Events';
		 }
	  },
	  legend: {
		 layout: 'vertical',
		 align: 'right',
		 verticalAlign: 'top',
		 x: 0,
		 y: 0,
		 borderWidth: 0,
				 borderRadius: 0,
				 borderColor: '#ddd',
				 backgroundColor: '#fff'
	  },
	  series: [{
				name: 'TCP',
				data: [<?php echo implode(',', $tcp);?>]
			},{
				name: 'UDP',
				data: [<?php echo implode(',', $udp);?>]
			},{
				name: 'ICMP',
				data: [<?php echo implode(',', $icmp);?>]
			}]
   });
   
//signature graph
pie = new Highcharts.Chart({
	  chart: {
		 renderTo: 'signature-graph',
		 margin: [50, 165, 50, 160]
	  },
  credits: {
	enabled: false
  },
	  title: {
		 text: ''
	  },
	  tooltip: {
		 formatter: function() {
			return "<b>" + this.point.name.substring(0, 30) + "</b>... (" + this.y + " events)"
		 }
	  },
	  plotOptions: {
		 pie: {
	  events: {
		click: function(event) {
		}
	  },
			allowPointSelect: true,
			cursor: 'pointer',
						dataLabels: {
								distance: 20,
							  formatter: function() {
								return "" + this.point.name.substring(0, 30) + "... (" + Math.round(this.percentage) + "%)"
							 },
				connectorColor: '#888',
								style: {
									fontSize: 10
								}
			}
		 }
	  },
		legend: {
			enabled: false
		},
	   series: [{
		 type: 'pie',
		 name: 'Signatures',
		 data: [
					<?php foreach($signature_metrics as $key=>$value): ?>
						['<?php echo $key; ?>', <?php echo $value; ?>],
					<?php endforeach; ?>
		 ]
	  }]
   });


//source graph
chart = new Highcharts.Chart({
  chart: {
	 renderTo: 'source-ips-graph',
	 margin: [50, 165, 50, 160]
  },
credits: {
enabled: false
},
  title: {
	 text: ''
  },
  tooltip: {
	 formatter: function() {
		return "<b>" + this.point.name.substring(0, 30) + "</b>... (" + this.y + " sessions)"
	 }
  },
  plotOptions: {
	 pie: {
 events: {
	click: function(event) {
	 },
  },
		allowPointSelect: true,
		cursor: 'pointer',
					dataLabels: {
							distance: 20,
						  formatter: function() {
							return "" + this.point.name.substring(0, 30) + "... (" + Math.round(this.percentage) + "%)"
						 },
			connectorColor: '#888',
							style: {
								fontSize: 10
							}
		}
	 }
  },
	legend: {
		enabled: false
	},
   series: [{
	 type: 'pie',
	 name: 'Unique Source Addresses',
 data: [
		<?php foreach($src_metrics as $key=>$value): ?>
		['<?php echo $key; ?>', <?php echo $value; ?>],
		<?php endforeach; ?>
	 ]
  }]
});

//destination graph
chart = new Highcharts.Chart({
	  chart: {
		 renderTo: 'destination-ips-graph',
		 margin: [50, 165, 50, 160]
	  },
  credits: {
	enabled: false
  },
	  title: {
		 text: ''
	  },
	  tooltip: {
		 formatter: function() {
			return "<b>" + this.point.name.substring(0, 30) + "</b>... (" + this.y + " sessions)"
		 }
	  },
	  plotOptions: {
		 pie: {
	  events: {
		click: function(event) {
		 },
	  },
			allowPointSelect: true,
			cursor: 'pointer',
						dataLabels: {
								distance: 20,
							  formatter: function() {
								return "" + this.point.name.substring(0, 30) + "... (" + Math.round(this.percentage) + "%)"
							 },
				connectorColor: '#888',
								style: {
									fontSize: 10
								}
			}
		 }
	  },
		legend: {
			enabled: false
		},
	   series: [{
		 type: 'pie',
		 name: 'Unique Destination Addresses',
		 data: [
		<?php foreach($dst_metrics as $key=>$value): ?>
		['<?php echo $key; ?>', <?php echo $value; ?>],
		<?php endforeach; ?>
		 ]
	  }]
   });

</script>