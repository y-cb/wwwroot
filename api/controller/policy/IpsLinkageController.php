<?php
namespace controller\policy;
use controller\mController;

/**
 * @api {GET}  /api/idp-linkage 获取IPS设备联动配置
 * @apiName idp-linkage
 * @apiGroup 防护策略
 *
 *
 * @apiSuccess {String} username 联动设备用户名
 * @apiSuccess {String} password 联动设备密码
 * @apiSuccess {String} ip 联动设备ip
 * @apiSuccess {Number} port 联动端口，固定8888
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data":,
 *		{
 *			"username": "admin",
 *			"password": "admin",
 *			"ip": "172.16.0.99",
 *			"port": "8888"
 *		}
 *	}
 */
 
/**
 * @api {PUT}  /api/idp-linkage 修改IPS设备联动配置
 * @apiName idp-linkage
 * @apiGroup 策略
 *
 * @apiParam {String} username 联动设备用户名
 * @apiParam {String} password 联动设备密码
 * @apiParam {String} ip 联动设备ip
 * @apiParam {Number} port 联动端口，固定8888
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *	"data":,
 *       {
 *			"username": "admin",
 *			"password": "admin",
 *			"ip": "172.16.0.99",
 *			"port": "8888"
 *       }
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


class IpsLinkageController extends mController {
	public $module = 'idp_linkage';
}

?>
