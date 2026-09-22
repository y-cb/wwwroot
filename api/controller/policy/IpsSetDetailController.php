<?php
namespace controller\policy;
use controller\mController;

/**
 * @api {GET}  /api/ips-set-detail 获取入侵防护事件集详情
 * @apiName ips-set-detail
 * @apiGroup 获取入侵防护事件集详情
 *
 *
 * @apiSuccess {String} type_name 入侵防护事件名称
 * @apiSuccess {String} type_name_cn 入侵防护事件名称
 * @apiSuccess {Number} num 入侵防护事件数
 * @apiSuccess {Number} enable 是否启用，0表示不启用，1表示启用
 * @apiSuccess {Number} log 是否开启日志，0表示不启用，1表示启用
 * @apiSuccess {Number} act 事件动作，0表示通过，1表示重置，2表示丢弃，3表示阻断会话，4表示阻断源地址
 * @apiSuccess {Number} level 防护等级，0表示信息，1表示通知，2表示警示，3表示告警
 * @apiSuccess {Number} risk 风险等级，1表示低危
 * @apiSuccess {Number} popularity 热度
 * @apiSuccess {String} set_name 入侵防护事件集名称
 * @apiSuccess {Number} mode 添加模式，固定为3
 * @apiSuccess {String} op 操作
 * @apiSuccess {Number} page 分页
 * @apiSuccess {Number} pageSize 页面数量
 *
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"set_name": "test",
 *   	        "mode": "3",
 *		"op": "list",
 *		"page":"1",
 *		"pageSize":"10"
 *  }
 *
 * @apiSuccessExample {json} Success-Response:
 *  HTTP/1.1 200 OK
    {
    "data": [
        {
            "type_name": "InformationDisclosure",
            "type_name_cn": "InformationDisclosure",
            "num": "213",
            "enable": "1",
            "log": "1",
            "act": "0",
            "level": "0",
            "risk": "1",
            "popularity": "1"
        },
        {
            "type_name": "BufferOverflow",
            "type_name_cn": "BufferOverflow",
            "num": "395",
            "enable": "1",
            "log": "1",
            "act": "0",
            "level": "0",
            "risk": "1",
            "popularity": "1"
        }
    ],
    "total": 2
    }
 */

/**
 * @api {DELETE}  /api/ips-set-detail 删除入侵防护事件集
 * @apiName ips-set-detail
 * @apiGroup 删除入侵防护事件集
 *
 * @apiParam {String} type_name 入侵防护事件名称
 * @apiParam {String} set_name 入侵防护事件集名称
 * @apiParam {Number} mode 添加模式，固定为3
 * @apiParam {String} mode_name 入侵防护事件名称
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *	
 *		"type_name": "InformationDisclosure",
 *		"type_name_cn":"缓冲溢出",
 *		"num": "109"
 *		"enable":"" 
 *		"log": ""
 *		"act": ""
 *		"level": ""
 *		"risk": "1"
 *		"popularity": "1"
 *		"tb_level": "1"
 *		"mode": 3
 * 		"set_name": "test",
 * 		"mode": "3",
 *		"mode_name": "InformationDisclosure"
 *	}
 */
/**
 * @api {PUT}  /api/ips-set-detail 修改入侵防护事件集
 * @apiName ips-set-detail
 * @apiGroup 修改入侵防护事件集
 *
 *
 * @apiSuccess {String} type_name 入侵防护事件名称
 * @apiSuccess {String} type_name_cn 入侵防护事件名称
 * @apiSuccess {String} set_name 入侵防护事件集名称
 * @apiSuccess {Number} act 事件动作，0表示通过，1表示重置，2表示丢弃，3表示阻断会话，4表示阻断源地址
 * @apiSuccess {Number} level 防护等级，0表示信息，1表示通知，2表示警示，3表示告警
 * @apiSuccess {Number} log 是否开启日志，0表示不启用，1表示启用
 * @apiSuccess {Number} enable 是否启用，0表示不启用，1表示启用
 * @apiSuccess {Number} risk 风险等级，1表示低危
 * @apiSuccess {Number} popularity 热度
 * @apiSuccess {Number} mode 添加模式，固定为3
 * @apiSuccess {String} mode_name 入侵防护事件名称
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"type_name": "InformationDisclosure",
 *		"type_name_cn": "InformationDisclosure",
 *         	"set_name": "test",
 *         	"num":"63" 
 *              "level": "1",
 *      "act": "0",
 *      "log": "1",
 *      "enable": "1"
 *	    "mode": "3",
 *	    "risk":"1",
 *	    "popularity":"1",
 *	    "tb_level":"1",
 *      "mode_name": "InformationDisclosure"
 *  }
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
 */

class IpsSetDetailController extends mController {
	public $module = 'ips_set_node';
}

?>
