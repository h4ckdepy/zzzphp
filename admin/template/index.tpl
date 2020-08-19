<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>管理后台</title>
<meta http-equiv="cache-control" content="no-siteapp" />
<meta http-equiv="x-ua-compatible" content="ie=edge,chrome=1"/>
<meta content=always name=referrer>
<link href="../plugins/bootstrap/bootstrap.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/font-awesome.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/animate.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/style.min.css" rel="stylesheet">
<link href="css/adminstyle.css" rel="stylesheet">
<!--[if lte ie 9]>
<script src="../js/respond.min.js"></script>
<script src="../js/html5.js"></script>
<![endif]-->
<script src="../js/jquery.min.js"></script>
<script src="../plugins/layer/layer.min.js"></script>
<meta name="viewport" content="width=767,user-scalable=no, target-densitydpi=device-dpi">
</head>
<body class="fixed-sidebar full-height-layout gray-bg" style="overflow:hidden">
<div id="wrapper"> 
  <!--左侧导航开始-->
  <nav class="navbar-default navbar-static-side" role="navigation">
    <div class="nav-close"><i class="fa fa-times-circle"></i> </div>
    <div class="sidebar-collapse">
      <ul class="nav" id="side-menu">
        <li class="nav-header">
          <div class="dropdown profile-element"> <span><a href=""><img alt="image" src="images/logo.png" /></a></span> <a data-toggle="dropdown" class="dropdown-toggle" href="#"><span class="face"><img alt="image" class="img-circle" id="adminface" src="{php echo get_cookie("adminface")}" /></span> <span class="clear"> <span class="block m-t-xs"><strong class="font-bold">{php echo get_cookie("adminname")}</strong></span> <span class="text-muted text-xs block">{php echo (get_session("admingroup"))}<b class="caret"></b></span> </span> </a>
            <ul class="dropdown-menu animated fadeIn m-t-xs">
              <li><a class="J_menuItem" onclick="opennew('?act=admin&uid={php echo get_session("adminid")}')">修改资料</a> </li>
              <li class="divider"></li>
              <li><a href="?act=loginesc">离开一会</a> </li>
              <li><a href="?act=loginout">安全退出</a> </li>
            </ul>
          </div>
          <div class="logo-element"><img src='../images/3z32.png'></div>
        </li>
        {php leftmenu()}
      </ul>
    </div>
  </nav>
  <!--左侧导航结束--> 
  <!--右侧部分开始-->
  <div id="page-wrapper" class="gray-bg dashbard-1"> 
    <div class="row border-bottom" id="navbar">     
      <nav class="navbar-static-top" role="navigation">  
       <a class="navbar-minimalize minimalize-styl-2" href="#"><i class="fa"></i></a>  
      
         <div class="navbar-collapse" id="navigation">
        <ul class="nav navbar-nav">          
         {php topmenu()}
        </ul>
        <ul class="nav navbar-top-links navbar-right">
          {$top_count ''}
          <li class="dropdown hidden-xs"> <a class="right-sidebar-toggle" title="后台样式" aria-expanded="false"> <i class="fa fa-tasks"></i> </a></li>           
          <li class="hidden-xs"><a onclick="delcache()" title="清理缓存" id="hourglass"><i class="fa fa-hourglass"></i>  </a>   </li>
		 
           {if conf('runmode')==1}
          	<li class="hidden-xs">  <a onclick="createhtml('pc')" title="更新电脑网站静态" ><i class="fa fa-refresh"></i>  </a>  </li>			
		     {if conf('wapmark')==1}
			  <li class="hidden-xs"><a onclick="createhtml('wap')" title="更新手机网站静态" ><i class="fa fa-retweet"></i>  </a>  </li>
			  {end if}
          {end if}       
	  
           <li class="hidden-xs"> <a href="../" target="_blank" title="预览首页" data-index="0"><i class="fa fa-institution"></i> </a> </li>
          </li>
        </ul> </div>
      </nav>
    </div>
    <div class="row content-tabs">
      <button class="roll-nav roll-left J_tabLeft"><i class="fa fa-backward"></i> </button>
      <nav class="page-tabs J_menuTabs">
        <div class="page-tabs-content"> <a href="javascript:;" class="active J_menuTab" data-id="?right">后台首页</a> </div>
      </nav>
      <button class="roll-nav roll-right J_tabRight"><i class="fa fa-forward"></i> </button>
      <div class="btn-group roll-nav roll-right">
        <button class="dropdown J_tabClose" data-toggle="dropdown">关闭操作<span class="caret"></span> </button>
        <ul role="menu" class="dropdown-menu dropdown-menu-right">
          <li class="J_tabShowActive"><a>定位当前选项卡</a> </li>
          <li class="divider"></li>
          <li class="J_tabClosethis"><a>关闭当前选项卡</a> </li>
          <li class="J_tabCloseAll"><a>关闭全部选项卡</a> </li>
          <li class="J_tabCloseOther"><a>关闭其他选项卡</a> </li>
        </ul>
      </div>     
  	  <a href="?act=loginesc" class="roll-nav roll-right J_tabExit"><i class="fa fa fa-sign-out"></i> 退出</a>    
    </div>
    <div class="J_mainContent row" id="content-main">
      <iframe class="J_iframe" name="iframe0"  id="main" width="100%" height="100%" style="min-height:600px;"  frameborder="0" src="{$ADMIN_PATH}?act=right"  data-id="?act=right"  seamless></iframe>
    </div>
  </div>
  <!--右侧部分结束--> 
  <!--右侧边栏开始-->
  <div id="right-sidebar">
    <div class="sidebar-container">
      <ul class="nav nav-tabs navs-3">
        <li class="active"> <a data-toggle="tab" href="#tab-1"> <i class="fa fa-gear"></i> 主题 </a> </li>
        <li class="" style="display:none"><a data-toggle="tab" href="#tab-2"> 通知 </a> </li>
        <li><a data-toggle="tab" href="#tab-3"> 版本 </a> </li>
      </ul>
      <div class="tab-content">
        <div id="tab-1" class="tab-pane active">
          <div class="sidebar-title">
            <h3> <i class="fa fa-comments-o"></i> 主题设置</h3>
            <small><i class="fa fa-tim"></i> 你可以从这里选择和预览主题的布局和样式，这些设置会被保存在本地，下次打开的时候会直接应用这些设置。</small> </div>
          <div class="skin-setttings">
            <div class="title">主题设置</div>
            <div class="setings-item"> <span>收起左侧菜单</span>
              <div class="switch">
                <div class="onoffswitch">
                  <input type="checkbox" name="collapsemenu" class="onoffswitch-checkbox" id="collapsemenu">
                  <label class="onoffswitch-label" for="collapsemenu"> <span class="onoffswitch-inner"></span> <span class="onoffswitch-switch"></span> </label>
                </div>
              </div>
            </div>
            <div class="setings-item"> <span>固定顶部</span>
              <div class="switch">
                <div class="onoffswitch">
                  <input type="checkbox" name="fixednavbar" class="onoffswitch-checkbox" id="fixednavbar">
                  <label class="onoffswitch-label" for="fixednavbar"> <span class="onoffswitch-inner"></span> <span class="onoffswitch-switch"></span> </label>
                </div>
              </div>
            </div>
            <div class="setings-item"> <span> 固定宽度 </span>
              <div class="switch">
                <div class="onoffswitch">
                  <input type="checkbox" name="boxedlayout" class="onoffswitch-checkbox" id="boxedlayout">
                  <label class="onoffswitch-label" for="boxedlayout"> <span class="onoffswitch-inner"></span> <span class="onoffswitch-switch"></span> </label>
                </div>
              </div>
            </div>
            <!-- <div class="title">皮肤选择</div>
           <div class="setings-item default-skin nb"> <span class="skin-name "> <a href="#" class="s-skin-0"> 默认皮肤 </a> </span> </div>
            <div class="setings-item blue-skin nb"> <span class="skin-name "> <a href="#" class="s-skin-1"> 蓝色主题 </a> </span> </div>
            <div class="setings-item yellow-skin nb"> <span class="skin-name "> <a href="#" class="s-skin-3"> 黄色/紫色主题 </a> </span> </div>--> 
          </div>
        </div>
        <div id="tab-2" class="tab-pane">
          <div class="sidebar-title">
            <h3> <i class="fa fa-comments-o"></i> 最新通知</h3>
            <small><i class="fa fa-tim"></i> 您当前有10条未读信息</small> </div>
          <div> </div>
        </div>
        <div id="tab-3" class="tab-pane">
          <div class="sidebar-title">
            <h3> <i class="fa fa-cube"></i> 更新说明</h3>
            <div class="panel panel-default">
              <div class="panel-heading">
                <h5 class="panel-title"> <a data-toggle="collapse" data-parent="#version" href="#v1">{$verid}</a><code class="pull-right">{$vertime}</code> </h5>
              </div>
              <div id="v1" class="panel-collapse collapse in">
                <div class="panel-body"> {$verlog}</div>
              </div>
            </div>
          </div>
          <ul class="sidebar-list">
            <li> <a href="#">
            本地版本：
              <div class="small m-t-xs">版本：{$zzz_version}</div>
              <div class="small m-t-xs">网址：{$zzz_verurl}</div>
              <div class="small text-muted m-t-xs">时间： {$zzz_vertime}</div>
              </a> </li>
          </ul>
        </div>
        <button class="right-sidebar-toggle btn btn-block btn-danger" aria-expanded="false"> <i class="fa fa-times"></i>　收起 </button>
      </div>
    </div>
  </div>
</div>
<script src="../plugins/bootstrap/bootstrap.min.js"></script> 
<script src="../plugins/metismenu/jquery.metismenu.js"></script> 
<script src="../plugins/slimscroll/jquery.slimscroll.min.js"></script> 
<script src="../plugins/bootstrap/hplus.min.js"></script> 
<script src="../plugins/bootstrap/contabs.min.js"></script> 
<script src="../plugins/pace/pace.min.js"></script> 
<script src="../js/zzzcms.js"></script>
<script src="js/adminjs.js"></script>
</body>
</html>