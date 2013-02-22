<style type="text/css">
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

<div id="wrapper">
	<div id="content" class='container_12'>

	<div id="title"><div class="grid_6" id="title-header">Snorby Advanced Search</div>
		<ul class="" id="title-menu-holder">
			<ul id="title-menu"><li>&nbsp;</li>

				<li><a href="#" class="has_dropdown right-more" id="options"><img alt="Filter" height="16" src="/images/icons/filter.png" width="16" /> More Options</a>
					<dl class="drop-down-menu" id="options" style="display:none;">

					<dd><a href="/saved/searches/new" class="snorbybox">Save Current Search</a></dd>

					<dd><a href="/saved/searches">View Saved Searches</a></dd>

					<dd><a href="#" class="reset-search-form">Reset Search Form</a></dd>

					</dl>
				</li>
				<li>&nbsp;</li>
			</ul>
		</ul>
	</div>
	
	
	
	
	
	
	
	<div id="search" class="boxit page grid_12">

	<!--
	  <div class="search-match-box" style="display:;">
		Match 
		<select class="global-match-setting">
		  <option value="any">Any</option>
		  <option value="all" selected="selected">All</option>
		</select> 
		of the following rules: 
	  </div>
	-->
	<!--
	  <div class="other-search-options" style="display:;">
		<input name="limit-all-search-rules" type="checkbox"> 
		Limit to
		<input class="limit-search-results-count" name="limit-search-results-to" type="text" value="10000"> 
		ordered by
		<select><option value="any">Event Timestamp</option><option value="all">All</option></select>
		<br>
		<input name="ignore-classified-events" type="checkbox"> Ignore all classified events.
	  </div>
		-->
		<form method="get" id="search_form"action="<?php echo site_url('search/results');?>">
			<div>
				<input type="radio" name="time_horizon" checked="checked"/>
				<p>From:<input type='text' class="datepicker" placeholder="2013/1/1" name="time_begin"/></p>
				<br/>
				<p>To:&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' class="datepicker" placeholder="2013/1/1" name="time_end"/></p>
			</div>
			
			<div>
			<input type="radio" name="engine" checked="checked"/>
				<p>Engine</p>
				<input type="checkbox" name="ip"/>ip<br/>
				<input type="checkbox" name="tcp"/>tcp<br/>
				<input type="checkbox" name="udp"/>udp<br/>
			</div>
			<div id="form-actions">
				<button class="submit-search success default"><span>Submit Search</span></button>
			</div>
		</form>
	</div>

	</div>
		
</div>

<script src="/js/jquery-ui-timepicker-addon.js" type="text/javascript"></script>

<script type="text/javascript">
$(function() {
       $("#datepicker").datetimepicker();
    });
</script>
