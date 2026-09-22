<?php
namespace controller\object;
use controller\mController;

/**
 * @api {GET} /api/local-auth 获取本地用户认证参数
 * @apiName 获取本地用户认证参数
 * @apiGroup 认证服务器
 *
 *
 * @apiSuccess {String} online_mode  用户登录唯一性，single:单一帐号登录 multi:允许重复登录 
 * @apiSuccess {String} offline_mode  单一帐号登录模式下：old 踢出已登录用户 new：禁止同名用户再次登录
 * @apiSuccess {Number} multi_limit  允许重复登录模式，0：无限制登录  >= 最大登录个数；（0表示关闭，2-1000表示启用）
 * @apiSuccess {Number} kick_interval  强制重登录间隔 10-144000分钟；（0表示关闭，10-144000表示启用）
 * @apiSuccess {Number} keepalive_timeout  心跳超时时间，1-720分钟; （0表示关闭，1-720表示启用）
 * @apiSuccess {Number} traffic_alive  流量超时时间，1-720分钟； （0表示关闭，1-720表示启用）
 * @apiSuccess {String} hello_url  重定向url，例：http%3A%2F%2Fwww.baidu.com  （1-127字符）
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *			"online_mode": "single",
 *			"offline_mode": "old",
 *			"multi_limit": "0",
 *			"kick_interval": "0",
 *			"keepalive_timeout": "10",
 *			"traffic_alive": "0",
 *			"hello_url": "http%3A%2F%2Fwww.baidu.com"
 *	}
 */

/**
 * @api {PUT} /api/local-auth 修改本地认证参数
 * @apiName 修改本地认证参数
 * @apiGroup 认证服务器
 *
 *
 * @apiSuccess {String} online_mode  用户登录唯一性，single:单一帐号登录 multi:允许重复登录 
 * @apiSuccess {String} offline_mode  单一帐号登录模式下：old 踢出已登录用户 new：禁止同名用户再次登录
 * @apiSuccess {Number} multi_limit  允许重复登录模式，0：无限制登录  >= 最大登录个数
 * @apiSuccess {Number} kick_interval  强制重登录间隔 10-144000分钟
 * @apiSuccess {Number} keepalive_timeout  心跳超时时间，1-720分钟
 * @apiSuccess {Number} traffic_alive  流量超时时间，1-720分钟
 * @apiSuccess {String} hello_url  重定向url，例：http%3A%2F%2Fwww.baidu.com
 * @apiSuccess {Number} secure  保留字段，不需关心
 * @apiSuccess {Number} http_port  保留字段，不需关心
 * @apiSuccess {Number} https_port  保留字段，不需关心
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *			"online_mode": "single",
 *			"offline_mode": "old",
 *			"multi_limit": "0",
 *			"kick_interval": "0",
 *			"keepalive_timeout": "10",
 *			"traffic_alive": "0",
 *			"secure": "0",
 *			"http_port": "8000",
 *			"https_port": "4433",
 *			"hello_url": "http%3A%2F%2Fwww.baidu.com"
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


class LocalAuthController extends mController{	
	public $module = 'auth_static_profile';
}

