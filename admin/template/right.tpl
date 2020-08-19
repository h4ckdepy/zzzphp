<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="css/adminstyle.css" rel="stylesheet">
<link href="../plugins/bootstrap/bootstrap.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/font-awesome.min.css" rel="stylesheet">
<link href="../plugins/bootstrap-table/bootstrap-table.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/animate.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/style.min.css" rel="stylesheet">
<script src="../js/jquery.min.js"></script>
<!--[if lte IE 9]>
<script src="../js/respond.min.js"></script>
<script src="../js/html5.js"></script>
<![endif]-->
</head>

<body class="gray-bg sidebar-content">
<div class="sidebard-panel"> {if [c tianqimark]==1}
  <div class="tianqi">
    <div class='onoff'> <a onclick="openonoff('save.php?act=tianqi&type=0')" title='关闭天气展示，可加快后台打开速度'> <i class='fa fa-times'></i> </a> </div>
    <iframe src='//i.tianqi.com/index.php?c=code&id=7' frameborder=0 scrolling=no width='220' height='110'  style='margin-left:-15px;'></iframe>
  </div>
  {else}
  <div class="tianqi">
    <div class='onoff'> <a onclick="openonoff('save.php?act=tianqi&type=1')" title='开启天气展示'> <i class='fa fa-soundcloud'></i> </a> </div>
    <div class="clock">
      <div id="Date"></div>
      <ul>
        <li id="hours"></li>
        <li id="point">:</li>
        <li id="min"></li>
        <li id="point">:</li>
        <li id="sec"> </li>
      </ul>
    </div>
  </div>
  <script type="text/javascript">
	$(function() {
		var monthNames = [ "1月", "2月", "3月", "4月", "5月", "6月", "7月", "8月", "9月", "10月", "11月", "12月" ]; 
		var dayNames= ["星期日","星期一","星期二","星期三","星期四","星期五","星期六"]
		var newDate = new Date();
		newDate.setDate(newDate.getDate());
		$('#Date').html(newDate.getFullYear() + "年" + monthNames[newDate.getMonth()] + '' + newDate.getDate() + '日 ' + dayNames[newDate.getDay()]);
		setInterval( function() {
			var seconds = new Date().getSeconds();
			$("#sec").html(( seconds < 10 ? "0" : "" ) + seconds);
		},1000);	
		setInterval( function() {
			var minutes = new Date().getMinutes();
			$("#min").html(( minutes < 10 ? "0" : "" ) + minutes);
		},1000);	
		setInterval( function() {
			var hours = new Date().getHours();
			$("#hours").html(( hours < 10 ? "0" : "" ) + hours);
		}, 1000);		
	}); 
	</script> 
  {/if}
  <div class="ibox-title"> <span class="label label-primary pull-right">总</span>
    <h5>内容统计</h5>
  </div>
  <div class="ibox-content">
    <ul class="list-group">
      {$right_count 'all'}
    </ul>
  </div>
    <?php
    if(get_cookie('adminpath')=='1'){
  echo '<div class="panel panel-warning">
<div class="panel-heading"><i class="fa fa-warning"></i> 安全提醒 <button onclick="openonoff(\'save.php?act=cookie&type=path\')" class="close" >×</button></div>
    <div class="panel-body">
      <p>不建议后台管理目录使用admin！</p>
      <a onclick="layer.prompt({title: \'请输入新目录名称，如newadmin\'},function(path, index){$.post(\'save.php?act=upadmin\',{\'path\':path},function(data){if(data==true){parent.location=\'../\'+path}else{parent.layer.alert(data)}})});" class="label label-primary ">立即修改</a>
      </p>
    </div>
  </div>';
    }
 if(get_cookie('adminpass')=='1'){
   echo '<div class="panel panel-danger">
    <div class="panel-heading"><i class="fa fa-warning"></i> 安全提醒 <button onclick="openonoff(\'save.php?act=cookie&type=pass\')"  class="close" >×</button></div>
    <div class="panel-body">
      <p>管理密码过于简单，请及时修改！</p>
      <p> <a onclick="opennew(\'?act=admin&uid='.get_session("adminid").'\')"  class="label label-primary">立即修改</a></p>
    </div>
  </div>';
    }
    ?>
</div>
</div>
<div class="wrapper">
  <div class="row">
    <div class="alert alert-success">
      <h3>欢迎您{$get_session 'adminname'}:，今天是{php echo date("Y/m/d")}</h3>
      [c:welcome]</div>
    <div class="clear"></div>
    <div class="row"> {$center_count ''} </div>
    <div class="row">
      <div class="col-sm-6">
        <div class="ibox float-e-margins">
          <div class="ibox-content no-padding">
            <table data-toggle="table">
              <thead>
                <tr>
                  <th>项目</th>
                  <th>状态</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>操作系统</td>
                  <td>{php echo PHP_OS;}</td>
                </tr>
                <tr>
                  <td>web 服务器</td>
                  <td>{php echo _SERVER('SERVER_SOFTWARE');}</td>
                </tr>
                <tr>
                  <td>PHP版本</td>
                  <td>{php echo PHP_VERSION;}</td>
                </tr>
                <tr>
                  <td>服务器IP</td>
                  <td>{php echo _SERVER('SERVER_ADDR');}</td>
                </tr>
                <tr>
                  <td>客户端IP</td>
                  <td>{php echo $ip;}</td>
                </tr>
                <tr>
                  <td>超时时间</td>
                  <td>{php echo ini_get("max_execution_time")}秒</td>
                </tr>
                <tr>
                  <td>服务器脚本引擎</td>
                  <td>VBScript/5.8.18739</td>
                </tr>
                <tr>
                  <td>数据库驱动</td>
                  <td>{php echo DB_TYPE;}</td>
                </tr>
                <tr>
                  <td>运行模式</td>
                  <td><?php
                     if(conf('runmode')==1){
                       echo '开启静态';
                     }else if(conf('iscache')==1){
                       echo '开启缓存';
                     }else{
                       echo '动态模式';
                     }
                    ?></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="ibox float-e-margins">
          <div class="ibox-content no-padding">
            <table data-toggle="table">
              <thead>
                <tr>
                  <th>项目</th>
                  <th>状态</th>
                </tr>
              </thead>
              <tr>
                <td>官网</td>
                <td><a href='http://zzzcms.com'>zzzcms.com</a></td>
              </tr>
              <tr>
                <td>作者</td>
                <td>升起</td>
              </tr>
              <tr>
                <td>版本</td>
                <td>{php echo ZZZ_VERSION} Build{php echo ZZZ_VERDATE}</td>
              </tr>
              <tr>
                <td>更新</td>
                <td><a onclick=opennew('?act=updata')  class="label label-danger">在线更新</a> <a onclick=opennew('http://zzzcms.com/zzzphp/')  class="text-navy">更新日志</a></td>
              </tr>
              <tr>
                <td>时间</td>
                <td>{php echo ZZZ_VERTIME}</td>
              </tr>
              <tr>
                <td>介绍</td>
                <td><a href='http://{php echo ZZZ_VERURL}' target="_blank">{php echo ZZZ_VERURL}</a></td>
              </tr>
              <tr>
                <td>描述</td>
                <td>{php echo ZZZ_VERDESC}</td>
              </tr>
              <tr>
                <td>QQ交流群</td>
                <td>14878087</td>
              </tr>
              <tr>
                <td>帮助文档</td>
                <td><a href="http://help.zzzcms.com/" target="_blank">help.zzzcms.com</a></td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
<script src="../plugins/bootstrap/bootstrap.min.js"></script>
<script src="../plugins/bootstrap-table/bootstrap-table.min.js"></script>
<script src="../plugins/bootstrap-table/bootstrap-table-mobile.min.js"></script>
<script src="../plugins/switchery/switchery.js"></script>
<link href="../plugins/switchery/switcherybig.css" rel="stylesheet">
<script src="../plugins/layer/layer.min.js"></script>
<script src="js/adminjs.js"></script>
</html>