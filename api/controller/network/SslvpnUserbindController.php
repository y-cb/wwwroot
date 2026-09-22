<?php
namespace controller\network;
use controller\mController;

/**
 * @api {GET}  /api/sslvpn-userbind 查询sslvpn用户绑定配置信息
 * @apiName 查询sslvpn用户绑定配置信息
 * @apiGroup SSL VPN
 *
 *
 * @apiSuccess {String} username  用户名，（1-63）字符，支持中英文大小写、数字以及@。._-|()[]字符
 * @apiSuccess {String} bindip  绑定IP，例如192.168.0.100
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"username": "test",
 *			"bindip": "1.1.1.1"
 *		}
 *	],
 *	"total": 1
 *	}
 */

/**
 * @api {POST}  /api/sslvpn-userbind 新增sslvpn用户绑定配置信息
 * @apiName 新增sslvpn用户绑定配置信息
 * @apiGroup SSL VPN
 *
 *
 * @apiParam {String} username  用户名，（1-63）字符，支持中英文大小写、数字以及@。._-|()[]字符
 * @apiParam {String} bindip  绑定IP，例如192.168.0.100
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"username": "test",
 *		"bindip": "2.2.2.2"
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
 * @api {PUT}  /api/sslvpn-userbind 修改sslvpn用户绑定配置信息
 * @apiName 修改sslvpn用户绑定配置信息
 * @apiGroup SSL VPN
 *
 *
 * @apiParam {String} username  用户名，（1-63）字符，支持中英文大小写、数字以及@。._-|()[]字符
 * @apiParam {String} bindip  绑定IP，例如192.168.0.100
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"username": "test",
 *		"bindip": "3.3.3.3"
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
 * @api {DELETE}  /api/sslvpn-userbind 删除sslvpn用户绑定配置信息
 * @apiName 删除sslvpn用户绑定配置信息
 * @apiGroup SSL VPN
 *
 *
 * @apiParam {String} username  用户名，（1-63）字符，支持中英文大小写、数字以及@。._-|()[]字符
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"username": "test"
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


class SslvpnUserbindController extends mController{
	public $module = 'sslvpn_userip';
}

?>
