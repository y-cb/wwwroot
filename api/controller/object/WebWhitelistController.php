<?php
namespace controller\object;
use controller\mController;

/**
 * @api {GET}  /api/web-whitelist 获取所有白名单信息
 * @apiName 获取所有白名单信息
 * @apiGroup 认证服务器
 *
 *
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
		"total": 1, 
		"data": [
				{
					"whnode_items": {"group": [{"domain": "www.baidu.com", "regular": "www%5C.baidu%5C.com", "regular_flag": "0"}, {"domain": "www.jd.com", "regular": "www%5C.jd%5C.com", "regular_flag": "0"}, {"domain": "www.sohu.com", "regular": "www%5C.sohu%5C.com", "regular_flag": "0"}]}, "ref_num": "0", "items_num": "3", "name": "alan_white_list_test", "description": "Just a test"
				}
			]
 *	}
 */

/**
 * @api {GET}  /api/web-whitelist 获取单个白名单信息
 * @apiName 获取单个白名单信息
 * @apiGroup 认证服务器
 *
 *
 * @apiParam {String} name 白名单对象的名称
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "alan_white_list_test",
		"op":"detail"
 *	}
 *
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
		"whnode_items": "{\"group\":[{\"domain\":\"www.baidu.com\",\"regular\":\"www%5C.baidu%5C.com\",\"regular_flag\":\"0\"},{\"domain\":\"www.jd.com\",\"regular\":\"www%5C.jd%5C.com\",\"regular_flag\":\"0\"},{\"domain\":\"www.sohu.com\",\"regular\":\"www%5C.sohu%5C.com\",\"regular_flag\":\"0\"}]}", 
		"ref_num": "0", 
		"items_num": "3", 
		"name": "alan_white_list_test", 
		"description": "Just a test"
 *	}
 */

/**
 * @api {POST}  /api/web-whitelist 添加白名单对象
 * @apiName 添加白名单对象
 * @apiGroup 认证服务器
 *
 *
 * @apiParam {String} name 白名单对象的名称
 * @apiParam {String} description 白名单对象的描述
 * @apiParam {Array} whnode_items 白名单对象的详细配置对象:"id":序号 "domain":域名,
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "alan_white_list_test",
 *		"description": "Just a test",
 *		"whnode_items": [{"id":0, "domain":"www.baidu.com"}, {"id":1, "domain":"www.sohu.com"}]
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
 *		"str":"对应的错误提示信息"
 *	}
 *
 */

/**
 * @api {PUT}  /api/web-whitelist 修改白名单对象
 * @apiName 修改白名单对象
 * @apiGroup 认证服务器
 *
 *
 * @apiParam {String} name 白名单对象的名称
 * @apiParam {String} description 白名单对象的描述
 * @apiParam {Array} whnode_items 白名单对象的详细配置对象:"id":序号 "domain":域名,
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "alan_white_list_test",
 *		"description": "Just a test",
 *		"whnode_items": [{"id":0, "domain":"www.baidu.com"}, {"id":1, "domain":"www.sohu.com"}, {"id":2, "domain":"www.jd.com"}]
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
 *		"str":"对应的错误提示信息"
 *	}
 *
 */

/**
 * @api {DELETE}  /api/web-whitelist 删除白名单对象
 * @apiName 删除白名单对象
 * @apiGroup 认证服务器
 *
 *
 * @apiParam {String} name 白名单对象名称
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "alan_white_list_test"
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
 *		"str":"对应的错误提示信息"
 *	}
 *
 */


class WebWhitelistController extends mController{	
	public $module = 'web_whitelist';
	function get() {
		$param = get_inputs();

		if($param['name']) {
			$rspString = getResponse($this->module,'show_o',$param);
		} else {
			$rspString = getResponse($this->module,'show',$param);
		}
		$ret = getAssign($rspString, $this->module);
		header('Content-type: application/json');
		if (!empty($ret)) {
			if($param['name']) {
				$ret['whnode_items'] = $this->decodeItems($ret['whnode_items']);
                $data=$ret;
			} else {
				if ($ret['name']) {
					$ret['whnode_items'] = $this->decodeItems($ret['whnode_items']);
					$data['data'][] = $ret;
				} else {
					foreach ($ret as $key => $value) {
						$ret[$key]['whnode_items'] = $this->decodeItems($value['whnode_items']);
					}
					$data['data'] = $ret;					
				}
			}
			
			if (isset($ret['page'])){
				$data['total'] = (int)$ret['page']['total'];
			} else {
				$data['total'] = (int)count($data['data']);
			}
			
		}
		if (empty($ret)){
			$data['data'] = array();
			$data['total'] = 0;
		}
		echo json_encode($data);
	}

	function decodeItems($data) {
		$whnode_items = json_decode($data,true);
		$whnode_items = $whnode_items[group];

		if ($whnode_items['domain']) {
			$whnode_items['domain'] = urldecode($whnode_items['domain']);
			$whnode_items['regular'] = urldecode($whnode_items['regular']);
		} else {
			foreach ($whnode_items as $k => $v) {
				$whnode_items[$k]['domain'] = urldecode($v['domain']);
				$whnode_items[$k]['regular'] = urldecode($v['regular']);
			}
		}

		$whnode_items[group] = $whnode_items;
		return $whnode_items;
	}
}

