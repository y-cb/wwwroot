<?php
namespace controller\object;
use controller\mController;

/**
 * @api {POST}  /api/address-group 添加地址组对象
 * @apiName 添加地址组对象
 * @apiGroup 地址对象
 *
 *
 * @apiParam {String} name 地址组对象名称
 * @apiParam {String} desc 地址组对象描述
 * @apiParam {Array} item 该地质组对象应用的地址对象数组，"addr_name"引用的地址对象的名称
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "alan_addr_grp",
 *		"desc": "Just a test",
 *		"item": [{"addr_name":"bbbb"}, {"addr_name":"my_new"}]
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
 * @api {get}  /api/address-group 获取所有地址组对象信息
 * @apiName 获取所有地址组对象信息
 * @apiGroup 地址对象
 * @apiParamExample {json} Request-Example:
 *	{
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		total: 2
 *		data: [
			{u'type': u'0', u'ref': u'0', u'name': u'bbb', u'item': {u'group': {u'addr_name': u'bbbb'}}, u'desc': u'ssss'}, 
			{u'type': u'0', u'ref': u'0', u'name': u'alan_addr_grp', u'item': {u'group': {u'addr_name': u'my_new'}}, u'desc': u'Just a test'}
		      ]
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
 * @api {get}  /api/address-group 获取单个地址组对象信息
 * @apiName 获取单个地址组对象信息
 * @apiGroup 地址对象
 * @apiParamExample {json} Request-Example:
 *	{
		"name":"alan_addr_grp"
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		total: 1
 *		data: [
			{u'type': u'0', u'ref': u'0', u'name': u'alan_addr_grp', u'item': {u'group': {u'addr_name': u'my_new'}}, u'desc': u'Just a test'}
		      ]
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
 * @api {DELETE}  /api/address-group 删除地址组对象
 * @apiName 删除地址组对象
 * @apiGroup 地址对象
 *
 *
 * @apiParam {String} name 要删除的地址组对象名称
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "alan_addr_grp"
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



class AddressDetailController extends mController {	
	public $module = 'domain_obj_addr_detail';
}
