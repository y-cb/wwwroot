<?php

define('EXCLUDE_ARRAY', ['c', 'h', 'php']);
define('UPLOAD_FILE', '/tmp/webserver.escape');
define('SSO_FILE', '/tmp/sso_config.json');
define('SSO_TOKEN', 'hiooobmg08kl6a7h7vg9k920gt');

function getSysCmd($param,$xml,$module,$action="submit"){
	global $global;
	$param['page'] = ($_GET['page']||$_POST['page'])?$_POST['page']:1;
	// $param['count'] = ($_GET['count']||$_POST['rows'])?$_POST['rows']:$global['count'];
	$param['page'] = ($param['page'])?$param['page']:$_GET['page'];
	$param['count'] = ($param['pageSize'])?$param['pageSize']:$param['count'];

	/*return '<?xml version="1.0" encoding="UTF-8" standalone="no"?> <request-list module="'.$module.'" action="'.$action.'" language="'.$GLOBALS['language_cmd'].'"  page="'.$param['page'].'" count="'.$param['count'].'" total="0"> <group> '.$xml.' </group> </request-list>';*/
	return '<?xml version="1.0" encoding="UTF-8" standalone="no"?><'.$module.' action="'.$action.'" language="'.$GLOBALS['language_cmd'].'"  page="'.$param['page'].'" count="'.$param['count'].'" total="0"><group>'.$xml.'</group></'.$module.'>';
}
function getResponse($module, $action, $param=array(), $unchecked=0, $field=array()){
	global $DEMO_DATA,$DEBUG_SWITCH,$RECORD_MODE,$OFFLINE_MODE;
	if( $DEMO_DATA == 1 || $OFFLINE_MODE == 1 ){
		/*$sendCmd = requestXml($module,$action,$param, $url);
		$demo_send_file = "req_".$url.".xml";
		$demo_data_file = "./data/rsp_".$module."_".$action.".xml";

		if( $submit == null)
		{
			$handle = fopen( $demo_data_file, 'rb');
			$xmlStr = @fread($handle, filesize ($demo_data_file));
			@pclose($handle);
		}

		if($DEBUG_SWITCH == 1)
			echo debugWindow('<h2 style="width:600px;">Send String:<input type="button" value="resend"></h2><textarea style="width:600px;height:80px;">'.$sendCmd.'</textarea><h2 style="width:600px;">Response File:<br>'.$demo_data_file.'</h2>'.htmlspecialchars($xmlStr));*/
	}
	else{
		//send to system
		$socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
		if (false == $socket)
			return false;

		$socketaddr = tempnam(DOMAIN_SOCKET_DIR, DOMAIN_SOCKET_PREFIX);
		unlink($socketaddr);

		if (!$socketaddr
			|| !socket_bind($socket, $socketaddr)
			|| !socket_connect($socket, DOMAIN_SOCKET_REMOTE)) {
			socket_close($socket);
			return false;
		}

		$api_key = $_GET['api_key'];
		if (!empty($api_key)) {
			$path = '/mnt/boot/sso_key.json';
			if (file_exists($path)) {
				$data = file_get_contents($path);
				$data = json_decode($data);
				if ($data === $api_key) {
					$api_key = $data;
				}
				
				//$api_key = ($data === $api_key)? 'hiooobmg08kl6a7h7vg9k920gt': $api_key;
			}
			$cmd = new utm_cmd(UCT_CMD, $api_key);
		} else {
			if (!$_SESSION[CONNECTION.ISUPER]){
				$sid = session_id();
			} else {
				$sid = 'hiooobmg08kl6a7h7vg9k920gt';
			}

			// $cmd = new utm_cmd(UCT_CMD, session_id());
			$cmd = new utm_cmd(UCT_CMD,$sid);
		}
		$sendCmd = requestXml($module,$action,$param,$unchecked,$field);

		$cmd->body->name = $module;
		$cmd->body->setdata($sendCmd);
		$send = $cmd->tobytes();

		$recv = transferpacket($socket, $send, strlen($send));
		$echo = new utm_echocmd();

		if (!$echo->frombytes($recv)) {
			throw new SocketException('echo bytes error!');
		}

		$code = $echo->body->errcode;
		if($code == 30000){
			$_SESSION[CONNECTION.USERNAME] = '';
			header("HTTP/1.1 401 Unauthorized");
			$ret = array('code' => '401', 'str' => 'Not login');
			echo json_encode($ret);
			exit();
		}

		$xmlStr = $echo->body->getdata();

		if($DEBUG_SWITCH == 1){
			echo debugWindow('<h2 style="width:600px;">Send String:</h2>'.htmlspecialchars($sendCmd).'<h2 style="width:600px;">Response:</h2>'.htmlspecialchars($xmlStr));
		}
		if($RECORD_MODE == 1){
			$demo_data_file = "./data/rsp_".$module."_".$action.".xml";
			if($fp = fopen($demo_data_file, 'w')) {
				flock($fp, 4);
				fwrite($fp, $xmlStr);
				fclose($fp);
			}
		}
	}
	response_Socket_Close($socket,$socketaddr);
	$retarray = domXmlToArr($xmlStr);
	return $retarray;
}
function response_Socket_Close($socket,$socketaddr) {
	if (isset($socket)) {
		socket_close($socket);
		unset($socket);
	}
	if (file_exists($socketaddr)) {
		unlink($socketaddr);
	}
}
function getRespXML($module, $action, $param, $submit=0){
}
function requestXml($module,$action,$param,$unchecked=0,$field=array()){
	return getSysCmd($param,arr2DomXml($param,$unchecked,$field),$module,$action);
}
function sendReqXml($xml){
	return ($xml)?domXmlToArr($xml):null;
}
function getAssign($array, $module_name,$json=1, $list=0){
	if(array_key_exists($module_name,$array)){
		$array = $array[$module_name];
		if($array==null)
			return $array;
		if( $json == false ){
			if($array['group'][0] == null){
				if($array[group])
					$retArr['group'][0] = $array['group'];
				else
					$retArr['group'] = array();
				if( $array['page'] )	$retArr['page'] = $array['page'];
			}
			if($array['group'][0])
				$retArr = $array;
			return $retArr;
		}
		$array = $array['group'];

		if( is_array($array[0]) && sizeof($array) > 1 ){
			$retArr = array();
			foreach( $array as $index=>$item ){
				foreach($item as $i=>$e){
					if(is_array($e))
					$item[$i] = json_encode($e);
				}
				$retArr[$index] = $item;
			}
		}
		else{
			if($array)
			{
				foreach($array as $i=>$e){
					$Arr[$i] = (is_array($e))?json_encode($e):$e;
				}
				if( $list ){
					$retArr[0] = $Arr;
				}
				else
					$retArr = $Arr;
			}
		}
		return $retArr;
	}else{
		return $array[return_code][group];
	}
}
function getAssignExpand($array, $json=1, $list=0){
	$array = $array['response-list'];
	if($array==null)
		return $array;
	if( $json == false ){
		if($array['group'][0] == null){
			if($array[group])
				$retArr['group'][0] = $array['group'];
			else
				$retArr['group'] = array();
			if( $array['page'] )	$retArr['page'] = $array['page'];
		}
		if($array['group'][0])
			$retArr = $array;
		return $retArr;
	}
	$array = $array['group'];
	if( is_array($array[0]) && sizeof($array) > 1 ){
		$retArr = array();
		foreach( $array as $index=>$item ){
			foreach($item as $i=>$e){
				if(is_array($e))
				$item[$i] = json_encode($e);
			}
			$retArr[$index] = $item;
		}
	}
	else{
		if($array)
		{
			foreach($array as $i=>$e){
				$Arr[$i] = (is_array($e))?json_encode($e):$e;
			}
			if( $list ){
				$retArr[0] = $Arr;
			}
			else
				$retArr = $Arr;
		}
	}
	return $retArr;
}
function getTotal( $array ){
	if($array['response-list'])
	return $array['response-list']['page']['total'];
	else
		return 0;
}
function fmtRetParam($array){
	return $array;
}
function getAddressObj($default=1,$prefix=0){
	$_GET['count'] = -1;
	$rspString = getResponse( "obj_address", "showindex" , $param );
	$retParam = getAssign($rspString,"obj_address", $json_el=true, $list=true);
	$Option = ajaxOptions($retParam);
	$Option = ($default)?$Option:$Option;

	$rspString = getResponse( "obj_address_grp", "showindex" , $param );
	$retParam = getAssign($rspString, "obj_address_grp",$json_el=true, $list=true);
	if($retParam){
		$grpOption = ajaxOptions($retParam);
		$grpOption = ($default)?"<optgroup label=\"".module_Translation_Table('obj_address',1)."\">".$grpOption:$grpOption;
		return $Option.$grpOption;
	}
	return $Option;
}
function getAddressPreObj($default=1,$prefix=0){
	$_GET['count'] = -1;
	$rspString = getResponse( 'obj_address', "showindex" , $param, 'obj_address_grp_show' );
	$retParam = getAssign($rspString);
	$obj_add_arr = formatReToArr($retParam);
	if($obj_add_arr[0]){
		$code = "<option value='A:' attr='A00'>".module_Translation_Table('obj_address',0)."</option>";
		foreach($obj_add_arr as $k=>$items){
			$code .= "<option value='A:".$items['name']."' attr='A0".($k+1)."'>".$items['name']."</option>";
		}
	}
	$rspString = getResponse( 'obj_address_grp', "showindex" , $param, 'obj_address_grp_show' );
	$groupParam = getAssign($rspString);
	$obj_add_grp_arr = formatReToArr($groupParam);
	if($obj_add_grp_arr[0]){
		$code .= "<option value='G:' attr='G00'>".module_Translation_Table('obj_address',1)."</option>";
		foreach($obj_add_grp_arr as $key=>$items){
			$code .= "<option value='G:".$items['name']."' attr='G0".($key+1)."'>".$items['name']."</option>";
		}
	}
	return $code;

}
function getServiceObj($default=1,$prefix=0){
	$_GET['count'] = -1;

	$rspString = getResponse( "obj_service_predef", "showindex" , $param );
	$retParam = getAssign($rspString,"obj_service_predef", "obj_service_predef",true,true);
	$predefOption = ($prefix)?ajaxOptions($retParam, $default = "", $json = false, $prefix = "pre:" ):ajaxOptions($retParam);
	$predefOption = ($default)?$predefOption:$predefOption;

	$rspString = getResponse( "obj_service_custom", "showindex" , $param );
	$retParam = getAssign($rspString,"obj_service_custom",true,true);
	$customOption = ($prefix)?ajaxOptions($retParam, $default = "", $json = false, $prefix = "cus:"):ajaxOptions($retParam);
	$customOption = ($default)?"<optgroup label=\"".module_Translation_Table('obj_service',1)."\">".$customOption:$customOption;

	$rspString = getResponse( "obj_service_grp", "showindex" , $param );
	$retParam = getAssign($rspString, "obj_service_grp",true,true);
	$grpOption = ($prefix)?ajaxOptions($retParam, $default = "", $json = false, $prefix = "grp:"):ajaxOptions($retParam);
	$grpOption = ($default)?"<optgroup label=\"".module_Translation_Table('obj_service',2)."\">".$grpOption:$grpOption;

	return $predefOption.$customOption.$grpOption;
}
function getServicePreObj($default=1,$prefix=0){
	$_GET['count'] = -1;
	$rspString = getResponse( 'obj_service_predef', "showindex" , $param, 'obj_service_grp_show' );
	$retParam = getAssign($rspString,'obj_service_predef');
	$obj_predef_arr = formatReToArr($retParam);
	$code = "<option value='P:'>".module_Translation_Table('obj_service',0)."</option>";
	foreach($obj_predef_arr as $items){
		$code .= "<option value='P:".$items['name']."'>".$items['name']."</option>";
	}

	$rspString = getResponse( 'obj_service_custom', "showindex" , $param, 'obj_service_grp_show' );
	$retParam = getAssign($rspString,'obj_service_custom');
	$obj_custom_arr = formatReToArr($retParam);
	if($obj_custom_arr[0]){
		$code .= "<option value='C:'>".module_Translation_Table('obj_service',1)."</option>";
		foreach($obj_custom_arr as $items){
			$code .= "<option value='C:".$items['name']."'>".$items['name']."</option>";
		}
	}
	$rspString = getResponse( 'obj_service_grp', "showindex" , $param, 'obj_service_grp_show' );
	$retParam = getAssign($rspString,'obj_service_grp');
	$obj_group_arr = formatReToArr($retParam);

	if($obj_group_arr[0]){
		$code .= "<option value='G:'>".module_Translation_Table('obj_service',2)."</option>";
		foreach($obj_group_arr as $items){
			$code .= "<option value='G:".$items['name']."'>".$items['name']."</option>";
		}
	}
	return $code;
}
function getApplication($cate){
	$others = array("instant-messaging", "online-community", "email", "file-transfer", "search-engine", "online-shopping");
	$is_othters = 0;

	if (isset($cate)) {
		$param['name'] = $cate;
	} else {
		$is_othters = 1;
	}
	$rspString = getResponse( "app_profile", "show" , $param );
	$retParam = getAssign($rspString,"app_profile", true,true);

	if($retParam){
		$appOptions .='<option value=""></option>';
		if (count($retParam) == count($retParam, 1))
			$appOptions .='<option value="'.$retParam[name].'">'.$retParam[name].'</option>';
		else{
			foreach($retParam as $key=>$value){
				if ($value['name'] == 'any') {
					continue;
				} else {
					if ($is_othters == 1 && in_array($value['category'], $others)) {
						continue;
					}
					$appOptions .='<option value="'.$value[name].'">'.$value[name].'</option>';
				}
			}
		}
	}
	return $appOptions;
}

function getAppObj(){
	$rspString = getResponse( "app_profile", "show_i" , $param );
	$retParam = getAssign($rspString,"app_profile", true,true);
	//$appOptions = '<option value=\'any\'>any</option>';
	if($retParam){
		if (count($retParam) == count($retParam, 1))
			$appOptions .='<option value="'.$retParam[name].'">'.$retParam[show_name].'</option>';
		else{
			foreach($retParam as $key=>$value){
				if ($key == 'any') {
					continue;
				} else {
					$appOptions .='<option value="'.$value[name].'">'.$value[show_name].'</option>';
				}
			}
		}
	}

	$rspString = getResponse( "app_category", "show_i" , $param );
	$retParam = getAssign($rspString,"app_category", true,true);
	$appCateOptions = '';
	if($retParam){
		if (count($retParam) == count($retParam, 1))
			$appOptions .='<option value="'.$retParam[name].'">'.$retParam[show_name].'</option>';
		else{
			foreach($retParam as $key=>$value){
				$appCateOptions .='<option value="'.$value[name].'">'.$value[show_name].'</option>';
			}
		}
	}

	$rspString = getResponse( "app_group", "show_i" , $param );
	$retParam = getAssign($rspString,"app_group", true,true);
	$appGroupOptions = '';
	if($retParam){
		if (count($retParam) == count($retParam, 1))
			$appOptions .='<option value="'.$retParam[name].'">'.$retParam[name].'</option>';
		else{
			foreach($retParam as $key=>$value){
				$appGroupOptions .='<option value="'.$value[name].'">'.$value[name].'</option>';
			}
		}
	}
	$lang = LocalUtil::getCurrentLocal();
	if ($lang == "zh") {
		return "<option value=\"any\">所有</option><optgroup label=\"".module_Translation_Table('obj_apps',1)."\">".$appCateOptions."</optgroup><optgroup label=\"".module_Translation_Table('obj_apps',2)."\">".$appGroupOptions."</optgroup><optgroup label=\"".module_Translation_Table('obj_apps',0)."\">".$appOptions."</optgroup>";
	} else {
		return "<option value=\"any\">any</option><optgroup label=\"".module_Translation_Table('obj_apps',1)."\">".$appCateOptions."</optgroup><optgroup label=\"".module_Translation_Table('obj_apps',2)."\">".$appGroupOptions."</optgroup><optgroup label=\"".module_Translation_Table('obj_apps',0)."\">".$appOptions."</optgroup>";
	}

	//return "<option value=\"any\">any</option><optgroup label=\"".module_Translation_Table('obj_apps',1)."\">".$appCateOptions."</optgroup><optgroup label=\"".module_Translation_Table('obj_apps',2)."\">".$appGroupOptions."</optgroup><optgroup label=\"".module_Translation_Table('obj_apps',0)."\">".$appOptions."</optgroup>";
}
function getScheduleObj(){
	$_GET['count'] = -1;
	$rspString = getResponse( "obj_schedule_cycle", "showindex" , $param );
	$retParam = getAssign($rspString,"obj_schedule_cycle", $json_el=true, $list=true);
	$cycleOption = ajaxOptions($retParam);

	$rspString = getResponse( "obj_schedule_once", "showindex" , $param );
	$retParam = getAssign($rspString,"obj_schedule_once", $json_el=true, $list=true);
	$oncOption = ajaxOptions($retParam);

	/*$rspString = getResponse( "obj_schedule_once", "showindex" , $param );
	$retParam = getAssign($rspString, $json_el=true, $list=true);
	$onceOption = ajaxOptions($retParam);

	$rspString = getResponse( "obj_schedule_month", "showindex" , $param );
	$retParam = getAssign($rspString, $json_el=true, $list=true);
	$monthOption = ajaxOptions($retParam);

	return "<optgroup label=\"".module_Translation_Table('obj_schedule',0)."\">".$dailyOption."<optgroup label=\"".module_Translation_Table('obj_schedule',1)."\">".$weeklyOption."<optgroup label=\"".module_Translation_Table('obj_schedule',2)."\">".$onceOption."<optgroup label=\"".module_Translation_Table('obj_schedule',3)."\">".$monthOption;*/

	return "<optgroup label=\"".module_Translation_Table('obj_schedule',0)."\">".$cycleOption."<optgroup label=\"".module_Translation_Table('obj_schedule',1)."\">".$oncOption;

}
function getInterface(){
	$rspString = getResponse( 'tb_vlan', "show_i" );
	$vlan_retParam = getAssign($rspString,'tb_vlan');
	$vlan_Options = '';
	if($vlan_retParam){
		if (count($vlan_retParam) == count($vlan_retParam, 1))
			$vlan_Options .='<option value="'.$vlan_retParam[vlan_name].'">'.$vlan_retParam[vlan_name].'</option>';
		else{
			foreach($vlan_retParam as $key=>$value){
				$vlan_Options .='<option value="'.$value[vlan_name].'">'.$value[vlan_name].'</option>';
			}
		}
	}
	$rspString = getResponse( 'interface_sub', "show" );
	$interface_sub_retParam = getAssign($rspString,'interface_sub');
	$interface_sub_Options = '';
	if($interface_sub_retParam){
		if (count($interface_sub_retParam) == count($interface_sub_retParam, 1))
			$interface_sub_Options .='<option value="'.$interface_sub_retParam[name].'">'.$interface_sub_retParam[name].'</option>';
		else{
			foreach($interface_sub_retParam as $key=>$value){
				$interface_sub_Options .='<option value="'.$value[name].'">'.$value[name].'</option>';
			}
		}
	}
	$rspString = getResponse( 'trunk_interface', "show" );
	$trunk_interface_retParam = getAssign($rspString,'trunk_interface');
	$trunk_interface_Options = '';
	if($trunk_interface_retParam){
		if (count($trunk_interface_retParam) == count($trunk_interface_retParam, 1))
			$trunk_interface_Options .='<option value="'.$trunk_interface_retParam[name].'">'.$trunk_interface_retParam[name].'</option>';
		else{
			foreach($trunk_interface_retParam as $key=>$value){
				$trunk_interface_Options .='<option value="'.$value[name].'">'.$value[name].'</option>';
			}
		}
	}

	$rspString = getResponse( 'security_region', "show" );
	$security_region_retParam = getAssign($rspString,'security_region');
	$security_region_Options = '';
	if($security_region_retParam){
		if (count($security_region_retParam) == count($security_region_retParam, 1))
			$security_region_Options .='<option value="'.$security_region_retParam[name].'">'.$security_region_retParam[name].'</option>';
		else{
			foreach($security_region_retParam as $key=>$value){
				$security_region_Options .='<option value="'.$value[name].'">'.$value[name].'</option>';
			}
		}
	}
/*display ajax reference*/
	return "<option value='any'>any</option>".$vlan_Options.$interface_sub_Options.$trunk_interface_Options.$security_region_Options;
}
function qosInterface(){
	$param['type']=11;
	$rspString = getResponse( 'interface_sub', "show" ,$param);

	$interface_sub_retParam = getAssign($rspString,'interface_sub');
	$interface_sub_Options = '';
	if($interface_sub_retParam){
		if (count($interface_sub_retParam) == count($interface_sub_retParam, 1)){
			if($interface_sub_retParam[name]!='mgt' && $interface_sub_retParam[name]!='eha'){
				$interface_sub_Options .='<option value="'.$interface_sub_retParam[name].'">'.$interface_sub_retParam[name].'</option>';
			}
		}
		else{
			foreach($interface_sub_retParam as $key=>$value){
				if($value[name]!='mgt' && $value[name]!='eha'){
					$interface_sub_Options .='<option value="'.$value[name].'">'.$value[name].'</option>';
				}
			}
		}
	}
	return $interface_sub_Options;
}
function getUsers(){
	$_GET['count'] = -1;
	$rspString = getResponse( 'auth_user', "showindex" , $param, 'aaa_user_show' );
	$userParam = getAssign($rspString,'auth_user', $json_el=true, $list=true);

	$rspString = getResponse( 'auth_user_grp', "show" , $param, 'aaa_user_show' );
	$groupParam = getAssign($rspString,'auth_user_grp', $json_el=true, $list=true);
	if($groupParam)
		return ajaxUserOptions($userParam)."<optgroup label=\"".module_Translation_Table('aaa_users',1)."\">".ajaxUserOptions($groupParam);
	else
		return ajaxUserOptions($userParam);
}
function getUsersSymbol($name = ''){
	$_GET['count'] = -1;
	$rspString = getResponse( 'auth_user', "showindex" , $param, 'aaa_user_show' );
	$userParam = getAssign($rspString,'auth_user');
	$obj_user_arr = formatReToArr($userParam);
	$code = "<option value='U:'>".module_Translation_Table('aaa_users',0)."</option>";
	foreach($obj_user_arr as $items){
		$code .= "<option value='U:".$items['name']."'>".$items['name']."</option>";
	}
	$rspString = getResponse( 'auth_user_grp', "show" , $param, 'aaa_user_show' );
	$groupParam = getAssign($rspString,'auth_user_grp');
	$obj_user_grp_arr = formatReToArr($groupParam);

	$code .= "<option value='G:'>".module_Translation_Table('aaa_users',1)."</option>";
	foreach($obj_user_grp_arr as $items){
		if ($items['name'] !== $name) {
			$code .= "<option value='G:".$items['name']."'>".user_Groups_Translation_Table($items['name'])."</option>";
		}

	}
	return $code;
}
function getUserGrp(){
	$rspString = getResponse( 'auth_user_grp', "show" , $param, 'aaa_user_show' );
	$groupParam = getAssign($rspString,'auth_user_grp');
	return ajaxOptions($groupParam);
}
/*
* 模块属性翻译对照表
*/
function module_Translation_Table($module,$inx){
	$languageid = sys_get_language();
	$ret_array = array(
		'aaa_users' =>array(
			'en' => array('-- Users --','-- Users groups --'),
			'cn' => array('-- 用户 --','-- 用户组 --')
		),
		'obj_address' =>array(
			'en' => array('-- Address --','-- Address groups --'),
			'cn' => array('-- 地址 --','-- 地址组 --')
		),
		'obj_schedule' =>array(
			'en' => array('-- Absolute Time --','-- Periodic Time --','-- Once Schedule --','-- Month Schedule --'),
			'cn' => array('-- 周期时间 --','-- 绝对时间 --','-- 单次计划--','-- 月计划--')
		),
		'obj_service' =>array(
			'en' => array('-- Service predef --','-- Service custom--','-- Service groups--'),
			'cn' => array('-- 预定义服务 --','-- 自定义服务--','-- 服务组--')
		),
		'obj_apps' =>array(
			'en' => array('-- Apps --','-- App groups--'),
			'cn' => array('-- 应用对象 --','-- 应用分类--','-- 应用组 --')
		),
		'obj_addr_track' =>array(
			'en' => array('-- Addr Track --','-- Addr Group Track --'),
			'cn' => array('-- 地址探测 --','-- 地址探测组--')
		),
		'aaa_radius' =>array(
			'en' => array('-- RADIUS --','-- RADIUS groups --'),
			'cn' => array('-- RADIUS --','-- RADIUS组 --')
		),
		'aaa_ldap' =>array(
			'en' => array('-- LDAP --','-- LDAP groups --'),
			'cn' => array('-- LDAP --','-- LDAP组 --')
		)
	);
	return $ret_array[$module][$languageid][$inx];
}
/*
* 用户组翻译对照表
*/
function user_Groups_Translation_Table($value){
	$languageid = sys_get_language();
	$ret_array = array(
		'anonymous' =>array(
			'en' => 'anonymous',
			'cn' => '匿名用户组'
		),
		'anonymovs' =>array(
			'en' => 'anonymous',
			'cn' => '匿名用户组'
		),
		'mobile' =>array(
			'en' => 'mobile',
			'cn' => '移动用户组'
		),
		'sam' =>array(
			'en' => 'SAM',
			'cn' => 'SAM用户组'
		),
		'portal-server' =>array(
			'en' => 'Portal Server',
			'cn' => 'Portal用户组'
		),
		'smp' =>array(
			'en' => 'SMP',
			'cn' => 'SMP用户组'
		),
		'Radius-user' =>array(
			'en' => 'Radius-user',
			'cn' => 'Radius用户组'
		),
		'Ldap-user' =>array(
			'en' => 'Ldap-user',
			'cn' => 'Ldap用户组'
		),
		'wechat' =>array(
			'en' => 'Wechat',
			'cn' => '微信用户组'
		),
		'sms_authentication' =>array(
			'en' => 'sms_authentication',
			'cn' => '短信用户组'
		),
		'remote' =>array(
			'en' => 'remote',
			'cn' => '远程用户组'
		),
		'auth-group' =>array(
			'en' => 'Authentication',
			'cn' => '认证用户组'
		)
	);
	if($ret_array[$value])
		return $ret_array[$value][$languageid];
	return $value;
}
function getResponseXml(
		$operation_name,
		$operation_func,
		$key = "param",
		$setParam = null,
		$c_Def = 0,
		$page = -1,
		$count = 20
	){
	global $debugModule;
	if($setParam)
	{
		if($c_Def==1){
			$setParamStr = "<".$key." ";
			foreach($setParam as $index=>$item){
				if( !is_array($item) )
					$setParamStr .= $index."=\"".$item."\" ";
			}
			$setParamStr .= ">";
			foreach($setParam as $index=>$item){
				if( is_array($item) ){
					$setParamStr .= "<$index>";
						for($i=0,$l=sizeof($item);$i<$l;$i++){
							$setParamStr .= setArrXmlAtt($item[$i]);
						}
					$setParamStr .= "</$index>";
				}
			}
			$setParamStr .= "</".$key.">";
		}
		elseif($c_Def==2){
			$setParamStr = "<".$key." ";
			foreach($setParam as $index=>$item){
				if( !is_array($item) )
					$setParamStr .= $index."=\"".$item."\" ";
			}
			$setParamStr .= ">";
			foreach($setParam as $index=>$item){
				if( is_array($item) ){
					for($i=0,$l=sizeof($item);$i<$l;$i++){
						$setParamStr .= setArrXmlAtt($item[$i],$index);
					}
				}
			}
			$setParamStr .= "</".$key.">";
		}
		else{
			$setParamStr = "<".$key." ";
			foreach($setParam as $index=>$item){
				if( is_array($item) ){

					//$setParamStr .= "<$index><param name=\"\"/></$index>";
				}
				else
					$setParamStr .= $index."=\"".$item."\" ";
			}
			$setParamStr .= "/>";
		}
	}
	$sendMsg = '<?xml version="1.0" encoding="utf-8"?><request-list operation_name="'.$operation_name.'" operation_func="'.$operation_func.'" page="'.$page.'" count="'.$count.'" total="0" loginUser="root" from="0" language="EN" request_id="0" virtual_id="0" ha="0" op="1" >'.$setParamStr.'</request-list>';

	$reg_msg = php_call_mgd($sendMsg,"1");
	if($debugModule == 1){
		echo debugWindow('<div id="debugMsg"><h2>Send Message</h2>'.htmlspecialchars($sendMsg).'<h2>Response Message</h2>'.htmlspecialchars($reg_msg)."</div>");
	}
	return $reg_msg;
}
function getResponseCustomXml($operation_name="",$operation_func="",$xml, $page=-1, $count=20){
	global $DEMO_DATA,$debugModule;
	$sendMsg = '<?xml version="1.0" encoding="utf-8"?><request-list operation_name="'.$operation_name.'" operation_func="'.$operation_func.'" page="'.$page.'" count="'.$count.'" total="0" loginUser="'.$_SESSION['username'].'@'.$_SESSION['sessionid'].'" from="0" language="EN" request_id="0" virtual_id="0" ha="0" op="1" >'.$xml.'</request-list>';

	$reg_msg = php_call_mgd($sendMsg,"1");

	if($debugModule == 1){
		echo debugWindow('<div id="debugMsg"><h2>Send Message</h2>'.htmlspecialchars($sendMsg).'<h2>Response Message</h2>'.htmlspecialchars($reg_msg)."</div>");
	}
	return $reg_msg;
}
function getResponseArr(
	$xmlStr,
	$operation_name = ""
){
	global $debugModule;
	require_once("./libs/XmlParser.class.php");
	$xml = new XmlParser();
	$xml->parseData($xmlStr);
	$tree = $xml->getTree();

	$ret[ErrorCode] = $tree[0][attrs][ERRORCODE];
	$ret[ErrorString] = $tree[0][attrs][ERRORSTRING];
	$ret[Total] = $tree[0][attrs][RESPONSE_GET_COUNT];
	$ret[Content] = $tree[0][child];

	return $tree;
}
function getArrAttrs( $arr ){
	return $arr = $arr[0][attrs];
}
function getPageTotal( $arr ){
	$array = getArrAttrs($arr);
	return $array['TOTAL'];
}
function getPageAttr($isPage=true){
	global $global;

	$page = Array();
	$page['page'] = ($_GET['page']||$_POST['page'])?$_POST['page']:1;
	$page['count'] = ($_GET['count']||$_POST['rows'])?$_POST['rows']:$global['count'];

	return $page;
}
function getPageLink($url,$total=0,$count=20){
	global $global;

	$page = Array();
	$page['page'] = ($_GET['page'])?$_GET['page']:1;
	$page['count'] = ($_GET['count'])?$_GET['count']:$global['count'];
	$page['total'] = $total;
	$page['link'] = $url;
	if($count)	$page['count'] = $count;

	$_SESSION['link'] = ($_GET['page'])?"&page=".$page['page']."&count=".$page['count']:'';
	return json_encode($page);
}
function getAssignArr( $arr, $arrKey = -1, $childDeep = 2){
	if( is_array($arr) && sizeof($arr) > 0 ){
		$arr = $arr[0][child];
		$retArr = array();
		if( is_array($arr) && sizeof($arr) > 0 )
		foreach( $arr as $index=>$item ){
			$retArr[$index] = $item[attrs];
			if(isset($item[child])){
				for( $i=0,$length=sizeof($item[child]);$i<$length;$i++ ){
					if($childDeep == 1)
						$retArr[$index][$item[child][$i][name]]=getChildArr($item);
					else if($childDeep == 2)
						$retArr[$index][$item[child][$i][name]]=getChildArr($item[child][$i]);
				}
			}
		}
	}
	return ( $arrKey == -1 )?$retArr:$retArr[$arrKey];
}
function getChildArr($arr){
	return ($arr[child])?json_encode($arr[child]):json_encode($arr);
}
function getNameArr($arr,$key=''){
	for($i=0,$l=sizeof($arr);$i<$l;$i++){
		$array[$i]['id'] = $arr[$i]['NAME'];
		$array[$i]['text'] = $arr[$i]['NAME'];
		if($key){
			if(in_array($array[$i]['text'],explode(",",$key)))
				$array[$i]['checked'] = "true";
		}
	}
	return $array;
}
function getItemArrOption($arr,$item='',$key=''){
	$str="";
	for($i=0,$l=sizeof($arr);$i<$l;$i++){
		if($key){
			if(in_array($arr[$i][$item],explode(",",$key))){
				$str.="<option value=\"".$arr[$i][$item]."\" checked>".$arr[$i][$item]."</option>";

			}
			else{
				$str.="<option value=\"".$arr[$i][$item]."\">".$arr[$i][$item]."</option>";

			}
		}
	}
	return $str ;
}
function getArrChild($array){
	if(sizeof($array)==1){
		if( sizeof(array_keys($array[0]['attrs'])) == 1 )
			return $array[0]['attrs']['NAME'];
		else
			return $array[0]['attrs'];
	}
	else{
		for( $i=0,$l=sizeof($array);$i<$l;$i++ ){
			$Arr[$i] = $array[$i]['attrs']['NAME'];
		}
		return json_encode($Arr);
	}
}
function setArrXmlAtt($Arr, $key="param"){
	if( is_array($Arr) ){
		$setParamStr = "<$key ";
		foreach($Arr as $index=>$item){
				$setParamStr .= $index."=\"".$item."\" ";
		}
		$setParamStr .= "/>";
		return $setParamStr;
	}
	else
		return "<$key name=\"".$Arr."\" /> ";
}
function getResult($Arr, $arrKey = -1){
	return $Arr[0][attrs];
}
function getRetParam( $param ){
	$retParam = array();
	foreach( $param as $i=>$item ){
		$retParam[strtoupper($i)]=$item;
	}
	return $retParam;
}
function getAppsCateNameObject($get_cache_file = 1){
	$objfile = S_ROOT.'./cachedata/templates/__json_obj_app_cate.tpl';
	if(!file_exists($objfile))
	{
		$_GET['count'] = 3500;
		$rspString = getResponse( "obj_app_category", "showindex" , $param, 'obj_app_show_cate' );
		$retParam = getAssign($rspString,$json_el=true, $list=true);

		foreach($retParam as $i=>$item){
			$array[$i][id] = $item[id];
			$array[$i][name] = $item[name];
			$array[$i][name_cn] = $item[name_cn];
		}

		$code = json_encode($array);

		if($get_cache_file)
		{
			if(!@$fp = fopen($objfile, 'w')) {
				exit("Directory './cachedata/templates/' not found or have no access!");
			}
			flock($fp, 4);
			fwrite($fp, $code);
			fclose($fp);
			return $code;
		}
	}
	else{
		if(@$fp = fopen($objfile, 'r')) {
			$template = fread( $fp, filesize($objfile));
			fclose($fp);
			return $template;
		}
	}
}
/** ------PHP SQLITE3--------- **/
class My_SQLite3_DB extends SQLite3
{
	private $row = null;
	private $db_file = '/tmp/local_tmp.db';
    private $db_tmp  = '/tmp/sqlite3_tmp.db';
	function __construct($file = '/tmp/local_tmp.db', $file_tmp = '/tmp/sqlite3_tmp.db')
    {
		$this->db_file = $file;
		$this->db_tmp = $file_tmp;

	//if (!file_exists($this->db_tmp))
			copy($this->db_file, $this->db_tmp);
        $this->open($this->db_tmp);
    }
	function get_SQLite3_data_result($table_name,$where,$pageSize,$offset,$order_cloumn = 'id',$sort_status = 'desc'){
		$sql = 'select * from '.$table_name.' '.$where.' order by '.$order_cloumn.' '.$sort_status.' limit '.$pageSize.' offset '.$offset.';';
		$result = $this->query($sql);
		$retdata = array();
		while ($line = $result->fetchArray()) {
			$row = (int)$i++;
			$retdata[group][$row] = $line;
		}
		return $retdata;
	}
	function get_SQLite3_data_count($table_name,$where,$count_cloumn = '1'){
		$sql = 'SELECT count('.$count_cloumn.') FROM '.$table_name.' '.$where.'';
		$totalNum = $this->querySingle($sql);
		$totalNum = (int)$totalNum;
		return $totalNum;
	}
	function __destruct()
    {
		$this->close();
		if (file_exists($this->db_tmp))
			system('rm -rf '.$this->db_tmp);
    }
}
function sys_get_language(){
	return $GLOBALS['language_define'];
}
function sys_code_msg_cover($code,$ext_par){
	//转换成错误信息
	$en_msg_array = array(
			'0' => array(
				'softupdate'=>'Upgrade file has been successfully issued，it will become effective after system reboot,and then, featrue lib will fall back to the initial release, please reboot to upgrade online.',
				'ipsupdate'=>'Feature DB upgrade success',
				'avupdate'=>'Feature DB upgrade success',
				'nacupdate'=>'Feature DB upgrade success',
				'urlupdate'=>'Feature DB upgrade success',
				'sys_config'=>'Import configuration file is successful, the system takes effect after reboot',
			),
			'23' => 'Creating Socket failed',
			'24' => 'Illegal gate',
			'135' => 'Version file dose not exist',
			'136' => 'No more space to execute the operation',
			'137' => 'Invalid system upgrade file',
			'138' => 'Version file CRC verification failed.',
			'139' => 'Saving version file failed.',
			'155' => ' Reading Socket error',
			'156' => 'Writing Socket error',
			'187' => 'Importing file error',
			'188' => 'Upgrading AV DB and IPS DB error',
			'189' => 'Upgrading AV DB/IPS DB URL specification is wrong,for example:http://..../...',
			'194' => 'AV DB/IPS DB specification is wrong',
			'198' => 'Saving Configuration failed',
			'199' => 'Unseting all failed',
			'200' => 'Disk is busy,operation failed,and try later.',
			'208' => array(
				'nacupdate' =>'Application Audit and Control Update Service,Not valid',
				'urlupdate'=>'URL Category Update Service,Not valid',
			),
			'209' => 'Invalid feature specification',
			'210' => 'The function is forbidden,for license is invalid or expired',
			'211' => 'current version does not support',
			'221' => 'IPS DB specification is wrong.',
			'222' => 'AV DB is wrong',
			'224' => 'Upgrading AV DB interval is too short,try later please.',
			'281' => 'File has already existed',
			'282' => 'Uploading file failed',
			'283' => 'File is too large.',
			'30000' => 'Session does not exist',
			'40000' => 'No reading or writing permissions',
			'50000' => 'Uploading file failed',
			'50001' => 'When page processing, communications failed',
			'50002' => 'File does not exist.',
			'50003' => ' Downloading file failed',
			'50004' => 'File does not exist or is too large.',
			'291' => 'Upgrade operation success',
			'292' => 'Upgrade operation failed',
			'293' => 'Upgrade timeout',
			'294' => 'Upgrade status unknown',
			'253' => 'Being upgraded TELNET, WEB or MGR by other means, please wait. . .',
	);
	$cn_msg_array = array(
			'0' => array(
				'softupdate'=>'升级文件已经成功下发,对于软件升级系统重启后方可生效,系统生效后特征库将回退至初始版本，请重新在线升级',
				'ipsupdate'=>'特征库升级成功',
				'avupdate'=>'特征库升级成功',
				'nacupdate'=>'特征库升级成功',
				'urlupdate'=>'特征库升级成功',
				'sys_config'=>'导入配置文件成功,系统重启后生效',
			),
			'23' => '创建Socket失败',
			'24' => '非法网关',
			'135' => '版本文件不存在',
			'136' => '没有空间执行该操作',
			'137' => '无效的系统升级文件',
			'138' => '版本文件的CRC校验失败',
			'139' => '保存版本文件失败',
			'155' => '读Socket错误',
			'156' => '写Socket错误',
			'187' => '导入文件错误',
			'188' => '升级防病毒特征库,入侵防御特征库错误',
			'189' => '升级防病毒特征库/入侵防御特征库的URL格式错误，应该为http://..../...',
			'194' => '防病毒特征库或者入侵防御特征库格式错误',
			'198' => '保存配置失败',
			'199' => '恢复出场配置失败',
			'200' => '设备磁盘忙，操作失败，请稍候重试',
			'208' => array(
				'nacupdate' =>'应用监控升级服务未授权,请授权后再试',
				'urlupdate'=>'URL分类库升级服务未授权,请授权后再试',
			),
			'209' => '升级包校验失败，错误的升级包',
			'210' => '该功能被禁止，因为License无效或过期',
			'211' => 'current version is not support',
			'221' => '入侵防御特征库格式错误',
			'222' => '防病毒特征库错误',
			'224' => '防病毒特征库升级间隔太短，请稍候再试',
			'281' => '文件已经存在',
			'282' => '上传文件失败',
			'283' => '文件太大',
			'30000' => '会话不存在',
			'40000' => '没有读或者写权限',
			'50000' => '文件上传失败',
			'50001' => '页面处理时，与设备通讯失败',
			'50002' => '文件不存在',
			'50003' => '文件下载失败',
			'50004' => '文件不存在或超大',
			'291' => '升级操作成功',
			'292' => '升级操作失败',
			'293' => '升级超时',
			'294' => '升级状态未知',
			'253' => '另外一个升级任务正在进行，请稍后重试',
	);
	if(sys_get_language() == 'en'){
		if($ext_par)
			return $en_msg_array[$code][$ext_par];
		else
			return $en_msg_array[$code];
	}else{
		if($ext_par)
			return $cn_msg_array[$code][$ext_par];
		else
			return $cn_msg_array[$code];
	}
}
function getMessageResponse($utc_type,$cmd_body_name, $fname){
	$socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
	if (false == $socket)
	{
		echo "socket failure\n";
		return false;
	}
	$socketaddr = tempnam(DOMAIN_SOCKET_DIR, DOMAIN_SOCKET_PREFIX);
	unlink($socketaddr);

	if (!$socketaddr
		|| !socket_bind($socket, $socketaddr)
		|| !socket_connect($socket, DOMAIN_SOCKET_REMOTE)) {
		socket_close($socket);
		echo "socket close\n";
		return false;
	}
	$api_key = $_GET['api_key'];
	if (!empty($api_key)) {
		$cmd = new utm_cmd(UCT_CMD, $api_key);
	} else {
		$cmd = new utm_cmd(UCT_CMD, session_id());
	}
	$cmd->body->name = $cmd_body_name;
	$cmd->body->setdata($fname);
	$send = $cmd->tobytes();
	$recv = transferpacket($socket, $send, strlen($send));
	$echo = new utm_echocmd();

	if (!$echo->frombytes($recv)) {
		throw new SocketException('echo bytes error!');
	}

	$code = $echo->body->errcode;
	if($code == 30000){
		header('Location:/logout.php');
		return;
	}
	$data = $echo->body->getdata();
	return $code ;
}
//用户是否登录超时检查
function checkLoginState($type = 0){
	$rspString = getResponse( 'login_state_xml', "show" , $param, $demo_link='page_frame_timeout' );
	$state = $rspString[login_state_xml][group][state];
	if($type == 1)
		return $state;
	else{
		if($state == 0){
			header('Location:/logout.php');
			return;
		}
	}
}
/*日志数据表后缀日期
	format:0,当天，1当月
*/
function get_Current_Format_Date($format = 0){
	$rspString = getResponse( 'time_config', "show" , $param);
	$time = getAssign($rspString);
	if($format == 1)
		return date('Ym',strtotime($time['sys_clock']));
	return date('Ymd',strtotime($time['sys_clock']));
}
function get_Query_Date($select_date,$range = 0,$format = 0){
	$current_date = ($select_date) ? $select_date: get_Current_Format_Date();
	if($format == 1)
		return date('Y-m-d',strtotime(''.$range.' day',strtotime($current_date))). ' 23:59';
	else
		return date('Ymd',strtotime(''.$range.' day',strtotime($current_date)));
}
function get_vrf(){
	$rspString = getResponse( 'vrf', "show" );

	$interface_sub_retParam = getAssign($rspString,'vrf');
	$interface_sub_Options = '';
	if (count($interface_sub_retParam) == count($interface_sub_retParam, 1)){
		$interface_sub_Options .='<option value="'.$interface_sub_retParam["vrf_name"].'">'.$interface_sub_retParam["vrf_name"].'</option>';
	}
	else{
		foreach($interface_sub_retParam as $key=>$value){
			$interface_sub_Options .='<option value="'.$value["vrf_name"].'">'.$value["vrf_name"].'</option>';
		}
	}
	return $interface_sub_Options;
}
function get_vrf_interface($vrf){
	$param['vrf_name']=$vrf;
	$rspString = getResponse( "vrf", "showindex" , $param, $get_url_param );
	$sys_vrf_list_arr = getAssign($rspString,"vrf",$json=true, $list=true);
	$code = '';
	foreach($sys_vrf_list_arr as $key=>$value){
		if($value["vrf_name"])
			$code .='<option value="'.$value["name"].'">'.$value["name"].'('.$value["vrf_name"].')</option>';
		else
			$code .='<option value="'.$value["name"].'">'.$value["name"].'</option>';
	}
	echo $code;
}

function lang_var($var) {
	global $language_array;
	global $language_define;

	$tpldir = TPLDIR;
	include_once language('templates', 0, $tpldir, sys_get_language());

    if(isset($GLOBALS['language_array'][$var])) {
        return $GLOBALS['language_array'][$var];
    } else {
        return "!$var!";
    }
}

function get_time_range($type) {
	$date = array();
	$cur = time();
	switch ($type) {
		case 'cur_month':
			$date['start_time'] = strtotime(date('Y-m', $cur) . "-1 00:00:00");
			break;
		case 'cur_week':
			$date['start_time'] = strtotime("-1 monday");
			break;
		case 'cur_day':
			$date['start_time'] = strtotime(date('Y-m-d', $cur) . " 00:00:00");
			break;
		case 'one_day':
			$date['start_time'] = strtotime(date("Y-m-d H:i:s", strtotime("-1 day")));
			break;
		case 'one_week':
			$date['start_time'] = strtotime(date("Y-m-d", strtotime("-7 days")));
			break;
		case 'one_month':
			$date['start_time'] = strtotime(date("Y-m-d", strtotime("-30 days")));
			break;
		case 'three_month':
			$date['start_time'] = strtotime(date("Y-m-d", strtotime("-90 days")));
			break;
	}

	$date['start_time'] = date("Y-m-d H:i:s", $date['start_time']);
	$date['end_time'] = date("Y-m-d H:i:s", $cur);
	// var_dump($date);die;

	return $date;
}

function set_upload_file($path, $msg='') {
	/*if (empty($path)) {
		return false;
	}*/

	$path_arr = explode('.', $path);
	if (!empty($path_arr) && in_array($path_arr[1], EXCLUDE_ARRAY)){
		return false;
	}

	file_put_contents($path, $msg);
	return true;
}

function delete_upload_file($path) {
	if (empty($path)) {
		return false;
	}

	$path_arr = explode('.', $path);
	if (!empty($path_arr) && in_array($path_arr[1], EXCLUDE_ARRAY)){
		return false;
	}

	if (file_exists($path)) {
		unlink($path);
	}
	return true;
}

function clean_file($path, $compare) {
	if (empty($path)) {
		return false;
	}

	if (!file_exists($path)) {
		return false;
	}

	$contents = file_get_contents($path);

	if ($contents && ($contents <= $compare)) {
		return true;
	}
}

function ftp_send_pdf($file_path,$is_del='false') {
	/*shell脚本修改，需获取报表具体名称，方便数据打包*/
	$filearr = explode('/', $file_path);
	$file_path = $filearr[count($filearr)-1];
	$path = '/mnt/boot/ftp.json';
	if (!file_exists($path)) {
		return false;
	}

	$json = file_get_contents($path);

	if (!empty($json)){
		$data = json_decode($json, true);
	}

	$tar_name = date('YmdHis', time()) . '.tar.gz';

	$shell = "/bin/bash /usr/local/wwwroot/common/lftp_bash.sh upload ".$data['ftp_user']." ".$data['ftp_passwd']." ".$data['ftp_server']." ".$data['ftp_port']." ".$file_path." ".$is_del." ".$tar_name;
	$ret = shell_exec($shell);
	return $ret;
}

function email_send_pdf($receiver, $filename,$is_del='0') {
	$module = 'sys_report_smtp_send';
	$last_num = strrpos($filename, '/');

	$info = array(
		'del_file' => $is_del,
		'receivers' => implode(";", $receiver),
		'file_name' => substr($filename, $last_num+1, strlen($filename)),
		'file_path' => substr($filename, 0, $last_num+1)
	);

	$ret = getResponse($module, 'add', $info);
	return getAssign($ret, $module);
}
/**
 * 后台发送邮件线程处理，前端无法获取发送成功或失败状态，因此请求接口del动作
 */
function check_email_send_pdf($receiver, $filename) {
	$module = 'sys_report_smtp_send';
	$last_num = strrpos($filename, '/');

	$info = array(
		'del_file' => '0',
		'receivers' => implode(";", $receiver),
		'file_name' => substr($filename, $last_num+1, strlen($filename)),
		'file_path' => substr($filename, 0, $last_num+1)
	);

	$ret = getResponse($module, 'del', $info);
	return getAssign($ret, $module);
}
/**
 * 报表添加缓存数据方法
 */
function report_add($name) {
	$path = '/mnt/boot/report_file.json';
	$data = array();

	if(empty($name) || !$name) {
		return;
	}
	if (file_exists($path)) {
		$json = file_get_contents($path);
		if ($json) {
			$data = json_decode($json, true);
		}
	}

	if ($key = array_search($name, $data)) {
		unset($data[$key]);
	}
	array_unshift($data, $name);
	@file_put_contents($path, json_encode($data));
}
/**
 * 获取当前设备主备状态
 */
function get_ha_status() {

	//var_dump($json);
	$mode = "1";
	$file_path = "/tmp/ha_stats";
	if(file_exists($file_path)){
		$str = file_get_contents($file_path);//将整个文件内容读入到一个字符串中
		$replace_str = str_replace(PHP_EOL, ';', $str);
		echo $replace_str;

		$ha_arr = explode(";",$replace_str);
		foreach ($ha_arr as $ha_value) {
			if(strstr($ha_value, 'workmode')){
				$workmodearr = explode("=",$ha_value);
				$workmode = $workmodearr[1];
			}
			if(strstr($ha_value, 'state')){
				$statearr = explode("=",$ha_value);
				$state = $statearr[1];
			}
		}
		$mode ="0";
		if($workmode=="0"){
			$mode ="1";
		}
		if($workmode=="1" && $state=="1"){
			$mode ="1";
		}
		if($workmode=="2" && $state=="6"){
			$mode ="1";
		}
		if($workmode=="2" && $state=="1"){
			$mode ="1";
		}
	}

	return $mode;
}

/**
 * 用于切割上传文件转换字符串头部信息方法
 */
function file_head_split(&$file_str) {
	$stra = substr($file_str, 0, 200);
	$strb = substr($file_str, 200, strlen($file_str));

	$cstra = preg_replace('/data:.*;base64,/i', '', $stra);

	$file_str = $cstra . $strb;
}

function sso_aes_decrypt($data, $key, $iv='', $crypttype) {
	$encryptedData=base64_decode($data);

	$decrypted=openssl_decrypt($encryptedData, $crypttype, $key, OPENSSL_RAW_DATA|OPENSSL_ZERO_PADDING, $iv);
	$result = rtrim($decrypted);
	return $result;
}

function check_user_permission() {

    $stat_array = array('user-monitor', 'app-monitor-trend', 'device-pref', 'device-connect', 'cpu-stat', 'memory-stat', 'device-connect', 'ips-sip', 'ips-dip', 'ips-event', 'ips-map', 'ips-list', 'av-sip', 'av-dip', 'av-event', 'apt-result', 'apt-type', 'apt-list', 'user-group', 'online-user', 'interface-monitor', 'session-stat', 'session-scout', 'service', 'service-group', 'service-predefined', 'flow-stat-policy', 'flow-stat-table', 'health-stat', 'health-check');

    $log_array = array('sys-log', 'audit-log', 'audit-timeline');

    $update_array = array('manual-update');

    $syslog_type_list = array(1,2,3,4, 'ips', 'av');

    $is_power = $_SESSION[PERMISSION]['separation_of_powers'];

    if ($is_power == 1) {
        $current_path = substr($_SERVER[PATH_INFO], 1, strlen($_SERVER[PATH_INFO]));

        if (in_array($current_path, $stat_array)) {
            return get_permission('CATEG_STATISTICS');
        }
        $get_data = get_inputs();
        if (in_array($current_path, $log_array) && in_array($get_data['type'], $syslog_type_list)) {
            // var_dump(get_permission('CATEG_SYSLOG'));die;
            return get_permission('CATEG_SYSLOG');
        }
        if ($current_path == 'sys-log' && $get_data['type'] == '5') {
            return get_permission('CATEG_AUDIT');
        }
    }
    return true;
}

function monitor_auditlog_table($database, $module) {
    $union_sql = '';
    $cur = time();
    for($i=0;$i<3;$i++) {
        $time = $cur - 86400 * $i;
        $day = strftime("%Y%m%d", $time);
        $table = $module. '_' . $day;
        $exists = $database->query("SELECT table_name FROM information_schema.TABLES WHERE table_name ='".$table."'")->fetchAll();

        if (!empty($exists)) {
            if ($union_sql){
                $union_sql .= " union all select * from ".$table;
            } else {
                $union_sql = 'select * from '.$table;
            }
        }
    }
    return $union_sql;
}

function auditlog_field_sql($param) {
    $find_sql = '';
    if (!empty($param)) {
        foreach ($param as $key => $value) {
            if ($find_sql) {
                $find_sql .= ' and ';
            } else {
                $find_sql .= 'where ';
            }
            $find_sql .= $key.'=\''.$value.'\'';
        }
    }
    return $find_sql;
}
?>
