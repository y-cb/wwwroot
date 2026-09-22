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


class DictionaryImportController extends mController{
	public $source = '/mnt/boot/user_dic.json';
	public $in_file = '/tmp/user_dic_in.json';
	public $out_file = '/tmp/user_dic.json';
	public $dic_folder = '/mnt/boot/dic/dic_';

	function get(){
		$param=get_inputs();
		$all_json = file_get_contents($this->source);
		$all_json_arr = json_decode($all_json,true);
		$json_type['dictionary'] = $all_json_arr;
		$json = json_encode($json_type,JSON_UNESCAPED_UNICODE);//导出汉字格式
		file_put_contents($this->out_file, $json);

		if( !file_exists($this->out_file) || $json_type['dictionary']==NUll){
			$ret = array('code'=>'-8888','str'=>t('policy.out_null'));
			echo json_encode($ret);
			return;

		}else{
			if ($param['log']!=false) {
				$msg='SrcIP='.$_SERVER["REMOTE_ADDR"].' UserName='.$_SESSION[CONNECTION.USERNAME].' Operate="export dictionary configuration" ManageStyle=web Content="operation success"';
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
		    header('Content-Disposition:attachment;filename= user_dic.txt');//声明作为附件处理和下载后文件的名称
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


                if (!file_exists($this->in_file)) {
					$ret = array('code'=>'-1','str'=>t('update.file_empty'));
		            echo json_encode($ret);
		            exit(0);
				}else{
					$str = file_get_contents($this->in_file);
					$in_file_arrall = json_decode($str,true);
					
					$in_file_arr = $in_file_arrall['dictionary'];
					//var_dump($in_file_arr);
					//exit;
					if($in_file_arr==NUll){

						$ret = array('code'=>'-7771','str'=>t('policy.input_file_error'));
	                	echo json_encode($ret);
	                	exit(0);
					}elseif (count($in_file_arr)>27) {
						$ret = array('code'=>'-7772','str'=>t('policy.input_file_count_error'));
	                	echo json_encode($ret);
	                	exit(0);
					}else{
						//调用函数，并更新配置文件
						self::save_json($in_file_arr);
						$msg='SrcIP='.$_SERVER["REMOTE_ADDR"].' UserName='.$_SESSION[CONNECTION.USERNAME].' Operate="import dictionary configuration" ManageStyle=web Content="operation success"';
						WriteLog::ConfigWrite($msg);
	            	}
				}
				//var_dump($in_file_arr);

				

            }else{
                $ret = array('code'=>'-50000','str'=>t('update.update_error_50000'));
                echo json_encode($ret);
            }

             // echo "ok";

        }

	}


	function check_jarrayone($arrone){  //检查是否文件有问题
		$matchnamestr = "/^[\u{4e00}-\u{9fa5}a-zA-Z0-9@。._\-\|\(\)\[\]]*$/";
		$matchdescstr = "/^[\u{4e00}-\u{9fa5}a-zA-Z0-9@。._\-\|\(\)\[\]\s\/]*$/";
		if($arrone['desc']==NUll|| $arrone['name']==NUll || $arrone['dictionary']==NUll){
			return 1;
		}
		if($arrone['desc']!=0){
			return 1;
		}
		if($arrone['lang']!= NULL){
			if($arrone['lang']!= cn && $arrone['lang']!= en){
				return 1;
			}
		}
		if ($arrone['name'] != NULL) {
			if(strlen($arrone['name']) > 31){
				return 1;
			}
			if(!preg_match($matchnamestr, $arrone['name'])){
				return 1;
			}
		}

		if ($arrone['description'] != NULL) {
			if(strlen($arrone['description']) > 127){
				return 1;
			}
			if(!preg_match($matchdescstr, $arrone['description'])){
				return 1;
			}
		}
		$dic_str = $arrone['dictionary'];
		$dic_arr = explode("\n" , $dic_str);
		if (count($dic_arr) != count(array_unique($dic_arr))) {
			return 1;
		}

		foreach ($dic_arr as $dic_value) {
			if(strlen($dic_value) > 15){
				//echo "lenth > 15";
				$wstatus = 1;
				break;
			}
		}
		if($wstatus == 1){
			return 1;
		}
			
		return 0;
		
		
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
		//var_dump($name_array);


		$need_add = 32 - count($array); //最多可加入32条，需减去已有的
		$had_add = 1;

		if(!is_dir('/mnt/boot/dic/')){ //创建存放字典的文件夹
			mkdir('/mnt/boot/dic/',0755,true);
		}

		foreach ($in_file_arr as $key => $value) {
			
			if (in_array($value['name'], $name_array)) {
				//var_dump($value['name']);
				continue;

			}else{
				$check = self::check_jarrayone($value);
				
				if($check == 1|| $had_add> $need_add || $need_add < 1){ //配置错误、已经添加大于、可添加或者可添加小于1
					break;
				}else{
					$had_add = $had_add + 1;

					file_put_contents($this->dic_folder.$value['name'], $value['dictionary']);//将字典详细内容输入字典文件dic_XXX
							
					$array[] = $value;
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
