<?php
require '../../../inc/zzz_admin.php';
$CONFIG = json_decode(preg_replace("/\/\*[\s\S]+?\*\//", "", file_get_contents("config.json")), true);
$action = safe_word(getform('action','get'));
$upfolder = safe_word(getform('upfolder','get'));
switch ($action) {
    case 'config':
        $result = json_encode($CONFIG);
        break;    
    /* 上传图片 */
    case 'uploadimage':
		$result =tojson(upload($_FILES['upfile'],'image',$upfolder));
        break;   
    /* 上传涂鸦 */
    case 'uploadscrawl':   
		$upfile=getform('upfile','post');
    	$result =tojson(up_base64($upfile,$upfolder));
        break;   
    /* 上传文件 */
    case 'uploadfile':
       $result =tojson(upload($_FILES['upfile'],'file',$upfolder));
        break;    
    /* 上传视频 */
	case 'uploadvideo':
		$result =tojson(upload($_FILES['upfile'],'video',$upfolder));
        break;  
	 /* 列出图片 */
    case 'listimage':
		$size=safe_word(getform('size','get'));
		$start=safe_word(getform('start','get'));
		$uporder=safe_word(getform('uporder','get'));
		$end = $start + $size;
		$allowFiles=str_replace(",","|",conf('imageext'));
		$path = UPLOAD_DIR.$upfolder.'/';
		$files = getfiles($path, $allowFiles);
		foreach($files as $k=>$v){
			$sizes[$k] = $v['size'];
			$times[$k] = $v['mtime'];
			$names[$k] = $v['name'];
		}
		switch($uporder){
			case'size1'	: array_multisort($sizes,SORT_DESC,SORT_STRING, $files);break;
			case'size2'	: array_multisort($sizes,SORT_ASC,SORT_STRING, $files);break;	
			case'name1'	: array_multisort($names,SORT_DESC,SORT_STRING, $files);break;
			case'name2'	: array_multisort($names,SORT_ASC,SORT_STRING, $files);break;	
			case'mtime2'	: array_multisort($times,SORT_ASC,SORT_STRING, $files);break;		
			default		: array_multisort($times,SORT_DESC,SORT_STRING, $files);break;
		}	
		if (! count($files)) {
			return json_encode(array(
				"state" => "no match file",
				"list" => array(),
				"start" => $start,
				"total" => count($files)
			));
		}
		$len = count($files);

		for ($i =$start,$list = array(); $i <= $len-1 &&  $i <= $end; $i ++) {
			$list[] = $files[$i];			
		}
		$result = json_encode(array(
			"state" => "SUCCESS",
			"list" => $list,
			"start" => $start,
			"total" => count($files)
		));		
        break;
    /* 列出文件 */
    case 'listfile':
        $result = getfiles();
        break;
    
    /* 抓取远程文件 */
    case 'catchimage':
		$source=getform('source','post');
		$list = array();
     	foreach ($source as $imgUrl) {
			$info =down_url(safe_url($imgUrl),$upfolder); 
			if ($info['state']=="SUCCESS"){
				array_push($list, array(			
					"state" => "SUCCESS",				
					"title" => $info["title"],
					"url" => $info["url"],
					"source"=>$imgUrl
				));
			}
		}
		$result =  json_encode(array(
			'state' => count($list) ? 'SUCCESS' : 'ERROR',
			'list' => $list
		));
        break;
    default:
        $result = json_encode(array(
            'state' => '请求地址出错'
        ));
        break;
}
/* 输出结果 */
if (isset($_GET["callback"])) {
    if (preg_match("/^[\w_]+$/", $_GET["callback"])) {
        echo htmlspecialchars($_GET["callback"]) . '(' . $result . ')';
    } else {
        echo json_encode(array(
            'state' => 'callback参数不合法'
        ));
    }
} else {
    echo($result);
}