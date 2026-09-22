<?php
//namespace lib;
// use database\ScanUtil;

class ScanResult extends PDO{
	public $json_file = '/mnt/boot/portscan.json';
	public $token_file = '/mnt/boot/token.json';
	public $ha_file = '/tmp/ha_stats';

	public function __construct($json) {
		
		self::connect();
		self::create();


		self::scan($json);
		
	}
	public function connect()
	{

		$file = '/tmp/locallog/event_log.db';
		
		
		try
		{
			$this->connection = new PDO('sqlite:'.$file);
		}
		catch(PDOException $e)
		{
			try
			{
				$this->connection = new PDO('sqlite2:'.$file);
			}
			catch(PDOException $e)
			{
				exit('<label style="font-size:12px;">'.LocalUtil::getCommonResource('log.error_nopath').'</label>');
			}
		}

	}

	public function create() {
		$this->connection->exec("CREATE TABLE IF NOT EXISTS `portsan_log`(`id` integer primary key autoincrement,`infor` varchar(1024),`result` varchar(1024));"); 
	}

	function __destruct()
	{
		$this->connection=null;
	}

	


	//提交扫描信息到数据库 
	public function postInfo($table, $infor, $result) {  
		 $num = $this->connection->query("SELECT id from portsan_log");//统计当前数据库有多少条数据
		 $rows = $num->fetchAll();
		 $rowCount = count($rows);
		 if($rowCount<1000){//数据库不满1000，插入数据
			$sql = 'INSERT INTO '.$table.'(infor, result) VALUES (?,?)';

			$stmt = $this->connection->prepare($sql);
			 
			$stmt->bindValue(1, $infor, PDO::PARAM_STR);
			$stmt->bindValue(2, $result, PDO::PARAM_STR);
			
			$stmt->execute();
		}else{//数据达到1000，删除数据后再插入
			//$sql = "DELETE FROM portsan_log limit 50 ";
			$sql = "DELETE FROM portsan_log where id in(select id from portsan_log limit 500) ";
			$res = $this->connection->query($sql);
			//var_dump($res);
			
			$sql = 'INSERT INTO '.$table.'( infor, result) VALUES (?,?)';
			$stmt = $this->connection->prepare($sql);
			$stmt->bindValue(1, $infor, PDO::PARAM_STR);
			$stmt->bindValue(2, $result, PDO::PARAM_STR);
			$stmt->execute();
		}
	}
	
	
	function scan($json) {

		//var_dump($json);
		$starttime = date('Y-m-d H:i:s',time());

		$mode = self::ha_stats();
		echo "\n----".$mode."----\n";
		if($mode=="0"){
			echo "ha workmode stop this";
			return;
		}	
		

		$all_json = file_get_contents($this->json_file);
		if ($all_json){
			$array = json_decode($all_json, true);
			$status_array = array_column($array, 'status');
			$name_array = array_column($array, 'name');
		}else{
			echo "no config";
			return;
		}
		if (strstr($json, '/mnt/boot/')) {
			

			$json = file_get_contents($json);
			$param = json_decode($json,true);
			//var_dump($all_json);
			if ($param['scan_time']=="1" && $param['time_type']=="week") {
				$cmd = 'date';

				exec($cmd, $date);
				//$date = preg_replace("/\s(?=\s)/","\\1",$date);
				$datearr = explode(' ', $date[0]);

				switch($datearr[0]) {
					case "Mon":
						$datetime="1";
						break;
					case "Tue":
						$datetime="2";
						break;
					case "Wed":
						$datetime="3";
						break;
					case "Thu":
						$datetime="4";
						break;
					case "Fri":
						$datetime="5";
						break;
					case "Sat":
						$datetime="6";
						break;
					case "Sun":
						$datetime="7";
						break;
				}

				if(strstr($param['week'], $datetime)){
					echo "week check right";
				}else{
					echo "week check wrong";
					return;
				}
				
				
			}
				

			if (in_array("2", $status_array)) {
				echo "busy";
				//var_dump("忙");
				//$ret = array('code'=>'-222','str' => "扫描忙");
				//echo json_encode($ret);
				//定时任务与立即执行任务冲突时，插入一条数据，显示执行结果
				
				$param['start_time'] = $starttime;
				$param['end_time'] = date('Y-m-d H:i:s',time());
				$param['status'] = "0";
				$param['exstatus'] = "0";//执行结果：未执行
				$result = array();
				
				$add = $this->postInfo('portsan_log', json_encode($param),json_encode($result)); //定时执行未执行需写一条日志
				return;
			}
			
		}
		
		$param = json_decode($json,true);
		if ($param['stop_flag']=="1") {  //停止请求
			$file_path ='/tmp/portscanresult.txt';
			if(file_exists($file_path)){
				$file = fopen($file_path, "r");
				$output=array();
				$i=0;
				//输出文本中所有的行，直到文件结束为止。
				while(! feof($file))
				{
				 $output[$i]= fgets($file);//fgets()函数从文件指针中读取一行
				 $i++;
				}
				fclose($file);
				$output=array_filter($output);
				print_r($output);
			}

			$result= self::getresult($output);//调用getresult函数，处理数据插入数据库
			//资产同步
			
			$param['end_time'] = date('Y-m-d H:i:s',time());
			$param['status'] = "1";
			$param['exstatus'] = "2";//执行结果：停止
			//$param['stop_flag']=="1";
			//写入数据库
			print_r($param);

			
			if(file_exists('/tmp/portscanresult.txt')){
				// $db = new ScanUtil();
				$aad = $this->postInfo('portsan_log', json_encode($param),json_encode($result));
				unlink('/tmp/portscanresult.txt'); //结果输出文件，每次需要清空
			}
			
			//var_dump($id);

			//每次写完数据库杀死下进程，避免进程占用
			$okn =self::knmap();
			
			
			/*资产同步*/

			if($param['assets_sync'] == "1"){
				$token_str = file_get_contents($this->token_file);
				$token_arr = json_decode($token_str,true);
				
				if(!empty($token_arr)){
					$apikey = $token_arr[0]['token'];
					//var_dump($apikey);
					$cmd ='wget -q http://localhost/api/port-scan-syn?api_key='.$apikey.'&lang=cn';
					//$cmd ='wget -q http://localhost/api/port-scan-syn?api_key=n3n2f26pdr470cis2jymd9bz87j13jdt&lang=cn';
					
					exec($cmd, $outinfor); 	
				}
			}
			//更新json文件中的状态
			$upstatus = self::update_status($param['name'],"4");
			//最后结束时父进程php也杀死下
			$okp =self::kphp();
			echo "stop";
			return;
		}

		if (!in_array($param['name'], $name_array)) {//再次判断运行的任务存在
			echo "no config";
			return;
		}

		if(file_exists('/tmp/portscanresult.txt')){
			unlink('/tmp/portscanresult.txt'); //结果输出文件，每次需要清空
		}

		echo "start";
		$starttime = date('Y-m-d H:i:s',time());
		if ($param['name']!=NULL && $param['scan_time']!=NULL && $param['ip_items']!=NULL) {
			echo $starttime.':'.$json."\n";

			$upstatus = self::update_status($param['name'],"2"); //执行中

			//$items = $param['ip_items']; // string(74) "[{"ip_host":"3.3.3.3","type":"0"}]" -》string(34)
			//$items = htmlspecialchars_decode($items);
			//$param['ip_items'] = $items =json_decode($items, true);
			if($param['type']=="3"){
				$iptypestr6 = ' -6';//ipv6
			}else{
				$iptypestr6 = '';
			}

		//异步执行
			if($param['fuzzy_port']=="1"){
				$cmdstr = 'nmap -sT ';
					
			}else{
				if($param['custom_port_enable']=="1"){//自定义端口开启
					if($param['normal_port']!=null){//常用端口与自定义端口拼接
						$port = $param['normal_port'].",".$param['port_items'];
					}else{//只有自定义端口
						$port = $param['port_items'];
					}
				}else{//只有扫描端口
					$port = $param['normal_port'];
				}
				$cmdstr = 'nmap -p '.$port;
			}

			/*$output获取结果，用exec()执行后会追加*/
			foreach($param['ip_items'] as $itemone){
				//echo $itemone['type'];

			
				if($itemone['type']=="0") {  //扫描主机
					$cmd = $cmdstr.' '.$itemone['ip_host'].' -Pn';
					$timeout = 300;
					echo $cmd;
					$out = self::ps_execute($cmd, $timeout, $sleep = 30);
					 
				}
				if($itemone['type']=="1"){  //扫描子网
					//$cmd = $cmdstr.' '.$itemone['ip_net'].' -Pn';
					$timeout = 300;
					echo $itemone['ip_net'];
					$range = self::getIpRange($itemone['ip_net']);
					print_r($range);

					for ($ip = $range['firstIP']; $ip <= $range['lastIP']; $ip++) {
						$ipeach = long2ip($ip);
						$cmd = $cmdstr.' '.$ipeach.' -Pn';
						echo $cmd;
						$out = self::ps_execute($cmd, $timeout, $sleep = 30);
						$ipall[] = $ipeach;
					}
					echo $ipall;
				}
				if($itemone['type']=="2"){//扫描范围
					
					/*$arr1=explode('.',$itemone['ip_range1']);
					$arr2=explode('.',$itemone['ip_range2']);
					foreach ($arr2 as $k => $v) {
						if(in_array($v, $arr1)){
							continue;
						} 
						else{
							$arr1[$k] .= '-'.$v;
						}
					}
					$str=$arr1[0].'.'.$arr1[1].'.'.$arr1[2].'.'.$arr1[3];
					$cmd = $cmdstr.' '.$str.' -Pn';*/
					$timeout = 300;
					$firstip = ip2long($itemone['ip_range1']);
					$lastip = ip2long($itemone['ip_range2']);
					for ($ip = $firstip; $ip <= $lastip; $ip++) {
						$ipeach = long2ip($ip);
						
						$cmd = $cmdstr.' '.$ipeach.' -Pn';
						echo $cmd;
						$out = self::ps_execute($cmd, $timeout, $sleep = 30);
						$ipall[] = $ipeach;
					}
					echo $ipall;
					
				}
				if($itemone['type']=="6"){//扫描ipv6主机
					$cmd = $cmdstr.' '.$itemone['host_v6'].$iptypestr6.' -Pn';
					
					$timeout = 300;
					echo $timeout;
					$out = self::ps_execute($cmd, $timeout, $sleep = 30);
				}
				if($itemone['type']=="8"){//扫描ipv6子网
					$cmd = $cmdstr.' '.$itemone['net_v6'].$iptypestr6.' -Pn';
					if($itemone['count']){
						$timeout = $itemone['count']*300;
					}else{
						$timeout = 300;
					}
					echo $timeout;
					$out = self::ps_execute($cmd, $timeout, $sleep = 30);
				}
				if($itemone['type']=="7") {  //扫描ipv6范围

					$intipv6_min = self::ip2long_v6($itemone['range6_min']);
					$intipv6_max = self::ip2long_v6($itemone['range6_max']);

					echo $intipv6_min;
					echo "\n";
					echo $intipv6_max;
					echo "\n***********************************\n";
					
					
					while ( $intipv6_min != $intipv6_max ) {//小于最大ip的扫描
						
						$range6_min = self::long2ip_v6($intipv6_min);
						$cmd = $cmdstr.' '.$range6_min.$iptypestr6.' -Pn';
						echo $cmd;
						echo "\n-----------------------------------\n";	
						
						$out = self::ps_execute($cmd, $timeout = 300, $sleep = 30);	
						
						$intipv6_min = self::jinwei($intipv6_min,1);	 
					}
					$cmd = $cmdstr.' '.$itemone['range6_max'].$iptypestr6.' -Pn';//最大ip扫描
					echo $cmd;
					
					$out = self::ps_execute($cmd, $timeout = 300, $sleep = 30);	 
				}
			}

			

			$file_path ='/tmp/portscanresult.txt';
			if(file_exists($file_path)){
				$file = fopen($file_path, "r");
				$output=array();
				$i=0;
				//输出文本中所有的行，直到文件结束为止。
				while(! feof($file))
				{
				 $output[$i]= fgets($file);//fgets()函数从文件指针中读取一行
				 $i++;
				}
				fclose($file);
				$output=array_filter($output);
				print_r($output);
			}

			$result= self::getresult($output);//调用getresult函数，处理数据插入数据库
			//资产同步
			$param['start_time'] = $starttime;
			$param['end_time'] = date('Y-m-d H:i:s',time());
			$param['status'] = "1";
			$param['exstatus'] = "1";//执行结果：完成状态
			$param['stop_flag']=="0";
			//写入数据库
			print_r($param);

			// $db = new ScanUtil();
			$aad = $this->postInfo('portsan_log', json_encode($param),json_encode($result));
			//var_dump($id);

			//每次写完数据库杀死下进程，避免进程占用
			$okn =self::knmap();
			unlink('/tmp/portscanresult.txt');
			
			/*资产同步*/

			if($param['assets_sync'] == "1"){
				$token_str = file_get_contents($this->token_file);
				$token_arr = json_decode($token_str,true);
				
				if(!empty($token_arr)){
					$apikey = $token_arr[0]['token'];
					//var_dump($apikey);
					$cmd ='wget -q http://localhost/api/port-scan-syn?api_key='.$apikey.'&lang=cn';
					//$cmd ='wget -q http://localhost/api/port-scan-syn?api_key=n3n2f26pdr470cis2jymd9bz87j13jdt&lang=cn';
					
					exec($cmd, $outinfor); 	
				}
			}

			
			//更新json文件中的状态
			$upstatus = self::update_status($param['name'],"1");
			//最后结束时父进程php也杀死下
			$okp =self::kphp();
		}else{
			echo "config wrong!";
			return;
		}
			
	}



	function getIpRange($cidr) {

		list($ip, $mask) = explode('/', $cidr);
		if ($mask ==32) {

			$start = ip2long( $ip );
			$end = ip2long( $ip );
		}else{
			$maskBinStr =str_repeat("1", $mask ) . str_repeat("0", 32-$mask );	  //net mask binary string
			$inverseMaskBinStr = str_repeat("0", $mask ) . str_repeat("1",  32-$mask ); //inverse mask

			$ipLong = ip2long( $ip );
			$ipMaskLong = bindec( $maskBinStr );
			$inverseIpMaskLong = bindec( $inverseMaskBinStr );
			$netWork = $ipLong & $ipMaskLong;
			$start = $netWork+1;//ignore network ID(eg: 192.168.1.0)

			$end = ($netWork | $inverseIpMaskLong) -1 ; //ignore brocast IP(eg: 192.168.1.255)
		}
		return array('firstIP' => $start, 'lastIP' => $end );
	}

	function getresult($arr){
		$arrall = array();
		//$i = 0;
		foreach ($arr as $v){//筛选ip、端口扫描结果
			if(strpos($v, 'report for') !==false){//判断包含for字符串，ip
				$arrone['ip'] = substr($v, 21);
				$arrone['ip'] = str_replace(array("\r\n", "\r", "\n"), "", $arrone['ip']);
			}
			elseif (strpos($v, '/tcp') !==false){//判断包含/tcp字符串，端口
				$v = preg_replace("/\s(?=\s)/","\\1",$v);

				$outlineout = explode(' ', $v);
				//$service = str_replace(' ', ';', $v);
				$arrone['port']= $outlineout[0];
				$arrone['port_status']= $outlineout[1];
				$arrone['port_service']= $outlineout[2];
				$arrone['port_service'] = str_replace(array("\r\n", "\r", "\n"), "", $arrone['port_service']);
				$arrall[] = $arrone;
			}	
		}
		//array_unique($arrall);去重
		if(count($arrall)>100){
			$arrall = array_slice($arrall, 0, 100);
			$arrone['ip']= "Simplified oversized data";
			$arrone['port']= "-";
			$arrone['port_status']= "-";
			$arrone['port_service']= "-";
			$arrall[] = $arrone;
		}
		return $arrall;
	}

	function update_status($name,$status)
	{

		//$status = "1";
		if($name){
			$str = file_get_contents($this->json_file);
			$arr = json_decode($str,true);

			foreach ($arr as $k => $v) {
				if ($arr[$k]['name'] == $name) {
					$arr[$k]['status'] = $status;
				}
			}
			$str = json_encode($arr);
			file_put_contents($this->json_file, $str);
			//echo "ok";
			return "ok";
		}
		
	}


	function ps_execute($cmd, $timeout, $sleep) {  //进程监控,$cmd执行, $timeout超时时间, $sleep检查超时的间隔
	// First, execute the process, get the process ID 
		$command = $cmd.' >> /tmp/portscanresult.txt 2>&1&echo $!';
		exec($command ,$op); 
		$pid = (int)$op[0]; //exec执行id
		//echo $pid;
		print_r($pid); 

		if(!$pid){
			$ok =self::knmap();	
			return "this end"; 
		}

		$cur = 0; 
		// Second, loop for $timeout seconds checking if process is running 
		while( $cur < $timeout ) { 
			sleep($sleep); 
			$cur += $sleep; 
			// If process is no longer running, return true; 

			echo "\n ---- $cur ------ \n";
			$exit =self::ps_exists($pid);
			if(!$exit){ 
				$ok =self::knmap();
				return "this end"; // Process must have exited, success!
			}
		} 


		return "Process timeout";
		
	}

	function ps_exists($pid) { //超看进程是否存在

		exec("ps ax | grep $pid 2>&1", $output); 

		while( list(,$row) = each($output) ) { 

				$row_array = explode(" ", $row); 
				$check_pid = $row_array[0]; 

				if($pid == $check_pid) { 
						return true; 
				} 

		} 

		return false; 
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

	function long2ip_v6($dec) { //ipv6长字符串转回ipv6
		if (function_exists('gmp_init')) {
			$bin = gmp_strval(gmp_init($dec, 10), 2);
		} elseif (function_exists('bcadd')) {
			$bin = '';
			do {
				$bin = bcmod($dec, '2') . $bin;
				$dec = bcdiv($dec, '2', 0);
			} while (bccomp($dec, '0'));
		} else {
			trigger_error('GMP or BCMATH extension not installed!', E_USER_ERROR);
		}
	 
		$bin = str_pad($bin, 128, '0', STR_PAD_LEFT);
		$ip = array();
		for ($bit = 0; $bit <= 7; $bit++) {
			$bin_part = substr($bin, $bit * 16, 16);
			$ip[] = dechex(bindec($bin_part));
		}
		$ip = implode(':', $ip);
		return inet_ntop(inet_pton($ip));
	}

	function jinwei($string,$i){ //长字符串递归进位
		
		if((int)$string[-$i]<9){
			$string[-$i]=(string)((int)$string[-$i] + 1); 
		}else{
			$string[-$i]= "0";
			$i=$i+1;
			$string = self::jinwei($string,$i);
		}
		//echo $string;
		return $string;

	}

	function ha_stats() {

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
			$mode = "0";
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

	function knmap()
	{
		// If process is still running after timeout, kill the process and return false 
		$hydracmd = 'ps -aux |grep nmap';// && ps -aux |grep php

		exec($hydracmd, $hydraoutput);
		
		foreach ($hydraoutput as $outline){
			if(strstr($outline, 'nmap -p')||strstr($outline, 'nmap -sT')){
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
		return "ok";
	}

	function kphp() //只有在完全结束后才用结束父php进程
	{
		// If process is still running after timeout, kill the process and return false 
		$hydracmd = 'ps -aux |grep php';//

		exec($hydracmd, $hydraoutput);
		
		foreach ($hydraoutput as $outline){
			if(strstr($outline, '/ScanResult.php')){
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
		return "ok";
	}

}



if($argc > 1) {
	
	$data = new ScanResult($argv[2]);
	
}
