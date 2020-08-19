<?php
PHP_VERSION < '5.3' AND die( '很抱歉，程序需要PHP版本要求5.3以上，请更换PHP版本。' );
$get_magic_quotes_gpc = get_magic_quotes_gpc();
$starttime = microtime( 1 );
$time = time();
session_start();
// 头部，判断是否运行在命令行下
define( 'IN_CMD', !empty( $_SERVER[ 'SHELL' ] ) || empty( $_SERVER[ 'REMOTE_ADDR' ] ) );
if ( IN_CMD ) {
	!isset( $_SERVER[ 'REMOTE_ADDR' ] )AND $_SERVER[ 'REMOTE_ADDR' ] = '';
	!isset( $_SERVER[ 'REQUEST_URI' ] )AND $_SERVER[ 'REQUEST_URI' ] = '';
	!isset( $_SERVER[ 'REQUEST_METHOD' ] )AND $_SERVER[ 'REQUEST_METHOD' ] = 'GET';
} else {
	header( 'Content-Type:text/html; charset=utf-8' );
	header( 'X-UA-Compatible:IE=edge,chrome=1' );
}

// 设置中国时区
date_default_timezone_set( 'Asia/Shanghai' );
// 超级全局变量
!empty( $_SERVER[ 'HTTP_X_REWRITE_URL' ] )AND $_SERVER[ 'REQUEST_URI' ] = $_SERVER[ 'HTTP_X_REWRITE_URL' ];
!isset( $_SERVER[ 'REQUEST_URI' ] )AND $_SERVER[ 'REQUEST_URI' ] = '';
$_SERVER[ 'REQUEST_URI' ] = str_replace( '/index.php?', '/', $_SERVER[ 'REQUEST_URI' ] ); // 兼容 iis6

// 定义站点物理路径
define( 'DOC_PATH', str_replace( '\\', '/', $_SERVER[ 'DOCUMENT_ROOT' ] ) );

// 定义站点虚拟目录（自适应获取多级目录）
$script_path = explode( '/', $_SERVER[ 'SCRIPT_NAME' ] );
$file_path = str_replace( '\\', '/', dirname( __DIR__ ) );

if ( count( $script_path ) > 2 ) {
	if ( !!$path_pos = strrpos( $file_path, '/' . $script_path[ 1 ] ) ) {
		define( 'SITE_PATH', substr( $file_path, $path_pos ) . '/' );
	} else {
		define( 'SITE_PATH', '/' );
	}
} else {
	define( 'SITE_PATH', '/' );
}
define( 'SITE_DIR', DOC_PATH . SITE_PATH );
define( 'CONF_DIR', SITE_DIR . 'config/' );
include SITE_DIR . 'config/zzz_config.php';
include 'zzz_version.php';
include 'zzz_main.php';
include 'zzz_file.php';
include 'zzz_array.php';
include 'zzz_cache.php';
include 'zzz_db.php';
define( 'PLUG_PATH', SITE_PATH . 'plugins/' );
define( 'PLUG_DIR', SITE_DIR . 'plugins/' );
define( 'RUN_DIR', SITE_DIR . 'runtime/' );
define( 'UPLOAD_DIR', SITE_DIR . $conf[ 'uploadpath' ] );
define( 'ADMIN_DIR', SITE_DIR . $conf[ 'adminpath' ] );
define( 'ADMIN_PATH', SITE_PATH . $conf[ 'adminpath' ] );

define( 'ISSESSION', 1 ); //1是session存储，0是cookie存储
// 1: 开发模式 0: 关闭
!defined( 'DEBUG' )AND define( 'DEBUG',$conf["bugmark"]);
function_exists( 'ini_set' )AND ini_set( 'display_errors', DEBUG ? '1' : '0' );
error_reporting( DEBUG ? E_ALL : 0 );
$ip = ip();
$longip = ip2long( $ip );
$longip < 0 AND $longip = sprintf( "%u", $longip ); // fix 32 位 OS 下溢出的问题
$useragent = _SERVER( 'HTTP_USER_AGENT' );
// 语言包变量
!isset( $lang )AND $lang = array();
// 全局的错误，非多线程下很方便。
$errno = 0;
$errstr = '';
// register_shutdown_function('xn_shutdown_handle');
DEBUG AND set_error_handler( 'error_handle', E_STRICT );

// IP 地址
!isset( $_SERVER[ 'REMOTE_ADDR' ] )AND $_SERVER[ 'REMOTE_ADDR' ] = 'localhost';
!isset( $_SERVER[ 'SERVER_ADDR' ] )AND $_SERVER[ 'SERVER_ADDR' ] = 'localhost';

$method = $_SERVER[ 'REQUEST_METHOD' ];

define( 'DB_TYPE', $conf[ 'db' ][ 'type' ] );
define( 'DB_PRE',  $conf[ 'db' ][ 'tablepre' ] );

// 保存到超级全局变量，防止冲突被覆盖。
$_SERVER[ 'starttime' ] = $starttime;
$_SERVER[ 'time' ] = $time;
$_SERVER[ 'ip' ] = $ip;
$_SERVER[ 'longip' ] = $longip;
$_SERVER[ 'useragent' ] = $useragent;
$_SERVER[ 'conf' ] = $conf;
$_SERVER[ 'prefix' ] = $conf[ 'prefix' ];
$_SERVER[ 'lang' ] = $lang;
$_SERVER[ 'errno' ] = $errno;
$_SERVER[ 'errstr' ] = $errstr;
$_SERVER[ 'method' ] = $method;
$_SERVER[ 'get_magic_quotes_gpc' ] = $get_magic_quotes_gpc;
$db = db_new( $conf[ 'db' ] );
$_SERVER[ 'db' ] = $db;
if ( $conf[ 'isinstall' ] == 1 ) {
	define( 'INSTALL', '1' );
	db_connect();
} else {
	define( 'INSTALL', '0' );
}
defined( 'LANGUAGE' ) ? defined( 'LANGUAGE' ) : define( 'LANGUAGE', 'ch' );
?>