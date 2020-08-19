<?php
include '../../inc/zzz_class.php';
$act = getform("act","both");
switch ($act){
	case "sendcode": 			sendcode();			break;	
	case "checkcode": 			checkcode();		break;
	case "checkmobile": 		checkmobile();		break;
	case "checkemail": 			checkemail();		break;	
	case "checkname":	 		checkname();		break;
	case 'trysms':		echo	try_sms(); 			break;				
	case "getnum": 		echo	smsnum();			break;
	case "getcode":		echo $_SESSION['code']	;break;
	default:			echo get_session("smscode");
}

function try_sms(){
	$mobile= getform("mobile",'post');
	return send_sms($mobile,'这是一条测试短信，您的验证码是1234。');
}

function sendcode(){
	$smsphone=getform("phonenum","both");
	$smscode= randname(4,'num');	
	$smsdata=send_sms($smsphone,"验证码为".$smscode.",有效期10分钟，请不要把验证码泄露给其他人。");
	set_session("smscode",$smscode);
	set_session("smsphone",$smsphone);
	echo $smsdata;
}

function checkcode(){
	$checkname=safe_word(getform("name","post"));
	$checkparam=safe_word(getform("param",'post'));
	$checktype=getform("checktype",'get');
	if ($checkname=="smscode" || $checktype=="smscode"){ 
		$nowcode=get_session("smscode")	;
		if( empty($nowcode)) die('{"status":"n","info":"验证失败1"}');	
	}elseif($checkname="code" || $checktype="code"){
		$nowcode=$_SESSION['code'];
		if(empty($nowcode)) die ('{"status":"n","info":"验证失败2"}');	
	}
	if ($checkparam==$nowcode) {
		echo '{"info":"验证成功","status":"y"}';
	} else{
		 echo'{"info":"验证失败","status":"n"}';
	}
}

function checkmobile(){		
		$checkparam=safe_word(getform("param","post"));
		$checktype=getform("checktype","get");
		if(empty($checktype)) $checktype=0;
		if(checkstr($checkparam,"mobile")) {
			if ($checktype==0) {if (check_used("user","mobile",$checkparam)) { echo '{"info":"手机号已被使用，请确认!","status":"n"}';} else{echo '{"info":"通过验证","status":"y"}';}}
			if ($checktype==1) {if (check_used("user","mobile",$checkparam)) { echo '{"info":"通过验证","status":"y"}';} else {  echo '{"info":"手机号不存在，请确认!","status":"n"}';}}
		}else{
			 echo '{"info":"验证失败","status":"n"}';
		}
}

function checkemail(){
		$checkparam=safe_url(getform("param","post"));
		$checktype=getform("checktype","get");
		if(empty($checktype)) $checktype=0;
		if(checkstr($checkparam,"email")) {
			if ($checktype==0) {if (check_used("user","email",$checkparam)) { echo '{"info":"邮箱账号已被使用，请确认！","status":"n"}';}else{echo '{"info":"通过验证","status":"y"}';}}
			if ($checktype==1) {if (check_used("user","email",$checkparam)) { echo '{"info":"通过验证","status":"y"}';} else {  echo '{"info":"邮箱账号不存在，请确认！","status":"n"}';}}
		}else{
			 echo '{"info":"验证失败","status":"n"}';
		}
}

function checkname(){
	$checkparam=safe_word(getform("param","post"));
	$checktype=getform("checktype","get");
	if( empty($checktype)) $checktype=0;
	if(checkstr($checkparam,"username")) {
		if ($checktype==0) {if(check_used("user","username",$checkparam)) {echo'{"info":"账号已存在，请确认！","status":"n"}'; }else{echo'{"info":"通过验证","status":"y"}';}}
		if ($checktype==1) {if(check_used("user","username",$checkparam) || check_used("user","mobile",$checkparam))  {echo'{"info":"通过验证","status":"y"}';} else{ echo'{"info":"账号不存在，请更改","status":"n"}';}}
	}else{
		 echo '{"info":"验证失败","status":"n"}';
	}
}
?>