<?php
require '../inc/zzz_admin.php';
check_admin('login');
$act=getform('act','get');
$type=getform('type','get');
$folder=getform('folder','get');
$id=getform('id','get');
$aid=getform('aid','get');
$sid=getform('sid','get');
$cid=getform('cid','get');
$pid=getform('pid','get');
$uid=getform('uid','get');
$stype=getform('stype','get');
$module=!empty($act) ? $act : 'index';
$GLOBALS['type']=$type;
switch ($module) { 
	case 'content':        
		if($cid){
			$data=db_load_sql_one('select *,b.sid,b.s_type from [dbpre]content a,[dbpre]sort b where b.sid=a.c_sid and cid='.$cid);			
			$GLOBALS['stype']=$data['s_type'];
			$GLOBALS['sid']=$data['sid'];			
		}else if(!empty($sid)){			
			$GLOBALS['stype']=$stype ? $stype :  db_select('sort','s_type',array('sid'=>$sid));            
            $GLOBALS['sid']=$sid;            
		}else{
           empty($stype) and die('未选择模型');
           $GLOBALS['stype']=$stype;
           $s=db_load_one('sort',array('s_type'=>$stype,'s_onoff'=>1),'sid',array('s_level'=>'desc'));
           $GLOBALS['sid']=$s['sid'];            
        }
		break;
	case 'contentlist':	
    case 'adds':		
		if ($sid==0){			
			$data=array('s_type'=>$stype,'s_name'=>'','sid'=>'');
		}else{
			$data=db_load_one('sort',$sid);		
		}
		break;
	case 'sort':	
		$GLOBALS['ID']='';
		if($sid){	
			$GLOBALS['ID']=$sid;
	   		$data=db_load_one('sort',array('sid'=>$sid));
		} elseif($pid){		
			$data=db_load_one('sort',array('sid'=>$pid));			
		}		
	   break;
	case 'about':
		if($sid){	
	   		$data=db_load_one('about',array('a_sid'=>$sid));
		} elseif($aid){		
			$data=db_load_one('about',array('aid'=>$aid));
		} 	
	   break;  
	case 'custom':
    case 'gbookcustom':    
        $customid=getform('customid','get');
		if ($customid) $data=db_load_one('content_custom',array('customid'=>$customid));	
		break;	
	case 'siteedit':
		 $data = db_load_one('language','l_onoff=1');
		break;
	case 'admin':
		if ($uid) $data = db_load_one('user',array('uid'=>$uid));
		break;
	case 'usergroup':
	case 'admingroup':
        $gid=getform('gid','get');
		if ($gid) $data = db_load_one('user_group',array('gid'=>$gid));
		break;
    case 'htmllist':	
        delfiles(RUN_DIR.'cache/','tpl','all');
		break;
	case 'filelist':
		break;
    case 'loginout':
		login_out();
		break;
	case 'loginesc':
		login_esc();
		break;
	default:
		if ($id) $data=db_load_one($module,$id);			
}
    //echop(getform());echop($module);echop($sid);echop ($data);
	$GLOBALS['r']=isset($data) ? arr_key($data) : '';
	//echop (parse_admin_tlp($module));die;
	include parse_admin_tlp($module);