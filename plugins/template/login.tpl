<!doctype html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<meta charset="utf-8">
<title>会员登录-{zzz:sitetitle}</title>
<meta name="description" content="{zzz:sietdesc}"/>
<meta name="Keywords" content="{zzz:sitekeys}"/>
<meta name="author" content="http://www.zzzcms.com"/>
<script src="{zzz:sitepath}js/jquery.min.js" type="text/javascript"></script>
<link href="{zzz:sitepath}plugins/Validform/Validform.css" rel="stylesheet" />
<script src="{zzz:sitepath}plugins/Validform/Validform.min.js"></script>
<link href="{zzz:plugpath}bootstrap/bootstrap.min.css" rel="stylesheet">
<link href="{zzz:plugpath}bootstrap/font-awesome.min.css?v=4.4.0" rel="stylesheet">
<link href="{zzz:plugpath}bootstrap/animate.min.css" rel="stylesheet">
<link href="{zzz:plugpath}bootstrap/style.min.css" rel="stylesheet">
<link href="{zzz:plugpath}template/css/login.min.css" rel="stylesheet">
<script type="text/javascript">
    $(function() {
        $(".registerform").Validform({
		tiptype:2
	}); 
	var logopanel=$(".other-btn").html()
	if(logopanel.length<10) $(".other-info").hide();		
	if(get_cookie('usercheck')==1){
		$("#usercheck").attr("checked","checked");
		$("#username").val(get_cookie('username'));
		$("#password").val(get_cookie('userpass'));
	}
 })
</script>
</head>

<body class="signin">
<div class="signinpanel">
  <div class="row">
    <div class="col-sm-12 animated fadeInDown">
      <div class="signin-info">
        <div class="logopanel m-b">
          <h1>{zzz:sitetitle}</h1>
          <h5>{zzz:sitetitle2}</h5>
        </div>
        <div class="m-b"></div>
      </div>
    </div>
    <div class="col-sm-12 animated fadeInDown">
      <form class="registerform" method="post" action="{zzz:sitepath}form/?login">
        <input type="hidden" name="type" value="[user:type]">
        <input type="hidden" name="backurl" value="[user:backurl]">
        <h4 class="no-margins">会员登录：</h4>
        <p class="m-t-md"></p>
        <li>
          <div>
            <input type="text" value="" name="username" id="username" placeholder="账号/手机号" class="form-control" datatype="s5-16" ajaxurl="{zzz:sitepath}plugins/sms/sms.php?act=checkname&checktype=1" nullmsg="请输入账号" errormsg="账户至少5个字符,最多18个字符！" />
            <i class="fa fa-user"></i> </div>
          <div class="Validform_checktip"></div>
        </li>
        <li>
          <div>
            <input type="password" name="password" id="password" class="form-control" placeholder="密码" datatype="s6-16" nullmsg="请输入密码！" errormsg="密码范围在6~16位之间！"/>
            <i class="fa fa-key"></i> </div>
          <div class="Validform_checktip"></div>
        </li>
        {if:{conf:usercode}=1}
        <li>
          <div>
            <input type="text" value="" name="code" class="form-control code" id="imgcode" ajaxurl="{zzz:sitepath}plugins/sms/sms.php?act=checkcode" datatype="*4-4" nullmsg="请输入验证码" errormsg="验证码错误" />
          </div>
          <div class="Validform_checktip"></div>
          <div class="imgcode"><img src="{zzz:sitepath}inc/imgcode.php" id="SeedCode" align="absmiddle" style="cursor:pointer;" border="0"/> </div>
        </li>
        {end if}
        <div class="row">
          <div class="col-sm-12">
            <label for="usercheck">
              <input type="checkbox" id="usercheck" name="usercheck" value="1" >
              记住密码</label>
            <div class="pull-right"><a href="{zzz:sitepath}?location=user&act=reg&type=[user:type]&backurl=[user:backurl]" class="nowreg">注册账号</a> <a href="{zzz:sitepath}?location=user&act=forget&type=[user:type]&backurl=[user:backurl]" class="nowforget">忘记密码</a></div>
          </div>
        </div>
        <button class="btn btn-success btn-block m-t" id="oBtn" type="submit">登录</button>
      </form>
      <div class="other-info fidein m-t">
        <h3>第三方登录</h3>
       <div class="logopanel other-btn">{if:check_dir('{zzz:sitepath}plug/qqlogin/')}<a href="/plug/qqlogin/"><img src="{zzz:plugpath}template/images/qq.png" title="qq登录">qq登录</a>{end if} {if:check_dir('{zzz:sitepath}plug/wxlogin/')}<a href="/plug/wxlogin/"><img src="{zzz:plugpath}template/images/weixin.png" title="微信登录">微信登录</a>{end if}{if:check_dir('{zzz:sitepath}plug/wblogin/')}<a href="/plug/wblogin/"><img src="{zzz:plugpath}template/images/weibo.png" title="微博登录">微博登录</a>{end if}</div></div>
    </div>
  </div>
  <div class="signup-footer animated fadeInDown m-t">
    <div> {zzz:copyright} </div>
  </div>
</div>
<script src="{zzz:plugpath}bootstrap/bootstrap.min.js"></script>
<script src="{zzz:sitepath}js/zzzcms.js" type="text/javascript"></script>
<script src="{zzz:plugpath}layer/layer.min.js" type="text/javascript"></script>
</body>
</html>