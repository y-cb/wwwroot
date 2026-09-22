<?php
namespace controller\network;
use controller\mController;

/**
 * @api {GET}  /api/dhcp-exclusion 获取DHCP地址排除范围
 * @apiName 获取DHCP地址排除范围
 * @apiGroup DHCP
 *
 *
 * @apiSuccess {String} vrf_name  指定需获取DHCP地址排除范围所对应的VRF名称 此名称可在'系统>VRF'界面查询,可不填写
 * @apiSuccess {Number} id  DHCP地址排除范围ID  GET操作可不填写
 * @apiSuccess {String} ip_start  DHCP地址排除范围开始地址  GET操作可不填写
 * @apiSuccess {String} ip_end  DHCP地址排除范围结束地址  GET操作可不填写
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"vrf_name": "vrf0",
 *			"id": "1",
 *			"ip_start": "10.0.0.1",
 *			"ip_end": "10.0.0.10"
 *		},
 *		{
 *			"vrf_name": "vrf0",
 *			"id": "2",
 *			"ip_start": "20.0.0.1",
 *			"ip_end": "20.0.0.10"
 *		}
 *	],
 *	"total": 2
 *	}
 */

/**
 * @api {POST}  /api/dhcp-exclusion 新增DHCP地址排除范围
 * @apiName 新增DHCP地址排除范围
 * @apiGroup DHCP
 *
 *
 * @apiSuccess {String} vrf_name  指定需获取DHCP地址排除范围所对应的VRF名称 此名称可在'系统>VRF'界面查询,可不填写
 * @apiParam {Number} id  XXX DHCP地址排除范围ID, POST操作可不填写
 * @apiParam {String} ip_start  DHCP地址排除范围开始地址
 * @apiParam {String} ip_end  DHCP地址排除范围结束地址
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"vrf_name": "vrf0",
 *		"ip_start": "10.0.0.1",
 *		"ip_end": "10.0.0.10"
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
 *		"code":"193",
 *		"str":""
 *	}
 *
 */

/**
 * @api {PUT}  /api/dhcp-exclusion 修改DHCP地址排除范围
 * @apiName 修改DHCP地址排除范围
 * @apiGroup DHCP
 *
 *
 * @apiSuccess {String} vrf_name  指定需获取DHCP地址排除范围所对应的VRF名称 此名称可在'系统>VRF'界面查询,可不填写
 * @apiParam {Number} id  DHCP地址排除范围ID,必填
 * @apiParam {String} ip_start  DHCP地址排除范围开始地址
 * @apiParam {String} ip_end  DHCP地址排除范围结束地址
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"vrf_name": "vrf0",
 *		"id": "1",
 *		"ip_start": "20.0.0.1",
 *		"ip_end": "20.0.0.10"
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
 *		"code":"193",
 *		"str":""
 *	}
 *
 */

/**
 * @api {DELETE}  /api/dhcp-exclusion 删除DHCP地址排除范围
 * @apiName 删除DHCP地址排除范围
 * @apiGroup DHCP
 *
 *
 * @apiSuccess {String} vrf_name  指定需获取DHCP地址排除范围所对应的VRF名称 此名称可在'系统>VRF'界面查询,可不填写
 * @apiParam {Number} id  DHCP地址排除范围ID
 * @apiParam {String} ip_start  DHCP地址排除范围开始地址, delete操作可不填写
 * @apiParam {String} ip_end  DHCP地址排除范围结束地址, delete操作可不填写
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"vrf_name": "vrf0",
 *		"id": "1"
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
 *		"code":"1",
 *		"str":"
 *	}
 *
 */


class DhcpExclusionController extends mController{
	public $module = 'dhcp_exclusion';
}

?>
