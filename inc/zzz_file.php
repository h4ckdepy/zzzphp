<?php
//读取文件
function load_file( $path, $location = NULL ) {
	$path = str_replace( '//', '/', $path );
	if ( is_file( $path ) ) {
		return file_get_contents( $path );
	} elseif ( !is_null( $location ) ) {
		$locationpath = PLUG_DIR . 'template/' . $location . '.tpl';
		if ( is_file( $locationpath ) ) {
			return file_get_contents( $locationpath );
		} elseif(conf('runmode')==1) {
			return false;
		}else{
			error ( '404，很抱歉您访问的页面模板不存在,请检查网址是否正确！,'.str_replace( DOC_PATH, '', $path ) ,SITE_PATH);
		}
	} elseif ( is_file( SITE_DIR . $path ) ) {
		return file_get_contents( SITE_DIR . $path );
	} else {
		error( "载入文件失败,请检查文件路径！," . str_replace( DOC_PATH, '', $path ) );
		return false;
	}
}
//读取模型
function load_model($table='content',$type='array'){
	$path=RUN_DIR . 'cache/model/'.md5('model_'.$table) . '.tpl';
	if(is_file( $path )){	
		 $json=file_get_contents( $path );
		 $list= jsonto($json);
	}else{
		$list=array();
		if($table=='content' || $table=='list'){
			$data=db_load('model',array('model_onoff'=>1,'model_table'=>'content'),'model_type');
		}else{
			$data=db_load('model',array('model_onoff'=>1,'model_type'=>array('<>'=>'links')),'model_type');
		}		
		foreach($data as $value){
			$list[]= $value['model_type'];
		}
        $list[]= 'content';
		$json=tojson($list);
		create_file( $path, $json);		
	}
	switch($type){
		case 'array':
			return  $list;
			break;
		case 'json':
			return  $json;
			break;
		default:
			return  implode($type, $list);
			break;
	}
	
}

// 检测目录是否存在
function check_dir( $path, $create = false ) {
	if ( is_dir( $path ) ) {
		return true;
	} else{
		if(cleft($path,0,1)=="/"  && substr_count($path,'/')<6  ){
			if (is_dir(SITE_DIR . ltrim( $path, '/' ))) return true;
		}
		if ( $create ) return create_dir( $path );		
	}
}

// 创建目录
function create_dir( $path ) {
	if ( !is_dir( $path ) ) {
		if ( @mkdir( $path, 0777, true ) ) {
			return true;
		}else{
			error( '创建文件夹失败,请检查目录权限，可手动创建文件夹：,'.str_replace(SITE_DIR,SITE_PATH,$path));
		}
	}
	return false;
}


// 检查文件是否存在
function check_file( $path, $create = false, $zcontent = NULL ) {
	if ( is_file( $path ) ) {
		return true;
	} else{		
		if(cleft($path,0,1)=="/" && substr_count($path,'/')<6 ){
			if (is_file(SITE_DIR . ltrim( $path, '/' ))) return true;
		}
		if ( $create ) return create_file( $path, $zcontent );		
	}
}

function check_pic( $path, $type, $id = 0 ) {
	$path = is_file( $path ) ? $path : SITE_DIR . ltrim( $path, '/' );
	if ( is_file( $path ) ) {
		$table = db_table( $type );
		$conf = $_SERVER[ 'conf' ];
		if ( $conf[ 'smallmark' ] == 1 ) {
			if ( $id == 0 )$id = db_maxid( $table, 'id' ) + 1;
			$img_mode = $conf[ $type . '_mode' ];
			if ( $type == 'about' || $type == 'brand' ) {
				$newpath = SITE_DIR . $conf[ 'uploadpath' ] . $type . '/' . $id . '.jpg';
			} else {
				$newpath = SITE_DIR . $conf[ 'uploadpath' ] . 'images/' . $id . '.jpg';
			}
			$max_width = $conf[ $type . '_width' ];
			$max_height = $conf[ $type . '_height' ];
			$img_quality = $conf[ $type . '_quality' ];
			resize_img( $path, $newpath, $img_mode, $max_width, $max_height, $img_quality );
		}
		return true;
	} else {
		return false;
	}
}

// 创建文件
function create_file( $path, $zcontent = NULL, $over = true ) {
	$path =  str_replace( '//', '/', $path );
	check_dir( dirname( $path ), true );
    $ext=file_ext( $path );
	if(in_array($ext,array('html','tpl','zzz','txt','css','jpg','png','gif','jpeg','xml','zip','bak','key','lock','config','htaccess')) &&  !empty($ext))  {
       $handle = fopen( $path, 'w' )or error( '创建文件失败,请检查目录权限！');
	   fwrite( $handle, $zcontent );
    }else{
        error( '创建文件失败,禁止创建'.$ext.'文件！,' . $path );
    }	
	return fclose( $handle );
}

// 目录文件夹列表
function dir_list( $path ) {
	$list = array();
	if ( !is_dir( $path ) || !$filename = scandir( $path ) ) {
		return $list;
	}
	$files = count( $filename );
	for ( $i = 0; $i < $files; $i++ ) {
		$dir = $path . '/' . $filename[ $i ];
		if ( is_dir( $dir ) && $filename[ $i ] != '.' && $filename[ $i ] != '..' ) {
			$list[] = $filename[ $i ];
		}
	}
	return $list;
}

function move_upload_file( $srcfile, $destfile ) {
	$r = copy_file( $srcfile, $destfile );
	return $r;
}

// 文件后缀名，不包含 .
function file_ext( $filename, $max = 16, $len = 1 ) {
	$filename = strpos( $filename, '?' ) !== false ? arr_split( $filename, '?', 0 ) : $filename;
	$ext = strtolower( substr( strrchr( $filename, '.' ), $len ) );
	strlen( $ext ) > $max AND $ext = substr( $ext, 0, $max );
	return $ext;
}

// 文件的前缀，不包含最后一个 .
function file_pre( $filename ) {
	return substr( $filename, 0, strrpos( $filename, '.' ) );
}

// 获取路径中的路径
function file_path( $path ) {
    if (strpos( $path, './' )!== false) return error ( '404，很抱歉，路径有误,不支持相对路径！',SITE_PATH); 
    $list=array();
	$path= substr( $path, 0, strrpos( $path, '/' ));
    $list=splits($path,'/');
    return $list;
}

// 获取路径中的文件名
function file_name( $path ) {
	return substr( $path, strrpos( $path, '/' ) + 1 );	
}

function get_downurl( $cid, $url, $name = '下载' ) {
	$urls = splits( $url, ',' );
	$titles = splits( $name, ',' );
	$list = '<div class="downfile">';
	foreach ( $urls as $key => $value ) {
		$filename = isset( $titles[ $key ] ) ? $titles[ $key ] : $name;
		if ( !empty( $value ) ) {
			$list .= "<span><a href='" . $value . "' class='downs' target='_blank'>" . $filename . "</a></span>";
		}
	}
	return $list . '</div>';
}

// 遍历获取目录下的指定类型的文件
function getfiles( $path, $allowFiles, $sub = '', & $files = array() ) {
	if ( !is_dir( $path ) ) return null;
	if ( substr( $path, strlen( $path ) - 1 ) != '/' )$path .= '/';
	$handle = opendir( $path );
	while ( false !== ( $file = readdir( $handle ) ) ) {
		if ( $file != '.' && $file != '..' ) {
			$path2 = $path . $file;
			if ( is_dir( $path2 ) && $sub == 'all' ) {
				getfiles( $path2, $allowFiles,$sub,$files );
			} else {
				if ( preg_match( "/\.(" . $allowFiles . ")$/i", $file ) ) {
					$file_arr = explode( '.', $file );
					$file_name = reset( $file_arr );
					$file_ext = strtolower( end( $file_arr ) );
					$files[] = array(
						'dir' => $path2,
						'url' => substr( $path2, strlen( $_SERVER[ 'DOCUMENT_ROOT' ] ) ),
						'name' => $file_name,
						'ext' => $file_ext,
						'size' => formatnum( filesize( $path2 ),'size' ),
						'mtime' => date( 'Y-m-d H:i:s', filemtime( $path2 ) )
					);
				}
			}
		}
	}
	return $files;
}

function delfiles( $path, $ext, $sub = '' ) {
	if ( !is_dir( $path ) ) return FALSE;
	if ( substr( $path, strlen( $path ) - 1 ) != '/' ) return NULL;
	$handle = opendir( $path );
	while ( false !== ( $file = readdir( $handle ) ) ) {
		if ( $file != '.' && $file != '..' ) {
			$path2 = $path . $file;
			if ( is_dir( $path2 ) && $sub == 'all' ) {					
				delfiles( $path2.'/',$ext,$sub);
			}			
			if ( preg_match( "/\.(" . $ext . ")$/i", $file ) ) {
				unlink( $path2 );
			}
		}
	}

}

function down_size( $url ) {
	$header_array = @get_headers( $url, true );
	if ( $header_array ) {
		$size = $header_array[ 'Content-Length' ];
	} else {
		$size = 0;
	}
	return $size;
}

function down_file( $url, $timeout = 60 ) {	
    check_dir(RUN_DIR . 'zip/',true);
    $file = RUN_DIR . 'zip/' . time() . '.zip';
	$url = str_replace( " ", "%20", $url );
	if ( function_exists( 'curl_init' ) ) {
		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_HEADER, 0 );
		curl_setopt( $ch, CURLOPT_TIMEOUT, $timeout );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $ch, CURLOPT_NOPROGRESS, 0 );
		curl_setopt( $ch, CURLOPT_BUFFERSIZE, 64000 );
		$temp = curl_exec( $ch );
		if ( @file_put_contents( $file, $temp ) && !curl_error( $ch ) ) {
			return $file;
		} else {
			return false;
		}
		curl_close( $ch );
	}
}

function select_template( $type, $str ) {
	$tempath = db_load_one( 'language', 'lid=1', 'pctemplate,waptemplate,pchtmlpath,waphtmlpath' );
	$arr = splits( $str, ',' );
	if ( $type == 'pc' ) {
		$path = SITE_DIR . 'template/pc/' . $tempath[ 'pctemplate' ] . $tempath[ 'pchtmlpath' ];
		$val = $arr[ 0 ];
	} else {
		$path = SITE_DIR . 'template/wap/' . $tempath[ 'waptemplate' ] . $tempath[ 'waphtmlpath' ];
		$val = isset( $arr[ 1 ] ) ? $arr[ 1 ] : $arr[ 0 ];
	}
	if ( !is_dir( $path ) ) return '';
	$handle = opendir( $path );
	while ( false !== ( $file = readdir( $handle ) ) ) {
		if ( $file != '.' && $file != '..' ) {
			$path2 = $path . $file;
			if ( preg_match( "/\.(htm|html|tpl)$/i", $file ) ) {
				$selected = $val == $file ? 'selected' : '';
				echo '<option value="' . $file . '" ' . $selected . '>' . $file . '</option>';
			}
		}
	}
}

function ad_name( $val ) {
	$adarr = array( 'couplet' => '对联广告', 'Fixed_button' => '固定底部', 'images' => '图片链接', 'pic' => '图片层', 'pop_right' => '右侧弹出', 'pop_up' => '上方落下', 'show_up' => '上方展开' );
	$name = isset( $adarr[ $val ] ) ? $adarr[ $val ] : $val;
	return $name;
}

function select_ad( $val = NULL ) {
	$list = '';
	$adlist = dir_list( PLUG_DIR . 'ad' );
	foreach ( $adlist as $folder ) {
		$selected = $val == $folder ? 'selected' : '';
		$name = ad_name( $folder );
		$list .= '<option value="' . $folder . '" ' . $selected . '>' . $name . '</option>';
	}
	return $list;
}

function select_face( $val = NULL ) {
	$list = '';
	$selected = '';
	$select = '';
	$facelist = file_list( PLUG_DIR . 'face' );
	foreach ( $facelist as $file ) {
		$selected = $val == $file ? 'selected' : '';
		$select .= $selected;
		$list .= '<option value="' . PLUG_PATH . 'face/' . $file . '" ' . $selected . '>' . PLUG_PATH . 'face/' . $file . '</option>';
	}
	if ( empty( $select ) && !empty( $val ) )$list .= '<option value="' . $val . '" selected>' . $val . '</option>';
	return $list;
}

// 目录文件列表
function file_list( $path ) {
	$list = array();
	if ( !is_dir( $path ) || !$filename = scandir( $path ) ) {
		return $list;
	}
	$files = count( $filename );
	for ( $i = 0; $i < $files; $i++ ) {
		$dir = $path . '/' . $filename[ $i ];
		if ( is_file( $dir ) ) {
			$list[] = $filename[ $i ];
		}
	}
	return $list;
}

// 目录下文件及文件夹列表
function path_list( $path ) {
	$list = array();    
	if ( !is_dir( $path ) || !$filename = scandir( $path ) ) {
		return $list;
	}
	$files = count( $filename );
	for ( $i = 0; $i < $files; $i++ ) {
		$dir = $path .$filename[ $i ];        
		if ( is_file( $dir ) || ( is_dir( $dir ) && $filename[ $i ] != '.' && $filename[ $i ] != '..' ) ) {           
			if ( strpos( $filename[ $i ], '.' ) !== FALSE ) {
				$file_arr = explode( '.', $filename[ $i ] );
				$file_ext = strtolower( end( $file_arr ) );
				$title=json_encode( $filename[ $i ]) === 'null' ? $filename[ $i ] : togbk($filename[ $i ]);
				$url =  substr($path . $title, strlen( $_SERVER[ 'DOCUMENT_ROOT' ] ) );
				$list[] = array(
					'dir' => $dir,
					'url' =>  $url,
					'name' => $title,
					'count' => 0,
					'ext' => $file_ext,
					'size' => formatnum( filesize( $dir ),'size' ),
					'mtime' => date( 'Y-m-d H:i:s', filemtime( $dir ) )
				);
			} else {
				$count = count( scandir( $path . $filename[ $i ] ) );
				$list[] = array(
					'dir' => $dir,
					'url' => substr( $dir, strlen( $_SERVER[ 'DOCUMENT_ROOT' ] ) ),
					'name' => $filename[ $i ],
					'count' => $count - 2,
					'ext' => '',
					'size' => formatnum( filesize( $dir ),'size' ),
					'mtime' => date( 'Y-m-d H:i:s', filemtime( $dir ) )
				);
			}

		}
	}
	return $list;
}
/*
	实例：
	set_dir(123, APP_PATH.'upload');
	
	000/000/1.jpg
	000/000/100.jpg
	000/000/100.jpg
	000/000/999.jpg
	000/001/1000.jpg
	000/001/001.jpg
	000/002/001.jpg
*/
function set_dir( $id, $dir = './' ) {
	$id = sprintf( "%09d", $id );
	$s1 = substr( $id, 0, 3 );
	$s2 = substr( $id, 3, 3 );
	$dir1 = $dir . $s1;
	$dir2 = $dir . "$s1/$s2";

	!is_dir( $dir1 ) && mkdir( $dir1, 0777 );
	!is_dir( $dir2 ) && mkdir( $dir2, 0777 );
	return "$s1/$s2";
}

// 取得路径：001/123
function get_dir( $id ) {
	$id = sprintf( "%09d", $id );
	$s1 = substr( $id, 0, 3 );
	$s2 = substr( $id, 3, 3 );
	return "$s1/$s2";
}

// 递归遍历目录
function get_folderlist( $pattern, $flags = 0 ) {
	$files = glob( $pattern, $flags );
	foreach ( glob( dirname( $pattern ) . '/*', GLOB_ONLYDIR | GLOB_NOSORT ) as $dir ) {
		$files = array_merge( $files, get_folderlist( $dir . '/' . basename( $pattern ), $flags ) );
	}
	return $files;
}


// 递归拷贝目录
function copy_dir( $src, $dst ) {
	substr( $src, -1 ) == '/'
	AND $src = substr( $src, 0, -1 );
	substr( $dst, -1 ) == '/'
	AND $dst = substr( $dst, 0, -1 );
	$dir = opendir( $src );
	!is_dir( $dst )AND mkdir( $dst );
	while ( FALSE !== ( $file = readdir( $dir ) ) ) {
		if ( ( $file != '.' ) && ( $file != '..' ) ) {
			if ( is_dir( $src . '/' . $file ) ) {
				copy_dir( $src . '/' . $file, $dst . '/' . $file );
			} else {
				copy_file( $src . '/' . $file, $dst . '/' . $file );
			}
		}
	}
	closedir( $dir );
    return is_dir($dst);
}

// 将变量写入到文件
function save_config( $replace = array() ) {
	$filepath = CONF_DIR . 'zzz_config.php';
	$arr = load_file( $filepath );
	foreach ( $replace as $k => $v ) {
		$arr = preg_replace( "/\'" . $k . "'=>'(\S*?)'/i", "'" . $k . "'=>'" . $v . "'", $arr );
	}
	return file_put_contents( $filepath, $arr );
}

function replace_file( $filepath, $key, $val ) {
	$arr = load_file( $filepath );
	$arr = preg_replace( "/" . $key . "='(\S*?)'/i", $key . "='" . $val . "'", $arr );
	return file_put_contents( $filepath, $arr );
}

function file_backname( $filepath ) {
	$dirname = dirname( $filepath );
	//$filename = file_name($filepath);
	$filepre = file_pre( $filepath );
	$fileext = file_ext( $filepath );
	$s = "$filepre.backup.$fileext";
	return $s;
}

function is_backfile( $filepath ) {
	return strpos( $filepath, '.backup.' ) !== FALSE;
}

// 备份文件
function file_backup( $filepath, $backfile = NULL ) {
	is_null( $backfile ) ? file_backname( $filepath ) : $backfile;
	if ( is_file( $backfile ) ) return TRUE; // 备份已经存在
	$r = copy_file( $filepath, $backfile );
	clearstatcache();
	return $r && filesize( $backfile ) == filesize( $filepath );
}

// 随机字符
function randname( $n = 16, $type = 'all' ) {
	if ( $type == 'num' ) {
		$str = '1234567890';
	} else {
		$str = '23456789ABCDEFGHJKMNPQRSTUVWXYZ';
	}
	$len = strlen( $str );
	$return = '';
	for ( $i = 0; $i < $n; $i++ ) {
		$r = mt_rand( 1, $len );
		$return .= $str[ $r - 1 ];
	}
	return $return;
}

// 检测文件是否可写，兼容 windows
function is_write( $file ) {
	if ( PHP_OS != 'WINNT' ) {
		return is_writable( $file );
	} else {
		// 如果是 windows，比较麻烦，这也只是大致检测，不够精准。
		if ( is_file( $file ) ) {
			$fp = fopen( $file, 'a+' );
			if ( !$fp ) return FALSE;
			fclose( $fp );
			return TRUE;
		} elseif ( is_dir( $file ) ) {
			$tmpfile = $file . uniqid() . '.tmp';
			$r = touch( $tmpfile );
			if ( !$r ) return FALSE;
			if ( !is_file( $tmpfile ) ) return FALSE;
			del_file( $tmpfile );
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

function copy_file( $src, $dest ) {
	check_dir( dirname( $dest ), true );
	$r = check_file( $src ) ? copy( $src, $dest ) : FALSE;
	return $r;
}

function new_dir( $dir, $mod = NULL, $recusive = NULL ) {
	$r = !is_dir( $dir ) ? mkdir( $dir, $mod, $recusive ) : FALSE;
	return $r;
}

function del_dir( $dir ) {
	$r = is_dir( $dir ) ? rmdir( $dir ) : FALSE;
	return $r;
}

function del_file( $file ) {
	if ( is_null( $file ) ) return FALSE;
	$file = is_file( $file ) ? $file : $_SERVER[ 'DOCUMENT_ROOT' ] . $file;
	if ( is_file( $file ) ) {
        if (ifstrin( $file,'runtime')){
            unlink( $file );
        }else{
            $ext = file_ext( $file );
            if ( in_array( $ext, array( 'php', 'db', 'mdb', 'tpl' ) ) ) return FALSE;
            if ( !unlink( $file ) ) {
                $r = @rename( $file, randname() );
            }
        }
	}
}

function size_file( $file ) {
	return is_file( $file ) ? filesize( $file ) : 0;
}

function time_file( $file ) {
	return is_file( $file ) ? filemtime( $file ) : 0;
}

// 判断文件是否是图片
function is_image( $path ) {
	$types = '.gif|.jpg|.jpeg|.png|.bmp'; // 定义检查的图片类型
	if ( is_file( $path ) ) {
		$info = getimagesize( $path );
		$ext = image_type_to_extension( $info[ '2' ] );
		return stripos( $types, $ext );
	} else {
		return false;
	}
}

// 递归删除目录，这个函数比较危险，传参一定要小心
function del_allfolder( $dir, $keepdir = 0 ) {
	if ( $dir == '/' || $dir == './' || $dir == '../' ) return FALSE; // 不允许删除根目录，避免程序意外删除数据。
	if ( !is_dir( $dir ) ) return FALSE;

	substr( $dir, -1 ) != '/'
	AND $dir .= '/';

	$files = glob( $dir . '*' ); // +glob($dir.'.*')
	foreach ( glob( $dir . '.*' ) as $v ) {
		if ( substr( $v, -1 ) != '.' && substr( $v, -2 ) != '..' )$files[] = $v;
	}
	$filearr = $dirarr = array();
	if ( $files ) {
		foreach ( $files as $file ) {
			if ( is_dir( $file ) ) {
				$dirarr[] = $file;
			} else {
				$filearr[] = $file;
			}
		}
	}
	if ( $filearr ) {
		foreach ( $filearr as $file ) {
			@unlink( $file );
		}
	}
	if ( $dirarr ) {
		foreach ( $dirarr as $file ) {
			del_allfolder( $file );
		}
	}
	if (!$keepdir) @rmdir($dir);
	return TRUE;
}
// 日志记录
function str_log( $s, $dir = 'error',$file = '' ) {
	$time = $_SERVER[ 'time' ];
	$ip = $_SERVER[ 'ip' ];
	$uid = intval( get_session( 'adminid' ) );
	$day = date( 'Ym', $time );
	$mtime = date( 'Y-m-d H:i:s' );
	$dbtype= $_SERVER[ 'conf' ]['db'];
	switch(	$dbtype['type']){
	case 'access':
		$name = md5( strtotime(date("Y-m-d"),time()).	$dbtype['accessname']) . ".zzz";
		break;
		case 'mysql':
		$name = md5( strtotime(date("Y-m-d"),time()).	$dbtype['user'].$dbtype['password']) . ".zzz";
		break;
		case 'sqlite':
		$name = md5( strtotime(date("Y-m-d"),time()).	$dbtype['sqlitename']) . ".zzz";
		break;
		default:
		$name = md5( strtotime(date("Y-m-d"),time()).conf('adminpath')) . ".zzz";
		break;
	}
	$url = isset( $_SERVER[ 'REQUEST_URI' ] ) ? $_SERVER[ 'REQUEST_URI' ] : '';
	$logpath = empty($file) ? RUN_DIR . $dir . '/' . $name : RUN_DIR . $dir . '/' . md5($file).".zzz";
    check_dir(dirname($logpath),true);
	is_array( $s )and $s = tojson( $s );
	$s = "$mtime\t$ip\t$url\t$uid\r\n$s\r\n";
	return error_log( $s, 3, $logpath );
}

/**
 * 文件上传
 *
 * @param string $input_name表单名称            
 * @param string $file_ext允许的扩展名            
 * @param number $max_width最大宽度            
 * @param number $max_height最大高度            
 * @return string 返回成功上传文件的路径数组
 */
function up_load() {
	$uptype = safe_word(getform( "uptype", "both" ));
	$upfolder = safe_word(getform( "upfolder", "both" ));
	$format = $_REQUEST[ "format" ];
	if ( isset( $REQUEST[ "name" ] ) ) {
		$fileName = safe_key($_REQUEST[ "name" ]);
	} elseif ( !empty( $_FILES ) ) {
		$fileName = $_FILES[ "file" ][ "name" ];
	}
	if ( isset( $fileName ) ) {
		$filearr = upload( $_FILES[ 'file' ], $uptype, $upfolder, $format );
	}
	echo tojson( $filearr );
}

function up_base64( $base64_img,$folder ) {
    $upfolder =  safe_word($folder);
	if ( conf( 'datefolder' ) == 1 ) {
		$save_path = SITE_DIR . conf( 'uploadpath' ) . $upfolder . '/' . date( 'Ymd' );
		check_dir( $save_path, true );
	} else {
		$save_path = SITE_DIR . conf( 'uploadpath' ) . $upfolder;
		check_dir( $save_path, true );
	}
	$newname = time() . mt_rand( 100000, 999999 );
	$file_path = $save_path . '/' . $newname . '.jpg';
	if ( file_put_contents( $file_path, base64_decode( $base64_img ) ) ) {
		$save_file = str_replace( SITE_DIR, SITE_PATH, $file_path );
		return  array( 'state' => 'SUCCESS', 'ext' => 'jpg', 'title' => $newname, 'url' => $save_file);
	} else {
		return array( 'state' => '上传类型不能为空！' );
	}
}

function upload( $file, $type, $folder, $format = NULL, $max_width = NULL, $max_height = NULL ) {
	if ( isset( $file ) ) {
		$files = $file;
	} elseif ( !isset( $_FILES[ $file ] ) ) {
			$files = $_FILES[ $file ];
		} else {
			return array();
		}
		// 定义允许上传的扩展
	if ( !isset( $type ) ) {
		return array( 'state' => '上传类型不能为空' );
	} else {
		switch ( $type ) {
			case 'file':
				$array_ext_allow = explode( ',', Conf( 'fileext' ) );
				$format = Conf( 'fileformat' );
				break;
			case 'video':
				$array_ext_allow = explode( ',', Conf( 'videoext' ) );
				$format = Conf( 'videoformat' );
				break;
			case 'image':
				$array_ext_allow = explode( ',', Conf( 'imageext' ) );
				$format = Conf( 'imageformat' );
				break;
			default:
				$array_ext_allow = explode( ',', strtolower( $type ) );
				break;
		}
	}
	if ( !$files[ 'error' ] ) {
		$upfile = $files[ 'name' ];
		$file_arr = explode( '.', $upfile );
		$file_ext = safe_word(strtolower( end( $file_arr )),'4');        
		$file_name = str_replace( '.' . end( $file_arr ), '', $upfile );
        if(empty($file_ext) || strpos($file_ext,'.')!==false) {
            return array( 'state' => '上传类型不能为空！' );
        }elseif ( in_array( $file_ext, array('php','asp','aspx','exe','sh','sql','bat') ) ) {
			return array( 'state' => $file_ext.'格式的文件不允许上传，请重新选择！' );
		} elseif ( !in_array( $file_ext, $array_ext_allow ) ) {
			return array( 'state' => $file_ext . '格式的文件不能上传，请重新选择！');
		}
		$savefile = array( 'state' => 'SUCCESS', 'ext' => $file_ext, 'title' => $file_name, 'url' => handle_upload( $files[ 'name' ], $files[ 'tmp_name' ], $array_ext_allow, $folder, $format, $file_name, $file_ext, $max_width, $max_height ) );
		return $savefile;
	} else {
		return $files[ 'error' ];
	}
}

// 处理并移动上传文件
function handle_upload( $file, $temp, $array_ext_allow, $folder, $format, $file_name, $file_ext, $max_width, $max_height ) {
	// 检查文件存储路径
	if ( conf( 'datefolder' ) == 1 ) {
		$save_path = SITE_DIR . conf( 'uploadpath' ) . $folder . '/' . date( 'Ymd' );
		check_dir( $save_path, true );
	} else {
		$save_path = SITE_DIR . conf( 'uploadpath' ) . $folder;
		check_dir( $save_path, true );
	}

	if ( $format == 'pinyin' ) {
		$newname = pinyin( $file_name );
	} elseif ( $format == 'yuanming' ) {
		$newname = toutf( $file_name );
	} else {
		$newname = time() . mt_rand( 100000, 999999 );
	}
	$file_path = $save_path . '/' . $newname . '.' . $file_ext;
	if ( is_file( $file_path ) ) {
		if ( conf( 'covermark' ) == 1 ) {
			del_file( $file_path );
		} else {
			$file_path = $save_path . '/' . $newname . mt_rand( 1000, 9999 ) . '.' . $file_ext;
		}
	}
	move_uploaded_file( $temp, $file_path ); // 从缓存中转存	
	$save_file = str_replace( SITE_DIR, SITE_PATH, $file_path );
	if ( $format == 'yuanming' )$save_file = togbk( $save_file );
	// 如果是图片进行等比例缩放
	if ( is_image( $file_path )) {
		resize_img( $file_path, $file_path, 0, Conf( 'compresswidth' ), Conf( 'compressheight' ),Conf( 'compressquality') );
	}
	return $save_file;
}

function cutpic($str){
	if(!ifstrin($str,",")) return $str;
	$arr=splits($str,",");
	$url=toutf($arr[0]);	
	$path= SITE_DIR . ltrim( trim($url), '/' );
	if(!is_image($path)) return($url);
	if(isset($arr[1])){
		$width=$arr[1];
		$height=isset($arr[2]) ? $arr[2] : $arr[1];
		//$newname=file_path($path).file_name($path).$width.'_'.$height.file_ext( $path );
		$picname=file_pre(file_name($url));
		$picname=ifch($picname) ? pinyin(togbk($picname)) : $picname;
		$newname= SITE_PATH . conf( 'uploadpath' ) . 'images/' .$width.'_'.$height.'/'.$picname.'.'.file_ext($url);
		if(check_file($newname)) return $newname;
		$mode=isset($arr[3]) ? $arr[3] : 5;
		$quality=isset($arr[4]) ? $arr[4] : 90;
		if(resize_img($path,$newname,$mode,$width,$height,$quality)) {
            return $newname;
        }else{
            return $str; 
        }         
	}else{
		return $str;
	}
}

/**
 * *
 * 等比缩放图片
 *
 * @param string $src_image源图片路径            
 * @param string $out_image输出图像路径            
 * @param number $max_width最大宽            
 * @param number $max_height最大高            
 * @param number $img_quality图片质量            
 * @return boolean 返回是否成功
 */
function resize_img( $src_image, $out_image = NULL, $img_mode = 0, $max_width = NULL, $max_height = NULL, $img_quality = 90 ) {
	if ( !is_file( $src_image ) ) return;
	if ( !$out_image )$out_image = $src_image; // 输出地址
	if (cleft($out_image,0,1)=="/" && substr_count($out_image,'/')<6) $out_image=SITE_DIR . ltrim( $out_image, '/' ) ;
	if ( !$max_width )$max_width = Conf( 'compresswidth' );
	if ( !$max_height )$max_height = Conf( 'compressheight' );
	// 获取图片属性
	list( $width, $height, $type, $attr ) = getimagesize( $src_image );
	if ( $width < $max_width && $height < $max_height ) {
		if ( $src_image != $out_image ) {
			copy( $src_image, $out_image );
			$src_image = $out_image;
		}
		return true;
	}
	switch ( $type ) {
		case 1:
			$img = imagecreatefromgif( $src_image );
			break;
		case 2:
			$img = imagecreatefromjpeg( $src_image );
			break;
		case 3:
			$img = imagecreatefrompng( $src_image );
			break;
	}
	// 求缩放比例
	switch ( $img_mode ) {
		case 0:
			$scale = min( $max_width / $width, $max_height / $height );
			break;
		case 2:
			$scale = $max_width / $width;
			break;
		case 3:
			$scale = $max_height / $height;
			break;
		default:
			$scale = max( $max_width / $width, $max_height / $height );
			break;
	}
	// 检查输出目录
	if ( $scale > 1 ) return false;
	check_dir( dirname( $out_image ), true );
	$new_width = floor( $scale * $width );
	$new_height = floor( $scale * $height );
	$new_img = imagecreatetruecolor( $new_width, $new_height );
	$start_x = 0;
	$start_y = 0;
	$judge = 1;
	if ( $img_mode > 3 ) {
		$judge = ( ( $width / $height ) > ( $max_width / $max_height ) );
		if ( $img_mode > 4 ) {
			$start_x = $judge ? ( $width * $scale - $max_width ) / 2 : 0;
			$start_y = !$judge ? ( $height * $scale - $max_height ) / 2 : 0;
		}
		imagecopyresampled( $new_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
		$new_img = imagecreatetruecolor( $max_width, $max_height );
	}
	imagecopyresampled( $new_img, $img, 0, 0, $start_x, $start_y, $new_width, $new_height, $width, $height );
	switch ( $type ) {
		case 1:
			imagegif( $new_img, $out_image, $img_quality );
			break;
		case 2:
			imagejpeg( $new_img, $out_image, $img_quality );
			break;
		case 3:
			imagepng( $new_img, $out_image, $img_quality / 10 ); // $quality参数取值范围0-99 在php 5.1.2之后变更为0-9
			break;
		default:
			imagejpeg( $new_img, $out_image, $img_quality );
	}
	imagedestroy( $new_img );
	return true;

	imagedestroy( $img );
	return false;
}

function down_url( $url, $save_dir='file', $filename = '', $type = 0 ) {
	if ( is_null( $url ) ) return array( 'msg' => '内容为空', 'state' => 'ERROR',  'error' => 1 );
	$save_dir = SITE_DIR.conf('uploadpath').$save_dir.'/';
	if ( trim( $filename ) == '' ) { //保存文件名 		
		$filename = file_name( $url );
		$file_ext = file_ext( $url );
	}else{		
		$file_ext = file_ext( $url );
	}
    if(empty($file_ext)) return array( 'msg' => '创建文件失败,禁止创建空文件！', 'state' => 'ERROR','error' => 5 );
    $allext=conf('imageext').conf('fileext').conf('videoext');    
	if(!in_array($file_ext,splits($allext,','))){
		return array( 'msg' => '创建文件失败,禁止创建'.$file_ext.'文件！', 'state' => 'ERROR',  'error' => 5 );
	}
	//创建保存目录 
	if ( !file_exists( $save_dir ) && !mkdir( $save_dir, 0777, true ) ) {
		return array( 'msg' => '创建文件夹失败', 'state' => 'ERROR',  'error' => 5 );
	}
	$file_dir = $save_dir . $filename;
	$file_path = str_replace( SITE_DIR, SITE_PATH, $file_dir );
	if ( file_exists( $file_dir ) )	del_file( $file_dir );
	//获取远程文件所采用的方法  
	if ( $type ) {
		$ch = curl_init();
		$timeout = 5;
		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, $timeout );
		$img = curl_exec( $ch );
		curl_close( $ch );
	} else {
		ob_start();
		readfile( $url );
		$img = ob_get_contents();
		ob_end_clean();
	}
	$fp2 = @fopen( $file_dir, 'a' );
	fwrite( $fp2, $img );
	fclose( $fp2 );
	unset( $img, $url );
	return array('state'=> 'SUCCESS','title' => $filename, 'dir' => $file_dir, 'ext' => $file_ext, 'url' => $file_path, 'error' => 0 );
}

function pinyin( $s, $sep = '' ) {
	include( SITE_DIR . "inc/zzz_pinyin.php" );
	$s = trim( $s );
	$len = strlen( $s );
	if ( $len < 3 ) return $s;
	$rs = '';
	for ( $i = 0; $i < $len; $i++ ) {
		$o = ord( $s[ $i ] );
		if ( $o < 0x80 ) {
			if ( ( $o >= 48 && $o <= 57 ) || ( $o >= 97 && $o <= 122 ) ) {
				$rs .= $s[ $i ]; // 0-9 a-z
			} elseif ( $o >= 65 && $o <= 90 ) {
				$rs .= strtolower( $s[ $i ] ); // A-Z
			}
			$rs .= $sep;
		} else {
			$z = $s[ $i ] . $s[ ++$i ] . $s[ ++$i ];
			if ( isset( $pinyin_map[ $z ] ) ) {
				$rs .= $pinyin_map[ $z ];
			}
			$rs .= $sep;
		}
	}
	return $rs;
}


//  加密   :encrypt('str','E','nowamagic');
//  解密   :encrypt('被加密过的字符串','D','nowamagic');
//  $string  :需要加密解密的字符串
//  $operation:判断是加密还是解密:E:加密  D:解密
//  $key   :加密的钥匙(密匙);

function encrypt( $string, $operation, $key = '' ) {
	$key = md5( $key );
	$key_length = strlen( $key );
	$string = $operation == 'D' ? base64_decode( $string ) : substr( md5( $string . $key ), 0, 8 ) . $string;
	$string_length = strlen( $string );
	$rndkey = $box = array();
	$result = '';
	for ( $i = 0; $i <= 255; $i++ ) {
		$rndkey[ $i ] = ord( $key[ $i % $key_length ] );
		$box[ $i ] = $i;
	}
	for ( $j = $i = 0; $i < 256; $i++ ) {
		$j = ( $j + $box[ $i ] + $rndkey[ $i ] ) % 256;
		$tmp = $box[ $i ];
		$box[ $i ] = $box[ $j ];
		$box[ $j ] = $tmp;
	}
	for ( $a = $j = $i = 0; $i < $string_length; $i++ ) {
		$a = ( $a + 1 ) % 256;
		$j = ( $j + $box[ $a ] ) % 256;
		$tmp = $box[ $a ];
		$box[ $a ] = $box[ $j ];
		$box[ $j ] = $tmp;
		$result .= chr( ord( $string[ $i ] ) ^ ( $box[ ( $box[ $a ] + $box[ $j ] ) % 256 ] ) );
	}
	if ( $operation == 'D' ) {
		if ( substr( $result, 0, 8 ) == substr( md5( substr( $result, 8 ) . $key ), 0, 8 ) ) {
			return substr( $result, 8 );
		} else {
			return '';
		}
	} else {
		return str_replace( '=', '', base64_encode( $result ) );
	}
}