<!doctype html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<meta charset="utf-8">
<title>忘记密码-{zzz:sitetitle}</title>
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
      <form class="registerform" method="post" action="{zzz:sitepath}form/?forget">
        <input type="hidden" name="type" value="[user:type]">
        <input type="hidden" name="backurl" value="[user:backurl]">
         <h4 class="no-margins">忘记密码：</h4>
        <p class="m-t-md"></p>
            <li>
              <div>
                <input type="text" value="" name="mobile" class="form-control" id="phonenum" datatype="*5-18" placeholder="请输入手机号" ajaxurl="{zzz:sitepath}plugins/sms/sms.php?act=checkmobile&checktype=1" errormsg="账号范围5~18" />
              </div>
			  <i class="fa fa-mobile"></i>
              <div class="Validform_checktip"></div>
            </li>
           {if:{conf:forgetsendsms}=1}
		  <li>
              <div>
                <input type="text" value="" name="code" id="imgcode" class="form-control code" ajaxurl="{zzz:sitepath}plugins/sms/sms.php?act=checkcode" datatype="*4-4"  placeholder="请输入验证码" errormsg="验证码错误" />
              </div>
              <div class="Validform_checktip"></div>
              <div class="imgcode"> <img src="{zzz:sitepath}inc/imgcode.php" id="SeedCode" align="absmiddle" style="cursor:pointer;" border="0"/> </div>
            </li>
		  <script src="{zzz:sitepath}plugins/sms/sms.js" type="text/javascript"></script>
            <li>
              <div>
                <input type="text" value="" name="smscode" id="smscode" class="form-control code" datatype="n4-4" ajaxurl="{zzz:sitepath}plugins/sms/sms.php?act=checkcode" placeholder="请输入短信验证码" errormsg="验证码错误">
              </div>
              <div class="Validform_checktip"></div>
              <div class="imgcode">  <input id="sedcond" value="获取验证码" type="button" class="button"></div>
            </li>
		  {else}
            <li>
              <div>
                <input type="text" value="" name="question" class="form-control" placeholder="请输入问题" datatype="*" errormsg="不能为空" />
              </div>
              <div class="Validform_checktip"></div>
            </li>
            <li>
              <div>
                <input type="text" value="" name="answer" class="form-control" placeholder="请输入密码" datatype="*" errormsg="不能为空" />
              </div>
              <div class="Validform_checktip"></div>
            </li> 
            {if1:{conf:usercode}=1}
            <li>
              <div>
                <input type="text" value="" name="code" id="imgcode" class="form-control code" ajaxurl="{zzz:sitepath}plugins/sms/sms.php?act=checkcode" datatype="*4-4"  placeholder="请输入验证码" errormsg="验证码错误" />
              </div>
              <div class="Validform_checktip"></div>
              <div class="imgcode"> <img src="{zzz:sitepath}inc/imgcode.php" id="SeedCode" align="absmiddle" style="cursor:pointer;" border="0"/> </div>
            </li>
            {end if1} 
		 {end if}
        <div class="row">
          <div class="col-sm-12"> <a a href="{zzz:sitepath}?location=user&act=login&type=[user:type]&backurl=[user:backurl]" class="nowforget">登陆账号</a> 
          <div class="pull-right">还没有账号？ <a href="{zzz:sitepath}?location=user&act=reg&type=[user:type]&backurl=[user:backurl]" class="nowreg">注册账号</a> </div></div>
        </div>
          <div class="action">
            <button class="btn btn-success btn-block m-t" type="submit">登录</button>
          </div>
        </div>
      </form>
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