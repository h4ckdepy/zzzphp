<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>单击获取点击的经纬度</title>

<style type="text/css">
*{margin:0;padding:0;list-style-type:none;}
a,img{border:0;}
body{font:12px/180% Arial, Helvetica, sans-serif, "新宋体";}
.demo{width:850px;margin:20px auto;}
#l-map{height:400px;width:600px;float:left;border:1px solid #bcbcbc;}
#r-result{height:400px;width:230px;float:right;}

input, button{ padding:5px 10px; margin:5px;}
</style>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.4"></script>
<script src="http://libs.baidu.com/jquery/1.9.1/jquery.min.js"></script>
<script src="http://res.layui.com/lay/lib/laycode/laycode.min.js"></script>

</head>
<body>
<div class="demo">
	<p style="height:50px;">
    输入地名：<input id="txtCity" type="text"/>  
    <button  onClick="getPoint()">搜索</button> 
    坐标：<input id="txtPoint" type="text" value="[G:type]"/>
    <button onclick="goback()">确定</button></p>
	<div id="l-map"></div>
	<div id="r-result"></div>
</div>
<script type="text/javascript">
// 百度地图API功能
var map = new BMap.Map("l-map");            // 创建Map实例
	map.centerAndZoom(new BMap.Point([g:type]), 12);
	map.enableScrollWheelZoom();
	map.enableInertialDragging(); 
	marker = new BMap.Marker(new BMap.Point([g:type]));
	map.addOverlay(marker);
	var local = new BMap.LocalSearch("全国", {
	  renderOptions: {
		map: map,
		panel : "r-result",
		autoViewport: true,
		selectFirstResult: false
	  }
	});	
	
		map.addEventListener("click",function(e){	
		 map.clearOverlays();
	 	 marker = new BMap.Marker(new BMap.Point(e.point.lng, e.point.lat));  // 创建标注
         map.addOverlay(marker);
		document.getElementById("txtPoint").value=e.point.lng + "," + e.point.lat;
	});
function getPoint(){	
    var city = document.getElementById("txtCity").value;
	local.search(city); 
	}
function myFun(result){
    var cityName = result.name;
    map.setCenter(cityName);
	document.getElementById("txtCity").value=(cityName)
   // alert(cityName);
}
{if ([g type]=='')}
	var myCity = new BMap.LocalCity();
	myCity.get(myFun);
{/if}
function goback(){
	var index = parent.layer.getFrameIndex(window.name);
	var Point=document.getElementById("txtPoint").value
	if (Point==""){alert ("未获取坐标，点击地图上位置")}
	else{
	
	parent.$("#companymappoint").val(Point);
	parent.layer.close(index);
	}
	//
    //parent.layer.msg('Hi, man', {shade: 0.3})
}
</script>
</body>
</html>