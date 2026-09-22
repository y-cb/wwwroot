<?php
namespace controller\network;
use controller\mController;

/**
 * @api {GET}  /api/ospf-area 查询ospf区域配置
 * @apiName 查询ospf区域配置
 * @apiGroup IPv4路由
 *
 *
 * @apiSuccess {String} vrf_name  ospf区域所属vrf名称
 * @apiSuccess {String} area_id  区域id
 * @apiSuccess {Number} auth_type  认证类型  0-none/1-text/2-md5
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"vrf_name": "vrf0",
 *			"area_id": "1",
 *			"auth_type": "0"
 *		}
 *	],
 *	"total": 1
 *	}
 */

/**
 * @api {PUT}  /api/ospf-area 修改ospf区域配置
 * @apiName 修改ospf区域配置
 * @apiGroup IPv4路由
 *
 *
 * @apiParam {String} vrf_name  ospf区域所属vrf名称
 * @apiParam {String} area_id  区域id
 * @apiParam {Number} auth_type  认证类型, 0-none/1-text/2-md5
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"vrf_name": "vrf0",
 *		"area_id": "1",
 *		"auth_type": "1"
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
 *		"code":"10",
 *		"str":""
 *	}
 *
 */


class OspfAreaController extends mController{
	public $module = 'ospf_area';
}

?>