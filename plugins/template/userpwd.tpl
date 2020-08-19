<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<meta name="apple-mobile-web-app-capable" content="yes"/>
<meta name="apple-touch-fullscreen" content="yes"/>
<meta name="format-detection" content="telephone=no"/>
<meta name="apple-mobile-web-app-status-bar-style" content="black"/>
<meta name="format-detection" content="telephone=no"/>
<meta name="msapplication-tap-highlight" content="no"/>
<meta name="viewport" content="initial-scale=1,maximum-scale=1,minimum-scale=1"/>
<title>修改密码</title>
<link rel="stylesheet" type="text/css" href="{zzz:plugpath}template/css/base.css">
<link rel="stylesheet" type="text/css" href="{zzz:plugpath}template/css/nctouch_member.css">
</head>
<body>
<div class="scroller-body">
  <div class="scroller-box">
    <div class="member-center">
      <form action="{zzz:sitepath}form/?editpwd" method="post">   
           <input name="uid" value="[user:uid]" type="hidden">
        <div class="edituser nctouch-inp-con">
          <header id="header">
            <div class="header-wrap">
            <div class="header-l"> <a href="{zzz:sitepath}?user">  <i class="back"></i> </a> </div>
              <div class="header-title">
                <h1>安全设置</h1>
              </div>
            </div>
          </header>
          <ul  class="user_info" >
            <li class="form-item">
              <h4>用户名</h4>
              <div class="input-box"> [user:name]</div>
            </li>
            <li class="form-item">
              <h4>旧密码</h4>
              <div class="input-box">
                <input name='password' class="inp"  type='password' id='password' size="38" maxlength='20'>
              </div>
            </li>
            <li class="form-item">
              <h4>新密码</h4>
              <div class="input-box">
                <input name='newpassword' class="inp"  type='text' id='repassword' size="38" maxlength='20'>
              </div>
            </li>
            <li class="form-item">
              <h4>安全问题</h4>
              <div class="input-box">
                <input name='question' class="inp"  type='text' id='question' size="38" maxlength='20' alue="[user:question]" placeholder="找回密码必填">
              </div>
            </li>
            <li class="form-item">
              <h4>问题答案</h4>
              <div class="input-box">
                <input name='answer' class="inp"  type='text' id='answer' size="38" maxlength='20' placeholder="找回密码必填"  value="[user:answer]">
              </div>
            </li>
          </ul>
          <div class="form-btn ok">
            <input type="submit" name="Submit" value="修改信息" class="btn">
          </div>
       </div>
      </form>  </div>
      <div class="clearfix"></div>
    </div>
  </div>
  <footer id="footer"></footer>
</div>
<script>
$('#closelayer').click(function(){parent.layer.closeAll()})
function opennew(url){layer.open({type:2,shade:0.8, maxmin: true, area:['90%','90%'],content:url,end:function(){location.reload();}});}
</script>
</body>
</html>