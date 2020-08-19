<?php
require 'zzz_class.php';
$aid=isnum(getform("aid","get"));
$bid=isnum(getform("bid","get"));
$cid=isnum(getform("cid","get"));
if(!empty($aid)) {
	db_update("about",$aid,array('a_visits+'=>1));
}else if(!empty($bid)){
	db_update("brand",$bid,array('b_visits+'=>1));
}else if(!empty($cid)){
	db_update("content",$cid,array('c_visits+'=>1));
}
?>
