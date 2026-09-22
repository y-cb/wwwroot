<?php
namespace controller\network;
use controller\mController;

/**
 * @api {GET}  /api/security-zone 查询安全域配置信息
 * @apiName 查询安全域配置信息
 * @apiGroup 安全域
 *
 *
 * @apiSuccess {String} name  安全域名称
 * @apiSuccess {Number} count  无意义
 * @apiSuccess {Number} filter_flux  接口间互相访问控制，0表示不启用，1表示启用
 * @apiSuccess {Array} interface  接口成员
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"name": "test",
 *			"count": "0",
 *			"filter_flux": "1",
 *			"interface": ""
 *		}
 *	],
 *	"total": 1
 *	}
 */

/**
 * @api {POST}  /api/security-zone 新建安全域配置信息
 * @apiName 新建安全域配置信息
 * @apiGroup 安全域
 *
 *
 * @apiParam {String} name  安全域名称
 * @apiParam {Number} count  无意义
 * @apiParam {Number} filter_flux  接口间互相访问控制，0表示不启用，1表示启用
 * @apiParam {Array} interface  接口成员
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *			"name": "test",
 *			"count": "0",
 *			"filter_flux": "1",
 *			"interface": ""
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
 *		"code":"2",
 *		"str":""
 *	}
 *
 */

/**
 * @api {PUT}  /api/security-zone 修改安全域配置信息
 * @apiName 修改安全域配置信息
 * @apiGroup 安全域
 *
 *
 * @apiParam {String} name  安全域名称
 * @apiParam {Number} count  无意义
 * @apiParam {Number} filter_flux  接口间互相访问控制，0表示不启用，1表示启用
 * @apiParam {Array} interface  接口成员
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *			"name": "test",
 *			"count": "0",
 *			"filter_flux": "1",
 *			"interface": "{"group": [{"ifname": "ge0/3"}, {"ifname": "ge0/4"}]}"
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
 *		"code":"1",
 *		"str":""
 *	}
 *
 */

/**
 * @api {DELETE}  /api/security-zone 删除安全域配置信息
 * @apiName 删除安全域配置信息
 * @apiGroup 安全域
 *
 *
 * @apiParam {String} name  安全域名称
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "test"
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
 *		"code":"1",
 *		"str":""
 *	}
 *
 */


class SecurityZoneController extends mController{
	public $module = 'security_region';
}

?>
