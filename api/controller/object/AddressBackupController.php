<?php
namespace controller\object;
use controller\Controller;
use message\MainModel;
use lib\ExportCnf;
use lib\Json2Txt;

/**
 * @api {GET}  /api/address-backup 地址对象导出
 * @apiName 地址对象导出
 * @apiGroup 备份恢复
 *
 *
 * @apiParam {String} type 导出类型，addr代表地址对象
 *
 *	
 * @apiSuccess {String} file base64序列化字符串
 *
 *
 * @apiSuccessExample {Srting} SuccessResponse:
 *	HTTP/1.1 200 OK
 *  {
 *		YWRkcmVzcyB0ZXN0DQogaG9zdC1hZGRyZXNzIDE3Mi4xNi4wLjANCg==
 *  }
 *
 *
 * @apiErrorExample {json} ErrorResponse:
 *	HTTP/1.1 422 Not Found
 *	{
 *		"code":"非0"
 *	}
 */

/**
 * @api {POST}  /api/address-backup 地址对象导入
 * @apiName 地址对象导入
 * @apiGroup 备份恢复
 *
 *
 * @apiParam {String} file 地址对象文件内容，需用base64序列化，并在字符串前添加data:text/plain;base64 内容拼接
 *
 * @apiParamExample {json} RequestExample:
 *	{
 *			"file": "data:text/plain;base64,YWRkcmVzcyB0ZXN0DQogaG9zdC1hZGRyZXNzIDE3Mi4xNi4wLjANCg=="  
 *	}
 * @apiSuccessExample {string} SuccessResponse:
 *	HTTP/1.1 200 OK
 *  {
 *		ok
 *	}
 *
 * @apiErrorExample {json} ErrorResponse:
 *	HTTP/1.1 422 Not Found
 *	{
 *		"code":"非0"
 *	}
 */

class AddressBackupController {
	private $dog_food = '/tmp/webserver.escape';
	function get(){
		$type = $_GET['type'];
		$config_data = ExportCnf::export($type);
		echo base64_encode($config_data);
        exit(0);
	}
	function post(){

		if (!file_exists($this->dog_food)) {
			@file_put_contents($this->dog_food, time());
		}
		$file = $_POST['file'];
		//preg_match无法对字段较长的数据进行正则处理
		$stra = substr($file, 0, 200);
		$strb = substr($file, 200, strlen($file));

		$cstra = preg_replace('/data:.*;base64,/i', '', $stra);
		$file_base64 = $cstra . $strb;
    	$file_base64 = base64_decode($file_base64);

		$tmpfname = tempnam("/tmp", "tmpsysconf");
    	$handle = fopen($tmpfname, "w");
    	fwrite($handle, $file_base64);
		fclose($handle);
		$res = MainModel::updateConfig("ADDR_OBJ_IN", $tmpfname);
		$code = $res['code'];

		if (file_exists($this->dog_food)) {
			unlink($this->dog_food);
		}
		if ($code == 0) {
			echo "ok";
		} else {
			if($code>0){
				$code = $code*(1);
			}
			$ret = array('code'=>$code,'str'=>$res["str"]);
			echo json_encode($ret);
		}
		unlink($tmpfname);
	}
}
