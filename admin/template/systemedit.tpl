<!doctype html public "-//w3c//dtd html 4.01 transitional//en" "http://www.w3c.org/tr/1999/rec-html401-19991224/loose.dtd">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>系统参数设置</title>
<link href="../plugins/bootstrap/bootstrap.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/font-awesome.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/animate.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/style.min.css" rel="stylesheet">
<link href="css/adminstyle.css" rel="stylesheet">
<link href="../plugins/icheck/icheck.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../plugins/webuploader/css/webuploader.css" />
<link rel="stylesheet" type="text/css" href="../plugins/webuploader/css/style.css" />
<script src="../js/jquery.min.js"></script>
<script src="../plugins/layer/layer.min.js"></script>
<script src="../plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
<!--[if lte ie 9]>
<script src="../js/respond.min.js"></script>
<script src="../js/html5.js"></script>
<![endif]-->
</head>
<body class="gray-bg">
<div class="wrapper wrapper-content">
  <div class="row">
    <form method="post" action="save.php?act=savesystem" class="form-horizontal">
      <div class="col-sm-12">
        <div class="tabs-container">
          <ul class="nav nav-tabs">
            <li class="tab1 active"><a data-toggle="tab" href="#tab-1" ><i class="fa fa-laptop"></i> 系统设置</a> </li>
            <li class="tab2"><a data-toggle="tab" href="#tab-2"><i class="fa fa-user"></i> 会员设置</a> </li>
            <li class="tab8"><a data-toggle="tab" href="#tab-8"><i class="fa fa-commenting"></i> 留言设置</a> </li>
            <li class="tab3"><a data-toggle="tab" href="#tab-3"><i class="fa fa-mobile"></i> 手机设置</a> </li>
            <li class="tab5"><a data-toggle="tab" href="#tab-5"><i class="fa fa-envelope"></i> 邮件设置</a> </li>
            <li class="tab7"><a data-toggle="tab" href="#tab-7"><i class="fa fa-comments"></i> 短信设置</a> </li>
            <li class="tab6"><a data-toggle="tab" href="#tab-6"><i class="fa fa-database"></i> 数据库设置</a> </li>
          </ul>
          <div class="tab-content">
            <div id="tab-1" class="tab-pane active">
              <div class="panel-body">
                <div class="form-group">
                  <div class="alert alert-info col-sm-10 col-md-offset-1"> 网站可在此位置进行关闭，关闭后显示提示文字。 </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">网站状态</label>
                  <div class="col-sm-2" id="webmode">
                    <input type="checkbox"  name="webmode"  value="1" class="js-switch" {$check_onoff conf('webmode'),'checked'}>
                    <span class="help-block m-b-none">{$check_onoff conf('webmode'),'ch'}</span> </div>
                  <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 可以直接关闭</span> </div>
                <div class="form-group hide-[c:webmode]" id="showcloseinfo">
                  <label class="col-sm-2 control-label">关闭后说明</label>
                  <div class="col-sm-4">
                    <input type="text" value="[c:closeinfo]" name="closeinfo" id="closeinfo" class="form-control">
                  </div>
                  <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 关闭后提示文字</span> </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">网站路径</label>
                  <div class="col-sm-2">
                    <input type="text" value="[c:sitepath]" name="sitepath" id="sitepath" class="form-control" readonly>
                  </div>
                  <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> “/”，网站根目录<code>此设置不能在此修改，可手动修改config/zzz_config.php</code></span> </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">后台路径</label>
                  <div class="col-sm-2">
                    <input type="text" value="[c:adminpath]" name="adminpath" id="adminpath" class="form-control" readonly>
                  </div>
                  <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 强烈建议使用复杂的目录名，<a onclick="layer.prompt({title: '请输入新目录名称，如newadmin'},function(path, index){$.post('save.php?act=upadmin',{'type':'admin','path':path},function(data){if(data==true){parent.location='../'+path}else{parent.layer.alert(data)}})});" class="label label-primary ">我想修改</a></span> </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">天气开关</label>
                  <div class="col-sm-2">
                    <input type="checkbox"  name="tianqimark"  value="1" class="js-switch" {$check_onoff conf('tianqimark'),'checked'}>
                    <span class="help-block m-b-none">{$check_onoff conf('tianqimark'),'ch'}</span> </div>
                  <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 如影响打开速度可以关闭</span> </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">直接删除</label>
                  <div class="col-sm-2">
                    <input type="checkbox"  name="isdel"  value="1" class="js-switch" {$check_onoff conf('isdel'),'checked'}>
                    <span class="help-block m-b-none">{$check_onoff conf('isdel'),'ch'}</span> </div>
                  <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 内容和分类是否直接删除不进入回收站</span> </div>
                 <div class="form-group">
                  <label class="col-sm-2 control-label">显示报错</label>
                  <div class="col-sm-2">
                    <input type="checkbox"  name="bugmark"  value="1" class="js-switch" {$check_onoff conf('bugmark'),'checked'}>
                    <span class="help-block m-b-none">{$check_onoff conf('bugmark'),'ch'}</span> </div>
                  <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 开启后将显示php报错，建议上线后关闭</span> </div> 
                  <div class="form-group">
                  <label class="col-sm-2 control-label">执行时间</label>
                  <div class="col-sm-2">
                    <input type="checkbox"  name="showtime"  value="1" class="js-switch" {$check_onoff conf('showtime'),'checked'}>
                    <span class="help-block m-b-none">{$check_onoff conf('showtime'),'ch'}</span> </div>
                  <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 开启后将显示页面执行时间，直接显示再页面最下面</span> </div> 
              </div>
            </div>
            <div id="tab-2" class="tab-pane">
              <div class="panel-body">
                <div class="form-group">
                  <div class="alert alert-info col-sm-10 col-md-offset-1"> 开启会员功能，请确保不能缺少会员模板。 </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">会员开关</label>
                  <div class="col-sm-2" id="usermark">
                    <input type="checkbox"  name="usermark"  value="1" class="js-switch" {$check_onoff [c usermark],"checked"}>
                    <span class="help-block m-b-none">{$check_onoff [c usermark],'ch'}</span> </div>
                  <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 关闭后，将不能新注册会员</span> </div>
                <div class="show-[c:usermark]" id="showuser">
                  <div class="form-group">
                    <label class="col-sm-2 control-label">注册必填手机</label>
                    <div class="col-sm-2">
                      <input type="checkbox"  name="ischeckmobile" id="ischeckmobile" value="1" class="js-switch" {$check_onoff [c ischeckmobile],"checked"}>
                      <span class="help-block m-b-none">{$check_onoff [c ischeckmobile],'ch'}</span> </div>
                    <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 关闭后，注册不要求手机</span> </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">注册必填邮箱</label>
                    <div class="col-sm-2">
                      <input type="checkbox"  name="ischeckemail" id="ischeckemail" value="1" class="js-switch" {$check_onoff [c ischeckemail],"checked"}>
                      <span class="help-block m-b-none">{$check_onoff [c ischeckemail],'ch'}</span> </div>
                    <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 关闭后，注册不要求邮箱</span> </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">开启验证码</label>
                    <div class="col-sm-2">
                      <input type="checkbox"  name="usercode" id="usercode" value="1" class="js-switch" {$check_onoff [c usercode],"checked"}>
                      <span class="help-block m-b-none">{$check_onoff [c usercode],'ch'}</span> </div>
                    <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 关闭后，注册登陆不验证验证码</span> </div>
                </div>
              </div>
            </div>
            <div id="tab-8" class="tab-pane">
              <div class="panel-body">
                <div class="form-group">
                  <div class="alert alert-info col-sm-10 col-md-offset-1"> 留言功能除基础参数外，还支持自定义参数</div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">留言开关</label>
                  <div class="col-sm-2" id="gbookmark" >
                    <input type="checkbox"  name="gbookmark" value="1" class="js-switch" {$check_onoff [c gbookmark],"checked"}>
                    <span class="help-block m-b-none">{$check_onoff [c gbookmark],'ch'}</span> </div>
                  <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 关闭后，将不能留言</span> </div>
                <div class="show-[c:gbookmark]" id="showgbook">
                  <div class="form-group">
                    <label class="col-sm-2 control-label">审核开关</label>
                    <div class="col-sm-2">
                      <input type="checkbox"  name="gbookonoff" id="gbookonoff" value="1" class="js-switch" {$check_onoff [c gbookonoff],"checked"}>
                      <span class="help-block m-b-none">{$check_onoff [c gbookonoff],'ch'}</span> </div>
                    <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 关闭后，留言将需要审核</span> </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">开启验证码</label>
                    <div class="col-sm-2">
                      <input type="checkbox"  name="gbookcode" id="gbookcode" value="1" class="js-switch" {$check_onoff [c gbookcode],"checked"}>
                      <span class="help-block m-b-none">{$check_onoff [c gbookcode],'ch'}</span> </div>
                    <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 关闭后，留言不验证验证码</span> </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">是否会员留言</label>
                    <div class="col-sm-2">
                      <input type="checkbox"  name="gbookuser" id="gbookuser" value="1" class="js-switch" {$check_onoff [c gbookuser],"checked"}>
                      <span class="help-block m-b-none">{$check_onoff [c gbookuser],'ch'}</span> </div>
                    <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 开启后必须会员登录方可留言</span></div>
                  <?php
                    $gbook=array('姓名'=>'name','标题'=>'title','电话'=>'tel','邮箱'=>'mail','内容'=>'content');
                    foreach ($gbook as $key=>$value){
                    echo '
                    <div class="form-group">
                      <label class="col-sm-2 control-label">'.$key.'</label>
                      <div class="col-sm-2">
                        <input name="gbook'.$value.'" type="text"  class="form-control" value="'.conf('gbook'.$value).'">
                      </div>
                      <label class="col-sm-1 control-label">开关</label>
                      <div class="col-sm-1">
                       <input type="checkbox"  name="gbook'.$value.'_onoff" value="1" class="js-switch" '.check_onoff(conf('gbook'.$value.'_onoff'),"checked").'>
                      </div>
                      <label class="col-sm-1 control-label">验证</label>
                      <div class="col-sm-1">
                     <select name="gbook'.$value.'_test" class="form-control">'.select_test(conf('gbook'.$value.'_test')).'</select>
                      </div> 
                    </div>
                     ';
                     }
                     ?>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">匿名留言次数</label>
                    <div class="col-sm-2">
                      <input name="gbookanonymousnum" type="number"  class="form-control" max="9" min="1" value="[c:gbookanonymousnum]">
                    </div>
                    <label class="col-sm-2 control-label">会员留言次数</label>
                    <div class="col-sm-2">
                      <input type="number" value="[c:gbookusernum]"  name="gbookusernum" max="9" min="1" class="form-control">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div id="tab-3" class="tab-pane">
              <div class="panel-body">
                <div class="form-group">
                  <div class="alert alert-info col-sm-10 col-md-offset-1"> 使用HTML5、自适应模板时，请关闭手机站。</div>
                </div>

				  <div class="form-group">
                  <label class="col-sm-2 control-label">手机网站开关</label>
                  <div class="col-sm-2">
                    <select name="wapmark" id="wapmark" class="form-control autogo">
                      <option value="">请选择</option>
                      <option value="0" {$check_onoff [c wapmark],"selected",'',0}>关闭</option>
                      <option value="1" {$check_onoff [c wapmark],"selected",'',1}>独立手机站</option>
                      <option value="2" {$check_onoff [c wapmark],"selected",'',2}>伪自适应</option>
                    </select>
                  </div>
                  <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 伪自适应是和pc网址相同,独立手机站有wap/</span> </div> 
				  
				  
                <div class="form-group">
                  <label class="col-sm-2 control-label">手机网站目录</label>
                  <div class="col-sm-2">
                    <input type="text" value="[c:wappath]" name="wappath" id="wappath" readonly class="form-control">
                  </div>
                   <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 修改需要有目录更改权限，<a onclick="layer.prompt({title: '请输入新目录名称，如m'},function(path, index){$.post('save.php?act=upadmin',{'type':'wap','path':path},function(data){if(data==true){location.reload();window.open('../'+path) }})});" class="label label-primary ">我想修改</a></span></div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">手机站是否识别电脑站</label>
                  <div class="col-sm-2">
                    <select name="padautogo" id="pc" class="form-control autogo">
                      <option value="">请选择</option>
                      <option value="0" {$check_onoff [c padautogo],"selected",'',0}>不跳转</option>
                      <option value="1" {$check_onoff [c padautogo],"selected",'',1}>跳转pc目录</option>
                      <option value="2" {$check_onoff [c padautogo],"selected",'',2}>跳转pc网址</option>
                    </select>
                  </div>
                  <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 根据浏览器类型跳转到对应网站</span> </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">电脑站是否识别手机站</label>
                  <div class="col-sm-2">
                    <select name="wapautogo" id="wap" class="form-control autogo">
                      <option value="">请选择</option>
                      <option value="0" {$check_onoff [c wapautogo],"selected",'',0}>不跳转</option>
                      <option value="1" {$check_onoff [c wapautogo],"selected",'',1}>跳转wap目录</option>
                      <option value="2" {$check_onoff [c wapautogo],"selected",'',2}>跳转wap网址</option>
                    </select>
                  </div>
                  <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 根据浏览器类型跳转到对应网站</span> </div>
              </div>
            </div>
            <div id="tab-5" class="tab-pane">
              <div class="panel-body">
                <div class="form-group">
                  <div class="alert alert-info col-sm-10 col-md-offset-1"> 邮件提醒功能，需要使用您的邮箱作为发件方。 注意：大多数服务器都禁用了25端口，发送失败请尝试ssl协议并使用465端口。 </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">邮件开关</label>
                  <div class="col-sm-2" id="mailmark" >
                    <input type="checkbox"  name="mailmark" value="1" class="js-switch" {$check_onoff [c mailmark],"checked"}>
                    <span class="help-block m-b-none"> {$check_onoff [c mailmark],'ch'}</span> </div>
                  <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 关闭后将不能发送提醒邮件。 </span> </div>
                <div class="show-[c:mailmark]" id="showmail">
                  <div class="form-group">
                    <label class="col-sm-2 control-label">发件服务器</label>
                    <div class="col-sm-4">
                      <input type="text" value="[c:smtp_server]" name="smtp_server" id="smtp_server" class="form-control">
                      <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 参照：smtp.qiye.163.com，建议使用企业邮箱</span> </div>
                    <label class="col-sm-1 control-label">协议</label>
                    <div class="col-sm-1" id="mailmark" >
                      <select   name="smtp_ssl" id="smtp_ssl"  class="form-control">
                        <option value="">标准</option>
                        <option value="ssl" {$check_on [c smtp_ssl],'ssl','selected'}>SSL</option>
                      </select>
                    </div>
                    <label class="col-sm-1 control-label">端口</label>
                    <div class="col-sm-2" id="mailmark" >
                      <input type="text"  name="smtp_port" id="smtp_port" value="[c:smtp_port]" class="form-control">
                      <span class="help-block m-b-none"> 标准：25，SSL：465</span> </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">发件人地址</label>
                    <div class="col-sm-4">
                      <input type="text" value="[c:smtp_mail]" name="smtp_mail" id="smtp_mail" class="form-control">
                      <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 参照：kefu@zzzcms.com</span> </div>
                    <label class="col-sm-1 control-label">昵称</label>
                    <div class="col-sm-4">
                      <input type="text" value="[c:smtp_name]" name="smtp_name" id="smtp_name" class="form-control">
                      <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 参照：kefu@zzzcms.com</span> </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">账号</label>
                    <div class="col-sm-4">
                      <input type="text" value="[c:smtp_user]" name="smtp_user" id="smtp_user" class="form-control">
                      <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 参照：kefu@zzzcms.com，企业邮箱写全账号</span> </div>
                    <label class="col-sm-1 control-label">密码</label>
                    <div class="col-sm-4">
                      <input type="text" value="[c:smtp_pass]" name="smtp_pass" id="smtp_pass" class="form-control">
                      <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 参照：123456</span> </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">收件邮箱地址</label>
                    <div class="col-sm-9">
                      <input type="text" value="[c:receive_email]" name="receive_email" id="receive_email" class="form-control">
                      <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 参照：kefu@zzzcms.com,365661@qq.com，支持多个邮箱逗号分隔</span> </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">留言提醒</label>
                    <div class="col-sm-1" >
                      <input type="checkbox"  name="gbooksendmail" value="1" class="js-switch" {$check_onoff [c gbooksendmail],"checked"}>
                      <span class="help-block m-b-none">{$check_onoff [c gbooksendmail],'ch'}</span> </div>
                    <label class="col-sm-1 control-label">注入提醒</label>
                    <div class="col-sm-1" >
                      <input type="checkbox"  name="evalsendmail" value="1" class="js-switch" {$check_onoff [c evalsendmail],"checked"}>
                      <span class="help-block m-b-none"> {$check_onoff [c evalsendmail],'ch'}</span> </div>
                    <label class="col-sm-1 control-label">注册提醒</label>
                    <div class="col-sm-1" >
                      <input type="checkbox"  name="regsendmail" value="1" class="js-switch" {$check_onoff [c regsendmail],"checked"}>
                      <span class="help-block m-b-none"> {$check_onoff [c regsendmail],'ch'}</span> </div>
                    <label class="col-sm-1 control-label">登陆提醒</label>
                    <div class="col-sm-1" >
                      <input type="checkbox"  name="loginsendmail" value="1" class="js-switch" {$check_onoff [c loginsendmail],"checked"}>
                      <span class="help-block m-b-none"> {$check_onoff [c loginsendmail],'ch'}</span> </div>
                    <label class="col-sm-1 control-label">忘记密码</label>
                    <div class="col-sm-1" >
                      <input type="checkbox"  name="forgetsendmail" value="1" class="js-switch" {$check_onoff [c forgetsendmail],"checked"}>
                      <span class="help-block m-b-none"> {$check_onoff [c forgetsendmail],'ch'}</span> </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">测试邮箱配置</label>
                  <div class="col-sm-2" >
                    <button type="button" class="btn btn-info" id="tryemail"><i class="fa fa-envelope"></i>　发送测试邮件</button>
                    <script>
					 $("#tryemail").click(function(){
						var smtp_server= $("#smtp_server").val(),smtp_mail= $("#smtp_mail").val(), smtp_user= $("#smtp_user").val(),smtp_pass= $("#smtp_pass").val(),receive_email= $("#receive_email").val(),smtp_name=$("#smtp_name").val(),smtp_ssl=$("#smtp_ssl").val(),smtp_port=$("#smtp_port").val();
						$.post('save.php?act=tryemail',{'smtp_server':smtp_server,'smtp_mail':smtp_mail,'smtp_user':smtp_user,'smtp_name':smtp_name,'smtp_ssl':smtp_ssl,'smtp_port':smtp_port,'smtp_pass':smtp_pass,'receive_email':receive_email},function(data) {if(data=true){alert("测试成功，如未收到邮件请确认是否开启smtp协议，是否端口封闭等问题")}});})
					 </script> 
                  </div>
                </div>
              </div>
            </div>
            <div id="tab-7" class="tab-pane">
              <div class="panel-body">
                <div class="form-group">
                  <div class="alert alert-info col-sm-10 col-md-offset-1"> 默认集成了短信验证码功能
                    <button type="button" class="btn btn-danger regsms"><i class="fa fa-commenting"></i>　申请短信接口</button>
                    <a href="javascript:void(0)" class="btn btn-success regsms"  target="_blank">充值地址</a> </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">短信开关</label>
                  <div class="col-sm-1" id="smsmark" >
                    <input type="checkbox"  name="smsmark" value="1" class="js-switch" {$check_onoff [c smsmark],"checked"}>
                    <span class="help-block m-b-none"> {$check_onoff [c smsmark],'ch'}</span> </div>
                  <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 开启后，会员注册，找回密码等采用短信验证</span> </div>
                <div class="show-[c:smsmark]" id="showsms">
                  <div class="form-group">
                    <label class="col-sm-2 control-label">账号</label>
                    <div class="col-sm-4">
                      <input type="text" value="[c:smsid]" name="smsid" id="smsid" class="form-control">
                    </div>
                    <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 6-10位数字账号</span> </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">密码</label>
                    <div class="col-sm-4">
                      <input type="text" value="[c:smspw]" name="smspw" id="smspw" class="form-control">
                    </div>
                    <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 32位字母数字组合</span> </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">注册短信验证</label>
                    <div class="col-sm-1" >
                      <input type="checkbox"  name="regsendsms" value="1" class="js-switch"  {$check_onoff [c regsendsms],"checked"}>
                      <span class="help-block m-b-none">开启</span> </div>
                    <label class="col-sm-2 control-label">找回密码验证</label>
                    <div class="col-sm-1" >
                      <input type="checkbox"  name="forgetsendsms" value="1" class="js-switch" {$check_onoff [c forgetsendsms],"checked"} >
                      <span class="help-block m-b-none">开启</span> </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">测试短信配置</label>
                    <div class="col-sm-2" >
                      <input type="text" id="testphone" name="testphone" placeholder="手机号"  class="form-control">
                    </div>
                    <div class="col-sm-4">
                      <button type="button" class="btn btn-info" id="trysms"><i class="fa fa-commenting"></i>　发送测试短信</button>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">余额</label>
                    <div class="col-sm-2" >
                      <input type="button" class="btn btn-outline btn-danger" id="smsnum" value="查询">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">发送记录</label>
                    <div class="col-sm-2" >
                      <button type="button" onClick="opennew('../plugins/sms/sms_list.php')" class="btn btn-outline btn-success">查看发送记录</button>
                    </div>
                  </div>
                </div>
              </div>
              <script>
					$("#smsnum").click(function(){
						$this=$(this);
						$.post('../plugins/sms/sms.php?act=getnum',function(data) {
							$this.val('剩余：'+data+'条')
						});
					});
					 $("#trysms").click(function(){
						 var mobile=$("#testphone").val();	
						 var myreg = /^(((1[3-8]{1}[0-9]{1}))+\d{8})$/; 
 						 if(myreg.test(mobile)){ 	 
						  $.post('../plugins/sms/sms.php?act=trysms',{'mobile':mobile},function(data) 
						 	 {
								 var act = data.substring(0, 1);
   								 var info = data.substring(1);
								  if (act == 1) {layer.msg("测试发送成功,请查看手机是否收到",{icon: 1,time: 2000})} 
								  else{layer.msg(info,{icon: 0,time: 2000})} 
						  });
 						 }else{
      					  alert('请输入有效的手机号码！'); 
						  $("#testphone").focus();   
						 }
    				  })
					 $(".regsms").click(function(){ 
					 layer.open({
						  type: 2,
						  title: '申请短信接口',
						  shadeclose: true,
						  shade: 0.8,
						  area: ['1200px', '90%'],
						  content: 'http://zzzcms.com/sms/' //iframe的url
						  }); 
					  })
					 </script> 
            </div>
            <div id="tab-6" class="tab-pane">
              <div class="panel-body">
                <div class="form-group">
                  <div class="alert alert-info col-sm-10 col-md-offset-1"> zzzcms系统默认支持Mysql/sqlite/access数据库，<a href="http://zzzcms.com/a/case/8_181_1.html"  class="btn btn-success" target="_blank">申请转换数据</a> </div>
                </div>
				  <div class="form-group">
                  <label class="col-sm-2 control-label">数据调试模式</label>
                  <div class="col-sm-1" id="showsql" >
                    <input type="checkbox"  name="showsql" value="1" class="js-switch" {$check_onoff $conf['db']['showsql'],"checked"}>
                    <span class="help-block m-b-none"> {$check_onoff $conf['db']['showsql'],'已开启'}</span> </div>
                  <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 开启后，显示sql语句并显示步进时间</span> </div>
				  
				  
				  
                <div class="form-group">
                  <label class="col-sm-2 control-label">数据库类型</label>
                  <div class="col-sm-2" id="db" >
                    <select  name="type" class="form-control">
                      <option value="<?php echo $conf['db']['type']?>"><?php echo $conf['db']['type']?></option>
                      <option value="mysql">mysql</option>
                      <option value="sqlite">sqlite</option>
                      <option value="access">access</option>
                    </select>
                  </div>
                </div>
                <div id="showaccess" class="dbinfo" style="<?php echo $conf['db']['type']=='access' ? '' : 'display: none;' ?>">
                  <div class="form-group">
                    <label class="col-sm-2 control-label">数据库路径</label>
                    <div class="col-sm-2">
                      <input type="text" value="<?php echo $conf['db']['accesspath'] ?>" name="accesspath" id="accesspath" class="form-control">
                    </div>
                    <span class="help-block m-b-none"><i class="fa fa-info-circle"></i><code>请确保路径正确</code>,默认“data/”，务必以 / 结尾</span> </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">数据库名称</label>
                    <div class="col-sm-2">
                      <input type="text" value="<?php echo $conf['db']['accessname'] ?>" name="accessname" id="accessname" class="form-control">
                    </div>
                  </div>
                </div>
                <div id="showsqlite"  class="dbinfo"  style="<?php echo $conf['db']['type']=='sqlite' ? '' : 'display: none;' ?>">
                  <div class="form-group">
                    <label class="col-sm-2 control-label">数据库路径</label>
                    <div class="col-sm-2">
                      <input type="text" value="<?php echo $conf['db']['sqlitepath'] ?>" name="sqlitepath" id="sqlitepath" class="form-control">
                    </div>
                    <span class="help-block m-b-none"><i class="fa fa-info-circle"></i><code>请确保路径正确</code>,默认“data/”，务必以 / 结尾</span> </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">数据库名称</label>
                    <div class="col-sm-2">
                      <input type="text" value="<?php echo $conf['db']['sqlitename'] ?>" name="sqlitename" id="sqlitename" class="form-control">
                    </div>
                  </div>
                </div>
                <div id="showmysql" class="dbinfo"  style="<?php echo $conf['db']['type']=='mysql' ? '' : 'display: none;' ?>">
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Mysql服务器</label>
                    <div class="col-sm-2">
                      <input type="text" value="<?php echo $conf['db']['host'] ?>" name="host" id="host" class="form-control" autocomplete="off">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Mysql端口</label>
                    <div class="col-sm-2">
                      <input type="text" value="<?php echo $conf['db']['port'] ?>" name="port" id="port" class="form-control" autocomplete="off">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">数据库名称</label>
                    <div class="col-sm-2">
                      <input type="text" value="<?php echo $conf['db']['name'] ?>" name="name" id="name" class="form-control" autocomplete="off">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Root账号</label>
                    <div class="col-sm-2">
                      <input type="text" value="<?php echo $conf['db']['user'] ?>" name="user" id="user" class="form-control" readonly onFocus="this.removeAttribute('readonly');">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Root密码</label>
                    <div class="col-sm-4">                      
                      <label>为了保证数据库安全，数据库信息请管理员手动修改config文件</label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-12  m-t">
        <div class=" col-sm-10 col-md-offset-1">
          <button class="btn btn-primary" type="submit" id="submit" title="快捷键：ctrl+enter"><i class="fa fa-floppy-o"></i>　保存内容</button>
          <button onClick="location.reload()" class="btn" type="button"><i class="fa fa-refresh"></i> 刷新</button>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- end panel other -->
</div>
<script src="../plugins/bootstrap/bootstrap.min.js"></script>
<link href="../plugins/colorpicker/bootstrap-colorpicker.min.css" rel="stylesheet">
<script src="../plugins/switchery/switchery.js"></script>
<link href="../plugins/switchery/switchery.css" rel="stylesheet">
<script src="../plugins/icheck/icheck.min.js"></script> 
<script src="js/adminjs.js"></script> 
<script>
$(function () {
	$(".i-checks").iCheck()
	var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
		elems.forEach(function(html) {
		var switchery = new Switchery(html);
		html.onchange = function() {
		var help=$(this).parent().find(".help-block")
		if(html.checked==true) {help.text("已开启")}
		else{help.text("已关闭")}
		};
	});
      $("#webmode").click(function () {
		    if ($("#webmode input").is(":checked")) {                
				  $("#showcloseinfo").css("display", "none");					
            }
            else {
              	$("#showcloseinfo").css("display", "block");
            }
        }); 
		$("#usermark").click(function () {
		    if ($("#usermark input").is(":checked")) {
                $("#showuser").css("display", "block");
            }
            else {
                $("#showuser").css("display", "none");
            }
        });   
		$("#gbookmark").click(function () {
		    if ($("#gbookmark input").is(":checked")) {
                $("#showgbook").css("display", "block");
            }
            else {
                $("#showgbook").css("display", "none");
            }
        });  
        
        $("#mailmark").click(function () {
		    if ($("#mailmark input").is(":checked")) {
                $("#showmail").css("display", "block");
            }
            else {
                $("#showmail").css("display", "none");
            }
        });
		
		$("#smsmark").click(function () {
		    if ($("#smsmark input").is(":checked")) {
                $("#showsms").css("display", "block");
            }
            else {
                $("#showsms").css("display", "none");
            }
        });
      
        $("#db select").change(function () {
			var val=$("#db select").val();
		  	$(".dbinfo").hide();
			$("#show"+val).show();
        });
        $("#logsql").click(function () {
		    if ($("#logsql input").is(":checked")) {
                $("#showlogsql").css("display", "block");			
            }
            else {
                $("#showlogsql").css("display", "none");			
            }
        });
    if(location.hash) {
        $('a[href=' + location.hash + ']').tab('show');
    }
    $(document.body).on("click", "a[data-toggle]", function(event) {
        location.hash = this.getAttribute("href");
    });
});
$(window).on('popstate', function() {
    var anchor = location.hash || $("a[data-toggle=tab]").first().attr("href");
    $('a[href=' + anchor + ']').tab('show');
});
</script>
</body>
</html>