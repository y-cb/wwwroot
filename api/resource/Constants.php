<?php
namespace resource;

define('DEV_VERSION', 'devversion');

/**
 * 通讯相关的常量
 */
define("CONNECTION.ENGINEIP", "CONNECTION.ENGINEIP");
define("CONNECTION.ENGINEPORT", "CONNECTION.ENGINEPORT");
define("CONNECTION.USERNAME", "CONNECTION.USERNAME");
define("CONNECTION.PASSWORD", "CONNECTION.PASSWORD");

define('LOGINSTATE', 'login_state');
define('LOGIN_FAIL', 'login_fail');
define('USER', 'usr');
define('PASSWORD', 'pwd');
define('LEVEL', 'level');
define('CONFIG_CHECKNUM', 'config_authnum');
define('WEB_CHECKNUM', 'web_authnum');

define('DOMAIN_SOCKET_DIR', '/tmp');
define('DOMAIN_SOCKET_PREFIX', '.x');
define('DOMAIN_SOCKET_REMOTE', '/tmp/.gui_xml');
define('PERMISSION', 'permission');


//定义非XML字段的前缀
define('NONXMLFIELD_PREFIX', '@');
//定义页面路径信息的key
define('PAGE_PATH_KEY', NONXMLFIELD_PREFIX . 'pagepath');
//定义操作类型的key
define('OPERATION_TYPE_KEY', NONXMLFIELD_PREFIX . 'ot');
//定义提交模式的key
define('SUBMIT_MODE_KEY', 'sm');
//定义是否使用保存数据的key
define('USE_SAVED_KEY', 'us');
//定义使用保存数据的参数
define('USE_SAVED', USE_SAVED_KEY . '=yes');
//定义传递主键值得key
define('PRIMARY_VALUE_KEY', 'pv');
//定义新建时的信息路径中的listindex常量
define('NEW_INDEX', '@');
//定义使用主键信息构建信息路径时使用的前缀，以区分与索引
define('PRI_INDEX_PREFIX', '_');
//定义是否被嵌入到frame的参数key
define('IS_EMBEDDED', 'embeded');
//定义默认错误码
define('DEFAULT_ERROR', 50001);

/**
 * Local相关的常量
 */
//定义保存Local信息的key
define("LOCAL_KEY", "localid");

//定义各种Local
define("LOCAL_CN", "zh");
define("LOCAL_EN", "en");

define("LOCAL_DEFAULT", LOCAL_EN);


/**
 * 操作类型相关常量
 */
define('OT_SHOW', 'show');
define('OT_ADD', 'add');
define('OT_INSERT', OT_ADD);
define('OT_MODIFY', 'mod');
define('OT_DELETE', 'del');
define('OT_MOVE', OT_MODIFY);
define('OT_SHOW_O', 'show_o');
define('OT_SHOW_I', 'show_i');
define('OT_SUBMIT', 'submit');
define('OT_CLEAR', 'clear');

/**
 * 调试信息相关常量
 */
//在data_collect.php的collect_data函数中保存收集的数据
define('COLLECTED_DATA', 'collected_data');
//在MainModel::updateData()中保存提交的数据
define('SUBMITED_DATA', 'submited_data');


/**
 * 输入长度限制常量
 */
define('XML_MAX_NAME_LEN','63" onkeypress="onlyName(event)');
define('XML_MAX_IP_LEN', '15" onkeypress="onlyIp(event)');
define('XML_MAX_IPV6_LEN', '43" onkeypress="onlyIpV6(event)');
define('XML_MAX_IPV6ORV4_LEN', '43" onkeypress="onlySubnetIpv6(event)');
define('XML_MAX_PORT_LEN', '5" onkeypress="onlyInteger(event)');
define('XML_MAX_IP_MASK_LEN', '31" onkeypress="onlySubnet(event)');
define('XML_MAX_MAC_LEN', '17" onkeypress="onlyMac(event)');
define('XML_MAX_DESC_LEN', 127);
define('IFNAMSIZ', '63" onkeypress="onlyName(event)');
define('AV_MAX_PATTERN_NAME_LEN', 15);
define('XML_MAX_LISTNAME_LEN', 255);
define('XML_MAX_WEBNAME_LEN', 127);
define('XML_MAX_PROCESSNAME_LEN', 63);

define('XML_MAX_PASSWORD_LEN', '63" onkeypress="onlyName(event)" onkeydown="preventCopy(event)" onpaste="return false" oncontextmenu="return false') ;
define('XML_MAX_PASSWORD_LEN_31', '31" onkeypress="onlyName(event)"   onkeydown="preventCopy(event)" onpaste="return false" oncontextmenu="return false');
define('XML_MAX_PASSWORD_LEN_16', '16" onkeypress="onlyName(event)"   onkeydown="preventCopy(event)" onpaste="return false" oncontextmenu="return false');
define('XML_MAX_PASSWORD_LEN_8', '8" onkeypress="onlyName(event)"  onkeydown="preventCopy(event)" onpaste="return false" oncontextmenu="return false');
define('XML_MAX_LOG_NUM',25);
define('XML_MAX_URL_LEN', 119);
define('XML_MAX_EMAIL_LEN_255', 255);
define('XML_MAX_EMAIL_LEN_127', 127);
define('XML_MAX_ADDRESS_LEN', 63);
define('XML_MAX_TEL_LEN', 63);
define('XML_MAX_KEYWORD_LEN', 15);
/**
 * 集中管理虚拟设备标志
 */
define('MOCK_DEVICE', 'ismockdev');
define('FIREWALL_POLICY_FRONT_TAG', '-2');

// 错误信息在会话中保存的key
define('ERROR_MSG_BUNDLE_KEY', 'ERROR.MSG.BUNDLE.KEY');
define('XML_MAX_AV_NUM', 90);
define('REFRESH_INTERVAL_ARM', 10000);
define('REFRESH_INTERVAL_X86', 5000);

//prefile
define('XML_MAX_PREFILE_LEN',1023);
define('XML_MAX_PERSOST_NAME_LEN',64);
define('XML_MAX_PERSOST_LEN','511" onkeypress="onlyName(event)');


?>
