<?php
namespace controller\policy;
use controller\mController;

/**
 * @api {GET} /api/nbc-qos  获取流量控制线路信息
 * @apiName  获取流量控制线路信息
 * @apiGroup  流控策略
 *
 *
 * @apiSuccess {Number} id  流量控制线路ID
 * @apiSuccess {String} name  流量控制线路的名字
 * @apiSuccess {String} bind_name  流量控制线路绑定的接口名
 * @apiSuccess {Number} egress_max  出接口的最大带宽流量
 * @apiSuccess {Number} enable  流量控制线路启用的标志，启用设置为 1，不启用设置为 0 ，默认启用，值为 1
 * @apiSuccess {Number} ingress_max  入接口的最大带宽流量
 * @apiSuccess {Number} egress_guaran  出接口的带宽管理流量
 * @apiSuccess {Number} ingress_guaran  入接口的带宽流量
 * @apiSuccess {Number} egress_enable  启用出接口代管流量管理的标志 ，启用设置为 1，不启用设置为 0 ，默认启用，值为 1
 * @apiSuccess {Number} ingress_enable  启用入接口代管流量管理的标志 ，启用设置为 1，不启用设置为 0 ，默认启用，值为 1
 * @apiSuccess {String} priority  优先级
 * @apiSuccess {String} _parentId  上级ID
 * @apiSuccess {String} ingress_perip  入接口每IP限速
 * @apiSuccess {String} egress_perip  出接口每IP限速
 * @apiSuccess {String} move_up  XXX 此处替换为对priority 的中文注释   （暂保留）
 * @apiSuccess {String} ingress_guaran_true  入接口生效保障带宽
 * @apiSuccess {String} egress_guaran_true  出接口生效保障带宽
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 * {"total": 2, 
 * "data": [{"egress_max": "1024", 
 * "egress_bps": "0", 
 * "ingress_guaran_true": "1048576", 
 * "name": "AAAAA", 
 * "ingress_guaran": "1048576", 
 * "ingress_perip": "0", 
 * "egress_enable": "1", 
 * "_parentId": "0", 
 * "ingress_bps": "0", 
 * "bind_name": "ge0/0", 
 * "ingress_max": "1048576", 
 * "state": "closed", 
 * "move_down": "0", 
 * "egress_guaran": "1024", 
 * "egress_perip": "0", 
 * "enable": "1", 
 * "ingress_enable": "0", 
 * "children_num": "1", 
 * "id": "1", 
 * "move_up": "0", 
 * "egress_guaran_true": "1024"
 *}, 
 * {"egress_max": "1024", 
 * "egress_bps": "0", 
 * "ingress_guaran_true": "1024", 
 * "name": "aaaaaaaa", 
 * "ingress_guaran": "1024", 
 * "ingress_perip": "0", 
 * "egress_enable": "1", 
 * "_parentId": "0", 
 * "ingress_bps": "0", 
 * "bind_name": "ge0/1", 
 * "ingress_max": "1024", 
 * "state": "closed", 
 * "move_down": "0", 
 * "egress_guaran": "1024", 
 * "egress_perip": "0", 
 * "enable": "1", 
 * "ingress_enable": "1", 
 * "children_num": "1", 
 * "id": "3", 
 * "move_up": "0", 
 * "egress_guaran_true": "1024"
 }]
 }
 *
 */

/**
 * @api {POST} /api/nbc-qos 添加流量控制线路
 * @apiName 添加流量控制线路
 * @apiGroup 流控策略
 *
 *
 * @apiParam {String} name  流量控制线路的名字
 * @apiParam {String} bind_name  流量控制线路绑定的接口名
 * @apiParam {Number} egress_max  出接口的带宽流量
 * @apiParam {Number} enable  流量控制线路启用的标志，启用设置为 1，不启用设置为 0 ，默认启用，值为 1
 * @apiParam {Number} ingress_max  入接口的最大带宽流量
 * @apiParam {Number} egress_guaran  出接口的带宽管理流量
 * @apiParam {Number} ingress_guaran  入接口的带宽管理流量
 * @apiParam {Number} egress_enable  启用出接口代管流量管理的标志 ，启用设置为 1，不启用设置为 0 ，默认启用，值为 1
 * @apiParam {Number} ingress_enable  启用入接口代管流量管理的标志 ，启用设置为 1，不启用设置为 0 ，默认启用，值为 1
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "AAA",
 *		"bind_name": "ge0/0",
 *		"egress_max": "1024",
 *		"enable": "1",
 *		"ingress_max": "1024",
 *		"egress_guaran": "1024",
 *		"ingress_guaran": "1024",
 *		"egress_enable": "1",
 *		"ingress_enable": "1"
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
 *		"code":"-1",
 *		"str":"\u63a5\u53e3\u4e0d\u5b58\u5728\u3002"
 *	}
 *
 */

/**
 * @api {PUT} /api/nbc-qos 修改流量控制线路
 * @apiName 修改流量控制线路
 * @apiGroup 流控策略
 *
 *
 * @apiParam {String} name  流量控制线路的名字
 * @apiParam {String} bind_name  流量控制线路绑定的接口名
 * @apiParam {Number} egress_max  出接口的带宽流量
 * @apiParam {Number} enable  流量控制线路启用的标志，启用设置为 1，不启用设置为 0 ，默认启用，值为 1
 * @apiParam {Number} ingress_max  入接口的最大带宽流量
 * @apiParam {Number} egress_guaran  出接口的带宽管理流量
 * @apiParam {Number} ingress_guaran  入接口的带宽管理流量
 * @apiParam {Number} egress_enable  启用出接口代管流量管理的标志 ，启用设置为 1，不启用设置为 0 ，默认启用，值为 1
 * @apiParam {Number} ingress_enable  启用入接口代管流量管理的标志 ，启用设置为 1，不启用设置为 0 ，默认启用，值为 1
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "AAA",
 *		"bind_name": "ge0/0",
 *		"egress_max": "1024",
 *		"enable": "1",
 *		"ingress_max": "1024",
 *		"egress_guaran": "1024",
 *		"ingress_guaran": "1024",
 *		"egress_enable": "1",
 *		"ingress_enable": "1"
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"code":""
 *	}
 *
 * @apiErrorExample {json} Error-Response:
 *	HTTP/1.1 422 Not Found
 *	{
 *		"code":"-1",
 *		"str":"QOS\u5bf9\u8c61\u4e0d\u5b58\u5728\u3002"
 *	}
 *
 */

/**
 * @api {DELETE} /api/nbc-qos 删除流量控制线路
 * @apiName 删除流量控制线路
 * @apiGroup 流控策略
 *
 *
 * @apiParam {String} name  XXX 此处替换为对name,的中文注释
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "aaa"
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"code":""
 *	}
 *
 * @apiErrorExample {json} Error-Response:
 *	HTTP/1.1 422 Not Found
 *	{
 *		"code":"-1",
 *		"str":"QOS\u5bf9\u8c61\u4e0d\u5b58\u5728\u3002"
 *	}
 *
 */


class NbcQosPstateController extends mController { 
	public $module = 'nbc_qos_punish_channel_stats';
}
