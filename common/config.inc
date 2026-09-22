<?php
/**
*
* @file		config.inc.php
*/

@define( PRODUCTS, "防火墙" );
@define( PRODUCTS_EN, "FW" );
@define( PATH, "default" );
@define( TITLE, "防火墙" );
/* 'en'-> english,'cn'->chinese */
@define( DEFAULT_LANGUAGE,	"cn" );
@define('WECHAT_APPID', 'wx43dad94ee86c16f9');
@define('WECHAT_APPSECRET', '42cf6bf0caf54bd2e030da9a59ac77eb');
@define('WECHAT_REDIR_URL', 'http://aaa.www.sec-inside.com/wx_auth');
$language_id = 2;

/*HTML*/
$charset		= "utf-8";

/*Function config*/
$attackevasive	= 0;		// 

/* Unlink response file */
@define( IS_UNLINK_RESPONSEXML, 0 );
@define( IS_CGICHECK, 0 );

/*@define( TPLDIR,	 "templates/default" );
@define( LANGUAGEDIR,	 "./language/" );*/

define('DOMAIN_SOCKET_DIR', '/tmp');
define('DOMAIN_SOCKET_PREFIX', '.x');
define('DOMAIN_SOCKET_REMOTE', '/tmp/.gui_xml');


/*define('IMPORT_PATH', './attachements/');*/

 /*
 *“控制<->引擎”通讯数据包类型
 */
define("UCT_UNKNOWN",	0x00000000);           //未知数据
define("UCT_CMD",		0x00000001);           //命令
define("UCT_CMD_ECHO",	0x00000002);           //回应命令
define("UCT_UPDATE",	0x00000003);		   //升级命令
define("UCT_CONFIG",	0x00000004);		   //配置相关命令(导入,导出等),引擎回的也是这个标志


$DEBUG_MODE = 0;
$DEMO_DATA = 0;
$AUTO_TIMEOUT = 1;

$global['count'] = 20;

?>
