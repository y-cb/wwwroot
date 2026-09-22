<?php
namespace controller\policy;
use controller\mController;

/**
 * @api {GET}  /api/av-engine 获取是否扫描所有文件
 * @apiName 获取是否扫描所有文件,
 * @apiGroup 防护策略
 *
 *
 * @apiSuccess {Number} scan_all 扫描状态，不可为空，是否扫描所有文件1启用0:不启用
 *
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data":,
 *		{
 *			"scan_all": "0"
 *		}
 *	}
 */

/**
 * @api {PUT}  /api/av-engine 修改是否扫描所有文件
 * @apiName 修改是否扫描所有文件
 * @apiGroup 防护策略
 *
 *
 * 
 * @apiParam {Number} scan_all 是否扫描所有文件，不可为空1启用,0:不启用
 *
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		
 *		"scan_all": "1"
 *	}
 *
 * @apiErrorExample {json} Error-Response:
 *	HTTP/1.1 422 Not Found
 *	{
 *		"scan_all": "1"
 *	}
 *
 */


class AvEngineController extends mController {	
	public $module = 'av_engine';
}
