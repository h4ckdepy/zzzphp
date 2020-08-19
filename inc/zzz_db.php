<?php
include 'zzz_db_access.php';
include 'zzz_db_mysql.php';
include 'zzz_db_sqlite.php';

// 此处的 $db 是局部变量，要注意，它返回后在定义为全局变量，可以有多个实例。
function db_new( $dbconf ) {
	global $errno, $errstr;
	// 数据库初始化，这里并不会产生连接！
	if ( $dbconf ) {
		//print_r($dbconf);
		// 代码不仅仅是给人看的，更重要的是给编译器分析的，不要玩 $db = new $dbclass()，那样不利于优化和 opcache 。
		switch ( $dbconf[ 'type' ] ) {
			case 'access':
				$db = new db_pdo_access( $dbconf );
				break;
			case 'mysql':
				$db = new db_pdo_mysql( $dbconf );
				break;
			case 'sqlite':
				$db = new db_pdo_sqlite( $dbconf );
				break;			
		}
        if ( !$db || ( $db && $db->errstr ) ) {			
            error("数据库连接失败,$db->errstr");
            return FALSE;
        }   
	return $db;
    }
}

// 测试连接
function db_connect( $d = NULL ) {
	$db = $_SERVER[ 'db' ];
	$d = $d ? $d : $db;
	$r = $d->connect();
	db_errno_errstr( $r, $d );
	return $r;
}

function db_close( $d = NULL ) {
	$db = $_SERVER[ 'db' ];
	$d = $d ? $d : $db;
	$r = $d->close();
	db_errno_errstr( $r, $d );
	return $r;
}

function db_subsort( $sid ) {
	$d = $_SERVER[ 'db' ];
	if ( is_array( $sid ) ) {
		if ( count( $sid ) > 1 ) {
			return $sid;
		} else {
			$sid = $sid[ 0 ];
		}
	}
	$r = $d->getsubsort( $sid );
	return $r;
}

function db_table_list($d = NULL) {
	$db = $_SERVER[ 'db' ];
	$d = $d ? $d : $db;
	$sql = 'SHOW TABLES';
	$r = $d->sql_query( $sql );
	return $r;
}

function db_table_create( $table ) {
	$d = $_SERVER[ 'db' ];
	$sql = "SHOW CREATE TABLE `{$table}`";
	$r = $d->sql_query( $sql );
	return $r[ 0 ][ 1 ] . ';';
}

function db_table_data( $table ) {
	$d = $_SERVER[ 'db' ];
	$sql = "SHOW COLUMNS FROM `{$table}`";
	$columns = '';
	$query = '';
	$list = $d->sql_query( $sql );
	foreach ( $list as $value ) {
		$columns .= "`{$value[0]}`,";
	}
	$columns = substr( $columns, 0, -1 );
	$data = $d->sql_query( "SELECT * FROM `{$table}`" );
	foreach ( $data as $value ) {
		$dataSql = '';
		foreach ( $value as $v ) {
			$dataSql .= "'{$v}',";
		}
		$dataSql = substr( $dataSql, 0, -1 );
		$query .= "INSERT INTO `{$table}` ({$columns}) VALUES ({$dataSql});\r\n";
	}
	return $query;
}

function db_load_sql_one( $sql, $d = NULL ) {
	$db = $_SERVER[ 'db' ];
	$d = $d ? $d : $db;
	if ( !$d ) return FALSE;
	$sql = str_replace( '[dbpre]', DB_PRE, $sql );
	$arr = $d->sql_find_one( $sql );
	db_errno_errstr($arr, $d, $sql);
	return $arr;
}

function db_load_sql( $sql, $key = NULL, $d = NULL ) {
	$db = $_SERVER[ 'db' ];
	$d = $d ? $d : $db;
	if ( !$d ) return FALSE;
	$sql = str_replace( '[dbpre]', DB_PRE, $sql );
	$arr = $d->sql_find( $sql, $key );
	db_errno_errstr($arr, $d, $sql);
	return $arr;
}

function db_load( $table, $where = array(), $col = array(), $pagesize = 1000, $orderby = array(), $page = 1, $key = '', $d = NULL ) {
	$db = $_SERVER[ 'db' ];
	// 高效写法，定参有利于编译器优化
	$d = $d ? $d : $db;
	if ( !$d ) return FALSE;
	return $d->find( $table, $where, $orderby, $page, $pagesize, $key, $col );
}

function db_load_one( $table, $where = array(), $col = array(), $orderby = NULL, $d = NULL ) {
	$db = $_SERVER[ 'db' ];
	$d = $d ? $d : $db;
	if ( !$d ) return FALSE;
	if ( ifnum( $where ) ) {
		$where = table_id( $table ) . '=' . $where;
	} else {
		$where = str_replace( '&', ' and ', $where );
	}
	return $d->find_one( $table, $where, $orderby, $col );
}

// 如果为 INSERT 或者 REPLACE，则返回 mysql_insert_id();
// 如果为 UPDATE 或者 DELETE，则返回 mysql_affected_rows();
// 对于非自增的表，INSERT 后，返回的一直是 0
// 判断是否执行成功: mysql_exec() === FALSE
function db_exec( $sql, $d = NULL ,$log=true) {
	$db = $_SERVER[ 'db' ];
	$d = $d ? $d : $db;
	if ( !$d ) return FALSE;
	$sql = str_replace( '[dbpre]', DB_PRE, $sql );
	$n = $d->exec( $sql );	
	db_errno_errstr( $n, $d,$sql);
	str_log( $sql."\t" , 'log' );
	return $n;
}

function db_count( $table, $where = array(), $d = NULL ) {
	$db = $_SERVER[ 'db' ];
	$d = $d ? $d : $db;
	if ( !$d ) return FALSE;
	$r = $d->count( $table, $where );
	return $r;
}

function db_maxid( $table, $field, $where = array(), $d = NULL ) {
	$db = $_SERVER[ 'db' ];
	$d = $d ? $d : $db;
	if ( !$d ) return FALSE;
	if ( $field == 'id' )$field = table_id( $table );
	$r = $d->maxid(  $table, $field, $where );
	return $r;
}

function db_select( $table, $field, $where, $orderby = NULL, $d = NULL ) {
	$db = $_SERVER[ 'db' ];
	$d = $d ? $d : $db;
	if ( !$d ) return FALSE;
	$table= db_tableby_to_sqladd($table);
	$sql = 'select ' . $field . ' as val from ' .  $table . db_cond_to_sqladd( $where ) . db_orderby_to_sqladd( $orderby );
	$arr = $d->sql_find_one( $sql );
	return !empty( $arr ) ? $arr[ 'val' ] : $arr;
}

// NO SQL 封装，可以支持 MySQL Marial PG MongoDB
function db_create( $table, $id, $arr, $d = NULL ) {
	$db = $_SERVER[ 'db' ];
	$d = $d ? $d : $db;
	if ( !$d ) return FALSE;
	$type = $_SERVER[ 'conf' ][ 'db' ][ 'type' ];
	$sqladd = db_array_to_create_sqladd( $arr, $type );
	if ( !$sqladd ) return FALSE;
	switch ( $type ) {
		case "mysql":
			db_exec( "DROP TABLE IF EXISTS [dbpre]$table" );
			$sqladd=str_replace('add `','`',$sqladd);
			db_exec( "CREATE TABLE [dbpre]$table(`$id` int(11) NOT NULL AUTO_INCREMENT,$sqladd ,PRIMARY KEY (`$id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1" );
			break;
		case "access":
			db_exec( "DROP TABLE [dbpre]$table" );
			db_exec( "CREATE TABLE [dbpre]$table(`$id` AUTOINCREMENT PRIMARY KEY NOT NULL, $sqladd)" );
			break;
		case "sqlite":
			db_exec( "DROP TABLE IF EXISTS  [dbpre]$table" );
			db_exec( "CREATE TABLE [dbpre]$table(`$id` INTEGER PRIMARY KEY AUTOINCREMENT, $sqladd )" );
			break;
	}
}

function db_add( $table, $arr, $d = NULL ) {
	$db = $_SERVER[ 'db' ];
	$d = $d ? $d : $db;
	if ( !$d ) return FALSE;
	$type = $_SERVER[ 'conf' ][ 'db' ][ 'type' ];
	if ( $type == "sqlite" ) {
		foreach ( $arr as $key => $val ) {
			$sqladd = db_array_to_create_sqladd( array( $key => $val ), $type );
			db_exec( "ALTER TABLE [dbpre]$table ADD $sqladd" );
		}
	} else {
		$sqladd = db_array_to_create_sqladd( $arr, $type );
		if ( !$sqladd ) return FALSE;
		db_exec( "ALTER TABLE [dbpre]$table $sqladd" );
	}
}

function db_drop( $table, $arr, $d = NULL ) {
	$db = $_SERVER[ 'db' ];
	$d = $d ? $d : $db;
	if ( !$d ) return FALSE;
	$type = $_SERVER[ 'conf' ][ 'db' ][ 'type' ];
	if ( $type == "sqlite" ) return '';
	foreach ( $arr as $val ) {
		db_exec( "ALTER TABLE [dbpre]$table DROP $val" );
	}
}

function db_insert( $table, $arr, $d = NULL) {
	$db = $_SERVER[ 'db' ];
	$d = $d ? $d : $db;
	if ( !$d ) return FALSE;
	$sqladd = db_array_to_insert_sqladd( $arr );
	if ( !$sqladd ) return FALSE;
	$id = db_exec( "INSERT INTO [dbpre]$table $sqladd", $d );
	if ( DB_TYPE == 'access' ) {
		return db_maxid( $table, table_id( '$table' ) );
	} else {
		return $id;
	}
}

function db_replace( $table, $arr, $d = NULL ) {
	$db = $_SERVER[ 'db' ];
	$d = $d ? $d : $db;
	if ( !$d ) return FALSE;
	$sqladd = db_array_to_insert_sqladd( $arr );
	if ( !$sqladd ) return FALSE;
	return db_exec( "REPLACE INTO [dbpre]$table $sqladd", $d );
}

function db_update( $table, $where, $update, $d = NULL ) {
	$db = $_SERVER[ 'db' ];
	$d = $d ? $d : $db;
	if ( !$d ) return FALSE;
	if ( ifnum( $where ) ) {
		$where = table_id( $table ) . '=' . $where;
	}
	$whereadd = db_cond_to_sqladd( $where );
	$sqladd = db_array_to_update_sqladd( $update );
	if ( !$sqladd ) return FALSE;
	return db_exec( "UPDATE [dbpre]$table SET $sqladd $whereadd", $d );
}

function db_delete( $table, $where, $d = NULL ) {
	$db = $_SERVER[ 'db' ];
	$d = $d ? $d : $db;
	if ( !$d ) return FALSE;
	if ( ifnum( $where ) ) {
		$where = table_id( $table ) . '=' . $where;
	} elseif ( is_array( $where ) ) {
		$arrkey = array_keys( $where );
		if ( $arrkey[ 0 ] === 0 ) {
			$where = array( table_id( $table ) => $where );
		}
	} elseif ( $where == 'recy' ) {
		if ( $table == 'content' )$where = array( 'c_onoff' => 2 );
	}
	$whereadd = db_cond_to_sqladd( $where );
	return db_exec( "DELETE FROM [dbpre]$table $whereadd", $d );
}

function db_remove( $table, $where, $onoff, $d = NULL ) {
	$db = $_SERVER[ 'db' ];
	$d = $d ? $d : $db;
	if ( !$d ) return FALSE;
	$where = array( table_id( $table ) => $where );
	$whereadd = db_cond_to_sqladd( $where );
	$sqladd = $table == 'content' ? 'c_onoff=' . $onoff : 's_onoff=' . $onoff;
	if ( !$sqladd ) return FALSE;
	return db_exec( "UPDATE [dbpre]$table SET $sqladd $whereadd", $d );
}

function table_id( $table ) {
	if ( in_array( $table, load_model()) ) return 'cid';
	switch ( $table ) {
		case 'ad':
			return 'adid';
			break;
		case 'about':
			return 'aid';
			break;
		case 'brand':
			return 'bid';
			break;
		case 'content':
			return 'cid';
			break;	
		case 'sort':
			return 'sid';
			break;
		case 'gbook':
			return 'gid';
			break;
		case 'content_custom':
			return 'customid';
			break;
		case 'labels':
			return 'labelid';
			break;
		case 'language':
		case 'links':
			return 'lid';
			break;
		case 'log_dbsql':
		case 'log_err':
			return 'logid';
			break;
		case 'log_dbbackup':
			return 'id';
			break;
		case 'slide':
			return 'slideid';
			break;
		case 'tag':
			return 'tid';
			break;
		case 'user':
			return 'uid';
			break;
		case 'user_group':
			return 'gid';
			break;
		case 'model':
			return 'model_id';
			break;
		case 'menu':
			return 'mid';
			break;
		case 'screen':
			return 'screenid';
			break;
		case 'order':
			return 'orderid';
			break;
		default:
			return 'id';
	}
}

function db_table( $table ) {
	$arr = load_model();
	if ( in_array( $table, $arr ) ) {
		return 'content';
	} else {
		return $table;
	}
}

function db_truncate( $table, $d = NULL ) {
	$db = $_SERVER[ 'db' ];
	$d = $d ? $d : $db;
	if ( !$d ) return FALSE;
	return $d->truncate( DB_PRE.$table );
}

function db_istable( $table, $d = NULL ) {
	$db = $_SERVER[ 'db' ];
	$d = $d ? $d : $db;
	if ( !$d ) return FALSE;
	return $d->istable( $table );
}

function db_read( $table, $where, $d = NULL ) {
	$db = $_SERVER[ 'db' ];
	$d = $d ? $d : $db;
	if ( !$d ) return FALSE;
	$sqladd = db_cond_to_sqladd( $where );
	$sql = "SELECT * FROM [dbpre]$table $sqladd";
	return db_load_sql_one( $sql, $d );
}

function check_model( $str ) {
	if ( $str == "about" || $str == "brand" ) {
		$sql = "select model_type,model_name  from [dbpre]model where model_onoff=1 and model_type='" . $str . "'";
	} elseif ( !empty( $str ) ) {
		$sql = "select model_type,model_name from [dbpre]model where model_onoff=1 and model_table='content'";
	} else {
		$sql = "select model_type,model_name  from [dbpre]model where model_onoff=1 and not(model_list_tp='-' or model_type='gbook')";
	}
	$data = db_load_sql( $sql );
	foreach ( $data as $value ) {
		$i = $value[ 'model_type' ];
		$name = ( $value[ 'model_name' ] );
		$sel = in_array( $i, splits( $str, ',' ) ) ? 'checked' : '';
		echo "  <div class='checkbox checkbox-success checkbox-inline'><input type='checkbox' value='" . $i . "' " . $sel . " name='customtype[]' id='" . $i . "'><label for=" . $i . "> " . $name . " </label></div>";
	}
}

function select_model( $str = NULL, $type = NULL ) {
	if ( $type == 'all' ) {
		$where = array( 'model_onoff' => 1, 'model_table' => array( 'about', 'brand', 'content' ) );
	} elseif ( $type =='old' ) {
		$where = array('model_type'=>array('about','brand','product','news','job','down','case','video','photo') );
	} elseif ( is_null( $type ) ) {
		$where = array( 'model_onoff' => 1 );	
	} else {
		$where = array( 'model_onoff' => 1, 'model_table' => $type );
	}
	$data = db_load( "model", $where, "model_id,model_name,model_type,model_list_tp,model_list_fd,model_content_tp,model_content_fd,model_list_name,model_content_name,model_table" );
	foreach ( $data as $value ) {
		$select = $str == $value[ 'model_type' ] ? 'selected' : '';
		echo '<option stp="' . $value[ 'model_list_tp' ] . '" ctp="' . $value[ 'model_content_tp' ] . '" sfd="' . $value[ 'model_list_fd' ] . '" cfd="' . $value[ 'model_content_fd' ] . '" sname="' . $value[ 'model_list_name' ] . '" cname="' . $value[ 'model_content_name' ] . '" value="' . $value[ 'model_type' ] . '" ' . $select . '>' . ( $value[ 'model_name' ] ) . '</option>';
	}
}

function check_group( $type, $str, $pid = 0 ) {
	$thisarr = explode( ',', $str );
	$typearr =load_model(); 
	if ( $type == 'menu' ) {
		$data = db_load_sql( 'select mid, m_name,m_level,(select count(*) from [dbpre]menu as b where m_onoff=1 and b.pid=a.mid ),m_key from [dbpre]menu as a where m_onoff=1 and pid=' . $pid . ' order by m_order asc,mid asc' );
	} elseif ( $type == 'sort' ) {
		$data = db_load_sql( 'select sid, s_name,s_level,(select count(*) from [dbpre]sort as b where s_onoff=1 and b.s_pid=a.sid ),s_type from [dbpre]sort as a where s_onoff=1 and s_pid=' . $pid . ' order by s_order asc,sid asc' );
	}
	foreach ( $data as $value ) {
		$value = array_values( $value );
		$checked = in_array( $value[ 0 ], $thisarr ) ? "checked" : '';
		$count = in_array( $value[ 4 ], $typearr ) ? '(' . db_count( 'content', array( 'c_type' => $value[ 4 ] ) ) . ')': '';
		if ( $pid == 0 ) {
			echo "<label class='checkbox-inline i-checks'><input class='checkbox top" . $type . "' " . $checked . " type='checkbox' name='g_" . $type . "[]' value='" . $value[ 0 ] . "'><strong>" . ( $value[ 1 ] ) . "</strong></label>";
		} else {
			echo "<label class='checkbox-inline'><input class='checkbox " . $type . $pid . "' " . $checked . " type='checkbox' name='g_" . $type . "[]' value='" . $value[ 0 ] . "'>" . ( $value[ 1 ] ) . $count . "</label>";
		}
		if ( $value[ 3 ] > 0 )check_group( $type, $str, $value[ 0 ] );
	}
	if ( $value[ 2 ] == 2 )echo '</br>';
}


function select_brand( $label, $name ) {
	$where = array( 'b_onoff' => 1 );
	$label = ifnum( $label ) ? $label : 1;
	$width = 6 - $label;
	$bname = db_select( 'model', 'model_name', array( 'model_type' => 'brand' ) );
	$data = db_load( 'brand', $where, 'bid,b_name' );
	if ( count( $data ) > 0 ) {
		echo '<label class="col-sm-' . $label . ' control-label">' . $bname . '</label><div class="col-sm-' . $width . '"> <select name="c_brand" class="form-control"></div><option></option>';
		foreach ( $data as $value ) {
			$sel = ( $value[ 'b_name' ] == $name ) ? "selected='selected'" : '';
			echo "<option value='" . $value[ 'b_name' ] . "' " . $sel . ">" . $value[ 'b_name' ] . "</option>";
		}
		echo '</select></div>';
	}
}
//分类管理中的选择分类
function select_sort( $type, $sid = 0, $pid = 0 ) {
    $adminsort=get_session('adminsort'); 
     $r='';$child=0;
    $adminsort=empty($adminsort)||$adminsort=='all'  ? '' : splits($adminsort,',');
    if ($type){
        $data=db_load('sort',array('s_onoff'=>1,'s_type'=>$type),'sid,s_pid,s_name,s_level as level,s_type','1000',array('s_order'=>'asc','sid'=>'desc'));
    }else{
        $data=db_load('sort',array('s_onoff'=>1),'sid,s_pid,s_name,s_level as level,s_type','1000',array('s_order'=>'asc','sid'=>'desc'));                
    }
	if($data){
        $list=get_tree($data,'sid','s_pid');
        foreach ( $list as $value ) {            
            if(!empty( $adminsort) && !in_array($value['sid'],$adminsort))  continue;  
            if($value['level']==0) $i=0;
            $sel = $value[ 'sid' ] == $sid  ? "selected='selected'" : '';
            $child=$value['child']>0 ? $value['child'] : $child;
			$r.= "<option value='" . $value[ 'sid' ] . "' " . $sel . ">" .ico_level($value['level'],$i,$child) .  $value['s_name']. "</option>";
            $i++;
		}
	}
    return $r;
}
//内容管理中的选择分类
function select_sort_content( $type, $sid = 0, $pid = 0 ) {
    $adminsort=get_session('adminsort'); 
    $r='';$sel='';$dis='';$child=0;$level=1;
    $adminsort=empty($adminsort)|| $adminsort=='all'  ? '' : splits($adminsort,',');
    $data=db_load('sort',array('s_onoff'=>1),'sid,s_pid,s_name,s_level as level,s_type','1000',array('s_order'=>'asc','sid'=>'desc'));
    $list=get_tree($data,'sid','s_pid');   
	foreach ( $list as $value ) { 
        if(!empty( $adminsort) && !in_array($value['sid'],$adminsort))  continue;  
        if($value['level']!=$level) $i=1;
		    $dis = $type != $value[ 's_type' ] ?  " disabled='disabled'" : '';
			$sel = $value[ 'sid' ] == $sid  ? "selected='selected'" : '';
            $child=$value['child']>0 ? $value['child'] : $child;
            $level=$value['level'];
			$r.= "<option value='" . $value[ 'sid' ] . "' " . $sel .$dis . ">" . ico_level($level,$i,$child) .  $value['s_name']. "</option>";
            $i++;
		
	}
    return $r;
}

function select_custom_class( $num = 99 ) {
	switch ( $num ) {
		case '0':
		case '11':
			$getCustomClass = "<option value='11' selected>文本</option>";
			break;
		case '10':
			$getCustomClass = "<option value='10' selected>日期时间</option>
								<option value='11'>文本</option>";
			break;	
		case '1':
			$getCustomClass = "<option value='1' selected>数字</option>
								<option value='11'>文本</option>";			
			break;
		case '2':
		case '3':
			$getCustomClass = "<option value='2' " . check_on( $num, 2, 'selected' ) . ">文本域</option>" .
			"<option value='3' " . check_on( $num, 3, 'selected' ) . ">编辑器</option>";
			break;
		case '4':
		case '5':
		case '6':
			$getCustomClass = "<option value='4' " . check_on( $num, 4, 'selected' ) . ">单选</option>" .
			"<option value='5' " . check_on( $num, 5, 'selected' ) . ">多选</option>" .
			"<option value='6' " . check_on( $num, 6, 'selected' ) . ">下拉</option>";
			break;
		case '7':
		case '8':
		case '9':
			$getCustomClass = "<option value='7' " . check_on( $num, 7, 'selected' ) . ">文件上传</option>" .
			"<option value='8' " . check_on( $num, 8, 'selected' ) . ">图片上传</option>" .
			"<option value='9' " . check_on( $num, 9, 'selected' ) . ">视频上传</option>";
			break;
		default:
			$getCustomClass = "<option value='11'>文本</option>" .
			"<option value='1'>数字</option>" .
			"<option value='2'>文本域</option>" .
			"<option value='3'>编辑器</option>" .
			"<option value='4'>单选</option>" .
			"<option value='5'>多选</option>" .
			"<option value='6'>下拉</option>" .
			"<option value='7'>文件上传</option>" .
			"<option value='8'>图片上传</option>" .
			"<option value='9'>视频上传</option>" .
			"<option value='10'>日期时间</option>";
	}
	return $getCustomClass;
}

function check_used( $table,$col,$val,$id=0 ) {
	if ( empty($table )|| empty($col) ||  empty($val) ) return false;
	$where=$id>0 ? array($col=>$val,table_id( $table )=>array('<>'=>$id)) :  array($col=>$val);
	if ( db_count($table,$where) > 0 ) {
		return true;
	} else {
		return false;
	}
}

function countdate( $str ) {
	$arr = splits( $str, ',' );
	$type = $arr[ 0 ];
	$val = $arr[ 1 ];
	if(ifstrin($val,'=')){
		$val=danger_key($val);
		return db_count( $type, $val);
	}else{
		if ($type == 'sort' ) {
			return db_count( 'sort', array( 'sid' => db_subsort( $val ),'s_onoff'=>1 ) );
		} elseif ( $type == 'content' ) {
			return db_count( 'content', array( 'c_sid' => db_subsort( $val ),'c_onoff'=>1 ) );
		} elseif ( $type == 'brand' ) {
			return db_count( 'content', array( 'c_brand' => $val,'c_onoff'=>1 ) );	
		} elseif ( $type == 'tag' ) {
			return db_count( 'content', array( 'c_tag' => array('LIKE'=>$val) ,'c_onoff'=>1));		
		} 
	}
}

function select_test( $val = NULL ) {
	$data = array( '必填' => 's', '手机' => 'm', '邮箱' => 'e', '邮编' => 'p', '数字' => 'n' );
	$r = "<option value=''>可空</option>";
	foreach ( $data as $key => $value ) {
		$selected = $val == $value ? 'selected' : '';
		$r .= "<option value='" . $value . "' " . $selected . ">" . $key . "</option>";
	}
	return $r;
}

function get_custom_name( $num ) {
	switch ( $num ) {
		case '1':
			$getCustomname = "数字";
			break;
		case '2':
			$getCustomname = "文本域";
			break;
		case '3':
			$getCustomname = "编辑器";
			break;
		case '4':
			$getCustomname = "单选";
			break;
		case '5':
			$getCustomname = "多选";
			break;
		case '6':
			$getCustomname = "下拉";
			break;
		case '7':
			$getCustomname = "文件上传";
			break;
		case '8':
			$getCustomname = "图片上传";
			break;
		case '9':
			$getCustomname = "视频上传";
			break;
		case '10':
			$getCustomname = "日期时间";
			break;
		default:
			$getCustomname = "文本";
			break;
	}
	return $getCustomname;
}

function echo_custom( $class, $name, $title, $value, $options, $plase ) {
	switch ( $class ) {
		case '1':
			$r = ' <input type="number" name="' . $name . '" id="' . $name . '" value="' . $value . '" datatype="' . $plase . '">';
			break;
		case '2':
			$r = "<textarea class='textarea form-control'   name='" . $name . "' id='" . $name . "'  datatype='" . $place . "'>" . $value . "'</textarea>";
			break;
		case '4':
		case '5':
		case '6':
			$options = str_replace( '，', ',', $options );
			$splitvalue = splits( $options, "," );
			$i = 0;
			if ( $class == 6 ) {
				$r = "<div class='select'><select name='" . $name . "' id='" . $name . "'>";
			} else {
				$r = '';
			}
			foreach ( $splitvalue as $val ) {
				$i++;
				if ( $val == $value ) {
					$checkstr = "checked";
					$selectstr = "selected";
				} else {
					$checkstr = "";
					$selectstr = "";
				}
				if ( $class == 4 )$r .= "<div class='radio'><input type='radio' id='" . $name . $i . "' name='" . $name . "' " . $checkstr . " value='" . $val . "'/><label for='" . $name . $i . "'>" . $val . "</label></div>";
				if ( $class == 5 )$r .= "<div class='checkbox'><input type='checkbox' id='" . $name . $i . "' name='" . $name . "[]' " . $checkstr . " value='" . $val . "'/><label for='" . $name . $i . "'>" . $val . "</label></div>";
				if ( $class == 6 )$r .= " <option value='" . $val . "' " . $selectstr . ">" . $val . "</option>";
			}
			if ( $class == 6 )$r .= " </select>";
			break;
		default:
			$r = ' <input type="text" name="' . $name . '" id="' . $name . '" value="' . $value . '" datatype="' . $plase . '">';
	}
	return $r;
}

function select_group( $gid, $gtype = 0 ) {
	if ( $gtype == 1 ) {
		$adminmark = get_session( "adminmark" );
		$data = db_load( 'user_group', 'isadmin=1 and g_onoff=1 and g_mark<=' . $adminmark, 'gid,g_name' );
	} else {
		$data = db_load( 'user_group', 'isadmin<>1 and g_onoff=1', 'gid,g_name' );
	}
	echo '<option value="0">选择会员级别</option>';
	foreach ( $data as $value ) {
		$sel = ( $value[ 'gid' ] == $gid ) ? "selected='selected'" : '';
		echo '<option value="' . $value[ 'gid' ] . '" ' . $sel . '>' . $value[ 'g_name' ] . '</option>';
	}
}

function select_user( $uid, $gtype = 0 ) {
	if ( $gtype == 1 ) {
		$data = db_load_sql( 'select uid,username from [dbpre]user,[dbpre]user_group where isadmin=1 and u_onoff=1 and u_gid=gid order by uid desc' );
	} else {
		$data = db_load_sql( 'select uid,username from [dbpre]user,[dbpre]user_group where isadmin<>1 and u_onoff=1 and u_gid=gid order by uid desc' );
	}
	foreach ( $data as $value ) {
		$sel = ( $value[ 'uid' ] == $uid ) ? "selected='selected'" : '';
		echo '<option value="' . $value[ 'uid' ] . '" ' . $sel . '>' . $value[ 'username' ] . '</option>';
	}
}

//声明静态數组,避免递归调用时,多次声明导致數组覆盖
function get_tree($array,$idname,$pidname, $pid =0, $level = 0){	
	static $list = array();
	if($level==0) $list= array();	
	if($array){
		foreach ($array as $key => $v){
			$v['child'] = haschild($array,$pidname,$v[$idname]);				
			if  ($v[$idname] == $pid&& $level == 0 ){
				$v['level'] =0;
				$list[] = $v;
			}
			if ($v[$pidname] == $pid ){
				$v['level'] = $level;
				//把數组放到list中
				$list[] = $v;
				unset($array[$key]);
				get_tree($array,$idname,$pidname, $v[$idname], $level+1);

			}
		}
	}
	return $list;
}
//判断是否有下级
function haschild($array,$name,$pid){
	$n = 0;
	foreach($array as $v){
		if($v[$name]==$pid){
			$n+=1;			
		}
	}
	return $n;
}

function ico_level( $l, $i, $c ) {     
	$a = '';
    if(!$l) return '';    
	for ( $k = 1; $k < $l; $k++ ) {
		$a .= '&nbsp;&nbsp;';
	}    
	if ( $i == $c ) {
		$b = '└';
	} else {
		$b = '├';
	}
	return $a . $b;
}

function getprev( $sid, $cid, $type = 'a' ) {
	$data = db_load_one( 'content', 'c_onoff=1 and CID<' . $cid . ' and C_sid=' . $sid, 'cid,c_title,c_type,c_pic,c_pagename,c_link', 'cid desc' );
	if ( is_array( $data ) ) {
		$title = $data[ 'c_title' ];        
		switch ( $type ) {
			case 'a':
				return "<a class='newsnext'  title='" . $title . "' href='" . getcontentlink( $data[ 'cid' ], $data[ 'c_pagename' ],$data['c_type'], $data[ 'c_link' ] ) . "'>" . $title . "</a>";
				break;
			case 'title':
				return $title;
				break;
            case 'pic':
                $pic=check_file($data[ 'c_pic' ]) ?  $data[ 'c_pic' ] : SITE_PATH.'images/nopic.gif';
				return $pic;
				break;    
			case 'link':
				return getcontentlink( $data[ 'cid' ], $data[ 'c_pagename' ],$data['c_type'],$data[ 'c_link' ] );
				break;
		}
	}
}

function getnext( $sid, $cid, $type = 'a' ) {
	$data = db_load_one( 'content', 'c_onoff=1 and CID>' . $cid . ' and C_sid=' . $sid, 'cid,c_title,c_type,c_pic,c_pagename,c_link', 'cid asc' );
	if ( is_array( $data ) ) {
		$title = $data[ 'c_title' ];
		switch ( $type ) {
			case 'a':
				return "<a class='newsprev'  title='" . $title . "' href='" . getcontentlink( $data[ 'cid' ], $data[ 'c_pagename' ],$data['c_type'], $data[ 'c_link' ] ) . "'>" . $title . "</a>";
				break;
			case 'title':
				return $title;
				break;
            case 'pic':
                $pic=check_file($data[ 'c_pic' ]) ?  $data[ 'c_pic' ] : SITE_PATH.'images/nopic.gif';
				return $pic;
				break;    
			case 'link':
				return getcontentlink( $data[ 'cid' ], $data[ 'c_pagename' ], $data['c_type'],$data[ 'c_link' ] );
				break;
		}
	}
}

function select_region( $type, $s = NULL, $json = 'option' ) {
	$arr = splits( $type, ',' );
	$type = $arr[ 0 ];
	$val = isset( $arr[ 1 ] ) ? $arr[ 1 ] : $s;
	if ( is_null( $s ) ) {
		$title = isset( $arr[ 2 ] ) ? $arr[ 2 ] : $val;
	} else {
		$title = $s;
	}
	switch ( $type ) {
		case 'p':
			$data = db_load( 'region', 'pid=0', 'rid,title,telcode,zipcode' );
			break;
		case 'c':
		case 'd':
			$data = db_load_sql( "select rid,title,telcode,zipcode from [dbpre]region where pid=(select rid from [dbpre]region where title='" . $val . "')" );
			break;
	}
	if ( !$data ) return false;
	if ( $json == 'option' ) {
		$r = '<option>请选择</option>';
		foreach ( $data as $value ) {
			$select = $value[ 'title' ] == $title ? 'selected' : '';
			$r .= '<option value="' . $value[ 'title' ] . '" ' . $select . ' data-id="' . $value[ 'rid' ] . '" data-zip="' . $value[ 'zipcode' ] . '" data-tel="' . $value[ 'telcode' ] . '">' . $value[ 'title' ] . '</option>';
		}
	} else {
		$r = tojson( $data );
	}
	return $r;
}

function getface( $uid ) {
	if ( $uid ) {
		return db_select( 'user', 'face', 'uid=' . $uid );
	} else {
		return PLUG_PATH . 'face/noface.png';
	}
}

function getbrandpic( $title ) {
	$pic = db_select( 'brand', 'b_pic', "b_name='" . $title . "'" );
	if ( $pic ) {
		return $pic;
	} else {
		return PLUG_PATH . 'face/nopic.png';
	}
}

function getbrandlink( $title, $bid = '', $pagename = '', $page = '1' ) {
     if(!defined('WAPPATH')) define('WAPPATH','');
	$siteext = conf( 'siteext' );
	if ( empty( $pagename ) && empty( $bid ) ) {
		$data = db_load_one( 'brand', "b_name='" . $title . "'", 'bid,b_filename' );
		$url = !empty( $data[ 'b_filename' ] ) ? $data[ 'b_filename' ] : $data[ 'bid' ];
	} else {
		$url = !empty( $pagename ) ? $pagename : $bid;
	}
    $url=$page==1 ? $url : $url . '_' . $page ;
	$runmode = conf( 'runmode' );
	if ( $runmode == 0 ) {
		return SITE_PATH .WAPPATH. '?brand/' . $url . $siteext;
	} elseif ( $runmode == 1 ) {
		return SITE_PATH . WAPPATH. conf( 'htmldir' ) . 'brand/' . $url . '.html';
	} else {
		return SITE_PATH .WAPPATH . 'brand/' . $url  . $siteext;
	}
}

function getsortlink( $type, $sid, $filename = '', $outlink = '', $page = 1 ) {
     if(!defined('WAPPATH')) define('WAPPATH','');
	$runmode = conf( 'runmode' );
    if (in_array($type,load_model('all')) || $type=='list') {		
        if ( $runmode == 0 ) {
            $remark = '?';
            $siteext = $page==1  ?  conf( 'siteext' )  : '_' . $page . conf( 'siteext');
        } elseif ( $runmode == 1 ) {
            $remark = conf( 'htmldir' );
            $siteext =  $page==1  ?  '.html' : '_' . $page . '.html';
        }else{
			 $remark = '';
			 $siteext = $page==1  ?  conf( 'siteext' )  : '_' . $page . conf( 'siteext');
		}
    }else {
		$remark = $runmode == 2 ? '':'?';
		$siteext =  '_' . $page . conf( 'siteext' ) ;
	}
	if ( $type == 'links' && !empty( $outlink ) ) {
		if ( strpos( $outlink, '://' ) !== FALSE ) {
			return $outlink . '"target="_blank"';
        }else if($runmode==1){
            return str_replace( '/?', '', SITE_PATH .WAPPATH. $outlink.'.html' );
		} else {
			return str_replace( '//', '/', SITE_PATH .WAPPATH. $outlink );
		}
	} elseif ( $filename  && strpos( $filename, '{page}' ) === FALSE ) {
		switch ( $type ) {
			case 'brand':
				$filename = empty( $filename ) ? 'index' : $filename;
				return SITE_PATH . WAPPATH . $remark . 'brandlist/' . $filename . $siteext;
			default:
				return str_replace( '//', '/', SITE_PATH . WAPPATH . $remark . $filename . $siteext );
		}
	} else {
		switch ( $type ) {
            case 'list':case 'content':
				return SITE_PATH .WAPPATH . $remark . 'list/' . $sid . $siteext;
				break;
			case 'about':
				return SITE_PATH .WAPPATH . $remark . 'about/' .$sid . $siteext;
				break;
			case 'brand':
				return SITE_PATH . WAPPATH . $remark . 'brandlist/index' . $siteext;
				break;
			default:
				if(in_array( $type ,load_model())) return SITE_PATH. WAPPATH . $remark .  'list/'. $sid . $siteext;
				return SITE_PATH .WAPPATH . $remark . $type . '/' . $sid . $siteext;
		}
	}
}

function getcontentlink( $cid, $pagename,$type='',$outlink = '' ) {
    if(!defined('WAPPATH')) define('WAPPATH','');
	$runmode = conf( 'runmode' );
	if ( $runmode == 0 ) {
		$remark = '?';
		$siteext = conf( 'siteext' );
	} elseif ( $runmode == 1 ) {
		$remark = conf( 'htmldir' );
		$siteext = '.html';
	} else {
		$remark = '';
		$siteext = conf( 'siteext' );
	}
	if ( empty( $outlink ) ) {
		if ( !empty( $pagename ) ) {
			return SITE_PATH .WAPPATH . $remark .$type. '/' . $pagename . $siteext;
		} else {
			return SITE_PATH .WAPPATH . $remark . $type.'/' . $cid . $siteext;
		}
	} else {
		if ( strpos( $outlink, '://' ) !== FALSE ) {
			return $outlink . '" target="_blank';
		} else {
			return str_replace( '//', '/', SITE_PATH . WAPPATH . $outlink );
		}
	}
}

function gettag( $tag ) {
	if ( empty( $tag ) ) return false;
	$tags = splits( $tag, "," );
	$list = '';
	foreach ( $tags as $value ) {
		$name = db_select( 'tag', 't_enname', array( 't_name' => $value ) );
		if ( !empty( $name ) ) {
			$link = gettaglink( $name, 1 );
			$list .= '<a href="' . $link . '">' . $value . '</a>';
		}
	}
	return $list;
}

function gettaglink( $name, $page = 1 ) {
     if(!defined('WAPPATH')) define('WAPPATH','');
	$runmode = conf( 'runmode' );
	if ( $runmode == 0 ) {
		$remark = '?';
		$siteext = conf( 'siteext' );
	} elseif ( $runmode == 1 ) {
		$remark = conf( 'htmldir' );
		$siteext = $page ==1 ? '.html' : '_' . $page . '.html';
	} else {
		$remark = '';
		$siteext = $page ==1 ?  conf( 'siteext' ) : '_' . $page . conf( 'siteext' );
	}
	$link = SITE_PATH . WAPPATH . $remark . 'taglist/' . $name . $siteext;
	return $link;
}

function check_adminsort( $name, $type ) {
	$adminsort = get_session( 'adminsort' );
	if ( !empty( $adminsort )||$adminsort!='all'  ) {
		$sorts = splits( $adminsort . ',', ',' );
		switch ( $type ) {
			case 'or':
				$wheresort = '';
				foreach ( $sorts as $value ) {
					$wheresort .= empty( $value ) ? '' : $name . '=' . $value . ' or ';
				}
				$wheresorts = isnul( $wheresort ) ? : 'and(' . $wheresort . $name . '=0)';
				break;
			case 'in':
				$wheresort = '';
				foreach ( $sorts as $value ) {
					$wheresort .= empty( $value ) ? '' : $name . '=' . $value . ' or ';
				}
				$wheresorts = isnul( $wheresort ) ? : 'and ' . $name . ' in(' . $wheresort . ')';
				break;
			case 'arr':
				$wheresorts = array( $name => array_filter( $sorts ) );
				break;
		}
		return $wheresorts;
	}
}

function ParseGlobal( $sid, $cid ) {
	if ( $sid > 0 ) {
		$data = db_load_one( 'sort', 'sid=' . $sid );
	} elseif ( $cid > 0 ) {
		$data = db_load_sql_one( 'select * from [dbpre]sort where sid=(select c_sid from [dbpre]content where cid=' . $cid . ')' );
	} else {
		$GLOBALS[ "tid" ] = G( 'sid' );
		return;
	}
	if ( !$data )error( '404，很抱歉您访问的页面不存在,请检查网址是否正确！',SITE_PATH);
	$value = array_change_key_case( $data );
	if ( conf( 'runmode' ) != 0 && $value[ 's_gid' ] > 0 ) {
		$gmark = get_session( 'gmark' ) ? get_session( 'gmark' ) : 0;
		$user = db_load_one( 'user_group', 'gid=' . $value[ 's_gid' ], 'gid,g_name,g_mark' );
		$gmark < $user[ 'g_mark' ]and error( '栏目访问权限不足,' . $user[ 'g_name' ] . '方可访问！', '?user/login' );
	}
	$GLOBALS[ "sid" ] = $value[ 'sid' ];
	$GLOBALS[ "tid" ] = $value[ 's_tid' ];
	$GLOBALS[ "pid" ] = $value[ 's_pid' ];
	$GLOBALS[ "stype" ] = $value[ 's_type' ];
	$GLOBALS[ "spic" ] = $value[ 's_pic' ];
	$GLOBALS[ "sname" ] = $value[ 's_name' ];
	$GLOBALS[ "senname" ] = $value[ 's_enname' ];
	$GLOBALS[ "slevel" ] = $value[ 's_level' ];
	$stpl = splits( $value[ 's_template' ], ',' );
	$ctpl = splits( $value[ 'c_template' ], ',' );
	if ( defined( 'ISWAP' ) ) {
		$GLOBALS[ "stpl" ] = isset( $stpl[ 1 ] ) ? $stpl[ 1 ] : $stpl[ 0 ];
		$GLOBALS[ "ctpl" ] = isset( $ctpl[ 1 ] ) ? $ctpl[ 1 ] : $ctpl[ 0 ];
	} else {
		$GLOBALS[ "stpl" ] = $stpl[ 0 ];
		$GLOBALS[ "ctpl" ] = $ctpl[ 0 ];
	}
	$GLOBALS[ "filename" ] = $value[ 's_filename' ];
	$GLOBALS[ "pagetitle" ] = $value[ 's_title' ];
	$GLOBALS[ "pagekeys" ] = $value[ 's_key' ];
	$GLOBALS[ "pagedesc" ] = $value[ 's_desc' ];
	$GLOBALS[ "pageurl" ] = $value[ 's_url' ];
	$GLOBALS[ "spath" ] = $value[ 's_path' ];
	$GLOBALS[ "level" ] = $value[ 's_level' ];
	if ( isset( $GLOBALS[ "spath" ] ) ) {
		$crumbs = array();
		$paths = splits( rtrim( $GLOBALS[ "spath" ], ',' ), ',' );
		$parent = db_load( 'sort', array( 'sid' => $paths ), 'sid,s_name,s_pic,s_type,s_enname,s_url,s_filename', 10 );
		$GLOBALS[ "tsname" ] = $parent[ 0 ][ 's_name' ];
		$GLOBALS[ "tsenname" ] = $parent[ 0 ][ 's_enname' ];
		$GLOBALS[ "tspic" ] = $parent[ 0 ][ 's_pic' ];
		$GLOBALS[ "psname" ] = $parent[ 0 ][ 's_name' ];
		$GLOBALS[ "psenname" ] = $parent[ 0 ][ 's_enname' ];
		foreach ( $parent as $value ) {
			$language=LANGUAGE=='ch' || LANGUAGE=="zh" ? '' : LANGUAGE;
			$crumbs[]= '<a href="' . getsortlink( $value[ 's_type' ], $value[ 'sid' ], $value[ 's_filename' ], $value[ 's_url' ] ) . '">' . $value[ 's_'.$language.'name' ] . '</a>';
		}
		$GLOBALS[ "crumbs" ] = $crumbs;
	}
}

// 保存 $db 错误到全局
function db_errno_errstr( $r, $d = NULL, $sql = '' ) {
	global $errno, $errstr;
	if ( $r === FALSE ) { //  && $d->errno != 0
		$errno = $d->errno;
		$errstr = db_errstr_safe( $errno, $d->errstr );
		$s =  $sql ."\t" . $errno . "\t" . $errstr;
		str_log( $s, 'error' );
	}
}

// 安全的错误信息
function db_errstr_safe( $errno, $errstr ) {
	switch ($errno){
        case 1024:  error ($errno.',连接数据库失败,读取数据表失败请检查是否拼写错误。');
        case 1026: error ($errno.',写文件错误。');
        case 1030: error ($errno.',可能是服务器不稳定。（具体原因不是很清楚）');        
        case 1037: error ($errno.',系统内存不足，请重启数据库或重启服务器。');
        case 1044: error ($errno.',数据库用户权限不足，请联系空间商解决。');
        case 1045: error ($errno.',连接数据库失败,请检查数据库账户密码是否正确');
        case 1049:  return ('1049,数据库名不存在,请手工创建');     
        case 1054:  return '连接数据库失败,写入数据表失败请检查写入字段';
        case 1064:  return '数据库执行语句有误，请检查排序字段';
        case 1130:  error ($errno.',连接数据库失败，没有连接数据库的权限。');   
        case 1235:  error ($errno.', MySQL版本过低，不具有本功能。');  
        case 2002:  error ($errno.', 服务器端口不对，请咨询空间商正确的端口。');      
        case 2003:  error ($errno.',连接数据库服务器失败,MySQL 服务没有启动，请启动该服务。');
        case 2008: error ($errno.',没有足够的内存存储全部结果');
		//default: error ($errno.',没有足够的内存存储全部结果');
    }        
	return $errstr;
}
//----------------------------------->  表结构和索引相关 end
/*
$where = array('id'=>123, 'groupid'=>array('>'=>100, 'LIKE'=>'\'jack'));
$s = db_where_to_sqladd($where);
echo $s;

WHERE id=123 AND groupid>100 AND groupid LIKE '%\'jack%' 

// 格式：
array('id'=>123, 'groupid'=>123)
array('id'=>array(1,2,3,4,5))
array('id'=>array('>' => 100, '<' => 200,'<>'=>0))
array('username'=>array('LIKE' => 'jack'))
*/
function db_cond_to_sqladd( $where ) {
	$s = '';	
	if ( DB_TYPE == 'access' )$where = toutf( $where );
	if ( !empty( $where ) ) {
		$s = ' WHERE ';
		if ( is_array( $where ) ) {
			foreach ( $where as $k => $v ) {
				if ( !is_array( $v ) ) {
                    $op = substr( $k, -1 );
                    if ( $op == '>' || $op == '<'  || $op == '=' ) {						
						if(substr( $k, -2 )== '>=' || substr( $k, -2 )== '<=' || substr( $k, -2 )== '<>') {
							$op=substr( $k, -2 );
							$k = substr( $k, 0, -2 );							
						}else{
							$k = substr( $k, 0, -1 );	
						}
						$s .= "`$k`$op$v AND";						
                    } else {
                        $v = ( ifnum( $v ) ) ? $v : "'" . ( $v ) . "'";
                        $s .= "`$k`=$v AND ";
                    }
				} elseif ( isset( $v[ 0 ] ) ) {
					// OR 效率比 IN 高
					$s .= '(';
					//$v = array_reverse($v);
					foreach ( $v as $v1 ) {
						$v1 = ( ifnum( $v1 ) ) ? $v1 : "'" . ( $v1 ) . "'";
						$s .= "`$k`=$v1 OR ";
					}
					$s = substr( $s, 0, -4 );
					$s .= ') AND ';

					/*
					$ids = implode(',', $v);
					$s .= "$k IN ($ids) AND ";
					*/
				} else {
					
					foreach ( $v as $k1 => $v1 ) {
						if ( $k1 == 'LIKE' ) {
							if(ifstrin($k,',')){								
								foreach (splits($k) as $v2){
									$ss .= "`$v2` LIKE '%".$v1."%' or";
								}
								$ss=rtrim($ss,'or');
								$s .= "($ss) AND";
							}else{
								$s .= "`$k` LIKE '%".$v1."%' AND";
							}							
						}else if( $k1 == 'FIND'){
							$s .= "(FIND_IN_SET($v1,`$k`) or $k='') AND";
                        }else if( $k1 == '!FIND'){
							$s .= "!FIND_IN_SET($v1,`$k`) AND";
                        }else if($k1 == 'BETWEEN'){               				
                            $s .= "`$k` BETWEEN $v1 AND";
						}else if(is_int( $v1 ) || is_float( $v1 ) || $k1=='='){	
							$s .= "`$k`$k1  $v1  AND ";
						}else{
							$s .= "`$k`$k1 '" . ( $v1 ) . "' AND ";
						}
					}
				}
			}
			$s = substr( $s, 0, -4 );
		} else {
			$s .= $where;
		}
	}
	return $s;
}

function db_orderby_to_sqladd( $orderby ) {
	$s = '';
	if ( !empty( $orderby ) ) {
		$s .= ' ORDER BY ';
		$comma = '';
		if ( is_array( $orderby ) ) {
			foreach ( $orderby as $k => $v ) {
				$s .= $comma . "`$k` " . ( $v == 'asc' ? ' ASC ' : ' DESC ' );
				$comma = ',';
			}
		} else {
			$s .= $orderby;
		}
	}
	return $s;
}
/*
	$arr = array('content'=>'c','sort'=>'s')
	$arr ='content c,sort s'
	$arr ='content'
*/
function db_tableby_to_sqladd($arr){	
	if ( is_array( $arr ) ) {
		$s='';
		foreach ( $arr as $k => $v ) {
			$s.=DB_PRE.$k.' as '.$v.',';
		}
		return $s;
	}elseif(strpos( $arr,',' )>0) 	{
		return DB_PRE.str_replace(',',','.DB_PRE,$arr);		
	}else {
		if (strpos( $arr,DB_PRE )>0){
			return $arr;
		}else{
			return DB_PRE.$arr;
		}		
	}
}

/*
	$arr = array('name'=>'abc','stocks+'=>1,'date'=>12345678900)
	db_array_to_update_sqladd($arr);
*/
function db_array_to_update_sqladd( $arr ) {
	$s = '';
	if ( DB_TYPE == 'access' ) $arr = toutf( $arr );
	if ( is_array( $arr ) ) {
		foreach ( $arr as $k => $v ) {
			$v = ( $v );
			$op = substr( $k, -1 );
			if ( $op == '+' || $op == '-' ) {
				$k = substr( $k, 0, -1 );
				$v = ( is_int( $v ) || is_float( $v ) ) ? $v : "'$v'";
				$s .= "`$k`=$k$op$v,";
			} else {
				$v = ( is_int( $v ) || is_float( $v ) ) ? $v : "'$v'";
				$s .= "`$k`=$v,";
			}
		}
		return substr( $s, 0, -1 );
	} else {
		return $arr;
	}
}

/*
	$arr = array(
		'name'=>'abc',
		'date'=>12345678900,
	)
	db_array_to_insert_sqladd($arr);
*/
function db_array_to_insert_sqladd( $arr ) {
	$s = '';
	if ( DB_TYPE == 'access' )$arr = toutf( $arr );
	$keys = array();
	$values = array();
	foreach ( $arr as $k => $v ) {
		$k = ( $k );
		$v = ( $v );
		$keys[] = '`' . $k . '`';
        is_array( $v ) || is_object( $v )  and $v=tojson($v);
		$v = ( is_int( $v ) || is_float( $v ) ) ? $v : "'$v'";
		$values[] = $v;
	}
	$keystr = implode( ',', $keys );
	$valstr = implode( ',', $values );
	$sqladd = "($keystr) VALUES ($valstr)";
	return $sqladd;
}

function db_array_to_create_sqladd( $arr, $type ) {
	$s = '';
	$keys = array();
	$values = '';
	foreach ( $arr as $k => $v ) {
		$k = ( $k );
		$v = ( $v );
		switch ( $type ) {
			case 'mysql':
				switch ( $v ) {
					case 'int':
						$values .= 'add `' . $k . '` int(11) DEFAULT 0,';
						break;
					case 'char':
					case 'varchar':
					case 'nvarchar':
						$values .= 'add `' . $k . '` varchar(255) DEFAULT NULL,';
						break;
					case 'time':
					case 'date':
					case 'datetime':
						$values .= 'add `' . $k . '` datetime DEFAULT NULL,';
						break;
					case 'text':
					case 'ntext':
					case 'longtext':
						$values .= 'add `' . $k . '` longtext DEFAULT NULL,';
						break;
					case 'money':
					case 'double':
						$values .= 'add `' . $k . '`  DOUBLE (16, 2)  DEFAULT NULL,';
						break;

				}
				break;
			case 'access':
				switch ( $v ) {
					case 'int':
						$values .= '`' . $k . '` int null,';
						break;
					case 'char':
					case 'varchar':
					case 'nvarchar':
						$values .= '`' . $k . '` varchar(255) NULL,';
						break;
					case 'time':
					case 'date':
					case 'datetime':
						$values .= '`' . $k . '` datetime NULL,';
						break;
					case 'text':
					case 'ntext':
					case 'longtext':
						$values .= '`' . $k . '` text NULL,';
						break;
					case 'money':
					case 'double':
						$values .= '`' . $k . '`  DOUBLE NULL,';
						break;
				}
				break;
			case 'sqlite':
				switch ( $v ) {
					case 'int':
						$values .= '`' . $k . '` int DEFAULT 0,';
						break;
					case 'char':
					case 'varchar':
					case 'nvarchar':
						$values .= '`' . $k . '` varchar(255) NULL,';
						break;
					case 'time':
					case 'date':
					case 'datetime':
						$values .= '`' . $k . '` datetime,';
						break;
					case 'text':
					case 'ntext':
					case 'longtext':
						$values .= '`' . $k . '` ntext NULL,';
						break;
					case 'money':
					case 'double':
						$values .= '`' . $k . '`  DOUBLE (16, 2)  NULL,';
						break;
				}
				break;
		}
	}
	return rtrim( $values, ',' );
}
?>