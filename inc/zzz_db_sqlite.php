<?php
class db_pdo_sqlite {
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
		$this->wlink = $this->real_connect($conf['sqlitepath'], $conf['sqlitename']);
		return $this->wlink;
	}
	public function real_connect($dbpath, $dbname) {		
		$sqlitedb = SITE_DIR. $dbpath. $dbname;
		try {
			$attr = array(
				PDO::ATTR_TIMEOUT => 5,
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
			);
			$link = new PDO('sqlite:'.$sqlitedb);//连接sqlite
		} catch (Exception $e) {
			$this->error($e->getCode(), '连接数据库服务器失败:'.$e->getMessage());
			return FALSE;
	        }
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
		$link->exec('PRAGMA synchronous = OFF');		
		try {

			$n = $link->exec($sql);
		} catch (Exception $e) { 		
			$this->error($e->getCode(), $e->getMessage(),$sql);
			return FALSE;
	    }
		if($this->showsql) echop($sql,1);
		if(count($this->sqls) < 1000) $this->sqls[] = $sql;
		if($n !== FALSE) {		
			$pre = strtoupper(substr(trim($sql), 0, 7));	
			if($pre == 'INSERT ') {
				return $this->last_insert_id();				
			}		
		}		
		return $n;
	}
	
	public function count($table, $where = array()) {
		$table= db_tableby_to_sqladd($table);
		$where = db_cond_to_sqladd($where);
		$sql = "SELECT COUNT(*) AS num FROM `$table` $where";
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
		$this->errno = $errno ? $errno : (isset($error[1]) ? $error[1] : 0);
		$this->errstr = $errstr ? $errstr : (isset($error[2]) ? $error[2] : '');
		DEBUG AND trigger_error('Database Error:'.$this->errstr.$sql);
	}
	
	public function close() {
		$this->wlink = NULL;
		return TRUE;
	}
	
	public function __destruct() {
		if($this->wlink) $this->wlink = NULL;
	}
	public function getsubsort($sid){
		if(stripos($sid,',') === false) {
		  $data=$this->sql_find("select sid from ".DB_PRE."sort where s_onoff=1  and (s_path  like '%,$sid,%' or  s_path  like '$sid,%' or  s_path  like '%,$sid' )");
		  $r= array();
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