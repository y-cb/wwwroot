<?php
namespace controller\object;
use controller\mController;

/**
 * @api {GET}  /api/abs-time 获取所有绝对时间对象信息
 * @apiName 获取所有绝对时间对象信息
 * @apiGroup 时间对象
 *
 *
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"name": "absolute_time_obj",
 *			"desc": "test for absolute_time_obj",
 *			"year1": "18",
 *			"month1": "5",
 *			"day1": "8",
 *			"hour1": "18",
 *			"minute1": "18",
 *			"year2": "19",
 *			"month2": "6",
 *			"day2": "9",
 *			"hour2": "19",
 *			"minute2": "19",
 *			"ref": "0"
 *		},
 *		{
 *			"name": "absolute_time_obj2",
 *			"desc": "test for absolute_time_obj2",
 *			"year1": "18",
 *			"month1": "7",
 *			"day1": "9",
 *			"hour1": "13",
 *			"minute1": "13",
 *			"year2": "19",
 *			"month2": "8",
 *			"day2": "10",
 *			"hour2": "14",
 *			"minute2": "14",
 *			"ref": "3"
 *		}
 *	],
 *	"total": 2
 *	}
 */

/**
 * @api {POST}  /api/abs-time 添加绝对时间对象信息
 * @apiName 添加绝对时间对象信息
 * @apiGroup 时间对象
 *
 *
 * @apiSuccess {String} name 绝对时间对象的名字
 * @apiSuccess {Number} ref 绝对时间对象的引用计数
 * @apiSuccess {Number} year1 绝对时间对象起始年后两位
 * @apiSuccess {Number} month1 绝对时间对象起始月
 * @apiSuccess {Number} day1 绝对时间对象起始日
 * @apiSuccess {Number} hour1 绝对时间对象起始时
 * @apiSuccess {Number} minute1 绝对时间对象起始分
 * @apiSuccess {Number} year2 绝对时间对象结束年后两位
 * @apiSuccess {Number} month2 绝对时间对象结束月
 * @apiSuccess {Number} day2 绝对时间对象结束日
 * @apiSuccess {Number} hour2 绝对时间对象结束时
 * @apiSuccess {Number} minute2 绝对时间对象结束分
 * @apiSuccess {String} desc 对绝对时间对象的描述
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "absolute_time_obj3",
 *		"desc": "test for absolute_time_obj3",
 *		"year1": "18",
 *		"month1": "5",
 *		"day1": "8",
 *		"hour1": "18",
 *		"minute1": "18",
 *		"year2": "19",
 *		"month2": "6",
 *		"day2": "9",
 *		"hour2": "19",
 *		"minute2": "19",
 *		"ref": "0"
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
 * @api {PUT}  /api/abs-time 修改绝对时间对象
 * @apiName 修改绝对时间对象
 * @apiGroup 时间对象
 *
 *
 * @apiSuccess {String} name 绝对时间对象的名字
 * @apiSuccess {Number} ref 绝对时间对象的引用计数
 * @apiSuccess {Number} year1 绝对时间对象起始年后两位
 * @apiSuccess {Number} month1 绝对时间对象起始月
 * @apiSuccess {Number} day1 绝对时间对象起始日
 * @apiSuccess {Number} hour1 绝对时间对象起始时
 * @apiSuccess {Number} minute1 绝对时间对象起始分
 * @apiSuccess {Number} year2 绝对时间对象结束年后两位
 * @apiSuccess {Number} month2 绝对时间对象结束月
 * @apiSuccess {Number} day2 绝对时间对象结束日
 * @apiSuccess {Number} hour2 绝对时间对象结束时
 * @apiSuccess {Number} minute2 绝对时间对象结束分
 * @apiSuccess {String} desc 对绝对时间对象的描述
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "absolute_time_obj3",
 *		"desc": "test for absolute_time_obj3",
 *		"year1": "18",
 *		"month1": "5",
 *		"day1": "9",
 *		"hour1": "18",
 *		"minute1": "18",
 *		"year2": "19",
 *		"month2": "8",
 *		"day2": "9",
 *		"hour2": "19",
 *		"minute2": "19",
 *		"ref": "0"
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
 * @api {DELETE}  /api/abs-time 删除绝对时间对象
 * @apiName 删除绝对时间对象
 * @apiGroup 时间对象
 *
 *
 * @apiParam {String} name 绝对时间对象的名称
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "absolute_time_obj3"
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


class AbsTimeController extends mController {	
	public $module = 'tr_abs_table';
}
