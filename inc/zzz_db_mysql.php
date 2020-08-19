<?php
class db_pdo_mysql {
	public $conf = array(); // 配置，可以支持主从
	public $wlink = NULL;  // 写连接
	public $link = NULL;   // 最后一次使用的连接
	public $errno = 0;
	public $errstr = '';
	public $sqls = array();
	public $innodb_first = TRUE;// 优先 InnoDB
	
	public function __construct($conf) {
		$this->conf = $conf;
		$this->showsql  = $conf['showsql'];
	}
	
	// 根据配置文件连接
	public function connect() {
		$this->wlink = $this->connect_master();
		return $this->wlink;
	}
	
	// 连接写服务器
	public function connect_master() {
		if($this->wlink) return $this->wlink;
		$conf = $this->conf;
		$this->wlink = $this->real_connect($conf['host'], $conf['user'], $conf['password'], $conf['name'], $conf['port'], $conf['charset'], $conf['engine']);
		return $this->wlink;
	}
	public function real_connect($host, $user, $password, $name,$port, $charset = '', $engine = '') {
		try {
			$attr = array(
				PDO::ATTR_TIMEOUT => 5,
				//PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
			);
			$link = new PDO("mysql:host=$host;port=$port;dbname=$name", $user, $password, $attr);
		} catch (Exception $e) {
			$this->error($e->getCode(), '连接数据库服务器失败:'.$e->getMessage());
			return FALSE;
	        }
		$charset AND $link->query("SET names $charset, sql_mode=''");
		return $link;
	}
	
	public function sql_find_one($sql) {
		$query = $this->query($sql);
		if(!$query) return $query;
		$query->setFetchMode(PDO::FETCH_ASSOC);
		return $query->fetch();
	}
	
	public function sql_find($sql, $key = NULL) {
		$query = $this->query($sql);
		if(!$query) return $query;
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$arrlist = $query->fetchAll();
		$key AND $arrlist = arrlist_change_key($arrlist, $key);
		return $arrlist;
	}
	public function sql_query($sql) {
		$query = $this->query($sql);
		$query->setFetchMode(PDO::FETCH_NUM);
		$arrlist = $query->fetchAll();
		return $arrlist;
	}	
	public function find($table, $where = array(), $orderby = array(), $page = 1, $pagesize = 10, $key = '', $col = array()) {
		$page = max(1, $page);
		$table= db_tableby_to_sqladd($table);
		$where = db_cond_to_sqladd($where);
		$orderby = db_orderby_to_sqladd($orderby);		
		$offset = ($page - 1) * $pagesize;
		if (empty($col)){
			$cols='*';
		}else if(is_array($col)){
			$cols= implode(',', $col);
		}else{
			$cols = $col;
		}
		//echo("SELECT $cols FROM $table $where$orderby LIMIT $offset,$pagesize");
		return $this->sql_find("SELECT $cols FROM $table $where$orderby LIMIT $offset,$pagesize", $key);
		
	}
		
	public function find_one($table, $where = array(), $orderby = array(), $col = array()) {
		$table= db_tableby_to_sqladd($table);
		$where = db_cond_to_sqladd($where);
		$orderby = db_orderby_to_sqladd($orderby);
		if (empty($col)){
			$cols='*';
		}else if(is_array($col)){
			$cols= implode(',', $col);
		}else{
			$cols = $col;
		}		
		//echop ("SELECT $cols FROM $table $where$orderby");
		return $this->sql_find_one("SELECT $cols FROM $table $where$orderby LIMIT 1");
	}
	
	public function query($sql) {
		if(!$this->wlink) return FALSE;
		$link = $this->link = $this->wlink;		
		try {
			$query = $link->query($sql);
		} catch (Exception $e) {  
			$this->error($e->getCode(), $e->getMessage(),$sql);
			return FALSE;
	    }
		if($this->showsql) echop($sql,1);
		return $query;
	}
	
	public function exec($sql) {
		if(!$this->wlink && !$this->connect_master()) return FALSE;
		$link = $this->link = $this->wlink;
		$n = 0;
		$this->showsql==0 ?: echop($sql);
		try {
			if(strtoupper(substr($sql, 0, 12) == 'CREATE TABLE')) {
				$fulltext = strpos($sql, 'FULLTEXT(') !== FALSE;
				$highversion = version_compare($this->version(), '5.6') >= 0;
				if(!$fulltext || ($fulltext && $highversion)) {
					$conf = $this->conf;
					if(strtolower($conf['engine']) != 'myisam') {
						$this->innodb_first AND $this->is_support_innodb() AND $sql = str_ireplace('MyISAM', 'InnoDB', $sql);
					}
				}
			}

			$n = $link->exec($sql); // 返回受到影响的行，插入的 id ?

		} catch (Exception $e) {  
			$this->error($e->getCode(), $e->getMessage(),$sql);
			return FALSE;
	        }
		if($this->showsql) echop($sql,1);
		if(count($this->sqls) < 1000) $this->sqls[] =$sql;
		
		if($n !== FALSE) {
			$pre = strtoupper(substr(trim($sql), 0, 7));
			if($pre == 'INSERT ' || $pre == 'REPLACE') {
				return $this->last_insert_id();
			}
		}
		return $n;
	}
	
	// innoDB 通过 information_schema 读取大致的行数
	// SELECT TABLE_ROWS FROM information_schema.tables WHERE TABLE_SCHEMA = '$table' AND TABLE_NAME = '$table';
	// SELECT TABLE_ROWS FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = '$table';
	public function count($table, $where = array()) {
		$table= db_tableby_to_sqladd($table);
		if(empty($where) && $this->conf['engine'] == 'innodb') {
			$dbname = $this->rconf['name'];
			$sql = "SELECT TABLE_ROWS as num FROM information_schema.tables WHERE TABLE_SCHEMA='$dbname' AND TABLE_NAME='$table'";
		} else {
			$where = db_cond_to_sqladd($where);
			$sql = "SELECT COUNT(*) AS num FROM `$table` $where";
		}
		$arr = $this->sql_find_one($sql);
		return !empty($arr) ? intval($arr['num']) : $arr;
	}
	
	public function maxid($table, $field, $where) {
		$table= db_tableby_to_sqladd($table);
		$where = db_cond_to_sqladd($where);
		$sql = "SELECT MAX($field) AS maxid FROM `$table` $where";
		$arr = $this->sql_find_one($sql);
		return !empty($arr) ? intval($arr['maxid']) : $arr;
	}
	
	public function istable($table) {
		$table= db_tableby_to_sqladd($table);
		$arr = $this->sql_find_one("SELECT COUNT(*) FROM `$table`");
		 return  $arr === FALSE ? 0 : 1;	
	}
	
	public function truncate($table) {
		$table= db_tableby_to_sqladd($table);
		return $this->exec("TRUNCATE $table");
	}
	
	public function last_insert_id() {
		return $this->wlink->lastInsertId();
	}
	
	public function version() {
		$r = $this->sql_find_one("SELECT VERSION() AS v");
		return $r['v'];
	}
	
	// 设置错误。
	public function error($errno = 0, $errstr = '',$sql='') {
		$error = $this->link ? $this->link->errorInfo() : array(0, 0, '');
		$this->errno = $errno ? $errno : (isset($error[1]) ? $error[1] : 0);
		$this->errstr = $errstr ? $errstr : (isset($error[2]) ? $error[2] : '');
		DEBUG AND trigger_error('Database Error:'.$this->errstr.$sql);
	}
	
	public function is_support_innodb() {
		$arrlist = $this->sql_find('SHOW ENGINES');
		$arrlist2 = arrlist_key_values($arrlist, 'Engine', 'Support');
		return isset($arrlist2['InnoDB']) AND $arrlist2['InnoDB'] == 'YES';
	}

	
	public function close() {
		$this->wlink = NULL;
		return TRUE;
	}
	
	public function __destruct() {
		if($this->wlink) $this->wlink = NULL;
	}
	public function getsubsort($sid){
		if(empty($sid)) return;
		if(stripos($sid,',') === false) {
		  $data=$this->sql_find("select sid from ".DB_PRE."sort where s_onoff=1 and find_in_set($sid,s_path)");
		  $r= array();
		  if(!is_array($data))  die($sid.$data);
		  foreach ($data as $value){
			array_push($r,$value['sid']);
		  }	
		}else{
			$r=explode(",",$sid);
		}		
		return $r;
	}
}
?>