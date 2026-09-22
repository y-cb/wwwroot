<?php
namespace controller\policy;
use controller\mController;

/**
 * @api {get}  /api/ips-set 获取入侵防护事件集
 * @apiName ips-set
 * @apiGroup 获取防护策略
 *
 *
 * @apiSuccess {String} name 入侵防护事件集名称
 * @apiSuccess {String} desc 入侵防护事件集描述
 * @apiSuccess {Number} protect_level 防护等级，1表示低，2表示中，3表示高
 * @apiSuccess {Number} type 是否默认，0表示默认，不可删除，1表示自定义，可删除
 * @apiSuccess {Number} member_count 入侵防护事件数量
 * @apiSuccess {Number} ref 是否被引用，0表示不启用，1表示启用
 *
 * @apiSuccessExample {json} Success-Response:
 *  HTTP/1.1 200 OK
    {
    "data": [
        {
            "name": "All",
            "desc": "最大事件集",
            "member_count": "2787",
            "protect_level": "1",
            "type": "0",
            "ref": "1"
        },
        {
            "name": "Common",
            "desc": "常规事件集",
            "member_count": "344",
            "protect_level": "1",
            "type": "0",
            "ref": "0"
        }
    ],
    "total": 2
    }
 */

/**
 * @api {POST}  /api/ips-set 新建入侵防护事件集策略
 * @apiName ips-set
 * @apiGroup 添加防护策略
 *
 * @apiParam {String} name 入侵防护事件集名称
 * @apiParam {String} desc 入侵防护事件集描述
 * @apiParam {Number} protect_level 防护等级，1表示低，2表示中，3表示高
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "test",
 *		"desc": "test",
 *		"protect_level": "1"
 *	}
 */

/**
 * @api {PUT}  /api/ips-set 修改入侵防护事件集策略
 * @apiName ips-set
 * @apiGroup 修改防护策略
 *
 *
 * @apiParam {String} name 入侵防护事件集名称
 * @apiParam {String} desc 入侵防护事件集描述
 * @apiParam {Number} protect_level 防护等级，1表示低，2表示中，3表示高
 * @apiParam {Number} member_count 入侵防护事件数量
 * @apiParam {Number} ref 是否被引用，0表示不启用，1表示启用
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "test",
 *		"desc": "test",
 *		"protect_level": "1",
 *		"member_count": "0",
 *		"ref": "1"
 *	}
 *
 */

/**
 * @api {delete}  /api/ips-set 删除入侵防护事件集策略
 * @apiName ips-set
 * @apiGroup 删除防护策略
 *
 *
 * @apiParam {String} name 防病毒库的名称
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "test"
 *	}
 *
 */
class IpsSetController extends mController {
	public $module = 'ips_sig_set';
}

?>
