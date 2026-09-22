<?php
namespace controller\object;
use controller\mController;

/**
 * @api {GET} /api/health-check 获取健康检查
 * @apiName 获取健康检查
 * @apiGroup 健康检查
 *
 *
 * @apiParam {Number} real_ip_type 目标IP地址类型，固定值0
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"real_ip_type": "0"
 *	} 
 *
 * @apiSuccess {String} template_name 名称
 * @apiSuccess {Number} ref 引用计数
 * @apiSuccess {Number} type 类型
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *	 		"template_name": "asd",
 *			"ref": "0",
 *			"type": "0"
 *		}, 
 *		{
 *	 		"template_name": "abcd",
 *			"ref": "0",
 *			"type": "0"
 *		}
 *		]
 *		"total": 2, 
 *	}
 *
 *
 * @apiParam {Number} template_name 名称
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"template_name": "asd"
 *	} 
 *
 * @apiSuccess {String} template_name 名称
 * @apiSuccess {Number} type 类型
 * @apiSuccess {Number} interval 间隔
 * @apiSuccess {Number} maxretrys 最大重试次数
 * @apiSuccess {Number} delay 平均延迟
 * @apiSuccess {Number} packetloss 丢包率
 * @apiSuccess {Number} samplerange 质量采样范围
 * @apiSuccess {Number} timeout 超时时间
 * @apiSuccess {Number} real_ip_type 目标IP地址类型
 * @apiSuccess {String} real_ip 目标IP
 * @apiSuccess {Number} real_port 目标端口
 *
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"template_name": "asd",
 *		"type": "0",
 *		"interval": "16",
 *		"maxretrys": "3",
 *		"delay": "",
 *		"packetloss": "",
 *		"samplerange": "10",
 *		"timeout": "5",
 *		"real_ip": "10.1.1.1",
 *		"real_ip_type": "1",
 *		"real_ip_port": ""
 *	} 
 *
 */

/**
 * @api {POST} /api/health-check 添加健康检查
 * @apiName 添加健康检查
 * @apiGroup 健康检查
 *
 *
 * @apiParam {String} template_name 名称
 * @apiParam {Number} type 类型：0代表icmp，1代表udp，3代表tcp，half open 8代表dns
 * @apiParam {Number} interval 间隔
 * @apiParam {Number} maxretrys 最大重试次数
 * @apiParam {Number} timeout 超时时间
 * @apiParam {Number} samplerange 质量采样范围
 * @apiParam {Number} real_ip_type 目标IP地址类型：1代表ipv4，2代表ipv6
 * @apiParam {Number} delay 平均延迟
 * @apiParam {Number} packetloss 丢包率
 * @apiParam {String} real_ip 目标IP
 *
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"template_name": "admin",
 *		"type": "0",
 *		"interval": "0",
 *		"maxretrys": "3",
 *		"timeout": "5",
 *		"samplerange": "10",
 *		"real_ip_type": "1",
 *      "delay": "50",
 *		"packetloss": "35",
 *		"real_ip": "1.2.3.4",
 *		"real_ip_v6": ""
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"code": "0"
 *	}
 *
 * @apiErrorExample {json} Error-Response:
 *	HTTP/1.1 422 Not Found
 *	{
 *		"code": "非0",
 *		"str": ""
 *	}
 *
 */

/**
 * @api {PUT} /api/health-check 修改健康检查
 * @apiName 修改健康检查
 * @apiGroup 健康检查
 *
 *
 * @apiParam {String} template_name 名称
 * @apiParam {Number} type 类型：0代表icmp，1代表udp，3代表tcp，half open 8代表dns
 * @apiParam {Number} interval 间隔
 * @apiParam {Number} maxretrys 最大重试次数
 * @apiParam {String} delay 平均延迟
 * @apiParam {String} packetloss 丢包率
 * @apiParam {Number} samplerange 质量采样范围
 * @apiParam {Number} timeout 超时时间
 * @apiParam {Number} real_ip 目标IP
 * @apiParam {Number} real_ip_type 目标IP地址类型
 * @apiParam {Number} real_ip_v6 目标IPV6地址类型
 *
 *
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"template_name": "cccccc",
 *		"type": "0",
 *		"interval": "16",
 *		"maxretrys": "3",
 *		"delay": "",
 *		"packetloss": "",
 *		"samplerange": "10",
 *		"timeout": "5",
 *		"real_ip": "10.1.1.10",
 *		"real_ip_type": "1",
 *		"real_ip_v6": "",
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"code": "0"
 *	}
 *
 * @apiErrorExample {json} Error-Response:
 *	HTTP/1.1 422 Not Found
 *	{
 *		"code": "非0"，,
 *		"str": ""
 *	}
 *
 */

/**
 * @api {DELETE} /api/health-check 删除健康检查
 * @apiName 删除健康检查
 * @apiGroup 健康检查
 *
 *
 * @apiParam {String} template_name  名称
 *
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"template_name": "admin"
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"code": "0"
 *	}
 *
 * @apiErrorExample {json} Error-Response:
 *	HTTP/1.1 422 Not Found
 *	{
 *		"code": "非0"，,
 *		"str": ""
 *	}
 *
 */


class HealthcheckController extends mController {	
	public $module = 'healthcheck';
}