<?php
//namespace lib;
// use database\ScanUtil;

class ScanResult extends PDO{
	public $json_file = '/mnt/boot/weakpwdscan.json';
	public $dic_file = '/mnt/boot/dic/dic_';

	public function __construct($json) {
		// var_dump($json);die;
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
		$this->connection->exec("CREATE TABLE IF NOT EXISTS `weakpwdscan_log`(`id` integer primary key autoincrement,`infor` varchar(1024),`result` varchar(1024));"); 
	}

	function __destruct()
	{
		$this->connection=null;
	}

	


	//提交扫描信息到数据库 
	public function postInfo($table, $infor, $result) {  
		 $num = $this->connection->query("SELECT id from weakpwdscan_log");//统计当前数据库有多少条数据
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
			$sql = "DELETE FROM weakpwdscan_log where id in(select id from weakpwdscan_log limit 500) ";
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
			echo "-----date-----";
			//时间判断
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
				//var_dump("忙");
				echo "busy";
				//$ret = array('code'=>'-222','str' => "扫描忙");
				//echo json_encode($ret);
				
				$param['start_time'] = $starttime;
				$param['end_time'] = date('Y-m-d H:i:s',time());
				$param['status'] = "0";
				$param['exstatus'] = "0";//执行结果：未执行
				$result = array();
				$add = $this->postInfo('weakpwdscan_log', json_encode($param),json_encode($result));
				return;
			}
			
			
		}
		
		
		$param = json_decode($json,true);
		if($param['stop_flag']=="1"){
			$file_path ="/tmp/weakscanresult.txt";
			if(file_exists($file_path)){
				$file = fopen($file_path, "r");
				$output=array();
				$i=0;
				//输出文本中所有的行，直到文件结束为止。
				while(!feof($file)){
					$output[$i]= fgets($file);//fgets()函数从文件指针中读取一行
					$i++;
				}
				fclose($file);
				$output= array_filter($output);
				print_r($output);
			}
			

			if($output){
				$result = self::getresult($output);//调用getresult函数，处理数据
				//var_dump($result);
				$result = array_unique($result, SORT_REGULAR); //多维数组去重必须加参数
				$result = array_values($result);
			}else{
				$result = [];
			}

			//var_dump($result);
			
			
			$param['end_time'] = date('Y-m-d H:i:s',time());
			$param['status'] = "1";
			$param['exstatus'] = "2";//执行结果：停止
			//写入数据库
			if(file_exists('/tmp/weakscanresult.txt')){
				// $db = new ScanUtil();
				$aad = $this->postInfo('weakpwdscan_log', json_encode($param),json_encode($result));
				unlink('/tmp/weakscanresult.txt'); //结果输出文件，每次需要清空
			}
			//每次写完数据库杀死下进程，避免进程占用
			$okn =self::knmap();
			$okh =self::khydra();
			//更新json文件中的状态
			$upstatus = self::update_status($param['name'],"4"); //停止
			//最后结束时父进程php也杀死下
			$okp =self::kphp();
			echo "stop";
			return;
		}

		if (!in_array($param['name'], $name_array)) {//再次判断运行的任务存在
			echo "no config";
			return;
		}
		if(file_exists('/tmp/weakscanresult.txt')){
			unlink('/tmp/weakscanresult.txt'); //结果输出文件，每次需要清空
		}
		if(file_exists('/tmp/weakscan.txt')){
			unlink('/tmp/weakscan.txt'); //结果输出文件，每次需要清空
		}
		$starttime = date('Y-m-d H:i:s',time());
		echo "start";
		if ($param['name']!=NULL && $param['scan_type']!=NULL && $param['ip_items']!=NULL && $param['normal_port']!=NULL) {
			echo $starttime.':'.$json."\n";

			$upstatus = self::update_status($param['name'],"2"); //执行中

			$userdic = '/mnt/boot/def_login.dic'; //默认值
			$passdic = '/mnt/boot/def_fast.dic';
			
			if($param['scan_type']=='1'){
				$passdic ='/mnt/boot/def_full.dic';
			}
			if($param['scan_type']=='2'){
				$userdicname = $param['user_dic'];
				$passdicname = $param['pwd_dic'];
				echo $passdicname;
				if($userdicname != 'def_login.dic'){
					$userdic = $this->dic_file.$userdicname;
				}
				if( $passdicname =='def_full.dic' ){
					$passdic = '/mnt/boot/def_full.dic';
				}
				if($passdicname !='def_fast.dic' && $passdicname !='def_full.dic' ){
					$passdic = $this->dic_file.$passdicname;
				}	
			}

			$last = '';
			/*if ($param['empty_pwd']=='1' && $param['user_pwd_same'] =='1') {
				$last = ' -e ns'; //都选
			}elseif ($param['empty_pwd']=='1') {
				$last = ' -e n'; //空密码,不好用
			}elseif ($param['user_pwd_same']=='1') {
				$last = ' -e s'; //相同
			}*/

			if ($param['user_pwd_same']=='1') {
				$last = ' -e s'; //相同
			}
			//$userdic = $this->dic_file.$param['user_dic'];
			//$passdic = $this->dic_file.$param['pass_dic'];
			// 扫描服务
			$servstr = $param['normal_port'];
			$servarr = explode(',',$servstr);
			
			$serviceport='';
			foreach ($servarr as $servalue) {
				$servaluep = explode(':',$servalue);
				$serviceport = $serviceport.','.$servaluep[1];
				
			}
			$serviceport=ltrim($serviceport,",");
		//print_r($serviceport);
		//$serviceport='21,22,23,25,513,143,110,1433,3306,5432,5900';
			echo $serviceport;

			/*$output获取结果，用exec()执行后会追加*/
			foreach($param['ip_items'] as $itemone){


				//echo $itemone['type'];

			
				if($itemone['type']=="0") {  //扫描主机
					$cmd = 'nmap -Pn -p '.$serviceport.' '.$itemone['ip_host'];
					echo $cmd;
					$out = self::ps_execute_nmap($cmd, $timeout = 300, $sleep = 30);
				 
				}if($itemone['type']=="6") {  //扫描ipv6主机
					$cmd = 'nmap -Pn -p '.$serviceport.' '.$itemone['host_v6'].' -6';
					$out = self::ps_execute_nmap($cmd, $timeout = 300, $sleep = 30);
				 
				}
				if($itemone['type']=="2"){//扫描范围端口
					$timeout = 300;
					$firstip = ip2long($itemone['ip_range1']);
					$lastip = ip2long($itemone['ip_range2']);
					for ($ip = $firstip; $ip <= $lastip; $ip++) {
						$ipeach = long2ip($ip);
						$cmd = 'nmap -Pn -p '.$serviceport.' '.$ipeach;
						echo $cmd;
						$out = self::ps_execute_nmap($cmd, $timeout = 300, $sleep = 30);
						$ipall[] = $ipeach;
					}
					echo $ipall;
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
						$cmd = 'nmap -Pn -p '.$serviceport.' '.$range6_min.' -6';
						echo $cmd;
						echo "\n-----------------------------------\n";	
						
						$out = self::ps_execute_nmap($cmd, $timeout = 300, $sleep = 30);
						
						$intipv6_min = self::jinwei($intipv6_min,1);
						 
					}
					$cmd = 'nmap -Pn -p '.$serviceport.' '.$itemone['range6_max'].' -6';
					echo $cmd;
					//最大ip扫描
					$out = self::ps_execute_nmap($cmd, $timeout = 300, $sleep = 30); 
				 
				}

			}
			$file_path ="/tmp/weakscan.txt";
			if(file_exists($file_path)){
				$file = fopen($file_path, "r");
				$output=array();
				$i=0;
				//输出文本中所有的行，直到文件结束为止。
				while(! feof($file))
				{
				 $output[$i]= fgets($file);//fgets()函数从文件指针中读取一行
				 echo $output;
				 $i++;
				}
				fclose($file);
				$output=array_filter($output);
				print_r($output);
			}

			$iponline= self::getonline($output);//调用getonline函数，处理数据返回在线ip使用的端口
			print_r($iponline);
			
			foreach ($iponline as $ipvalueall){

				/*

					 normal_port_opt:[{name: 'ftp:21', value: 'ftp:21'},{name: 'ssh:22', value: 'ssh:22'},{name: 'telnet:23', value: 'telnet:23'},{name: 'smtp:25', value: 'smtp:25'},{name: 'rlogin:513', value: 'rlogin:513'},{name: 'imap:143', value: 'imap:143'},{name: 'pop3:110', value: 'pop3:110'},{name: 'mssql:1433', value: 'mssql:1433'},{name: 'mysql:3306', value: 'mysql:3306'},{name: 'postgresql:5432', value: 'postgresql:5432'},{name: 'vnc:5900', value: 'vnc:5900'}],

				*/
				$ipvalue = $ipvalueall['ip'];
				echo $ipvalue;
				if($ipvalueall['port'] == '5900/tcp' && in_array('vnc:5900', $servarr) ){
					$service = 'vnc';
					$cmd = 'hydra '.$ipvalue.' '.$service.' -P '.$passdic.' -vV'.$last;
					echo $cmd;
					$out = self::ps_execute($cmd, $timeout = 300, $sleep = 30);
					 //空密码检测
					if ($param['empty_pwd']=='1') {
						$cmd = 'hydra '.$ipvalue.' '.$service.' -p '.'" "'.' -vV';
						$out = self::ps_execute($cmd, $timeout = 300, $sleep = 30);				
					}	

				}
				if($ipvalueall['port'] == '143/tcp' && in_array('imap:143', $servarr)){
					$service = 'imap';
					$cmd = 'hydra '.$ipvalue.' '.$service.' PLAIN -L '.$userdic.' -P '.$passdic.' -vV'.$last;
					echo $cmd;
					$out = self::ps_execute($cmd, $timeout = 300, $sleep = 30);
					 //空密码检测
					if ($param['empty_pwd']=='1') {
						$cmd = 'hydra '.$ipvalue.' '.$service.' PLAIN -L '.$userdic.' -p '.'" "'.' -vV';
						$out = self::ps_execute($cmd, $timeout = 300, $sleep = 30);					
					}	
				}
				
				if($ipvalueall['port'] == '25/tcp' && in_array('smtp:25', $servarr)){
					$service = 'smtp';
					$cmd = 'hydra '.$ipvalue.' '.$service.' -L '.$userdic.' -P '.$passdic.' -vV'.$last;
					//hydra 服务器地址 smtp -L usr.txt -P pas.txt  -vV -e ns
					echo $cmd;
					$out = self::ps_execute($cmd, $timeout = 300, $sleep = 30);
					 //空密码检测
					if ($param['empty_pwd']=='1') {
						$cmd = 'hydra '.$ipvalue.' '.$service.' -L '.$userdic.' -p '.'" "'.' -vV';
						$out = self::ps_execute($cmd, $timeout = 300, $sleep = 30);						
					}	
				}
				if($ipvalueall['port'] == '110/tcp' && in_array('pop3:110', $servarr)){
					$service = 'pop3';
					$cmd = 'hydra '.$ipvalue.' '.$service.' -L '.$userdic.' -P '.$passdic.' -vV'.$last;
					echo $cmd;
					$out = self::ps_execute($cmd, $timeout = 300, $sleep = 30);
					 //空密码检测
					if ($param['empty_pwd']=='1') {
						$cmd = 'hydra '.$ipvalue.' '.$service.' -L '.$userdic.' -p '.'" "'.' -vV';
						$out = self::ps_execute($cmd, $timeout = 300, $sleep = 30);						
					}	
				}
				if($ipvalueall['port'] == '21/tcp' && in_array('ftp:21', $servarr)){
					$service = 'ftp';
					$cmd = 'hydra '.$ipvalue.' '.$service.' -L '.$userdic.' -P '.$passdic.' -vV'.$last;
					echo($cmd); 
					$out = self::ps_execute($cmd, $timeout = 300, $sleep = 30);
					   		 
					 //空密码检测
					if ($param['empty_pwd']=='1') {
						$cmd = 'hydra '.$ipvalue.' '.$service.' -L '.$userdic.' -p '.'" "'.' -vV';
						$out = self::ps_execute($cmd, $timeout = 300, $sleep = 30);						
					}	
				}
				if($ipvalueall['port'] == '22/tcp' && in_array('ssh:22', $servarr)){
					$service = 'ssh';
					$cmd = 'hydra '.$ipvalue.' '.$service.' -L '.$userdic.' -P '.$passdic.' -vV -t 30'.$last;//ssh线程多一点
					//$cmd = 'hydra 172.17.109.3 ssh -L /mnt/boot/def_login.dic -P /mnt/boot/def_full.dic -vV -t 30 -e s';
					echo $cmd;
					$out = self::ps_execute($cmd, $timeout = 300, $sleep = 30);
					 //空密码检测
					if ($param['empty_pwd']=='1') {
						$cmd = 'hydra '.$ipvalue.' '.$service.' -L '.$userdic.' -p '.'" "'.' -vV -t 30';
						$out = self::ps_execute($cmd, $timeout = 300, $sleep = 30);						
					}	
				}
				if($ipvalueall['port'] == '23/tcp' && in_array('telnet:23', $servarr)){
					$service = 'telnet';
					$cmd = 'hydra '.$ipvalue.' '.$service.' -L '.$userdic.' -P '.$passdic.' -vV'.$last;
					echo $cmd;
					$out = self::ps_execute($cmd, $timeout = 300, $sleep = 30);
					 //空密码检测
					if ($param['empty_pwd']=='1') {
						$cmd = 'hydra '.$ipvalue.' '.$service.' -L '.$userdic.' -p '.'" "'.' -vV';
						$out = self::ps_execute($cmd, $timeout = 300, $sleep = 30);						
					}	
				}
				if($ipvalueall['port'] == '3306/tcp' && in_array('mysql:3306', $servarr)){
					$service = 'mysql';
					$cmd = 'hydra '.$ipvalue.' '.$service.' -L '.$userdic.' -P '.$passdic.' -vV'.$last;
					echo $cmd;
					$out = self::ps_execute($cmd, $timeout = 300, $sleep = 30);
					 //空密码检测
					if ($param['empty_pwd']=='1') {
						$cmd = 'hydra '.$ipvalue.' '.$service.' -L '.$userdic.' -p '.'" "'.' -vV';
						$out = self::ps_execute($cmd, $timeout = 300, $sleep = 30);						
					}	
				}
				if($ipvalueall['port'] == '1433/tcp' && in_array('mssql:1433', $servarr)){
					$service = 'mssql';
					$cmd = 'hydra '.$ipvalue.' '.$service.' -L '.$userdic.' -P '.$passdic.' -vV'.$last;
					echo $cmd;
					$out = self::ps_execute($cmd, $timeout = 300, $sleep = 30);
					 //空密码检测
					if ($param['empty_pwd']=='1') {
						$cmd = 'hydra '.$ipvalue.' '.$service.' -L '.$userdic.' -p '.'" "'.' -vV';
						$out = self::ps_execute($cmd, $timeout = 300, $sleep = 30);						
					}	
				}
				if($ipvalueall['port'] == '5432/tcp' && in_array('postgresql:5432', $servarr)){
					$service = 'postgres';
					$cmd = 'hydra '.$ipvalue.' '.$service.' -L '.$userdic.' -P '.$passdic.' -vV'.$last;
					echo $cmd;
					$out = self::ps_execute($cmd, $timeout = 300, $sleep = 30);
					 //空密码检测
					if ($param['empty_pwd']=='1') {
						$cmd = 'hydra '.$ipvalue.' '.$service.' -L '.$userdic.' -p '.'" "'.' -vV';
						$out = self::ps_execute($cmd, $timeout = 300, $sleep = 30);						
					}	
				}
				if($ipvalueall['port'] == '3389/tcp' && in_array('rdp:3389', $servarr)){
					$service = 'rdp';
					$cmd = 'hydra '.$ipvalue.' '.$service.' -L '.$userdic.' -P '.$passdic.' -vV'.$last;
					echo $cmd;
					$out = self::ps_execute($cmd, $timeout = 300, $sleep = 30);
					 //空密码检测
					if ($param['empty_pwd']=='1') {
						$cmd = 'hydra '.$ipvalue.' '.$service.' -L '.$userdic.' -p '.'" "'.' -vV';
						$out = self::ps_execute($cmd, $timeout = 300, $sleep = 30);						
					}	
				}
				if($ipvalueall['port'] == '513/tcp' && in_array('rlogin:513', $servarr)){
					$service = 'rlogin';
					$cmd = 'hydra '.$ipvalue.' '.$service.' -L '.$userdic.' -P '.$passdic.' -vV'.$last;
					echo $cmd;
					$out = self::ps_execute($cmd, $timeout = 300, $sleep = 30);
					 //空密码检测
					if ($param['empty_pwd']=='1') {
						$cmd = 'hydra '.$ipvalue.' '.$service.' -L '.$userdic.' -p '.'" "'.' -vV';
						$out = self::ps_execute($cmd, $timeout = 300, $sleep = 30);						
					}	
				}
			}
			
			//echo $out;
			
			$file_path ="/tmp/weakscanresult.txt";
			if(file_exists($file_path)){
				$file = fopen($file_path, "r");
				$output=array();
				$i=0;
				//输出文本中所有的行，直到文件结束为止。
				while(!feof($file)){
					$output[$i]= fgets($file);//fgets()函数从文件指针中读取一行
					$i++;
				}
				fclose($file);
				$output= array_filter($output);
				print_r($output);
			}
			

			if($output){
				$result = self::getresult($output);//调用getresult函数，处理数据
				//var_dump($result);
				$result = array_unique($result, SORT_REGULAR); //多维数组去重必须加参数
				$result = array_values($result);
			}else{
				$result = [];
			}

			//var_dump($result);
			
			$param['start_time'] = $starttime;
			$param['end_time'] = date('Y-m-d H:i:s',time());
			$param['status'] = "1";
			$param['exstatus'] = "1";//执行结果：完成状态
			//写入数据库

			// $db = new ScanUtil();
			$aad = $this->postInfo('weakpwdscan_log', json_encode($param),json_encode($result));
			//var_dump($id);
			//寻找进程id,结束探测ip端口在线的nmap进程，结束进行破解的hydra进程
			$okn =self::knmap();
			$okh =self::khydra();
			//更新json文件中的状态
			$upstatus = self::update_status($param['name'],"1"); //完成
			//最后结束时父进程php也杀死下
			$okp =self::kphp();

			
		}else{
			echo "config wrong!";
			return;
		}
		
	}

	function getonline($arr){ //在线ip结果
		$arrall = array();
		$preg_v4 = '/((25[0-5]|(2[0-4]\d)|(1\d{2})|([1-9]\d)|(\d))\.){3}(25[0-5]|(2[0-4]\d)|(1\d{2})|([1-9]\d)|(\d))/';
		$preg_v6 = '/([a-f0-9]{1,4}(:[a-f0-9]{1,4}){7}|[a-f0-9]{1,4}(:[a-f0-9]{1,4}){0,7}::[a-f0-9]{0,4}(:[a-f0-9]{1,4}){0,7})/';
		//$i = 0;
		foreach ($arr as $v){//筛选ip、端口扫描结果
			if(strpos($v, 'report for') !==false){//判断包含for字符串，ip
				//$ipstr = str_replace(PHP_EOL, '', substr($v, 21)); //取出ip并去掉换行
				if(preg_match($preg_v4, $v, $ipstr) || preg_match($preg_v6, $v, $ipstr)){
					echo $ipstr;
					$arrone['ip'] = $ipstr[0];
				}

			}
			elseif (strpos($v, '/tcp') !==false){//判断包含/tcp字符串，端口
				$v = preg_replace("/\s(?=\s)/","\\1",$v);

				$outlineout = explode(' ', $v);
				//$service = str_replace(' ', ';', $v);
				$arrone['port']= $outlineout[0];
				$arrone['port_status']= $outlineout[1];
				if ($arrone['port_status'] == 'open'||$arrone['port_status'] == 'filtered') {
					$arrall[] = $arrone;
				}
				//$arrone['port_service']= $outlineout[2];
				
			}	
		}
		//array_unique($arrall);//去重
		return $arrall;
	}



	function getresult($arr){ //处理结果，获取特定格式
		$arrall = array();
		//print_r($arr);

		foreach ($arr as $v){//筛选ip、端口扫描结果
			

			/*if (strstr($v, 'attacking')){//判断包含 [DATA] attacking ftp://ip:21/
				$v = preg_replace("/\s(?=\s)/","\\1",$v);
				$outlineout = explode(' ', $v); //$outlineout[2] 为 ftp://ip:21/
				//echo $outlineout;
				$outlineinfor = explode('://', $outlineout[2]);
				
				$arrone['service'] = $outlineinfor[0];
				$outlineinforip = explode(':', $outlineinfor[1]);
				
				$ip = str_replace(':'.$outlineinforip[count($outlineinforip)-1] , '' , $outlineinfor[1]);

				$arrone['ip'] = trim($ip,"[]");
				//var_dump($arrone['ip']);
				//$arrone['ip'] = $outlineinforip[0];

			}*/
			if ((strstr($v, 'host:')&& strstr($v, 'login:'))||(strstr($v, 'host:')&& strstr($v, 'password:'))) { //弱密码用户
			//[21][ftp] host: 172.23.0.105   login: anonymous   password: anonymous 
			//[21][ftp] host: 172.23.0.105   login: anonymous
			//[23][telnet] host: 4000::1   login: admin   password: admin123.
			//[vnc] host: 172.23.0.105   password: anonymous
			/*错误的connection string: host = '172.17.119.109' dbname = 'template1' user = 'admin' password = '12345678' 

			[24] => connection string: host = '172.17.119.109' dbname = 'template1' user = 'admin' password = 'admin!11' */
				$v = str_replace(': ', '|', $v); //先把： 换成-，避免和ipv6地址::混淆
				$v = preg_replace("/\s(?=\s)/","\\1",$v);
				$outlineout = explode(' ', $v);
				//var_dump($outlineout);
				$service = trim($outlineout[0],"[]");
				$arrone['service'] = explode('][', $service)[1];
				
				$arrone['ip']= explode('|', $outlineout[1])[1];
				if($arrone['service']=="vnc"){
					$arrone['weakpwduser']="-";
				}else{
					$arrone['weakpwduser']= explode('|', $outlineout[2])[1]; //：空格分割
				}
				
				//$arrone['password']= $outlineout[3];
				$arrall[] = $arrone;	
			}
		}
		//array_unique($arrall);//去重
		//print_r($arrall);
		if(count($arrall)>100){
			$arrall = array_slice($arrall, 0, 100);
			$arrone['ip']= "Simplified oversized data";
			$arrone['service']= "-";
			$arrone['weakpwduser']= "-";
			$arrall[] = $arrone;
		}
		return $arrall;
	}

	function update_status($name,$status) //更新执行状态
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
		
		$command = $cmd.' >> /tmp/weakscanresult.txt 2>&1&echo $!';
	
		exec($command ,$op); 
		$pid = (int)$op[0]; //exec执行id
		//echo $pid;
		print_r($pid); 

		if(!$pid){ 
			$ok =self::khydra();
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
				$ok =self::khydra(); 
				return "this end"; // Process must have exited, success!
			}
		} 

		
		return "Process timeout";
		
	}


	function ps_execute_nmap($cmd, $timeout, $sleep) {  //进程监控,$cmd执行, $timeout超时时间, $sleep检查超时的间隔
	// First, execute the process, get the process ID
		
		$command = $cmd.' >> /tmp/weakscan.txt 2>&1&echo $!';
	
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
			$exit =self::ps_exists_nmap($pid);
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

	function ps_exists_nmap($pid) { //超看进程是否存在

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

	function knmap()
	{
		// If process is still running after timeout, kill the process and return false 
		$hydracmd = 'ps -aux |grep nmap';

		exec($hydracmd, $hydraoutput);
		
		foreach ($hydraoutput as $outline){
				if(strstr($outline, 'nmap -Pn')){
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

	function khydra()
	{
		// If process is still running after timeout, kill the process and return false


		$cmdhydra = "killall -9 hydra";	
		$ahydra =popen($cmdhydra, 'r');
		pclose($ahydra); 

		$hydracmd = 'ps -aux |grep hydra';

		exec($hydracmd, $hydraoutput);
		
		foreach ($hydraoutput as $outline){
				if(strstr($outline, 'hydra')){
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
			if(strstr($outline, '/WeakScanResult.php')){
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
