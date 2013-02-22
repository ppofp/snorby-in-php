<div class="container">
	<table class="table">
		<thead>
			<tr>
				<th>Sensor</th>
				<th>Source IP</th>
				<th>Destination IP</th>
				<th>Event Signature</th>
				<th>Timestamp</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($eventlist as $event):?>
			<tr class="<?php if($event['sev'] == 1) echo 'error';else if($event['sev'] == 2) echo 'warning'; else echo 'info';?>">
				<td><?php echo $event['sid'];?></td>
				<td><?php echo $event['src'];?></td>
				<td><?php echo $event['dst'];?></td>
				<td><?php echo $event['sig_name'] . '...';?></td>
				<td><?php echo $event['timestamp'];?></td>
			</tr>
			<?php endforeach;?>
		</tbody>
	</table>
	<div class="pagination pagination-large">
		<ul>
			<li class="<?php if($current_page == 1) echo 'disabled'; ?>"><a id="prev" href="#">Prev</a></li>
			<?php 
				$total_page = ceil($event_count / 20 );
				$start_page = (($current_page - 4) > 0) ? ($current_page -4) : 1;
				$end_page = ($start_page + 8) <= $total_page ? ($start_page + 8) : $total_page; 
				for(;$start_page <= $end_page; $start_page++)
				{
					echo '<li class="';
					if($start_page == $current_page)
						echo "disabled current_page";
					echo '"><a class="page_index" href="#">';
					echo $start_page;
					echo "</a></li>";
				}?>
			<li class="<?php if($current_page == $total_page) echo 'disabled'; ?>"><a id="next" href="#">Next</a></li>
		</ul>
	</div>
</div>