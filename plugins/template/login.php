<?php
require '../../inc/zzz_class.php';
$backurl=getform('backurl','get');
$path =is_mobile() ?  SITE_PATH.'wap/' :  SITE_PATH;
$url =conf('runmode')==1 ? $path.'index.php?location=user&backurl='.$backurl.'&act=' : $path.'?location=user&backurl='.$backurl.'&act=' ;
if ((get_session('uid')>0)){
	echo('document.write("  <a href='.$url.'userinfo><i class=\'ico login\'></i> 会员中心</a><a href='.$url.'loginout><i class=\'ico reg\'></i> 登出</a>")');
}else{
	echo('document.write("  <a href='.$url.'login><i class=\'ico login\'></i> 登录</a><a href='.$url.'reg><i class=\'ico reg\'></i> 注册</a>")');
}
?>