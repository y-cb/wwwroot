<?php
namespace controller\policy;
use controller\mController;
use database\DbUtil;
use lib\WriteLog;

/**
 * @api {GET}  /api/sys-log 获取日志信息
 * @apiName sys-log
 * @apiGroup 日志信息获取
 *
 *
 * @apiParam {String} type 1代表系统日志，2代表安全日志，3代表NAT日志，4代表应用控制日志，5代表操作日志，av代表无硬盘设备病毒防护日志，ips代表无硬盘设备ips防护日志
 * @apiParam {Number} page 分页，默认为1
 * @apiParam {Number} pageSize 页码，默认为10
 * @apiParam {Timestamp} start_time 开始时间，选填，格式：Y-m-d H:i
 * @apiParam {Timestamp} end_time 结束时间，选填，开始时间和结束时间需一起填写，格式：Y-m-d H:i
 * @apiParam {Number} level 日志等级，选填项，默认返回全部，0代表紧急，1代表告警，2代表严重，3代表错误，4代表警告，5代表通知，6代表信息
 * @apiParam {Number} ids 信息类型，系统日志、操作日志、安全日志使用，选填项，多选用逗号分隔，2：DDOS攻击，，14：防火墙策略，17：HA事件，20：系统事件，21：告警事件，22：接口信息，23：配置审计，24：SCAN攻击，26：OSPF事件，27：RIP事件，28：QOS事件，55：BGP事件，60:VRRP事件，63：Flood攻击，64：沙箱检测，65：威胁情报，76：审计事件
 * @apiParam {String} sip 源ip，选填项，除系统日志外，其他可查询
 * @apiParam {String} dip 目的ip，选填项，除系统日志，操作日志外，其他可查询
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"type": "1",
 *		"page": "1",
 *		"pageSize": "10"
 *	}
 *
 * @apiSuccess {Number} ID 日志ID
 * @apiSuccess {Number} daemon 日志类型，数字与查询参数对应
 * @apiSuccess {Timestamp} time 日志生成时间
 * @apiSuccess {String} type 日志类型，系统日志字段，IF_INFO：接口信息，SYS_INFO：系统日志，SYSTEM_INFO：系统日志，WARNING_INFO：告警事件，CONFIG：配置审计，ATTACK：DDOS攻击，SCAN：SCAN攻击，FILTER：防火墙策略，FLOOD：Flood攻击，DEFENSE：威胁情报
 * @apiSuccess {Number} level 日志级别，数字与查询参数对应
 * @apiSuccess {String} UserName 管理员名称，操作日志字段
 * @apiSuccess {String} SrcIP 源IP，除系统日志、安全日志外，其余日志都有此字段
 * @apiSuccess {String} DstIP 目的IP，除系统日志、操作日志、安全日志外，其余日志都有此字段
 * @apiSuccess {String} ManageStyle 管理方式，操作日志字段
 * @apiSuccess {String} Operate 操作，操作日志字段
 * @apiSuccess {String} Content 结果，操作日志字段
 * @apiSuccess {String} SrcPort 源端口，NAT日志字段
 * @apiSuccess {String} DstPort 目的端口，NAT日志字段
 * @apiSuccess {String} DstPort 目的端口，NAT日志字段
 * @apiSuccess {String} BeforeTransAddr 转换前地址，NAT日志字段
 * @apiSuccess {String} BeforeTransPort 转换前端口，NAT日志字段
 * @apiSuccess {String} AfterTransAddr 转换后地址，NAT日志字段
 * @apiSuccess {String} AfterTransPort 转换后端口，NAT日志字段
 * @apiSuccess {String} PolicyId 策略/规则ID，应用控制日志字段
 * @apiSuccess {String} Protocol 协议，应用控制日志字段
 * @apiSuccess {String} SrcPort 源端口，NAT日志、应用控制日志、入侵防护日志、病毒防护日志字段
 * @apiSuccess {String} DstPort 目的端口，NAT日志、应用控制日志、入侵防护日志、病毒防护日志字段
 * @apiSuccess {String} AppName 应用名称，应用控制日志字段
 * @apiSuccess {String} AppAction 应用行为，应用控制日志字段
 * @apiSuccess {String} Action 应用行为，应用控制日志字段
 * @apiSuccess {String} EventName 事件名称，入侵防护日志字段
 * @apiSuccess {String} SecurityType 安全类型，入侵防护日志字段
 * @apiSuccess {String} count 次数，入侵防护日志字段
 * @apiSuccess {String} VirusName 病毒名称，病毒防护日志字段
 * @apiSuccess {String} VirusFileName 文件名，病毒防护日志字段
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *	    "data": [
 *	        {
 *	            desc: "0"
				description: "1"
				dictionary: "1"
				lang: "cn"
				name: "1"
 *	        }
 *	    ],
 *	    "total": 1
 *	}
 */

class DictionaryController extends mController{
	public $def_diclist = '/mnt/boot/def_dic.json';
	public $list_file = '/mnt/boot/user_dic.json';
	public $dic_folder = '/mnt/boot/dic/dic_';
	public $json_file = '/mnt/boot/weakpwdscan.json';
	//字典文件
	function get(){
		//获取字典列表
		$param = get_inputs();
		if($param['op']=='showone'){
			//$dictionary = ['default_login','default_fastscan_dic','default_fullscan_dic'];
			//$name_array =[];
			$name_array_sys = ['def_login.dic','def_fast.dic','def_full.dic'];
			$json = file_get_contents($this->list_file);
			$array = json_decode($json, true);
			if ($array) {
				$name_array_user = array_column($array, 'name');
			}else{
				$name_array_user = [];
			}
			$name_array = array_merge($name_array_sys, $name_array_user);
			echo json_encode($name_array);
		}
		elseif($param['op'] == 'detail'){ //详情
			$name = $param['name'];
			$arrdic = file_get_contents($this->dic_folder.$name);
			$arrdic = htmlspecialchars_decode($arrdic);
			echo $arrdic;
		}elseif($param['op'] == 'search'){ //查询条目
			//$name ="['11','111']";
			if(strlen($param['search_item']) > 15){
			   $ret = array('code'=>'-99999','str'=>t('policy.dic_length_wrong'));
			   echo json_encode($ret);
			   return 1;
		    }
			$name = htmlspecialchars_decode($param['name']);
			$name = htmlspecialchars_decode($name);
			$name = json_decode($name, true);
			//var_dump($param);
			
			$havefile = array();
			foreach($name as $nameone){
				if(strstr($nameone, 'def_')){
					$file_path = '/mnt/boot/'.$nameone;
				}else{
					$file_path = $this->dic_folder.$nameone;
				}
				
				if(file_exists($file_path)){
					//var_dump("1");
					$file_arr = [];
					$fileout = [];
    				$file_arr = file($file_path);
					foreach ($file_arr as $line) {
						$fileout[] = rtrim($line);
					}
					if(in_array($param['search_item'], $fileout)){
						//var_dump("2");
						$havefile[] = $nameone;
					}
				}
			}
			echo json_encode($havefile);
		}else{
			$page_num = $param['page']?$param['page']:1;
			$page_count = $param['pageSize'];
			$start_num = ($page_num-1)*$page_count;
			if (file_exists($this->def_diclist)) {   //系统字典
				$str = file_get_contents($this->def_diclist);
				$sys_token_list_arr = json_decode($str,true);
			}
			
			if (file_exists($this->list_file)) {   //用户字典
				$str = file_get_contents($this->list_file);
				$diclist_users = json_decode($str,true);
				foreach($diclist_users as $dic_user){
					$sys_token_list_arr[] = $dic_user;   //如果有用户字典则追加下
				}
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
		}
		

	}

	function post(){
		//新增字典
		$param = get_inputs();
		//var_dump($param);


		$name = $param['name'];
		$dictionary = $param['dictionary'];
		//var_dump($dictionary);
		$param['desc']= "0";

		$json = file_get_contents($this->list_file);
		if ($json){
			$array = json_decode($json, true);
		}

		if (count($array)>=29) {
			$ret = array('code'=>'-2222','str'=>t('policy.more_than_config'));
			echo json_encode($ret);
			return;
		}

		if(self::funCheck($param)){
			return;
		}


		$name_array = array_column($array, 'name');
		
		if (in_array($param['name'], $name_array)) {
			$ret = array('code'=>'-1111','str'=>t('policy.duplicate_dic_name'));
			echo json_encode($ret);
			return;
		}
		if(!is_dir('/mnt/boot/dic/')){
			mkdir('/mnt/boot/dic/',0755,true);
		}
		file_put_contents($this->dic_folder.$name,$dictionary);//将字典详细内容输入字典文件dic_XXX
		
		/*name desc输入 diclist,除字典详情外*/
		//array_pop($param); //删除数组中最后一个元素dictionary
		if (file_exists($this->list_file)) {
				$str = file_get_contents($this->list_file);
				$arr = json_decode($str);
		}
		$arr[] = $param;
		$json = json_encode($arr);
		file_put_contents($this->list_file, $json);

		
		$params = array("sync_module"=>"7","sync_type"=>"3","sync_name"=>$param['name']);  //   5-/mnt/boot/dic/name
		$rspString = getResponse('ha_sync_module', "mod" ,$params);
		
		$msg='SrcIP='.$_SERVER["REMOTE_ADDR"].' UserName='.$_SESSION[CONNECTION.USERNAME].' Operate="add dictionary configuration" ManageStyle=web Content="operation success"';
		WriteLog::ConfigWrite($msg);

		echo ok;
		return;
	}

	function put(){
		//修改字典
		$param = get_inputs();
		//echo $param;
		$name = $param['name'];
		$dictionary = $param['dictionary'];
		
		if(self::funCheck($param)){
			return;
		}


		if(!is_dir('/mnt/boot/dic/')){
			mkdir('/mnt/boot/dic/',0755,true);
		}   
		file_put_contents($this->dic_folder.$name, $dictionary); 
		

		$all_json = file_get_contents($this->list_file);
		//var_dump($all_json);
		$array = json_decode($all_json, true);

		if($param['name']){
			foreach ($array as $k => $v) {
				if ($array[$k]['name'] == $param['name']) {
					$array[$k]['description'] = $param['description'];
					$array[$k]['dictionary'] = $param['dictionary'];
				}
			}
			$str = json_encode($array);
			//var_dump($str);
			file_put_contents($this->list_file, $str);
		}

		
		$params = array("sync_module"=>"7","sync_type"=>"3","sync_name"=>$param['name']);  //   5-/mnt/boot/dic/name
		$rspString = getResponse('ha_sync_module', "mod" ,$params);
		
		$msg='SrcIP='.$_SERVER["REMOTE_ADDR"].' UserName='.$_SESSION[CONNECTION.USERNAME].' Operate="edit dictionary configuration" ManageStyle=web Content="operation success"';
		WriteLog::ConfigWrite($msg);

		echo ok;
		return;
	}

	function delete(){
		//删除字典
		$param = get_inputs();

		$use_infor = file_get_contents($this->json_file);
		$infor_array = json_decode($use_infor, true);
        
        foreach ($infor_array as $v) {
                if($v['scan_type']=="2"){//取出自定义字典中所有引用的字典            		
             		$use_user_dic[] = $v['user_dic'];
             		$use_pwd_dic[] = $v['pwd_dic'];
             	}
        }


		//$use_user_dic = array_column($infor_array, 'user_dic');
		//$use_pwd_dic = array_column($infor_array, 'pwd_dic');

		if (!file_exists($this->list_file)) {
			$ret = array('code'=>'0','str'=>t('policy.no_scan_json')); //json文件不存在
			echo json_encode($ret);
			exit(0);
		}elseif($param['desc'] == 1){
			$ret = array('code'=>'5555','str'=>t('policy.dic_system')); //系统字典,不能删除
			echo json_encode($ret);
			exit(0);
		}elseif(in_array($param['name'], $use_user_dic) && $param['desc'] == 0){
			$ret = array('code'=>'4444','str'=>t('policy.dic_used')	); //字典被引用,不能删除
			echo json_encode($ret);
			exit(0);
		}elseif(in_array($param['name'], $use_pwd_dic) && $param['desc'] == 0){
			$ret = array('code'=>'4444','str'=>t('policy.dic_used')	); //字典被引用,不能删除
			echo json_encode($ret);
			exit(0);
		}else{
			/*删除配置条目*/
			if($param['name']){
				$str = file_get_contents($this->list_file);
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
				
				$db = new DbUtil();
				$msg='SrcIP='.$_SERVER["REMOTE_ADDR"].' UserName='.$_SESSION[CONNECTION.USERNAME].' Operate="delete dictionary configuration" ManageStyle=web Content="operation success"';
				unlink($this->dic_folder.$param['name']); //删除字典文件
				foreach ($arr as $item) {
					if ($item->name == $param['name'] && $param['desc'] == 0) {
						//插入一条操作日志
						/*$table = 'CONFIG_LOG';
			            $db->addEventLog(20,date('Y-m-d H:i:s',time()),'SYSTEM_INFO',5,'',$msg,$table);*/
			            WriteLog::ConfigWrite($msg);


						continue;
					}
					$new_arr[] = $item;
				}
				$str = json_encode($new_arr);
				file_put_contents($this->list_file, $str);

				
				$params = array("sync_module"=>"7","sync_type"=>"3","sync_name"=>$param['name']);  //   5-/mnt/boot/dic/name
				$rspString = getResponse('ha_sync_module', "mod" ,$params);
				
				//$msg='SrcIP='.$_SERVER["REMOTE_ADDR"].' UserName='.$_SESSION[CONNECTION.USERNAME].' Operate="delete dictionary configuration" ManageStyle=web Content="operation success"';
				//WriteLog::ConfigWrite($msg);
				//echo "ok";
			}else{
				$ret = array('code'=>'0','str'=>t('policy.no_scan_json'));//json不存在
				echo json_encode($ret);
				exit(0);
			}
		}
		
	}

	/*可按需检查以下
	desc: "0"
	description: "1"
	dictionary: "1"
	lang: "cn"
	name: "1"
	*/

	function funCheck($arrone){ //一些检查
		$matchnamestr = "/^[\u{4e00}-\u{9fa5}a-zA-Z0-9@。._\-\|\(\)\[\]]*$/";
		$matchdescstr = "/^[\u{4e00}-\u{9fa5}a-zA-Z0-9@。._\-\|\(\)\[\]\s\/]*$/";
		$dic = explode("\n", $arrone['dictionary']);
		//var_dump(count($dic));
		//var_dump($dic);
		//判断输入名称或字典内容是否空
		if ($arrone['name'] == NULL || $arrone['dictionary']== NULL) {
			$ret = array('code'=>'-4444','str'=>t('policy.empty_dic_name_or_dic_content'));
			echo json_encode($ret);
			return 1;
		}
		elseif (count($dic) != count(array_unique($dic))) { //判断字典内容是否有重复  
			$ret = array('code'=>'-3333','str'=>t('policy.duplicate_dic_content'));
			echo json_encode($ret);
			return 1; 
		}
		elseif(strlen($arrone['name']) > 63){
			$ret = array('code'=>'-9999','str'=>t('policy.name_length_wrong'));
			echo json_encode($ret);
			return 1;
		}
		elseif(strlen($arrone['description']) > 127){
			$ret = array('code'=>'-9999','str'=>t('policy.desc_length_wrong'));
			echo json_encode($ret);
			return 1;
		}
		elseif ($dic) {
			foreach ($dic as $v) {
				if(strlen($v) > 15){
				  $ret = array('code'=>'-99999','str'=>t('policy.dic_length_wrong'));
			      echo json_encode($ret);
			      return 1;
				}				
			}
			if(count($dic) > 50){
			$ret = array('code'=>'-88888','str'=>t('policy.dic_count_wrong'));
			echo json_encode($ret);
			return 1;
		    }
		}
		
		elseif(!preg_match($matchnamestr, $arrone['name'])){
			$ret = array('code'=>'-7777','str'=>t('policy.name_have_char'));
			echo json_encode($ret);
			return 1;
		}
		elseif(!preg_match($matchdescstr, $arrone['description'])){
			$ret = array('code'=>'-8888','str'=>t('policy.desc_have_char'));
			echo json_encode($ret);
			return 1;
		}
		else{
			return 0;
		}	
	}


}
