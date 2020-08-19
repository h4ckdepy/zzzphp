<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="../plugins/bootstrap/bootstrap.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/font-awesome.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/animate.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/style.min.css" rel="stylesheet">
<link href="css/adminstyle.css" rel="stylesheet">
<!--[if lte IE 9]>
<script src="../js/respond.min.js"></script>
<script src="../js/html5.js"></script>
<![endif]-->
<link href="../plugins/sortable/style.css" rel="stylesheet">
<script src="../js/jquery.min.js"></script>
<script src="../plugins/layer/layer.min.js"></script> 
</head>
<body class="gray-bg">
<div class="wrapper wrapper-content">
  <div style="width:1000px;margin:0 auto;background: #fff; position:relative">
    <ul class="splitter">
      <li> <span>类型:</span>
        <ul>
          <li class="segment-1 selected-1"><a href="#" data-value="all">全部</a></li>
          <li class="segment-0"><a href="#" data-value="企业">企业</a></li>
          <li class="segment-0"><a href="#" data-value="行业">行业</a></li>
          <li class="segment-0"><a href="#" data-value="商城">商城</a></li>
          <li class="segment-0"><a href="#" data-value="制造">制造</a></li>
          <li class="segment-0"><a href="#" data-value="商贸">商贸</a></li>
          <li class="segment-0"><a href="#" data-value="餐宿">餐宿</a></li>
          <li class="segment-0"><a href="#" data-value="建筑">建筑</a></li>
          <li class="segment-0"><a href="#" data-value="医药">医药</a></li>
          <li class="segment-0"><a href="#" data-value="教育">教育</a></li>
          <li class="segment-0"><a href="#" data-value="网络">网络</a></li>
          <li class="segment-0"><a href="#" data-value="手机">手机</a></li>
          <li class="segment-0"><a href="#" data-value="白"><font color="#ccc">白</font></a></li>
          <li class="segment-0"><a href="#" data-value="灰"><font color="#999">灰</font></a></li>
          <li class="segment-0"><a href="#" data-value="黑"><font color="#000">黑</font></a></li>
          <li class="segment-0"><a href="#" data-value="蓝"><font color="#0066CC">蓝</font></a></li>
          <li class="segment-0"><a href="#" data-value="绿"><font color="#009933">绿</font></a></li>
          <li class="segment-0"><a href="#" data-value="黄"><font color="#FFCC00">黄</font></a></li>
          <li class="segment-0"><a href="#" data-value="红"><font color="#FF0000">红</font></a></li>
          <li class="segment-0"><a href="#" data-value="彩"><font color="#CC3399">彩</font></a></li>
        </ul>
      </li>
      <li> <span>排序:</span>
        <ul>         
          <li class="segment-1"><a href="#" data-value="name">名称</a></li>
          <li class="segment-0"><a href="#" data-value="size">价格</a></li>
          <li class="segment-0"><a href="#" data-value="sales">销量</a></li>
          <li class="segment-0"><a href="#" data-value="time">时间</a></li>
        </ul>
      </li>
    </ul>
    <div class="split_search">  <span>搜索：</span><input type="text" id="search_plug" placeholder="模板名称"><button>搜索</button> <button onClick="opennew('http://zzzcms.com/plug/submission/content_add.asp')">我要发布</button></div>
    <ul id="list" class="image-grid">    	
    	{$online 'template'}
    </ul>
  </div>
</div>
</div>
<!-- End Panel Other -->
</div>
<script src="../plugins/sortable/sortable.js"></script>
<script src="../plugins/sortable/main.js"></script>
<script src="js/adminjs.js"></script> 
</body>
</html>