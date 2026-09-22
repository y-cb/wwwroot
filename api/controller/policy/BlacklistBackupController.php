<?php
namespace controller\policy;
use controller\Controller;
use message\MainModel;
use lib\ExportCnf;
use lib\Json2Txt;

/**
 * @api {GET}  /api/blacklist-backup 黑名单导出
 * @apiName 黑名单导出
 * @apiGroup 防护策略
 *
 *
 * @apiSuccess {String} file base64序列化字符串
 * @apiParam {String} type 导出类型，blist代表黑名单
 *
 * @apiParamExample {json} RequestExample:
 *	{
 *		"type": "blist"  
 *	}
 *
 * @apiSuccessExample {Srting} SuccessResponse:
 *	HTTP/1.1 200 OK
 *  {
 *		Ymxpc3QgYWRkIDIuMi4zLjQ1IGFnZSBmb3JldmVyDQoNCg==
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
 * @api {POST}  /api/blacklist-backup 黑名单导入
 * @apiName 黑名单导入
 * @apiGroup 防护策略
 *
 *
 * @apiParam {String} file 地址对象文件内容，需用base64序列化，并在字符串前添加data:text/plain;base64 内容拼接
 *
 * @apiParamExample {json} RequestExample:
 *	{
 *			"file": "data:text/plain;base64,Ymxpc3QgYWRkIDIuMi4zLjQ1IGFnZSBmb3JldmVyDQoNCg=="  
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

class BlacklistBackupController {	
	function get(){
		$type = $_GET['type'];
		$config_data = ExportCnf::export($type);
		echo base64_encode($config_data);
        exit(0);
	}
	function post(){
		$file = $_POST['file'];
		$file_base64 = preg_replace('/data:.*;base64,/i', '', $file);  
    	$file_base64 = base64_decode($file_base64);
		$tmpfname = tempnam("/tmp", "tmpsysconf");
    	$handle = fopen($tmpfname, "w");
    	fwrite($handle, $file_base64);
		fclose($handle);
		$res = MainModel::updateConfig("BLIST_OBJ_IN", $tmpfname);
		$code = $res['code'];
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