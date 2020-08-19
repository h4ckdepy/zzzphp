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
      <li class="installed"><b></b><a href="index.php">安装须知</a></li>
      <li class="installed"><b></b><a href="?act=step1">阅读安装协议</a></li>
      <li class="installing"><b></b>填写数据信息</li>
      <li><b></b>开始安装</li>
      <li><b></b>安装完成</li>
    </ul>
  </div>
  <div class="mainpanel">
    <h2 CLASS="STEP">STEP<SPAN>2</SPAN></h2>
	 <?php 
		$script_path = explode( '/', $_SERVER[ 'SCRIPT_NAME' ] );
		$file_path = str_replace( '\\', '/', dirname( __DIR__ ) );
		if ( count( $script_path ) > 2 ) {
			if ( !!$path_pos = strrpos( $file_path, '/' . $script_path[ 1 ] ) ) {
				$webroot= substr( $file_path, $path_pos );
			} else {
				$webroot= '' ;
			}
		} else {
			$webroot= '' ;
		}
        $prefix=$conf['prefix']!='zzz_' ? $conf['prefix'] : 'zzz'.randname(3,'num').'_';
		$adminroot=$conf['adminpath']!='admin/' ? $conf['adminpath'] : 'admin'.randname(3,'num').'/';
	 ?>
    <form name="submitForm" action="?act=install" method="post">
      <div class="rightpanel">
        <div class="step3_box">
          <div class="cuetitle">填写网站基本信息<span style="font-weight:normal;">(默认系统会自动获取不用修改，如有错请修改.)</span></div>
          <table border="0" cellpadding="0" cellspacing="0" class="infoTable">
            <tr>
              <td class="titletd">网站名称:</td>
              <td class="infotd"><input type="text" class="text" name="sitetitle" value="ZZZCMS php版本建站系统" />
                <label class="normal"></label></td>
            </tr>
            <tr>
              <td class="titletd">网站网址:</td>
              <td class="infotd"><input type="text" class="text" name="siteurl" value="http://<?php echo $_SERVER['HTTP_HOST'].$webroot?>" />
                <label class="normal">以http开头， 例: http://zzzcms.com</label></td>
            </tr>
            <tr>
              <td class="titletd">系统路径:</td>
              <td class="infotd"><input type="text" class="text" name="sitepath" value="<?php echo $webroot?>/" />
                <label class="normal">"/"开头并以"/"结束 例: /zzzcms/ 或 /</label></td>
            </tr>
            <tr>
              <td class="titletd">后台地址:</td>
              <td class="infotd"><input type="text" class="text" name="adminpath" id="adminpath" maxlength="20" value="<?php echo $adminroot?>" />
                <label class="normal">以/结尾，不含非法字符！</label></td>
            </tr>
            <tr>
              <td class="titletd">Session区别符:</td>
              <td class="infotd"><input type="text" class="text" name="prefix" id="prefix" maxlength="20" value="<?php echo $prefix?>" />
                <label class="normal">prefix，建议每个网站不一样！</label></td>
            </tr>  
          </table>
        </div>
        <div class="step3_box">
          <div class="cuetitle">填写数据库信息</div>
          <div>
            <table border="0" cellpadding="0" cellspacing="0" class="infoTable">
              <tr>
                <td class="titletd">选择数据库类型:</td>
                <td class="infotd"><span id="dbType">
                  <label>
                    <input type="radio" name="dbtype" id="dbType_1" value="sqlite" {if [c db]['type']=='sqlite'}checked{/if}/>
                    <span>Sqlite</span></label>
                 
                  <label>
                    <input type="radio" name="dbtype" id="dbType_2" value="access" {if [c db]['type']=='access'}checked{/if}  {if PHP_OS!='WINNT'} disabled="disabled"{/if}/>
                    <span {if PHP_OS!='WINNT'} onmouseover="layer.tips('仅限windows服务器可选择access数据库',this,{tips: [1, '#3595CC'],time: 3000});" {/if}>Access</span></label>
                  
                  <label>
                    <input type="radio" name="dbtype" id="dbType_3"  value="mysql" {if [c db]['type']=='mysql'}checked{/if}/>
                    <span>Mysql</span></label>
                  </td>
              </tr>
             </table>
          </div>
          <div class="dbType" id="sqlite" {if [c db]['type']!='sqlite'} style="display:none;"{/if}>
            <table border="0" cellpadding="0" cellspacing="0" class="infoTable">
              <tr>
                <td class="titletd">Sqlite文件夹:</td>
                <td class="infotd"><input type="text" class="text" name="sqlitepath" onblur="onblur(this,Array('replace','/[^0-9a-zA-Z-_.#$]*/g','maxLength:50'))" value="{$randname 8}/" />
                  <label class="normal">以/结尾，不含非法字符！,原路径：data/</label></td>
              </tr>
              <tr>
                <td class="titletd">Sqlite文件名:</td>
                <td class="infotd"><input type="text" class="text" name="sqlitename" onblur="onblur(this,Array('replace','/[^0-9a-zA-Z-_.#$]*/g','maxLength:50'))" value="{$randname 8}.db" />
                  <label class="normal">Sqlite数据库文件名,原名称：#zzzcms.db，是否存在：True</label></td>
              </tr>
            </table>
          </div>
          <div class="dbType" id="access" {if [c db]['type']!='access'} style="display:none;"{/if}>
            <table border="0" cellpadding="0" cellspacing="0" class="infoTable">
              <tr>
                <td class="titletd">ACCESS文件夹:</td>
                <td class="infotd"><input type="text" class="text" name="accesspath" onblur="onblur(this,Array('replace','/[^0-9a-zA-Z-_.#$]*/g','maxLength:50'))" value="{$randname 8}/" />
                  <label class="normal">以/结尾，不含非法字符！,原路径：data/</label></td>
              </tr>
              <tr>
                <td class="titletd">ACCESS文件名:</td>
                <td class="infotd"><input type="text" class="text" name="accessname" onblur="onblur(this,Array('replace','/[^0-9a-zA-Z-_.#$]*/g','maxLength:50'))" value="{$randname 8}.mdb" />
                  <label class="normal">ACCESS数据库文件名,原名称：#zzzcms.mdb，是否存在：True</label></td>
              </tr>
            </table>
          </div>
          <div class="dbType" id="mysql" {if [c db]['type']!='mysql'} style="display:none;"{/if}>
            <table border="0" cellpadding="0" cellspacing="0" class="infoTable mssqlTable">
              <tr>
                <td class="titletd">数据库服务器:</td>
                <td class="infotd"><input type="text" class="text" id="host" name="host" value="<?php if ($conf['db']['host']!='') {echo $conf['db']['host'];} else {echo '127.0.0.1';}?>" placeholder="127.0.0.1"/>
                  <label class="normal hostinfo"></label></td>
              </tr>
              <tr>
                <td class="titletd">数据库端口号:</td>
                <td class="infotd"><input type="text" class="text"  id="port" name="port" value="3306" style="width:80px;"  placeholder="空"/>
                  <label class="normal">默认3306一般不需要更改</label></td>
              </tr>
              <tr>
                <td class="titletd">数据库名称:</td>
                <td class="infotd"><input type="text" class="text" id="name" name="name" value="<?php if ($conf['db']['name']!='') {echo $conf['db']['name'];} else {echo 'zzzcms';}?>" placeholder="zzzcms" />
                  <label class="normal nameinfo">最好提前创建</label></td>
              </tr>
              <tr>
                <td class="titletd">数据库帐号:</td>
                <td class="infotd"><input type="text" class="text" id="user" name="user" value="<?php if ($conf['db']['user']!='') {echo $conf['db']['user'];} else {echo 'root';}?>"  placeholder="root"/>
                  <label class="normal userinfo"></label></td>
              </tr>
              <tr>
                <td class="titletd">数据库密码:</td>
                <td class="infotd"><input type="text" class="text" id="password" name="password" value="<?php if ($conf['db']['password']!='') {echo $conf['db']['password'];} else {echo 'root';}?>" />
                  <label class="normal passwordinfo"></label></td>
              </tr>
            </table>
          </div>
        </div>
        <div class="step3_box">
          <div class="cuetitle">填写创始人信息</div>
          <table border="0" cellpadding="0" cellspacing="0" class="infoTable">
            <tr>
              <td class="titletd">管理员:</td>
              <td class="infotd"><input type="text" class="text" name="admin_name" id="adminname" maxlength="20" value="<?php if (get_session('admin_name')!='') {echo get_session('admin_name');} else {echo 'admin';}?>" />
                <label class="normal">0到20个字符，不含非法字符！</label></td>
            </tr>
            <tr>
              <td class="titletd">密码:</td>
              <td class="infotd"><input type="text" class="text" name="admin_pass" id="adminpass" maxlength="20" value="<?php if (get_session('admin_pass')!='') {echo get_session('admin_pass');} else {echo randname(6,'num');}?>" />
                <label class="normal">6到20个字符</label></td>
            </tr>
            <tr>
              <td class="titletd">确认密码:</td>
              <td class="infotd"><input type="text" class="text" name="admin_repass" id="repassword" maxlength="20" value="<?php if (get_session('admin_pass')!='') {echo get_session('admin_pass');} else {echo '';}?>" />
                <label class="normal">和密码保持一致</label></td>
            </tr>
              <tr>
              <td class="titletd">找回密码问题:</td>
              <td class="infotd"><input type="text" class="text" name="question" id="question" maxlength="50" value="<?php if (get_session('question')!='') {echo get_session('question');} else {echo randname();}?> " placeholder="请认真填写，可代替密码"/>
                <label class="normal">不能为空</label></td>
            </tr>
            <tr>
              <td class="titletd">找回密码答案:</td>
              <td class="infotd"><input type="text" class="text" name="answer" id="answer" maxlength="50" value="<?php if (get_session('answer')!='') {echo get_session('answer');} else {echo randname();}?>" placeholder="请认真填写，可代替密码"/>
                <label class="normal">不能为空</label></td>
            </tr>
          </table>
        </div>
      </div>
      <div class="submitarea">
        <input type="button" onclick="window.location.href='?act=step1'" value="<< 返回" />
        <input type="button" class="button " id="submitinput" onclick="formSubmit();" value="下一步 >" />
      </div>
    </form>
  </div>
</div>
<script type="text/javascript">
	$("input:radio[name='dbtype']").change(function(){
			$val=$(this).val();
			$(".dbType").hide();
			$("#"+$val).show();
	})			
		function formSubmit(){
			var sitetitle = $("input[name='sitetitle']");
			var check = true;
			if($("input:radio[name='dbtype']:checked").val()==undefined){check=false;layer.alert("请选择数据库类型!");return false;}
			if($.trim(sitetitle.val())==""){check=false;layer.alert("请填写网站名称!");sitetitle.focus();return false;}
			if($.trim($("#adminname").val())==""){check=false;layer.alert("请填写用户名!");$("#adminname").focus();return false;}
			if($.trim($("#adminpass").val())==""){check=false;layer.alert("请填写密码!");$("#adminpass").focus();return false;}
			if($.trim($("#repassword").val())==""){check=false;layer.alert("请填写确认密码!");$("#repassword").focus();return false;}
			if($.trim($("#adminpass").val())!=$.trim($("#repassword").val())){check=false;layer.alert("密码和确认密码不符!");$("#repassword").focus();return false;}
			if($.trim($("#question").val())==""){check=false;layer.alert("请填写问题!");$("#question").focus();return false;}
			if($.trim($("#answer").val())==""){check=false;layer.alert("请填写答案!");$("#answer").focus();return false;}
			if(check){$("form[name='submitForm']").submit();}
		}
        </script>
    <div id="footer">
      <p>Powered By <a href="http://zzzcms.com" target="_blank">zzzcms.com</a></p>
    </div>
  </div>
</div>
</body>
</html>
