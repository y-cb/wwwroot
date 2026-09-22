<?php
namespace controller\policy;
use controller\mController;

/**
 * @api {GET}  /api/app-audit 获取应用审计策略
 * @apiName app-audit
 * @apiGroup 应用策略
 *
 *
 * @apiSuccess {Number} id id
 * @apiSuccess {Number} enable 状态
 * @apiSuccess {String} user 用户
 * @apiSuccess {String} addr 地址
 * @apiSuccess {Number} instant_message 即时通讯(登录、聊天、收发文件)
 * @apiSuccess {Number} search_engine 搜索引擎(搜索内容)
 * @apiSuccess {Number} social_network 社交网络(在线社区、BBS、社交网站的搜索及发帖)
 * @apiSuccess {Number} email 电子邮件(邮件收发及附件信息)
 * @apiSuccess {Number} file_transfer 文件共享(FTP/HTTP文件传输，网盘文件上传和下载)
 * @apiSuccess {Number} online_shopping 在线购物(搜索内容信息)
 * @apiSuccess {Number} other 其它应用，仅能审计应用的行为，会产生大量日志，不建议勾选
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"id": "1",
 *			"enable": "1",
 *			"user": "anoymous",
 *			"addr": "any",
 *			"instant_message": "0",
 *			"search_engine": "1",
 *			"social_network": "1",
 *			"email": "0",
 *			"file_transfer": "0",
 *			"online_shopping": "0",
 *			"other": "0"
 *		},
 *		{
 *			"id": "2",
 *			"enable": "1",
 *			"user": "any",
 *			"addr": "any",
 *			"instant_message": "0",
 *			"search_engine": "1",
 *			"social_network": "1",
 *			"email": "0",
 *			"file_transfer": "0",
 *			"online_shopping": "0",
 *			"other": "0"
 *		} 
 *	],
 *	}
 */

/**
 * @api {POST}  /api/app-audit 添加应用审计策略
 * @apiName app-audit
 * @apiGroup 应用策略
 *
 *
 * @apiParam {Number} id id
 * @apiParam {Number} enable 状态
 * @apiParam {String} user 用户
 * @apiParam {String} addr 地址
 * @apiParam {Number} instant_message 即时通讯(登录、聊天、收发文件)
 * @apiParam {Number} social_network 社交网络(在线社区、BBS、社交网站的搜索及发帖)
 * @apiParam {Number} email 电子邮件(邮件收发及附件信息)
 * @apiParam {Number} online_shopping 在线购物(搜索内容信息)
 * @apiParam {Number} file_transfer 文件共享(FTP/HTTP文件传输，网盘文件上传和下载)
 * @apiParam {Number} other 其它应用，仅能审计应用的行为，会产生大量日志，不建议勾选
 *
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *			"enable": "1",
 *			"user": "anoymous",
 *			"addr": "any",
 *			"id": "0",
 *			"search_engine": "1",
 *			"social_network": "1",
 *			"instant_message": "0",
 *			"email": "0",
 *			"file_transfer": "0",
 *			"online_shopping": "0",
 *			"other": "0"
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
 *		"code":"非0",
 *		"str":""
 *	}
 *
 */

/**
 * @api {PUT}  /api/app-audit 修改应用审计策略
 * @apiName app-audit
 * @apiGroup 应用策略
 *
 *
 * @apiParam {Number} id id
 * @apiParam {Number} enable 状态
 * @apiParam {String} user 用户
 * @apiParam {String} addr 地址
 * @apiParam {Number} instant_message 即时通讯(登录、聊天、收发文件)
 * @apiParam {Number} social_network 社交网络(在线社区、BBS、社交网站的搜索及发帖)
 * @apiParam {Number} email 电子邮件(邮件收发及附件信息)
 * @apiParam {Number} online_shopping 在线购物(搜索内容信息)
 * @apiParam {Number} file_transfer 文件共享(FTP/HTTP文件传输，网盘文件上传和下载)
 * @apiParam {Number} other 其它应用，仅能审计应用的行为，会产生大量日志，不建议勾选
 *
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *			"enable": "1",
 *			"user": "anoymous",
 *			"addr": "any",
 *			"id": "1",
 *			"search_engine": "1",
 *			"social_network": "1",
 *			"instant_message": "0",
 *			"email": "0",
 *			"file_transfer": "0",
 *			"online_shopping": "0",
 *			"other": "0"
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
 *		"code":"非0",
 *		"str":""
 *	}
 *
 */

/**
 * @api {DELETE}  /api/app-audit 删除应用审计策略
 * @apiName app-audit
 * @apiGroup 应用策略
 *
 *
 * @apiParam {Number} id id
 *
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"id": "1"
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
 *		"code":"非0",
 *		"str":""
 *	}
 *
 */


class AppAuditController extends mController {	
	public $module = 'xml_app_audit_policy';
}
