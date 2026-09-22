<?php
namespace controller\network;
use controller\mController;

/**
 * @api {GET}  /api/interface-tb 获取接口列表
 * @apiName 根据传入的参数（type：如“route”）获取需要的接口列表
 * @apiGroup 接口列表获取
 *
 *
 * @apiSuccess {String} vlan_name  接口名称
 * @apiSuccess {String} type  需要的接口的类型
 * @apiSuccess {String} vrf_name  属于的vrf名称（现在未使用）
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"vlan_name": "test"
 *		},
 *		{
 *			"vlan_name": "ge0/0"
 *		}
 *	],
 *	"total": 2
 *	}
 */

/**
 * @api {PUT}  /api/interface-tb 不支持PUT操作
 * @apiName XXX 此处替换为对Put方法的解释
 * @apiGroup 接口列表获取
 *
 */


class InterfaceTbController extends mController{
	public $module = 'tb_interface';
}

?>
