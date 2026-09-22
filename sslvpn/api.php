<?php
require_once '../common/config.inc';
require_once '../common/cfgeng.inc';
require_once '../common/common.inc';
require_once '../common/func.inc';
require_once 'sslvpn_lang.php';

initSystem();
function aes_decode($data, $method, $key) {
	return openssl_decrypt(base64_decode($data),  $method, $key, OPENSSL_RAW_DATA);
}
// require_once 'sslvpn_lang.php';

if($_POST['submit']=='webauthlogin'){
		if($_POST['username']) $param['username'] = formatpost($_POST['username']);
		if($_POST['password']) $param['password'] = formatpost($_POST['password']);
		$param['loginipaddr'] = $_SERVER['REMOTE_ADDR'];
		$rspString = getResponse( "webauthlogin", "show" , $param );
		$result = $rspString[webauthlogin][group];
		$result = (int)$result["result"];
	if( $result > 0){
		$param['logintime'] = $rspString[webauthlogin][group]['login_time'];
		$param['secret']  = $rspString[webauthlogin][group]['secret'];
		$hb  = $rspString[webauthlogin][group]['heartbeat'];
		$lifeTime = 24*3600*7;
	    setcookie("user", $param['username'], time() + 3600,"/" );
		$_SESSION[LOGINSTATE] = 'set';
		//if(isset($_COOKIE["user"])){
		echo '1';
		//}else{
	//	echo '2';
	//	}
		// echo $param['username'].'|'.$param['logintime'].'|'.$param['loginipaddr'].'|'.$param['secret'].'|'.$hb;
	}else{
	    setcookie("user","",time()-3600,"/");
		echo '0#'.$rspString[webauthlogin][group][err_msg];
	}
	return;
}

if($_POST['submit']=='vpn_tmlimit'){
	if($_POST['terminalinfo']) $param['terminalinfo'] = formatpost($_POST['terminalinfo']);
	if($_POST['version']) $param['version'] = formatpost($_POST['version']);
	$str = aes_decode($param['terminalinfo'], 'aes-256-ecb', '73756e7961696e666f73736c76706e32');
	parse_str($str, $arr);
	$module = 'vpn_user_tmlimit_info';
	$param['remote_addr'] = $_SERVER[REMOTE_ADDR];
	$rspString = getResponse( $module, "add" , $param );
	$ret = getAssign($rspString, $module);

	if(empty($ret)){
		//将硬件码缓存为session，用于进行其他连接校验
		if (!$_SESSION[DEVICE.CODE]||$_SESSION[DEVICE.CODE]!= $param['terminalinfo']) {
			$_SESSION[VPN.TERMINAL.TYPE] = $arr['terminal_type'];
		}
		$isopen = getResponse('vpn_subauth_cfg', 'show', '');
		$isopen = getAssign($isopen, 'vpn_subauth_cfg');

		/* else {
			$msg = array('code'=> '869', 'str'=> '用户终端受限，请联系管理员');
			echo json_encode($msg);
			return;
		}*/
		$data = array('code'=> '200', 'authtype'=> ($isopen['otp_enable']== 1 ? 'OTP': ''));
		echo json_encode($data);
	}else{
		if(strstr($ret['str'], "APP Store")){
			$err_arr = explode('，', getCommonResource('sslvpn.error.msgios'));
		}else{
			$err_arr = explode('，', getCommonResource('sslvpn.error.msg'));
		}
		if (strstr($ret['str'], $err_arr[0]) != false && strstr($ret['str'], $err_arr[1]) != false) {
			$ret['code'] = '200';
			$ret['authtype'] = 'update';
			if(strstr($ret['str'], "APP Store") == false){
				$ret['url'] = 'https://'. $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . '/api.php?submit=vpn_download';
			}
		}
		echo json_encode($ret);
	}
	return;
}

if($_POST['submit']=='vpn_auth') {
	$module = 'vpn_subauth_otp_check';
	// if($_POST['username']) $param['username'] = formatpost($_POST['username']);
	if($_POST['terminalinfo']) $param['terminalinfo'] = formatpost($_POST['terminalinfo']);
	if($_POST['otp']) $param['otp_code'] = formatpost($_POST['otp']);
	$str = aes_decode($param['terminalinfo'], 'aes-256-ecb', '73756e7961696e666f73736c76706e32');
	parse_str($str, $arr);
	$param['user_name'] = $arr['username'];
	//添加临时处理逻辑
	if ($arr['username'] && $arr['password'] && $arr['terminal_id'] && $arr['terminal_type']) {
		if (!$param['user_name'] || !$param['otp_code']) {
			echo json_encode(array('code'=> '1', 'str'=> '缺少参数'));
			return;
		}
		/*if ($_SESSION[USERNAME] && $_SESSION[OTP] && $_SESSION[USERNAME] == $param['username'] && $_SESSION[OTP] == $param['otp']) {
			echo json_encode(array('code'=> '1', 'str'=> '验证失败'));
			return;
		}*/
		$rspString = getResponse($module, 'add', $param);
		$ret = getAssign($rspString, $module);
		if (empty($ret)) {
			echo json_encode(array('code'=> '200', 'str'=> ''));
		} else {
			echo json_encode($ret);
		}
	} else {
		echo json_encode(array('code'=> '1', 'str'=> '用户未登录'));
	}
	return;
}

/*if($_POST['submit']=='vpn_version_check') {
	$module = 'vpn_client_version';
	if($_POST['version']) $param['version'] = formatpost($_POST['version']);
	//校验逻辑
	if($_POST['terminalinfo']) $param['terminalinfo'] = formatpost($_POST['terminalinfo']);
	$str = aes_decode($param['terminalinfo'], 'aes-256-ecb', '73756e7961696e666f73736c76706e32');
	parse_str($str, $arr);


	//添加临时处理逻辑
	if ($_SESSION[VPN.TERMINAL.TYPE] && $arr['terminal_type'] == $_SESSION[VPN.TERMINAL.TYPE]) {
		if ($param['version']) {
            $param['terminal_type'] = $_SESSION[VPN.TERMINAL.TYPE];
    		$rspString = getResponse($module, 'add', $param);
    		$ret = getAssign($rspString, $module);
            //如果非最新版本，再获取版本路径
            if (!empty($ret) && $ret['code']) {
                //数据拼接整理
                $ret['url'] = 'https://'. $_SERVER['SERVER_NAME'] . ':' . $_SERVER['REMOTE_PORT'] . '/api.php?submit=vpn_download';
            } else {
                echo json_encode(array('code'=> '200', 'str'=> ''));
            }

    	} else {
    		echo json_encode(array('code'=> '1', 'str'=> '缺少参数'));
    	}
	} else {
	    echo json_encode(array('code'=> '2', 'str' => '用户'));
	}

	return;
}*/

if ($_GET['submit']=='vpn_download') {
	$terminal_type_array = array('Android'=>'ANDROID', 'Windows32'=> 'WIN32', 'Windows64'=> 'WIN64');
	$terminalinfo = $_GET['terminalinfo'];
	$terminalinfo = str_replace(' ', '+', $terminalinfo);

	/*if (strpos($terminalinfo, ' ')){
		$arr = explode(' ', $terminalinfo);
		foreach ($arr as $key => $value) {
			if (strstr($_SESSION[VPN.TERMINAL.INFO], $value)) {
				$terminalinfo = $_SESSION[VPN.TERMINAL.INFO];
				$istrue = true;
				break;
			}
		}
	}*/
	$str = aes_decode($terminalinfo, 'aes-256-ecb', '73756e7961696e666f73736c76706e32');
	if (!$str) {
		echo json_encode(array('code'=> '3', 'str'=> '用户异常，请重新登录'));
		return;
	}

	parse_str($str, $terminal);

	$path_name = 'VPNCLIENT_' . strtoupper($terminal_type_array[$terminal['terminal_type']]);

	if (file_exists('/mnt1/mysql/')) {
		$download_path = '/mnt1/vpn_client/' . $path_name . '/';
	} else {
		$download_path = '/mnt/boot/vpn_client/' . $path_name . '/';
	}

	if (file_exists($download_path)) {
		$filename = scandir($download_path);
		$file = '';

		// 定义一个数组接收文件名
		foreach($filename as $k=>$v){
		    // 跳过两个特殊目录   continue跳出循环
		    if($v=="." || $v==".." || $v== "readme.txt" || $v=="md5"){continue;}
		    $file = $v;
		}

		ini_set("memory_limit", "512M");

		$download_path .= $file;

		download_file($download_path, $file);
	} else {
		echo json_encode(array('code'=> '-1', 'str' => 'Please contact the administrator.'));
		return;
	}


}

function download_file($path, $filename) {
	//以只读和二进制模式打开文件
    $sh = fopen ( $path, "rb" );



    //告诉浏览器这是一个文件流格式的文件

    Header ( "Content-type: application/octet-stream" );

    //请求范围的度量单位

    Header ( "Accept-Ranges: bytes" );

    //Content-Length是指定包含于请求或响应中数据的字节长度

    Header ( "Accept-Length: " . filesize ( $path ) );

    //用来告诉浏览器，文件是可以当做附件被下载，下载后的文件名称为$file_name该变量的值。

    Header ( "Content-Disposition: attachment; filename=" . $filename );

    //读取文件内容并直接输出到浏览器

    echo fread ( $sh, filesize ( $path ) );

    fclose ( $sh );

    exit ();
}
