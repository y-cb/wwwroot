<?php
namespace controller\policy;
use controller\mController;

/**
 * @api {GET}  /api/app-action 获取应用动作
 * @apiName app-action
 * @apiGroup 应用策略
 *
 * @apiSuccess {String} name 应用名称
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "streaming-media"
 *	}
 *
 * @apiSuccess {String} name 应用动作名称
 * @apiSuccess {String} show_name 应用动作名称中文
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"name": "Media_play",
 *			"show_name": "看视频"
 *		},
 *		{
 *			"name": "Media_music",
 *			"show_name": "听音乐"
 *		}
 *	],
 *	"total": 2
 *	}
 */


class AppActionController extends mController {	
	public $module = 'app_action';
}