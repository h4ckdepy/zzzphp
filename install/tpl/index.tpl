<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>zzzcms系统安装向导</title>
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
      <li class="installing"><b></b>安装须知</li>
      <li><b></b><a href="?act=step1">阅读安装协议</a></li>
      <li><b></b><a href="?act=step2">填写数据信息</a></li>
      <li><b></b>开始安装</li>
      <li><b></b>安装完成</li>
    </ul>
  </div>
  <div class="mainpanel">
    <h2 CLASS="STEP">BEGIN<SPAN></SPAN></h2>
    <div class="rightpanel">
      <h1>运行环境需求</h1>
      <div class="license">
        <p>1.<a href="#">要求PHP5.3以上版本，支持windows和linnux主机</a></p>
        <p>2.<a href="#">环境建议大家使用宝塔面板，可自动配置环境</a></p>
        <p>3.<a href="#">asp版本zzzcms和php版本的标签模板通用</a></p>
        <p>4.支持mysql,sqlite,access三种数据库，asp版本的数据库可直接使用</p>
      </div>
        <h1>安装环境</h1>
      <table border="0" cellpadding="0" cellspacing="0" class="listTable">
        <tr class="top">
          <th width="320">环境</th>
          <th width="300">当前</th>
          <th width="110">要求</th>
        </tr>
         <tr class="data">
          <td>PHP</td>          
          <td>{$echop check_version()}</td>
          <td>5.3</td>
        </tr>
         <tr class="data">
          <td>路径</td> 
          <td>{$echop check_chinese()}</td>        
          <td>无中文字符</td>
        </tr>
        <tr class="data">
          <td>权限</td> 
          <td>{$echop check_disable()}</td>        
          <td>opendir</td>
        </tr>
      </table>
      <h1>目录权限</h1>
      <table border="0" cellpadding="0" cellspacing="0" class="listTable">
        <tr class="top">
          <th width="320">目录</th>
          <th width="300">当前</th>
          <th width="110">所需</th>
        </tr>
         <tr class="data">
          <td>根目录</td>
          <td>{$num_ch is_write(SITE_DIR),'满足','不支持'}</td>
          <td>可写</td>
        </tr>
         <tr class="data">
          <td>安装目录</td>
          <td>{$num_ch is_write(SITE_DIR.'install'),'满足','不支持'}</td>
          <td>可写</td>
        </tr>
        <tr class="data">
          <td>配置文件/zzz_config.php</td>
          <td>{$num_ch is_write(SITE_DIR.'config/zzz_config.php'),'满足','不支持'}</td>
          <td>可写</td>
        </tr>
        <tr class="data">
          <td>缓存文件/runtime/</td>
          <td>{$num_ch is_write(SITE_DIR.'runtime'),'满足','不支持'}</td>
          <td>可写</td>
        </tr>
        <tr class="data">
          <td>上传文件夹/upLoad/</td>
          <td>{$num_ch is_write(SITE_DIR.'upload'),'满足','不支持'}</td>
          <td>可写</td>
        </tr>
      </table>
    </div>
    <div class="submitarea">
    <?php 
    	if( G('err')==1) {
        	echo('<input type="button" value="不符合要求，不能安装！" disabled>');
        }else{
      	  echo ('<input type="button" class="button"  value="开始安装 > > >" onclick="window.location.href=\'?act=step1\'"/>');
        }
    ?>
      
    </div>
  </div>
</div>
</div>
<script>
function installfinish() {
    layer.confirm("您确定取消安装吗？这样非常不安全，将使用默认后台地址和密码！", {
        icon: 3,
        title: '警告危险'
    }, function() {
        $.post("?act=finish", function(data) {
            window.location.href = '../'
        });
    })
}
</script>

    <div id="footer">
      <p>Powered By <a href="http://zzzcms.com" target="_blank">zzzcms.com</a></p>
    </div>
  </div>
</div>
</body>
</html>
