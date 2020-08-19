<?php
include ADMIN_DIR.'plug.php';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>插件管理</title>
<link href="../plugins/bootstrap/bootstrap.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/font-awesome.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/animate.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/style.min.css" rel="stylesheet">
<link href="css/adminstyle.css" rel="stylesheet">
<script src="../js/jquery.min.js"></script>
<script>var table='plug';</script>
<script src="../plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
<link href="../plugins/sortable/style.css" rel="stylesheet">
<script src="../plugins/layer/layer.min.js"></script>
<!--[if lte IE 9]>
<script src="<../js/respond.min.js"></script>
<script src="<../js/html5.js"></script>
<![endif]-->
</head>
<body class="gray-bg">
<div class="wrapper wrapper-content">
  <div class="row">
    <div class="col-sm-12">
      <div class="tabs-container">
        <ul class="nav nav-tabs">
          <li class="tab1 active"><a data-toggle="tab" href="#tab-1"> <i class="fa fa-laptop"></i>本地插件</a> </li>
          <li class="tab2"><a data-toggle="tab" href="#tab-2"> <i class="fa fa-globe"></i>在线插件</a> </li>
        </ul>
        <div class="tab-content">
          <div id="tab-1" class="tab-pane active">
            <div class="panel-body">
              <div class="ibox-content">
                <div class="row">
                  <div class="ibox-tools"> 授权域名
                    <input type="text" id="plugurl" style="width:200px" placeholder="[c:plugurl]" value="[c:plugurl]" onmouseover="layer.tips('填主域名，不加www',this,{tips: [1, '#3595CC'],
  time: 4000});">
                    <a class="btn btn-success" style="height:25px; padding:3px 6px" id="seturl">保存</a>
                  </div>
                </div>
                <div class="row"> {$plug_list ''} </div>
              </div>
            </div>
          </div>
          <div id="tab-2" class="tab-pane">
            <div class="panel-body">
              <div style="width:1000px;position: relative;   margin: 0px auto;">
                <ul class="splitter">
                  <li> <span>类型:</span>
                    <ul>
                      <li class="segment-1 selected-1"><a href="#" data-value="all">全部</a></li>
                      <li class="segment-0"><a href="#" data-value="常用">常用</a></li>
                      <li class="segment-0"><a href="#" data-value="商城">商城</a></li>
                      <li class="segment-0"><a href="#" data-value="微信">微信</a></li>
                      <li class="segment-0"><a href="#" data-value="营销">营销</a></li>
                      <li class="segment-0"><a href="#" data-value="扩展">扩展</a></li>
                      <li class="segment-0"><a href="#" data-value="特价">特价</a></li>
                      <li class="segment-0"><a href="#" data-value="免费">免费</a></li>
                      <li class="segment-0"><a href="#" data-value="其他">其他</a></li>
                    </ul>
                  </li>
                  <li style=" clear:both"> <span>排序:</span>
                    <ul>
                      <li class="segment-1"><a href="#" data-value="name">名称</a></li>
                      <li class="segment-0"><a href="#" data-value="size">价格</a></li>
                    </ul>
                  </li>
                </ul>
                <div class="split_search"> <span>搜索：</span>
                  <input type="text" id="search_plug" placeholder="模板名称">
                  <button>搜索</button>
                </div>
                <ul id="list" class="image-grid">
                  {$online 'plug'}
                </ul>
              </div>
            </div>
          </div>
        </div>
        <!-- End Panel Other --> 
      </div>
    </div>
  </div>
</div>
<script>

$("#seturl").click(function(){
	var plugurl=$("#plugurl").val();
	 $.post("save.php?act=plugurl",{'plugurl':plugurl},function(result){
	if (result==1){
		layer.open({title:'保存成功',content:'保存成功',icon:4,time:3000,end:function(){location.reload();}});
	} 
  });
});
$(".plugkey").change(function(){
  var plugpath=$(this).attr("plugpath");
  var plugkey=$(this).val();
  $.post("save.php?act=plugkey",{'plugpath':plugpath,'plugkey':plugkey},function(result){
	if (result==1){
		layer.open({title:'保存成功',content:'保存成功',icon:4,time:3000,end:function(){location.reload();}});
	}else{
		layer.open({title:'保存失败',content:'请确认授权码是否正确',icon:3,time:3000,end:function(){location.reload();}});
		}
	});
});
</script> 
<script src="../plugins/bootstrap/bootstrap.min.js"></script>
<link href="../plugins/colorpicker/bootstrap-colorpicker.min.css" rel="stylesheet">
<script src="../plugins/sortable/sortable.js"></script>
<script src="../plugins/sortable/main.js"></script>
<script src="js/adminjs.js"></script>
</body>
</html>