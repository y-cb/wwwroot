<?php
namespace controller\policy;
use controller\mController;

/**
 * @api {GET}  /api/edr-center 获取EDR中心配置
 * @apiName 获取EDR中心配置
 * @apiGroup EDR中心配置
 *
 *
 * @apiSuccess {String} central EDR管理中心地址（1.1.1.1）
 * @apiSuccess {String} tenant_admin 租户管理员用户
 * @apiSuccess {Number} enable 是否启用 1启用 0:不启用
 * @apiSuccess {Number} asset_sync 是否资产发现同步 1启用 0:不启用
 *
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data":,
 *		{
 *			"central": "1.1.1.1",
 *			"tenant_admin": "aaa",
 *			"enable": "1",
 *			"asset_sync": "1",
 *		}
 *	}
 */

/**
 * @api {PUT}  /api/edr-center 修改EDR中心配置
 * @apiName 修改EDR中心配置
 * @apiGroup EDR中心配置
 *
 *
 * 
 * @apiParam {String} central EDR管理中心地址（1.1.1.1）
 * @apiParam {String} tenant_admin 租户管理员用户
 * @apiParam {Number} enable 是否启用 1启用 0:不启用
 * @apiParam {Number} asset_sync 是否资产发现同步 1启用 0:不启用
 *
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		
 *		"central": "1.1.1.1",
 *		"tenant_admin": "aaa",
 *		"enable": "1",
 *		"asset_sync": "1",
 *	}
 *
 * @apiErrorExample {json} Error-Response:
 *	HTTP/1.1 422 Not Found
 *	{
 *		"scan_all": "1"
 *	}
 *
 */


class EdrCenterController extends mController {	
	public $module = 'edr_centre';
}
