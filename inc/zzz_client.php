<?php
require 'zzz_class.php';
if ($conf['isinstall']==0) error('很抱歉!程序未安装, <span id=time></span>即将进入安装界面',SITE_PATH.'install/');
//echop('wapmark:'.$conf['wapmark']);echo('ISWAP:');echov(defined('ISWAP'));echop('');echo('is_mobile:');echov(is_mobile());echop('');echop('wapmark:'.$conf['wapmark']);echop('wapautogo:'.$conf['wapautogo']);die;
if($conf['wapmark']==1){//手机网站开关，已开启手机
	if(!defined('ISWAP')) {
	  if(is_mobile()){//手机访问
        if ($conf['wapautogo']>0 ) phpgowap(); //手机访问，开启手机跳转，跳转到手机站    
        define( 'WAPPATH', $conf[ 'wappath' ] );		
	  }elseif($conf['padautogo']=='2'){//非手机访问，开启跳转pc域名，跳转到PC网站
          $wapurl=str_replace(array('http','https','://'),'',db_select('language','sitewapurl',"l_alias='".LANGUAGE."'"));
          if(_SERVER('HTTP_HOST')==$wapurl ||  _SERVER('SERVER_NAME')==$wapurl ){                       
              phpgopc(); 
          }else{
             define( 'WAPPATH', "");
          }
	  }else{// 
          define( 'WAPPATH', "");
      }
	}else if(!defined('WAPPATH')){
		define( 'WAPPATH', $conf[ 'wappath' ]);
		if(!is_mobile()) phpgopc();		
	}
}elseif($conf['wapmark']=='2'){  //手机网站开关，已开启伪自适应
    define( 'WAPPATH', "");
    if(!defined('ISWAP')) {
        if(is_mobile()){            
          if($conf['wapautogo']==2 ) phpgowap();  
          define('ISWAP', 1); 
        }else{  
          if($conf['padautogo']==2 ) phpgopc(); 
        }
    }else{
        define( 'WAPPATH', $conf[ 'wappath' ] );
    }
}else{//手机网站关闭
    define( 'WAPPATH', "");
	if(defined('ISWAP'))  phpgopc();
}

if (!defined('TPL_DIR')){
	$data = db_load_one('language',"l_alias='".LANGUAGE."'",'pctemplate,waptemplate,pchtmlpath,waphtmlpath,sitekeys,sitedesc,siteurl,sitewapurl');	
	define('PCTPL',$data['pctemplate']);
	define('WAPTPL',$data['waptemplate']);		
	if (defined('ISWAP')){
		define('TPL_DIR',SITE_DIR . 'template/wap/'.WAPTPL.$data['waphtmlpath']);
		define('TPL_PATH', SITE_PATH . 'template/wap/'.WAPTPL);
		define('HTML_PATH', SITE_PATH . 'wap/');
		define('HTML_DIR', SITE_DIR . 'wap/');
	}else{
		define('TPL_DIR', SITE_DIR . 'template/pc/'.PCTPL.$data['pchtmlpath']);
		define('TPL_PATH', SITE_PATH . 'template/pc/'.PCTPL);
		define('HTML_PATH', SITE_PATH );
		define('HTML_DIR', SITE_DIR );
	} 
	$GLOBALS['sitekeys']=$data['sitekeys'];
	$GLOBALS['sitedesc']=$data['sitedesc'];	
	unset($data);
}

 require 'zzz_template.php';
 if (conf('webmode')==0) error(conf('closeinfo'));
 $location=getlocation();
 ParseGlobal(G('sid'),G('cid'));
 //echop($location);die;
 switch ($location) {
	case 'about':
	 	$tplfile= TPL_DIR . G('stpl');
		break; 
	case 'brand':		
		$stpl=splits(db_select('brand','b_template',"bid=".G('bid') or "b_name='".G('bname')."'"),',');
		if (defined('ISWAP')){
		  $tplfile=isset($stpl[1]) ? $stpl[1] : $stpl[0];
		}else{
		  $tplfile=$stpl[0];	
		}
	 	$tplfile=empty($tplfile) ? TPL_DIR .'brand.html' : TPL_DIR . $tplfile ;
		break;	
	case 'brandlist':
		$tplfile=isset($stpl) ? TPL_DIR .  $stpl: TPL_DIR . 'brandlist.html'; 
		$GLOBALS['tid']='-1';
		break;
	case 'content':		
	 	$tplfile= TPL_DIR . G('ctpl');
		break;	
	case 'list':
	 	$tplfile= TPL_DIR . G('stpl');
		break;
	case 'taglist':
		$tplfile=TPL_DIR . 'taglist.html'; 
		$GLOBALS['tid']='-1';
		break;
	case 'user':
	 	$tplfile= TPL_DIR . 'user.html'; 
		break;
	case 'search':
	 	$tplfile= TPL_DIR . 'search.html'; 
		break;
	case 'links':
	 	header ('location:'.G('pageurl'));
		break;
     case 'sitemap':
     case 'sitexml':
        $tplfile=  PLUG_DIR . 'template/' . $location . '.tpl';
        break;
	default:
	 	$tplfile=is_file(TPL_DIR . $location.'.html') ? TPL_DIR . $location.'.html'  : TPL_DIR .'index.html' ;
		break; 		
 }
 if ($location=='user'){	
	$user_tpl='';$logintype='';$backurl='';
	$act=safe_word(getform('act','get'));
	$GLOBALS['logintype']=$logintype=safe_word(getform('type','get'));
	$GLOBALS['backurl']=$backurl=getform('backurl','get');
	if (empty($act)){
		$path=geturl_path();
		if(SITE_PATH=='/'){
			$act=defined('ISWAP') ? $path[2] : $path[1];
		}else{
			$act=defined('ISWAP') ? $path[3] : $path[2];
		}
	}
	$uid=get_session('uid');
	$gid=get_session('gid');
	$GLOBALS['sid']='-1';
	$GLOBALS['tid']='-1';
	$GLOBALS['pid']='-1';
	if ($uid==""){
		$act=empty($act) ? 'login': $act;
		$incfile=TPL_DIR. 'user'.$act.'.html';		
		switch ($act) {				
		  case "reg":case "forget":case "login":
			  $tplfile=TPL_DIR. 'user'.$act.'.html';
			  $user_tpl = is_file($tplfile) ? load_file($tplfile) :  load_file(PLUG_DIR.'template/'.$act.'.tpl');											
		  break;
		default: 
		  phpgo(SITE_PATH.'?location=user&act=login&type='.$logintype.'&backurl='.$backurl)	;		
		}			
	}else{
		$act=isnul($act) ? 'userinfo': $act;		
		$incfile=TPL_DIR. $act.'.html';
		switch ($act) {		
		  case "reg":case "forget":case "login":		
			  phpgo(SITE_PATH.'?user/',$act);
			  break;
		  case "userinfo":
			  $user_tpl = load_file($incfile,'userinfo');				
			  break; 
		  case "loginout":	
			  phpgo(SITE_PATH.'form/?loginout');
			  break; 
		  default:              
			  $user_tpl = load_file($incfile,$act);
		  }
	}
	$GLOBALS['act']=$act;
	$zcontent = $user_tpl;
	if($logintype=='open'){
		$zcontent=str_replace('{zzz:top}','',$zcontent);
		$zcontent=str_replace('{zzz:foot}','',$zcontent);
	}
	$parser = new ParserTemplate();
	$zcontent = $parser->parserCommom($zcontent); // 解析模板
	$zcontent=str_replace('[login:type]',$logintype,$zcontent);
	$zcontent=str_replace('[login:backurl]',$backurl,$zcontent);
	echo $zcontent;	
 }elseif($conf['iscache']==1){
	 if(!defined('ISWAP')) {
		$cachefile = RUN_DIR . 'cache/html/pc/'.md5($location.G('sid').G('cid').G('page')). '.tpl' ; 
	 }else{
		$cachefile = RUN_DIR . 'cache/html/wap/'.md5($location.G('sid').G('cid').G('page')). '.tpl' ; 
	 }
 	if (!check_file($cachefile) || time_file($tplfile) > time_file($cachefile) ||strtotime('-'.$conf['cachetime'].' hour', time(date('Y-m-d H:i:s')))>time_file($cachefile) ){	  
		$zcontent = load_file($tplfile,$location);		
		$parser = new ParserTemplate();
		$zcontent = $parser->parserCommom($zcontent); // 解析模板
		create_file($cachefile, $zcontent);
		echo $zcontent;	
	}else{
		echo load_file($cachefile);	
	}
 }elseif($location=='sitemap' || $location=='sitexml'){
	$htmlpath = HTML_PATH. $conf['htmldir'].$location.'.html';
	$htmlfile = HTML_DIR . $conf['htmldir'].$location.'.html';
	$zcontent = load_file($tplfile,$location);
	$parser = new ParserTemplate();
	$zcontent = $parser->parserCommom($zcontent); // 解析模板
	create_file($htmlfile, $zcontent);
	phpgo($htmlpath);
 }elseif($conf['runmode']==0|| $conf['runmode']==2 || $location=='search' ||$location=='form' ||$location=='screen' || $location=='app'){
	$zcontent = load_file($tplfile,$location);
	$parser = new ParserTemplate();
	$zcontent = $parser->parserCommom($zcontent); // 解析模板
	echo $zcontent;
 }elseif($conf['runmode']==1){
	$location=='index' ? $url='index' : $url=$_SERVER['REQUEST_URI'];
    if (SITE_PATH!='/'){
        $url=str_replace(array($conf['siteext'],'?'),'',$url);
    }else{
        $url=str_replace(array($conf['siteext'],'?',SITE_PATH),'',$url); 
    }	
	$urlarr=splits($url,'/');
	if(count($urlarr)>3){
		$url='';		
		foreach( $urlarr as $key=>$value){
			$url.= $key<3 ?  '/'.$value : '&'. $value;
		}
	}
	$url=ltrim($url,'/');
	empty($url) and $url='index';
	$htmlpath = HTML_PATH. $conf['htmldir'].$url.'.html';
	$htmlfile = HTML_DIR . $conf['htmldir'].$url.'.html';
	$zcontent = load_file($tplfile,$location);
	$parser = new ParserTemplate();
	$zcontent = $parser->parserCommom($zcontent); // 解析模板		
	create_file($htmlfile, $zcontent);
	phpgo($htmlpath);
}else{
	error ('404，很抱歉您访问的页面不存在,请检查网址是否正确',SITE_PATH);
}