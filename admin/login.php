<?php
require '../inc/zzz_admin.php';
check_admin('index');
$act=getform('act','get');
switch ($act) {	
	case 'loginesc':
		login_esc();
		break;
	case 'loginout':
		del_cookie("adminname");
		del_session("adminid");
		phpgo ("login.php");	
		break;	
	case 'loginon':
		$adminname=safe_word(getform('adminname','post','nul'));
		$adminpass=getform('adminpass','post');
		$question=safe_word(getform('question','post'));
		$answer=safe_word(getform('answer','post'));
		get_cookie('adminname')==''	?	$code=getform('code','post','code') :	'';
		if (empty($adminpass)) {
			db_count('user',"username = '". $adminname ."' and question = '". $question ."' and answer='".$answer."'")>0 ?: back('登录失败,问题和答案错误!');
		}else{
            $lowpass=array('123456','1234567','12345678','admin','admin888','111111','000000','qq123456','abc123','password','qwerty');
            in_array($adminpass,$lowpass) ? set_cookie('adminpass','1') :  set_cookie('adminpass','0');
			db_count('user',"username = '". $adminname ."' and password='".md5_16($adminpass)."'")>0 ?: back('登录失败,用户名或密码错误!');
		}        
        conf('adminpath')=='admin/' ? set_cookie('adminpath','1') :  set_cookie('adminpath','0');
		login_in($adminname);
		phpgo(http_url_path());
		break;
	default:
	include parse_admin_tlp('login');
}

function login_in($username){
    $value=db_load_one('user a,user_group b',array('username'=>$username,'u_gid'=>array('='=>'gid')),'uid,username,u_onoff,face,gid,g_onoff,g_name,g_menu,g_mark,isadmin,logincount');
    if($value){
        $admintime=time();
        $adminrand=md5($admintime.$value['uid']);
		$value['isadmin']!=1 and	back($username."对不起，你不是管理员");
		$value['g_onoff']!=1 and 	back("对不起，您所在用户组已被禁用");
		$value['u_onoff']!=1 and 	back("对不起，您的账号已被禁用");        
		set_cookie("adminname",$value['username']);	
		set_cookie("admintime",$admintime);
		set_session("admingroup",$value['g_name']);	
		set_session("adminid",$value['uid']);
		set_session("admingid",$value['gid']);
		set_session("adminmenu",$value['g_menu']);	
		set_session("adminmark",$value['g_mark']);      
		set_session("adminrand",$adminrand);
		if (empty($value['face'])){
			set_cookie("adminface","../plugins/face/face01.png");
		}elseif(lenstr($value['face'])<11){
			set_cookie("adminface","../plugins/face/". $value['face']);
		}else{
			set_cookie("adminface", $value['face']);
		}
		set_session("gname",$value['g_name']);
		arr_add($val,'lastlogintime', date('Y/m/d H:i:s'));
		arr_add($val,'lastloginip',ip());
		arr_add($val,'adminrand',$adminrand);
		arr_add($val,'logincount',$value['logincount']+1);
		db_update('user',$value['uid'],$val);	
        return true;
    }else{
        back("对不起，登陆失败");
    }	
}