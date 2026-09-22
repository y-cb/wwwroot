<?php
namespace controller\object;
use controller\mController;

/**
 * @api {GET}  /api/app-category 获取所有应用分类对象信息 
 * @apiName 获取所有应用分类对象信息
 * @apiGroup 文件类型
 *
 *
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"total": 20,
 *		"data": [
			{u'show_name': u'instant-messaging', u'app_num': u'69', u'ref': u'0', u'name': u'instant-messaging'}, 
			{u'show_name': u'p2p-software', u'app_num': u'22', u'ref': u'0', u'name': u'p2p-software'}, 
			{u'show_name': u'streaming-media', u'app_num': u'148', u'ref': u'0', u'name': u'streaming-media'}, 
			{u'show_name': u'stock-software', u'app_num': u'19', u'ref': u'0', u'name': u'stock-software'}, 
			{u'show_name': u'online-game', u'app_num': u'186', u'ref': u'0', u'name': u'online-game'}, 
			{u'show_name': u'file-transfer', u'app_num': u'41', u'ref': u'0', u'name': u'file-transfer'}, 			     {u'show_name': u'search-engine', u'app_num': u'50', u'ref': u'0', u'name': u'search-engine'}, 			  {u'show_name': u'online-community', u'app_num': u'103', u'ref': u'0', u'name': u'online-community'}, 
			{u'show_name': u'database', u'app_num': u'7', u'ref': u'0', u'name': u'database'}, 
			{u'show_name': u'online-shopping', u'app_num': u'128', u'ref': u'0', u'name': u'online-shopping'}, 
			{u'show_name': u'network-protocol', u'app_num': u'99', u'ref': u'0', u'name': u'network-protocol'}, 
			{u'show_name': u'email', u'app_num': u'13', u'ref': u'0', u'name': u'email'}, 
			{u'show_name': u'telecontrol', u'app_num': u'11', u'ref': u'0', u'name': u'telecontrol'}, 
			{u'show_name': u'websites', u'app_num': u'162', u'ref': u'0', u'name': u'websites'}, 
			{u'show_name': u'proxy-software', u'app_num': u'5', u'ref': u'0', u'name': u'proxy-software'}, 
			{u'show_name': u'office-software', u'app_num': u'10', u'ref': u'0', u'name': u'office-software'}, 
			{u'show_name': u'online-update', u'app_num': u'12', u'ref': u'0', u'name': u'online-update'}, 			     {u'show_name': u'network-tools', u'app_num': u'12', u'ref': u'0', u'name': u'network-tools'}, 
			{u'show_name': u'electronic-commerce', u'app_num': u'24', u'ref': u'0', u'name': u'electronic-commerce'}, 
			{u'show_name': u'others', u'app_num': u'17', u'ref': u'0', u'name': u'others'}]
 *	}
 */


class AppCategoryController extends mController {	
	public $module = 'app_category';
}
