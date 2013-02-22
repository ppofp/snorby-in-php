<div class="container">
	<div class="well">
	<form method="POST" action = "<?php echo site_url('statistic');?>">
		<div class="span3">
			<div class="input-prepend">
			  <span class="add-on">开始</span>
			  <input class="span2 timepicker" placeholder="" value="<?php echo date("m/d/Y H:i", $time['time_start']);?>" name="time_start" id="start" type="text"/>
			</div>
		</div>
		
		<div class="span3">
			<div class="input-prepend">
			  <span class="add-on">结束</span>
			  <input class="span2 timepicker" placeholder="" value="<?php echo date("m/d/Y H:i", $time['time_end']);?>" name="time_end" id="end" type="text"/>
			</div>
		</div>
		
		<div class="span2 pull-right">
			<input type="submit" class="btn btn-success" value="生成"/>
		</div>
	</form>
	</div>
	
	<div class="well">
		<div class="">
			<h4>Sensor:</h4>
			<ul class="unstyled">
			<?php foreach($sensors as $key=>$sensor):{?>
			<?php if($total == 0)
						$proportion = "0%";
				else
					$proportion = round(100*$sensor['cnt']/$total, 2) . "%";?>
			    <li><?php echo $sensor['sid'] . " " . $sensor['hostname'];?><span class="pull-right strong"><?php echo $sensor['cnt'] . "Events " . $proportion;?></span>
			        <div class="progress <?php 
			        	switch(round($sensor['cnt']*10/($total?$total:1)))
			        	{
			        		case 10:
			        		case 9:
			        		case 8:
			        		case 7:
			        		case 6:
			        		case 5:echo 'progress-danger';break;
			        		case 4:
			        		case 3:echo 'progress-warning';break;
			        		case 2:
			        		case 1:echo 'progress-success';break;
			        		default:echo 'progress-info';break;
			        	};
			        ?>">
			            <div class="bar" style="width: <?php echo $proportion;?>;"></div>
			        </div>
			    </li>
			<?php } endforeach;?>
			</ul>
			
			<h4>Signature:</h4>
			<ul class="unstyled">
			<?php foreach($signatures as $key=>$sig):{?>
			<?php if($total == 0)
						$proportion = "0%";
				else
					$proportion = round(100*$sig['cnt']/$total, 2) . "%";?>
			    <li><?php echo $sig['sig_name'] . "...";?><span class="pull-right strong"><?php echo $sig['cnt'] . "Events " . $proportion;?></span>
			        <div class="progress <?php 
			        	switch(round($sig['cnt']*10/($total?$total:1)))
			        	{
			        		case 10:
			        		case 9:
			        		case 8:
			        		case 7:
			        		case 6:
			        		case 5:echo 'progress-danger';break;
			        		case 4:
			        		case 3:echo 'progress-warning';break;
			        		case 2:
			        		case 1:echo 'progress-success';break;
			        		default:echo 'progress-info';break;
			        	};
			        ?>">
			            <div class="bar" style="width: <?php echo $proportion;?>;"></div>
			        </div>
			    </li>
			<?php } endforeach;?>
			</ul>

			<h4>IPSRC:</h4>
			<ul class="unstyled">
			<?php foreach($ipsrc as $key=>$ip):{?>
			<?php if($total == 0)
						$proportion = "0%";
				else
					$proportion = round(100*$ip['cnt']/$total, 2) . "%";?>
			    <li><?php echo $ip['ipaddr'];?><span class="pull-right strong"><?php echo $ip['cnt'] . "Events " . $proportion;?></span>
			        <div class="progress <?php 
			        	switch(round($ip['cnt']*10/($total?$total:1)))
			        	{
			        		case 10:
			        		case 9:
			        		case 8:
			        		case 7:
			        		case 6:
			        		case 5:echo 'progress-danger';break;
			        		case 4:
			        		case 3:echo 'progress-warning';break;
			        		case 2:
			        		case 1:echo 'progress-success';break;
			        		default:echo 'progress-info';break;
			        	};
			        ?>">
			            <div class="bar" style="width: <?php echo $proportion;?>;"></div>
			        </div>
			    </li>
			<?php } endforeach;?>
			</ul>
			
			<h4>IPDST:</h4>
			<ul class="unstyled">
			<?php foreach($ipdst as $key=>$ip):{?>
			<?php if($total == 0)
						$proportion = "0%";
				else
					$proportion = round(100*$ip['cnt']/$total, 2) . "%";?>
			    <li><?php echo $ip['ipaddr'];?><span class="pull-right strong"><?php echo $ip['cnt'] . "Events " . $proportion;?></span>
			        <div class="progress <?php 
			        	switch(round($ip['cnt']*10/($total?$total:1)))
			        	{
			        		case 10:
			        		case 9:
			        		case 8:
			        		case 7:
			        		case 6:
			        		case 5:echo 'progress-danger';break;
			        		case 4:
			        		case 3:echo 'progress-warning';break;
			        		case 2:
			        		case 1:echo 'progress-success';break;
			        		default:echo 'progress-info';break;
			        	};
			        ?>">
			            <div class="bar" style="width: <?php echo $proportion;?>;"></div>
			        </div>
			    </li>
			<?php } endforeach;?>
			</ul>
		</div>
	</div>
</div>