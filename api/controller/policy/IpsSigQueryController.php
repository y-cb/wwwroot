<?php
namespace controller\policy;
use controller\mController;

/**
 * @api {POST}  /api/ips-sig-query 将预定义事件集添加入侵防护事件集
 * @apiName ips-sig-query
 * @apiGroup 预定义事件集添加入侵防护事件集
 *
 *
 * @apiParam {String} mode_name 事件集名称
 * @apiParam {Number} mode 添加模式，固定为3
 * @apiParam {String} set_name 入侵防护事件集名称
 * @apiParam {Array} member 成员
 * @apiParam {Number} id 添加成员序列号，从0开始
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"set_name": "test",
 *		"mode": "3",
 *		"member": [
 *			{
 *				"id": "0",
 *				"mode_name": "BufferOverflow"
 *			},
 *			{
 *				"id": "1",
 *				"mode_name": "DoS"
 *			}
 *		]
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

class IpsSigQueryController extends mController {
	public $module = 'ips_sig_node';
	public $set_module = 'ips_set_node';

	function post() {
		$param = get_inputs();
		$sig_array = $param['sig_member'];

		if ($param['set_member'] && !empty($param['set_member'])) {
			$data = $param['query'];
			unset($data['op']);
			if (!$sig_array || empty($sig_array)) {
				$sig_array = array();
			}

			foreach ($param['set_member'] as $value) {
				$data['mode_name'] = $value['mode_name'];
				$rspString = getResponse($this->set_module, 'show', $data);
				$ret = getAssign($rspString, $this->set_module);

				if (empty($ret)) {
					continue;
				}

				if ($ret['sig_id']) {
					$sig_array[]['sig_id'] = $ret['sig_id'];
				} else {
					foreach ($ret as $val) {
						$sig_array[]['sig_id'] = $val['sig_id'];
					}
				}
			}
		}

		$list = [
			'set_name' => $param['set_name'],
			'mode' => 0,
			'member' => $sig_array 
		];

		$rspString = getResponse($this->module, 'add', $list);
		$ret = getAssign($rspString, $this->module);

		if ($ret['code']) {
			echo json_encode($ret);
		}

	}

	function get() {

	}

	function put() {

	}

	function delete() {

	}
}

?>
