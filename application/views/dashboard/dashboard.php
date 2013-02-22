<div class="container box-holder">
	<div class="row">
		<!-- high severity graph -->
		<div class='span4 box'>
				<div class='content shadow-in'>
					<div class='data'>
						
						<div class='box-count'>
							<?php echo array_sum($high); ?>
						</div>
						
						<div class="box-title">
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
		<div class='span4 box'>
				<div class='content shadow-in'>
					<div class='data'>
						
						<div class='box-count'>
							<?php echo array_sum($medium); ?>
						</div>
						
						<div class="box-title">
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
		<div class='span4 box'>
				<div class='content shadow-in'>
					<div class='data'>
						
						<div class='box-count'>
							<?php echo array_sum($low); ?>
						</div>
						
						<div class="box-title">
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
</div>
				
<div class="container">
	<div class="tabbable">
		<ul class="nav nav-tabs" id="graph_tab">
			<li class="active"><a href="#show_events_graph" data-toggle="tab">Sensors</a></li>
			<li><a href="#show_severities_graph" data-toggle="tab">Severities</a></li>
			<li><a href="#show_protocol_graph" data-toggle="tab">Protocols</a></li>
			<li><a href="#show_signature_graph" data-toggle="tab">Signatures</a></li>
			<li><a href="#show_source_ips_graph" data-toggle="tab">Sources</a></li>
			<li><a href="#show_destination_ips_graph" data-toggle="tab">Destinations</a></li>

		</ul>
		
		<div class="tab-content line-chart">	
			<div class="tab-pane active" id="show_events_graph">
				<div id='events-graph'  style="width:87%"></div>
			</div>

			<div class="tab-pane" id="show_severities_graph">
				<div id='severity-graph'  style="width:60%"></div>
			</div>

			<div class="tab-pane" id="show_protocol_graph">
				<div id='protocol-graph' style="width:60%"></div>
			</div>

			<div class="tab-pane" id="show_signature_graph">
				<div id='signature-graph' style="width:60%"></div>
			</div>

			<div class="tab-pane" id="show_source_ips_graph">
				<div id='source-ips-graph' style="width:60%"></div>
			</div>
			
			<div class="tab-pane" id="show_destination_ips_graph">
				<div id='destination-ips-graph' style="width:60%"></div>
			</div>		
		</div>
	</div>
</div>

<script type="text/javascript" src="<?php echo base_url('public/js/jquery.sparkline.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('public/js/highcharts.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('public/js/highcharts.exporting.js');?>"></script>
<script type="text/javascript">
var sev1_bg_color = '#eb0000';
var sev2_bg_color = '#ffab2e';
var sev3_bg_color = '#00ab00';

//severity的三张柱状图
$('#sev1-graph').sparkline([<?php echo implode($high, ",")?>],{barWidth: 10, height: 100, type: 'bar', barColor: sev1_bg_color} );
$('#sev2-graph').sparkline([<?php echo implode($medium, ",")?>],{barWidth: 10, height: 100, type: 'bar', barColor: sev2_bg_color} );
$('#sev3-graph').sparkline([<?php echo implode($low, ",")?>],{barWidth: 10, height: 100, type: 'bar', barColor: sev3_bg_color} );


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
						text: "<?php echo $axis_desp; ?>"
		 },
		 labels: {
                staggerLines: 2
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
						text: "<?php echo $axis_desp; ?>"
		 },
		 labels: {
                staggerLines: 2
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
						text: "<?php echo $axis_desp; ?>"
		 },
		 labels: {
                staggerLines: 2
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
	  series: [<?php foreach($proto as $key=>$value):?>
			{
				name: "<?php echo $key;?>",
				data: [<?php echo implode(',', $value);?>]
			},<?php endforeach;?>]
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