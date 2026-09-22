<?php
namespace controller\network;
use controller\mController;

/**
 * @api {GET}  /api/interface-p2p 获取接口列表
 * @apiName 获取当前vsys下的p2p接口列表
 * @apiGroup 接口列表获取
 *
 *
 * @apiSuccess {String} vrf_name  VRF名称
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"name": "ge0/2",
			"real_name": "ge0/2",
			"alias_name": "ge0/2"
 *		},
 *		{
 *			"name": "tunl0",
			"real_name": "tunl0",
			"alias_name": "tunl0"
 *		}
 *	],
 *	"total": 2
 *	}
 */

/**
 * @api {POST}  /api/interface-p2p 不支持POST操作
 * @apiName XXX 此处替换为对Post方法的解释
 * @apiGroup 接口列表获取
 *
 */


class InterfaceP2PController extends mController{
	public $module = 'p2p_if';
}

?>
