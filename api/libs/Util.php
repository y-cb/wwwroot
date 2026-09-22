<?php
namespace lib;

class Util{
	function redirect($url) {
		header('Location: ' . $url);
		exit;
	}

	/**
	 * $relative 相对于服务器根目录的地址
	 */
	function server_url($relative) {
		return $relative;
	}

	function last_url() {
		$l = getenv('HTTP_REFERER');
		if (false == $l)
			return '';

		$s = $_SERVER['SERVER_NAME'];
		$pos = stripos($l, $s) + strlen($s);
		return substr($l, $pos);
	}

	function remove_param($url, $key) {
		if (!is_array($key)) {
			$key = array($key);
		}
		$nodes = explode('?', $url, 2);
		if (1 == count($nodes))
			return $url;

		$params = explode('&', $nodes[1]);
		$url = $nodes[0];
		$cat = '?';
		foreach ($params as $v) {
			list($k) = explode('=', $v);
			if (in_array($k, $key))
				continue;
			$url .= $cat;
			$cat = '&';
			$url .= $v;
		}

		return $url;
	}

	function add_param($url, $params) {
		if (!is_array($params)) {
			$params = array($params);
		}
		foreach ($params as $v) {
			list($k) = explode('=', $v);
			$url = remove_param($url, $k);
		}
		$cat = '?';
		if (false !== strpos($url, $cat)) {
			$cat = '&';
		}
		foreach ($params as $v) {
			$url .= $cat;
			$cat = '&';
			$url .= $v;
		}
		return $url;
	}

	function param_exists($url, $param) {
		$nodes = explode('?', $url, 2);
		if (1 == count($nodes))
			return false;

		$params = explode('&', $nodes[1]);
		foreach ($params as $v) {
			list($k) = explode('=', $v);
			if ($param == $k)
				return true;
		}

		return false;
	}

	function current_url() {
		$url = $_SERVER['PHP_SELF'];
		$params = $_SERVER['QUERY_STRING'];
		if (strlen($params)) {
			$url .= '?' . $params;
		}
		return $url;
	}

	function get_listtree_state($name) {
		$key = 'LISTTREE/' . $name;
		$r = array();
		foreach ($_COOKIE as $k => $v) {
			if ($k == $key) {
				$r = explode(" ", $v);
			}
		}
		return $r;
	}

	function set_modify_state($value) {
		$_SESSION['MODIFY_STATE'] = $value ? true : false;
	}

	function get_modify_state() {
		return !empty($_SESSION['MODIFY_STATE']);
	}

	function hook_update_modify_state($url) {
		if (empty($url)) {
			$url = self::current_url();
		}
		$url = '/common/update_modify_state.php?url=' . rawurlencode($url);
		return $url;
	}
	/*
	function is_embeded() {
		if (isset($_GET[IS_EMBEDDED])) {
			if ("yes" == $_GET[IS_EMBEDDED]) {
				$_SESSION[IS_EMBEDDED] = $_GET[IS_EMBEDDED];
			} else {
				unset($_SESSION[IS_EMBEDDED]);
			}
		}
		return isset($_SESSION[IS_EMBEDDED]);
	}
	*/

	function is_embeded() {
		return isset($_SESSION[IS_EMBEDDED]);
	}

	function getmicrotime() {
		list($usec, $sec) = explode(" ", microtime());
		return ((float)$usec + (float)$sec);
	}

	function is_mockdev_mode() {
		return isset($_SESSION[MOCK_DEVICE]);
	}

	/*
	设置版本，在login.html中调用，为方便集中管理中心，所以在login.html中设置
	*/
	function set_version($version) {
		return $_SESSION[DEV_VERSION] = $version;
	}

	/*
	获取版本
	*/
	function get_version() {
		return $_SESSION[DEV_VERSION];
	}

	/*
	replace pattern #{aa} in $url with $data[aa]
	*/
	function replace_pattern($url, $data) {
		$p = '/#\{(\w+)\}/';
		preg_match_all($p, $url, $all, PREG_SET_ORDER);
		foreach ($all as $v) {
			$pp = "/" . preg_quote($v[0]) . "/";
			$url = preg_replace($pp, $data[$v[1]], $url);
		}
		return $url;
	}

	/**
	 *解码,"和'进行转义,使js脚本能正常运行
	 */
	function specialCharsConvert($data) {
		$data = html_entity_decode($data, ENT_QUOTES, "utf-8");
	/*	$data = ereg_replace('"','\"',$data);
		$data = ereg_replace("'","\'",$data);
		$data = ereg_replace("<","&lt;",$data);
	*/
		$data = htmlspecialchars($data, ENT_QUOTES);
		return $data;
	}

	/**
	*	设置虚拟系统的状态
	**/
	function setSystemState(){
		if (!isset($_SESSION['vsys_enable'])) {
			$vsys = MainModel::getConvertedData('vsys_switch');
			if ($vsys instanceof arraylist) {
				$vsysinfo = $vsys['0'];
				$_SESSION['vsys_enable'] = $vsysinfo['enable'];
				$_SESSION['vsys_cnt'] = $vsysinfo['vsys_cnt'];
				if (1 == $vsysinfo['enable']) {
					$virture = MainModel::getConvertedData('vsys_user');
					$vs = $virture[0];
					$_SESSION['vsys_root'] = (0 == $vs['vsys_id']) ? true : false;
					$_SESSION['vsys_name'] = $vs['vsys_name'];
					$_SESSION['vsys_switch'] = (1 == $vs['vsys_switch_enable']) ? true : false;
				}
			}
		}
	}
	function vsys_enable() {
		return $_SESSION['vsys_enable'];
	}

	function is_vsys_root() {
		return $_SESSION['vsys_root'];
	}

	function vsys_switch_enable() {
		return $_SESSION['vsys_switch'];
	}

	function get_vsys_name() {
		return $_SESSION['vsys_name'];
	}

	function get_vsys_cnt() {
		return $_SESSION['vsys_cnt'];
	}

	function unsetSystemState() {
		unset($_SESSION['vsys_enable']);
		unset($_SESSION['vsys_cnt']);
		unset($_SESSION['vsys_root']);
		unset($_SESSION['vsys_name']);
		unset($_SESSION['vsys_switch']);
	}

	/*
	**  tree和tab的显示,权限控制
	*/
	function setPageDisplay() {
		if (!isset($_SESSION['page_display'])) {
			$items = MainModel::getConvertedData('page_display');
			$item = $items[0];
			$_SESSION['page_display'] = serialize($item);
		}
	}

	function getPageDisplay() {
		return unserialize($_SESSION['page_display']);
	}

	/**
	 * 获取权限列表，模块名
	 * $rule 角色名 0超级管理员，1用户管理员，2审计管理员
	 */
	function getRights($rule){
		$rights = array();
		$audit_right = array(
			'admin_authen_login',
			'admin_authen_logout',
			'page_display',
			'hostinfo',
			'license_info',
			'wizard_state',
			'ha_show_status',
			'syslog_filter',
			'change_admin_passwd',
			'save_config'
		);

		switch($rule) {
			case 0:
				break;
			case 1:
				break;
			case 2:
				$rights = $audit_right;
				break;
			default:
				break;
		}
		return $rights;
	}

	/**
	 * 授权信息
	 */
	function setLicence(){
		if (!isset($_SESSION['license_info'])) {
			$items = MainModel::getConvertedData('license_info');
			$item = $items[0];
			$_SESSION['license_info'] = serialize($item);
		}
	}
	/**
	 * 授权信息
	 */
	function setLicence_(){
		if (!isset($_SESSION['license_info'])) {
			$item['adc_layer7_time'] = 1;
			$item['smart_dns_time'] = 1;
			$item['gtm_time'] = 1;
			$item['l4_firewall_time'] = 1;
			$item['l7_firewall_time'] = 1;
			$_SESSION['license_info'] = serialize($item);
		}
	}

	function getLicence(){
		return unserialize($_SESSION['license_info']);
	}

	function isSetPageDisplay() {
		return isset($_SESSION['page_display']);
	}

	/**
	 * 将标准格式IP转换为特殊格式字符串：000000000000000000000000FFFFFFFF
	 * @param $ip   标准格式IP地址
	 * @param $tyoe   ip地址类型，IPV4-4 IPV6-6
	 * @return 转换为16进制的字符串000000000000000000000000FFFFFFFF
	 */
	function transIP($ip,$type){
		if(!is_null($ip)){
			if($type == 4){
				$ip_pre = '000000000000000000000000';
				//$ip = $ip_pre.sprintf('%X',ip2long($ip));
				$ip = str_pad(sprintf('%X',ip2long($ip)), 32, '0', STR_PAD_LEFT);
			}else if($type == 6){
				$ip = fillIPv6($ip);
				$ip = str_replace(':','',$ip);
			}
		}
		return $ip;
	}

	/**
	 * 将掩码格式IP转换为地址起始范围
	 * @param $ip   点分十进制IP/掩码
	 * @param $tyoe   ip地址类型，IPV4-4 IPV6-6
	 * @return 转换为16进制的字符串000000000000000000000000FFFFFFFF
	 */
	function getRangeIP($ip, $type) {
		$ips = array();
		if(!is_null($ip)){
			if($type == 4){
				$pos = strpos($ip,'/');
				$mask = substr($ip, $pos + 1);
				$ip = substr($ip, 0, $pos);

				$ip = ip2long($ip);
				$mask = 0xffffffff << (32 - $mask);
				$mask = 0x00000000FFFFFFFF & $mask;//兼容64位系统
				$nw = $ip & $mask;
				$ips['startIP'] = '000000000000000000000000'.sprintf('%X',$nw);
				if (strlen($ips['startIP'])<32) {
					$ips['startIP'] = '0'. $ips['startIP'];
				}
				$endip = '';
				$endip = $nw|(~$mask & 0x00000000FFFFFFFF);//兼容64位系统
				$ips['endIP'] = '000000000000000000000000'.sprintf('%X',$endip);
				if (strlen($ips['endIP'])<32) {
					$ips['endIP'] = '0'.$ips['endIP'];
				}
			}else if($type == 6){
				$pos = strpos($ip,'/');
				$mask = substr($ip, $pos + 1);
				$ip = substr($ip, 0, $pos);
				$ip = fillIPv6($ip);
				$nm = $mask%16;
				$ip_arr = explode(':',$ip);
				$start = null;
				$end = null;
				if($nm == 0){
					$nm = $mask/16;
					for($i=0; $i<$nm; $i++){
						$start .= $ip_arr[$i];
					}
					$end = $start;
					for($j=0; $j<8-$nm; $j++){
						$start .= '0000';
						$end .= 'FFFF';
					}
				}else{
					$_nm = floor($mask/16);
					for($i=0; $i < $_nm+1; $i++){
						if($i == $_nm){
							$end = $start;
							$_mask = 0XFFFF << (16-$nm);
							$_mask = 0x000000000000FFFF & $_mask;
							$tmp = (intval($ip_arr[$i],16))&$_mask;
							$start .= sprintf('%X',$tmp);
							$tmp = $tmp | (~$_mask & 0x000000000000FFFF);
							$end .= sprintf('%X',$tmp);
						}else{
							$start .= $ip_arr[$i];
						}
					}
					for($j=0; $j<8-$_nm-1; $j++){
						$start .= '0000';
						$end .= 'FFFF';
					}
				}
				$ips['startIP'] = $start;
				$ips['endIP'] = $end;
			}
		}
		return $ips;
	}

	/**
	 * 将IPv6地址转换为完整的IPv6格式。
	 * @param $addr IPv6地址
	 */
	 function fillIPv6($addr) {
		// 标准IPv6格式
		if (!ipv6_check($addr)) return $addr;
		//$addr = self::_fix_v4($addr);
		$arr = explode(':',$addr);
		foreach ($arr as $a) {
			$l = strlen($a);
			if ( $l > 0 && $l < 4 )
				$arr2[] = str_repeat('0', 4-$l).$a;
			else $arr2[] = $a;
		}
		$addr = join(':',$arr2);
		$fil = ':'.str_repeat('0000:', 9-count($arr));
		$addr = str_replace('::',$fil,$addr);
		$addr = preg_replace('/^\:/','0000:',$addr);
		$addr = preg_replace('/\:$/',':0000',$addr);
		return strtoupper($addr);
	}

	/**
	 * 获取IP版本，IPv4返回数字4，IPv6返回数字6，否则返回0。
	 * @param $addr IP地址
	 */
	function getIPVersion($addr){
		if(strpos($addr,'/') !== false){
			$pos = strpos($addr,'/');
			$addr = substr($addr, 0, $pos);
		}
		$ver = 0;
		if(self::ipv4_check($addr))
			$ver = 4;
		if(self::ipv6_check($addr))
			$ver = 6;
		return $ver;
	}

	/**
	 * 判断IPv4地址是否合法。
	 * @param $addr IPv4地址
	 */
	function ipv4_check($addr) {
		$arr = explode('.', $addr);
		$l = count($arr);
		for ( $i=0;$i<$l;$i++ ) {
			if ( strlen($arr[$i]) > 3 ) return false;
			if ( !is_numeric($arr[$i]) ) return false;
			$a = intval($arr[$i], 10);
			if ($a > 255 || $a <0) return false;
		}
		return true;
	}

	/**
	 * 判断IPv6地址是否合法。
	 * @param $addr IPv6地址
	 */
	function ipv6_check($addr) {
		//$addr = self::_fix_v4($addr);
		if ( strpos($addr, '.') ) return false;
		$l1 = count(explode('::',$addr));
		if ( $l1 > 2 ) return false;
		$l2 = count(explode(':',$addr));
		if ( $l2 < 3 || $l2 > 8 ) return false;
		if ( $l2 < 8 && $l1 !== 2 ) return false;
		preg_match('/^([0-9a-f]{0,4}\:)+[0-9a-f]{0,4}$/i',$addr,$arr);
		if ( !$arr[0] ) return false;
		return true;
	}

	/**
	 * 给流量的数字转换成带单位的表示。
	 * @param $type 单位1-b 0|null-kb 2-B
	 */
	function add_unit($num, $type = null){
		if($num == 0)	//去掉0.00这样的数字，使直接显示0
			$num = 0;
		if($type == null){
			$num = $num * 1024;
		}
		$result = $num;
		$byte_s_TB = $num/(1024*1024*1024*1024);
		$byte_s_GB = $num/(1024*1024*1024);
		$byte_s_MB = $num/(1024*1024);
		$byte_s_KB = $num/1024;

		if($byte_s_TB>1)
			$result = round($byte_s_TB,2).' Tb';
		else if($byte_s_GB>1)
			$result = round($byte_s_GB,2).' Gb';
		else if($byte_s_MB>1)
			$result = round($byte_s_MB,2).' Mb';
		else if($byte_s_KB>1)
			$result = round($byte_s_KB,2).' Kb';
		else
			$result = $num . ' b';
		if($type == 2)
			$result = str_replace('b', 'B', $result);
		return $result;
	}

	/**
	 * 格式化数字，换算成K,M,G。
	 * @param $num 具体数字
	 */
	function formatNum($num){
		$result = $num;
		$num_G = $num/(1000*1000*1000);
		$num_M = $num/(1000*1000);
		$num_K = $num/1000;

		if($num_G > 1)
			$result = round($num_G, 2).' G';
		else if($num_M > 1)
			$result = round($num_M, 2).' M';
		else if($num_K > 1)
			$result = round($num_K, 2).' K';
		else
			$result = $num;
		return $result;
	}

	/*
	* 报表发送邮件
	* @param $type 报表任务类型 a-自动任务 m-手动任务
	* @param $subject 邮件主题
	* @param $to 收件人，多个收件人用分号隔开
	* @param $fileName 邮件附件名称，不用后缀
	*
	*/
	function sendEmail($type, $subject, $to, $fileName){
		system("report_email -t ".$type." -s \"".$subject."\" -f \"".$fileName."\" -r \"".$to."\"");
	}

	/**
	 * 获取mask长度
	 */
	function getMaskLen($mask){
		if('0.0.0.0' == $mask)
			return 0;
		if($mask >=0 && $mask <= 128)
			return $mask;
		else {
			$_mask = strpos(decbin(ip2long($mask)),"0");
			return !$_mask? 32 : $_mask;
		}
	}

	/**
	 * 扩展in_array方法，支持array里边是key=>value的方式
	 */
	function inarrayByKey($str, $arr = null, $key = null){
		$re = false;
		if(isset($key)){
			$tmp = array();
			foreach($arr as $value){
				$tmp[] = $value[$key];
			}
			$re = in_array($str, $tmp);
		}else{
			$re = in_array($str, $arr);
		}
		return $re;
	}

	/**
	 * 获取系统类型
	 * 1-不支持虚拟化的bos系统，2-支持虚拟化的bos系统，3-vadc系统。
	 */
	function getVer(){
		$v = 1;
		//$host_file1 = '/mnt/boot/host_kernel.img';
		//$host_file2 = '/mnt/boot/host_rootfs.img';
		$virt_file = "/virtflag";
		$vadc_file = '/proc/in_vm_mode';
		if (file_exists($vadc_file)) {
			$i = file_get_contents($vadc_file);
			if ($i == 1) {
				return 3;
			}
		}
		//if (file_exists($host_file1) && file_exists($host_file2)) {
		if (file_exists($virt_file)) {
			return 2;
		}
		return $v;
	}

	function get_https($url, $data='', $method='GET'){
	    $curl = curl_init(); // 启动一个CURL会话
	    curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
	    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检查
	    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); // 从证书中检查SSL加密算法是否存在
	    curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
	    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
	    curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
	    if($method=='POST'){
	        curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
	        if ($data != ''){
	            curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
	        }
	    }
	    if($method=='PUT'){
	    	curl_setopt ($ch, CURLOPT_CUSTOMREQUEST, "PUT");
	    	if ($data != ''){
	            curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // PUt提交的数据包
	        }
	    }
	    curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
	    curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
	    $tmpInfo = curl_exec($curl); // 执行操作
	    curl_close($curl); // 关闭CURL会话
	    return $tmpInfo; // 返回数据
	}
	function httpRequest($url,$method,$postfields = null,$headers = array(),$debug = false){

		$method = strtoupper($method);
		$ci = curl_init();
		/* Curl setting */
		curl_setopt($ci,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_1_0);
		curl_setopt($ci,CURLOPT_USERAGENT,"Mozilla/5.0 (Windows NT 6.2; WOW64; rv:34.0) Gecko/20100101 Firefox/34.0");
		curl_setopt($ci,CURLOPT_CONNECTTIMEOUT, 60); //在发起连接前等待的时间，如果设置为0，则无限等待
		curl_setopt($ci,CURLOPT_TIMEOUT, 7);//设置curl允许执行的最长秒数
		curl_setopt($ci,CURLOPT_RETURNTRANSFER, true);
		switch ($method) {
			case "POST":
				curl_setopt($ci,CURLOPT_POST,true);
				if (!empty($postfields)) {
					$tmpdatastr = is_array($postfields) ? http_build_query($postfields) :$postfields;
					curl_setopt($ci,CURLOPT_POSTFIELDS,$tmpdatastr);
					curl_setopt($ci,CURLOPT_HTTPHEADER,array('Content-Type: application/json', 'Content-Length: '.strlen($tmpdatastr)));
				}
				break;
			default:
				curl_setopt($ci,CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
				curl_setopt($ci,CURLOPT_CUSTOMREQUEST,$method);//设置请求方式
				break;
		}
		$ssl = preg_match('/^https:\/\//i',$url) ? TRUE : FALSE;
		curl_setopt($ci,CURLOPT_URL,$url);
		if ($ssl) {
			curl_setopt($ci,CURLOPT_SSL_VERIFYPEER,FALSE);//https请求 不验证证书和hosts
			curl_setopt($ci,CURLOPT_SSL_VERIFYHOST,FALSE);//不从证书中检查SSL加密算法是否存在
		}
		curl_setopt($ci,CURLOPT_FOLLOWLOCATION,1);
		curl_setopt($ci,CURLOPT_MAXREDIRS,2);//指定最多的http重定向的数量，这个选项是和CURLOPT_FOLLOWLOCATION一起使用的
		curl_setopt($ci,CURLINFO_HEADER_OUT,true);

		curl_setopt($ci, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
		curl_setopt($ci, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
		$tmpInfo = curl_exec($ci); // 执行操作
		curl_close($ci); // 关闭CURL会话
		$output = json_decode($tmpInfo,true);
		return $output;
	}
}
?>
