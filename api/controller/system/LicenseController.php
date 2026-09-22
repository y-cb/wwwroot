<?php
namespace controller\system;
use controller\mController;

/**
 * @api {GET}  /api/license 获取设备授权信息
 * @apiName 获取设备授权信息
 * @apiGroup 系统维护
 *
 *
 * @apiSuccess {String} name  模块名
 * @apiSuccess {Array} point  授权点数
 * @apiSuccess {String} timeleft  是否有剩余时间
 * @apiSuccess {String} active_status  激活状态 
 * @apiSuccess {String} day_left  剩余时间
 * @apiSuccess {String} type  授权状态
 * @apiSuccess {String} id  id
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"name": "Next-Generation Firewall",
 *			"point":"-",
 *			"timeleft": "1",
 *			"active_status": "Active",
 *			"day_left": "-",
 *			"type": "Valid",
 *			"id": "0"
 *		},
 *		{
 *			"name": "Application Access Control",
 *		        "point": "-",
 *			"time_left": "1",
 *			"active_status": "Active",
 *			"day_left": "24 Days",
 *			"type": "Valid",
 *			"id": "1"
 *		}
 *	],
 *	"total": 2
 *	}
 */

/**
 * @api {POST}  /api/license 导入授权码
 * @apiName 将授权码导入设备
 * @apiGroup 系统维护
 *
 *
 * @apiParam {String} license  生产网站上根据序列号生产的授权码
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"license": "vE2xwt6PeMdmMkI36wTZheoH24UNiCSBZ+pFbTlwnp9tTQaf+vOtf64qjfUPzszdpFN9OZlwYg6hTblHYIx52EEq+4MgAHj9"
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
 *		"code":"392" //The license had already active before
 *	}
 *
 */


/**
 * @api {PUT}  /api/license 修改授权码
 * @apiName 修改授权码
 * @apiGroup 系统维护
 *
 *
 * @apiParam {String} license  生产网站上根据序列号生产的授权码
 *
 * @apiParamExample {json} Request-Example:
 *      {
 *              "license": "vE2xwt6PeMdmMkI36wTZheoH24UNiCSBZ+pFbTlwnp9tTQaf+vOtf2Xk5Np2UQctxN/zmaAJG+p0fNWCADiGsFqrO5NcM6I/"
 *      }
 *
 * @apiSuccessExample {json} Success-Response:
 *      HTTP/1.1 200 OK
 *      {
 *      }
 *
 * @apiErrorExample {json} Error-Response:
 *      HTTP/1.1 422 Not Found
 *      {
 *              "code":"392" //The license had already active before
 *      }
 *


 */


class LicenseController extends mController{	
	public $module = 'license_info';
}

