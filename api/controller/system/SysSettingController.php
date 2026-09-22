<?php
namespace controller\system;
use controller\mController;

/**
 * @api {GET}  /api/sys-conf 获取系统设置
 * @apiName  获取系统设置
 * @apiGroup 系统设置
 *
 *
 * @apiSuccess {Number} auto_save 系统配置是否实时自动保存 <0-1>
 * @apiSuccess {Number} session_timeout 页面超时时间 <5-480> 分钟
 * @apiSuccess {Number} max_client 在线管理员最大数量<1-20>
 * @apiSuccess {Number} dt_off 保留字段，后台不做处理<0-1>
 * @apiSuccess {Number} av_off 保留字段，后台不做处理<0-1>
 * @apiSuccess {Number} admin_unique 管理员唯一性检查配置<0-1>
 * @apiSuccess {String} mgr_ip1 保留字段，后台不做处理
 * @apiSuccess {String} mgr_ip2 保留字段，后台不做处理
 * @apiSuccess {String} mgr_ip3 保留字段，后台不做处理
 * @apiSuccess {Number} mgr_port 保留字段，后台不做处理
 * @apiSuccess {Number} auth_retry 管理员最大登录重试次数 <1-60>
 * @apiSuccess {Number} auth_block 管理员登录失败阻断间隔 <1-3600>
 * @apiSuccess {Number} auth_cert_enable 保留字段，后台不做处理
 * @apiSuccess {Number} local_http_port 本地HTTP服务管理端口<1024-65535>
 * @apiSuccess {Number} local_https_port 本地HTTPS服务管理端口<1024-65535> 
 * @apiSuccess {String} admin_if_addr 管理接口ip地址
 * @apiSuccess {String} admin_if_addr_v6 管理接口ipv6地址
 * @apiSuccess {String} hostname主机名称 
 * @apiSuccess {String} admin_pwd 保留字段，后台不做处理
 * @apiSuccess {Number} admin_verification_enable 管理员登录图形验证码 <0-1>
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"auto_save": "0",
 *			"session_timeout": "20",
 *			"max_client": "10",
 *			"dt_off": "0",
 *			"av_off": "0",
 *			"admin_unique": "0",
 *			"mgr_ip1": "",
 *			"mgr_ip2": "",
 *			"mgr_ip3": "",
 *			"mgr_port": "4433",
 *			"auth_retry": "[05]",
 *			"auth_block": "[060]",
 *			"auth_cert_enable": "0",
 *			"local_http_port": "80",
 *			"local_https_port": "443",
 *			"admin_if_addr": "1.1.1.1",
 *			"admin_if_addr_v6": "3ffe:506::1/48",
 *			"hostname": "host",
 *			"admin_verification_enable": "1"
 *		}
 *	]
 *	"total": 1
 *	}
 */

/**
 * @api {PUT}  /api/sys-conf 修改系统设置
 * @apiName 修改系统设置
 * @apiGroup 系统设置
 *
 *
 * @apiSuccess {Number} auto_save 系统配置是否实时自动保存
 * @apiSuccess {Number} session_timeout 页面超时时间
 * @apiSuccess {Number} max_client 在线管理员最大数量
 * @apiSuccess {Number} admin_unique 管理员唯一性检查配置
 * @apiSuccess {Number} auth_retry 管理员最大登录重试次数
 * @apiSuccess {Number} auth_block 管理员登录失败阻断间隔 
 * @apiSuccess {Number} auth_cert_enable 保留字段，后台不做处理
 * @apiSuccess {Number} local_http_port 本地HTTP服务管理端口
 * @apiSuccess {Number} local_https_port本地HTTPS服务管理端口 
 * @apiSuccess {String} hostname主机名称 
 * @apiSuccess {Number} admin_verification_enable 管理员登录图形验证码 
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *	{
 *		"data": [
 *		{
 *			"auto_save": "0",
 *			"session_timeout": "20",
 *			"max_client": "10",
 *			"admin_unique": "0",
 *			"auth_retry": "5",
 *			"auth_block": "60",
 *			"auth_cert_enable": "0",
 *			"local_http_port": "80",
 *			"local_https_port": "443",
 *			"hostname": "host",
 *			"admin_verification_enable": "1"
 *		}
 *	]
 *	"total": 1
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
 *		"code":"755"
 *	}
 *
 */


class SysSettingController extends mController {	
	public $module = 'sys_config';
}
