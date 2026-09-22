<?php
namespace controller\policy;
use controller\mController;
use lib\WriteLog;

/**
 * @api {GET}  /api/ips-rule 获取入侵防护策略
 * @apiName ips-rule
 * @apiGroup 获取防护策略
 *
 *
 * @apiSuccess {String} name 策略名称
 * @apiSuccess {String} src_zone 入接口
 * @apiSuccess {String} dst_zone 出接口
 * @apiSuccess {String} src 源地址
 * @apiSuccess {String} dst 目的地址
 * @apiSuccess {String} set 事件集
 * @apiSuccess {Number} id 策略ID
 * @apiSuccess {Number} enable 启用状态
 * @apiSuccess {Number} log 是否记录日志
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"name": "test",
 *			"src_zone": "any",
 *			"dst_zone": "any",
 *			"src": "any",
 *			"dst": "any",
 *			"set": "All",
 *			"id": "1",
 *			"enable": "1",
 *			"log": "1"
 *		},
 *		{
 *			"name": "test1",
 *			"src_zone": "any",
 *			"dst_zone": "ge0/0",
 *			"src": "any",
 *			"dst": "any",
 *			"set": "All",
 *			"id": "2",
 *			"enable": "1",
 *			"log": "1"
 *		}
 *	],
 *	"total": 2
 *	}
 */

/**
 * @api {POST}  /api/ips-rule 添加入侵防护策略
 * @apiName ips-rule
 * @apiGroup 添加防护策略
 *
 *
 * @apiParam {String} name 策略名称
 * @apiParam {String} src_zone 入接口
 * @apiParam {String} dst_zone 出接口
 * @apiParam {String} src 源地址
 * @apiParam {String} dst 目的地址
 * @apiParam {String} set 事件集
 * @apiParam {Number} id 策略ID
 * @apiParam {Number} refer_id 移动参考目标策略id
 * @apiParam {Number} enable 启用状态
 * @apiParam {Number} log 是否记录日志
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "test",
 *		"src_zone": "any",
 *		"dst_zone": "any",
 *		"src": "any",
 *		"dst": "any",
 *		"set": "All",
 *		"id": "1",
 *		"refer_id": "0",
 *		"enable": "1",
 *		"log": "1"
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"code":"0"
 *	}
 *
 * @apiErrorExample {json} Error-Response:
 *	HTTP/1.1 422 Not Found
 *	{
 *		"code":"非0",
 *		"str":""
 *	}
 *
 */

/**
 * @api {PUT}  /api/ips-rule 修改入侵防护策略
 * @apiName ips-rule
 * @apiGroup 修改防护策略
 *
 *
 * @apiParam {String} name 策略名称
 * @apiParam {String} src_zone 入接口
 * @apiParam {String} dst_zone 出接口
 * @apiParam {String} src 源地址
 * @apiParam {String} dst 目的地址
 * @apiParam {String} set 事件集
 * @apiParam {Number} id 策略ID
 * @apiParam {Number} refer_id 引用计数，固定为0
 * @apiParam {Number} enable 启用状态
 * @apiParam {Number} log 是否记录日志
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "test",
 *		"src_zone": "any",
 *		"dst_zone": "any",
 *		"src": "any",
 *		"dst": "any",
 *		"set": "Common",
 *		"id": "1",
 *		"refer_id": "0",
 *		"enable": "1",
 *		"log": "1"
 *	}
 *
 * @apiParam {String} name 策略名称
 * @apiParam {String} src_zone 入接口
 * @apiParam {String} dst_zone 出接口
 * @apiParam {String} src 源地址
 * @apiParam {String} dst 目的地址
 * @apiParam {String} set 事件集
 * @apiParam {Number} id 策略ID
 * @apiParam {Number} refer_id 引用计数，固定为0
 * @apiParam {Number} move_type 策略移动类型
 * @apiParam {Number} enable 启用状态
 * @apiParam {Number} log 是否记录日志
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "test",
 *		"src_zone": "any",
 *		"dst_zone": "any",
 *		"src": "any",
 *		"dst": "any",
 *		"set": "Common",
 *		"id": "1",
 *		"refer_id": "1",
 *		"move_type": "3",
 *		"enable": "1",
 *		"log": "1"
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"code":"0"
 *	}
 *
 * @apiErrorExample {json} Error-Response:
 *	HTTP/1.1 422 Not Found
 *	{
 *		"code":"非0",
 *		"str":""
 *	}
 *
 */

/**
 * @api {DELETE}  /api/ips-rule 删除入侵防护策略
 * @apiName ips-rule
 * @apiGroup 删除防护策略
 *
 *
 * @apiParam {Number} id 策略id
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"id": "1"
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"code":"0"
 *	}
 *
 * @apiErrorExample {json} Error-Response:
 *	HTTP/1.1 422 Not Found
 *	{
 *		"code":"非0",
 *		"str":""
 *	}
 *
 */


class WeakPwdImportController extends mController{
	public $source = '/mnt/boot/weakpwdscan.json';
	public $in_file = '/tmp/weakpwdscan_in.json';
	public $out_file = '/tmp/weakpwdscan.json';
	public $crondir = '/mnt/boot/weakcron/';
	public $crontab_file = '/tmp/cron/crontabs/root';

	function get(){
		$param = get_inputs();
		$all_json = file_get_contents($this->source);
		$all_json_arr = json_decode($all_json,true);
		$json_type['weakpwd_scan'] = $all_json_arr;
		$json = json_encode($json_type,JSON_UNESCAPED_UNICODE);
		file_put_contents($this->out_file, $json);

		if( !file_exists($this->out_file) || $json_type['weakpwd_scan']==NUll){
			$ret = array('code'=>'-8888','str'=>t('policy.out_null'));
			echo json_encode($ret);
			return;

		}else{
			
			if ($param['log']!=false) {
				$msg='SrcIP='.$_SERVER["REMOTE_ADDR"].' UserName='.$_SESSION[CONNECTION.USERNAME].' Operate="export weakpassword scan configuration" ManageStyle=web Content="operation success"';
				WriteLog::ConfigWrite($msg);				
			}


			
			$readBuffer = 1024;

		
			header('Content-Type: application/octet-stream');
			//声明浏览器返回大小是按字节进行计算
			header('Accept-Ranges:bytes');
			//告诉浏览器文件的总大小
			$fileSize = filesize($this->out_file);//坑 filesize 如果超过2G 低版本php会返回负数
			header('Content-Length:' . $fileSize); //注意是'Content-Length:' 非Accept-Length
			//声明下载文件的名称
			header('Content-Disposition:attachment;filename= weakpwdscan_out.txt');//声明作为附件处理和下载后文件的名称
			//获取文件内容
			$handle = fopen($this->out_file, 'rb');//二进制文件用‘rb’模式读取
			while (!feof($handle) ) { //循环到文件末尾 规定每次读取（向浏览器输出为$readBuffer设置的字节数）
				echo fread($handle, $readBuffer);
			}
			fclose($handle);//关闭文件句柄
			// $rspString = getResponse($this->module, "show_one" ,$params);
			exit;
		}
		
	}

	function post(){
		$updatefile = $_FILES['file'];
		//var_dump($updatefile);

		if (0 == $updatefile['size']) {
			$ret = array('code'=>'-1','str'=>t('update.file_empty'));
			echo json_encode($ret);
			exit(0);
		} else {
			if (UPLOAD_ERR_OK == $updatefile['error']) {
				$tmp_dir = $updatefile['tmp_name'];
				// var_dump($tmp_dir);die;
				// $dirs = explode('/', $tmp_dir);
				$dir = $this->in_file;

				move_uploaded_file($updatefile['tmp_name'], $dir);


				/*if (file_exists($this->in_file)) {
					$str = file_get_contents($this->in_file);
					$in_file_arr = json_decode($str,true);
				}*/
				 if (!file_exists($this->in_file)) {
					$ret = array('code'=>'-1','str'=>t('update.file_empty'));
					echo json_encode($ret);
					exit(0);
				}else{
					$str = file_get_contents($this->in_file);
					$in_file_arrall = json_decode($str,true);
					$in_file_arr = $in_file_arrall['weakpwd_scan'];
					if($in_file_arr==NUll){

						$ret = array('code'=>'-7771','str'=>t('policy.input_file_error'));
						echo json_encode($ret);
						exit(0);
					}elseif (count($in_file_arr)>32) {
						$ret = array('code'=>'-7772','str'=>t('policy.input_file_count_error'));
						echo json_encode($ret);
						exit(0);
					}else{
						//调用函数，并更新配置文件
						self::save_json($in_file_arr);
						$msg='SrcIP='.$_SERVER["REMOTE_ADDR"].' UserName='.$_SESSION[CONNECTION.USERNAME].' Operate="import weakpassword scan configuration" ManageStyle=web Content="operation success"';
						WriteLog::ConfigWrite($msg);
					}
				}
				


			}else{
				$ret = array('code'=>'-50000','str'=>t('update.update_error_50000'));
				echo json_encode($ret);
			}

			
			// echo "ok";

		}
		
	}

	function check_item($itemvalue){
		$wstatus = 0;
		$preg_v4 = '/^((25[0-5]|(2[0-4]\d)|(1\d{2})|([1-9]\d)|(\d))\.){3}(25[0-4]|(2[0-4]\d)|(1\d{2})|([1-9]\d)|(\d))$/';
		$preg_v6 = '/^([a-f0-9]{1,4}(:[a-f0-9]{1,4}){7}|[a-f0-9]{1,4}(:[a-f0-9]{1,4}){0,7}::[a-f0-9]{0,4}(:[a-f0-9]{1,4}){0,7})$/';

		
		if(isset($itemvalue['ip_host'])){
			$ip_infor = $itemvalue['ip_host'];
			if (preg_match($preg_v4, $ip_infor, $ipstr)) {
				$ip_earr = explode(".",$ip_infor);
				//print_r($ip_earr);
				if($ip_earr[3] < 255){
					$wstatus = 0;
				}else{
					$wstatus = 1;
					return $wstatus; //只要是1 就有错
				}
			}else{
				$wstatus = 1;
				return $wstatus;
			}

		}
		elseif(isset($itemvalue['ip_range1']) && isset($itemvalue['ip_range2'])){


			$ip_infor1 = $itemvalue['ip_range1'];
			$ip_infor2 = $itemvalue['ip_range2'];
			if (preg_match($preg_v4, $ip_infor1, $ipstr) && preg_match($preg_v4, $ip_infor2, $ipstr)) {
				$ip_earr1 = explode(".",$ip_infor1);
				$ip_earr2 = explode(".",$ip_infor2);
				if($ip_earr1[3] < 255 && $ip_earr2[3] < 255){
					$wstatus = 0;
				}else{
					$wstatus = 1;
					return $wstatus;
				}
			}else{
				$wstatus = 1;
				return $wstatus;
			}

			$ip_min = $ip_infor1;
			$ip_max = $ip_infor2;
			$count = ip2long($ip_max) - ip2long($ip_min) + 1;
			if($count>100){
				$wstatus = 1;
				return $wstatus;
			}else{
				$wstatus = 0;
			}


		}
		elseif(isset($itemvalue['host_v6'])){
			$ip_infor = $itemvalue['host_v6'];
			if (preg_match($preg_v6, $ip_infor, $ipstr)) {
				$wstatus = 0;
			}else{
				$wstatus = 1;
				return $wstatus;
			}
		}
		elseif(isset($itemvalue['range6_min']) && isset($itemvalue['range6_max'])){
			$ip_infor1 = $itemvalue['range6_min'];
			$ip_infor2 = $itemvalue['range6_max'];
			if (preg_match($preg_v6, $ip_infor1, $ipstr) &&  preg_match($preg_v6, $ip_infor2, $ipstr)) {
				$wstatus = 0;
			}else{
				$wstatus = 1;
				return $wstatus;
			}

			$stripv6_min = self::ip2long_v6($ip_infor1);
			$stripv6_max = self::ip2long_v6($ip_infor2);

			$array_calcu = self::calcu_v6range($stripv6_min ,$stripv6_max);

			$count = $array_calcu[0] + $array_calcu[1]*10 + $array_calcu[2]*100 + $array_calcu[3]*1000;
			for($i=4;$i<count($array_calcu);$i++){
				if($array_calcu[$i]>0){
					$count = 10000;//大于10000赋值10000
					break;
				}
			}
			if($count>100){
				$wstatus = 1;
				return $wstatus;
			}else{
				$wstatus = 0;
			}
		}else{
			$wstatus = 1;
			return $wstatus;
		}
		return $wstatus;
	}

	function check_jarrayone($arrone){

		$matchnamestr = "/^[\u{4e00}-\u{9fa5}a-zA-Z0-9@。._\-\|\(\)\[\]]*$/";
		$matchdescstr = "/^[\u{4e00}-\u{9fa5}a-zA-Z0-9@。._\-\|\(\)\[\]\s\/]*$/";
		$serve = ['ftp:21','ssh:22','telnet:23','smtp:25','rlogin:513','imap:143','pop3:110','mssql:1433','mysql:3306','postgresql:5432','vnc:5900'];

		if($arrone['name']==NUll || $arrone['scan_time']==NUll || $arrone['normal_port']==NUll || $arrone['ip_items']==NUll){
			return 1;
		}
		

		foreach ($arrone['ip_items'] as $itemvalue) {
			$status = self::check_item($itemvalue);
			if($status==1){
				return 1;
			}
		}

		if ($arrone['normal_port']!= NULL) {
			$serv_arr = explode(",",$arrone['normal_port']);
			foreach ($serv_arr as $ser_value) {
				if(!in_array($ser_value, $serve)){
					return 1;
					break;
				}
			}
		}
		
		
		if($arrone['scan_time']=="1" || $arrone['scan_time']=="0"){
			//echo "scan_timeok";
			$key = 0;
		}else{
			return 1;
		}

		if ($arrone['name'] != NULL) {
			if(strlen($arrone['name']) > 31){
				return 1;
			}
			if(!preg_match($matchnamestr, $arrone['name'])){
				return 1;
			}
		}

		if ($arrone['desc'] != NULL) {
			if(strlen($arrone['desc']) > 127){
				return 1;
			}
			if(!preg_match($matchdescstr, $arrone['desc'])){
				return 1;
			}
		}
		
		
		
		return 0;
		
		
	}

	function ip2long_v6($ipv6) { //ipv6地址转为长字符串
		$ip_n = inet_pton($ipv6);
		$bits = 15; // 16 x 8 bit = 128bit
		$ipv6long='';
		while ($bits >= 0) {
				$bin = sprintf("%08b",(ord($ip_n[$bits])));
				$ipv6long = $bin.$ipv6long;
				$bits--;
		}
		return gmp_strval(gmp_init($ipv6long,2),10); 
	}

	function calcu_v6range($start ,$end){

		$arr_start = array();//定义要输出的数组
		$start_len = strlen($start);
		$arr_end = array();
		$end_len = strlen($end);
		
		for($i=0;$i<$end_len;$i++){//遍历字符串追加给数组
			$arr_end[] = $end[$i];
		}

		$diff = $end_len - $start_len;
		if($start_len < $arr_end){//长度不同补位

			for($i=0;$i<$diff;$i++){
				$diff_arr = 0;
				$arr_start[] = $diff_arr;

			}
		}

		for($i=$diff;$i<$diff+$start_len;$i++){//遍历字符串追加给数组
			$arr_start[] = $start[$i-$diff]; //现在是从diff开始，需要减掉diff

		}

		$rev_start = array_reverse($arr_start);//数组转至，从角标0对应个十百排
		$rev_end = array_reverse($arr_end);
		
		//定义要输出的数组
		$result = array();
		$flag = 0;
		for($i=0;$i<strlen($end);$i++) {
			//print_r($flag);
			$tmpr = $rev_end[$i] - $rev_start[$i] - $flag ; //flag表示当前是否被借位
			
			if($tmpr < 0){
				$tmpr = $tmpr + 10;
				$flag = 1;
				
			}else{
				$flag = 0;
			}
			$result[] = $tmpr;
		}
		return $result;
	}


	function save_json($in_file_arr)
	{
		
		if (file_exists($this->source)) {  	
		/*判断是否重名、执行状态*/
			$all_json = file_get_contents($this->source);

			$array = json_decode($all_json, true);

			$name_array = array_column($array, 'name');
		}else{
			$array = [];

			$name_array = [];					

		}

		//var_dump(count($array));
		//exit;
		$need_add = 32 - count($array); //最多可加入32条，需减去已有的
		$had_add = 1;

		foreach ($in_file_arr as $key => $value) {
				
			
			//var_dump($had_add);

			if (in_array($value['name'], $name_array)) {
					continue;	
			}else{
				$check = self::check_jarrayone($value);
				$str = json_encode($value,JSON_UNESCAPED_UNICODE);//数组转换成字符串格式，并且保证汉字不被编码
					//var_dump($value['scan_time']);
					
				if( $check == 1 || $had_add> $need_add || $need_add < 1){ // 配置错误、已经添加大于可添加、可添加小于1
					break;
				}else{
					$had_add = $had_add + 1;
					$value['status'] = "0";
					$array[] = $value;
					if($value['scan_time']=="1"){  //建定时任务
						if(!is_dir($dir_cron)){
							mkdir($this->crondir,0755,true);
						}
						file_put_contents($this->crondir.$value['name'], $str);
						$cmd = ' nohup /usr/bin/php /usr/local/wwwroot/api/libs/WeakScanResult.php -f '.$this->crondir.$value['name'].' >/tmp/port.log &';
							
						$time = $value['time'];
						$timeout = explode(':', $time);
						$minute = $timeout[1];
						$hour = $timeout[0];

						if($value['time_type']== "week"){
							$week = $value['week'];
							$cronstr = $minute.' '.$hour.' * * '.$week;
						}
						if($value['time_type']== "month"){
							$month = $value['month'];
							$cronstr = $minute.' '.$hour.' '.$month.' * *';
						}
							//建定时任务  {minute} {hour} {day-of-month} {month} {day-of-week} {full-path-to-shell-script}


						$cron = $cronstr.$cmd."\n";
						$arrcron = file($this->crontab_file);
						$arrcron[] = $cron;
						unlink($this->crontab_file);
						file_put_contents($this->crontab_file, $arrcron);
							//echo $cron;	
					}
				}
			}
		}

		if($check== 1){

			$ret = array('code'=>'7777','str'=>t('policy.input_file_error'));
			echo json_encode($ret);
			return;
		}else{
			$str = json_encode($array); //更新配置文件
			file_put_contents($this->source, $str);
			echo "ok";
		}
	}
}

?>
