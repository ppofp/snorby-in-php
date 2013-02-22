	<!-- advanced search -->	
  		<div class="container advanced_search">
			<div class='tabbed_content'>
				<div class='tabs'>
					<div class='moving_bg'>
						&nbsp;
					</div>
					<span class='tab_item'>
						Time
					</span>
					<span class='tab_item'>
						Protocol
					</span>
					<span class='tab_item'>
						Signature
					</span>
					<span class='tab_item'>
						Sensor
					</span>	
					<span class="tab_item">
						IP
					</span>
					<span class='tab_item'>
						Search
					</span>
				</div>
			 
				<div class='slide_content'>
					<div class='tabslider'>
						<style>
						.ui-timepicker-div .ui-widget-header { margin-bottom: 8px; }
						.ui-timepicker-div dl { text-align: left; }
						.ui-timepicker-div dl dt { height: 25px; margin-bottom: -25px; }
						.ui-timepicker-div dl dd { margin: 0 10px 10px 65px; }
						.ui-timepicker-div td { font-size: 90%; }
						.ui-tpicker-grid-label { background: none; border: none; margin: 0; padding: 0; }

						.ui-timepicker-rtl{ direction: rtl; }
						.ui-timepicker-rtl dl { text-align: right; }
						.ui-timepicker-rtl dl dd { margin: 0 65px 10px 10px; }
						</style>
						<div class="row" id="time">
							<div class="span3">
								<div class="input-prepend">
								  <span class="add-on">开始</span>
								  <input class="span2 timepicker" placeholder="" value="<?php echo date("m/d/Y H:i", strtotime("-24hour"));?>" id="start" type="text"/>
								</div>
							</div>
							
							<div class="span3">
								<div class="input-prepend">
								  <span class="add-on">结束</span>
								  <input class="span2 timepicker" placeholder="" value="<?php echo date("m/d/Y H:i");?>" id="end" type="text"/>
								</div>
							</div>
							
							<div class="span3">
								<div class="input-prepend">
									<span class="add-on">Axis</span>
									<select id="axis">
										<option value="year">Year</option>
										<option value="month">Month</option>
										<option value="day">Day</option>
										<option value="hour" selected="selected">Hour</option>
										<option value="minute">Minute</option>
									</select>
								</div>
							</div>
						</div>

						<div class="row" id="protocol">
							<div class="span12">
								<label class="checkbox">
								  <input type="checkbox" checked="checked" class="checkAll"/>
								  全选
								</label>
								<div class="span2">
									<label class="checkbox">
									  <input type="checkbox"  checked="checked" name="protocol" value="1"/>
									  ICMP
									</label>
								</div>
								<!--
								<div class="span2">
									<label class="checkbox">
									  <input type="checkbox"  checked="checked" name="protocol" value=""/>
									  DNS
									</label>
								</div>-->
								<div class="span2">
									<label class="checkbox">
									  <input type="checkbox"  checked="checked" name="protocol" value="6"/>
									  TCP
									</label>
								</div>
								<div class="span2">
									<label class="checkbox">
									  <input type="checkbox"  checked="checked" name="protocol" value="17"/>
									  UDP
									</label>
								</div>
							</div>
						</div>

						<div class="row" id="signature">
							  <div class="controls">
								<label class="checkbox">
								  <input type="checkbox"  checked="checked" class="checkAll"/>
								  全选
								</label>
							<?php $sig_show = array_slice($signatures, 0, 9);
								  $sig_hidden = array_slice($signatures, 9);?>
							<?php foreach($sig_show as $sig): ?>
								<div class="span3">
									<label class="checkbox">
									  <input type="checkbox"  checked="checked" name="signature" value="<?php echo  $sig['id'];?>"/>
									  <?php echo substr($sig['name'],0,20),'...'; ?>
									</label>
								</div>
							<?php endforeach; ?>
								
							<?php if(count($sig_hidden) > 0):?>
								<a href="#" id="unfold_sig">更多</a>
								<div id="hidden_sig" style="display:none">
								<?php foreach($sig_hidden as $sig):?>
									<div class="span3">
										<label class="checkbox">
										  <input type="checkbox"  checked="checked" name="signature" value="<?php echo  $sig['id'];?>"/>
										  <?php echo substr($sig['name'],0,20),'...'; ?>
										</label>
									</div>
								<?php endforeach;?>
								</div>
							<?php endif;?>
							 </div>
						</div>
						
						<div class="row" id="sensor">
								<label class="checkbox">
								  <input type="checkbox"  checked="checked" class="checkAll"/>
								  全选
								</label>
								<?php foreach($sensors as $sensor):?>
								<div class="span3">
									<label class="checkbox">
									  <input type="checkbox"  checked="checked" name="sensor" value="<?php echo $sensor['sid'];?>"/>
									  <?php echo $sensor['sid'] . ":" . $sensor['hostname'] . ":" . $sensor['interface'];?>
									</label>
								</div>
								<?php endforeach; ?>						
						</div>
						
						<div class="row" id="ip">
							<label class="checkbox">
								  <input type="checkbox" class="checkAllIP" checked="checked"/>
								  所有
							</label>
							<br/>
							<div class="row">
								<div class="input-prepend">
									<span class="add-on">IP Type</span>
									<select id="ipType" disabled="disabled">
										<option value="src">Source</option>
										<option value="dst">Destination</option>
									</select>
									<input placeholder="127.0.0.1,192.168.0.1" id="ipaddr" disabled="disabled" type="text"/>
								</div>								
							</div>
						</div>
						
						<div class="row" id="searchType">
								<div class="span3">
									<label class="radio">
									  <input type="radio" value="graph" checked="checked" name="searchType"/>
									  统计图
									</label>
								</div>
								<div class="span3">
									<label class="radio">
									  <input type="radio" value="list" name="searchType"/>
									  事件列表
									</label>
								</div>
								<div class="row">
									<button class="btn btn-success" id="btnSearch">搜索</button>
									<button class="btn btn-success" id="btnExport">导出</button>
								</div>
						</div>
			 
					</div>
				</div>
			</div>
		</div>
			  <form id="hiddenForm" style="display: none" method="POST" action="" graphUrl="<?php echo site_url('dashboard');?>" listUrl="<?php echo site_url('event');?>">
				<input type="text" name="params" value='<?php echo $params;?>' id="params"/>
				<input type="text" name="page" value="" id="page"/>
			  </form>
		<!-- end of advanced search -->