<?php
namespace controller\system;
use controller\mController;

/**
 * @api {GET}  /api/snmp-config 获取SNMP配置信息
 * @apiName 获取SNMP的配置信息
 * @apiGroup 系统维护
 *
 *
 * @apiSuccess {String} enable  是否使能 
 * @apiSuccess {String} trap_addr_ipv6  trap6地址
 * @apiSuccess {String} community   SNMP团体
 * @apiSuccess {String} v3_tag  v3版本
 * @apiSuccess {String} trap_addr   trap地址
 * @apiSuccess {String} location   位置
 * @apiSuccess {String} v1_tag   V1版本
 * @apiSuccess {String} v2c_tag   V2版本
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *		 "enable": "0",
 *		 "trap_addr_ipv6": "",
 *		 "community": "public",
 *		 "v3_tag": "1",
 *	       	"trap_addr": "",
 * 		"location": "",
 *		 "v1_tag": "1",
 *		 "v2c_tag": "1"
 *		},
 *	],
 *	"total": 1
 *	}
 */


/**
 * @api {PUT}  /api/snmp-config 配置SNMP
 * @apiName 配置SNMP
 * @apiGroup 系统维护
 *  
 *
 *
 * @apiParamExample {json} Request-Example:
 *      {
 *	  "enable": "0",
 *        "trap_addr_ipv6": "",
 *        "community": "public",
 *        "v3_tag": "1",
 *        "trap_addr": "172.16.0.12",
 *        "location": "aa",
 *        "v1_tag": "1",
 *        "v2c_tag": "1"
 *      }
 *
 * @apiSuccessExample {json} Success-Response:
 *      HTTP/1.1 200 OK
 *      {
 *      }
 *
 * @apiErrorExample {json} Error-Response:
 *      HTTP/1.1 422 Not Found
 *      {
 *      }
 *
 *
 */


class SNMPConfigController extends mController{	
	public $module = 'snmp_config';
}

