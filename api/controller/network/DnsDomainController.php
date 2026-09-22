<?php
namespace controller\network;
use controller\mController;

/**
 * @api {GET} /api/dns-proxy 获取DNS代理
 * @apiName 获取DNS代理
 * @apiGroup DNS
 *
 *
 * @apiSuccess {Number} enable  DNS代理启用状态 1：开启 0：关闭
 * @apiSuccess {String} master  DNS代理主服务器ipv4地址
 * @apiSuccess {String} hm_master  DNS代理主服务器健康检查对象
 * @apiSuccess {String} backup  DNS代理备服务器ipv4地址
 * @apiSuccess {String} hm_backup  DNS代理备服务器健康检查对象
 * @apiSuccess {Array} ipbind  DNS服务器监听ipv4地址数组
 * @apiSuccess {String} ip  DNS服务器监听ipv4地址
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"enable": "1",
 *		"master": "1.1.1.1",
 *		"hm_master": "health_check_master",
 *		"backup": "2.2.2.2",
 *		"hm_backup": "health_check_backup",
 *		"ipbind": [
 *		{
 *			"ip": "172.16.0.123",
 *		},
 *		{
 *			"ip": "192.168.1.1",
 *		}
 *		],
 *		"total": 2
 *	}
 */

/**
 * @api {put} /api/dns-proxy 修改DNS代理
 * @apiName 修改DNS代理
 * @apiGroup DNS
 *
 * @apiParam {Number} enable  DNS代理启用状态 1：开启 0：关闭
 * @apiParam {String} master  DNS代理主服务器ipv4地址
 * @apiParam {String} hm_master  DNS代理主服务器健康检查对象
 * @apiParam {String} backup  DNS代理备服务器ipv4地址
 * @apiParam {String} hm_backup  DNS代理备服务器健康检查对象
 * @apiParam {Array} ipbind  DNS服务器监听ipv4地址数组
 * @apiParam {String} ip  DNS服务器监听ipv4地址
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"enable": "1",
 *		"master": "1.1.1.1",
 *		"hm_master": "health_check_master",
 *		"backup": "2.2.2.2",
 *		"hm_backup": "health_check_backup",
 *		"ipbind": [
 *		{
 *			"ip": "172.16.0.123",
 *		},
 *		{
 *			"ip": "192.168.1.1",
 *		}
 *		],
 *		"total": 2
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
 *		"code":"-1",
 *		"str":""
 *	}
 *
 */

class DnsDomainController extends mController{
	public $module = 'dns_domain';
}

?>
