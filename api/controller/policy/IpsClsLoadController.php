<?php
namespace controller\policy;
use controller\mController;

/**
 * @api {get}  /api/ips-cls-load 获取入侵防护分类加载数据
 * @apiName ips-cls-load
 * @apiGroup 获取入侵防护分类加载数据
 *
 *
 * @apiSuccess {Number} risk 入侵防护事件风险等级
 * @apiSuccess {Number} popularity 入侵防护事件热度
 *
 * @apiSuccessExample {json} Success-Response:
 *  HTTP/1.1 200 OK
    {
    "data": [
        {
            "risk": "1",
            "popularity": "2",
        }
    ],
    "total": 1
    }
 */

/**
 * @api {PUT}  /api/ips-cls-load 修改入侵防护分类加载数据
 * @apiName ips-cls-load
 * @apiGroup 修改入侵防护分类加载数据
 *
 *
 * @apiParam {Number} risk 入侵防护事件风险等级
 * @apiParam {Number} popularity 入侵防护事件热度
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"risk": "3",
 *		"popularity": "4",
 *	}
 *
 */

class IpsClsLoadController extends mController {
	public $module = 'ips_classify_load';
}

?>
