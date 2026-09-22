<?php
namespace controller\system;
use controller\mController;

/**
 * @api {GET} /api/sys-vrrp 获取VRRP配置
 * @apiName 获取VRRP配置
 * @apiGroup VRRP
 *
 *
 * @apiSuccess {String} ifname  接口名称
 * @apiSuccess {Number} vrid  虚拟路由ID
 * @apiSuccess {String} vmac  虚拟MAC
 * @apiSuccess {Number} is_address_owner  IP合法
 * @apiSuccess {Number} vrt_state  vrrp状态
 * @apiSuccess {String} master_ip  主备IP
 * @apiSuccess {Number} master_prio  主备优先级
 * @apiSuccess {Number} enabled  启用（1表示启用，0表示不启用）
 * @apiSuccess {String} desc  描述
 * @apiSuccess {Number} version  VRRP 版本（0表示V2，1表示V3）
 * @apiSuccess {Number} priority  优先级
 * @apiSuccess {Number} preempt_enabled  抢占模式启用（1表示启用，0表示不启用）
 * @apiSuccess {Number} preempt_delay  抢占延迟
 * @apiSuccess {Number} accept_enabled  是否可 ping （1表示可 ping ，0表示不可 ping）
 * @apiSuccess {Number} adver_interval  通告间隔时间
 * @apiSuccess {Number} auth_type  认证模式  （0表示无认证模式 ，1表示Text认证模式 ，2表示MD5认证模式）
 * @apiSuccess {String} auth_data  认证秘钥
 * @apiParam {Array} vip_list  虚拟IP列表
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"ifname": "ge0/1",
 *			"vrid": "3",
 *			"vmac": "00:00:5E:00:01:03",
 *			"is_address_owner": "0",
 *			"vrt_state": "0",
 *			"master_ip": "0.0.0.0",
 *			"master_prio": "0",
 *			"enabled": "1",
 *			"desc": "ccc",
 *			"version": "1",
 *			"priority": "111",
 *			"preempt_enabled": "1",
 *			"preempt_delay": "11",
 *			"accept_enabled": "1",
 *			"adver_interval": "60",
 *			"auth_type": "0",
 *			"auth_data": "",
 *			"vip_list": "{"group": {"vip": "3.3.3.6"}}"
 *		},
 *		{
 *			"ifname": "ge0/3",
 *			"vrid": "6",
 *			"vmac": "00:00:5E:00:01:06",
 *			"is_address_owner": "0",
 *			"vrt_state": "0",
 *			"master_ip": "0.0.0.0",
 *			"master_prio": "0",
 *			"enabled": "1",
 *			"desc": "vvvvvv",
 *			"version": "0",
 *			"priority": "100",
 *			"preempt_enabled": "1",
 *			"preempt_delay": "1",
 *			"accept_enabled": "1",
 *			"adver_interval": "100",
 *			"auth_type": "1",
 *			"auth_data": "111111",
 *			"vip_list": "{"group": {"vip": "12.12.12.11"}}"
 *		}
 *	],
 *	"total": 2
 *	}
 */

/**
 * @api {POST} /api/sys-vrrp 添加VRRP配置
 * @apiName 添加VRRP配置
 * @apiGroup VRRP
 *
 *
 * @apiParam {String} ifname  接口名称
 * @apiParam {Number} vrid  虚拟路由ID（范围：1-255）
 * @apiParam {String} vmac  虚拟MAC，无需填写，由虚拟路由ID自动生成
 * @apiParam {Number} is_address_owner  IP合法
 * @apiParam {Number} vrt_state  vrrp状态
 * @apiParam {String} master_ip  主备IP
 * @apiParam {Number} master_prio  主备优先级
 * @apiParam {Number} enabled  启用（1表示启用，0表示不启用）
 * @apiParam {String} desc  描述
 * @apiParam {Number} version  VRRP 版本（0表示V2，1表示V3）
 * @apiParam {Number} priority  优先级（范围：1-254）
 * @apiParam {Number} preempt_enabled  抢占模式启用（1表示启用，0表示不启用）
 * @apiParam {Number} preempt_delay   抢占延迟（范围：0-255）
 * @apiSuccess {Number} adver_interval  通告间隔时间（范围：20-25500）
 * @apiParam {Number} accept_enabled  是否可 ping （0表示不可 ping，1表示可 ping）
 * @apiParam {Number} auth_type  认证模式（0表示无认证模式 ，1表示Text认证模式 ，2表示MD5认证模式）
 * @apiParam {String} auth_data  认证秘钥（长度：1-8）（当认证模式为0时，无需填写）
 * @apiParam {Array} vip_list  虚拟IP列表
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"ifname": "ge0/1",
 *		"vrid": "3",
 *		"is_address_owner": "0",
 *		"vrt_state": "0",
 *		"enabled": "1",
 *		"desc": "ccc",
 *		"version": "0",
 *		"priority": "111",
 *		"preempt_enabled": "1",
 *		"preempt_delay": "11",
 *		"accept_enabled": "1",
 *		"adver_interval": "60",
 *		"auth_type": "1",
 *		"auth_data": "666666",
 *		"vip_list[0][vip]": "3.3.3.6"
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
 *		"code":"459",
 *		"str":"VRID\u91cd\u590d\u7684\u5907\u4efd\u7ec4"
 *	}
 *
 */

/**
 * @api {PUT} /api/sys-vrrp 修改VRRP配置
 * @apiName 修改VRRP配置
 * @apiGroup VRRP
 *
 *
 * @apiParam {String} ifname  接口名称
 * @apiParam {Number} vrid  虚拟路由ID
 * @apiParam {String} vmac  虚拟MAC，无需填写，由虚拟路由ID自动生成
 * @apiParam {Number} is_address_owner  IP合法
 * @apiParam {Number} vrt_state  vrrp状态
 * @apiParam {String} master_ip  主备IP
 * @apiParam {Number} master_prio  主备优先级
 * @apiParam {Number} enabled  启用（1表示启用，0表示不启用）
 * @apiParam {String} desc  描述
 * @apiParam {Number} version  VRRP 版本（0表示V2，1表示V3）不允许修改
 * @apiParam {Number} priority  优先级
 * @apiParam {Number} preempt_enabled  抢占模式启用（1表示启用，0表示不启用）
 * @apiParam {Number} preempt_delay   抢占延迟
 * @apiSuccess {Number} adver_interval  通告间隔时间
 * @apiParam {Number} accept_enabled  是否可 ping （1表示可 ping ，0表示不可 ping）
 * @apiParam {Number} auth_type  认证模式  （0表示无认证模式 ，1表示Text认证模式 ，2表示MD5认证模式）
 * @apiParam {String} auth_data  认证秘钥
 * @apiParam {Array} vip_list  虚拟IP列表
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *			"ifname": "ge0/2",
 *			"vrid": "3",
 *			"is_address_owner": "0",
 *			"vrt_state": "0",
 *			"master_ip": "0.0.0.0",
 *			"master_prio": "0",
 *			"enabled": "1",
 *			"desc": "ccc",
 *			"priority": "111",
 *			"preempt_enabled": "1",
 *			"preempt_delay": "11",
 *			"accept_enabled": "1",
 *			"adver_interval": "60",
 *			"auth_type": "0",
 *			"auth_data": "",
 *			"vip_list": "{"group": {"vip": "3.3.3.9"}}"
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
 *		"code":"458",
 *		"str":"\u4e0d\u5b58\u5728\u6b64\u5907\u4efd\u7ec4"
 *	}
 *
 */

/**
 * @api {DELETE} /api/sys-vrrp 删除VRRP配置
 * @apiName 删除VRRP配置
 * @apiGroup VRRP
 *
 *
 * @apiParam {String} ifname  接口名称
 * @apiParam {Number} vrid  虚拟路由ID
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"ifname": "ge0/1",
 *		"vrid": "3"
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
 *		"code":""
 *	}
 *
 */


class SystemVrrpController extends mController{	
	public $module = 'vrt_xml';
}

