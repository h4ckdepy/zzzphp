

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>zzzcms系统安装-导入测试数据</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link rel="stylesheet" type="text/css" href="css/global.css" />
<link rel="stylesheet" type="text/css" href="css/main.css" />
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../plugins/layer/layer.min.js"></script>
<script type="text/javascript" src="js/common.js"></script>
</head>
<body>
<div id="abody">
  <div id="bbody">
    <div id="header"> <a href="http://www.zzzcms.com" target="_blank"></a> <a href="http://help.zzzcms.com" target="_blank"></a> <a href="http://zzzcms.com/product/?list_9_1.html" target="_blank"></a> <a href="http://zzzcms.com/case/?list_8_1.html" target="_blank"></a> </div>
    
<div id="mbody">
  <div class="leftpanel">
    <ul class="step">
      <li class="installed"><b></b><a href="index.php">安装须知</a></li>
      <li class="installed"><b></b><a href="?act=step1">阅读安装协议</a></li>
      <li class="installed"><b></b><a href="?act=step2">填写数据信息</a></li>
      <li class="installing"><b></b>开始安装</li>
      <li><b></b>安装完成</li>
    </ul>
  </div>
  <div class="mainpanel">
    <h2 CLASS="STEP">STEP<SPAN>4</SPAN></h2>
      <link rel="stylesheet" href="css/ui.progress-bar.css">
      <div class="rightpanel">
      <div class="centerpanel">
        <h1>安装进度<span>安装过程中请不要做其他操作，安装时间大约需要1分钟。</span></h1>
        <div id="progress_bar" class="ui-progress-bar ui-container">
          <div class="ui-progress" style="width: 0%;"><span class="ui-label" style="display:none;">Processing<b class="value">100%</b></span></div>
          <div id="main_content">正在载入...</div>
        </div></div>
<script>
 $(function() { 
  $('#progress_bar .ui-progress .ui-label').hide();  	  
  getinstalling(0,100);
});
  function getinstalling(start,to){
	var index = layer.load();
	$('#main_content').html("正在安装中，请耐心等待！sqlite大概需要10-30秒");		
	$.post("?act=testdata",{"start":start,"to":to},  function(data){
	  var count=data.count;
	  var start =data.to;
	  var num =Math.round(start/count*100);
	$('#progress_bar .ui-progress').animateProgress(num)	  
		 if (num==100){
			 layer.close(index)
			 $('#main_content').html("测试数据安装完成，请点击[完成安装]。");
			 $(".button_step5").val("完成安装").removeAttr("disabled");
			 if("0"=="1"){ $(".button_testsql").show(); }
		 }else{
		  layer.close(index)
		  layer.alert("安装出错，请检查服务器环境，写入权限是否开启");
		  $(".button_step5").val("安装出错").attr({"disabled":"disabled"});
		  return false;
		  }
 	 },"json");	  
  }
</script>
      </div>
      <div class="submitarea">        
         <input type="button" class="button" onclick="window.location.href='?act=step5'" value="安装完成 >>" />
      </div>
    </div>
  </div>
  
    <div id="footer">
      <p>Powered By <a href="http://zzzcms.com" target="_blank">zzzcms.com</a></p>
    </div>
  </div>
</div>
</body>
</html>
