<?php
require '../inc/zzz_class.php';
$act = getModule();
switch ( $act ) {
    case 'reg'      : reg();        break;
    case 'login'    : login();      break;
    case 'forget'   : forget();     break;
    case 'dels'     : dels();       break;
    case 'editface' : editface();   break;
    case 'edituser' : edituser();   break;
    case 'editpwd'  : editpwd();    break;
    case 'loginout' : loginout();   break;
    case 'gbook'    : gbooking();   break;
    case 'gbooking' : gbooking();   break;
    case 'getjson'  : get_json();   break;
}

function gbooking() {
    $conf = _SERVER( 'conf' );
    $type = safe_word(getForm( 'type', 'post','','parent' ));
    $userid = safe_word(getform( "userid", "post", '', 0 ));
    $code = safe_word(getform( "code", "post", 'gbookcode' ));
    $backurl = getform( "backurl", "post");
    $ip = ip();
    $mailbody = '';
    $today = date( 'Y-m-d' );
    if ( $conf[ 'gbookuser' ] == 1 && isnul( get_session( 'uid' ) ) ) returnmsg($type,0, '很抱歉！要求会员才可以提交，请先登陆！', $backurl );
    $maxnum = isnul( get_session( 'uid' ) ) ? $conf[ 'gbookanonymousnum' ] : $conf[ 'gbookusernum' ];
    if ( $conf[ 'db' ][ 'type' ] == 'access' ) {
        $nownum = db_count( 'gbook', "g_time>date() and g_ip='" . $ip . "'" );
    } elseif ( $conf[ 'db' ][ 'type' ] == 'sqlite' ) {
        $nownum = db_count( 'gbook', "g_time>'" . $today . "' and g_ip='" . $ip . "'" );
    } elseif ( $conf[ 'db' ][ 'type' ] == 'mysql' ) {
        $nownum = db_count( 'gbook', "date(g_time)='" . $today . "' and g_ip='" . $ip . "'" );
    }
    $nownum >= $maxnum and returnmsg($type,0,'很抱歉,每天最多提交' . $maxnum . '次，请明日再来' , $backurl );
    $colarr = array( 'lid' => 1, 'g_uid' => $userid, 'g_order' => 9, 'g_onoff' => conf( 'gbookonoff' ), 'g_time' => date( 'Y-m-d H:i:s' ), 'g_ip' => $ip );
    if ( $conf[ 'gbookname_onoff' ] == 1 ) {
        $gname = safe_key( getform( "gname", "post", $conf[ 'gbookname_test' ] ,$conf[ 'gbookname' ]) );
        arr_add( $colarr, 'g_name', $gname );
        $mailbody .= $conf[ 'gbookname' ] . ':' . $gname . '<br>';
    }
    if ( $conf[ 'gbooktitle_onoff' ] == 1 ) {
        $gtitle = safe_key( getform( "gtitle", "post", $conf[ 'gbooktitle_test' ],$conf[ 'gbooktitle' ] ) );
        arr_add( $colarr, 'g_title', $gtitle );
        $mailbody .= $conf[ 'gbooktitle' ] . ':' . $gtitle . '<br>';
    }
    if ( $conf[ 'gbooktel_onoff' ] == 1 ) {
        $gtel = safe_key( getform( "gtel", "post", $conf[ 'gbooktel_test' ]) );
        arr_add( $colarr, 'g_tel', $gtel );
        $mailbody .= $conf[ 'gbooktel' ] . ':' . $gtel . '<br>';
    }
    if ( $conf[ 'gbookmail_onoff' ] == 1 ) {
        $gmail = safe_url( getform( "gmail", "post", $conf[ 'gbookmail_test'] ) );
        arr_add( $colarr, 'g_email', $gmail );
        $mailbody .= $conf[ 'gbookmail' ] . ':' . $gmail . '<br>';
    }
    if ( $conf[ 'gbookcontent_onoff' ] == 1 ) {
        $gcontent = safe_key( getform( "gcontent", "post", $conf[ 'gbookcontent_test' ],$conf[ 'gbookcontent' ] ) );
        arr_add( $colarr, 'g_content', $gcontent );
        $mailbody .= $conf[ 'gbookcontent' ] . ':' . $gcontent . '<br>';
    }
    $backurl = empty( $backurl ) ? SITE_PATH.WAPPATH : str_replace( 'ＰＨＰ', 'php', $backurl );
    $data = db_load( 'content_custom', "customType = 'gbook'", 'customname,custom' );
    foreach ( $data as $value ) {
        $val = safe_key( getform( $value[ 'custom' ], "post" ) );
        arr_add( $colarr, $value[ 'custom' ], $val );
        $mailbody .= $value[ 'customname' ] . ':' . $val . '<br>';
    }
    db_insert( 'gbook', $colarr );
    if ( $conf[ 'gbooksendmail' ] == 1 )alertmail( '新提交申请！', $mailbody );
    returnmsg($type,1,'提交成功！', $backurl );   
}

function reg() {
    $type = safe_word(getForm( 'type', 'post','','ok' ));
    $backurl = safe_url(getForm( 'backurl', 'post' ));
    $check = array( 'lenmin' => 5, 'lenmax' => 16 );
    $username = safe_key( getform( 'username', 'post', $check ) );  
    if ( check_used( "user","username", $username ))back( '账户已被使用，请更换' );
    $password = getform( 'password', 'post', 'pass' );
    $mobile = safe_key( getform( 'mobile', 'post')); 
    if(conf('ischeckmobile')==1 && !checkstr($mobile,'mobile')) back( '手机格式不正确，请更换' );
    if ( check_used( "user","mobile", $mobile ))back( '手机号已被使用，请更换' );
    $email = safe_url(getform( 'email', 'post' ));
    if(conf('ischeckemail')==1 && !checkstr($email,'email')) back( '邮箱格式不正确，请更换' );
    $code = safe_word(getform( 'code', 'post', 'usercode' ));
    $regtime = date( 'Y-m-d H:i:s' );
    if ( conf( 'smsmark' ) == 1 && conf( 'regsendsms' ) == 1 ) {
        $smscode = getform( 'smscode', 'post' );
        if ( $mobile != get_session( "smsphone" ) || $smscode != get_session( "smscode" ) )back( '手机验证码不正确，请重试' );
    }
    $colarr = array( 'username' => $username, 'password' => md5_16( $password ), 'mobile' => $mobile, 'email' => $email, 'regtime' => $regtime, 'u_onoff' => conf( 'useronoff' ), 'u_gid' => 4, 'u_order' => 9, 'balance' => 0, 'points' => 0, 'logincount' => 0 );
    $backurl = empty( $backurl ) ? SITE_PATH.WAPPATH . '?user/': str_replace( 'ＰＨＰ', 'php', $backurl );
    if ( db_insert( 'user', $colarr ) ) {
        if ( conf( 'regsendmail' ) == 1 ) {
            $mailbody = '会员：' . $username . '手机' . $mobile;
            alertmail( '会员注册提醒！', $mailbody );
        }
        if ( conf( 'useronoff' ) == 1 ) {
            loginin( $username );
            returnmsg($type,1,'注册成功,欢迎您' . $username . '！', $backurl );
        } else {
            returnmsg($type,1,'注册成功，需要审核后方可登陆', $backurl );
        }
    }
}

function edituser() {
    $type = safe_word( getForm( 'type', 'post') );
    $uid = safe_word(getform( 'uid', 'post' ));
    $uid != get_session( 'uid' )and back( '很抱歉，资料修改失败' );
    $truename = safe_key(getform( 'truename', 'post','*'));
    $telcode = safe_word(getform( 'telcode', 'post' ));
    $tel = safe_word(getform( 'tel', 'post' ));
    $tel = empty($telcode) ?  $tel : $telcode . '-' . $tel;
    $mobile = safe_word(getform( 'mobile', 'post','m' ));
	if (db_count('user',array("mobile"=>$mobile,"uid"=>array("<>"=>$uid)))>0 )	back('手机号已经存在请更换手机号');
    $face = safe_url(getform( 'face', 'post' ));
    $email = safe_url(getform( 'email', 'post' ));
    $qq = safe_word(getform( 'qq', 'post' ));
    $province = safe_key(getform( 'province', 'post' ));
    $city = safe_key(getform( 'city', 'post' ));
    $district = safe_key(getform( 'district', 'post' ));
    $address = safe_key(getform( 'address', 'post' ));
    $post = safe_word(getform( 'post', 'post' ));
    $desc = safe_key(getform( 'desc', 'post' ));
    $backurl= safe_url(getForm( 'backurl', 'post','',SITE_PATH.WAPPATH . '?user/'  ));
    $colarr = array( 'truename' => $truename, 'tel' => $tel, 'email' => $email, 'face' => $face, 'qq' => $qq, 'province' => $province, 'city' => $city, 'district' => $district, 'address' => $address, 'post' => $post, 'u_desc' => $desc );
    if ( !empty( $mobile ) ) {
        arr_add( $colarr, 'mobile', $mobile );      
    }   
    $code=db_update( 'user', array( 'uid' => $uid ), $colarr );
    returnmsg($type,$code,'',$backurl);
}

function login() {
    $type = safe_key(getForm( 'type', 'post'));
    $backurl = getForm( 'backurl', 'post' );
    $check = array( 'lenmin' => 5, 'lenmax' => 16 );
    $username = safe_key( getForm( 'username', 'post', $check ) );
    $password = getForm( 'password', 'post', $check );
	$usercheck = isnum(getForm( 'usercheck', 'post' ));
	set_cookie('usercheck',$usercheck,365);
	if( $usercheck==1){		
		set_cookie('username',$username,365);
		set_cookie('userpass',$password,365);		
	}else{
		del_cookie('username');
		del_cookie('userpass');
	}
    $code = safe_word(getForm( 'code', 'post', 'usercode' ));
    $count = db_count( 'user', "u_onoff=1 and (username='" . $username . "' or mobile='" . $username . "') and password='" . md5_16( $password ) . "'" );
    $backurl = empty( $backurl ) ? SITE_PATH . WAPPATH.'?user/': str_replace( 'ＰＨＰ', 'php', $backurl );
    if ( $count > 0 ) {
        loginin( $username );
        if ( conf( 'loginsendmail' ) == 1 ) {
            $mailbody = '会员：' . $username;
            alertmail( '会员登陆提醒！', $mailbody );
        }
       returnmsg($type,1,'登陆成功,欢迎您' . $username . '！', $backurl );      
    } else {
       returnmsg($type,0,'登录失败，请检查用户名、密码是否正确？是否还再审核中？', $backurl );      
    }
}

function loginin( $username ) {
    $data = db_load_sql( "select uid,username,truename,tel,mobile,email,qq,face,gid,g_name,g_mark from [dbpre]user as a,[dbpre]user_group as b where a.u_gid=b.gid and (username ='" . $username . "' or mobile ='" . $username . "')" );
    foreach ( $data as $value ) {
        $GLOBALS[ 'username' ] = set_session( "username", $value[ 'username' ] );
        $GLOBALS[ 'gmark' ] = set_session( "gmark", $value[ 'g_mark' ] );
        $GLOBALS[ 'uid' ] = set_session( "uid", $value[ 'uid' ] );
        $GLOBALS[ 'gid' ] = set_session( "gid", $value[ 'gid' ] );
        $GLOBALS[ 'truename' ] = set_session( "truename", $value[ 'truename' ] );
        $GLOBALS[ 'useremail' ] = set_session( "useremail", $value[ 'email' ] );
        $GLOBALS[ 'usermobile' ] = set_session( "usermobile", $value[ 'mobile' ] );
        $GLOBALS[ 'usertel' ] = set_session( "usertel", $value[ 'tel' ] );
        $GLOBALS[ 'userqq' ] = set_session( "userqq", $value[ 'qq' ] );
        $face = empty( $value[ 'face' ] ) ? $value[ 'face' ] : "noface.png";
        $GLOBALS[ 'userface' ] = set_session( "userface", $face );
        $GLOBALS[ 'gname' ] = set_session( "gname", $value[ 'g_name' ] );
        arr_add( $val, 'lastlogintime', date( 'Y-m-d H:i:s' ) );
        arr_add( $val, 'lastloginip', ip() );
        arr_add( $val, 'logincount+', 1 );
        db_update( 'user', 'uid=' . $value[ 'uid' ], $val );
    }
}

function forget() {
    $type = safe_word( getForm( 'type', 'post','','ok' ) );
    $backurl = getForm( 'backurl', 'post' );
    $mobile = safe_key( getForm( 'mobile', 'post' ) );
    $question = safe_key( getForm( 'question', 'post' ) );
    $answer = safe_key( getForm( 'answer', 'post' ) );	
	if ( conf( 'smsmark' ) == 1 && conf( 'forgetsendsms' ) == 1 ) {
		$smscode = getform( 'smscode', 'post' );
        if ( $mobile != get_session( "smsphone" ) || $smscode != get_session( "smscode" ) )back( '手机验证码不正确，请重试' );
		$count = db_count( 'user', "u_onoff=1 and (username='" . $mobile . "' or mobile='" . $mobile . "')");
	}else{
    	$count = db_count( 'user', "u_onoff=1 and (username='" . $mobile . "' or mobile='" . $mobile . "') and question='" . $question . "'  and answer='" . $answer . "'" );
	}	
    $backurl = empty( $backurl ) ? SITE_PATH .WAPPATH. '?user/': str_replace( 'ＰＨＰ', 'php', $backurl );
    if ( $count > 0 ) {
        loginin( $mobile );
        if ( conf( 'forgetsendmail' ) == 1 ) {
            $mailbody = '会员：' . $mobile;
            alertmail( '会员找回密码提醒！', $mailbody );
        }
      returnmsg($type,1,'验证成功，请进入会员中心修改密码',SITE_PATH .WAPPATH. '?user/');      
    } else {  
      returnmsg($type,0,'验证失败,请确认问题答案是否正确', SITE_PATH .WAPPATH. '?user/forget');      
    }
}

function editpwd() {
    $type = safe_word( getForm( 'type', 'post','','ok' ) );
    $uid = safe_word(getform( 'uid', 'post' ));
    $uid != get_session( 'uid' )and back( '很抱歉，密码修改失败' );
    $check = array( 'lenmin' => 4, 'lenmax' => 16 );
    $password = getform( 'password', 'post', '*','原密码' );
    $newpassword = getform( 'newpassword', 'post', 'pass' ,'新密码');
    $question = safe_key(getform( 'question', 'post', $check,'问题' ));
    $answer = safe_key(getform( 'answer', 'post', $check,'答案' ));
    $backurl= safe_url(getForm( 'backurl', 'post','',SITE_PATH .WAPPATH. '?user/'  ));
    $colarr = array( 'password' => md5_16( $newpassword ), 'question' => $question, 'answer' => $answer );
    if ( db_count( 'user', array( 'uid' => $uid, 'password' => md5_16( $password ) ) ) > 0 ) {
        db_update( 'user', array( 'uid' => $uid ), $colarr );
        returnmsg($type,1,'修改成功,密码修改完成！', $backurl );      
    } else {
        returnmsg($type,0,'很抱歉，密码修改失败，原密码不正确', $backurl );      
    }
}

function loginout() {
	$type = safe_word( getForm( 'type', 'get') );
    del_session( "username" );
    del_session( "uid" );
    del_session( "gid" );
    del_session( "gmark" );
    del_session( "truename" );
    del_session( "useremail" );
    del_session( "usermobile" );
    del_session( "usertel" );
    del_session( "userqq" );
    del_session( "userface" );
    del_session( "gname" );
    $backurl= SITE_PATH.WAPPATH . "?user/login" ;
	returnmsg($type,1,'', $backurl );  
}

function editface() {
    $type = safe_word( getForm( 'type', 'post') );
    $backurl= safe_url(getForm( 'backurl', 'post','',SITE_PATH.WAPPATH . '?user/'  ));
    $uid =  get_session( 'uid' );
    $face = safe_url(getform( 'face', 'post' ));
    $code=db_update( 'user', array( 'uid' => $uid ), array( 'face' => $face ) );
    returnmsg($type,$code,'', $backurl );      
}


//支持任意查询输出json，只支持post提交
function get_json() {
    $table = safe_key(getform( 'table', 'post' ));
    $arr = array( 'user', 'user_group', 'log_err', 'log_dbsql', 'log_dbbackup', 'content_custom' );
    in_array( $table, $arr )and exit;
    $col = safe_key(getform( 'col', 'post' ));
    $where = str_replace('等于','=',safe_key(str_replace('=','等于',getform( 'where', 'post' ))));
    if ( empty( $col ) || empty( $where ) )exit;
    $num = safe_word(getform( 'num', 'post' ,'',100));
    $page = safe_word(getform( 'page', 'post' ,'',1));
    $order = safe_key(getform( 'order', 'post','','0'));
    //echop($table);echop($where);echop($col);
    $data = db_load( $table, $where, $col, $num, $order, $page );
    echo tojson( $data );
}