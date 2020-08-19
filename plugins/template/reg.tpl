<!doctype html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<meta charset="utf-8">
<title>会员注册-{zzz:sitetitle}</title>
<meta name="description" content="{zzz:sietdesc}"/>
<meta name="Keywords" content="{zzz:sitekeys}"/>
<meta name="author" content="http://www.zzzcms.com"/>
<script src="{zzz:sitepath}js/jquery.min.js" type="text/javascript"></script>
<script src="{zzz:plugpath}layer/layer.min.js" type="text/javascript"></script>
<script src="{zzz:sitepath}js/zzzcms.js" type="text/javascript"></script>
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
});   
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
    <form class="registerform" method="post" action="{zzz:sitepath}form/?reg">
      <input type="hidden" name="type" value="[user:type]">
      <input type="hidden" name="backurl" value="[user:backurl]">
      <h4 class="no-margins">会员注册：</h4>
      <p class="m-t-md"></p>
      <div class="formsub">
        <li>
          <div>
            <input type="text" value="" name="username" class="form-control" datatype="*5-18" placeholder="请输入账号 " ajaxurl="{zzz:sitepath}plugins/sms/sms.php?act=checkname " errormsg="账号范围5~18 " />
                <i class="fa fa-user"></i>
          </div>
         <div class="Validform_checktip"></div>
        </li>
        <li>
          <div>
            <input type="text" value="" name="password" class="form-control" datatype="*5-16" placeholder="请输入密码" errormsg="密码范围范围5~16" />
                <i class="fa fa-key"></i>
          </div>
         <div class="Validform_checktip"></div>
        </li>
        {if:{conf:ischeckmobile}=1}
        <li>
          <div>
            <input type="text" value="" name="mobile" id="phonenum" class="form-control" datatype="m" placeholder="请输入手机号 " ajaxurl="{zzz:sitepath}plugins/sms/sms.php?act=checkmobile " errormsg="手机格式不正确 " />
                <i class="fa fa-mobile"></i>
          </div>
        <div class="Validform_checktip"></div>
        </li>
        {end if}
        {if:{conf:ischeckemail}=1}
        <li>
          <div>
            <input type="text" value="" name="email" id="email" class="form-control" datatype="e" placeholder="请输入邮箱地址 " ajaxurl="{zzz:sitepath}plugins/sms/sms.php?act=checkemail " errormsg="邮箱格式不正确 " />
                <i class="fa fa-email"></i>
          </div>
          <div class="Validform_checktip "></div>
        </li>
        {end if}
        {if:{conf:usercode}=1}
        <li>
          <div>
            <input type="text " value="" name="code" id="imgcode" class="form-control code" ajaxurl="{zzz:sitepath}plugins/sms/sms.php?act=checkcode" datatype="*4-4" placeholder="请输入验证码" errormsg="验证失败" />              
          </div>
          <div class="Validform_checktip"></div>
          <div class="imgcode"> <img src="{zzz:sitepath}inc/imgcode.php" id="SeedCode" align="absmiddle" style="cursor:pointer;" border="0"/> </div>
        </li>
        {end if}
        {if:{conf:regsendsms}=1} 
        <script src="{zzz:sitepath}plugins/sms/sms.js" type="text/javascript"></script>
        <li>
          <div>
          <input type="text" value="" name="smscode" id="smscode" class="form-control code" datatype="n4-4" ajaxurl="{zzz:sitepath}plugins/sms/sms.php?act=checkcode" placeholder="请输入短信验证码" errormsg="验证码错误">
                <i class="fa fa-comment"></i>
          <div>
          <div class="Validform_checktip"></div>
         <div class="imgcode"> <input id="sedcond" class="button" type="button" value="获取验证码"></div>
        </li>
        {end if}
        <div class="row">
          <div class="col-sm-12"> <a a href="{zzz:sitepath}?location=user&act=login&type=[user:type]&backurl=[user:backurl]">登陆账号</a>
           <a href="{zzz:sitepath}?location=user&act=forget&type=[user:type]&backurl=[user:backurl]" class="pull-right">忘记密码？</a> </div>
        </div>
        <div class="action">
          <button class="btn btn-success btn-block m-t" type="submit" >注册</button>
        </div>
      </div>
    </form>
  </div>
      </div>
  <div class="signup-footer animated fadeInDown m-t">
    <div> {zzz:copyright} </div>
  </div>
</div>
<script src="{zzz:plugpath}bootstrap/bootstrap.min.js"></script>
</body>
</html>