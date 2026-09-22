<?php
namespace controller\policy;
use controller\mController;

/**
 * @api {GET}  /api/app-whitelist-url 获取URL白名单
 * @apiName app-whitelist-url
 * @apiGroup 应用策略
 *
 * @apiSuccess {Number} enable 使能状态
 * @apiSuccess {Number} type 使能状态，1代表URL前缀白名单，2代表URL后缀白名单
 * @apiSuccess {Array} item URL数组
 * @apiSuccess {String} url URL
 *
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 * 			"enable": "1",
 * 			"type": "1",
 * 			"item": [
 *			{
 *				"url": "baidu"
 *			},
 *			{
 *				"url": "www.qq"
 *			}
 *			]
 *		}
 *		{
 * 			"enable": "1",
 * 			"type": "2",
 * 			"item": [
 *			{
 *				"url": "update1.jiangmin.com"
 *			},
 *			{
 *				"url": "cn1h.kaspersky-labs.com"
 *			}
 *			]
 *		}
 *	],
 *	}
 */


/**
 * @api {PUT}  /api/app-whitelist-url 修改URL白名单
 * @apiName app-whitelist-url
 * @apiGroup 应用策略
 *
 *
 * @apiParam {Number} suffix_enable 后缀使能状态
 * @apiParam {Number} prefix_enable 前缀使能状态
 * @apiParam {Array} suffix 前缀URL数组
 * @apiParam {Array} prefix 后缀URL数组
 *
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *			"suffix_enable": "1",
 *			"prefix_enable": "1",
 * 			"suffix": ["org","com"],
 *			"prefix": ["baidu","www.qq"]
 *	}
 *
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

class AppWhitelistUrlController extends mController {	
	public $module = 'xml_url_whitelist';
	public $path = '/usr/share/data/url_suffix_list.txt';
	function put(){
		$param = get_inputs();
		if(isset($param['default'])){
			$text = file_get_contents($this->path);
			if ($text) {
				$url_arr = explode("\n",$text);
			}
			if (!empty($url_arr)) {
				foreach ($url_arr as $v) {
					if ($v) {
						$suffix_tmp[]['url'] = trim($v);
					}
				}
			}
			$param['enable'] = 1;
			$param['type'] = 2;
			$param['item'] = $suffix_tmp;
			$rspString = getResponse($this->module, "mod", $param);
			$ret = getAssign($rspString,$this->module);
			if ($ret[code]) {
				$ret = array('code'=>$ret[code],'str'=>$ret[str]);
				echo json_encode($ret);
				exit(0);
			}else{
				echo "ok";
			}
		}else{
			$param_suffix['enable'] = $param['suffix_enable'];
			$tmp_suffix = $param['suffix'];
			foreach($tmp_suffix as $key){
				$suffix_url[]['url'] = trim($key);
			}
			$param_suffix['item'] = $suffix_url;
			$param_suffix['type'] = 2;

			$param_prefix['enable'] = $param['prefix_enable'];
			$tmp_prefix = $param['prefix'];
			foreach($tmp_prefix as $key){
				$prefix_url[]['url'] = trim($key);
			}
			$param_prefix['item'] = $prefix_url;
			$param_prefix['type'] = 1;

			$rspString1 = getResponse($this->module,"mod",$param_suffix);
			$ret1 = getAssign($rspString1,$this->module);
			if ($ret1[code]) {
				$ret1 = array('code'=>$ret1[code],'str'=>$ret1[str]);
				echo json_encode($ret1);
				exit(0);
			}
			$rspString2 = getResponse($this->module,"mod",$param_prefix);
			$ret2 = getAssign($rspString2,$this->module);
			if ($ret2[code]) {
				$ret = array('code'=>$ret2[code],'str'=>$ret2[str]);
				echo json_encode($ret);
				exit(0);
			}

		}
		
	}
}
