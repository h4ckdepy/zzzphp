<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>模板管理</title>
<link href="../plugins/bootstrap/bootstrap.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/font-awesome.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/animate.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/style.min.css" rel="stylesheet">
<link href="css/adminstyle.css" rel="stylesheet">
<script src="../js/jquery.min.js"></script>
<script src="../plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
<!--[if lte IE 9]>
<script src="../js/respond.min.js"></script>
<script src="../js/html5.js"></script>
<![endif]-->
</head>
<body class="gray-bg">
<div class="wrapper wrapper-content">
<div class="row">
<div class="col-sm-12">
<div class="tabs-container">
<ul class="nav nav-tabs">
  <li class="tab1 active"><a data-toggle="tab" href="#tab-1"> <i class="fa fa-laptop"></i>电脑网站模板</a> </li>
  <li class="tab2"><a data-toggle="tab" href="#tab-2"> <i class="fa fa-globe"></i>手机网站模板</a> </li>
</ul>
<div class="tab-content">
<div id="tab-1" class="tab-pane active">
  <div class="panel-body">
    <div class="ibox-content">
      <div class="row">
        <div class="ibox-tools"> HTML文件夹
          <input type="text" id="pchtmlpath" style="width:60px" value="{$db_select 'language','pchtmlpath','lid=1'}" onmouseover="layer.tips('以/结尾，不可随意修改',this,{tips: [1, '#3595CC'],
  time: 4000});">
          <button class="btn btn-success" style="height:25px; padding:3px 6px" onclick="savehtmlpath('pchtmlpath')">保存</button>
        </div>
      </div>
      <div class="row"> {$template 'pc'} </div>
    </div>
  </div>
 </div>
  <div id="tab-2" class="tab-pane">
    <div class="panel-body">
      <div class="ibox-content">
        <div class="row">
          <div class="ibox-tools"> HTML文件夹
            <input type="text" id="waphtmlpath" style="width:60px" value="{$db_select 'language','waphtmlpath','lid=1'}"  onmouseover="layer.tips('以/结尾，不可随意修改',this,{tips: [1, '#3595CC'],
  time: 4000});">
            <button class="btn btn-success" style="height:25px; padding:3px 6px" onclick="savehtmlpath('waphtmlpath')">保存</button>
          </div>
        </div>
        <div class="row"> {$template 'wap'} </div>
      </div>
    </div>
  </div>
  <!-- End Panel Other --> 
</div>
<script src="../plugins/bootstrap/bootstrap.min.js"></script>
<link href="../plugins/colorpicker/bootstrap-colorpicker.min.css" rel="stylesheet">
<script src="../plugins/layer/layer.min.js"></script> 
<script src="js/content.min.js"></script> 
<script src="js/adminjs.js"></script>
</body>
</html>