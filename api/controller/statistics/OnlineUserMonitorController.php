<?php
namespace controller\statistics;
use controller\mController;

/**
 * @api {POST}  /api/online-user 冻结某个用户
 * @apiName 冻结某个用户
 * @apiGroup 在线用户统计
 *
 *
 * @apiParam {String} name 要冻结用户的名称
 * @apiParam {String} ip 要冻结用户的IP
 * @apiParam {Number} freeze_time 冻结时间单位是秒(60-86400)
 * @apiParam {Number} freeze_enable 冻结使能开关 
 * @apiParam {String} op "submit"
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "172.17.200.12",
 *		"ip":  "172.17.200.12",
 *		"freeze_time": 800,
 *		"freeze_enable": 1,
 *		"op":"submit" 
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
 *		"code":"非0"
 *	}
 *
 */

/**
 * @api {GET}  /api/online-user 获取所有用户信息
 * @apiName 获取所有用户信息
 * @apiGroup 在线用户统计
 *
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *	}
 *
 *
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
		"total": 62, 
		"data":,
			[
				{"freeze_enable": "0", "name": "172.17.200.92", "ip": "172.17.200.92", "group_name": "anonymous", "equipment": "", "type": "anony", "expire_time": "", "freeze_time": "0", "can_kick": "0", "online_time": "314", "identity": "anonymous", "login_time": "2018/05/09 15:11"}, 
				{"freeze_enable": "0", "name": "172.17.200.63", "ip": "172.17.200.63", "group_name": "anonymous", "equipment": "", "type": "anony", "expire_time": "", "freeze_time": "0", "can_kick": "0", "online_time": "538", "identity": "anonymous", "login_time": "2018/05/09 15:08"}, 
				{"freeze_enable": "0", "name": "44.44.44.133", "ip": "44.44.44.133", "group_name": "anonymous", "equipment": "", "type": "anony", "expire_time": "", "freeze_time": "0", "can_kick": "0", "online_time": "554", "identity": "anonymous", "login_time": "2018/05/09 15:07"}, 
				{"freeze_enable": "0", "name": "172.17.200.115", "ip": "172.17.200.115", "group_name": "anonymous", "equipment": "", "type": "anony", "expire_time": "", "freeze_time": "0", "can_kick": "0", "online_time": "636", "identity": "anonymous", "login_time": "2018/05/09 15:06"}, 
				{"freeze_enable": "0", "name": "172.17.200.198", "ip": "172.17.200.198", "group_name": "anonymous", "equipment": "", "type": "anony", "expire_time": "", "freeze_time": "0", "can_kick": "0", "online_time": "769", "identity": "anonymous", "login_time": "2018/05/09 15:04"}, 
				{"freeze_enable": "0", "name": "172.17.50.100", "ip": "172.17.50.100", "group_name": "anonymous", "equipment": "", "type": "anony", "expire_time": "", "freeze_time": "0", "can_kick": "0", "online_time": "11692", "identity": "anonymous", "login_time": "2018/05/09 12:02"}, 
				{"freeze_enable": "0", "name": "22.0.0.200", "ip": "22.0.0.200", "group_name": "anonymous", "equipment": "", "type": "anony", "expire_time": "", "freeze_time": "0", "can_kick": "0", "online_time": "11720", "identity": "anonymous", "login_time": "2018/05/09 12:01"
				}
			]
 *	}
 */

/**
 * @api {GET}  /api/online-user 根据主机地址过滤用户信息
 * @apiName 根据主机地址过滤用户信息
 * @apiGroup 在线用户统计
 *
 * @apiParam {String} filter_type  过滤的类型host
 * @apiParam {String} filter_address  过滤的值
 *
 * @apiParamExample {json} Request-Example:
 *	{
		"filter_type":"host",
		"filter_address":"172.17.150.111"
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
		"total": 1, 
		"data": [
				{
					"freeze_enable": "0", 
					"name": "172.17.150.111", 
					"ip": "172.17.150.111", 
					"group_name": "anonymous", 
					"equipment": "", 
					"type": "anony", 
					"expire_time": "", 
					"freeze_time": "0", 
					"can_kick": "0", 
					"online_time": "595", 
					"identity": "anonymous", 
					"login_time": "2018/05/09 15:02"
				}
			]
 *	}
 */


/**
 * @api {DELETE}  /api/online-user 踢除本地在线用户对象
 * @apiName 踢除本地在线用户对象
 * @apiGroup 在线用户统计
 *
 *
 * @apiParam {String} name  用户名
 * @apiParam {String} ip  用户IP
 * @apiParam {String} type  用户类型
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "test_user",
		"ip": "172.17.150.20",
		"type":"local_db"
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
 *		"code":"非0"
 *	}
 *
 */

/**
 * @api {PUT}  /api/online-user 清除所有本地在线用户对象
 * @apiName 清除所有本地在线用户对象
 * @apiGroup 在线用户统计
 *
 *
 * @apiParam {String} name  用户名
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "root"
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
 *		"code":"非0"
 *	}
 *
 */


class OnlineUserMonitorController extends mController{
	public $module = 'auth_onlineuser_monitor';
}
