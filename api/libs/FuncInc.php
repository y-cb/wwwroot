<?php
namespace lib;
class FunInc{
	/*
	*get language from system.conf
	*/
	function initSystem(){
		$fp = fopen('/tmp/webui/lang.conf', 'r');
		$reg_msg = fread( $fp, filesize('/tmp/webui/lang.conf'));
		fclose($fp);

		if( strstr( $reg_msg, "1" ) ){
			$GLOBALS['language_id']	= 1;
			$GLOBALS['language_define']	= "en";
			$GLOBALS['language_cmd'] = 'EN';
			$GLOBALS['language_reporter']	= "en_US";
		}
		else{
			$GLOBALS['language_id']	= 2;
			$GLOBALS['language_define']	= "cn";
			$GLOBALS['language_cmd'] = 'CN';
			$GLOBALS['language_reporter']	= "zh_CN";
		}
		return $GLOBALS;
	}
	function endSystem($url=""){
		global $starttime,$DEBUG_ALL;
		
		$mtime = explode(' ', microtime());
		$endtime = $mtime[1] + $mtime[0];
		if($url)	$_SESSION['url']=$url;
		if($DEBUG_ALL)
			echo "Cost Time:".($endtime-$starttime)."s</div>";
	}
	/*
	*chcek module auth
	*/
	function destroy_session(){
		$_SESSION['username'] = "";
		$_SESSION['sessionid'] = "";
	}
	function formatpost( $post, $type = null){
		if($trim)		$post = str_replace(" ","",$post);
		$post = str_replace("--Null--","",$post);
		$post =  preg_replace("/<script.*>.*<\/script>/isU", "", $post);
		if( is_array($post) )		return $post;
		switch($type){
			case 'json':
				return $array = json_decode(trim(stripslashes(htmlspecialchars_decode($post))));
			break;
		}
		if(strstr($post,'\\'))
			return trim( ( htmlspecialchars ( $post ) ) );
		else
			return trim( stripslashes( htmlspecialchars ( $post ) ) );
	}
	function formatget( $name , $trim = 1, $type = null){
		if($trim)		$name = str_replace(" ","",$name);
		if(strstr($name,'\\'))
			return trim( ( htmlspecialchars ( $name ) ) );
		else
			return trim( stripslashes( htmlspecialchars ( $name ) ) );
	}

	/**
	 * assigns values to template variables
	 *
	 * @param array|string $tpl_var the template variable name(s)
	 * @param mixed $value the value to assign
	 */
	function language( $file, $templateid = 0, $langdir = '', $language = DEFAULT_LANGUAGE ) {
		$languagepack = S_ROOT.'./'.$langdir.'/'.$file.'.'.$language.'.lang';
		return ( @file_exists($languagepack) )?$languagepack:false;
	}
	function template( $file,  $templateid = 0,  $tpldir = '') {
		global $language_id;
		$tpldir = $tpldir ? $tpldir : TPLDIR;
		$templateid = $templateid ? $templateid : $language_id;

		$tplfile = S_ROOT.'./'.$tpldir.'/'.$file.'.html';
		$objfile = S_ROOT.'./cachedata/templates/'.$templateid.'_'.$file.'.tpl';

		if( $language_id != 1 && $templateid != 1 && !file_exists($tplfile) ) {
			return template( $file, 1, './templates/default/' );
		}
		if( file_exists( $objfile ) == 0 || @filemtime( $tplfile ) > @filemtime( $objfile ) ) {
			require_once S_ROOT.'./include/template.inc';
			parse_template($file, $templateid, $tpldir);
		}
		return $objfile;
	}
	function ajaxOptions( $array, $default = "", $json = false, $symbol = "" ){
		if($json){
			for($i=0,$l=sizeof($array);$i<$l;$i++){
				$result = array_diff(array_merge($array[$i],$key),$array[$i]);
				if(sizeof($result)==0){
					$array[$i]['selected'] = true;
					break;
				}
			}
			if($default){
				$ret[0]['id'] = 0;
				$ret[0]['name'] = $default;
				$ret[0]['children'] = $array;
				return json_encode($ret);
			}
			return json_encode($array);
		}
		if( $default ) echo "<option value='".$symbol."'>".$default."</option>";
			
		if($array['name']&&!$array[0])
			return $optionCode .= "<option value='".$array['name']."'>".$array['name']."</option>";

		else
		{
			for($i=0,$l=sizeof($array);$i<$l;$i++){
				$optionCode .= "<option value='".$symbol.$array[$i][name]."'";
				$optionCode .= ( $key == $array[$i][name] )?"selected":"";
				$optionCode .= ">".$array[$i][name]."</option>";
			}
		}
		return $optionCode;
	}
	function ajaxUserOptions( $array, $default = "", $json = false, $symbol = "" ){
		if($json){
			for($i=0,$l=sizeof($array);$i<$l;$i++){
				$result = array_diff(array_merge($array[$i],$key),$array[$i]);
				if(sizeof($result)==0){
					$array[$i]['selected'] = true;
					break;
				}
			}
			if($default){
				$ret[0]['id'] = 0;
				$ret[0]['name'] = $default;
				$ret[0]['children'] = $array;
				return json_encode($ret);
			}
			return json_encode($array);
		}
		if( $default ) echo "<option value='".$symbol."'>".$default."</option>";
			
		if($array['name']&&!$array[0])
			return $optionCode .= "<option value='".$array['name']."'>".$array['name']."</option>";

		else
		{
			for($i=0,$l=sizeof($array);$i<$l;$i++){
				$optionCode .= "<option value='".$symbol.$array[$i][name]."'";
				$optionCode .= ( $key == $array[$i][name] )?"selected":"";
				$optionCode .= ">".$array[$i][name]."</option>";
			}
		}
		return $optionCode;
	}
	function get_jsondata($data){
		//$root = get_array_el( explode(">",$_GET[json]), 0);
		//$root_1 = get_array_el( explode(">",$_GET[json]), 1);
		if ($root == null)
			return json_encode($data);
		return ($root_1)?json_encode($data[$root][$root_1]):json_encode($data[$root]);
	}

	/**
	 * assigns values to template variables
	 *
	 * @param array|string $tpl_var the template variable name(s)
	 * @param mixed $value the value to assign
	 */
	function showError( $message, $alert = 0 ){
		if($DEBUG_SWITCH)
			echo debugWindow( "<div  class='debug_msg'><h1>Send Message</h1>".htmlspecialchars($sendMsg)."<br><h1>Response Message</h1>".htmlspecialchars($reg_msg)."</div>");
		
		if($message==null)
			return $messgae = "\"系统错误,无返回消息\"";
		
		if($alert)
			echo "<script>alert('$message')</script>";
		return json_encode($message);
	}
	function showSuccess( $url, $message = "",$par = '' ){
		global $DEBUG_SWITCH;
		$successMsg = "success";
		if($DEBUG_SWITCH)
		{
			include template('header');

			echo '<script>$("#debugMsg").append("<a href=\'?g='.$url.'&time='.time().'&successMsg=success\'>Go Next Link>>></a>")</script>';
			exit;
		}
		echo "<script>window.location='?g=$url&".$par."&time=".time()."&successMsg=success'</script>";
	}
	function pageGoUrl( $url, $message = "" ){
		echo "<script>window.location='?g=$url'</script>";
	}


	/*
	*ultility
	*2012/9/20 15:57
	*/
	function get_array_el($array, $val){
		return (is_array($array))?$array[$val]:$array;
	}
	function h_addslashes($string, $force = 0) {
		if(!$GLOBALS['magic_quotes_gpc'] || $force) {
			if(is_array($string)) {
				foreach($string as $key => $val) {
					$string[$key] = h_addslashes($val, $force);
				}
			} else {
				$string = addslashes($string);
			}
		}
		return $string;
	}
	function formatReToArr($arr){
		if(!$arr[0])
		{
			$retarr[0] = $arr;
		}
		else
			$retarr= $arr;
		return $retarr;
	}
	function sys_array_plus($a,$b){
		
	}
	function xmlToArray($n)
	{
		$xml_array = array();
		$occurance = array();
		 foreach($n->childNodes as $nc)
		 {
			 $occurance[$nc->nodeName]++;
		 }
		
		foreach($n->childNodes as $nc){
			if( $nc->hasChildNodes() )
			{
				if($occurance[$nc->nodeName] > 1)
				{
					$xml_array[$nc->nodeName][] = xmlToArray($nc);
				}
				else
				{
					$xml_array[$nc->nodeName] = xmlToArray($nc);
				}
			}
			else
			{
				if($nc->nodeValue == null)
					$xml_array[$nc->nodeName] = "";
				else
					return $nc->nodeValue;
			}
		}
		return $xml_array;
	}
	function formatArr($arr){
		if($arr[child]){
			$r_arr = $arr[child];
		}
		else
			$r_arr = $arr;
		return $r_arr;
	}
	function domXmlToArr($xmlStr){
		$xml= new DOMDocument();
		$xml->preserveWhiteSpace=false;
		if($xmlStr)	$xml->loadXML($xmlStr);	
		return xmlToArray($xml); 
	}
	function transAttrXml2DomXml($xmlStr){	
		require_once("./libs/XmlParser.class.php");
		$xml = new XmlParser();
		$xml->parseData($xmlStr);
		$tree = $xml->getTree();
		$array = $tree[0];
		$tmp_arr = array();
		formatArr($array);
		foreach($array[child] as $i => $item){
			$arr[strtolower($item[name])] = $item[attrs];
			$tmp_arr[] = $arr;
		}
		$retarray[strtolower($array[name])] = $tmp_arr;
		return $array;
	}
	function arr2DomXml($array) {  
		if(is_object($array)) {  
			$array = get_object_vars($array);  
		}  
		$xml = null;
		if($array)
		foreach($array as $k=>$v) {
			is_numeric($k) && $k="group id='{$k}'";  
			$xml.= "<{$k}>";  
			//$xml.= (is_array($v)||is_object($v)) ? arr2DomXml($v) : ((strlen($v)>0 && isSpecialChar($v)) ? "<!--[CDATA[{$v}]]-->" : $v); 
			$xml.= (is_array($v)||is_object($v)) ? arr2DomXml($v) : ((strlen($v)>0 && isSpecialChar($v)) ? htmlspecialchars($v) : $v); 
			
			list($k,) = explode(' ',$k);  
			$xml.= "</{$k}>\n"; 
		}
		return $xml; 
	}
	function isSpecialChar($array, $key="',\",>,<,\n"){  
		$keyArr = explode(',',$key);  
		foreach ($keyArr as $v){  
			if ( strpos($array,$v)!==false){  
				return true;  
			}  
		}  
		return false;  
	} 
	function getJsonArrName($json){
		$array = (array)json_decode($json);
		for($i=0,$l=sizeof($array);$i<$l;$i++){
			$name .= $array[$i]->attrs->NAME;	
			$name .= ($i==($l-1))?"":",";	
		}
		return $name;
	}
	function getClientBrowse(){
		$agent = $_SERVER["HTTP_USER_AGENT"];
		if(strpos($agent,"MSIE 9.0"))
			return "IE9.0";
		else if(strpos($agent,"MSIE 8.0"))
			return "IE8.0";
		else if(strpos($agent,"MSIE 10.0"))
			return "IE10.0";
		else if(strpos($agent,"MSIE 7.0"))
			return "IE7.0";
		else if(strpos($agent,"MSIE 6.0"))
			return "IE6.0";
		else if(strpos($agent,"Firefox/3"))
			return "Firefox 3";
		else if(strpos($agent,"Firefox/2"))
			return "Firefox 2";
		else if(strpos($agent,"Chrome"))
			return "Google Chrome";
		else if(strpos($agent,"Safari"))
			return "Safari";
		else if(strpos($agent,"Opera"))
			return "Opera";
		else{ 
			preg_match("/Trident\/7/i", $_SERVER["HTTP_USER_AGENT"],$ua);
			if($ua)
					return "IE11.0";
			else
				return $agent;
		}
	}
	/*
	*debug
	*2008/11/28 15:57
	*/
	function debug( $request_msg_ret ){
			print "<div class='debug_msg'>".$request_msg_ret."</div>";

	}
	function print_array( $array ){
		if( is_array( $array ) ){
			print "<div  class='debug_msg'><h2>Array Content</h2><pre>";print_r($array);print "</pre></div>";
		}
	}
	function php_log($msg){
		$logfile = dirname(__FILE__) . "/log/php.log";
		clearstatcache();
		@ $size = filesize($logfile);
		if ($size > 512 * 1024) {
			unlink($logfile);
		}
		file_put_contents($logfile, $msg . "\n", FILE_APPEND);
	}
	function debugMode($checkStr){
		global $DEBUG_MODE;
		if( $DEBUG_MODE == 1 )
			return 1;

		if($checkStr==md5("debug=1")||$checkStr==123456789){
			$_SESSION['debug'] = 1;
			return 0;
		}
		else if($checkStr==987654321){
			$_SESSION['debug'] = 0;
			return 0;
		}
		else{
			if($_SESSION['debug'])
				return 1;

			if($checkStr && $DEBUG_MODE==1 )
				return $checkStr;

			return 0;
		}
	}
	function debugWindow($message){
		return '	<div id="w" class="easyui-window" data-options="title:\'Debug Window\',iconCls:\'icon-save\'" style="width:660px;height:400px;padding:5px;">		<div class="easyui-layout" data-options="fit:true">			<div data-options="region:\'center\',border:false" style="padding:10px;background:#fff;border:1px solid #ccc;overflow:auto;">	'.$message.'		<span id="debugMsg"></span></div>		</div>	</div>';
	}

	function sysSortArray($ArrayData, $KeyName1, $SortOrder1 = "SORT_ASC", $SortType1 = "SORT_REGULAR")
	{
		if (!is_array($ArrayData))
		{
			return $ArrayData;
		}
		// Get args number.
		$ArgCount = func_num_args();
		// Get keys to sort by and put them to SortRule array.
		for ($I = 1; $I < $ArgCount; $I++)
		{
			$Arg = func_get_arg($I);
			if (!eregi("SORT", $Arg))
			{
				$KeyNameList[] = $Arg;
				$SortRule[] = '$' . $Arg;
			}
			else
			{
				$SortRule[] = $Arg;
			}
		}
		// Get the values according to the keys and put them to array.
		foreach ($ArrayData as $Key => $Info)
		{
			foreach ($KeyNameList as $KeyName)
			{
				${$KeyName}[$Key] = $Info[$KeyName];
			}
		}
		
		//	var_dump($ArrayData);
		

		// Create the eval string and eval it.
		$EvalString = 'array_multisort(' . join(",", $SortRule) . ',$ArrayData);';
		eval($EvalString);
		return $ArrayData;
	}
	function php_htmlspecialchars($str){
		$str = preg_replace('/\+/i', '%2B',$str);
		return $str;  
	}
	function php_htmlspecialchars_decode($str){
		$str = preg_replace('/%2B/i', '+',$str);
		return $str;  
	}

	function get_oem_str()
	{
		return file_get_contents("/etc/oem_id");
	}

	function is_disk_exist()
	{
		if(file_exists('/mnt1/mysql/')) {
			return true;
		}
		return false;
	}

	function ecd_int_get($name)
	{
		$module = 'ecd_item';
		$param['name'] = $name;
		$rspString = getResponse($module, "show" , $param, $get_url_param);
		$retparam = getAssign($rspString, $module, $json_el=true, $list=false);
		return (int)$retparam['value'];
	}

	function ecd_int_set($name, $value)
	{	
		$module = 'ecd_item';
		$param['name'] = $name;
		$param['value'] = $value;
		$rspString = getResponse($module, "mod" , $param, $get_url_param);
		return 0;
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
			curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环  
			curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容  
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回  
			$tmpInfo = curl_exec($curl); // 执行操作  
			curl_close($curl); // 关闭CURL会话  
			return $tmpInfo; // 返回数据  
	}
}

?>
