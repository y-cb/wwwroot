<?php
namespace controller\policy;
use controller\mController;

/**
 * @api {get} /api/nat-trans 获取跨协议转换列表
 * @apiName 获取跨协议转换列表
 * @apiGroup NAT策略
 *
 *
 * @apiSuccess {Number} rule_id 跨协议转换ID
 * @apiSuccess {Number} type 跨协议转换类型，3表示所有，1表示NAT64，2表示NAT46
 * @apiSuccess {String} src_addr_obj 跨协议转换的源地址
 * @apiSuccess {String} dst_addr_obj 跨协议转换的目的地址
 * @apiSuccess {String} src_serv 跨协议转换服务
 * @apiSuccess {String} in_ifname 跨协议转换入接口
 * @apiSuccess {String} src_mapped_addr_type 转换后源地址
 * @apiSuccess {String} dst_pool 转换后目的地址
 * @apiSuccess {Number} trans_way 转换方式，1表示IVI，2表示嵌入地址，3表示地址池
 * @apiSuccess {Number} log 是否记录日志，0表示不启用，1表示启用
 * @apiSuccess {String} desc 描述
 *
 * @apiSuccessExample {json} Success-Response:
 *  HTTP/1.1 200 OK
    {
    "data": [
        {
            "type": "1",
        }
    ]
    }
 */

/**
 * @api {POST} /api/nat-trans 新建跨协议转换策略
 * @apiName 新建跨协议转换策略
 * @apiGroup NAT策略
 *
 *
 * @apiSuccess {Number} type 跨协议转换类型，1表示NAT64，2表示NAT46
 * @apiSuccess {String} src_addr_obj 跨协议转换的源地址
 * @apiSuccess {String} dst_addr_obj 跨协议转换的源地址
 * @apiSuccess {String} src_serv 跨协议转换服务
 * @apiSuccess {String} in_ifname 跨协议转换入接口
 * @apiSuccess {String} ivi_mapped_type 源地址类型 1表示指定源地址前缀，2表示准换后源地址
 * @apiSuccess {String} AAAA 转换后源地址
 * @apiSuccess {String} prefix_v6_1 指定目的地址前缀
 * @apiSuccess {String} src_mapped_addr_type 转换后源地址
 * @apiSuccess {String} dst_pool 转换后目的地址
 * @apiSuccess {Number} arpresponse 相应ARP，0表示不启用，1表示启用
 * @apiSuccess {Number} log 是否记录日志，0表示不启用，1表示启用
 * @apiSuccess {String} desc 描述
 *
 */

/**
 * @api {PUT} /api/nat-trans 修改跨协议转换策略
 * @apiName 修改跨协议转换策略
 * @apiGroup NAT策略
 *
 *
 * @apiSuccess {Number} type 跨协议转换类型，1表示NAT64，2表示NAT46
 * @apiSuccess {String} src_addr_obj 跨协议转换的源地址
 * @apiSuccess {String} dst_addr_obj 跨协议转换的源地址
 * @apiSuccess {String} src_serv 跨协议转换服务
 * @apiSuccess {String} in_ifname 跨协议转换入接口
 * @apiSuccess {String} ivi_mapped_type 源地址类型 1表示指定源地址前缀，2表示准换后源地址
 * @apiSuccess {String} AAAA 转换后源地址
 * @apiSuccess {String} prefix_v6_1 指定目的地址前缀
 * @apiSuccess {String} src_mapped_addr_type 转换后源地址
 * @apiSuccess {String} dst_pool 转换后目的地址
 * @apiSuccess {Number} arpresponse 相应ARP，0表示不启用，1表示启用
 * @apiSuccess {Number} log 是否记录日志，0表示不启用，1表示启用
 * @apiSuccess {String} desc 描述
 *
 */

/**
 * @api {delete} /api/nat-trans 删除跨协议转换策略
 * @apiName 删除跨协议转换策略
 * @apiGroup NAT策略
 *
 *
 * @apiSuccess {String} rule_id 跨协议转换id
 *
 */

class NatTransController extends mController{	
	public $module = 'nat_trans_rule_table_data';
}
