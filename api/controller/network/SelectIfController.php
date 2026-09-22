<?php
namespace controller\network;
use controller\mController;

/**
 * @api {GET}  /api/interface-select 获取接口信息
 * @apiName 获取接口信息
 * @apiGroup 接口配置
 *
 *
 * @apiSuccess {Number} get_type  类型
 * @apiSuccess {String} name  接口名称
 * @apiSuccess {String} real_name  真实接口名称
 * @apiSuccess {String} alias_name  别名
 * @apiSuccess {String} vrf_name  VRF名称
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"get_type": "0",
 *			"name": "tunl0",
 *			"real_name": "tunl0",
 *			"alias_name": "tunl0",
 *			"vrf_name": "vrf0"
 *		}
 *	],
 *	"total": 1
 *	}
 */


class SelectIfController extends mController{
	public $module = 'inf_select';
}

?>
