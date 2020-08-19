<?php
require '../inc/zzz_admin.php';
check_admin('die');
$act=safe_word(getform('act','get'));
$type=safe_word(getform('type','both'),10);
switch ($act) {
	case 'about':		return save_about(); 		break;			
	case 'ad':     		return save_ad();      		break;			
	case 'admingroup':	return save_admingroup(); 	break;			
	case 'backup':		return backup();       		break;			
	case 'brand':		return save_brand(); 		break;			
	case 'content':		return save_content(); 		break;			
	case 'copyid':		return copy_id();      		break;	
	case 'custom':		return save_custom();		break;	
	case 'model':		return save_model();		break;
	case 'delallfile':	return delallfile($type);	break;			
	case 'delfile':		return delfile();	    	break;
	case 'delcustom':	return del_custom();		break;	
	case 'delsort':		return del_sort();	       	break;
	case 'editfile':	return editfile();        	break;			
	case 'gbook':		return save_gbook(); 		break;	
	case 'links':		return save_links(); 		break;		
	case 'labels':		return save_labels(); 		break;			
	case 'moveid':		return move_id('move');     break;	
	case 'recovery':	return move_id('recovery'); break;			
	case 'remove':		return move_id('remove');	break;	
	case 'delid':		return move_id('delid');	break;	
	case 'delall':		return move_id('recy');     break;			
	case 'restore':		return restore();     		break;			
	case 'savehtml':	return savehtml();    		break;	
	case 'createhtml':	return create_html();		break;			
	case 'saveid':		return updata_id();    		break;			
	case 'savesystem':	return save_system();		break;			
	case 'saveupload':	return save_upload();		break;			
	case 'setcol':		return set_col();          	break;
	case 'plugurl':		return plug_url();     		break;	
	case 'plugkey':		return plug_key();     		break;		
	case 'settemplate':	return settemplate();		break;	
	case 'setqqkf':		return setqqkf();	    	break;				
	case 'sort':		return save_sort(); 		break;
	case 'sortadds':	return save_sortadds(); 	break;	
	case 'sortrepair':	return repair_sort(); 		break;		
	case 'smallpic':	return small_pic($type); 	break;	
	case 'slide':		return save_slide(); 		break;				
	case 'tag':    		return save_tag(); 		    break;	
	case 'tryemail':	return try_email(); 		break;		
	case 'upload':		return up_load();		    break;	
	case 'updata':		return up_data();		    break;	
	case 'upadmin':		return up_admin($type);		    break;	  
	case 'user':		return save_user(); 		break;	
	case 'usergroup':	return save_usergroup(); 	break;			
	case 'tianqi':		save_config(array('tianqimark'=>$type));                                   echop('修改成功'); 		break;	
	case 'cookie':		$type=='pass' ? set_cookie('adminpass','0') : set_cookie('adminpath','0') ;echop('修改成功'); 		break;	 
	default: phpgo("index.php");
}
function plug_url(){
	$plugurl=safe_url(getform('plugurl','post'));
	$plugurl=str_replace(array('http://','https://','www.','/','&#039;','&quot;'),'',$plugurl);
	if ($plugurl){
		$config=array('plugurl'=>$plugurl);
		save_config($config);
		echo 1;
	}else{
		echo 0;
	}
}

function plug_key(){
	$plugpath=safe_word(getform('plugpath','post'));
	$plugkey=safe_word(getform('plugkey','post'));	
	if (lenstr($plugkey)!=32) die(0);
	$xmlpath=SITE_DIR.'plug/'.$plugpath.'/plug.xml';
	if(is_file($xmlpath)){	
		$xml=simplexml_load_file($xmlpath);
		$xmlstr=load_file($xmlpath);
		$keys= $xml->plugkey;
		if($keys==''){
			$xmlstr=str_replace('<plugkey></plugkey>','<plugkey>'.$plugkey.'</plugkey>',$xmlstr);
			create_file($xmlpath,$xmlstr);
		}elseif( $keys!=$plugkey){
			$xmlstr=str_replace($keys,$plugkey,$xmlstr);
			create_file($xmlpath,$xmlstr);
		}
		echo 1;
	}else{
		echo 0;
	}
}

function set_col(){
    $table=safe_word(getForm("table","post"));
    $id=isnum(getForm("id","post"));
	$col=safe_word(getForm("col","post"));
	$colval=isnum(getForm("colval","post"));	
    if($table=='sort') {
        delfiles(RUN_DIR . 'cache/navlist/','tpl','all');
    }
    if(db_update($table,array(table_id($table)=>$id),array($col=>$colval))){
		if  ($col=="model_onoff") {
			delfiles(RUN_DIR . 'cache/model/','tpl','all');
			$mname=db_select('model','model_type',array('model_id'=>$id));
			db_update('menu',array('m_key'=>$mname),array('m_onoff'=>$colval));
		}
        return 1;
    }    
	return 0;
}

function move_id( $type ) {
    $id = safe_key(getform('id','post'));
    $cid=  is_array($id) ?  $id : splits( $id, ',' ) ;
    $sid = safe_key( getform( "col", "post" ) );
    $table = safe_word(getform("table", "post"),10);
    switch ( $type ) {
        case 'move':
            return db_update( 'content', array( 'cid' => $cid ), 'c_sid=' . $sid );
            break;
        case 'recovery':
            return db_remove( $table, $cid, 1 );
            break;
        case 'remove':
            return db_remove( $table, $cid, 2 );
            break;
        case 'delid':
            return db_delete($table,$cid);
            break;
        case 'recy':
            return db_delete($table,'recy');
            break;         
    }
}

function copy_id(){
	$copyid=safe_key(getform("id","post"));
	$sid=safe_word(getform("sid","post","num",'json'));
	$custom='';	$cid=db_cond_to_sqladd(array('cid'=>splits($copyid,',')));			
	$data=db_load('content_custom',"customtype <> 'about' and customtype <>'brand' and customtype <>'gbook'",'custom');	
	foreach ($data as $value){$custom.=','.$value['custom'];}	
	$sql="insert into [dbpre]content (c_title,c_lid,c_brand,c_type,c_gid,c_title2,c_color,c_link,c_tag,c_content,c_onoff,c_order,isoutlink,istop,isgood,ispic,isoffer,issell,ishtml,c_visits,c_star,c_addtime,c_edittime,c_picsurl,c_picsname,c_pic,c_downurl,c_downname,c_pagename,c_pagetitle,c_pagekey,c_pagedesc".$custom.",c_sid) select c_title,c_lid,c_brand,c_type,c_gid,c_title2,c_color,c_link,c_tag,c_content,c_onoff,c_order,isoutlink,istop,isgood,ispic,isoffer,issell,ishtml,c_visits,c_star,c_addtime,c_edittime,c_picsurl,c_picsname,c_pic,c_downurl,c_downname,c_pagename,c_pagetitle,c_pagekey,c_pagedesc".$custom.",".$sid." from [dbpre]content ".$cid;	
	db_exec ($sql);	
}

function save_about(){
	check_token();
	$aid=getform("aid", "post",'num');
	$a_sid=getform("a_sid", "post",'num');
	$a_name=getform("a_name", "post",'nul','json');
	$istitle=getform("istitle", "post");
	$a_enname=getform("a_enname", "post");
	$a_visits=getform("a_visits", "post",'','1');
	$a_addtime=getform("a_addtime", "post");
	$a_edittime=date('Y-m-d H:i:s');
	$a_key=getform("a_key", "post");
	$a_content=getform("a_content", "post");
	$a_desc=getform("a_desc", "post");
	$a_desc= empty($a_desc) ? leftstr(html_info($a_content),255) : html_info($a_desc);	
	$a_pic=getform("a_pic", "post");		check_pic($a_pic,'about',$aid);
	$a_picsurl=getform("picsurl",'post');			$a_picsurl=count($a_picsurl)==0 ? $a_pic : @implode(",",$a_picsurl);
	$a_picsname=getform("picsname",'post');		$a_picsname=count($a_picsname)==0 ? $a_name : @implode(",",$a_picsname);
	$colarr=array('a_name'=>$a_name,'a_enname'=>$a_enname,'a_visits'=>$a_visits,'a_addtime'=>$a_addtime,'a_edittime'=>$a_edittime,'a_key'=>$a_key,'a_content'=>$a_content,'a_desc'=>$a_desc,'a_pic'=>$a_pic,'a_picsurl'=>$a_picsurl,'a_picsname'=>$a_picsname,'a_lid'=>1,'a_order'=>1,'a_onoff'=>1);
	$data=db_load('content_custom',array("customType"=>'about','customonoff'=>1),'custom,customclass');		
	foreach ($data as $value){
		if ($value['customclass']==1){
			arr_add($colarr,$value['custom'],getform($value['custom'], "post",'num'));
		}elseif ($value['customclass']==5){
			$val=getform($value['custom'],"post");
			$val=count($val)==0 ? $val : @implode(",",$val);
			arr_add($colarr,$value['custom'],$val);
		}else{
			arr_add($colarr,$value['custom'],getform($value['custom'],'post'));
		}
	}
	if ($istitle==1) db_update('sort','sid='.$a_sid,array('s_name'=>$a_name));
	if (db_update('about','aid='.$aid,$colarr)) returnmsg('json',1,'修改成功');		
	returnmsg('json',0,'修改失败');	
}

function save_ad(){
    check_token();
	$adid=getform("adid", "post");
	$adname=getform("adname", "post",'nul','json');
	$adclass=getform("adclass", "post",'nul','json');
	$adlink=getform("adlink", "post");
	$addTime=date('Y-m-d H:i:s');
	$adstime=getform("adstime", "post",'date','json');
	$adetime=getform("adetime", "post",'date','json');
	$adwidth=getform("adwidth", "post");
	$adheight=getform("adheight", "post");
	$adimg=getform("adimg", "post");
	$adcontent=getform("adcontent", "post");
	$colarr=array('adname'=>$adname,'adclass'=>$adclass,'adlink'=>$adlink,'addTime'=>$addTime,'adstime'=>$adstime,'adetime'=>$adetime,'adwidth'=>$adwidth,'adheight'=>$adheight,'adimg'=>$adimg,'adcontent'=>$adcontent,'LID'=>1,'AdOnOff'=>1);
	if ($adid==0){
		if(db_insert('ad',$colarr)) returnmsg('json',1,'保存成功','?act=ad');
	}else{
		if(db_update('ad','adid='.$adid,$colarr))  returnmsg('json',1,'保存成功') ;
	}
	returnmsg ('json',0,'保存失败');	
}

function save_admingroup(){
	check_token();
	$gid=safe_key(getform("gid", "post"));
	$g_name=safe_key(getform("g_name", "post",'nul','json'));
	$g_mark=safe_key(getform("g_mark", "post"));
	$g_desc=safe_key(getform("g_desc", "post"));
	$g_menu=safe_key(getform("g_menu", "post"));		
    empty($g_menu) and $g_menu='all';
	$g_sort=safe_key(getform("g_sort", "post"));		
    empty($g_sort) and $g_sort='all';
	$colarr=array('g_name'=>$g_name,'g_mark'=>$g_mark,'g_desc'=>$g_desc,'g_menu'=>$g_menu,'g_sort'=>$g_sort);
	if ($gid==0){
		arr_add($colarr,'g_onoff',1);
		arr_add($colarr,'isadmin',1);
		arr_add($colarr,'g_order',9);
		db_insert('user_group',$colarr);
		returnmsg('json',1,'添加成功','?act=admingroup');	
	}else{
		if($gid==get_session('admingid')) {
			set_session('adminmenu',$g_menu);
			set_session('adminsort',$g_sort);
		}
		db_update('user_group','gid='.$gid,$colarr);
		returnmsg('json',1,'保存成功');	
	}	
}

function save_usergroup(){
	check_token();
	$gid=isnum(getform("gid", "post"));
	$g_name=safe_key(getform("g_name", "post",'nul','json'));
	$g_mark=safe_key(getform("g_mark", "post"));
	$g_desc=safe_key(getform("g_desc", "post"));

	$colarr=array('g_name'=>$g_name,'g_mark'=>$g_mark,'g_desc'=>$g_desc,'g_menu'=>'','g_sort'=>'');
	if ($gid==0){
		arr_add($colarr,'g_onoff',1);
		arr_add($colarr,'isadmin',0);
		arr_add($colarr,'g_order',9);
		db_insert('user_group',$colarr);
		returnmsg('json',1,'添加成功','?act=usergroup');	
	}else{		
		db_update('user_group','gid='.$gid,$colarr);
		returnmsg('json',1,'保存成功');	
	}
}
	
function save_brand(){
	check_token();
	$bid=getform("bid", "post");
	$b_name=getform("b_name", "post",'nul','json');
	$b_enname=getform("b_enname", "post");
	$b_type=getform("b_type", "post");
	$b_filename=getform("b_filename", "post");
	$b_visits=getform("b_visits", "post",'',1);
	$b_addtime=getform("b_addtime", "post");
	$b_edittime=date('Y-m-d H:i:s');
	$b_key=getform("b_key", "post");
	$b_url=getform("b_url", "post");
	$b_content=getform("b_content", "post");
	$b_content=str_replace('{list:page}','',$b_content);
	$b_desc=getform("b_desc", "post");
	$b_desc= empty($b_desc) ? leftstr(html_info($b_content),255) : html_info($b_desc);	
	$b_pic=getform("b_pic", "post");		check_pic($b_pic,'brand',$bid);
	$b_template=getform("b_template", "post");		$b_template=count($b_template)==0 ? $b_template : @implode(",",$b_template);
	$b_picsurl=getform("picsurl", "post");			$b_picsurl=count($b_picsurl)==0 ? $b_pic : @implode(",",$b_picsurl);
	$b_picsname=getform("picsname", "post");		$b_picsname=count($b_picsname)==0 ? $b_name : @implode(",",$b_picsname);
	$colarr=array('b_name'=>$b_name,'b_enname'=>$b_enname,'b_type'=>$b_type,'b_filename'=>$b_filename,'b_visits'=>$b_visits,'b_addtime'=>$b_addtime,'b_edittime'=>$b_edittime,'b_key'=>$b_key,'b_content'=>$b_content,'b_desc'=>$b_desc,'b_pic'=>$b_pic,'b_picsurl'=>$b_picsurl,'b_picsname'=>$b_picsname,'b_template'=>$b_template,'b_url'=>$b_url,'b_lid'=>1,);
	$data=db_load('content_custom',array("customType"=>'brand','customonoff'=>1),'custom,customclass');	
	foreach ($data as $value){
		if ($value['customclass']==1){
			arr_add($colarr,$value['custom'],getform($value['custom'], "post",'num'));
		}elseif ($value['customclass']==5){
			$val=getform($value['custom'], "post");
			$val=count($val)==0 ? $val : @implode(",",$val);
			arr_add($colarr,$value['custom'],($val));
		}else{
			arr_add($colarr,$value['custom'],getform($value['custom'], "post"));
		}
	}		
	if ($bid==0){
		arr_add($colarr,'b_order',1);
		arr_add($colarr,'b_onoff',1);
		if(db_insert('brand',$colarr)) returnmsg ('json',1,'添加成功，继续添加？','?act=brand');
	}else{
		if(db_update('brand','bid='.$bid,$colarr)) returnmsg('json',1,'修改成功');
	}
	returnmsg('json',0,'添加失败');	
}

function save_content(){
	check_token();
	$c_picsurl=array();$c_picsname=array();
	$cid=getform("cid", "post",'',0);
	$c_sid=getform("c_sid", "post","num",'json');
	$c_gid=getform("c_gid", "post","",0);
	$c_color=getform("c_color", "post");
	$c_type =getform("c_type", "post");	
	$c_title=getform("c_title", "post","nul",'json');
	$c_title2=getform("c_title2", "post");
    $c_title2=empty($c_title2) ?  leftstr(html_info($c_title),12)  : $c_title2;
	$c_content=getform("c_content", "post");	
	$c_pagetitle=getform("c_pagetitle", "post");
	$c_pagekey=getform("c_pagekey", "post");
	$c_pagedesc=getform("c_pagedesc", "post");	
	$c_pagedesc= empty($c_pagedesc) ? leftstr(html_info($c_content),255) : html_info($c_pagedesc);
	$c_link=getform("c_link", "post");		
	$c_brand=getform("c_brand", "post");
	$istop=getform("istop", "post",'',0);
	$isgood=getform("isgood", "post",'',0);
	$isoffer=getform("isoffer", "post",'',0);	
	$issell=getform("issell", "post",'',0);	
	$ishtml=getform("ishtml", "post",'',0);			
	$c_star=getform("c_star", "post",'',0);		
	$c_visits=getform("c_visits", "post",'',1);	
	$c_addtime=getform("c_addtime", "post");
	$c_tag =getform("c_tag", "post");	$c_tag=(str_replace('，',',',$c_tag));  check_tag($c_tag);
	$c_pic=getform("pic", "post");		check_pic($c_pic,$c_type,$cid) ? $ispic=1 : $ispic=0;
	$c_picsurl=getform("picsurl", "post");			$c_picsurl=count($c_picsurl)==0 ? $c_pic : @implode(",",$c_picsurl);
	$c_picsname=getform("picsname", "post");			$c_picsname=count($c_picsname)==0 ? $c_title : @implode(",",$c_picsname);
	$c_downurl=getform("c_downurl", "post");			$c_downurl=count($c_downurl)==0 ? '' : @implode(",",$c_downurl);
	$c_downname=getform("c_downname", "post");		$c_downname=count($c_downname)==0 ? '' : @implode(",",$c_downname);
	$c_pagename=getform("c_pagename", "post");		
	$colarr=array('c_title'=>$c_title,'c_title2'=>$c_title2,'c_lid'=>1,'c_sid'=>$c_sid,'istop'=>$istop,'isgood'=>$isgood,'ispic'=>$ispic,'isoffer'=>$isoffer,'issell'=>$issell,'c_gid'=>$c_gid,'ishtml'=>$ishtml,'c_visits'=>$c_visits,'c_star'=>$c_star,'c_brand'=>$c_brand,'c_type'=>$c_type,'c_color'=>$c_color,'c_link'=>$c_link,'c_tag'=>$c_tag,'c_content'=>$c_content,'c_addtime'=>$c_addtime,'c_picsurl'=>$c_picsurl,'c_picsname'=>$c_picsname,'c_pic'=>$c_pic,'c_downurl'=>$c_downurl,'c_downname'=>$c_downname,'c_pagename'=>$c_pagename,'c_pagetitle'=>$c_pagetitle,'c_pagekey'=>$c_pagekey,'c_pagedesc'=>$c_pagedesc);
	$data=db_load('content_custom',array('customType'=>array('LIKE'=>$c_type),'customonoff'=>1),'custom,customclass');	
	foreach ($data as $value){
		if ($value['customclass']==1){
			arr_add($colarr,$value['custom'],getform($value['custom'], "post",'num'));
		}elseif ($value['customclass']==5){
			$val=getform($value['custom'],"post");	
			$val=count($val)==0 ? $val : @implode(",",$val);
			arr_add($colarr,$value['custom'],$val);
		}else{
			arr_add($colarr,$value['custom'],getform($value['custom'], "post"));
		}
	}
	if ($cid==0){
		if(check_used('content','c_pagename',$c_pagename)) returnmsg ('json',0,'【短链接】存在重名，请修改');
		arr_add($colarr,'c_onoff',1);
		arr_add($colarr,'c_order',9);
		if(db_insert('content',$colarr)) returnmsg ('json',1,'添加成功，继续添加？','?act=content&stype='.$c_type.'&sid='.$c_sid);
	}else{
		if(check_used('content','c_pagename',$c_pagename,$cid)) returnmsg ('json',0,'【短链接】存在重名，请修改');
		arr_add($colarr,'c_edittime',date('Y-m-d H:i:s'));
		if(db_update('content',array('cid'=>$cid),$colarr)) returnmsg ('json',1,'保存成功');
	}
	returnmsg ('json',0,'保存失败');
}

function check_tag($tag){
	if(isnul($tag)) return '';
	$tags=splits($tag,",");
	foreach ($tags as $value){
	  if (db_count('tag',array('t_name'=>$value))==0)save_tag($value,'no');
	}
	return true;
}

function save_tag($tag='',$msg=''){
	check_token();
	$tid=getform("tid", "post");
	if (empty($tag)){	
		$t_name=getform("t_name", "post");
		if (db_count('tag',array('t_name'=>$t_name))>0) returnmsg('json',0,'很抱歉,TAG标题已存在，请更换！');
		$t_enname=getform("t_enname", "post",'name',0);
		$t_visits=getform("t_visits", "post",'',1);
		$t_addtime=getform("t_addtime", "post");
		$t_edittime=date('Y-m-d h:i:s',time());
	}else{
		$t_name=$tag;
		$t_enname=pinyin($tag);	
		$t_visits=0;
		$t_addtime=date('Y-m-d h:i:s',time());
		$t_edittime=date('Y-m-d h:i:s',time());
	} 
	if ($tid==0){
		$colarr=array('t_name'=>$t_name,'t_enname'=>$t_enname,'t_visits'=>$t_visits,'t_addtime'=>$t_addtime,'t_order'=>1,'t_lid'=>1,'t_onoff'=>1);
		if(db_insert('tag',$colarr)) {
		   if($msg=='no'){
			   return true;
		   }else{
			  returnmsg ('json',1,'添加成功，是否继续添加？','?act=tag'); 
		   }
		}
	}else{
		$colarr=array('t_name'=>$t_name,'t_enname'=>$t_enname,'t_visits'=>$t_visits,'t_edittime'=>$t_edittime);
		if(db_update('tag','tid='.$tid,$colarr)) returnmsg('json',1,'保存成功');	
	}
	if( $msg=='no'){
		return false;
	}else{
		returnmsg ('json',0,'保存失败');	
	}
}

function save_model(){
	check_token();
	$model_id=getform("model_id", "post");	
	$model_name=safe_key(getform("model_name", "post"));
	$model_type=strtolower(safe_word(getform("model_type", "post")));
	$model_list_tp=getform("model_list_tp", "post");
	$model_content_tp=getform("model_content_tp", "post");
	$colarr=array('model_name'=>$model_name,'model_type'=>$model_type,'model_list_tp'=>$model_list_tp,'model_content_tp'=>$model_content_tp,'model_table'=>'content','model_order'=>9,'model_onoff'=>1);	
	if ($model_id==0){
		if(db_insert('model',$colarr)) {
			delfiles(RUN_DIR . 'cache/model/','tpl','all');
			db_insert('menu',array('pid'=>1,'tid'=>1,'m_link'=>'zzz_content/content/content_list?stype='.$model_type,'m_name'=>$model_name,'m_order'=>8,'m_level'=>2,'m_onoff'=>1,'m_key'=>$model_type));
			returnmsg ('json',1,'添加成功，是否继续添加？','?act=model'); 
		}
	}else{
		if(db_update('model','$model_id='.$model_id,$colarr)) returnmsg('json',1,'修改成功');
	}
	returnmsg('json',0,'保存失败');
}

function save_custom(){
	check_token();
	$customid=safe_word(getform("customid","post"));
	$customname=getform("customname","post",'*','json');
	$custom='z'.safe_word(getform("custom","post",'*','json'));
	$customtype=getform("customtype","post","sel",'json');
    if(is_array($customtype)) $customtype=count($customtype)==0 ? $customtype : @implode(",",$customtype);    
	$customclass=safe_word(getform("customclass","post","sel",'json'));
	$customoptions=getform("customoptions","post");
	$customoptions=safe_key(str_replace('，',',',$customoptions),1000);
	$customvalues=safe_key(getform("customvalues","post"));
	$customplace=safe_key(getform("customplace","post"));	
	$customdesc=safe_key(getform("customdesc","post"));	$colarr=array('customname'=>$customname,'customtype'=>$customtype,'customclass'=>$customclass,'customoptions'=>$customoptions,'customvalues'=>$customvalues,'customplace'=>$customplace,'customdesc'=>$customdesc);
	if ($customid==0){
		if (db_count('content_custom',array('custom'=>$custom))>0 ) returnmsg('json',0,'参数名已存在，请更换');
		arr_add($colarr,'custom',$custom);
		arr_add($colarr,'customorder',9);
		arr_add($colarr,'customonoff',1);	
		arr_add($colarr,'lid',1);			
		if ($customtype=="about" || $customtype=="brand" || $customtype=="gbook"){
			$dbtable=$customtype;
		}else{
			$dbtable="content";
		}
		switch ($customclass){
			case 1:				
				db_add($dbtable,array($custom=>'int'));
				db_update($dbtable,'',array($custom=>$customvalues));
			break;
			case 2:
			case 3:
				db_add($dbtable,array($custom=>'text'));			
			break;
			case 10:
				db_add($dbtable,array($custom=>'datetime'));			
			break;
			default:
				db_add($dbtable,array($custom=>'varchar'));
		}		
		if(db_insert('content_custom',$colarr)) returnmsg ('json',1,'添加成功，是否继续添加？','?act=custom'); 
	}else{
		if(db_update('content_custom','customid='.$customid,$colarr)) returnmsg('json',1,'保存成功');
	}
	 returnmsg ('json',0,'保存失败');	
}

function del_custom(){
	$custom=safe_word(getform('custom','post'));
	$customtype=db_select("content_custom","customtype","custom='".$custom."'");
	if($customtype=='about'|| $customtype=='brand'||$customtype=='gbook'){
		$dbtable=$customtype;
	}else{
		$dbtable='content';
	}
	db_delete('content_custom',array("custom"=>$custom));	
	db_drop($dbtable,$custom);	
}

function save_user(){
	check_token();
	$uid=getform("uid", "post");	
	$type=getform("type", "post");	
	$u_gid=getform("u_gid", "post",'sel','json');
	$username=safe_key(getform("username", "post",'name','json'));
	$truename=safe_key(getform("truename", "post",'nul','json'));
	$password=getform("password", "post");
	$repassword=getform("repassword", "post");	
	$question=safe_word(getform("question", "post"));
	$answer=safe_word(getform("answer", "post"));
	$tel=getform("tel", "post");
	$telcode=getform("telcode", "post");
	$tel=$telcode.'-'.$tel;
	$mobile=safe_key(getform("mobile", "post",'m','json'));
	$email=getform("email", "post");
	$qq=getform("qq", "post");	
	$province=getform("province", "post");
	$city=getform("city", "post");
	$district=getform("district", "post");
	$address=getform("address", "post");
	$post=getform("post", "post");
	$qq=getform("qq", "post");
	$face=getform("face", "post");	 $face=str_replace(PLUG_PATH.'face/','',$face);	
	$u_desc=getform("u_desc", "post");
	$colarr=array('username'=>$username,'truename'=>$truename,'question'=>$question,'answer'=>$answer,'tel'=>$tel,'mobile'=>$mobile,'email'=>$email,'qq'=>$qq,'province'=>$province,'city'=>$city,'district'=>$district,'address'=>$address,'post'=>$post,'face'=>$face,'u_desc'=>$u_desc,'u_gid'=>$u_gid);
	if($uid==0){
		if (empty($password)) 								returnmsg('json',0,'添加用户密码不能为空');
		if (checkstr($password,'pass')!==true) 				returnmsg('json',0,'密码不符合规则');
		if (check_used('user',"username",$username))	returnmsg('json',0,'账号已经存在请更换账号');
		if (check_used('user',"mobile",$mobile))		returnmsg('json',0,'手机号已经存在请更换手机号');
		arr_add($colarr,'u_onoff',1);
		arr_add($colarr,'u_order',9);		
		arr_add($colarr,'password',md5_16($password));	
		if(db_insert('user',$colarr)) returnmsg('json',1,'添加成功，是否继续添加？','?act='.$type); 
	}else{
		if (check_used('user',"mobile",$mobile,$uid))		returnmsg('json',0,'手机号已经存在请更换手机号');
		if (!empty($password)){
			if (checkstr($password,'pass')!==true) 			returnmsg('json',0,'很抱歉，密码必须为6-16位大小写字母或数字！');
            set_cookie('adminpass','0');
			arr_add($colarr,'password', md5_16($password));			
		}
		if ($uid==get_session("adminid")) {
			if (empty($face)){
				set_cookie("adminface","../plugins/face/face01.png");
			}elseif(lenstr($face)<11){
				set_cookie("adminface","../plugins/face/".$face);
			}else{
				set_cookie("adminface", $face);
			}
		}
		if(db_update('user','uid='.$uid,$colarr)) returnmsg('json',1,'保存成功');	
	}
	 returnmsg('json',0,'保存失败');
}

function save_gbook(){
	check_token();
	$gid=getform("gid", "post","num",'json');
	$g_title=safe_key(getform("g_title", "post"));
	$g_name=safe_key(getform("g_name", "post"));
	$g_time=getform("g_time", "post");	
	$g_tel=getform("g_tel", "post");
	$g_email=getform("g_email", "post");
	$g_ip=getform("g_ip", "post");
	$r_name=safe_key(getform("r_name", "post"));
	$g_content=getform("g_content", "post");
	$r_content=getform("r_content", "post");
	$colarr=array('g_title'=>$g_title,'g_name'=>$g_name,'g_time'=>$g_time,'g_content'=>$g_content,'g_tel'=>$g_tel,	'g_email'=>$g_email,'g_ip'=>$g_ip,'r_name'=>$r_name,'r_content'=>$r_content);
	if (empty($r_content)){
		arr_add($colarr,'r_onoff', 0);
	}else{
		arr_add($colarr,'r_time', date('Y-m-d h:i:s',time()));
		arr_add($colarr,'r_onoff', 1);
	}
	if(db_update('gbook','gid='.$gid,$colarr)) returnmsg('json',1,'修改成功');
	returnmsg('json',0,'保存失败');
}

function save_sort(){
	check_token();
	$sid=getform("sid", "post");
	$istitle=getform("istitle", "post");
	$s_type=getform("s_type", "post",'sel','json');
	$s_pid=getform("s_pid", "post",'',0);
	if ($s_pid==$sid && $s_pid>0) returnmsg('json',0,'上级分类不能选择当前分类');
	$s_name=getform("s_name", "post",'nul');
	$s_enname=safe_key(getform("s_enname", "post"));
	$s_url=safe_url(getform("s_url", "post"));
	$s_filename=safe_word(getform("s_filename", "post"));
	$s_pic=getform("s_pic", "post");
	$s_ico=getform("s_ico", "post");	
	$s_template=getform("s_template", "post");	$s_template=count($s_template)==0 ? $s_template : @implode(",",$s_template);
	$c_template=getform("c_template", "post");	$c_template=count($c_template)==0 ? $c_template : @implode(",",$c_template);
	$s_postion=getform("s_postion", "post");	$s_postion=count($s_postion)==0 ? $s_postion : @implode(",",$s_postion);
	$s_gid=getform("s_gid", "post",'num');
	$s_other1=getform("s_other1", "post");
	$s_other2=getform("s_other2", "post");
	$s_title= $istitle==1 ? $s_name : getform("s_title", "post");
	$s_key=getform("s_key", "post");
	$s_desc=getform("s_desc", "post");
	$time= date('Y-m-d h:i:s',time());
	$colarr=array('s_type'=>$s_type,'s_pid'=>$s_pid,'s_name'=>$s_name,'s_enname'=>$s_enname,'s_url'=>$s_url,'s_filename'=>$s_filename,'s_pic'=>$s_pic,'s_ico'=>$s_ico,'s_template'=>$s_template,'c_template'=>$c_template,'s_postion'=>$s_postion,'s_gid'=>$s_gid,'s_other2'=>$s_other2,'s_other1'=>$s_other1,'s_title'=>$s_title,'s_key'=>$s_key,'s_addtime'=>$time,'s_desc'=>$s_desc,'s_lid'=>1);
	delfiles(RUN_DIR . 'cache/navlist/','tpl','all');
	if ($sid==0){
		if(check_used('sort','s_filename',$s_filename)) returnmsg('json',0,'【短链接】存在重名，请修改');
		arr_add($colarr,'s_order',9);
		arr_add($colarr,'s_onoff',1);
		$sid=db_insert('sort',$colarr);
		save_path($sid);
		if ($s_type=='about')  db_insert('about',array('a_sid'=>$sid,'a_lid'=>1,'a_name'=>$s_name,'a_order'=>9,'a_onoff'=>1,'a_addtime'=>$time));
		$s_pid>0 ? returnmsg('json',1,'添加成功,继续添加','?act=sort&pid='.$s_pid) : returnmsg('json',1,'添加成功,继续添加','?act=sort');
	}else{		
		if(check_used('sort','s_filename',$s_filename,$sid)) returnmsg('json',0,'【短链接】存在重名，请修改');
		if ($s_type=='about') {
		  if(db_count('about',array('a_sid'=>$sid))==0) db_insert('about',array('a_sid'=>$sid,'a_lid'=>1,'a_name'=>$s_name,'a_order'=>9,'a_onoff'=>1,'a_addtime'=>$time));
		}elseif(db_table($s_type)=='content'){
		  if(db_select('sort','s_type',array('sid'=>$sid))!=$s_type) db_update('content',array('c_sid'=>$sid),array('c_type'=>$s_type));
		}        
		db_update('sort','sid='.$sid,$colarr);
		save_path($sid,$s_pid);
		returnmsg('json',1,'修改成功');
	}	
}

function save_sortadds(){
	$onearr=array();$morearr=array();
	for ($i=1; $i<=9; $i++) {
		$model=getform("model_".$i, "post");
		$pid=getform("pid_".$i, "post");
		$onename=(getform("onename_".$i, "post"));
		$morename=(getform("morename_".$i, "post"));		
		if($model!='') {
			if($onename!='' || $morename!=''){	
				$data=db_load_one('model',"model_type='".$model."'",'model_list_tp,model_list_fd,model_content_tp,model_content_fd,model_list_name,model_content_name');
				if ($pid==0){
					$tid=0;			
				}else{
					$tid=db_select('sort','s_tid','sid='.$pid);
					$tid=$tid==0 ? $pid : $tid;					
				}
				if ($onename!='')	{
					$pid=add_sort($model,$onename,$tid,$pid,$data);
					$tid=db_select('sort','s_tid','sid='.$pid);
				}
				if($morename!=''){				
					$morearr=splits($morename,'|');
					foreach($morearr  as $value) {
						if ($value!=''){
							add_sort($model,$value,$tid,$pid,$data);
						}
					}
				}
			}
		}
	}
    delfiles(RUN_DIR . 'cache/navlist/','tpl','all');
	layertrue('添加成功','?act=sortlist');
}

function add_sort($model,$name,$tid,$pid,$data){
	$time= date('Y-m-d h:i:s',time());
	$colarr=array('s_tid'=>$tid,'s_pid'=>$pid, 's_order'=>9, 's_type'=>$model, 's_name'=>$name,'s_title'=>$name,  's_template'=>$data['model_list_tp'].','.$data['model_list_tp'], 'c_template'=>$data['model_content_tp'].','.$data['model_content_tp'], 's_folder'=>'', 'c_folder'=>'', 's_filename'=>'', 'c_filename'=>'', 's_onoff'=>1,  's_lid'=>1, 's_addtime'=>$time, 's_gid'=>0, );
	$sid=db_insert('sort',$colarr);
	save_path($sid);
	if ($model=='about') db_insert('about',array('a_sid'=>$sid,'a_lid'=>1,'a_name'=>$name,'a_order'=>9,'a_onoff'=>1,'a_addtime'=>$time));
	return $sid;
}

function save_path($sid,$pid=-1){
	if (empty($sid)) return false;
	$pid= $pid<0 ? db_select('sort','s_pid','sid='.$sid) : $pid;
	if ($pid==0){
		db_update('sort',array('sid'=>$sid),array('s_tid'=>$sid, 's_level'=>1, 's_path'=>$sid.','));
	}else{
		$data=db_load_one('sort','sid='.$pid,'s_tid,s_level,s_path');
		$spath=$data['s_path'].$sid.',';
		db_update('sort',array('sid'=>$sid),array('s_tid'=>$data['s_tid'], 's_level'=>$data['s_level']+1, 's_path'=>$spath));
		$subid=db_load('sort',array('s_pid'=>$sid),'sid');
		foreach ($subid as $value) {
		  save_path($value['sid']);
		}
	}
}

function del_sort(){
    $id=isnum(getform('id','both'));
    if (empty($id)) return false;
	$data=db_subsort($id);
	foreach ($data as $key=>$sid){	
	  $type=db_select('sort','s_type',array('sid'=>$sid));
	  if ($type=='about' ){
		  db_exec('delete FROM [dbpre]about where a_sid='.$sid);	
	  }else{
		  db_exec('delete FROM [dbpre]content where c_sid='.$sid);	
	  }
    delfiles(RUN_DIR . 'cache/navlist/','tpl','all');    
	db_delete('sort',$sid);	
	}
}

function repair_sort(){
	$data=db_load('sort','','sid,s_tid,s_pid,s_level,s_path,s_onoff');
	foreach($data as $value){
		if(!$value['s_onoff'])  db_update('sort',array('sid'=>$value['sid']),array('s_onoff'=>0));
		if(!$value['s_tid'])   save_path($value['sid']);
		if(!$value['s_level'])	db_update('sort',array('s_level'=>0,'s_tid'=>0,'s_pid'=>0,'s_path'=>$value['sid'].',')); 
		if(substr_count($value['s_path'],',')!=$value['s_level']) save_path($value['sid']);	
		if(!ifstrin($value['s_path'],$value['sid'])) save_path($value['sid']);	
		if($value['s_pid']==0 && $value['s_level']!=1)   save_path($value['sid']);
		if($value['s_pid']!=0 && $value['s_level']==1)   save_path($value['sid']);			
	}
	returnmsg('json',1,'修复完成');
}
	
function save_links(){
	check_token();
	$lid=getform("lid", "post",'',0);
	$l_name=getform("l_name", "post",'nul','json');
	$l_type=getform("l_type", "post",'nul','json');
	$l_cid=getform("l_cid", "post",'num','json');
	$l_url=getform("l_url", "post");
	$l_pic=getform("l_pic", "post");
	$colarr=array('l_name'=>$l_name,'l_type'=>$l_type,'l_cid'=>$l_cid,'l_url'=>$l_url,'l_pic'=>$l_pic,'l_order'=>9,'l_onoff'=>1);
	if ($lid==0){
		arr_add($colarr,'l_order',9);
		arr_add($colarr,'l_onoff',1);
		db_insert('links',$colarr);
		returnmsg('json',1,'添加成功，是否继续','?act=links');
	}else{
		db_update('links','lid='.$lid,$colarr);
		returnmsg('json',1,'修改成功');
	}
}
function save_labels(){
	check_token();
	$labelid=getform('labelid','post','',0);
	$label_name=getform('label_name','post');
	$label_title=getform('label_title','post');
	$label_entitle=getform('label_entitle','post');
	$label_addtime=getform('label_addtime','post');
	$label_pic=getform('label_pic','post');
	$file=getform('file','post');
	$label_content=getform('label_content', "post");
	$label_desc=getform('label_desc','post');		
	if ($labelid==0){		$colarr=array('label_name'=>$label_name,'label_title'=>$label_title,'label_entitle'=>$label_entitle,'label_addtime'=>$label_addtime,'label_pic'=>$label_pic,'label_content'=>$label_content,'label_desc'=>$label_desc,'label_order'=>9,'label_onoff'=>1);
		db_insert('labels',$colarr);
		returnmsg('json',1,'添加成功，是否继续','?act=labels');
	}else{	
		$colarr=array('label_name'=>$label_name,'label_title'=>$label_title,'label_entitle'=>$label_entitle,'label_edittime'=>date('Y-m-d h:i:s',time()),'label_pic'=>$label_pic,'label_content'=>$label_content,'label_desc'=>$label_desc);
		db_update('labels','labelid='.$labelid,$colarr);
		returnmsg('json',1,'修改成功');
	}
}

function save_slide(){
	check_token();
	$slideid=getform("slideid","post",'',0);
	$slidename=getform("slidename","post",'*','json');
	$slideimg=getform("slideimg","post",'*','json');
	$slidewidth=getform("slidewidth","post");
	$slideheight=getform("slideheight","post");
	$slideclass=getform("slideclass","post");
	$slideorder=getform("slideorder","post");
	$slidelink=getform("slidelink","post");	
	$slidetitle1=getform("slidetitle1","post");
	$slidetitle2=getform("slidetitle2","post");
	$slidecontent=getform("slidecontent","post");	
	$colarr=array('slidename'=>$slidename,'slidewidth'=>$slidewidth,'slideheight'=>$slideheight,'slideclass'=>$slideclass,'slidelink'=>$slidelink,'slideimg'=>$slideimg,'slidetitle1'=>$slidetitle1,'slidetitle2'=>$slidetitle2,'slidecontent'=>$slidecontent);
	check_pic($slideimg,'slide',$slideid);
	if ($slideid==0){
		arr_add($colarr,'slideOrder',9);
		arr_add($colarr,'slideonoff',1);
		db_insert('slide',$colarr);
		returnmsg('json',1,'添加成功，是否继续','?act=slide');
	}else{
		db_update('slide','slideid='.$slideid,$colarr);
		returnmsg('json',1,'修改成功');
	}
}

function updata_id(){
	$table=safe_word(getForm("table","post"));
	$colid=safe_word(getForm("colid","post"));
	$colname=safe_word(getForm("colname","post"));
	$colval=getForm("colval","post");
	$update=array($colname=>$colval);
    if($table=='sort') {
        delfiles(RUN_DIR . 'cache/navlist/','tpl','all');
    }
	if($colname=='model_name'){
		$colkey=db_select('model','model_type','model_id='.$colid);
		db_update('menu',array('m_key'=>$colkey),array('m_name'=>$colval.'管理'));
	}elseif ($colname=='s_filename' ||$colname== 'c_pagename') {
		if (check_used($table,$colname,$colval,$colid)) returnmsg('json',0,'名称重复，请修改');	
	}
	if (db_update($table,$colid,$update)) {
		returnmsg('json',1,'修改成功');
	}else{
		returnmsg('json',2,'修改失败，请查看报错日志');	
	}
}

function up_admin($type){
    $path=strtolower(safe_word(getForm("path","post")));
    if ($type=='admin'){
        if($path==safe_word(conf('adminpath'))) die('修改失败,别和原来的一样啊！');
        if(lenstr($path)<5 || lenstr($path)>15) die('修改失败，目录请设置5-15位！');
         if($path=='admin') die('修改失败,别用admin这个目录了！');
         if(copy_dir(ADMIN_DIR,SITE_DIR.$path)){
            $config=array('adminpath'=>$path.'/');
            save_config($config);
            del_allfolder(ADMIN_DIR);
            set_cookie('adminpath',0);
        }
    }elseif ($type=='wap'){
        if($path==safe_word(conf('wappath'))) die('修改失败,别和原来的一样啊！');
        if(copy_dir(SITE_DIR.conf('wappath'),SITE_DIR.$path)){
            $config=array('wappath'=>$path.'/');
            del_allfolder(SITE_DIR.conf('wappath'));
            save_config($config);
        }
    }
    echo true;
}

function up_data(){
	$type=safe_word(getForm("type","post"));	
	$savepath=RUN_DIR.'updata/';
	$zipdir=RUN_DIR.'zip/';
    $cachedir=RUN_DIR.'cache/';
	$updatastr=https_get("http://zzzcms.com/zzzphp/ver.html");
	$updataarr=splits($updatastr,";");
	$file=$updataarr[6];
	switch ($type){
	  case 'size':
        del_allfolder($zipdir);
		$downsize=$GLOBALS['downsize']=down_size(trim($file));
		returnmsg('json',$downsize,$file);
		break;
	  case 'down':        
        $GLOBALS['downfile']=down_file(trim($file));
        returnmsg('json',1);
		break;
	  case 'unzip':
        $zipfile=getfiles($zipdir,'zip','no');
	 	$zipfile= $zipfile[0]['dir'];           
        if(!is_file($zipfile)) { 
			returnmsg('json',0,'解压失败, 补丁地址不正确:'.$zipfile);
        }
	     $zip = new ZipArchive; 
		 $res = $zip->open($zipfile);
		 if ($res === TRUE) { 
			$zip->extractTo($savepath); 
			$zip->close();
			returnmsg('json',1,'解压成功');
		 } else { 
			returnmsg('json',0,'解压失败，failed, code:' . $res); 
		 } 
		break;
	 case 'movefile':
		copy_dir($savepath.'admin',ADMIN_DIR);	
		del_allfolder($savepath.'admin');
		copy_dir($savepath,SITE_DIR);	
		del_allfolder($savepath);
        del_allfolder($zipdir);    
        del_allfolder($cachedir);
		returnmsg('json',1,'升级成功');
		break;
	}
}

function editfile(){
	check_token();
	$file=safe_url(getform('file','post'));
	$filetext=getform('filetext','post');
	if(strpos($filetext,'.')!==false || strpos($file,'..')!==false || strpos($file,'./')!==false || strpos($file,conf('adminpath'))!==false) returnmsg('json',0,'危险路径，不允许修改');	
    $file_path=file_path($file);
    $safe_path=array('upload','template','runtime');
    if(arr_search($file_path,$safe_path)){
	   $file=$_SERVER['DOCUMENT_ROOT'].$file;
       !(is_file($file)) and returnmsg('json',0,'保存失败，文件不存在');
    }else{
        returnmsg('json',0,'非安全目录文件不允许修改');
    }
	if (create_file($file,decode(html_textarea($filetext)))){
		returnmsg('json',1,'修改成功');
	}else{
		returnmsg('json',0,'保存失败');
	};
}

function delfile(){
	$file=safe_url(getform('path','post'));	   
    $file_path=file_path($file);
    $safe_path=array('upload','template','runtime','backup');
    if(arr_search($file_path,$safe_path)){
        $file=$_SERVER['DOCUMENT_ROOT'].$file; 
        return del_file($file);
    }
}

function delallfile($type){
	$folder=safe_word(getform('folder','get'));	
    $filedir= $folder ?$folder.'/' : '';   
	switch ($type){
		case 'html':
			$filedir=SITE_DIR.$filedir.conf('htmldir');
           // echop($filedir);
			$model=load_model('all');
			foreach( $model as $value){
				 delfiles($filedir.$value.'/','html','all');
			}
			 delfiles($filedir.'list/','html','all');
			 delfiles($filedir.'brandlist/','html','all');
			 delfiles($filedir.'taglist/','html','all');
			 delfiles($filedir.'content/','html','all');			
			 delfiles($filedir,'html');
			layertruego ('清空成功','?act=htmllist&type='.$folder,'');
		case 'cache':
			$filedir=RUN_DIR.'cache/';
			return delfiles($filedir,'tpl','all');
	}
}

function backup(){
		$conf = _SERVER('conf');
		$db=$conf['db'];
		$name=time();
		$username=get_cookie('adminname');
		$time= date('Y-m-d h:i:s',time());
		$ip=ip();		
		switch ($conf['db']['type']) {
		case 'access':
			$filepath=SITE_DIR.$db['accesspath'].$db['accessname'];
			$backpath=SITE_DIR.$db['accesspath'].'backup/'.$name.'.acc';
			str_log('数据库备份,原路径'.$filepath.',备份路径:'.$backpath.',管理员:'.$username.',时间：'.$time.',IP:'.$ip,'data');
			file_backup($filepath,$backpath);	
			break;
		case 'sqlite':	
			$filepath=SITE_DIR.$db['sqlitepath'].$db['sqlitename'];
			$backpath=SITE_DIR.$db['sqlitepath'].'backup/'.$name.'.lite';
			str_log('数据库备份,原路径'.$filepath.',备份路径:'.$backpath.',管理员:'.$username.',时间：'.$time.',IP:'.$ip,'data');
			file_backup($filepath,$backpath);	
			break;
		case 'mysql':
			$filepath=SITE_DIR.$db['accesspath'].$db['accessname'];	
			$str = "SET FOREIGN_KEY_CHECKS=0;\r\n";  
			$i = 0;  
			$tables=db_table_list();
			foreach ($tables as $table) { 
				foreach ($table as $value){
				$str .= "DROP TABLE IF EXISTS `{$value}`;\r\n";  
				$str .= db_table_create($value) . "\r\n";  
				$str .= db_table_data($value) . "\r\n";  
				$i++; 
				}				
			}	
			str_log('数据库备份,原路径'.$filepath.',备份路径:'.$name.'.bak,管理员:'.$username.',时间：'.$time.',IP:'.$ip,'data');
			create_file(dirname(__FILE__).'/backup/'.$name.'.bak',$str);	
		break;
		}
}

function restore(){
	$conf=_SERVER('conf');
	$path=safe_url(getform('path','post'));
	$backpath=$_SERVER['DOCUMENT_ROOT'].$path;	
	$username=get_cookie('adminname');
	$time= date('Y-m-d h:i:s',time());
	$ip=ip();	
	str_log('数据库还原,原路径'.$path.'备份路径:'.$backpath.'管理员:'.$username.'时间：'.$time.'IP:'.$ip,'data');
	switch ($conf['db']['type']) {
	case 'access':
		$name=randname().'.mdb';
		$datapath=SITE_DIR.$conf['db']['accesspath'].$name;
		if (file_backup($backpath,$datapath)){
            echo save_config(array('accessname'=>$name));
        }else{
            echo 0;
        }
		break;
	case 'sqlite':	
		$name=randname().'.db';	
		$datapath=SITE_DIR.$conf['db']['sqlitepath'].$name;	
		if (file_backup($backpath,$datapath)){
           echo save_config(array('sqlitename'=>$name));
        }else{
           echo 0;
        }
		break;
	case 'mysql':
		 if (is_file($backpath)) {  
           $sql = load_file($backpath);  
		   $data = explode(';'.PHP_EOL, $sql);
			foreach ($data as $value) {
				if ($value){					
				echo db_exec($value);
				}
			}     
        } 
		break;
	}
	
}

function small_pic($type){
	switch($type){
		case 'about':	
		$data=db_load('about','a_onoff=1','a_pic as pic,aid as id');
		break;
		case 'brand':	
		$data=db_load('brand','b_onoff=1','b_pic  as pic,bid as id');
		break;
		case 'slide':	
		$data=db_load('slide','slideonoff=1','slideimg  as pic,slideid as id');
		break;
		case 'all':			
		small_pic('about');
		small_pic('brand');	
		$data=db_load('content',array('c_onoff'=>1),'c_pic  as pic,cid as id,c_type as type');
		foreach ($data as $key=>$value) {
			check_pic($value['pic'],$value['type'],$value['id']);
		} 
		return true;	
		break;
		default:
		$data=db_load('content',array('c_onoff'=>1,'c_type'=>$type),'c_pic  as pic,cid as id');
	}
	foreach ($data as $key=>$value) {
		check_pic($value['pic'],$type,$value['id']);
	} 
	return true;
}

function savehtml(){
	check_token();
	$runmode=getform('runmode','post','num');
	$iscache=getform('iscache','post','num');
	$runmode==1 and $iscache=0;	
	$htmldir=safe_key(getform('htmldir','post'));
	$htmldir=empty($htmldir) ? '' : str_replace('//','/',$htmldir.'/');
	$cachetime=getform('cachetime','post','','1');
	$siteext=safe_key(getform("siteext",'post'));
	$siteext= empty($siteext) ? '' :'.'.ltrim( $siteext, '.' );
	$config=array('runmode'=>$runmode,'iscache'=>$iscache,'htmldir'=>$htmldir,'cachetime'=>$cachetime,'siteext'=>$siteext);
	if( $runmode==2 ) {
		$model=load_model('content','|');		
		if (strtoupper(substr(PHP_OS,0,3))==='WIN'){
			$webconfig=file_get_contents(SITE_DIR.'plugins/webconfig/webconfig');	
			$webconfig=str_replace('siteext',conf("siteext"),$webconfig);
			$webconfig=preg_replace( "/about(\S*?)content/i", "about|" . $model ."brand|content", $webconfig );
			if (is_file(SITE_DIR.'web.config' )) {
				layeropen(txt_html($webconfig),1,'请修改根目录web.config伪静态规则，配置参考如下:');				
			}else{
				create_file(SITE_DIR.'web.config',$webconfig );
				save_config($config);
				layertruego('修改成功','?act=htmlset','');
			}		
							   
		}elseif(substr(PHP_SAPI,0,3)=='cgi'){
			if (copy_file( SITE_DIR.'plugins/webconfig/htaccess', SITE_DIR.'.htaccess')) {
				save_config($config);
				layertruego('修改成功','?act=htmlset','');
			}
		}else{
			$rewrite=load_file( SITE_DIR.'plugins/webconfig/rewrite');
			save_config($config);
			layeropen(txt_html($rewrite),1,'请将服务器伪静态规则配置如下:');
		}
	}else{
        delfiles(RUN_DIR . 'cache/navlist/','tpl','all');
		del_file( SITE_DIR.'web.config' );
		del_file( SITE_DIR.'.htaccess' );
		del_file( SITE_DIR.'index.html' );
		save_config($config);
		layertruego('修改成功','?act=htmlset','');		
	}	
}

function create_index($htmldir){    
	require_once '../inc/zzz_template.php';
	$GLOBALS['sid']=0;$GLOBALS['tid']=0;
	$htmlfile =  $htmldir.'index.html';
	$tplfile  = TPL_DIR.'index.html';
	$zcontent = load_file($tplfile);     
	$parser = new ParserTemplate();
	$zcontent = $parser->parserCommom($zcontent); // 解析模板    
	create_file($htmlfile, $zcontent);
	return array('num'=>1,'total'=>1,'page'=>1);
}

function create_brand($htmldir,$folder){
    $total=db_count('brand',array('b_onoff'=>1));
	$data=db_load_sql('select bid,b_template,b_filename from [dbpre]brand  where b_onoff=1');
	if(is_array($data)){			
		require_once '../inc/zzz_template.php';			
		foreach ($data as $k=>$value){
			$GLOBALS['sid']=-1;$GLOBALS['tid']=-1;
			$GLOBALS['bid']=$value['bid'];
			$GLOBALS['bname']=$value['b_filename'];
			$GLOBALS['location']='brand';
			$GLOBALS['page']=1;
			$b_template=splits($value['b_template'],',');
				if ($folder=='wap'){
					$template=isset($b_template[1]) ? $b_template[1] : 'brand.html';
				}else{
					$template=!empty($b_template[0]) ? $b_template[0] : 'brand.html';
				}				
			$tplfile=TPL_DIR.$template;
			$url=empty($value['b_filename']) ?  'brand/'.$value['bid'] : 'brand/'.$value['b_filename'];
			do{
				$htmlfile = G('page')>1 ?  $htmldir.$url.'_'.G('page').'.html' :  $htmldir.$url.'.html';
				$zcontent = load_file($tplfile);
				$parser = new ParserTemplate();
				$zcontent = $parser->parserCommom($zcontent); // 解析模板	
				create_file($htmlfile, $zcontent);
				//echop ($htmlfile);
			}while (G('page')>1);
		}		
	}
    return array('num'=>$k+1,'total'=> $total,'page'=>1);
}

function create_about($htmldir,$folder){
    $total=db_count('about',array('a_onoff'=>1));
	$data=db_load_sql('select aid,sid,s_template,s_filename,a_content from [dbpre]sort as a,[dbpre]about as b where a_onoff=1 and s_type="about" and a.sid=b.a_sid ');
		$GLOBALS['location']='about';
		if(is_array($data)){
		  require_once '../inc/zzz_template.php';			
		  foreach ($data as $k=>$value){	
			$GLOBALS['sid']=$value['sid'];
			$GLOBALS['aid']=$value['aid'];
			ParseGlobal($value['sid'],'');			
			$c_template=splits($value['s_template'],',');
			if ($folder=='wap'){
				$template=isset($c_template[1]) ? $c_template[1] :  $c_template[0];
			}else{
				$template=$c_template[0];
			}
			$tplfile = is_file(TPL_DIR . $template) ? TPL_DIR . $template : TPL_DIR . 'about.html' ;			
			$listpage=substr_count($value['a_content'],'{list:page}')+1;
			for($i=1;$i<=$listpage;$i++ ) {
				$GLOBALS['page']=$i;
				$url=empty($value['s_filename']) ?  'about/'.$value['sid'] : $value['s_filename'] ;
				$htmlfile =$i>1 ? $htmldir.$url.'_'.$i.'.html' : $htmldir.$url.'.html';
				$zcontent = load_file($tplfile,'about');		
				$parser = new ParserTemplate();
				$zcontent = $parser->parserCommom($zcontent); // 解析模板		
				create_file($htmlfile, $zcontent);
				//echop ($htmlfile);
			}
		 }
	}
     return array('num'=>$k+1,'total'=> $total,'page'=>1);
}

function create_tag($htmldir,$folder){
    $total=db_count('tag',array('c_tag'=>1));$k=0;$page =0;
	$data=db_load_sql('select tid,t_enname,t_name from [dbpre]tag  where t_onoff=1');
	if(is_array($data)){			
		require_once '../inc/zzz_template.php';			
		foreach ($data as $k=>$value){
			$GLOBALS['sid']=$value['t_enname'];$GLOBALS['tid']=-1;
			$GLOBALS['tagid']=$value['tid'];
			$GLOBALS['tname']=$value['t_enname'];
			$GLOBALS['location']='taglist';
			$GLOBALS['page']=1;
			$template='taglist.html';					
			$tplfile=TPL_DIR.$template;
			$url='taglist/'.$value['t_enname'];
			do{
				$htmlfile = G( 'page' )==1 ? $htmldir.$url.'.html' : $htmldir.$url.'_'.G('page').'.html';
				$zcontent = load_file($tplfile);
				$parser = new ParserTemplate();
				$zcontent = $parser->parserCommom($zcontent); // 解析模板	
				create_file($htmlfile, $zcontent);
			//	echop ($htmlfile);
			}while (G('page')>1);            
		}		
	}
     return array('num'=>$k+1,'total'=>$total,'page'=>$page);
}

function create_content($htmldir,$folder,$page=1){
    $total=db_count('content',array('c_onoff'=>1));
    $size=DB_TYPE=='mysql' ? 2000 :500;
    if($total>$size){
        $data=db_load('sort s,content c',array('c_onoff'=>1,'sid'=>array('='=>'c_sid')),'cid,sid,s_type,c_template,c_pagename,c_content','500','cid desc',$page);
    }else{
        $data=db_load('sort s,content c',array('c_onoff'=>1,'sid'=>array('='=>'c_sid')),'cid,sid,s_type,c_template,c_pagename,c_content','500','cid desc');
    }
    $GLOBALS['location']='content';
    if(is_array($data)){
      require_once '../inc/zzz_template.php';			
      foreach ($data as $k=>$value){	
        $GLOBALS['sid']=$value['sid'];
        $GLOBALS['cid']=$value['cid'];
        ParseGlobal($value['sid'],$value['cid']);			
        $c_template=splits($value['c_template'],',');
        if ($folder=='wap'){
            $template=isset($c_template[1]) ? $c_template[1] :  $c_template[0];
        }else{
            $template=$c_template[0];
        }
        $tplfile = is_file(TPL_DIR . $template) ? TPL_DIR . $template : TPL_DIR . 'content.html' ;			
        $listpage=substr_count($value['c_content'],'{list:page}')+1;
            for($i=1;$i<=$listpage;$i++ ) {
                $url=empty($value['c_pagename']) ?  $value['s_type'].'/'.$value['cid'] : $value['s_type'].'/'.$value['c_pagename'] ;
                $htmlfile =$i>1 ? $htmldir.$url.'_'.$i.'.html' : $htmldir.$url.'.html';
                $zcontent = load_file($tplfile,'content');		
                $parser = new ParserTemplate();
                $zcontent = $parser->parserCommom($zcontent); // 解析模板
                create_file($htmlfile, $zcontent);
               // echop ($htmlfile);
            }
        }
    }
    return array('num'=>$size*($page-1)+$k,'total'=>$total,'page'=>$page);
}

function create_list( $htmldir, $folder,$num=0,$sid=null) {
    $data = db_load_sql( "select sid,s_template,s_filename,s_type from [dbpre]sort where s_onoff=1 and s_type<>'links' and s_type<>'about'" );
    $counttotal=0;
    $overtime=29;
    $starttime=time();
    if ($data) {
        require_once '../inc/zzz_template.php';
        $parser = new ParserTemplate();
        foreach ( $data as $value ) {
           if ( $value[ 's_type' ] == 'brand' ) {
                $GLOBALS[ 'btype' ] = empty($value[ 's_filename' ]) ? 'index' : $value[ 's_filename' ];
            } elseif ( in_array( $value[ 's_type' ], load_model() ) ) {
                $GLOBALS[ 'location' ] = 'list';
            } else {
                $GLOBALS[ 'location' ] = $value[ 's_type' ];
            }
            ParseGlobal( $value[ 'sid' ], '' );
            $GLOBALS[ 'page' ] = $page = 1;
            $GLOBALS[ 'cname' ]=$value[ 's_filename' ];
            $s_template = splits( $value[ 's_template' ], ',' );
            if ( $folder == 'wap' ) {
                $template = isset($s_template[ 1 ] ) ? $s_template[ 1 ] : $s_template[ 0 ];
            } else {
                $template = $s_template[ 0 ];
            }
            
            $tplfile = is_file(TPL_DIR . $template) ? TPL_DIR . $template : TPL_DIR . 'list.html' ;
            if ( !empty( $value[ 's_filename' ] ) && strpos( $value[ 's_filename' ], '{page}' ) === FALSE ) {
                $url = $value[ 's_filename' ];
            }else {
                $url = G( 'location' ) . '/' . $value[ 'sid' ];
            }            
            $tplcontent=load_file( $tplfile,G('location'));
            $pagesize=parserParam( $tplcontent,'size',10);
            $totalnum=db_count('content',array('c_sid'=>db_subsort($value['sid'])));
            $totalpage=ceil($totalnum/$pagesize);
           // echop($url.$totalpage);
            for($k=0;$k<=$totalpage;$k++) {
                $counttotal++;
                 if ($value[ 's_type' ] == 'brand'){
                     $htmlfile =  G( 'page' )==1 ? $htmldir.'brandlist/'.G('btype').'.html': $htmldir.'brandlist/'.G('btype').'_' .  G( 'page' ). '.html';
                }else{
                     $htmlfile =  G( 'page' )==1 ? $htmldir . $url  . '.html': $htmldir . $url . '_' . G( 'page' ) . '.html';
                }
                if($counttotal>$num ) {                   
                    $zcontent = $parser->parserCommom($tplcontent); // 解析模板                    
                    create_file($htmlfile,$zcontent);                
                    if((($starttime-time())/1000)>=$overtime) return array('num'=>$counttotal,'total'=>$counttotal+1);
                }
            } 
        }      
    }
    return array('num'=>$counttotal,'total'=>$counttotal,'pagesize'=>$pagesize,'totalnum'=>$totalnum,'totalpage'=>$totalpage);
}

function create_html(){
	$type	=	safe_key(getform('type','both'));
	$folder	=	safe_key(getform('folder','both'));
    $sid    =   safe_key(getform('sid','both'));
    $num    =   safe_key(getform('num','both'));
    $page   =   safe_key(getform('page','both'));
	$x=0;
    delfiles(RUN_DIR . 'cache/navlist/','tpl','all');
	if ($folder=='pc'){
		$data = db_load_one('language',"l_onoff=1",'pctemplate,pchtmlpath,sitekeys,sitedesc');
		$template=$data['pctemplate'];
		$htmlpath=$data['pchtmlpath'];
		$htmldir= SITE_DIR.conf('htmldir');	
         if(!defined('WAPPATH')) define('WAPPATH','');
	}else{
		$data = db_load_one('language',"l_onoff=1",'waptemplate,waphtmlpath,sitekeys,sitedesc');
		$template=$data['waptemplate'];  
		$htmlpath=$data['waphtmlpath'];
		$htmldir= SITE_DIR.conf('wappath').conf('htmldir');	
		if(!defined('WAPPATH')) define('WAPPATH',conf('wappath'));
	}
	$GLOBALS['sitekeys']=$data['sitekeys'];
	$GLOBALS['sitedesc']=$data['sitedesc'];	
	define('TPL_PATH', SITE_PATH.'template/'.$folder.'/'.$template);
	define('TPL_DIR', SITE_DIR.'template/'.$folder.'/'.$template.$htmlpath);
	switch($type){
		case 'index':			
			returnmsg('json',1,create_index($htmldir));			
		break;
		case 'brand':
			returnmsg('json',1,create_brand($htmldir,$folder));			
		break;
		case 'about':
			returnmsg('json',1,create_about($htmldir,$folder));
		break;
		case 'content':
			returnmsg('json',1,create_content($htmldir,$folder,$page));
		break;
		case 'list':
			returnmsg('json',1,create_list($htmldir,$folder,$num));
		break;
        case 'tag':
			returnmsg('json',1,create_tag($htmldir,$folder));
		break;
		case 'all':
			create_index($htmldir);$num=1;
			$num+=create_about($htmldir,$folder)['num'];
			$num+=create_brand($htmldir,$folder)['num'];
			$num+=create_tag($htmldir,$folder)['num'];
			$num+=create_content($htmldir,$folder)['num'];
			$num+=create_list($htmldir,$folder)['num'];
			returnmsg('json',1,array('num'=>$num,'total'=>$num));
		break;      
	}
}
	
function save_upload(){
	check_token();
	$uploadmark=getform('uploadmark','post','','0');
	$datefolder=getform('datefolder','post');
	$covermark=getform('covermark','post','','0');
	$imageext=trim(str_replace(array('，','|',' '),',',getform('imageext','post','*','jpg,jpeg,gif,png')),',');
	$imageext=str_replace(array('php','bat','js','.',';'),'',$imageext);
	$imagemaxsize=getform('imagemaxsize','post','','2mb');
	$imageformat=getform('imageformat','post','*','shijian');
	$compresswidth=getform('compresswidth','post','','2000');
	$compressheight=getform('compressheight','post','','2000');
	$compressquality=getform('compressquality','post','','80');
	$fileext=trim(str_replace(array('，','|',' '),',',getform('fileext','post','','pdf,txt,doc,docx,xls,xlsx,zip,rar')),',');
	$fileext=str_replace(array('php','bat','js','.',';'),'',$fileext);
	$filemaxsize=getform('filemaxsize','post','','10mb');
	$fileformat=getform('fileformat','post','','shijian');
	$videoext=trim(str_replace(array('，','|',' '),',',getform('videoext','post','','mp4,flv,swf')),',');
	$videoext=str_replace(array('php','bat','js','.',';'),'',$videoext);
	$videomaxsize=getform('videomaxsize','post','','20mb');
	$videoformat=getform('videoformat','post','','shijian');
	$smallmark=getform('smallmark','post','','0');
	$smallmodel=getform('smallmodel','post','','0');
	$about_mode=getform('about_mode','post','','5');
	$about_width=getform('about_width','post','','500');
	$about_height=getform('about_height','post','','500');
	$about_quality=getform('about_quality','post','','80');
	$brand_mode=getform('brand_mode','post','','5');
	$brand_width=getform('brand_width','post','','500');
	$brand_height=getform('brand_height','post','','500');
	$brand_quality=getform('brand_quality','post','','80');
	$slide_mode=getform('slide_mode','post','','5');
	$slide_width=getform('slide_width','post','','500');
	$slide_height=getform('slide_height','post','','500');
	$slide_quality=getform('slide_quality','post','','80');
	$product_mode=getform('product_mode','post','','5');
	$product_width=getform('product_width','post','','500');
	$product_height=getform('product_height','post','','500');
	$product_quality=getform('product_quality','post','','80');
	$news_mode=getform('news_mode','post','','5');
	$news_width=getform('news_width','post','','500');
	$news_height=getform('news_height','post','','500');
	$news_quality=getform('news_quality','post','','80');
	$job_mode=getform('job_mode','post','','5');
	$job_width=getform('job_width','post','','500');
	$job_height=getform('job_height','post','','500');
	$job_quality=getform('job_quality','post','','80');
	$down_mode=getform('down_mode','post','','5');
	$down_width=getform('down_width','post','','500');
	$down_height=getform('down_height','post','','500');
	$down_quality=getform('down_quality','post','','80');
	$case_mode=getform('case_mode','post','','5');
	$case_width=getform('case_width','post','','500');
	$case_height=getform('case_height','post','','500');
	$case_quality=getform('case_quality','post','','80');
	$video_mode=getform('video_mode','post','','5');
	$video_width=getform('video_width','post','','500');
	$video_height=getform('video_height','post','','500');
	$video_quality=getform('video_quality','post','','80');
	$photo_mode=getform('photo_mode','post','','5');
	$photo_width=getform('photo_width','post','','500');
	$photo_height=getform('photo_height','post','','500');
	$photo_quality=getform('photo_quality','post','','80');

	$watermark=getform('watermark','post','','0');
	$watertype=getform('watertype','post','','0');
	$watermarkfont=getform('watermarkfont','post');
	$watermarkpic=getform('watermarkpic','post');
	$markpicwidth=getform('markpicwidth','post','','100');
	$markpicheight=getform('markpicheight','post','','30');
	$markpicalpha=getform('markpicalpha','post','','0.5');
    $watermarklocation=getform('watermarklocation','post','','0');
    

	$config=array('uploadmark'=>$uploadmark,
				'datefolder'=>$datefolder,
				'covermark'=>$covermark,
				'imageext'=>$imageext,
				'imagemaxsize'=>$imagemaxsize,
				'imageformat'=>$imageformat,
				'compresswidth'=>$compresswidth,
				'compressheight'=>$compressheight,
				'compressquality'=>$compressquality,
				'fileext'=>$fileext,
				'filemaxsize'=>$filemaxsize,
				'fileformat'=>$fileformat,
				'videoext'=>$videoext,
				'videomaxsize'=>$videomaxsize,
				'videoformat'=>$videoformat,
				'smallmark'=>$smallmark,
				'smallmodel'=>$smallmodel,				
				'about_mode'=>$about_mode,
				'about_width'=>$about_width,
				'about_height'=>$about_height,
				'about_quality'=>$about_quality,				
				'brand_mode'=>$brand_mode,
				'brand_width'=>$brand_width,
				'brand_height'=>$brand_height,
				'brand_quality'=>$brand_quality,
				'slide_mode'=>$slide_mode,
				'slide_width'=>$slide_width,
				'slide_height'=>$slide_height,
				'slide_quality'=>$slide_quality,
				'product_mode'=>$product_mode,
				'product_width'=>$product_width,
				'product_height'=>$product_height,
				'product_quality'=>$product_quality,
				'news_mode'=>$news_mode,
				'news_width'=>$news_width,
				'news_height'=>$news_height,
				'news_quality'=>$news_quality,
				'job_mode'=>$job_mode,
				'job_width'=>$job_width,
				'job_height'=>$job_height,
				'job_quality'=>$job_quality,
				'down_mode'=>$down_mode,
				'down_width'=>$down_width,
				'down_height'=>$down_height,
				'down_quality'=>$down_quality,
				'case_mode'=>$case_mode,
				'case_width'=>$case_width,
				'case_height'=>$case_height,
				'case_quality'=>$case_quality,
				'video_mode'=>$video_mode,
				'video_width'=>$video_width,
				'video_height'=>$video_height,
				'video_quality'=>$video_quality,
				'photo_mode'=>$photo_mode,
				'photo_width'=>$photo_width,
				'photo_height'=>$photo_height,
				'photo_quality'=>$photo_quality,
				'watermark'		=>	$watermark	,
				'watertype'		=>	$watertype	,
				'watermarkfont'	=>	$watermarkfont	,
				'watermarkpic'	=>	$watermarkpic	,
				'markpicwidth'	=>	$markpicwidth	,
				'markpicheight'	=>	$markpicheight	,
				'markpicalpha'	=>	$markpicalpha	,
				'watermarklocation'	=>	$watermarklocation	,
		);	
	save_config($config);
	layertruego('修改成功','?act=uploadset','');
}

function try_email(){
	$smtp_server= getform("smtp_server",'post');
	$smtp_mail= getform("smtp_mail",'post');
	$smtp_user= getform("smtp_user",'post');
	$smtp_pass= getform("smtp_pass",'post');	
	$smtp_name= getform("smtp_name",'post');
	$smtp_ssl= getform("smtp_ssl",'post');
	$smtp_port= getform("smtp_port",'post');
	$receive_email= getform("receive_email",'post');
	require_once(PLUG_DIR."phpmailer/class.phpmailer.php"); 
    require_once(PLUG_DIR."phpmailer/class.smtp.php");
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->SMTPAuth=true;
	$mail->SMTPDebug =0;
    $mail->Host =$smtp_server;
    $mail->SMTPSecure =$smtp_ssl;
	$mail->Port =$smtp_port;//设置ssl连接smtp服务器的远程服务器端口号，以前的默认是25，但是现在新的好像已经不可用了 可选465或587
    $mail->CharSet = 'utf-8';//设置发送的邮件的编码 可选GB2312 我喜欢utf-8 据说utf8在某些客户端收信下会乱码
    $mail->FromName = $smtp_name;//设置发件人姓名（昵称） 任意内容，显示在收件人邮件的发件人邮箱地址前的发件人姓名
    $mail->Username =$smtp_user;//smtp登录的账号 这里填入字符串格式的qq号即可
    $mail->Password =$smtp_pass;//smtp登录的密码 使用生成的授权码（就刚才叫你保存的最新的授权码）【非常重要：在网页上登陆邮箱后在设置中去获取此授权码】
    $mail->From = $smtp_mail;//设置发件人邮箱地址 这里填入上述提到的“发件人邮箱”
    $mail->isHTML(true);//邮件正文是否为html编码 注意此处是一个方法 不再是属性 true或false
    //$mail->addAddress($to);//设置收件人邮箱地址
    //设置多个收件人邮箱地址,从数组中获取
	$to=splits($receive_email,',');
    foreach($to as $value){
		if(checkstr($value,'email')===true){
       	 $mail->addAddress($value);// 收件人邮箱地址
		}
    }
	
    $mail->Subject = "这是一封发自zzzcms系统的测试邮件";//添加该邮件的主题
    $mail->Body = "zzzcms是国内一款非常优秀的建站系统,致力于打造最棒的asp建站系统";
    if($mail->send()) {
        echo 'true';
    }else{
        echo 'false';
    }
}

function save_system(){
	$webmode=getform('webmode','post','','0');
	$closeinfo=getform('closeinfo','post');
	$sitepath=getform('sitepath','post','nul','/');
	$adminpath=getform('adminpath','post','nul','admin/');
	$tianqimark=getform('tianqimark','post','','0');
	$isdel=getform('isdel','post','','0');
    $bugmark=getform('bugmark','post','','0');
    $showtime=getform('showtime','post','','0');
	$usermark=getform('usermark','post','','0');
	$ischeckmobile=getform('ischeckmobile','post','','0');
	$ischeckemail=getform('ischeckemail','post','','0');
	$usercode=getform('usercode','post','','0');
	$gbookmark=getform('gbookmark','post','','0');
	$gbookonoff	=getform('gbookonoff','post','','0');
	$gbookcode=getform('gbookcode','post','','0');
	$gbookanonymousnum=getform('gbookanonymousnum','post','','9');
	$gbookusernum=getform('gbookusernum','post','','9');
	$gbookuser=getform('gbookuser','post','','0');
	$gbookname=getform("gbookname","post");
	$gbookname_onoff=getform("gbookname_onoff","post");
	$gbookname_test=getform("gbookname_test","post");
	$gbooktitle=getform("gbooktitle","post");
	$gbooktitle_onoff=getform("gbooktitle_onoff","post");
	$gbooktitle_test=getform("gbooktitle_test","post");
	$gbooktel=getform("gbooktel","post");
	$gbooktel_onoff=getform("gbooktel_onoff","post");
	$gbooktel_test=getform("gbooktel_test","post");
	$gbookmail=getform("gbookmail","post");
	$gbookmail_test=getform("gbookmail_test","post");
	$gbookmail_onoff=getform("gbookmail_onoff","post");
	$gbookcontent=getform("gbookcontent","post");
	$gbookcontent_onoff=getform("gbookcontent_onoff","post");
	$gbookcontent_test=getform("gbookcontent_test","post");
	$wapmark=getform('wapmark','post','','0');
	$wapautogo=getform('wapautogo','post','','0');
	$padautogo=getform('padautogo','post','','0');		

	$mailmark=getform('mailmark','post','','0');
	$smtp_server=getform('smtp_server','post');
	$smtp_mail=getform('smtp_mail','post');
	$smtp_user=getform('smtp_user','post');
	$smtp_pass=getform('smtp_pass','post');
	$smtp_name=getform('smtp_name','post');
	$smtp_ssl=getform('smtp_ssl','post');
	$smtp_port=getform('smtp_port','post');	
	$receive_email=getform('receive_email','post');
	$gbooksendmail=getform('gbooksendmail','post','','0');
	$evalsendmail=getform('evalsendmail','post','','0');
	$regsendmail=getform('regsendmail','post','','0');
	$loginsendmail=getform('loginsendmail','post','','0');
	$forgetsendmail=getform('forgetsendmail','post','','0');
	$smsmark=getform('smsmark','post','','0');
	$smsid=getform('smsid','post');
	$smspw=getform('smspw','post');
	if (strlen($smsid)<5 || strlen($smspw)<32) $smsmark=0;
	$regsendsms=getform('regsendsms','post','','0');
	$forgetsendsms=getform('forgetsendsms','post','','0');
	$textphone=getform('textphone','post');
	$showsql=getform('showsql','post','','0');
	$type=getform('type','post','nul');
	$accesspath=getform('accesspath','post');
	$accessname=getform('accessname','post');
	$sqlitepath=getform('sqlitepath','post');
	$sqlitename=getform('sqlitename','post');
	$host=getform('host','post');
	$port=getform('port','post');
	$name=getform('name','post');
	$user=getform('user','post');
	$password=getform('password','post');
	$config=array('webmode'		=>	$webmode	,
				'closeinfo'		=>	$closeinfo	,
				'sitepath'		=>	$sitepath	,
				'adminpath'		=>	$adminpath	,
				'tianqimark'	=>	$tianqimark	,
				'isdel'			=>	$isdel	,
				'bugmark'		=>	$bugmark	,                  
				'usermark'		=>	$usermark	,
                'showtime'      =>  $showtime   ,
				'ischeckmobile'	=>	$ischeckmobile	,
				'ischeckemail'	=>	$ischeckemail	,
				'usercode'		=>	$usercode	,
				'gbookmark'		=>	$gbookmark	,
				'gbookonoff'	=>	$gbookonoff	,
				'gbookcode'		=>	$gbookcode	,
				'gbookanonymousnum'	=>	$gbookanonymousnum	,
				'gbookusernum'	=>	$gbookusernum	,
				'gbookuser'		=>	$gbookuser	,
				'gbookname'		=>$gbookname,
				'gbookname_onoff'=>$gbookname_onoff,
				'gbookname_test'=>$gbookname_test,
				'gbooktitle'		=>$gbooktitle,
				'gbooktitle_onoff'=>$gbooktitle_onoff,
				'gbooktitle_test'=>$gbooktitle_test,
				'gbooktel'		=>$gbooktel,
				'gbooktel_onoff'=>$gbooktel_onoff,
				'gbooktel_test'=>$gbooktel_test,
				'gbookmail'		=>$gbookmail,
				'gbookmail_test'=>$gbookmail_test,
				'gbookmail_onoff'=>$gbookmail_onoff,
				'gbookcontent'	=>$gbookcontent,
				'gbookcontent_onoff'=>$gbookcontent_onoff,
				'gbookcontent_test'=>$gbookcontent_test,

				'wapmark'		=>	$wapmark	,
				'wapautogo'		=>	$wapautogo	,
				'padautogo'		=>	$padautogo	,  				
				'mailmark'		=>	$mailmark	,
				'smtp_server'	=>	$smtp_server	,
				'smtp_mail'		=>	$smtp_mail	,
				'smtp_user'		=>	$smtp_user	,
				'smtp_pass'		=>	$smtp_pass	,
				'smtp_name'		=>	$smtp_name,
				'smtp_ssl'		=>	$smtp_ssl,
				'smtp_port'		=>	$smtp_port,				
				'receive_email'	=>	$receive_email	,
				'gbooksendmail'	=>	$gbooksendmail	,
				'evalsendmail'	=>	$evalsendmail	,
				'regsendmail'	=>	$regsendmail	,
				'loginsendmail'	=>	$loginsendmail	,
				'forgetsendmail'=>	$forgetsendmail	,
				'smsmark'		=>	$smsmark	,
				'smsid'			=>	$smsid	,
				'smspw'			=>	$smspw	,
				'regsendsms'	=>	$regsendsms	,
				'forgetsendsms'	=>	$forgetsendsms	,
				'textphone'		=>	$textphone	,
				'showsql'		=>	$showsql	, 
				'type'			=>	$type	,
				'accesspath'	=>	$accesspath	,
				'accessname'	=>	$accessname	,
				'sqlitepath'	=>	$sqlitepath	,
				'sqlitename'	=>	$sqlitename	,
				'host'			=>	$host	,
				'port'			=>	$port	,
				'name'			=>	$name				
 	 );
	save_config($config);
	layertruego('修改成功','?act=systemedit','');
}

function settemplate(){
	$folder=safe_word(getform('folder','get'));
	$type=safe_word(getform('type','get'));
	if ($type=='pc'){
		$update=array('pctemplate'=>$folder.'/');
		db_update('language','IsDefault=1',$update);
	}elseif ($type=='wap'){
		$update=array('waptemplate'=>$folder.'/');
		db_update('language','IsDefault=1',$update);
	}
	reload();
}
function setqqkf(){	
    $id=safe_word(getform('id','post'));
	$pctemplate=safe_key(getform('pctemplate','post'));
	$pchtmlpath=safe_key(getform('pchtmlpath','post'));
	$foothtml=load_file(SITE_DIR.'template/pc/'.$pctemplate.$pchtmlpath.'foot.html');
	$foothtml=preg_replace("/\{zzz:qqkf[0-9]\}/","",$foothtml);
	if ($id){
		create_file(SITE_DIR.'template/pc/'.$pctemplate.$pchtmlpath.'foot.html',$foothtml."{zzz:qqkf".$id."}");
	}else{
		create_file(SITE_DIR.'template/pc/'.$pctemplate.$pchtmlpath.'foot.html',$foothtml);
	}
}
?>