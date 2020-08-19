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
<link rel="stylesheet" type="text/css" href="{zzz:plugpath}template/css/base.css">
<link rel="stylesheet" type="text/css" href="{zzz:plugpath}template/css/nctouch_member.css">
<title>我的资料</title>
</head>
<body>
<div class="scroller-body">
  <div class="scroller-box">
      <div class="member-top">
  <div class="member-info"><a href="{zzz:sitepath}plug/face/" class="default-avatar" style="display:block; background:url([user:face]); background-size:cover"></a><a class="to-login">[user:truename]</a></div>
  <div class="member-collect"><span><a href="{zzz:sitepath}?user/useredit"><i class="favorite-goods"></i>
    <p>个人资料</p>
    </a> </span><span><a href="{zzz:sitepath}?user/userpwd"><i class="favorite-store"></i>
    <p>密码管理</p>
    </a> </span><span><a href="{zzz:sitepath}?user/loginout"><i class="goods-browse"></i>
    <p>退出登录</p>
    </a> </span></div>
</div>

    <div class="member-center">
    
      <!--  <dl class="mt5">
        <dt><a href="/?userorder/">
          <h3><i class="mc-01"></i>商品订单</h3>
          <h5>查看全部订单<i class="arrow-r"></i></h5>
          </a></dt>
        <dd>
          <ul id="order_ul">
            <li><a href="/?userorder/nopay"><i class="cc-01"></i>
              <p>待付款</p>
              </a></li>
            <li><a href="/?userorder/ispay"><i class="cc-02"></i>
              <p>已付款</p>
              </a></li>
            <li><a href="/?userorder/nopost"><i class="cc-03"></i>
              <p>待发货</p>
              </a></li>
            <li><a href="/?userorder/ispost"><i class="cc-04"></i>
              <p>已发货</p>
              </a></li>
            <li><a href="/?userorder/isover"><i class="cc-05"></i>
              <p>已完成</p>
              </a></li>
          </ul>
        </dd>
      </dl>
      
	<dl  style="border-top: solid 0.05rem #EEE;">
        <dt><a href="/?userpoints/">
          <h3><i class="mc-01"></i>我的积分</h3>
          <h5>积分：[user:points]<i class="arrow-r"></i></h5>
          </a></dt>               
      </dl>
      -->
      <dl style="border-top: solid 0.05rem #EEE;">
        <dt><a href="{zzz:sitepath}?user/userpwd">
          <h3><i class="mc-02"></i>安全设置</h3>
          <h5><i class="arrow-r"></i></h5>
          </a></dt>
      </dl>
      <dl style="border-top: solid 0.05rem #EEE;">
        <dt><a href="{zzz:sitepath}?user/useredit">
          <h3><i class="mc-03"></i>用户资料</h3>
          <h5><i class="arrow-r"></i></h5>
          </a></dt>
      </dl>
      <dl style="border-top: solid 0.05rem #EEE;">
        <dt><a href="{zzz:sitepath}?user/loginout">
          <h3><i class="mc-04"></i>退出登录</h3>
          <h5><i class="arrow-r"></i></h5>
          </a></dt>
      </dl>
      <div class="clearfix"></div>
    </div>
  </div>
</div>

</body>
</html>