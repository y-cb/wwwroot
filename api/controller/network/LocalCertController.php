<?php
namespace controller\network;
use controller\mController;

/**
 * @api {GET}  /api/local-cert 获取证书策略
 * @apiName 获取IPsecIKE策略
 * @apiGroup IPsec-VPN
 *
 *
 * @apiSuccess {String} local_cert_name 证书名称
 * @apiSuccess {Number} local_cert_state 证书状态，1表示启用，0表示禁用
 * @apiSuccess {Number} local_cert_locate 证书位置
 * @apiSuccess {Number} local_cert_type 证书类型
 * @apiSuccess {String} subject 证书描述
 * @apiSuccess {Number} ref 证书引用
 * @apiSuccess {String} issuer  发行者信息
 * @apiSuccess {String} start_time  有效起始
 * @apiSuccess {String} end_time  有效终止
 * @apiSuccess {Number} version  版本
 * @apiSuccess {String} serial_num  序列号
 * @apiSuccess {String} ext_info  扩展  
 * 
 * @apiParamExample {json} Request-Example:
 *	{
 *		"op": "detail",
 *		"local_cert_type": "0",
 *		"local_cert_name": "root"
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *  HTTP/1.1 200 OK
 *   {
 *   "data": [
 *       {
 *           "local_cert_name": "default",
 *           "local_cert_state": "1",
 *           "local_cert_locate": "0",
 *           "local_cert_type":"0",
 *           "subject": "C=CN,ST=BJ,O=AD,OU=AD,CN=ADC",
 *           "subject": "1",
 *		},
 *       {
 *           "local_cert_name": "root",
 *           "local_cert_state": "1",
 *           "local_cert_locate": "0",
 *           "local_cert_type":"0",
 *           "subject": "C=CN,ST=BJ,O=AD,OU=AD,CN=ADC",
 *           "subject": "1",
 *       }
 *	],
 *	"total": 1
 *   }
 */
 
 
 /**
 * @api {DELETE}  /api/local-cert 获取证书策略
 * @apiName 获取IPsecIKE策略
 * @apiGroup IPsec-VPN
 *
 *
 * @apiParam {String} local_cert_name  证书名称
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"local_cert_name": "default"
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *	}
 *
 * @apiErrorExample {json} Error-Response:
 *	HTTP/1.1 422 Not Found
 *	{
 *		"code":"383"
 *	}
 *
 */

class LocalCertController extends mController{
	public $module = 'pki_local_cert_info';
}

?>
