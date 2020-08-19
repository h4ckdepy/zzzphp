<?php
require '../inc/zzz_admin.php';
check_admin('die');
$act=safe_word(getform('act','get','nul'));
$id=safe_key(getform('id','both'));
$table=safe_word(getform('table','post'));
$type=safe_word(getform('type','both'));
$limit=safe_word(getform('limit','post'));
$offset=safe_word(getform('offset','post'));
$sort=safe_key(getform('sort','post'));
$order=safe_word(getform('order','post'));
$GLOBALS['search']=$search=getform('search','post');
$page= $offset>0 ?  $offset/ $limit+1 : 0;
switch ($act) {
	case 'aboutlist':
		echo aboutlist(); 
		break;
	case 'adlist':
		echo adlist(); 
		break;		
	case 'brandlist':
		echo brandlist(); 
		break;
	case 'contentlist':
		echo contentlist(); 
		break;
	case 'customlist':
		echo customlist(); 
		break;	
	case 'linkslist':
		echo linkslist(); 
		break;
	case 'gbooklist':
		echo gbooklist(); 
		break;
	case 'taglist':
		echo taglist(); 
		break;	
	case 'sortlist':
		echo sortlist($id); 
		break;			
	case 'recylist':
		echo recylist(); 
		break;	
	case 'slidelist':
		echo slidelist(); 
		break;		
	case 'modellist':
		echo modellist(); 
		break;	
	case 'labelslist':
		echo labelslist(); 
		break;	
	case 'userlist':
		echo userlist(); 
		break;	
	case 'usergroup':
		echo usergroup(); 
		break;		
	case 'adminlist':
		echo adminlist(); 
		break;	
	case 'admingroup':
		echo admingroup(); 
		break;			
	case 'imagelist':
		echo imagelist(); 
		break;
	case 'downlist':
		echo downlist(); 
		break;	
	case 'templatelist':
		echo filelist('template'); 
		break;
	case 'uploadlist':
		echo filelist('upload'); 
		break;
	case 'htmllist':
		echo filelist('html'); 
		break;
	case 'cachelist':
		echo filelist('cache'); 
		break;	
	case 'databackup':	
		echo filelist('data'); 
		break;
	case 'dbbacklist':	
		echo dbbacklist(); 
		break;
	case 'dbsqllist':	
		echo filelist('log'); 
		break;	
	case 'errlist':	
		echo filelist('error'); 
		break;			
	case 'selectsort':
		echo select_sort_content($type,$id); 
		break;	
	case 'pinyin':
		echo pinyin($sort);
		break;	
	case 'checkname':
		echo dbcount('content',"c_pagename='".$sort."'");
		break;	
	case 'gettag':
		echo( tojson(db_load('tag',array('t_onoff'=>1),'t_name')));
		break;
}
function aboutlist(){
	$arr = array();$where='';$i=0;
	$aid=getform('aid','get');
	$sid=getform('sid','get');
	if ($sid)  $where='where a_sid='.$sid;
	$data=db_load_sql("select aid,a_name,a_sid,a_enname,a_visits,a_order,a_onoff,a_addtime,a_edittime,(select s_name from [dbpre]sort where sid=a_sid) as sname,(select count(*) from [dbpre]sort where sid=a_sid and s_type='about') as num from [dbpre]about ". $where." order by a_order asc, aid asc");	
	foreach ($data as $value) {
		$i=$value['aid'];
		 if( $value['num']>0){
		array_push($arr,array(
			'id' =>$i,
			'sid' => $value['a_sid'],
			'sname'=> $value['sname'].'<a href='.getsortlink('about',$value['a_sid'],'').' target="_blank"><i class="fa fa-external-link"></i></a>',		
			'a_name'=> '<input type="text" class="title" id="a_name-'.$i.'" placeholder="'.$value['a_name'].'" value="'.$value['a_name'].'"> ',			
			'a_enname'=> '<input type="text" class="title" id="a_enname-'.$i.'" placeholder="'.$value['a_enname'].'" value="'.$value['a_enname'].'">',
			'a_order'=> '<input type="number" class="order" id="a_order-'.$i.'" placeholder="'.$value['a_order'].'" value="'.$value['a_order'].'">',
			'a_onoff'=> $value['a_onoff']==1 ? 'ON' : 'OFF',
			'edit' => '<button type="button" class="btn btn-info dim" onclick="opennew(\'?act=about&aid='.$value['aid'].'\')"><i class="fa fa-pencil"></i></button> '		
			));
		}
	}
	return tojson($arr);
}

function sortlist($pid){
	$arr = array();
	$count	=	db_count("sort");	
	$data=db_load_sql('select t.*,model_type,model_name,model_table,(select count(*) from [dbpre]sort where s_pid=t.sid and (s_onoff=0 or s_onoff=1)) as c from [dbpre]model as a,[dbpre]sort t where s_type=model_type and (s_onoff=0 or s_onoff=1) and s_pid='.$pid.' order by s_order asc , sid asc');
	foreach ($data as $value) {
		$value=array_change_key_case($value);
		if($count>conf('sortsize')&&$value['c']>0){
			$open='<a class="open" data-id="'.$value['sid'].'"  data-level="'.$value['s_level'].'" id="tid'.$value['sid'].'"><i class="S_Level Level1"></i></a>';		
		}elseif ($value['c']>0){
			$open='<i class="S_Level onLevel'.$value['s_level'].'" title="'.$value['s_level'].'级分类"></i>';
		}else{
			$open='<i class="S_Level Level'.$value['s_level'].'" title="'.$value['s_level'].'级分类"></i>';
		}		
		$i=$value['sid'];
		$stype=$value['s_type'];
		$sortlink=' <a href='.getsortlink($value['s_type'],$i,$value['s_filename'],$value['s_url']).' target="_blank"><i class="fa fa-external-link"></i></a>';
		if ($value['s_onoff']==1){
			$edit='<button type="button" class="btn btn-success dim" onclick=opennew(\'?act=sort&pid='.$value['sid'].'\')><i class="fa fa-plus"></i></button> <button type="button" class="btn btn-info dim" onclick="opennew(\'?act=sort&pid='.$value['s_pid'].'&sid='.$value['sid'].'\')"><i class="fa fa-pencil"></i></button> ';
		}else{
			$edit='';
		}
		if ($value['s_type']=='links'){
			$surl='<input type="text" class="title" id="s_url-'.$i.'" placeholder="'.$value['s_url'].'" value="'.$value['s_url'].'">';
		}else{
			$surl='<input type="text" class="title" id="s_filename-'.$i.'" placeholder="'.$value['s_filename'].'" value="'.$value['s_filename'].'">';
		}
		$del= conf("isdel")==0 ? '<button type="button" class="btn btn-warning dim" onclick="removesort('.$i.')"><i class="fa fa-trash"></i></button>' :'<button type="button" class="btn btn-danger dim" onclick="delsort('.$i.',\'sort\')"><i class="fa fa-times"></i></button> ';
		array_push($arr,array(
			'id' => $value['sid'],
			'num' => $open,
			's_name'=> '<input type="text" class="title" id="s_name-'.$i.'" placeholder="'.$value['s_name'].'" value="'.$value['s_name'].'">',
			's_enname'=> '<input type="text" class="title" id="s_enname-'.$i.'" placeholder="'.$value['s_enname'].'" value="'.$value['s_enname'].'">',
			'model_name'=> $value['model_name'].$sortlink,
			's_url'=>$surl ,
			's_order'=> '<input type="number" class="order" id="s_order-'.$i.'" placeholder="'.$value['s_order'].'" value="'.$value['s_order'].'">',
			's_onoff'=> '<button type="button" class="btn btn-'.$value['s_onoff'].' dim" onclick=setcol("s_onoff","'.abs($value['s_onoff']-1).'","'.$i.'") id="'.$i.'s_onoff"  ><i class="fa fa-toggle-on"></i></button>',			
			'edit' =>$edit.$del
			));
			
		if ($count<conf('sortsize')&&$value['c']>0) $arr=subsort($arr,$value['sid']);
	}
	//echop($arr);
	return tojson($arr);
}
function subsort($arr ,$pid){	
	$data=db_load_sql('select t.*,model_type,model_name,model_table,(select count(*) from [dbpre]sort where s_pid=t.sid  and (s_onoff=0 or s_onoff=1) ) as c from [dbpre]model as a,[dbpre]sort t where s_type=model_type  and (s_onoff=0 or s_onoff=1) and s_pid='.$pid.' order by s_order asc , sid asc');
	foreach ($data as $key=>$value) {
		$value=array_change_key_case($value);
		if($value['c']>0 ){
			$open='<i class="S_Level onLevel'.$value['s_level'].'" title="'.$value['s_level'].'级分类">Parent1</i></a>';
		}else{
			if($key==(count($data)-1)){
				$open='<i class="S_Level Levelend Level'.$value['s_level'].'" title="'.$value['s_level'].'级分类">Parent1</i>';
			}else{
				$open='<i class="S_Level Level'.$value['s_level'].'" title="'.$value['s_level'].'级分类">Parent1</i>';
			}
		}
		$i=$value['sid'];
		$stype=$value['s_type'];
		$sortlink=' <a href='.getsortlink($value['s_type'],$i,$value['s_filename'],$value['s_url']).' target="_blank"><i class="fa fa-external-link"></i></a>';
		if ($value['s_onoff']==1){
		$edit='<button type="button" class="btn btn-success dim" onclick=opennew(\'?act=sort&pid='.$value['sid'].'&sid=0\')><i class="fa fa-plus"></i></button> 
        <button type="button" class="btn btn-info dim" onclick="opennew(\'?act=sort&pid='.$value['s_pid'].'&sid='.$value['sid'].'\')"><i class="fa fa-pencil"></i></button> ';
		}else{
			$edit='';
		}
		if ($value['s_type']=='links'){
			$surl='<input type="text" class="title" id="s_url-'.$i.'" placeholder="'.$value['s_url'].'" value="'.$value['s_url'].'">';
		}else{
			$surl='<input type="text" class="title" id="s_filename-'.$i.'" placeholder="'.$value['s_filename'].'" value="'.$value['s_filename'].'">';
		}
		array_push($arr,array(
			'id' => $value['sid'],
			'num' => $open,
			's_name'=> '<input type="text" class="title" id="s_name-'.$i.'" placeholder="'.$value['s_name'].'" value="'.$value['s_name'].'">',
			's_enname'=> '<input type="text" class="title" id="s_enname-'.$i.'" placeholder="'.$value['s_enname'].'" value="'.$value['s_enname'].'">',
			'model_name'=> $value['model_name'].$sortlink,
			's_url'=>$surl ,
			's_order'=> '<input type="number" class="order" id="s_order-'.$i.'" placeholder="'.$value['s_order'].'" value="'.$value['s_order'].'">',
			's_onoff'=> '<button type="button" class="btn btn-'.$value['s_onoff'].' dim" onclick=setcol("s_onoff","'.abs($value['s_onoff']-1).'","'.$i.'") id="'.$i.'s_onoff" ><i class="fa fa-toggle-on"></i></button>',
			'edit' => conf("isdel")==0 ? $edit.'<button type="button" class="btn btn-warning dim" onclick="removesort('.$i.')"><i class="fa fa-trash"></i></button>' : $edit.'<button type="button" class="btn btn-danger dim" onclick="delsort('.$i.',\'sort\')"><i class="fa fa-times"></i></button> '
			));
		if ($value['c']>0)  $arr=subsort($arr,$value['sid']);
	}
	return ($arr);
}

function adlist(){
	$arr = array();$where='';$i=0;$adclass='';
	$data=db_load("ad",$where,"adid,adname,adclass,adlink,adetime,adonoff,adstyle");
	$adlist=dir_list(PLUG_PATH.'ad');
	foreach ($data as $value) {
		$i=$value['adid'];
		array_push($arr,array(
			'id' => $value['adid'],
			'ad' => "{zzz:ad".$value['adid']."}",
			'adname'=> '<input type="text" class="title" id="adname-'.$i.'" placeholder="'.$value['adname'].'" value="'.$value['adname'].'">',			
			'adclass'=> ad_name($value['adclass']),
			'adlink'=> '<input type="text" class="title" id="adlink-'.$i.'" placeholder="'.$value['adlink'].'" value="'.$value['adlink'].'">',	
			'adstime'=> $value['adstime'],		
			'adetime'=> $value['adetime'],			
			'adonoff'=> "<button type='button'  onclick=setcol('adonoff',".abs($value['adonoff']-1).",'".$i."')  id='".$i."adonoff' class='btn btn-".$value["adonoff"]."  dim'><i class='fa fa-toggle-on'></i></button>",	
			'edit' => '<button type="button" class="btn btn-info dim" onclick="opennew(\'?act=ad&id='.$i.'\')"><i class="fa fa-pencil"></i></button> <button type="button" class="btn btn-danger dim" onclick="delid('.$i.',\'ad\')"><i class="fa fa-times"></i></button>'
			));
	}
	return tojson($arr);
}

function brandlist(){
	$arr = array();$i=0;
	$data=db_load("brand",'','bid,b_name,b_enname,b_type,b_filename,b_visits,b_order,b_onoff,b_addtime,b_edittime');
	foreach ($data as $value) {
		$i=$value['bid'];
		array_push($arr,array(
			'id' => $value['bid'],
			'b_name'=> '<input type="text" class="title" id="b_name-'.$i.'" placeholder="'.$value['b_name'].'" value="'.$value['b_name'].'">',
			'b_enname'=> '<input type="text" class="title" id="b_enname-'.$i.'" placeholder="'.$value['b_enname'].'" value="'.$value['b_enname'].'">',
			'b_type'=> '<input type="text" class="title" id="b_type-'.$i.'" placeholder="'.$value['b_type'].'" value="'.$value['b_type'].'">',
			'b_filename'=> '<input type="text" class="name" id="b_filename-'.$i.'" placeholder="'.$value['b_filename'].'" value="'.$value['b_filename'].'">
			<a href='.getbrandlink('',$value['bid'],$value['b_filename']).' target="_blank"><i class="fa fa-external-link"></i></a>',
			'b_order'=> '<input type="number" class="order" id="b_order-'.$i.'" placeholder="'.$value['b_order'].'" value="'.$value['b_order'].'">',
			'b_onoff'=> "<button type='button'  onclick=setcol('b_onoff','".$i."')  id='".$i."b_onoff' class='btn btn-".$value["b_onoff"]."  dim'><i class='fa fa-toggle-on'></i></button>",
			'edit' => '<button type="button" class="btn btn-info dim" onclick="opennew(\'?act=brand&id='.$i.'\')"><i class="fa fa-pencil"></i></button> <button type="button" class="btn btn-danger dim" onclick="delid('.$i.',\'brand\')"><i class="fa fa-times"></i></button>'
			));
	}
	return tojson($arr);
}

function contentlist(){
	$arr = array();$i=0;$where=array();$sort=G('sort');$search=G('search');$limit=G('limit');$page=G('page');$order=G('order');$sid=G('id');$type=G('type');
	switch ($sort){
		case 'id' :
		$orderby=array('cid'=>$order);
		break;
		case '':		
		$orderby=array('cid'=>'desc');
		break;
		default:
		$orderby=array($sort=>$order,'cid'=>'desc');
	}
	if (!$sort)		$orderby=array('istop'=>1,'isgood'=>1,'c_order'=>'asc','c_addtime'=>'desc','cid'=>'desc');		
	if ($type)		$where=array('c_onoff'=>array(0,1),'c_type'=> $type);	
	if ($sid)		$where=array('c_onoff'=>array(0,1),'c_sid'=>db_subsort($sid));
	if ($search)	$where=array('c_onoff'=>array(0,1),'c_title'=>array('LIKE'=>$search));	
	if (!$where)	return false;
	$count	=	db_count	("content",$where);	
	arr_add($where,'sid',array('='=>'c_sid'));
	$data	=	db_load	("content c,sort s",$where,'c.*,s.s_filename,s.s_url,s.s_name,s.s_enname',$limit,$orderby,$page);	
	foreach ($data as $value) {
		$value=array_change_key_case($value);
		$value['ispic']==1 ? $picstr=' <a onclick="$.fancybox([\''.repkong(str_replace(",","','",$value['c_picsurl'])).'\']);" class="lightbox"><i class="fa fa-photo"></i></a>' : $picstr='';
		$contentlink=' <a href="'.getcontentlink($value['cid'],$value['c_pagename'],$value['c_type'],$value['c_link']).'" target="_blank"><i class="fa fa-external-link"></i></a>';
		$i=$value['cid'];
		$price=isset($value['zprice']) ? $value['zprice'] : 0;
		$edit ='<button type="button" class="btn btn-info dim" onclick="opennew(\'?act=content&cid='.$i.'\')"><i class="fa fa-pencil"></i></button>';
		array_push($arr,array(
			'id' => $i,
			'link' => $picstr .$contentlink,			
			'c_title'=> '<input type="text" class="title" id="c_title-'.$i.'" placeholder="'.$value['c_title'].'" value="'.$value['c_title'].'">',	
			'c_sid'=> '<span id="sid'.$value['c_sid'].'">'.$value['s_name'].'</span>',
			'c_addtime'=> '<a onclick="setjeDate(this,'.$i.');" title="双击可修改">'.$value['c_addtime'].'</a>',
			'zprice'=> '<input type="number" class="order" id="zprice-'.$i.'" placeholder="'.$price.'" value="'.$price.'">',
			'c_order'=> '<input type="number" class="order" id="c_order-'.$i.'" placeholder="'.$value['c_order'].'" value="'.$value['c_order'].'">',
			'c_onoff'=> '<button type="button" onclick=setcol("c_onoff",'.abs($value['c_onoff']-1).',"'.$i.'") id="'.$i.'c_onoff" class="btn btn-'.$value['c_onoff'].'  dim"><i class="fa fa-toggle-on"></i></button>',
			'istop'=>			
				'<button type="button"  onclick=setcol("istop",'.abs($value['istop']-1).',"'.$i.'") id="'.$i.'istop" class="btn btn-'.$value['istop'].' dim"><i class="fa fa-thumb-tack"></i></button>'.
				'<button type="button"  onclick=setcol("isgood",'.abs($value['isgood']-1).',"'.$i.'") id="'.$i.'isgood" class="btn btn-'.$value['isgood'].' dim"><i class="fa fa-thumbs-up"></i></button>',				
			'edit' => conf("isdel")==0 ? $edit.'<button type="button" class="btn btn-warning dim" onclick="remove('.$i.',\'content\')"><i class="fa fa-trash"></i></button>' : $edit.'<button type="button" class="btn btn-danger dim" onclick="delid('.$i.',\'content\')"><i class="fa fa-times"></i></button>'
			));
	}
	return '{"total":'.$count.',"rows":'.tojson($arr).'}';
}

function recylist(){
	$arr = array();$i=0;$type=G('type');
	if ($type=='content'){
		$data	=	db_load	($type,array('c_onoff'=>2),'cid,c_title,c_type,c_addtime');
	}elseif($type=='sort'){
		$data	=	db_load	($type,array('s_onoff'=>2),'sid,s_name,s_type,s_addtime');
	}
	if (isset($data)){
		$count=count($data);
		foreach (array_values($data) as $value) {
			$value=array_values($value);
			array_push($arr,array(
				'id' =>$value[0],
				'title'=> $value[1],
				'type'=> $value[2],
				'time'=> $value[3],
				'edit' => '<button type="button" class="btn btn-primary dim" onclick="recovery('.$value[0].',\''.$type.'\')"><i class="fa fa-undo"></i></button> <button type="button" class="btn btn-danger dim" onclick="delid('.$value[0].',\''.$type.'\')"><i class="fa fa-remove"></i></button> '
			));
		}
	return tojson($arr);
	}
}

function linkslist(){
	$arr = array();$i=0;
	$data=db_load("links",'','lid,l_name,l_cid,l_type,l_desc,l_pic,l_url,l_order,l_onoff');	
	foreach ($data as $value) {
		$i=$value['lid'];
		array_push($arr,array(
			'id' => $value['lid'],
			'l_name'=> '<input type="text" class="title" id="l_name-'.$i.'" placeholder="'.$value['l_name'].'" value="'.$value['l_name'].'">',	
			'l_cid'=> '<input type="text" class="title" id="l_cid-'.$i.'" placeholder="'.$value['l_cid'].'" value="'.$value['l_cid'].'">',	
			'l_type'=> '<input type="text" class="title" id="l_type-'.$i.'" placeholder="'.$value['l_type'].'" value="'.$value['l_type'].'">',	
			'l_pic'=> '<input type="text" class="title" id="l_pic-'.$i.'" placeholder="'.$value['l_pic'].'" value="'.$value['l_pic'].'">',		
			'l_url'=> '<input type="text" class="title" id="l_url-'.$i.'" placeholder="'.$value['l_url'].'" value="'.$value['l_url'].'">',		
			'l_order'=> '<input type="number" class="order" id="l_order-'.$i.'" placeholder="'.$value['l_order'].'" value="'.$value['l_order'].'">',
			'l_onoff'=> '<button type="button"  onclick=setcol("l_onoff",'.abs($value['l_onoff']-1).','.$i.')  id="'.$i.'.l_onoff"  class="btn btn-'.$value["l_onoff"].' dim"><i class="fa fa-toggle-on"></i></button>',	
			'edit' => '<button type="button" class="btn btn-info dim" onclick="opennew(\'?act=links&id='.$value['lid'].'\')"><i class="fa fa-pencil"></i></button> <button type="button" class="btn btn-danger dim" onclick="delid('.$value['lid'].',\'links\')"><i class="fa fa-times"></i></button>'
			));
	}	
	return tojson($arr);
}

function taglist(){
	$arr = array();$i=0;
	$data=db_load_sql("select tid,t_name,t_enname,t_type,t_visits,t_onoff,t_order,t_addtime,t_edittime from [dbpre]tag");
	foreach ($data as $value) {
		$i=$value['tid'];
		array_push($arr,array(
			'id' => $value['tid'],
			't_name'=> $value['t_name'],	
			't_enname'=> '<input type="text" class="title" id="t_enname-'.$i.'" placeholder="'.$value['t_enname'].'" value="'.$value['t_enname'].'">',	
			't_count'=> db_count('content',array('c_tag'=>array('LIKE'=>$value['t_name']))),	
			't_visits'=> '<input type="text" class="title" id="t_visits-'.$i.'" placeholder="'.$value['t_visits'].'" value="'.$value['t_visits'].'">',		
			't_order'=> '<input type="number" class="order" id="t_order-'.$i.'" placeholder="'.$value['t_order'].'" value="'.$value['t_order'].'">',
			't_onoff'=> "<button type='button'  onclick=setcol('t_onoff',".abs($value['t_onoff']-1).",'".$i."') id='".$i."t_onoff' class='btn btn-".$value["t_onoff"]."  dim'><i class='fa fa-toggle-on'></i></button>",	
			'edit' => '<button type="button" class="btn btn-info dim" onclick="opennew(\'?act=tag&id='.$value['tid'].'\')"><i class="fa fa-pencil"></i></button> <button type="button" class="btn btn-danger dim" onclick="delid('.$value['tid'].',\'tag\')"><i class="fa fa-times"></i></button>'
			));
	}
	return tojson($arr);
}



function labelslist(){
	$arr = array();
	$data=db_load('labels','','labelid,label_title,label_entitle,label_name,label_onoff,label_order,label_pic');
	foreach ($data as $value) {
		$i=$value['labelid'];
		array_push($arr,array(
		'id' => $i,
		'label_title'=> "<input type='text' class='title' id='label_title-".$i."' placeholder='".$value["label_title"]."'  value='".$value["label_title"]."'>",
		'label_entitle'=> "<input type='text' class='title' id='label_entitle-".$i."' placeholder='".$value["label_entitle"]."'  value='".$value["label_entitle"]."'>",
		'label_name'=> "<input type='text' class='title' id='label_name-".$i."' placeholder='".$value["label_name"]."'  value='".$value["label_name"]."'>",
		'label_pic'=> "<input type='text' class='title'  id='label_pic-".$i."' placeholder='".$value["label_pic"]."'  value='".$value["label_pic"]."'>",	
		'label_order'=> "<input type='number' class='order' id='label_order-".$i."' placeholder='".$value["label_order"]."'  value='".$value["label_order"]."'>",
		'label_onoff'=> "<button type='button'  onclick=setcol('label_onoff',".abs($value['label_onoff']-1).",'".$i."') id='".$i."label_onoff' class='btn btn-".$value["label_onoff"]."  dim'><i class='fa fa-toggle-on'></i></button>",	
		'edit'=> "<button type='button' class='btn btn-info dim' onclick=opennew('?act=labels&id=".$i."')><i class='fa fa-pencil'></i></button> <button type='button'  onclick=delid('".$i."','labels')  class='btn btn-danger dim'><i class='fa fa-times'></i></button>"
			   
		));
	}
	return tojson($arr);
}

function userlist(){
	$arr = array();$whereStr='';
	$data=db_load_sql('select * from [dbpre]user,[dbpre]user_group where U_GID=GID and IsAdmin=0');	
	foreach ($data as $value) {
		$value=array_change_key_case($value);
		$i=$value['uid'];
		array_push($arr,array(
		'id' => $i,
		'username'=>$value["username"],
		'gname'=>$value["g_name"],
		'truename'=> "<input type='text' class='title' id='truename-".$i."' placeholder='".$value["truename"]."'  value='".$value["truename"]."'>",
		'mobile'=> "<input type='text' class='title' id='mobile-".$i."' placeholder='".$value["mobile"]."'  value='".$value["mobile"]."'>",
		'email'=> "<input type='text' class='title'  id='email-".$i."' placeholder='".$value["email"]."'  value='".$value["email"]."'>",	
		'lastlogintime'=>$value["lastlogintime"],
		'u_order'=> "<input type='number' class='order' id='u_order-".$i."' placeholder='".$value["u_order"]."'  value='".$value["u_order"]."'>",
		'u_onoff'=> "<button type='button'  onclick=setcol('u_onoff',".abs($value['u_onoff']-1).",'".$i."')  id='".$i."u_onoff' class='btn btn-".$value["u_onoff"]."  dim'><i class='fa fa-toggle-on'></i></button>",	
		'edit'=> "<button type='button' class='btn btn-info dim' onclick=opennew('?act=user&id=".$i."')><i class='fa fa-pencil'></i></button> <button type='button'  onclick=delid('".$i."','user')  class='btn btn-danger dim'><i class='fa fa-times'></i></button>"
			   
		));
	}
	return tojson($arr);
}

function adminlist(){
	$arr = array();
	$data=db_load_sql('select * from [dbpre]user,[dbpre]user_group where U_GID=GID and IsAdmin=1  and g_mark<='.get_session("adminmark").' order by U_order asc, UID desc');	
	foreach ($data as $value) {
		$value=array_change_key_case($value);
		$i=$value['uid'];
		if($i!=get_session('adminid')){ 
			$onoff="<button type='button'  onclick=setcol('u_onoff',".abs($value['u_onoff']-1).",'".$i."') id='".$i."u_onoff' class='btn btn-".$value["u_onoff"]."  dim'><i class='fa fa-toggle-on'></i></button>";
			$del="<button type='button'  onclick=delid('".$i."','user')  class='btn btn-danger dim'><i class='fa fa-times'></i></button>";
		}else{
			$onoff="<button type='button'  class='btn btn-".$value["u_onoff"]."  dim'><i class='fa fa-toggle-on'></i></button>";
			$del="";
		}		
		$face=lenstr($value["face"])>11 ?  $value["face"] : "../plugins/face/". $value['face'];
		array_push($arr,array(
		'id' => $i,
		'username'=>$value["username"],
		'userface'=>"<img src='".$face."' height='25'>",
		'usergroup'=>$value["g_name"],
		'truename'=> "<input type='text' class='title' id='truename-".$i."' placeholder='".$value["truename"]."'  value='".$value["truename"]."'>",		
		'lastlogintime'=>$value["lastlogintime"],
		'u_order'=> "<input type='number' class='order' id='u_order-".$i."' placeholder='".$value["u_order"]."'  value='".$value["u_order"]."'>",
		'u_onoff'=> $onoff,	
		'edit'=> "<button type='button' class='btn btn-info dim' onclick=opennew('?act=admin&uid=".$i."')><i class='fa fa-pencil'></i></button> ".$del		   
		));
	}
	return tojson($arr);
}

function admingroup(){
	$arr = array();
	$data=db_load_sql("select * from [dbpre]user_group  where isadmin=1 and g_mark<=".get_session("adminmark")." order by g_order asc, gid desc");	
	foreach ($data as $value) {
		$value=array_change_key_case($value);
		$i=$value['gid'];
		if($i!=get_session('admingid')){ 
			$onoff="<button type='button'  onclick=setcol('g_onoff',".abs($value['g_onoff']-1).",'".$i."') id='".$i."g_onoff' class='btn btn-".$value["g_onoff"]."  dim'><i class='fa fa-toggle-on'></i></button>";
			$del="<button type='button'  onclick=delid('".$i."','user_group')  class='btn btn-danger dim'><i class='fa fa-times'></i></button>";
		}else{
			$onoff="<button type='button'  class='btn btn-".$value["g_onoff"]."  dim'><i class='fa fa-toggle-on'></i></button>";
			$del="";
		}		
		array_push($arr,array(
		'id' => $i,
		'g_name'=> "<input type='text' class='title' id='g_name-".$i."' placeholder='".$value["g_name"]."'  value='".$value["g_name"]."'>",	
		'g_mark'=> "<input type='text' class='title' id='g_mark-".$i."' placeholder='".$value["g_mark"]."'  value='".$value["g_mark"]."'>",			
		'g_desc'=> "<input type='text' class='title' id='g_desc-".$i."' placeholder='".$value["g_desc"]."'  value='".$value["g_desc"]."'>",		
		'g_order'=> "<input type='number' class='order' id='g_order-".$i."' placeholder='".$value["g_order"]."'  value='".$value["g_order"]."'>",
		'g_onoff'=> $onoff,	
		'edit'=> "<button type='button' class='btn btn-info dim' onclick=opennew('?act=admingroup&gid=".$i."')><i class='fa fa-pencil'></i></button> ".$del		   
		));
	}
	return tojson($arr);
}
function usergroup(){
	$arr = array();
	$data=db_load_sql("select * from [dbpre]user_group  where isadmin=0 order by g_order asc, gid desc");	
	foreach ($data as $value) {
		$value=array_change_key_case($value);
		$i=$value['gid'];
		array_push($arr,array(
		'id' => $i,
		'g_name'=> "<input type='text' class='title' id='g_name-".$i."' placeholder='".$value["g_name"]."'  value='".$value["g_name"]."'>",	
		'g_mark'=> "<input type='text' class='type' id='g_mark-".$i."' placeholder='".$value["g_mark"]."'  value='".$value["g_mark"]."'>",			
		'g_desc'=> "<input type='text' class='title' id='g_desc-".$i."' placeholder='".$value["g_desc"]."'  value='".$value["g_desc"]."'>",		
		'g_order'=> "<input type='number' class='order' id='g_order-".$i."' placeholder='".$value["g_order"]."'  value='".$value["g_order"]."'>",
		'g_onoff'=> "<button type='button'  onclick=setcol('g_onoff',".abs($value['g_onoff']-1).",'".$i."') id='".$i."g_onoff' class='btn btn-".$value["g_onoff"]."  dim'><i class='fa fa-toggle-on'></i></button>",	
		'edit'=> "<button type='button' class='btn btn-info dim' onclick=opennew('?act=usergroup&gid=".$i."')><i class='fa fa-pencil'></i></button> <button type='button'  onclick=delid('".$i."','user_group')  class='btn btn-danger dim'><i class='fa fa-times'></i></button>"			   
		));
	}
	return tojson($arr);
}


function slidelist(){
	$arr = array();
	$data=db_load('slide','','slideid,slidename,slidetitle1,slidetitle2,slideclass,slideimg,slidelink,slidewidth,slideheight,slideonoff,slideorder,slidecontent,slidedtime,lid,slidestyle');
	foreach ($data as $value) {
		$i=$value['slideid'];
		array_push($arr,array(
		'id' => $i,
		'slidename'=> "<input type='text' class='title' id='slidename-".$i."' placeholder='".$value["slidename"]."'  value='".$value["slidename"]."'>",
		'slideclass'=> "<input type='text' class='order' id='slideclass-".$i."' placeholder='".$value["slideclass"]."'  value='".$value["slideclass"]."'>",
		'slideimg'=> "<input type='text' class='title' id='slideimg-".$i."' placeholder='".$value["slideimg"]."'  value='".$value["slideimg"]."'>",
		'slidelink'=> "<input type='text' class='title'  id='slidelink-".$i."' placeholder='".$value["slidelink"]."'  value='".$value["slidelink"]."'>",	
		'slideorder'=> "<input type='number' class='order' id='slideorder-".$i."' placeholder='".$value["slideorder"]."'  value='".$value["slideorder"]."'>",
		'slideonoff'=> "<button type='button'  onclick=setcol('slideonoff',".abs($value['slideonoff']-1).",'".$i."')  id='".$i."slideonoff' class='btn btn-".$value["slideonoff"]."  dim'><i class='fa fa-toggle-on'></i></button>",	
		'edit'=> "<button type='button' class='btn btn-info dim' onclick=opennew('?act=slide&id=".$i."')><i class='fa fa-pencil'></i></button> <button type='button'  onclick=delid('".$i."','slide')  class='btn btn-danger dim'><i class='fa fa-times'></i></button>"			   
		));
	}
	return tojson($arr);
}

function modellist(){
	$arr = array();
	$data=db_load('model','','model_id,model_name,model_type,model_onoff,model_order,model_list_tp,model_list_fd,model_content_tp,model_content_fd,model_list_name,model_content_name,model_table');
	foreach ($data as $value) {
		$i=$value['model_id'];
		array_push($arr,array(
		  'id' => $i,
		  'model_name'=> "<input type='text' id='model_name-".$i."' placeholder='".$value['model_name']."' value='".$value['model_name']."'>",
		  'model_type'=> $value['model_type'],
		  'model_list_tp'=> "<input type='text' class='title' id='model_list_tp-".$i."' placeholder='".$value['model_list_tp']."' value='".$value['model_list_tp']."'>",
		  'model_content_tp'=> "<input type='text' class='title' id='model_content_tp-".$i."' placeholder='".$value['model_content_tp']."' value='".$value['model_content_tp']."'>",
		  'model_onoff'=> "<button type='button'  onclick=setcol('model_onoff',".abs($value['model_onoff']-1).",'".$i."')  id='".$i."model_onoff' class='btn btn-".$value['model_onoff']."  dim'><i class='fa fa-toggle-on'></i></button>",
		  'model_order'=> "<input type='number' class='order'  min='0' max='99' id='model_order".$i."' placeholder='".$value['model_order']."'  value=".$value['model_order'].">",
			   
		));
	}
	return tojson($arr);
}

function customlist(){
	$type=getform('type','get');
	$arr = array();$i=0;$sort=G('sort');$search=G('search');$limit=500;	$page=G('page');
	$order	=	empty($sort)	?	'customid desc' 		:	$sort.' '.G('order');	
	$where	=	empty($search)	?	''		:	"`CustomName` like '%".$search."%'";
	$where	=	empty($type)	?	''		:	"`Customtype` like '%".$type."%'";	
	$data	=	db_load("content_custom",$where,'customid,custom,customname,lid,customtype,customclass,customoptions,customvalues,customplace,customorder,customonoff,customdesc',$limit,$order,$page);
	foreach ($data as $value) {
	$i=$value['customid'];
	$typelink='';
	$customtype=splits($value['customtype'],',');
	foreach ($customtype as $val){
		$typelink .= "<a href='?act=customlist&type=".$val."'>".$val."</a> ";
	}
    $editlink=$value['customtype']=='gbook' ? '?act=gbookcustom/'.$i :'?act=custom&customid='.$i;
	array_push($arr,array(	
		'id' => $i,	
		'customname' => "<input type='text'  class='title' id='customname-".$i."' placeholder='".$value['customname']."' value='".$value['customname']."'>",
		'custom' => $value['custom'],			
		'customclass' => get_custom_name($value['customclass']),	
		'customtype' =>$typelink,			
		'customoptions' => "<input type='text' class='title' id='customoptions-".$i."' placeholder='".$value['customoptions']."' value='".$value['customoptions']."'>",	
		'customvalues' => "<input type='text' class='title' id='customvalues-".$i."' placeholder='".$value['customvalues']."'  value='".$value['customvalues']."'>",
		'customorder' => "<input type='number' class='order' id='customorder-".$i."' placeholder='".$value['customorder']."'  value='".$value['customorder']."'>",		
		'customonoff' => "<button type='button' class='btn btn-".$value["customonoff"]." dim'  onclick=setcol('customonoff',".abs($value['customonoff']-1).",'".$i."')><i class='fa fa-toggle-on'></i></button>",		
		'edit' => "<button type='button' class='btn btn-info dim' onclick=opennew('".$editlink."')><i class='fa fa-pencil'></i></button> 
		<button type='button'  onclick=delcustom('".$value['custom']."')  class='btn btn-danger dim'><i class='fa fa-times'></i></button>"
		));
	}
	return tojson($arr);
}

function dbbacklist(){
	$arr = array();$i=0;;
	$data	=	db_load("log_dbbackup");	
	foreach ($data as $value) {
	$i=$value['ID'];
	array_push($arr,array(	
		'id' => $i,	
		'dbname' => "<input type='text'  class='title' value='".$value['dbname']."'>",
		'addtime' => $value['addtime'],			
		'username' => $value['username'],	
		'ip' => $value['ip'],	
		'edit' => "<button type='button'  onclick=delid('".$i."','log_dbbackup')  class='btn btn-danger dim'><i class='fa fa-times'></i></button>"
		));
	}
	return tojson($arr);
}

function gbooklist(){
	$arr = array();$i=0;$sort=G('sort');$search=G('search');$limit=G('limit');	$page=G('page');
	empty($sort)			?	$order='gid desc' 		:			$order=$sort.' '.G('order');	
	empty($search)			?	$where='' 				:			$where="`g_title` like '%".$search."%'";		
	$count	=	db_count("gbook",$where);
	$data	=	db_load("gbook",$where,'gid,g_title,lid,g_uid,g_name,g_tel,g_email,g_content,g_ip,g_time,g_onoff,g_order,r_name,r_content,r_time,r_onoff',$limit,$order,$page);
	foreach ($data as $value) {
		$i=$value['gid'];
		array_push($arr,array(
			'id' => $i,
			'g_name'=> '<input type="text"  id="g_name-'.$i.'" placeholder="'.$value['g_name'].'" value="'.$value['g_name'].'">',	
			'g_title'=> '<input type="text" class="title" id="g_title-'.$i.'" placeholder="'.$value['g_title'].'" value="'.$value['g_title'].'">',	
			'g_time'=> '<input type="text"id="g_time-'.$i.'" placeholder="'.$value['g_time'].'" value="'.$value['g_time'].'">',	
			'g_tel'=> '<input type="text"  id="g_tel-'.$i.'" placeholder="'.$value['g_tel'].'" value="'.$value['g_tel'].'">',		
			'g_email'=> '<input type="text" id="g_email-'.$i.'" placeholder="'.$value['g_email'].'" value="'.$value['g_email'].'">',			
			'g_order'=> '<input type="number" class="order" id="g_order-'.$i.'" placeholder="'.$value['g_order'].'" value="'.$value['g_order'].'">',
			'g_content'=> txt_html($value['g_content']),			
			'g_onoff'=> '<button type="button" class="btn btn-'.$value['g_onoff'].' dim" onclick=setcol("g_onoff",'.abs($value['g_onoff']-1).',"'.$i.'") id="'.$i.'g_onoff"><i class="fa fa-toggle-on"></i></button>',
			'edit' => '<button type="button" class="btn btn-info dim" onclick="opennew(\'?act=gbook&id='.$i.'\')"><i class="fa fa-pencil"></i></button> <button type="button" class="btn btn-danger dim" onclick="delid('.$i.',\'gbook\')"><i class="fa fa-times"></i></button>'
			));
	}
	return '{"total":'.$count.',"rows":'.tojson($arr).'}';
}
function imagelist(){
	$upfolder=safe_key(getform("upfolder","post"));
	$uporder=safe_word(getform("uporder","post"));
	$path=UPLOAD_DIR.$upfolder.'/';
	$allowFiles=str_replace(",","|",conf('imageext'));
	$files = getfiles($path, $allowFiles);
	foreach($files as $k=>$v){
        $size[$k] = $v['size'];
        $time[$k] = $v['mtime'];
        $name[$k] = $v['name'];
    }
	switch($uporder){
		case'size1'	: array_multisort($size,SORT_DESC,SORT_STRING, $files);break;
		case'size2'	: array_multisort($size,SORT_ASC,SORT_STRING, $files);break;	
		case'name1'	: array_multisort($name,SORT_DESC,SORT_STRING, $files);break;
		case'name2'	: array_multisort($name,SORT_ASC,SORT_STRING, $files);break;	
		case'mtime2'	: array_multisort($time,SORT_ASC,SORT_STRING, $files);break;		
		default		: array_multisort($time,SORT_DESC,SORT_STRING, $files);break;
	}	
	echo tojson($files);
}

function downlist(){
	$upfolder=safe_key(getform("upfolder","get"));
	$path=UPLOAD_DIR.$upfolder.'/';
	$allowFiles=str_replace(",","|",conf('fileext'));
	$files = getfiles($path, $allowFiles);
	echo tojson($files);
}	
function filelist($str){
	$arr = array();
	$folder=safe_key(getform("folder","get"));
	$type=safe_word(getform("type","get"));
	$folders=empty($folder) ? '' : str_replace('//','/',$folder.'/');	
	switch ($str) {
	case 'template':
		$path=$type=='wap' ? SITE_DIR.'template/wap/'.$folders : SITE_DIR.'template/pc/'.$folders;
		$files = path_list($path);
		break;
	case 'upload':		
		$path=UPLOAD_DIR.$folders;		
		$files = path_list($path);
		break;
	case 'html':
		$path=$type=='wap' ? SITE_DIR.'wap/'.conf('htmldir'):SITE_DIR.conf('htmldir');		
		$files = getfiles($path,'html','no');
		$about=getfiles($path.'about/','html','no');
		is_array($about) and $files = array_merge($files,$about);
		$brand=getfiles($path.'brand/','html','no');
		is_array($brand) and $files = array_merge($files,$brand);
		$brandlist=getfiles($path.'brandlist/','html','no');
		is_array($brandlist) and $files = array_merge($files,$brandlist);
		$list=getfiles($path.'list/','html','no');
		is_array($list) and $files = array_merge($files,$list);
		$taglist=getfiles($path.'taglist/','html','no');
		foreach (load_model() as $v){
            $content=getfiles($path.$v.'/','html','no');
            is_array($content) and $files = array_merge($files,$content);
        }            
		break;
	case 'cache':
		$path=$type=='web' ? RUN_DIR.'cache/'.conf('adminpath') : RUN_DIR.'cache/html/';
		$files = getfiles($path,'tpl','all');
		break;
	case 'log':case 'error':
		$path=RUN_DIR.$str.'/';
		$files = getfiles($path,'zzz');
		break;	
	case 'data':
		$conf = _SERVER('conf');
		switch ($conf['db']['type']) {
		case 'access':
			$path=SITE_DIR.$conf['db']['accesspath'].'backup';
			$files = getfiles($path,'acc');
			break;
		case 'sqlite':	
			$path=SITE_DIR.$conf['db']['sqlitepath'].'backup';
			$files = getfiles($path,'lite');
			break;
		case 'mysql':	
			$path=ADMIN_DIR.'backup';
			$files = getfiles($path,'bak');
			break;	
		}		
		break;
	}	
	
	if (!is_array($files)){
		return false;
	}else{
	$data= arr_asc($files,'ext');
	$count	=count($data);
	foreach ($data as $value) {
		$edit=' <a href="javascript:void(0)"  class="btn btn-danger dim"  onclick=delfile(\''.$value['url'].'\')><i class="fa fa-times"></i></a> ';
		$url=$value['url'];
		switch ( $value['ext']) {
			case '':
			$edit='<a href="?act='.$str.'list&type='.$type.'&folder='.$folders.$value['name'].'" class="btn btn-default dim"><i class="fa fa-folder-open"></i></a>';
			$name='<a href="?act='.$str.'list&type='.$type.'&folder='.$folders.$value['name'].'"><i class="fa fa-folder"></i>&nbsp;'.$value['name'].'('.$value['count'].')</a>';
			$ext='Folder';
			$size='';
			break;
			case 'jpg':case 'jpeg':case 'png':case 'gif':case 'bmp':
			$name='<a href="'.$value['url'].'" class="fancybox"  rel="group"><i class="fa fa-image"></i>&nbsp;'.$value['name'].'</a>';
			$ext='Image';
			$size=$value['size'];
			break;
			case 'txt':case 'xml':case 'htm':case 'js':case 'css':case 'zzz':
			$edit='<a href="'.$value['url'].'" class="btn btn-default dim" target="_blank"><i class="fa fa-external-link"></i></a> <a href="javascript:void(0)" class="btn btn-success dim" onclick=opennew(\'?act=log&type='.$value['url'].'\')><i class="fa fa-pencil"></i></a>'.$edit;
			$name='<a href="javascript:void(0)" onclick=opennew(\'?act=log&type='.$value['url'].'\')><i class="fa fa-edit"></i>'.$value['name'].'</a>';
			$ext='Text';
			$size=$value['size'];
			break;
			case 'html':case 'tpl':
			$edit= '<a href="javascript:void(0)" class="btn btn-success dim" onclick=opennew(\'?act=templateedit&type='.$value['url'].'\')><i class="fa fa-pencil"></i></a>'.$edit;
			$name=  $str=='html'  ? '<a href="'.$value['url'].'" target="_blank">'.$value['name'].'</a>' :'<a href="javascript:void(0)" onclick=opennew(\'?act=templateedit&type='.$value['url'].'\')><i class="fa fa-edit"></i>&nbsp;'.$value['name'].'</a>';
			$ext='Html';
			$size=$value['size'];
			break;
			case 'acc':case 'lite':case 'bak':
			$edit= '<a href="javascript:void(0)" class="btn btn-warning dim" onclick=restore(\''.$value['url'].'\')><i class="fa fa-recycle"></i></a>'.$edit;
			$name=  $str=='html'  ? '<a href="'.$value['url'].'" target="_blank">'.$value['name'].'</a>' :'<a href="javascript:void(0)" onclick=opennew(\'?act=templateedit&type='.$value['url'].'\')><i class="fa fa-edit"></i>&nbsp;'.$value['name'].'</a>';
			$ext='Data';
			$size=$value['size'];
			break;
			default:
			$name=$value['name'];
			$ext=$value['ext'];
			$size=$value['size'];
			$edit='<a href="'.$value['url'].'" target="_blank" class="btn btn-default dim"><i class="fa fa-external-link"></i></a> '.$edit;
		}	
		array_push($arr,array(
			'name'=>$name,
			'url'=>'<input class="title" value="'.$url.'" readonly="readonly">',
			'mtime'=>$value['mtime'],
			'size'=>$size,
			'ext'=>$ext,
			'edit'=>$edit
		));
	  }
	 return tojson($arr);
      //return '{"total":'.$count.',"rows":'.tojson($arr).'}';
	}	
  
}
	