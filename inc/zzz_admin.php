<?php
require 'zzz_class.php';
if ($conf['isinstall']==0) error('很抱歉!程序未安装, <span id=time></span>即将进入安装界面',SITE_PATH.'install/');
function check_admin($type=""){  
    $r='';
		$adminid      =get_session("adminid");
		$admingid     =get_session("admingid");
        $admingroup   =get_session("admingroup");	
		$adminmenu    =get_session("adminmenu");			
		$adminmark    =get_session("adminmark");
        $adminrand    =get_session("adminrand");
    if (isnul($adminid) || isnul($admingid) || isnul($admingroup) || is_null($adminmark))	{
       $r=false;    
    }elseif(!check_rand()){
       $r=false;  
    } else{
       $r=true;
    }
    switch( $type){
        case 'login':
           if(!$r)  login_esc();
        break;
        case 'index':
           if($r)  phpgo("index.php");	
        break;
        case 'msg':
           if(!$r)  returnmsg ('json',0); 
        case 'die':
           if(!$r)  die(0);
    }
    return $r;
}

function check_rand(){
    $adminrand=get_session("adminrand");
    $uid=get_session("adminid");
    $admintime=md5(get_cookie('admintime').$uid);	
    if ($admintime==$adminrand){
    	if (db_count('user',array('adminrand'=>$admintime))) return true;
	}
    return false;
}

function login_esc(){
	del_session("admingroup");
	del_session("adminid");
	del_session("admingid");
	del_session("adminmenu");		
	del_session("adminmark");
	del_session("adminrand");
	phpgo ("login.php");	
}

function login_out(){
	del_cookie("adminname");
	del_session("admingroup");
	del_session("adminid");
	del_session("admingid");
	del_session("adminmenu");	
	del_session("adminmark");
	del_session("adminrand");
	phpgo ("login.php");	
}

function topmenu(){
	if(get_session('adminmenu')){
		$adminmenu=get_session('adminmenu');
		$where=array('m_level'=>1,'m_onoff'=>1);
		if ($adminmenu!="all") {			
			$adminmenu=splits($adminmenu,",");
			arr_add($where,'mid',$adminmenu);			
		}		
	$data=db_load('menu',$where,'mid,m_name');
	foreach ($data as $value){
		$where2=array('m_onoff'=>1,'m_level'=>2,'pid'=>$value['mid']);
		echo '<li class="dropdown"> <a aria-expanded="false" role="button" href="#" class="dropdown-toggle" data-toggle="dropdown"> '.($value['m_name']).' <span class="caret"></span></a>'.
            '<ul role="menu" class="dropdown-menu">';
				$datai=db_load('menu',$where2,'mid,m_name,m_link,m_key','50',array('m_order'=>'asc','mid'=>'asc'));
				foreach ($datai as $valuei){
					if ($adminmenu=="all" || @in_array($valuei['mid'],$adminmenu)){
					$links=strtolower($valuei['m_link']);	
					$links = str_replace('．','.',$links);										
						if(cleft($links,0,3)=='zzz'){
							$link=array_filter(explode("/",$links));	
							$link = trim(end($link));
							$link = str_replace('.asp','',$link);								
							$link = str_replace('?','&',$link);
							$link = '?act='.(str_replace('_','',$link));
							echo '<li id="'.$valuei['m_key'].'"><a href="'.$link.'"  class="J_menuItem">'.$valuei['m_name'].'</a> </li>';
						}else{
							echo '<li id="'.$valuei['m_key'].'"><a href="'.$links.'"  class="J_menuItem">'.$valuei['m_name'].'</a> </li>';
						}
					}
				}
         echo '</ul>'.
          '</li>';
	}}
	echo '<ul class="hidden">';
	$data=db_load('model','Model_table <> null','model_id,model_name,model_type,model_onoff,model_table');
	foreach ($data as $value){
		echo '<li id="custom_'.$value['model_type'].'"><a href="?module=customlist&type='.$value['model_type'].'"  class="J_menuItem">'.($value['model_name']).'参数</a> </li>';
	}	
	echo '</ul>';
}

function leftmenu($sid=0){
	$adminsort=db_load_one('admin_group',array('gid'=>get_session("admingid")));
    $adminsort=empty($adminsort)||$adminsort=='all'  ? '' : splits($adminsort,',');
	$data=db_load_sql('select sid,s_name,s_level,s_type,(select count(0) from [dbpre]sort where s_pid=a.sid) as c from [dbpre]sort as a where s_onoff=1  and s_pid='.$sid.' order by s_order asc,sid asc');
	foreach ($data as $value){     
         if(!empty( $adminsort)){
             if(!in_array($value['sid'],$adminsort))  continue;  
         } 
		switch ($value['s_type']) {
			case 'about':
				$menulink= '?act=aboutlist&sid='.$value['sid'];
				$ico='fa-about';
			break;
			case 'links':
				$menulink= '';
				$ico='fa-links';
			break;
			case 'gbook':
				 $menulink= '?act=gbooklist';
				$ico='fa-links';
			break;	
			case 'news':case 'product':case 'case':case 'photo':case 'video':case 'down':case 'job':case 'gbook':case 'brand':
				$menulink= '?act=contentlist&sid='.$value['sid'];
				$ico='fa-'.$value['s_type'];
			break;	
			default:
			    $menulink= '?act=contentlist&sid='.$value['sid'];
				$ico='fa-product';
		}
		echo "<li class='leftdown menuList".$sid."'> <a class='J_menuItem' href='".$menulink."'  data-index='".$sid."' id='left".$sid."'> <i class='fa ".$ico."'></i> <span class='nav-label'>".($value['s_name'])."</span> </a>";
		 if ($value['c']>0) {        
       		echo ' <em>+</em><ul class="nav nav-'.$value['s_level'].'-level collapse">';
			echo leftmenu($value['sid']);
			echo "</ul>";
		 }
	}	
}

function right_count($type){
	$data=db_load("model","model_onoff=1 and model_table='content'","model_id,model_name,model_type,model_table");
	foreach ($data as $value){
		echo '<li class="list-group-item" onclick="goparent(\''.$value['model_type'].'\')"> <span class="badge badge-'.$value['model_id'].'">'.
		db_count('content','c_type=\''.$value['model_type'].'\' and C_OnOff=1').
		'</span> <a href="javascript:void(0)">'.($value['model_name']).'</a> </li>';
	}	
}

function center_count($type){
     echo '<div class="col-sm-3"><div class="ibox float-e-margins">
          <div class="ibox-title"> <span class="label label-primary pull-right">总</span>
            <h5>栏目统计</h5>
          </div>
          <div class="ibox-content"> <a onclick="goparent(\'sort\')">
            <h1 class="no-margins">'.db_count("sort","s_onoff=1").'</h1>
            <div class="stat-percent font-bold text-navy">进入 <i class="fa fa-level-up"></i> </div>
            <small>栏目数量</small> </a></div>
      </div></div>';
     if(check_dir(SITE_DIR.'shop')){
     foreach(array('订单'=>'order','支付'=>'pay','发货'=>'post') as $key=>$value){
      echo '<div class="col-sm-3"><div class="ibox float-e-margins">
          <div class="ibox-title"> <span class="label label-primary pull-right">总</span>
            <h5>'.$key.'统计</h5>
          </div>
          <div class="ibox-content"> <a onclick="goparent(\''.$value.'list\')">
            <h1 class="no-margins">'.db_count('shop_'.$value).'</h1>
            <div class="stat-percent font-bold text-navy">进入 <i class="fa fa-level-up"></i> </div>
            <small>'.$key.'数量</small> </a></div>
      </div></div>'; 
          }   
     }else{      
         $data=db_load('model',array('model_type'=>array('about','brand','gbook')));         
         foreach($data as $value){
             $value=array_change_key_case($value);
         echo '<div class="col-sm-3"><div class="ibox float-e-margins">
          <div class="ibox-title"> <span class="label label-primary pull-right">总</span>
            <h5>'.$value['model_name'].'统计</h5>
          </div>
          <div class="ibox-content"> <a onclick="goparent(\''.$value['model_type'].'\')">
            <h1 class="no-margins">'.db_count($value['model_type']).'</h1>
            <div class="stat-percent font-bold text-navy">进入 <i class="fa fa-level-up"></i> </div>
            <small>'.$value['model_name'].'数量</small> </a></div>
      </div></div>';
     }        
   } 
} 

function top_count(){
	$num=0;$unum=0;$gnum=0;$onum=0;
	if (conf('usermark')==1 && conf('useronoff')==0)		$unum=db_count('user','U_onoff=0');
	if (conf('gbookmark')==1 && conf('gbookonoff')==0)		$gnum=db_count('gbook','G_onoff=0');
	if (db_istable('shop_order')) 							$onum=db_count('shop_order','ispay=1 and ispost=0');
	$num=$unum+$gnum+$onum;
	if ($gnum>0){
	echo '<li class="dropdown"><a class="dropdown-toggle count-info" data-toggle="dropdown" href="#" aria-expanded="false"><i class="fa fa-bell xintiao"></i>
		<span class="label label-primary">'.$num.'</span></a><ul class="dropdown-menu dropdown-alerts">';
	if ($unum>0)
	 {echo '<li><a href="javascript:void(0)" onclick="goparent(\'user\')"><div><i class="fa fa-user-plus fa-fw"></i> '.$unum.'个会员需要审核<span class="pull-right text-muted small">'.formatdate(db_select('user','regtime','u_onoff=0','uid desc'),'now').'</span></div></a></li>';}
	if ($gnum>0) 
	 {echo '<li><a href="javascript:void(0)" onclick="goparent(\'gbook\')"><div><i class="fa fa-envelope fa-fw"></i> '.$gnum.'条留言需要审核<span class="pull-right text-muted small">'.formatdate(db_select('gbook','g_time','g_onoff=0','gid desc'),'now').'</span></div></a></li>';}
	if ($onum>0) 
	 {echo '<li><a href="javascript:void(0)" onclick="goparent(\'shop_order\')"><div><i class="fa fa-envelope fa-fw"></i> '.$onum.'条订单需要处理<span class="pull-right text-muted small">'.formatdate(db_select('shop_order','addtime','ispay=1 and ispost=0','id desc'),'now').'</span></div></a></li>';} 
	echo '</ul></li>';
	}
}
function get_files($fileurl,$filename){
	$file_list='';
	if (!isnul($fileurl)){
		$file=splits($fileurl,',');
		$titles=splits($filename,',');		
		foreach ($file as $key=>$value) {	
		$filename=isset($titles[$key]) ? $titles[$key] : '';		
		if (!empty($filename)){
			$file_list.='<tr class="fileli">
						<td>'.file_ext($value).'</td>
						<td><input name="c_downname[]" class="form-control input-sm"  value="'.$filename.'" placeholder="附件名称" /></td>
						<td><input name="c_downurl[]" class="form-control input-sm" value="'.$value.'" placeholder="下载地址" /></td>
						<td><i class="fa fa-plus"></i> <i class="fa fa-remove"></i> <i class="fa fa-arrow-up"></i> <i class="fa fa-arrow-down"></i> </td>
					  </tr>';
			}
		}
	}	
	return $file_list;
}

function get_pics($picsurl,$picsname,$pic,$type=NULL){
		$dndArea="";
		$statusBar="style='display:none;'";
		$pics_list="";	
	if (!isnul($picsurl)){
				$pics=splits($picsurl,',');
				$titles=splits($picsname,',');
				$pics_list='';
				foreach ($pics as $key=>$picurl) {				
				$pictitle=isset($titles[$key]) ? ($titles[$key]) : '';
				$selected= $picurl==$pic ? "selected" : "";
				$pics_list.="<li class='state-complete'><p class='title'> </p><p class='imgWrap'><img src='".$picurl."'></p><p class='progress'><span style='display: none; width: 0px;'></span></p><div class='file-panel' style='height: 0px;'><i class='cancel'>删除</i><i class='moveRight'>向右</i><i class='moveLeft'>向左</i></div><input value='".$picurl."' name='picsurl[]'><input value='".$pictitle."' name='picsname[]'><span class='success ".$selected."'></span></li>";
				}
				$pics_list="<ul class='filelist'>".$pics_list."</ul>";
				$dndArea="element-invisible";
				$statusBar="";
	}
	echo '<div id="uploader">
                <div class="queueList">
                  <div id="dndArea" class="placeholder '.$dndArea.'">
                    <div id="imgPicker"></div>
                    <div id="imgSelect" class="webuploader-container">
                      <div class="webuploader-pick" onClick=openimagemanager("'.$type.'")><i class="fa fa-folder-open"></i> 选择图片</div>
                    </div>
                    <p>或将照片拖到这里，单次最多可选300张</p>
                  </div>
				   '.$pics_list.'
                </div>
                <div class="statusBar" '.$statusBar.'>
                  <div class="progress"> <span class="text">0%</span> <span class="percentage"></span> </div>
                  <div class="info"></div>
                  <div class="btns">
                    <div id="imgPicker2"></div>
                    <div class="uploadBtn" onClick=openimagemanager("'.$type.'")>选择图片</div>
                  </div>
                </div>
              </div>';
	
}
function get_custom($stype,$id){
	$getcustom='';
	$data=db_load_sql("select * from [dbpre]content_custom where  customonoff=1 and (customtype like '%".$stype."%' or customtype='all')  order by customorder asc,customid asc");	
		foreach ($data as $value){	
			$onecustom='';$customname='';
			switch ($stype){
				case 'about':				
					$valstr=$id==0 ? $value['customvalues'] : db_select("about",$value['custom'],"aid=".$id);
				break;
				case 'brand':
					$valstr=$id==0 ? $value['customvalues'] : db_select("brand",$value['custom'],"bid=".$id);
				break;
				case 'gbook':
					$valstr=$id==0 ? $value['customvalues'] : db_select("gbook",$value['custom'],"gid=".$id);
				break;
				default:
					$valstr=$id==0 ? $value['customvalues'] : db_select("content",$value['custom'],"cid=".$id);
			}
			$customclass=$value['customclass'];$customoptions=$value['customoptions'];$customname=($value['customname']);
			switch ($customclass){			
			case'1':
			$customplace=empty($value['customplace']) ? '数字字段' : $value['customplace'];
			$valstr=empty($valstr) ? '0' : $valstr;
			$onecustom ="<input name='".$value['custom']."' id='".$value['custom']."' type='number' step='0.01' class='form-control' placeholder='".$customplace."' value='".$valstr."'>";
			$onecustom ="<div class='col-sm-5'><div class='input-group'>".$onecustom ."<span class='input-group-addon'>".$value['customdesc']."</span></div></div>";
			break;
			case '2':
			$onecustom="<div class='col-sm-11'> <textarea class='textarea form-control'   name='".$value['custom']."' id='".$value['custom']."'>".html_textarea($valstr)."</textarea></div>";
			break;
			case '3':
			$onecustom=
				"<div class='col-sm-11'> <textarea class='textarea textarea-editor'   name='".$value['custom']."' id='".$value['custom']."'>".decode($valstr)."</textarea>
				</div><script>var $".$value['custom']." = new UE.getEditor('".$value['custom']."');</script>";
			break;
			case '4': case '5': case'6':
				$splitvalue=splits($customoptions,",");$i=0;			
				if($customclass==6) {
					$onecustom="<div class='col-sm-10'><select name='".$value['custom']."' id='".$value['custom']."' class='form-control'>"; 
				}else{ 
					$onecustom.="<div class='col-sm-10'>";
				}	
				foreach ($splitvalue as $key=>$val){
					if(ifstrin($valstr,$val)) {
						$checkstr="checked";
						$selectstr="selected";
					}else {
					 	$checkstr="";
					 	$selectstr="";
					}				
					if($customclass==4) $onecustom.="<div class='radio checkbox-primary radio-inline'><input type='radio' id='".$value['custom'].$key."' name='".$value['custom']."' ".$checkstr." value='".$val."'/><label for='".$value['custom'].$key."'>".$val."</label></div>";
					if($customclass==5) $onecustom.="<div class='checkbox checkbox-primary radio-inline'><input type='checkbox' id='".$value['custom'].$key."' name='".$value['custom']."[]' ".$checkstr." value='".$val."'/><label for='".$value['custom'].$key."'>".$val."</label></div>";
					if($customclass==6) $onecustom.=" <option value='".$val."' ".$selectstr.">".$val."</option>";
				}
				if($customclass==6) $onecustom.=" </select>";
				$onecustom .= "</div>";
			break;
			case '7': case '8': case'9':
				if ($customclass==7) {
				$filetype="file";	
				$fileext=empty($customoptions) ? 'file' : $customoptions;
				$filescript="<script>$(function(){fileuploader('".$value['custom']."_upload','".$fileext."','".$stype."','".$value['custom']."','')}) </script>";
				$fileview=" <div class='col-sm-1'>".$valstr."</div>";
				}elseif ($customclass==8) {
				$filetype="pic"; 
				$filescript="<script>$(function(){fileuploader('".$value['custom']."_upload','image','".$stype."','".$value['custom']."','')}) </script>";
				$fileview=" <div class='col-sm-1'><img src='".$valstr."' height='30' id='img_".$value['custom']."'></div>";
				}elseif ($customclass==9) {
				$filetype="video";
				$filescript="<script>$(function(){fileuploader('".$value['custom']."_upload','video','".$stype."','".$value['custom']."','')}) </script>";
				$fileview=" <div class='col-sm-1'>".$valstr."</div>";
                }
				$onecustom=
					  "<div class='col-sm-7'><input id='".$value['custom']."' name='".$value['custom']."' class='form-control' value='".$valstr."'/></div>".
					 "<div class='col-sm-2'><div id='".$value['custom']."_upload'>上传</div>".$fileview." </div>".
					 $filescript;
			break;
			case '10':	
            $options=empty($value['customoptions'])? "format:'YYYY-MM-DD hh:mm:ss',onClose:false,isinitVal:true" : $value['customoptions'];
			$onecustom=				 
				  "<div class='col-sm-5'><div class='input-group'>".
					"<input type='text' id='".$value['custom']."' class='form-control time'  name='".$value['custom']."'  placeholder='".$value['customplace']."'  value='".$valstr."'>".
					"<span class='input-group-addon'>  <i class='fa fa-calendar'></i></span> </div></div>".
					"<script>$(function(){jeDate('#".$value['custom']."',{".$options."})})</script>";
			break;
			default:
			$onecustom =
				 "<div class='col-sm-5'><input name='".$value['custom']."' id='".$value['custom']."' type='text' class='form-control' placeholder='".$value['customplace']."' value='".$valstr."'>".
				 "</div>";
			
			}
			$getcustom .="<div class='form-group'> <label class='col-sm-1 control-label'>".$customname."</label>".$onecustom."</div>";
		}
	return $getcustom;
}

function online($type){
   $cachefolder = RUN_DIR . 'cache/'.conf('adminpath');    
   $cachefile=$cachefolder.'/template';   
	$templatestr=https_get("http://zzzcms.com/updata/".$type.".html");$i=0;$list='';
	$templateArry=splits($templatestr,";");
		foreach ($templateArry as $value) {		
			$i++;
			$templatej=splits($value,",");
			if (count($templatej)>6){		
				//$savefile=down_url($templatej[2],$cachefolder.'images/');
				//$pic=$savefile['url'];
				$pic=$templatej[2];
				$list.= '<li class="'.$templatej[1].'" data-id="id-'.$i.'"><a href="'.$templatej[5].'" target="_blank"><img alt="image" src="'.$pic.'"></a><dd>
				<p class="title">'.$templatej[0].'</p>
				<p>价格:<span>'.$templatej[4].'</span>元<i>'.$templatej[6].'</i><em>'.$templatej[7].'</em></p>
				<p>演示:<button onclick=location.href='.$templatej[5].'" target="_blank" class="text-navy">访问</button></p>
				<p>作者:'.$templatej[3].'</p>
				<p>风格:'.$templatej[1].'</p>
				</dd></li>';		
			}
		}
	return $list;
}
function template($type){
	$list='';$folder=dir_list(SITE_DIR.'template/'.$type);
	 $tpl=db_load_one('language',"lid=1",'pctemplate,waptemplate');
	 $pctpl=$tpl['pctemplate'];
	 $waptpl=$tpl['waptemplate'];
		foreach ($folder as $value) {
		 $dir=SITE_DIR.'template/'.$type.'/'.$value.'/template.xml';
		 if (is_file($dir)){
		   $xml=simplexml_load_file($dir);
		   if($pctpl==$value.'/'&& $type=='pc'){
			   	$button="<button type='button' class='btn btn-primary' onclick=window.open('".SITE_PATH."','_blank');><i class='fa fa-check'></i> 电脑网站使用中</button>
						 <button class='btn btn-info' onclick=\"goparent('template_list')\"><i class='fa fa-edit'></i> 编辑</button>";
				$active='active';
		   }elseif($waptpl==$value.'/'&& $type=='wap'){
			   $button="<button type='button' class='btn btn-primary' onclick=window.open('".SITE_PATH."','_blank');><i class='fa fa-check'></i> 手机网站使用中</button>";
			   $active='active';
		   }else{
				$button="<a class='btn btn-info'  href='save.php?act=settemplate&type=".$type."&folder=".$value."'><i class='fa fa-gears'></i>　使用此模板</a>";
				$active='';
		   }
           $list.= '  <div class="col-sm-12 m-t file"> <span class="corner '.$active.'"></span>
              <div class="image"> <img alt="image" class="feed-photo" src="'.SITE_PATH.'template/'.$type.'/'.$value.'/'.$xml->ScreenShot.'"> </div>
              <div class="file-name">
                <ul>
			    <dt>名　称:</dt>
                <dd>'.$xml->name.'</dd>
                <dt>演　示:</dt>
                <dd><a href="'.$xml->demo.'" target="_blank" class="text-navy">'.$xml->demo.'</a> </dd>
                <dt>作　者:</dt>
                <dd>'.$xml->author.'</dd>
				 </ul> <ul>
                <dt>主　页:</dt>
                <dd><a href="'.$xml->website.'"  target="_blank" class="text-navy">'.$xml->website.'</a> </dd>
                <dt>描　述:</dt>
                <dd>'.$xml->description.'</dd>				
                <dl>'.$button.'</dl>
				</ul>
              </div></div>';
		}
	}
	return $list;
}