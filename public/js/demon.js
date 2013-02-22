$(document).ready(function(){
	//展开高级搜索选项
	$("#unfold_sig").click(function(){
		$("#hidden_sig").slideToggle("fast",function(){ });
	});
	
	//全选
	$(".checkAll").click(function(){
		if(this.checked)
			$(this).parent().parent().find("input").each(function(){this.checked=true;});//children().each(function(){$(this).children("input[type='checkbox']").each(function(){this.checked=true;})});
		else
			$(this).parent().parent().find("input").each(function(){this.checked=false;});//children().each(function(){$(this).children("input[type='checkbox']").each(function(){this.checked=false;})});
	});
	
	$(".advanced_search input:not('.checkAll'):not('.checkAllIP')").click(function(){
		if(this.checked == false)
			$(this).parent().parent().parent().find(".checkAll").each(function(){this.checked=false;});
	});
	
	$(".checkAllIP").click(function(){
		if(this.checked == false)
		{
			$("#ipType").removeAttr("disabled");
			$("#ipaddr").removeAttr("disabled");
		}
		
		else
		{
			$("#ipType").attr("disabled", "disabled");
			$("#ipaddr").attr("disabled", "disabled");
		}
	});
	
	//处理用户选项，以json格式填充form
	function prepareOptions()
	{
		var params = {};
		//时间范围
		params.time = {};
		params.time.start = Date.parse($("#start").val()) / 1000;
		params.time.end = Date.parse($("#end").val()) / 1000;
		params.time.axis = $("#axis").val();
		
		//协议
		if( $("#protocol .checkAll").attr("checked") != "checked" )
		{
			params.protocol = "";
			$("#protocol input[name='protocol']").each(function(){
				if(this.checked)
					params.protocol += this.value + ",";
			});
			
			if(params.protocol.length > 0 )
				params.protocol.substr(0,params.protocol.length - 1);
		}
		
		//signature
		if($("#signature .checkAll").attr("checked") != "checked")
		{
			params.signature = "";
			$("#signature input[name='signature']").each(function(){
				if(this.checked)
					params.signature += this.value + ",";
			});
			if(params.signature.length > 0 )
				params.signature.substr(0,params.signature.length - 1);
		}
		
		//IP
		if($(".checkAllIP").attr("checked") != "checked")
		{	
			params.ip={};
			if($("#ipType").val() == "src")
			{
				params.ip.src = $("#ipaddr").val();
			}
			else
			{
				params.ip.dst = $("#ipaddr").val();
			}
		}
		
		//sensor
		if( $("#sensor .checkAll").attr("checked") != "checked" )
		{
			params.sensor = "";
			$("#sensor input[name='sensor']").each(function(){
				if(this.checked)
					params.sensor += this.value + ",";
			});
			if(params.sensor.length > 0 )
				params.sensor.substr(0,params.sensor.length -1);
		}
		
		$("#hiddenForm input[name='params']").attr("value", $.toJSON(params));
		return $.toJSON(params);
	}
	
	//搜索，提交参数
	$("#btnSearch").click(function(e){
		e.preventDefault();
		prepareOptions();
		
		if($("#searchType input[name='searchType']:checked").val() == 'graph')
			$("#hiddenForm").attr("action", $("#hiddenForm").attr('graphUrl'));
		else
			$("#hiddenForm").attr("action", $("#hiddenForm").attr('listUrl'));
		
		$("#hiddenForm").submit();
	});
	
	
	//导出
	$("#btnExport").click(function(){
		prepareOptions();
		var url = siteUrl + '/event/exportList';
		$("#hiddenForm").attr("action", url);
		$("#hiddenForm").attr("target", '_blank');
		$("#hiddenForm").submit();
	});
	
	
	//换页
	$(".page_index").click(function(e){
	e.preventDefault();
	if($(this).parent().attr('class') != "disabled")
	{
		$("#hiddenForm input[name='page']").attr("value", $(this).text());
		$("#hiddenForm").submit();
	}
	});
	
	//上一页
	$("#prev").click(function(e){
	e.preventDefault();
	if($(this).parent().attr('class') != "disabled")
	{
		$("#hiddenForm input[name='page']").attr("value", parseInt($(".current_page").text()) - 1);
		$("#hiddenForm").submit();
	}
	});
	
	//下一页
	$("#next").click(function(e){
	e.preventDefault();
	if($(this).parent().attr('class') != "disabled")
	{
		$("#hiddenForm input[name='page']").attr("value", parseInt($(".current_page").text()) + 1);
		$("#hiddenForm").submit();
	}
	});
	
	$('#graph_tab a').click(function (e) {
	  e.preventDefault();
	  $(this).tab('show');
	});
	
	//时间选择
	$(".timepicker").datetimepicker();
	
	//高级搜索tab效果
	var TabbedContent = {
		init: function() {	
			$(".tab_item").mouseover(function() {
			
				var background = $(this).parent().find(".moving_bg");
				
				$(background).stop().animate({
					left: $(this).position()['left']
				}, {
					duration: 300
				});
				
				TabbedContent.slideContent($(this));
				
			});
		},
		
		slideContent: function(obj) {
			
			var margin = $(obj).parent().parent().find(".slide_content").width();
			margin = margin * ($(obj).prevAll().size() - 1);
			margin = margin * -1;
			
			$(obj).parent().parent().find(".tabslider").stop().animate({
				marginLeft: margin + "px"
			}, {
				duration: 300
			});
		}
	}

	TabbedContent.init();
	
//google map
	$('#map_canvas').gmap({
	      zoom: 2,
	      mapTypeId: google.maps.MapTypeId.ROADMAP
	    }); // Add the contructor
	// addMarker returns a jQuery wrapped google.maps.Marker object 

//刷新demon_event表
	$(".refreshDemonEvent").click(function(){
		$.post(siteUrl + '/setting/ajaxRefreshDemonEvent', function(data){
			alert("成功更新了DemonEvent临时表");
		});
	});
	

});