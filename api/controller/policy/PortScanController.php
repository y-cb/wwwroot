<?php
namespace controller\policy;
// use database\DbUtil;
use controller\mController;
use database\ScanUtil;
use lib\ScanResult;
use lib\WriteLog;
/**
 * @api {GET}  /api/port-scan 获取扫描配置信息
 * @apiName port-scan
 * @apiGroup 端口扫描
 
 * @apiSuccess {Number} assets_sync 日志ID
 * @apiSuccess {Number} custom_port_enable  自定义端口打开
 * @apiSuccess {String} desc 描述
 * @apiSuccess {Number} fuzzy_port 模糊扫描打开
 * @apiSuccess {String} ip_items ip地址组
 * @apiSuccess {String} lang 语言
 * @apiSuccess {String} name 名称
 * @apiSuccess {String} normal_port 常用端口
 * @apiSuccess {Number} scan_time 立即执行
 * @apiSuccess {Number} status 执行状态

 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		data: [,…]
			0: {normal_port: "", scan_time: "1", time_type: "week", time: "00:10", type: "0", assets_sync: "0",…}
			assets_sync: "0"
			cron_status: "1"
			custom_port_enable: "0"
			desc: ""
			fuzzy_port: "1"
			ip_items: [{ip_host: "172.23.0.91", type: "0"}]
			lang: "cn"
			name: "定时1"
			normal_port: ""
			scan_time: "1"
			status: "0"
			time: "00:10"
			time_type: "week"
			type: "0"
			week: "1,2,3,4,5,6,7"
			1: {normal_port: "25,513", scan_time: "0", time_type: "week", time: "00:00", assets_sync: "0",…}
		total: 2
 *	}
 */

/**
 * @api {POST}  /api/port-scan 添加扫描配置信息
 * @apiName port-scan
 * @apiGroup 端口扫描
 *
 * @apiParam {Number} assets_sync 日志ID
 * @apiParam {Number} custom_port_enable  自定义端口打开
 * @apiParam {String} desc 描述
 * @apiParam {Number} fuzzy_port 模糊扫描打开
 * @apiParam {String} ip_items ip地址组
 * @apiParam {String} lang 语言
 * @apiParam {String} name 名称
 * @apiParam {String} normal_port 常用端口
 * @apiParam {Number} scan_time 立即执行
 * @apiParam {Number} status 执行状态
 *
 * @apiParamExample {json} Request-Example:
 *	{
		"normal_port": "21,22",
		"scan_time": "0",
		"type": "0",
		"assets_sync": "0",
		"fuzzy_port": "0",
		"ip_items": [{"ip_host": "1.1.1.1","type": "0"}],
		"custom_port_enable": "0",
		"name": "111",
		"desc": "111",
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"code": "ok",
 *	}
 *
 */

/**
 * @api {PUT}  /api/port-scan 修改扫描配置信息
 * @apiName port-scan
 * @apiGroup 端口扫描
 *
 * @apiParam {Number} assets_sync 日志ID
 * @apiParam {Number} custom_port_enable  自定义端口打开
 * @apiParam {String} desc 描述
 * @apiParam {Number} fuzzy_port 模糊扫描打开
 * @apiParam {String} ip_items ip地址组
 * @apiParam {String} lang 语言
 * @apiParam {String} name 名称
 * @apiParam {String} normal_port 常用端口
 * @apiParam {Number} scan_time 立即执行
 * @apiParam {Number} status 执行状态
 *
 * @apiParamExample {json} Request-Example:
 *	{
		"normal_port": "21",
		"scan_time": "0",
		"type": "0",
		"assets_sync": "0",
		"fuzzy_port": "0",
		"ip_items": [{"ip_host": "1.1.1.3","type": "0"}],
		"custom_port_enable": "0",
		"name": "111",
		"desc": "1113",
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"code": "ok",
 *	}
 *
 */

/**
 * @api {DELETE}  /api/port-scan 删除web访问策略
 * @apiName port-scan
 * @apiGroup 端口扫描
 *
 *
 * @apiParam {Number} id 策略id
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "aaa"
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"code":"0"
 *	}
 *
 */




class PortScanController extends mController{

	
	public $json_file = '/mnt/boot/portscan.json';
	public $crontab_file = '/tmp/cron/crontabs/root';
	public $crontab_bk = '/mnt/boot/scancronbk';
	public $crondir = '/mnt/boot/scancron/';

	//public $module = 'assets_mgmt';//资产同步模块
	function get(){

		$param = get_inputs();
		$page_num = $param['page']?$param['page']:1;
		$page_count = $param['pageSize'];
		$start_num = ($page_num-1)*$page_count;
		
		if (file_exists($this->json_file)) {
			$str = file_get_contents($this->json_file);
			$sys_token_list_arr = json_decode($str);
		}
		$total = count($sys_token_list_arr);
		
		
		for($i=0;$i<$page_count;$i++){
			if(isset($sys_token_list_arr[$start_num+$i])){
				$paged_sys_token_list_arr[] =  $sys_token_list_arr[$start_num+$i];
			}
			
		}

		$data = array();
		$data['total'] = $total;
		$data['data'] = $paged_sys_token_list_arr;
		echo json_encode($data);

		//exec($cmd ,$output ,$status);
		//echo $status;

		//后续的资产同步
		/*$param['ip']= "2.2.2.2";
		$param['service'] = "135:msrpc;139:netbios-ssn;445:microsoft-ds;";
		$param['from_scan'] = "1";
		$rspString = getResponse("assets_mgmt", 'add' ,$param);
		$ret = getAssign($rspString, "assets_mgmt");*/

	}



	function statusinfo($param){ //获取执行状态并调用执行脚本
		$str = json_encode($param);
		//var_dump($str);
		/*判断可用cp大于20%可执行*/
		/*$cmd = 'cat /proc/meminfo';

		exec($cmd, $output);
		
		foreach ($output as $outline){
			if(strstr($outline, 'MemTotal')){
				$outline = preg_replace("/\s(?=\s)/","\\1",$outline);
				$outlineout = explode(' ', $outline);
				$memtotal = $outlineout[1];
			}
			if(strstr($outline, 'MemFree')){
				$outline = preg_replace("/\s(?=\s)/","\\1",$outline);
				$outlineout = explode(' ', $outline);
				$memfree = $outlineout[1];
			}
			if(strstr($outline, 'HugePages_Total')){
				$outline = preg_replace("/\s(?=\s)/","\\1",$outline);
				$outlineout = explode(' ', $outline);
				$hugepagetotal = $outlineout[1];
			}
			if(strstr($outline, 'Hugepagesize')){
				$outline = preg_replace("/\s(?=\s)/","\\1",$outline);
				$outlineout = explode(' ', $outline);
				$hugepagesize = $outlineout[1];
			}				
		}
		//计算cp使用剩余
		$memrate = (float)$memfree/(float)($memtotal - $hugepagetotal * $hugepagesize);*/
		


			if($param['scan_time']=="0"){//立即执行
				echo "执行中";
				$status = "2"; 
				//$para_j ='{"normal_port":"23,25","scan_time":"0","time_type":"week","time":"00:00","assets_sync":"0","fuzzy_port":"0","ip_items":[{"ip_host":"6.6.6.6","type":"0"}],"custom_port_enable":"0","name":"6.6.6.6","desc":"","week":""}';

				$cmd = "nohup /usr/bin/php /usr/local/wwwroot/api/libs/ScanResult.php -f "."'".$str."' >/tmp/port.log &";//调用php在后台执行扫描操作
				$a =pclose(popen($cmd, 'r'));//开启一个子进程后马上关闭, 子进程进入后台处理耗时的处理
				/*定时任务修改为立即执行时删除定时任务*/
				if($param['cron_status']=="1"){
					unlink($this->crondir.$param['name']); //删除文件

					$arrcronnew = self::delTargetLine($this->crontab_file, $this->crondir.$param['name']); //删除任务
					
					unlink($this->crontab_file); 
					file_put_contents($this->crontab_file, $arrcronnew);
					unlink($this->crontab_bk); //备份crontabs，重启时使用
					copy($this->crontab_file,$this->crontab_bk);
					echo "ddcron";
				}
			}else{
				echo "未执行";
				$status = "0";
				
				if(!is_dir($dir_cron)){
					mkdir($this->crondir,0755,true);
				}
				file_put_contents($this->crondir.$param['name'], $str);
				$cmd = ' nohup /usr/bin/php /usr/local/wwwroot/api/libs/ScanResult.php -f '.$this->crondir.$param['name'].' >/tmp/port.log &';
				
				$time = $param['time'];
				$timeout = explode(':', $time);
				$minute = $timeout[1];
				$hour = $timeout[0];

				if($param['time_type']== "week"){
					$week = $param['week'];
					$cronstr = $minute.' '.$hour.' * * '.$week;
				}
				if($param['time_type']== "month"){
					$month = $param['month'];
					$cronstr = $minute.' '.$hour.' '.$month.' * *';
				}
				//建定时任务  {minute} {hour} {day-of-month} {month} {day-of-week} {full-path-to-shell-script}


				$cron = $cronstr.$cmd."\n";
				//echo $cron;

				$arrcronnew = self::delTargetLine($this->crontab_file, $this->crondir.$param['name']);	
				$arrcronnew[] = $cron;
				unlink($this->crontab_file);
				file_put_contents($this->crontab_file, $arrcronnew);
				unlink($this->crontab_bk); //备份crontabs，重启时使用
				copy($this->crontab_file,$this->crontab_bk);		
			}

		return $status;

	}


	function delTargetLine($cronPath, $target){	
		$arrcron = file($cronPath);
		$arrcronnew = array();
			foreach ($arrcron as $cronline) {
				if(!strstr($cronline, $target)){
					$arrcronnew[] = $cronline;
				}
			}	
		return $arrcronnew;

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
		if($start_len < $arr_end){ //长度不同补位

			for($i=0;$i<$diff;$i++){
				$diff_arr = 0;
				$arr_start[] = $diff_arr;

			}
		}

		for($i=$diff;$i<$diff+$start_len;$i++){//遍历字符串追加给数组
			$arr_start[] = $start[$i-$diff]; //现在是从diff开始，需要减掉diff

		}

		$rev_start = array_reverse($arr_start); //数组转至，从角标0对应个十百排位
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

	function itemCount($items_arr){

		$ip_count = 0;
		foreach ($items_arr as $key => $value) {
			
			if ($items_arr[$key]['type']== "0"){// || $items_arr[$key]['type']=="6" ){重复
				$items_arr[$key]['count'] = 1;
				$ip_count = $items_arr[$key]['count'] + $ip_count;
			}

			if($items_arr[$key]['type']=="1"){  //扫描子网
				$ipnet = $items_arr[$key]['ip_net'];
				$ipnet_arr = explode('/', $ipnet);
				if($ipnet_arr[1]==32){
					$items_arr[$key]['count']=1;
				}else{
					$netnumber = 32-(int)$ipnet_arr[1];
					$items_arr[$key]['count'] = pow(2,$netnumber) -2 ;
				}
				$ip_count = $items_arr[$key]['count'] + $ip_count;
			}
			if($items_arr[$key]['type']=="2"){//扫描范围
				$ip_min = $items_arr[$key]['ip_range1'];
				$ip_max = $items_arr[$key]['ip_range2'];
				//echo $ip_max   . "\n"; 
				//echo $ip_min   . "\n"; 
				//printf("%u\n", ip2long($ip_max)); 
				//printf("%u\n", ip2long($ip_min)); 
				$ipcon = ip2long($ip_max) - ip2long($ip_min) + 1;
				//var_dump($ipcon);
				//exit;
				
				$items_arr[$key]['count'] = $ipcon;
				$ip_count = $items_arr[$key]['count'] + $ip_count;
			}
			if($items_arr[$key]['type']=="6"){//扫描ipv6主机
				
				$items_arr[$key]['count'] = 1;
				$ip_count = $items_arr[$key]['count'] + $ip_count;
			}
			if($items_arr[$key]['type']=="8"){//扫描ipv6子网
				$ipnet = $items_arr[$key]['net_v6'];
				$ipnet_arr = explode('/', $ipnet);
				
				$netnumber = 128-(int)$ipnet_arr[1];
				$items_arr[$key]['count'] = pow(2,$netnumber) -2 ;
				$ip_count = $items_arr[$key]['count'] + $ip_count;
			}
			if($items_arr[$key]['type']=="7") {  //扫描ipv6范围

				$ipv6_min = $items_arr[$key]['range6_min'];
				$ipv6_max = $items_arr[$key]['range6_max'];
				//echo $ipv6_min;
				//echo $ipv6_max;

				$stripv6_min = self::ip2long_v6($ipv6_min);
				$stripv6_max = self::ip2long_v6($ipv6_max);

				$array_calcu = self::calcu_v6range($stripv6_min ,$stripv6_max);
				//print_r($array_calcu);

				$items_arr[$key]['count'] = $array_calcu[0] + $array_calcu[1]*10 + $array_calcu[2]*100 + $array_calcu[3]*1000;
				

				for($i=4;$i<count($array_calcu);$i++){
					if($array_calcu[$i]>0){
						$items_arr[$key]['count']=10000;//大于10000赋值10000
						break;
					}
				}

				//echo $items_arr[$key]['count'];

				$ip_count = $items_arr[$key]['count'] + $ip_count;
			}
			
			# code...
		}

		$ip_param['items'] =  $items_arr;
		$ip_param['countall'] =  $ip_count;
		//var_dump($items_arr);
		//exit;
		return $ip_param;

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
	    return  gmp_strval(gmp_init($ipv6long,2),10); 
	}
	
	function post(){//提交配置调用扫描执行

		$param = get_inputs();
		//var_dump($param);
		//$lang = $this->lang;
		
		//exit;
		if($param['scan_time']=="0"){
			$param['time']="0";
		}

		/*终止任务*/
		if($param['stop_flag']=="1"){


			self::stopEvent($param);
			echo "stop";
			return;

		}
		
		
		
		$items = $param['ip_items']; // string(74) "[{"ip_host":"3.3.3.3","type":"0"}]" -》string(34)
		$items = htmlspecialchars_decode($items);
		$items_arr = json_decode($items, true);
		$items_out = self::itemCount($items_arr);

		$param['ip_items'] = $items_out['items'];
		$param['countall'] = $items_out['countall'];
		if(self::funCheck($param)){
			return;
		}

		if($items_out['countall']>500){
			$ret = array('code'=>'-7777','str'=>t('policy.more_than_port_scan'));
			echo json_encode($ret);
			return;
		}
		if($param['custom_port_enable']=="1"){
			$portcount = self::portCount($param['port_items']);
			//var_dump($portcount);
			//exit;
			if($portcount[0]==1){
				$ret = array('code'=>'-1777','str'=>t('policy.repeat_port_scanp'));//限制自定义端口重复
				echo json_encode($ret);
				return;
			}
			if($portcount[2]>200){
				$ret = array('code'=>'-2777','str'=>t('policy.more_than_port_scanp'));//限制自定义端口个数
				echo json_encode($ret);
				return;
			}

		}
		

		$array = array();

		if (file_exists($this->json_file)) {  	
			/*判断是否重名、执行状态*/
			$all_json = file_get_contents($this->json_file);
			
			if ($all_json){
				$array = json_decode($all_json, true);
				if (count($array)>=32) {
					$ret = array('code'=>'-2222','str'=>t('policy.more_than_config'));
					echo json_encode($ret);
					return;
				}

				$name_array = array_column($array, 'name');
				$status_array = array_column($array, 'status');
				$time_array = array_column($array, 'time');


				if (in_array($param['name'], $name_array)) {
					//$ret = array('code'=>'-1111','str' => "扫描名称重复");
					$ret = array('code'=>'-1111','str'=>t('policy.duplicate_scan_name'));
					echo json_encode($ret);
					return;
				}

				if (in_array("2", $status_array)) {
					$ret = array('code'=>'-2222','str'=>t('policy.scan_task_busy'));
					echo json_encode($ret);
					return;
				}

				//时间重复判断
				if ($param['scan_time']=="1" && in_array($param['time'], $time_array)) {

					if ($param['time_type']=="week") {
						$day_array = array_column($array, 'week');
						$day_add = $param['week'];
					}

					if ($param['time_type']=="month") {
						$day_array = array_column($array, 'month');
						$day_add = $param['month'];
					}
					

					$days_hav = [];
					
					foreach ($day_array as $value) {
						$value_hav = explode(",",$value);
						$days_hav = array_merge($days_hav,$value_hav);
					}

					$day_arr = explode(",",$day_add);
					foreach ($day_arr as $add_one){

						if(in_array($add_one, $days_hav)){
							$ret = array('code'=>'-1112','str'=>t('policy.duplicate_scan_time')); 
							echo json_encode($ret);
							return;
						}
					}
					
				}



				foreach ($param['ip_items'] as $v) {
                    //判断0.0.0.0地址
                    if($v[ip_host] == "0.0.0.0" || $v[ip_host] == "255.255.255.255" || $v[ip_range1] == "0.0.0.0" || $v[ip_range2] == "255.255.255.255"){
                	   $ret = array('code'=>'-4444','str'=>t('policy.disallow_address'));
				       echo json_encode($ret);
				       return;
                    }

            	//正则表达式判断127网段
            	    $ip_host=preg_match('/^(?:127)(?:[.](?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)){3}$/', $v[ip_host]);
            	    $ip_net=preg_match('/^(?:127)(?:[.](?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)){3}/', $v[ip_net]);
            	    $ip_range1=preg_match('/^(?:127)(?:[.](?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)){3}$/', $v[ip_range1]);
            	    $ip_range2=preg_match('/^(?:127)(?:[.](?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)){3}$/', $v[ip_range2]);
            	
            	    if($ip_host==1||$ip_net==1||$ip_range1==1||$ip_range2==1){
            		    $ret = array('code'=>'-4444','str'=>t('policy.disallow_address'));
				        echo json_encode($ret);
				        return;
            	    }
                }

              

                 //判断自定义端口从小到大输入
			    $var=explode(",",$param['port_items']);//自定义端口转化成数组			
			    if ($param['custom_port_enable']==1) {
                    foreach ($var as $v){       
			            if(strpos($v, '-') !==false){//判断包含'-'字符				
				            $port_str=explode("-",$v);
                            if(intval($port_str[0])>=intval($port_str[1])){
                                $ret = array('code'=>'-3333','str'=>t('policy.custom_port_format_error'));
					            echo json_encode($ret);
					            return;
                            } 
		                }
				    }
			    }

			}
		}
		$param['status'] = "0";
		
		$starttime = date('Y-m-d H:i:s',time());
		if($param['scan_time']=="1"){
			$param['cron_status'] = "1";
			$starttime = date('Y-m-d',time())." ".$param['time'].":00";
		}

		$param['start_time'] = $starttime;

		$ha_status = get_ha_status(); //判断ha是否执行

		if ($ha_status =="1") {
			$param['status'] = self::statusinfo($param);
		}

		/*将配置信息输入到配置文件*/
		$array[] = $param;

		$str = json_encode($array);

		file_put_contents($this->json_file, $str);
		

		
		if($param['scan_time']=="1"){
			$params = array("sync_module"=>"5","sync_type"=>"3","sync_name"=>$param['name']);  //   5-/mnt/boot/scancron/name
			$rspString = getResponse('ha_sync_module', "mod" ,$params);

			$params = array("sync_module"=>"8","sync_type"=>"3","sync_name"=>"");   //  8-/tmp/cron/crontabs/root记录
			$rspString = getResponse('ha_sync_module', "mod" ,$params);

		}

	
		$params = array("sync_module"=>"2","sync_type"=>"3","sync_name"=>"");    //    2-/mnt/boot/portscan.json
		$rspString = getResponse('ha_sync_module', "mod" ,$params);

		$msg='SrcIP='.$_SERVER["REMOTE_ADDR"].' UserName='.$_SESSION[CONNECTION.USERNAME].' Operate="add port scan configuration" ManageStyle=web Content="operation success"';
		WriteLog::ConfigWrite($msg);
		
		echo "ok";
		return;

	}

	function put(){//修改

		$param = get_inputs();
		if($param['scan_time']=="0"){

			$param['time']="0";
		}

		$items = $param['ip_items']; // string(74) "[{"ip_host":"3.3.3.3","type":"0"}]" -》string(34)
		$items = htmlspecialchars_decode($items);
		$items_arr = json_decode($items, true);

		$items_out = self::itemCount($items_arr);

		$param['ip_items'] = $items_out['items'];
		$param['countall'] = $items_out['countall'];
		if(self::funCheck($param)){
			return;
		}
		if($items_out['countall']>500){
			$ret = array('code'=>'-7777','str'=>t('policy.more_than_port_scan'));
			echo json_encode($ret);
			return;
		}

		if($param['custom_port_enable']=="1"){
			$portcount = self::portCount($param['port_items']);
			//var_dump($portcount);
			//exit;
			if($portcount[0]==1){
				$ret = array('code'=>'-1777','str'=>t('policy.repeat_port_scanp'));//限制自定义端口重复
				echo json_encode($ret);
				return;
			}
			if($portcount[1]>200){
				$ret = array('code'=>'-2777','str'=>t('policy.more_than_port_scanp'));//限制自定义端口个数
				echo json_encode($ret);
				return;
			}

		}

		$all_json = file_get_contents($this->json_file);
		
		if ($all_json){
			$array = json_decode($all_json, true);
			$status_array = array_column($array, 'status');
			$time_array = [];
			$day_array = [];

			if (in_array("2", $status_array)) {
				$ret = array('code'=>'-2222','str'=>t('policy.scan_task_busy'));
				echo json_encode($ret);
				return;
			}

			//时间重复判断
			if ($param['scan_time']=="1") {


				foreach ($array as $arrvalue) {
					if ($arrvalue['name']!=$param['name'] && $param['time_type']=="week") {
						$time_array[] = $arrvalue['time'];
						$day_array[] = $arrvalue['week'];
					}
					if ($arrvalue['name']!=$param['name'] && $param['time_type']=="month") {
						$time_array[] = $arrvalue['time'];
						$day_array[] = $arrvalue['month'];
					}

				}

				if ($param['time_type']=="week") {
					$day_add = $param['week'];
				}

				if ($param['time_type']=="month") {
					$day_add = $param['month'];
				}


				$days_hav = [];
				
				foreach ($day_array as $value) {
					$value_hav = explode(",",$value);
					$days_hav = array_merge($days_hav,$value_hav);
				}

				$day_arr = explode(",",$day_add);
				foreach ($day_arr as $add_one){

					if( in_array($param['time'], $time_array) && in_array($add_one, $days_hav)){
						$ret = array('code'=>'-1112','str'=>t('policy.duplicate_scan_time')); 
						echo json_encode($ret);
						return;
					}
				}
				
			}

            foreach ($param['ip_items'] as $v) {
                //判断0.0.0.0地址
                    if($v[ip_host] == "0.0.0.0" || $v[ip_host] == "255.255.255.255" || $v[ip_range1] == "0.0.0.0" || $v[ip_range2] == "255.255.255.255"){
                	   $ret = array('code'=>'-4444','str'=>t('policy.disallow_address'));
				       echo json_encode($ret);
				       return;
                    }


            	//正则表达式判断127网段
            	$ip_host=preg_match('/^(?:127)(?:[.](?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)){3}$/', $v[ip_host]);
            	$ip_net=preg_match('/^(?:127)(?:[.](?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)){3}/', $v[ip_net]);
            	$ip_range1=preg_match('/^(?:127)(?:[.](?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)){3}$/', $v[ip_range1]);
            	$ip_range2=preg_match('/^(?:127)(?:[.](?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)){3}$/', $v[ip_range2]);
            	
            	if($ip_host==1|$ip_net==1|$ip_range1==1|$ip_range2==1){
            		$ret = array('code'=>'-4444','str'=>t('policy.disallow_address'));
				    echo json_encode($ret);
				    return;
            	}
            }





			//判断自定义端口从小到大输入
			$var=explode(",",$param['port_items']);//自定义端口转化成数组			
			if ($param['custom_port_enable']==1) {
                 foreach ($var as $v){       
			        if(strpos($v, '-') !==false){//判断包含'-'字符				
				        $port_str=explode("-",$v);
                        if(intval($port_str[0])>=intval($port_str[1])){
                           $ret = array('code'=>'-3333','str'=>t('policy.custom_port_format_error'));
					       echo json_encode($ret);
					       return;
                        } 
		            }
				}
			}
             

		}

		$param['status'] = "0";

		
		$starttime = date('Y-m-d H:i:s',time());
		
		if($param['scan_time']=="1"){
			$param['cron_status'] = "1";
			$starttime = date('Y-m-d',time())." ".$param['time'].":00";
		}
		$param['start_time'] = $starttime;
		
		$ha_status = get_ha_status();
		//var_dump($ha_status);
		//exit;
		if ($ha_status == "1") {
			/*更新执行状态*/
			$param['status'] = self::statusinfo($param);
			//echo $param['status'];
		}
		if($param['name']){


			foreach ($array as $k => $v) {
				if ($array[$k]['name'] == $param['name']) {
					$array[$k] = $param;
					
				}
			}

		
		$str = json_encode($array);
		file_put_contents($this->json_file, $str);

		if($param['scan_time']=="1"){
			$params = array("sync_module"=>"5","sync_type"=>"3","sync_name"=>$param['name']);  //   5-/mnt/boot/scancron/name
			$rspString = getResponse('ha_sync_module', "mod" ,$params);

			$params = array("sync_module"=>"8","sync_type"=>"3","sync_name"=>"");   //  8-/tmp/cron/crontabs/root记录
			$rspString = getResponse('ha_sync_module', "mod" ,$params);

		}

		
		$params = array("sync_module"=>"2","sync_type"=>"3","sync_name"=>"");    //    2-/mnt/boot/portscan.json
		$rspString = getResponse('ha_sync_module', "mod" ,$params);
		
		$msg='SrcIP='.$_SERVER["REMOTE_ADDR"].' UserName='.$_SESSION[CONNECTION.USERNAME].' Operate="edit port scan configuration" ManageStyle=web Content="operation success"';
		WriteLog::ConfigWrite($msg);

		echo "ok";
		return;
		}
		
	}

	function delete(){//删除
		
		$param = get_inputs();
		if (!file_exists($this->json_file)) {
			$ret = array('code'=>'0','str'=>t('policy.no_scan_json'));
			echo json_encode($ret);
			exit(0);
		}else{
			/*删除配置条目*/
			if($param['name']!==NULL){
				$str = file_get_contents($this->json_file);
				$arr = json_decode($str);
                //判断是否有这条数据
				$arr_name = array_column($arr, 'name');
				$isin = in_array($param['name'],$arr_name);
				//var_dump($isin);
				if($isin==false){
					$ret = array('code'=>'44444','str'=>t('policy.dic_no_name')	); 
			        echo json_encode($ret);
			        exit(0);
				}

				
				foreach ($arr as $item) {
					if ($item->status== 2) {
						$ret = array('code'=>'-2','str'=>t('policy.scan_executing'));
						echo json_encode($ret);
						exit(0);	
					}

					if ($item->name == $param['name'] && $param['status']!= 2) {
						continue;
					}
					$new_arr[] = $item;
				}
				$str = json_encode($new_arr);
				file_put_contents($this->json_file, $str);

				/*如果有定时任务则删除定时任务及文件*/
				if($param['scan_time']=="1"){
					$arrcronnew = self::delTargetLine($this->crontab_file, $this->crondir.$param['name']);
					unlink($this->crontab_file);
					file_put_contents($this->crontab_file, $arrcronnew);
					unlink($this->crontab_bk); //备份crontabs，重启时使用
					copy($this->crontab_file,$this->crontab_bk);

					unlink($this->crondir.$param['name']);
					echo "ddcron";
				}

				if($param['scan_time']=="1"){
					$params = array("sync_module"=>"5","sync_type"=>"3","sync_name"=>$param['name']);  //   5-/mnt/boot/scancron/name
					$rspString = getResponse('ha_sync_module', "mod" ,$params);

					$params = array("sync_module"=>"8","sync_type"=>"3","sync_name"=>"");   //  8-/tmp/cron/crontabs/root记录
					$rspString = getResponse('ha_sync_module', "mod" ,$params);

				}

				
				$params = array("sync_module"=>"2","sync_type"=>"3","sync_name"=>"");    //    2-/mnt/boot/portscan.json
				$rspString = getResponse('ha_sync_module', "mod" ,$params);
				
				$msg='SrcIP='.$_SERVER["REMOTE_ADDR"].' UserName='.$_SESSION[CONNECTION.USERNAME].' Operate="delete port scan configuration" ManageStyle=web Content="operation success"';
				WriteLog::ConfigWrite($msg);

				echo "ok";
			}else{
				$ret = array('code'=>'0','str'=>t('policy.no_scan_json'));
				echo json_encode($ret);
				exit(0);
			}
		}
	}

	function portCount($port_items){ //统计自定义端口个数
		$portarr = explode(",", $port_items);
		$count = 0;
		foreach ($portarr as $porteach) {
			if(strpos($porteach, '-') !==false){//判断包含for字符串，ip
				$portnum = explode("-", $porteach);
				$count = $portnum[1]-$portnum[0]+1+$count;
			}else{
				$count = $count+1;
			}
			# code...
		}
		$key = 1;
		if(array_unique($portarr) == $portarr){
			$key = 0;
		}

		return array($key, $count);
	}

	function stopEvent($param){//结束进程

		//寻找进程id
		$cmd = 'ps -aux |grep nmap && ps -aux |grep php';//遍历namp及php，杀死进程

		exec($cmd, $output);
		//停止进程
		foreach ($output as $outline){
			if(strstr($outline, 'nmap -sT')|| strstr($outline, 'nmap -p')||strstr($outline, '/ScanResult.php')){
				$outline = preg_replace("/\s(?=\s)/","\\1",$outline);
				$outlineout = explode(' ', $outline);
				$pid = $outlineout[1];
				//echo $pid;
				$cmd = "kill -9 ".$pid;
				$a =popen($cmd, 'r');
				pclose($a);
				//echo "kill -9 ".$pid;
			}
		}
		$name = $param['name'];
		if($name){
			$all_json = file_get_contents($this->json_file);
			$array = json_decode($all_json, true);
			foreach ($array as $k => $v) {
				if ($array[$k]['name'] == $name) {
					$array[$k]['status'] = "4";
				}
			}
			$str = json_encode($array);
			file_put_contents($this->json_file, $str);	
		}
		$strparam = json_encode($param);

		$cmd = "nohup /usr/bin/php /usr/local/wwwroot/api/libs/ScanResult.php -f "."'".$strparam."' >/tmp/port.log &";//调用php在后台执行扫描停止操作
		$a =pclose(popen($cmd, 'r'));//开启一个子进程后马上关闭, 子进程进入后台处理耗时的处理
		echo "ok";
		return;
	}

	/*格式如下，可根据情况检查
	  "normal_port": "",
	  "scan_time": "1",
	  "time_type": "week",
	  "time": "00:10",
	  "type": "0",
	  "assets_sync": "0",
	  "fuzzy_port": "1",
	  "ip_items": [
	    {
	      "ip_host": "172.23.0.91",
	      "type": "0"
	    }
	  ],
	  "custom_port_enable": "0",
	  "name": "定时1",
	  "desc": "",
	  "week": "1,2,3,4,5,6,7",
	  "lang": "cn",
	  "status": "0",
	  "cron_status": "1"

	*/

	function funCheck($arrone){ //一些检查
		$matchnamestr = "/^[\u{4e00}-\u{9fa5}a-zA-Z0-9@。._\-\|\(\)\[\]]*$/";
		$matchdescstr = "/^[\u{4e00}-\u{9fa5}a-zA-Z0-9@。._\-\|\(\)\[\]\s\/]*$/";
        $matchip = '/((2(5[0-5]|[0-4]\d))|[0-1]?\d{1,2})(\.((2(5[0-5]|[0-4]\d))|[0-1]?\d{1,2})){3}/';
		if($arrone['name']==NUll || $arrone['scan_time']==NUll || $arrone['type']==NUll || $arrone['ip_items']==NUll){
			$ret = array('code'=>'-5555','str'=>t('policy.something_not_null'));
			echo json_encode($ret);
			return 1;
		}
		elseif($arrone['normal_port']==NUll && $arrone['port_items']==NUll && $arrone['fuzzy_port']==NUll){
			$ret = array('code'=>'-6666','str'=>t('policy.have_onekind_port'));
			echo json_encode($ret);
			return 1;
		}
		//判断地址格式
		elseif ($arrone['ip_items']!=NUll) {	    
			foreach ($arrone['ip_items'] as $v) {
					if($v['type'] == '0' && ( !preg_match($matchip, $v[ip_host]) )){
					   $ret = array('code'=>'-44444','str'=>t('policy.address_format_error'));
				       echo json_encode($ret);
				       return 1;
					}
					elseif($v['type'] == '2' && ( (!preg_match($matchip, $v[ip_range1]))||(!preg_match($matchip, $v[ip_range2])) )){
                        $ret = array('code'=>'-44444','str'=>t('policy.address_format_error'));
				        echo json_encode($ret);
				        return 1;
					}
			}
		}
		elseif($arrone['scan_time']==1 && $arrone['time_type']=='week'){
			$week = explode(",", $arrone['week']);
			foreach ($week as $v) {
			 	//$v=intval($v);
			 	if(!preg_match("/^[1-7]$/" ,$v)){         		  
         		  $ret = array('code'=>'-22222','str'=>t('policy.date_range_error'));
				  echo json_encode($ret);
				  return 1;
         	    }
			}
		}
		elseif($arrone['scan_time']==1 && $arrone['time_type']=='month'){
			$month = explode(",", $arrone['month']);
			foreach ($month as $v) {
			 	//$v=intval($v);
			 	if(!preg_match("/^([1-9]|[1-2]\d|3[0-1])$/" ,$v)){         		  
         		  $ret = array('code'=>'-22222','str'=>t('policy.date_range_error'));
				  echo json_encode($ret);
				  return 1;
         	    }
			}
		}

		elseif(strlen($arrone['name']) > 31){
			$ret = array('code'=>'-9999','str'=>t('policy.name_length_wrong'));
			echo json_encode($ret);
			return 1;
		}
		elseif(strlen($arrone['desc']) > 127){
			$ret = array('code'=>'-9999','str'=>t('policy.desc_length_wrong'));
			echo json_encode($ret);
			return 1;
		}
		elseif(!preg_match($matchnamestr, $arrone['name'])){
			$ret = array('code'=>'-7777','str'=>t('policy.name_have_char'));
			echo json_encode($ret);
			return 1;
		}
		elseif(!preg_match($matchdescstr, $arrone['desc'])){
			$ret = array('code'=>'-8888','str'=>t('policy.desc_have_char'));
			echo json_encode($ret);
			return 1;
		}
		else{
			return 0;
		}	
	}

}
