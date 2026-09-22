<?php
namespace controller\policy;
use controller\mController;

/**
 * @api {GET}  /api/av-sig 获取病毒库信息
 * @apiName av-sig
 * @apiGroup 防护策略
 *
 *
 * @apiSuccess {String} av_version 版本号
 * @apiSuccess {Number} av_statistics 病毒数量
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"av_version": "20170223",
 *			"av_statistics": "6177758" 
 *		}
 *	],
 *	}
 */


class AvSigController extends mController{	
  public $category = 'CATEG_CONFIG';
	public $module = 'av_info';
}
