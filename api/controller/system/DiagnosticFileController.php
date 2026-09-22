<?php
namespace controller\system;
use controller\Controller;


/**
 * @api {get}  /api/diagnostic-file 导出诊断信息
 * @apiName 导出诊断信息
 * @apiGroup 抓包工具
 *
 * @apiParam {String} name 包文件名称
 *
 * @apiSuccess {String} base64加密字符串
 *
 */

class DiagnosticFileController extends Controller {	
	public $module = 'diag_infomation_collect';
	function get(){
		$param = get_inputs();
		$rspString = getResponse($this->module, "show" ,$param);
		$ret = getAssign($rspString, $this->module);
		if($ret["diag_get"]=="1"){
			$path = '/mnt/diag/diag.txt';
			$data = file_get_contents($path);
			echo base64_encode($data);
			return;
		}else{
			$err = array('code'=>1,'str'=>"wrong");
			echo json_encode($err);
			exit(0);
		}		
	}
}
