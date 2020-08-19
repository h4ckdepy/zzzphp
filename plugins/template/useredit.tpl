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
<title>会员资料</title>
<link rel="stylesheet" type="text/css" href="{zzz:plugpath}template/css/base.css">
<link rel="stylesheet" type="text/css" href="{zzz:plugpath}template/css/nctouch_member.css">
<script src="{zzz:sitepath}js/jquery.min.js"></script>
<script src="{zzz:plugpath}imageselect/imageselect.js"></script>
<script src="{zzz:sitepath}js/zzzcms.js"></script>
<link  rel="stylesheet" type="text/css" href="{zzz:plugpath}imageselect/imageselect.css"/>
<style>
.jqis{ height:auto !important;width: 90% !important;}
.jqis_dropdown{ position:relative; overflow: inherit}
</style>
</head>
<body>
<div class="scroller-body">
  <div class="scroller-box"> 
    <div class="member-center">
      <form action="{zzz:sitepath}form/?edituser" method="post">
      <input name="uid" value="[user:uid]" type="hidden">
        <div class="edituser nctouch-inp-con">
          <header id="header">
            <div class="header-wrap">
              <div class="header-l"> <a href="{zzz:sitepath}?user"> <i class="back"></i> </a> </div>
              <div class="header-title">
                <h1>编辑信息</h1>
              </div>
            </div>
          </header>
          <ul  class="user_info" >
           <li class="form-item">
              <h4>用户名</h4>
              <div class="input-box">
               [user:username]
              </div>
            </li>
			  {if:check_dir('/plug/wxlogin')}
           <li class="form-item">
              <h4>微信绑定</h4>
              <div class="input-box">
               {if1:'[user:wxopenid]'=''}
              <a href="/plug/wxlogin/">未绑定，马上微信绑定</a>
              {else1}
              您已经绑定了微信，<a href="/plug/wxlogin/wxlogin_fun.php?act=wxexit&uid=[user:id]&type=back">解绑</a>
              {end if1}
              </div>
            </li>
			  {end if}
			   {if:check_dir('/plug/qqlogin')}
			 <li class="form-item">
              <h4>绑定QQ</h4>
              <div class="input-box">
               {if1:'[user:qqopenid]'=''}
              <a href="/plug/qqlogin/">未绑定，马上绑定QQ</a>
              {else1}
              您已经绑定了QQ，<a href="/plug/qqlogin/qqlogin_fun.php?act=qqexit&uid=[user:id]&type=back">解绑</a>
              {end if1}
              </div>
            </li>
			    {end if}
			    {if:check_dir('/plug/wblogin')}
			  <li class="form-item">
              <h4>微博绑定</h4>
              <div class="input-box">
               {if1:'[user:wbopenid]'=''}
              <a href="/plug/wblogin/">未绑定，马上微博绑定</a>
              {else1}
              您已经绑定了微博，<a href="/plug/wblogin/wblogin_fun.php?act=wbexit&uid=[user:id]&type=back">解绑</a>
              {end if1}
              </div>
            </li>
			    {end if}
            <li class="form-item">
              <h4>姓名</h4>
              <div class="input-box">
                <input type="text" class="inp" name="truename" id="truename" value="[user:truename]">
              </div>
            </li>
            <li class="form-item">
              <h4>联系电话</h4>
              <div class="input-box">
                <input type="text" class="inp" name="tel" id="tel" value="[user:tel]">
              </div>
            </li>
            <li class="form-item">
              <h4>手机</h4>
              <div class="input-box">
                <input type="text" class="inp" name="mobile" id="mobile" value="[user:mobile]">
              </div>
            </li>
            <li class="form-item">
              <h4>邮箱</h4>
              <div class="input-box">
                <input type="text" class="inp" name="email" id="email" value="[user:email]">
              </div>
            </li>
            <li class="form-item">
              <h4>QQ号码</h4>
              <div class="input-box">
                <input type="text" class="inp" name="qq" id="qq" value="[user:qq]">
              </div>
            </li>
            <li class="form-item">
              <h4>地区选择</h4>
              <div class="input-box">

                <select class="select" name="province"  id="Province" onChange="get_province()">
                  <option value="[user:province]">{region:p,[user:province]}</option>
                </select>
               <select class="select" name="city"  id="City" onChange="get_city()">
                  <option value="[user:city]">{region:c,[user:province],[user:city]}</option>
                </select>
                 <select class="select" name="district"  id="District">
                  <option value="[user:district]">{region:d,[user:city],[user:district]}</option>
                </select>
              </div>
            </li>            
            <li class="form-item">
              <h4>联系地址</h4>
              <div class="input-box">
                <input type="text" class="inp" name="address" id="address" value="[user:address]">
              </div>
            </li>
            <li class="form-item">
              <h4>邮编</h4>
              <div class="input-box">
                <input type="text" class="inp" name="post" id="post" value="[user:post]">
              </div>
            </li>
            <li class="form-item">
              <h4>个人介绍</h4>
              <div class="input-box">
                <input type="text" class="inp" name="desc" id="desc" value="[user:desc]">
              </div>
            </li>
          </ul>
          <div class="form-btn ok">
            <input type="submit" name="Submit" value="修改信息" class="btn">
          </div>
        </div>
      </form>
      <div class="clearfix"></div>
    </div>
  </div>
  <footer id="footer"></footer>
</div>
<script>
$(function(){ 
$('select[name=face]').ImageSelect({dropdownHeight:200, dropdownWidth:100, height:32});
});
function opennew(url){layer.open({type:2,shade:0.8, maxmin: true, area:['90%','90%'],content:url,end:function(){location.reload();}});}
</script>
</body>
</html>