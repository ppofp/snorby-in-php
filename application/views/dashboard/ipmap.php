<div class="container" style="height:520px;">
	<div id="map_canvas" style="width:100%; height:100%;border:4px solid #eee;"></div>
</div>
<script>
<?php foreach($threat_ips as $key=>$ip):?>
var <?php echo '$marker' . $key; ?> = $('#map_canvas').gmap('addMarker', {'position': "<?php echo $ip['latitude'] . ',' . $ip['longitude'];?>", 'bounds': true});
<?php echo '$marker' . $key; ?>.click(function() {
	$('#map_canvas').gmap('openInfoWindow', {'content': "<strong>Country:</strong><?php echo $ip['country'];?><br/><strong>City:</strong><?php echo $ip['city'];?><br/><strong>IP:</strong><?php echo $ip['ipaddr'];?><br/><strong>Events:</strong><?php echo $ip['cnt'];?><br/>"}, this);
});
<?php endforeach;?>
</script>