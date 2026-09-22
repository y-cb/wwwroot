<?php
namespace controller\policy;
use controller\mController;

/**
 * @api {PUT} /api/policy-state 修改镜像策略状态
 * @apiName 修改镜像策略状态
 * @apiGroup 防火墙策略
 *
 *
 * @apiParam {Number} id  策略ID
 * @apiParam {Number} protocol  协议类型，1表示ipv4，2表示ipv6
 * @apiParam {Number} enable  是否启用策略，0表示不启用，1表示启用
 * @apiParam {Number} clear_statistic  是否重置统计次数，0表示不启用，1表示启用 （暂时保留）
 * @apiParam {String} vrf_name  vrf名称
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"id": "2",
 *		"protocol": "1",
 *		"enable": "1",
 *		"vrf_name": ""
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"code":""
 *	}
 *
 * @apiErrorExample {json} Error-Response:
 *	HTTP/1.1 422 Not Found
 *	{
 *		"code":"87"
 *	}
 *
 */

class MirrorPolicyStateController extends mController{
	public $module = 'mirror_policy_state';
}

?>
