<?php
namespace controller\system;
use controller\Controller;



/**
 * @api {get}  /api/capture 获取抓包列表
 * @apiName 获取抓包列表
 * @apiGroup 抓包工具
 *
 *
 *
 * @apiSuccessExample {json} Success-Response:
 *  HTTP/1.1 200 OK
	{
	    "data": [
	        {
	            "size": "8.75 KB",
	            "name": "capture_file_0.cap",
	            "time": "Tue Mar 13 14:39:15 2018\n",
	            "path": "/tmp/capture_file_0.cap"
	        },
	        {
	            "size": "10.79 KB",
	            "name": "capture_file_1.cap",
	            "time": "Tue Mar 13 18:43:45 2018\n",
	            "path": "/tmp/capture_file_1.cap"
	        }
	    ]
	}
 */

/**
 * @api {delete}  /api/capture 删除包文件
 * @apiName 删除包文件
 * @apiGroup 抓包工具
 *
 *
 * @apiSuccess {String} name 包文件名称
 *
 */

class CaptureController extends Controller {	
	public $module = 'capture_file';
	function get(){
		$name = $_GET['name'];
		//$vsys_id = $_SERVER['VSYSID'];
		if ($name){
			$vsys_id_data = getResponse('vsys_switch_ui','show','');
			$vsys_id_data = getAssign($vsys_id_data,'vsys_switch_ui');
			$vsys_id = $vsys_id_data['vsysid'];
			
			$path = '/tmp/' . $vsys_id.'/'.$name;
			if (preg_match('/^[a-zA-Z0-9_]+\.(cap|CAP)$/', $name)) {
				$file_size = filesize($path);
				$data = file_get_contents($path);
			}

			Header("Content-type: application/octet-stream");
			Header("Accept-Ranges: bytes"); 
			Header("Accept-Length:".$file_size); 
			// Header($contTypeArr[$filetype].' charset=utf-8');
			Header('Content-Disposition: attachment;filename="'.$name.'"');
			Header('Cache-Control: max-age=0'); 
			echo $data;
		} else {
			$data = getResponse($this->module,'show','');
			$data = getAssign($data,$this->module);
			if ($data['name'] && $data['size'] && $data['time'] && $data['path']) {
				$list['data'][] = $data;
			} else {
				$list['data'] = $data;
			}
			echo json_encode($list);	
		}
		return;
	}
	/*function delete(){
		$param['name'] = $_GET['name'];
		if ($param['name']){
			$rtn = getResponse($this->module,'del',$param);			
		} else {
			$rtn = getResponse($this->module,'del');
		}

		$response = getAssign($rtn,$this->module);
		if ($response){
			echo json_encode($response);
		}
		return;
	}*/

}
