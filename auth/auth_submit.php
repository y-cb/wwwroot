<?php
if($_SERVER[SERVER_PORT]!=8000&&$_SERVER[SERVER_PORT]!=8043){
	header('Location:/login.html');
	return;
}
require_once '../common/config.inc';
require_once '../common/common.inc';
require_once '../common/func.inc';
require_once '../common/cfgeng.inc';
require_once '../vendor/autoload.php';
require_once 'auth_lang.php';

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use database\MysqlDb;
use database\DbUtil;

if($_GET['weburl']) $param['weburl'] = formatget($_GET['weburl']);
$cookieInfo = ($_COOKIE['logincookie'] && isset($_COOKIE['logincookie'])) ? json_decode($_COOKIE['logincookie'],true) : array();
$DEMO_DATA = 0;

function send_message($access_key, $access_secret, $phone, $sign_name, $template_code, $template_param) {
	// Download：https://github.com/aliyun/openapi-sdk-php
	// Usage：https://github.com/aliyun/openapi-sdk-php/blob/master/README.md

	 AlibabaCloud::accessKeyClient($access_key, $access_secret)
	                        ->regionId('cn-hangzhou')
	                        ->asDefaultClient();

	try {
	    $result = AlibabaCloud::rpc()
				->product('Dysmsapi')
				// ->scheme('https') // https | http
				->version('2017-05-25')
				->action('SendSms')
				->method('POST')
				->host('dysmsapi.aliyuncs.com')
				->options([
				            'query' => [
				              'RegionId' => "cn-hangzhou",				//服务器所在地
				              'PhoneNumbers' => $phone,					//手机号码
				              'SignName' => $sign_name,					//签名
				              'TemplateCode' => $template_code,			//短信模版
				              'TemplateParam' => json_encode($template_param),	//短信参数，需用JSON格式
				            ],
				        ])
				->request();
	    return $result->toArray();
	} catch (ClientException $e) {
        echo getCommonResource('auth.not_config_dns');
        return;
//		return $e->getErrorMessage();
//        echo $e->getErrorMessage() . PHP_EOL;
	} catch (ServerException $e) {
	     echo getCommonResource('auth.config_error');
	     return;
//       echo $e->getErrorMessage() . PHP_EOL;
	}
}

function aes_decrypt($data) {
	$privateKey=$_SESSION['randomkey'];
	$iv=$_SESSION['randomkey'];
	$encryptedData=base64_decode($data);
	// $decrypted=openssl_decrypt(MCRYPT_RIJNDAEL_128,$privateKey,$encryptedData,MCRYPT_MODE_CBC,$iv);
	$decrypted=openssl_decrypt($encryptedData, "AES-128-CBC", $privateKey, OPENSSL_RAW_DATA|OPENSSL_ZERO_PADDING, $iv);
	return $decrypted;
}
function rand_captcha() {
  $key = '';
  $pattern = '1234567890';
  for( $i=0; $i<6; $i++ ) {
     $key .= $pattern[mt_rand(0, 9)];
  }
  return $key;
}
function url_splice($phone,$code) {
	if (!$phone && !$code) {
		return;
	}
	$file = '/mnt/boot/sms.json';

	if (file_exists($file)) {
		$json = file_get_contents($file);

		if ($json) {
			$data = json_decode($json, true);
		}

		if ($data) {
			$smsMsg = "【".$data['SMSprefix']."】".$data['smsContent'];
			$url = $data['gatewayAdd'] . '?uid=' . $data['serialNum'] . '&pw='. $data['password'] . '&mb=' . $phone . '&ms=' . $smsMsg . $code . '&ex=&tm=&dm=';
			return $url;
		}
	}
}

function alicloud_msg($phone,$code) {
	$file_path = '/mnt/boot/ali_msg.json';

	if (!file_exists($file_path)) {
		return array('Result'=> 'ERROR', 'Message'=> getCommonResource('auth.sms.aliconfig'));
	}

	if (!$phone && !$code) {
		return;
	}

	$json = file_get_contents($file_path);

	if ($json) {
		$data = json_decode($json, true);
	}

	return send_message($data['access_key'], $data['access_secret'], $phone, $data['sign_name'], $data['template_code'], array('code'=> $code, 'product'=> getCommonResource('auth.sms.product.fw')));
}

if($_GET['act']=='webauthlogin'){
	$isCaptcha = $_SESSION['auth_verification_enable'];//file_exists('/tmp/test_webauth');
	$data = base64_decode($_POST['data']);
	$data = json_decode($data, true);
	if($data['username']) $param['username'] = formatpost(aes_decrypt($data['username']));
	if($data['password']) $param['password'] = formatpost(aes_decrypt($data['password']));

	$param['username'] = base64_decode($param['username']);
	$showname = $param['username'];
	$param['password'] = base64_decode($param['password']);
	$param['username'] = bin2hex(urldecode($param['username']));
	$param['password'] = bin2hex($param['password']);

	if ($isCaptcha){
		if($data['validate']) $param['validate'] = formatpost($data['validate']);
	}

    if($data['token']) $param['token'] = formatpost(aes_decrypt($data['token']));

	$param['vsysid'] = $_SERVER['VSYSID']? $_SERVER['VSYSID']: 0;
	if ($isCaptcha){
		if($param['validate']!=$_SESSION[web_checknum] || strlen($param['validate'])==0 || strlen($_SESSION[web_checknum])==0){
			echo '0#'."check_num_error";
			return false;
		}
	}
    if($param['token']!=$_SESSION['token']){
        echo '0#'. "check_token_error";
        return false;
    }
	$param['password'] = $param['password'];
	$param['loginipaddr'] = $_SERVER['REMOTE_ADDR'];
	$param['login_type'] = 1;
	$rspString = getResponse( "webauthlogin", "show" , $param );
	$result = $rspString[webauthlogin][group];
	$result = (int)$result["result"];
	if( $result > 0){
		$param['logintime'] = $rspString[webauthlogin][group]['login_time'];
		$param['secret']  = $rspString[webauthlogin][group]['secret'];
		$hb  = $rspString[webauthlogin][group]['heartbeat'];
		$user_type  = $rspString[webauthlogin][group]['user_type'];
		$can_change_passwd  = $rspString[webauthlogin][group]['can_change_passwd'];
		$lifeTime = 24*3600*7;
		$param['logintype'] = 'webauth';
		$bname = base64_encode($showname);
		$param['username'] = $bname;
		setcookie('logincookie', json_encode($param), time() + $lifeTime, "/");
		echo $bname.'&'.$param['logintime'].'&'.$param['loginipaddr'].'&'.$param['secret'].'&'.$hb.'&'.$user_type.'&'.$can_change_passwd;
	}
	else{
		setcookie("logincookie", "", time() - 3600, "/");
		echo '0#'.$rspString[webauthlogin][group][err_msg];
	}
	return;
}
/* keepalive */
if($_GET['act'] == 'keepalive'){
	if($_POST['username']) $param['username'] = formatget($_POST['username']);
	$showname = base64_decode($param['username']);
	$param['username'] = bin2hex(urldecode($showname));
	//if($_POST['userip']) $param['userip'] = formatget($_POST['userip']);
	$param['userip'] = $_SERVER['REMOTE_ADDR'];
	$param['vsysid'] = $_SERVER['VSYSID'];
	if($_POST['secret']) $param['secret'] = formatget($_POST['secret']);

	$rspString = getResponse( "webauthkeepalive", "show" , $param );
	$result = $rspString[webauthkeepalive][group];
	$result = (int)$result["result"];
	if( $result > 0){
		$param['logintime'] = $rspString[webauthkeepalive][group]['login_time'];
		$param['loginipaddr'] = $rspString[webauthkeepalive][group]['userip'];
		$hb  = $rspString[webauthkeepalive][group]['heartbeat'];
		$login_duration  = $rspString[webauthkeepalive][group]['login_duration'];
		$can_change_passwd  = $rspString[webauthkeepalive][group]['can_change_passwd'];
		$param['logintype'] = 'webauth';
		$lifeTime = 24*3600*7;
		$param['username'] = base64_encode($showname);
		setcookie('logincookie', json_encode($param), time() + $lifeTime, "/");
		echo $param['username'].'&'.$param['logintime'].'&'.$param['loginipaddr'].'&'.$param['secret'].'&'.$hb.'&'.$login_duration.'&'.$can_change_passwd;
	}
	else{
		setcookie("logincookie", "", time() - 3600, "/");
		echo '0#'.$rspString[webauthlogin][group][err_msg];
	}
	return;
}
/* msgkeepalive */
if($_GET['act'] == 'msgkeepalive'){
	$module = 'sms_user_auth';
	if($_POST['name']) $param['name'] = formatget($_POST['name']);
	$param['ip'] = $_SERVER['REMOTE_ADDR'];

	$rspString = getResponse( $module, "showone" , $param );
	$ret = getAssign($rspString, $module);
	if( $ret['result'] > 0){
		$param['username'] = $ret['name'];
		$param['logintime'] = $ret['login_time'];
		$param['loginipaddr'] = $ret['ip'];
		$param['logintype'] = 'message';
		$lifeTime = 24*3600*7;
		setcookie('logincookie', json_encode($param), time() + $lifeTime, "/");
		echo $param['username'].'&'.$param['logintime'].'&'.$param['loginipaddr'] . '&' . $ret['online_time'];
	}else{
		setcookie("logincookie", "", time() - 3600, "/");
		echo '0#'.$ret[err_msg];
	}
	return;
}
/* freekeepalive */
if($_GET['act'] == 'freekeepalive'){
	$param['name'] = $_SERVER['REMOTE_ADDR'];
	$param['ip'] = $_SERVER['REMOTE_ADDR'];
	$param['vsysid'] = $_SERVER['VSYSID'];

	$rspString = getResponse( "free_user_auth", "show_one" , $param );
	$ret = getAssign($rspString, "free_user_auth");
	if( $ret['result'] > 0){
		$param['logintime'] = $ret['login_time'];
		$param['loginipaddr'] = $ret['ip'];
		$param['username'] = $ret['name'];
		$param['logintype'] = 'free_webauth';
		$lifeTime = 24*3600*7;
		setcookie('logincookie', json_encode($param), time() + $lifeTime, "/");
		echo $param['name'].'&'.$param['logintime'].'&'.$param['ip'] . '&' . $ret['online_time'];
	}
	else{
		setcookie("logincookie", "", time() - 3600, "/");
		echo '0#'.$rspString[free_user_auth][group][err_msg];
	}
	return;
}
//短信认证
if($_GET['act']=='sms_vlcode_check'){
	if($_POST['mobile']) $param['mobile'] = formatpost($_POST['mobile']);
    if($_POST['token']) $param['token'] = formatpost(aes_decrypt($_POST['token']));
	$param['vsysid'] = $_SERVER['VSYSID'];

    $vcode = rand_captcha();

    $result = alicloud_msg($param['mobile'], $vcode);

	//message($s['result']);


    /*$url = "http://47.100.76.43:18002/send.do";
    $params=array('uid'=>5,'pw'=>'056126','mb'=>$param['mobile'],'ms'=>$vcode_msg);
    $headers=array(
        "Content-Type:application/json;charset=utf-8",
        "Accept:application/json;charset=utf-8"
    );    //json序列化

    $params=json_encode($params, JSON_FORCE_OBJECT);
    $result=do_get($url,$params);*/

    if($result['Message']!='OK'){
		echo $result['Message'];
	}else{
		$srcip = $_SERVER[REMOTE_ADDR];
		$_SESSION[$srcip . '_phone'] = $param['mobile'];
		$_SESSION[$srcip . '_code'] = $vcode;
		$_SESSION[$srcip . '_timeout'] = time() + 120;
		echo "ok";
	}
    return;

/*    unset($_SESSION[web_checknum]);
	$param['password'] = $param['password'];
	$param['loginipaddr'] = $_SERVER['REMOTE_ADDR'];
	$rspString = getResponse( "webauthlogin", "show" , $param );
	$result = $rspString[webauthlogin][group];
	$result = (int)$result["result"];
	if( $result > 0){
		$param['logintime'] = $rspString[webauthlogin][group]['login_time'];
		$param['secret']  = $rspString[webauthlogin][group]['secret'];
		$hb  = $rspString[webauthlogin][group]['heartbeat'];
		$user_type  = $rspString[webauthlogin][group]['user_type'];
		$can_change_passwd  = $rspString[webauthlogin][group]['can_change_passwd'];
		$lifeTime = 24*3600*7;
		setcookie('logincookie', json_encode($param), time() + $lifeTime, "/");
		echo $param['username'].'&'.$param['logintime'].'&'.$param['loginipaddr'].'&'.$param['secret'].'&'.$hb.'&'.$user_type.'&'.$can_change_passwd;
	}
	else{
		setcookie("logincookie", "", time() - 3600, "/");
		echo '0#'.$rspString[webauthlogin][group][err_msg];
	}
	return;*/
}

//短信发送状态检查
if($_GET['act']=='sms_send_status') {
	$data = array('time_left' => 0);
	$srcip = $_SERVER[REMOTE_ADDR];
	$code = $srcip . '_code';
	$timeout = $srcip . '_timeout';
	$phone = $srcip . '_phone';

	if (empty($_SESSION[$code]) && empty($_SESSION[$timeout])) {
		echo json_encode($data);
	}

	if ($_SESSION[$code] && $_SESSION[$timeout] < time()) {
		unset($_SESSION[$phone]);
		unset($_SESSION[$code]);
		unset($_SESSION[$timeout]);
		echo json_encode($data);
	}

	if ($_SESSION[$code] && $_SESSION[$timeout] > time()) {
		$data['phone'] = $_SESSION[$phone];
		$data['time_left'] = $_SESSION[$timeout] - time();
		echo json_encode($data);
	}
	exit;
}

if($_GET['act']=='msgauthlogin') {
	$module = 'sms_user_auth';
	$data = base64_decode($_POST['data']);
	$data = json_decode($data, true);

	if($data['name']) $param['name'] = formatpost($data['name']);
	if($data['code']) $param['code'] = formatpost($data['code']);
    if($data['token']) $param['token'] = formatpost(aes_decrypt($data['token']));

	$srcip = $_SERVER[REMOTE_ADDR];


    if ($_SESSION[$srcip . '_timeout'] < time()) {

        $log_msg='SrcIP='.$srcip.' UserName='.$param['name'].' Operate="sms message" ManageStyle=web Content="verification code supermarket"';
        if(file_exists('/mnt1/mysql/')) {
            $db = new MysqlDb();
            $table_name = 'event_log_'.date('Ymd');
            $sql = 'INSERT INTO '.$table_name.' (daemon, time, type, level, src_ip, msg) VALUES ('."'".'23'."','".date('Y-m-d H:i:s',time())."','".'SYSTEM_INFO'."','".'5'."','".' '."','".$log_msg."'".')';
            $db->sql_query($sql);
        }else{
            $db = new DBUtil();
            $table = 'EVENT_LOG';
            $db->addEventLog(23,date('Y-m-d H:i:s',time()),'SYSTEM_INFO',5,'',$log_msg,$table);
        }

    	echo '0#'.getCommonResource('auth.cant.vldcode.timeout');
    	return;
    }

    if ($_SESSION[$srcip . '_phone']!=$param['name'] || $_SESSION[$srcip . '_code']!=$param['code']){

        $log_msg='SrcIP='.$srcip.' UserName='.$param['name'].' Operate="sms message" ManageStyle=web Content="verification code does not match mobile phone number"';
        if(file_exists('/mnt1/mysql/')) {
            $db = new MysqlDb();
            $table_name = 'event_log_'.date('Ymd');
            $sql = 'INSERT INTO '.$table_name.' (daemon, time, type, level, src_ip, msg) VALUES ('."'".'23'."','".date('Y-m-d H:i:s',time())."','".'SYSTEM_INFO'."','".'5'."','".' '."','".$log_msg."'".')';
            $db->sql_query($sql);
        }else{
            $db = new DBUtil();
            $table = 'EVENT_LOG';
            $db->addEventLog(23,date('Y-m-d H:i:s',time()),'SYSTEM_INFO',5,'',$log_msg,$table);
        }

    	echo '0#'.getCommonResource('auth.cant.vldcode.notmatch');
    	return;
    }
    if($_SESSION[$srcip . '_phone']==$param['name'] && $param['code']==$_SESSION[$srcip . '_code'] && $_SESSION[$srcip . '_timeout'] > time()) {
    	$data = array(
    		'name' => $param['name'],
    		'ip' => $_SERVER[REMOTE_ADDR]
		);
		$rspString = getResponse( $module, "add" , $data);
		$ret = getAssign($rspString, $module);

		if ($ret['code']) {
			echo '0#'.$ret['str'];
			return;
		}

		$rspString = getResponse( $module, "show" , $data );
		$ret = getAssign($rspString, $module);

		if ($ret['result'] > 0) {
			unset($_SESSION[$srcip . '_phone']);
			unset($_SESSION[$srcip . '_code']);
			unset($_SESSION[$srcip . '_timeout']);
			$ret['logintype'] = 'message';
			$lifeTime = 24*3600*7;
			setcookie('logincookie', json_encode($ret), time() + $lifeTime, "/");
			echo $ret['name'].'&'.$ret['login_time'].'&'.$ret['ip'] . '&' . $ret['online_time'];
		} else {
			setcookie("logincookie", "", time() - 3600, "/");
			echo '0#'.$ret[err_msg];
		}
		return;
    }

    echo '0#'.getCommonResource('auth.cant.vldcode.loginerr');
}

if($_GET['act']=='free_webauth_login'){
	$module = 'free_user_auth';
	$data = base64_decode($_POST['data']);
	$data = json_decode($data, true);

    if($data['token']) $param['token'] = formatpost(aes_decrypt($data['token']));

	$param['vsysid'] = $_SERVER['VSYSID']? $_SERVER['VSYSID']: 0;

    if($param['token']!=$_SESSION['token']){
        echo '0#'. "check_token_error";
        return false;
    }
    $param['name'] = $_SERVER['REMOTE_ADDR'];
	$param['ip'] = $_SERVER['REMOTE_ADDR'];
	//$rspStringadd = getResponse("free_user_auth", "add" , $param );
	//var_dump($rspStringadd);exit(0);
	$addString = getResponse($module, "add" , $param);
	$ret = getAssign($addString, $module);

	if ($ret['code']) {
		echo '0#' . $ret['str'];
		return;
	}

	$rspString = getResponse($module, "show" , $param );
	$result = $rspString[free_user_auth][group];
	$result = (int)$result["result"];
	if( $result > 0){
		$param['logintime'] = $rspString[free_user_auth][group]['login_time'];
		$param['secret']  = $rspString[free_user_auth][group]['secret'];
		$hb  = $rspString[free_user_auth][group]['heartbeat'];
		$user_type  = $rspString[free_user_auth][group]['user_type'];
		$lifeTime = 24*3600*7;
		$param['logintype'] = 'free_webauth';
		setcookie('logincookie', json_encode($param), time() + $lifeTime, "/");
		echo $param['name'].'&'.$param['logintime'].'&'.$param['ip'].'&'.$param['secret'].'&'.$hb.'&'.$user_type;
	}
	else{
		setcookie("logincookie", "", time() - 3600, "/");
		echo '0#'.$rspString[free_user_auth][group][err_msg];
	}
	return;
}

if($_GET['act']=='get_cheknum_show'){
	$param['lang']='cn';
	$rspString = getResponse("sys_auth_verification", "show" , $param );
	$result = $rspString[sys_auth_verification][group];
	$auth_verification_enable = (int)$result["auth_verification_enable"];
	$_SESSION['auth_verification_enable'] = $auth_verification_enable;
	echo $auth_verification_enable;
	return;

}
?>
