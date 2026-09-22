<?php
namespace controller\policy;
use controller\mController;

/**
 * @api {GET}  /api/ips-log 获取IPS日志合并配置
 * @apiName ips-log
 * @apiGroup 获取防护策略
 *
 *
 * @apiSuccess {Number} enable 使能状态
 * @apiSuccess {Number} interval 时间间隔
 * @apiSuccess {Number} basis 合并条件，0代表基于源IP，1代表基于目的IP，2代表基于源目的IP
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data":,
 *		{
 *			"enable": "1",
 *			"interval": "30",
 *			"basis": "0"
 *		}
 *	}
 */
 
/**
 * @api {POST}  /api/ips-log 添加IPS日志合并配置
 * @apiName ips-log
 * @apiGroup 添加防护策略
 *
 * @apiParam {Number} enable 使能状态
 * @apiParam {Number} interval 时间间隔
 * @apiParam {Number} basis 合并条件，0代表基于源IP，1代表基于目的IP，2代表基于源目的IP
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *	"data":,
 *       {
 *			"enable": "1",
 *			"interval": "30",
 *			"basis": "0"
 *       }
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


class IpsLogController extends mController {
	public $module = 'ips_log_merge';
}

?>
