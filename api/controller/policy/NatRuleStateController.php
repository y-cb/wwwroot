<?php
namespace controller\policy;
use controller\mController;

/**
 * @api {GET} /api/nat  获取源NAT列表
 * @apiName 获取源NAT列表
 * @apiGroup NAT策略
 *
 * 
 * @apiSuccess {String} type 1表示静态NAT；2表示源NAT；4表示目的NAT
 * @apiSuccess {String} src_src_addr_obj 源地址
 * @apiSuccess {String} src_dst_addr_obj 目标地址
 * @apiSuccess {String} src_serv 服务的协议类型
 * @apiSuccess {String} src_ifname 出接口
 * @apiSuccess {Number} src_mapped_addr_type  转换后源地址 1表示出接口地址; 2表示地址池地址
 * @apiSuccess {String} src_pool 转换后源地址
 * @apiSuccess {Number} log 日志开关，0：禁用  1:启用
 * @apiSuccess {Number} rule_id 策略ID
 * @apiSuccess {String} desc 描述，添加对策略的描述信息
 * @apiSuccess {Number} unit_id 单元ID
 * @apiSuccess {Number} protocol 协议类型
 * @apiSuccess {Number} auto_mapped 默认值0
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data":,
 *		{	 
 *			"type": "2",
 *			"src_src_addr_obj": "source",
 *			"src_dst_addr_obj": "dest",
 *			"src_serv": "any",
 *			"src_ifname": "ge0/4",
 *			"src_mapped_addr_type": "2",
 *			"src_pool": "pool",
 *			"log": "1",
 *			"rule_id": "1",
 *			"desc": "desc",
 *			"unit_id": "1",
 *			"protocol": "1"
 *			"auto_mapped": "0"
 *		},
 *	"total": 1
 *	}
 */

/**
 * @api {POST} /api/nat 添加源NAT列表
 * @apiName 添加源NAT列表
 * @apiGroup NAT策略
 *
 *
 * @apiSuccess {String} type 1表示静态NAT；2表示源NAT；4表示目的NAT
 * @apiSuccess {String} src_src_addr_obj 源地址
 * @apiSuccess {String} src_dst_addr_obj 目标地址
 * @apiSuccess {String} src_serv 服务的协议类型
 * @apiSuccess {String} src_ifname 出接口
 * @apiSuccess {Number} src_mapped_addr_type 转换后源地址 1表示出接口地址; 2表示地址池地址
 * @apiSuccess {String} src_pool 转换后源地址
 * @apiSuccess {Number} log 日志开关，0：禁用  1:启用
 * @apiSuccess {Number} rule_id 策略ID
 * @apiSuccess {String} desc 描述，添加对策略的描述信息
 * @apiSuccess {Number} unit_id 单元ID
 * @apiSuccess {Number} protocol 协议类型
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *			"type": "2",
 *			"src_src_addr_obj": "source",
 *			"src_dst_addr_obj": "dest",
 *			"src_serv": "any",
 *			"src_ifname": "ge0/4",
 *			"src_mapped_addr_type": "2",
 *			"src_pool": "pool",
 *			"log": "1",
 *			"rule_id": "1",
 *			"desc": "desc",
 *			"unit_id": "1",
 *			"protocol": "1"
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"code":"Success!"
 *	}
 *
 * @apiErrorExample {json} Error-Response:
 *	HTTP/1.1 422 Not Found
 *	{
 *		"code":"0",
 *		"str":"Error!"
 *	}
 *
 */

/**
 * @api {PUT} /api/nat 修改源NAT策略
 * @apiName 修改源NAT策略
 * @apiGroup NAT策略 
 *
 *
 * @apiSuccess {String} type 1表示静态NAT；2表示源NAT；4表示目的NAT
 * @apiSuccess {String} src_src_addr_obj 源地址
 * @apiSuccess {String} src_dst_addr_obj 目标地址
 * @apiSuccess {String} src_serv 服务的协议类型
 * @apiSuccess {String} src_ifname 出接口
 * @apiSuccess {Number} src_mapped_addr_type 转换后源地址 1表示出接口地址; 2表示地址池地址
 * @apiSuccess {String} src_pool 转换后源地址
 * @apiSuccess {Number} log 日志开关，0：禁用  1:启用
 * @apiSuccess {Number} rule_id 策略ID
 * @apiSuccess {String} desc 描述，添加对策略的描述信息
 * @apiSuccess {Number} unit_id 单元ID
 * @apiSuccess {Number} protocol 协议类型
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *			"type": "2",
 *			"src_src_addr_obj": "source-put",
 *			"src_dst_addr_obj": "dest",
 *			"src_serv": "any",
 *			"src_ifname": "ge0/4",
 *			"src_mapped_addr_type": "2",
 *			"src_pool": "pool",
 *			"log": "1",
 *			"rule_id": "1",
 *			"desc": "desc",
 *			"unit_id": "1",
 *			"protocol": "1"
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"code":"Success!"
 *	}
 *
 * @apiErrorExample {json} Error-Response:
 *	HTTP/1.1 422 Not Found
 *	{
 *		"code":"0",
 *		"str":"Error!"
 *	}
 *
 */

/**
 * @api {DELETE} /api/nat 删除源NAT策略
 * @apiName 删除源NAT策略
 * @apiGroup NAT策略 
 *
 *
 * @apiSuccess {String} type 1表示静态NAT；2表示源NAT；4表示目的NAT
 * @apiSuccess {String} src_src_addr_obj 源地址
 * @apiSuccess {String} src_dst_addr_obj 目标地址
 * @apiSuccess {String} src_serv 服务的协议类型
 * @apiSuccess {String} src_ifname 出接口
 * @apiSuccess {Number} src_mapped_addr_type  转换后源地址 1表示出接口地址; 2表示地址池地址
 * @apiSuccess {String} src_pool 转换后源地址
 * @apiSuccess {Number} log 日志开关，0：禁用  1:启用
 * @apiSuccess {Number} rule_id 策略ID
 * @apiSuccess {String} desc 描述，添加对策略的描述信息
 * @apiSuccess {Number} unit_id 单元ID
 * @apiSuccess {Number} protocol 协议类型
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *			"type": "2",
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"code":"Success!"
 *	}
 *
 * @apiErrorExample {json} Error-Response:
 *	HTTP/1.1 422 Not Found
 *	{
 *		"code":"0",
 *		"str":"Error!"
 *	}
 *
 */


class NatRuleStateController extends mController{
	public $module = 'nat_rule_state';
}

