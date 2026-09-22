<?php
namespace controller\network;
use controller\mController;

/**
 * @api {GET}  /api/overlay 获取overlay网关配置(该版本不支持该接口)
 * @apiName 获取overlay网关配置
 * @apiGroup Overlay网关
 *
 *
 * @apiSuccess {Number} enable  overlay网关功能开关
 * @apiSuccess {Number} type  目前只支持vxlan封装
 * @apiSuccess {String} vtep_addr  VTEP地址
 * @apiSuccess {Number} vtep_port  VTEP端口  
 * @apiSuccess {String} cont_addr  Controller地址
 * @apiSuccess {Number} cont_port  Controller端口
 * @apiSuccess {Number} fresh_timer  刷新时间
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *
 *		{
 *			"enable": "1",
 *			"type": "1",
 *			"vtep_addr": "1.1.1.1",
 *			"vtep_port": "8848",
 *			"cont_addr": "2.2.2.2",
 *			"cont_port": "2322",
 *			"fresh_timer": "22"
 *		}
 *	],
 *	"total": 1
 *	}
 */

/**
 * @api {PUT}  /api/overlay 修改overlay网关配置(该版本不支持该接口)
 * @apiName 修改overlay网关配置
 * @apiGroup Overlay网关
 *
 *
 * @apiParam {Number} enable  overlay网关功能开关
 * @apiParam {Number} type  目前只支持vxlan封装
 * @apiParam {String} vtep_addr  VTEP地址
 * @apiParam {Number} vtep_port  VTEP端口  
 * @apiParam {String} cont_addr  Controller地址
 * @apiParam {Number} cont_port  Controller端口
 * @apiParam {Number} fresh_timer  刷新时间
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"enable": "1",
 *		"type": "1",
 *		"vtep_addr": "1.1.1.1",
 *		"vtep_port": "8848",
 *		"cont_addr": "2.2.2.2",
 *		"cont_port": "2322",
 *		"fresh_timer": "22"
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
 *		"code":"100",
 *		"str":""
 *	}
 *
 */


class OverlayController extends mController{
	public $module = 'overlay_common_config';
}

?>