<?php
namespace controller\policy;
use controller\mController;

/**
 * @api {GET}  /api/auth-policy 获取认证策略
 * @apiName auth-policy
 * @apiGroup 用户策略
 *
 *
 * @apiSuccess {Number} id ID
 * @apiSuccess {Number} dst_id 目的地址
 * @apiSuccess {String} ifz_in 入接口
 * @apiSuccess {String} ifz_out 出接口
 * @apiSuccess {String} addr_src 源地址
 * @apiSuccess {String} addr_dst 目的地址
 * @apiSuccess {String} sche 时间
 * @apiSuccess {String} whlist 认证域名白名单
 * @apiSuccess {String} move "head" "tail" "before" "after"
 * @apiSuccess {String} action 相关行为
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"id": "1",
 *			"enable": "1",
 *			"ifz_in": "ge0/0",
 *			"ifz_out": "ge0/3",
 *			"addr_src": "any",
 *			"addr_dst": "any",
 *			"sche": "always",
 *			"whlist": "域名白名单",
 *			"action": "local-webauth"
 *		},
 *		{
 *			"id": "2",
 *			"enable": "1",
 *			"ifz_in": "any",
 *			"ifz_out": "any",
 *			"addr_src": "any",
 *			"addr_dst": "any",
 *			"sche": "always",
 *			"whlist": "域名白名单",
 *			"action": "portal-server-webauth"
 *		}
 *	],
 *	"total": 2
 *	}
 */

/**
 * @api {GET}  /api/auth-policy 获取单个认证策略
 * @apiName auth-policy
 * @apiGroup 用户策略
 *
 *
 * @apiSuccess {Number} id ID
 * @apiSuccess {String} op 操作
 *
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"id": "1",
 *		"op": "detail_o"
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"id": "1",
 *		"enable": "1",
 *		"ifz_in": "ge0/0",
 *		"ifz_out": "ge0/3",
 *		"addr_src": "any",
 *		"addr_dst": "any",
 *		"sche": "always",
 *		"whlist": "域名白名单",
 *		"action": "local-webauth"
 *	}
 */

/**
 * @api {POST}  /api/auth-policy 添加认证策略
 * @apiName auth-policy
 * @apiGroup 用户策略
 *
 *
 * @apiParam {Number} id ID 固定为0，系统分配
 * @apiParam {String} ifz_in 入接口
 * @apiParam {String} ifz_out 出接口
 * @apiParam {String} addr_dst 目的地址
 * @apiParam {String} sche 时间
 * @apiParam {String} action 相关行为
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"ifz_in": "any",
 *		"addr_src": "any",
 *		"ifz_out": "any",
 *		"addr_dst": "any",
 *		"action": "local-webauth",
 *		"sche": "always",
 *		"whlist": "域名白名单",
 *		"id": "0"
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
 *		"code":"非0",
 *		"str":""
 *	}
 *
 */

/**
 * @api {PUT}  /api/auth-policy 修改认证策略
 * @apiName auth-policy
 * @apiGroup 用户策略
 *
 *
 * @apiParam {Number} id ID
 * @apiParam {String} ifz_in 入接口
 * @apiParam {String} ifz_out 出接口
 * @apiParam {String} addr_src 源地址
 * @apiParam {String} addr_dst 目的地址
 * @apiParam {String} sche 时间
 * @apiParam {String} whlist 认证域名白名单
 * @apiParam {String} action 相关行为
 *
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"ifz_in": "any",
 *		"addr_src": "any",
 *		"ifz_out": "any",
 *		"addr_dst": "any",
 *		"action": "portal-server-webauth",
 *		"sche": "always",
 *		"whlist": "域名白名单",
 *		"id": "3"
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
 *		"code":"非0",
 *		"str":""
 *	}
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"move": "before",
 *		"dst_id": "2",
 *		"id": "3"
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
 *		"code":"非0",
 *		"str":""
 *	}
 */

/**
 * @api {DELETE}  /api/auth-policy 删除认证策略
 * @apiName auth-policy
 * @apiGroup 用户策略
 *
 *
 * @apiParam {Number} id ID
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"id": "3"
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
 *		"code":"非0",
 *		"str":""
 *	}
 *
 */


class AuthPolicyController extends mController {

    public $module = 'user_policy';
    private $addModule = 'addr_obj_table';
    private $object_default_name = 'def_wechat_whitelist_policy';
    private $object_default_desc = 'wechat domain white list';
    private $config_path = '/mnt/boot/wechat_whitelist_policy';
    private $whitelist_path = '/mnt/boot/wechat_whitelist_detail';

    public function post() {

        header('Content-type: application/json');

        $param = get_inputs();

        $rspString = getResponse($this->module, 'add' ,$param);
        $ret = getAssign($rspString, $this->module);

        if($ret['code'] == -2) { //不存在地址对象，创建微信白名单地址对象

            $cache = @json_decode(@file_get_contents($this->whitelist_path));
            if(!$cache) {
                $cache = [
                    ['domain_name'=> 'open.weixin.qq.com', 'type'=> '9', 'exclude'=> '0'],
                    ['domain_name'=> 'res.wx.qq.com', 'type'=> '9', 'exclude'=> '0'],
                    ['domain_name'=> 'lp.open.weixin.qq.com', 'type'=> '9', 'exclude'=> '0'],
                    ['domain_name'=> 'aaa.www.sec-inside.com', 'type'=> '9', 'exclude'=> '0'],
                ];
            }

            $object_name = $this->get_object_name($this->object_default_name);
            $data = [
                'name'=> $object_name,
                'desc'=> $this->object_default_desc,
                'type'=> '0',
                'fresh_time'=> 60,
                'item'=> $cache,
            ];
            $edit_ret = getAssign(getResponse($this->addModule, 'add', $data), $this->addModule);
            if(empty($edit_ret)) {
                @file_put_contents($this->config_path, $data['name']);
            }
            $rspString = getResponse($this->module, 'add' ,$param);
            getAssign($rspString, $this->module);
        }
    }

    protected function get_object_name($name) {
        $rspString = getResponse($this->module, 'showone', ['addr_type'=> 1, 'ip_type'=> 1, 'name'=> $name,'ref'=> -1]);
        $object = getAssign($rspString, $this->module);

        if (!empty($object) && $object['desc']!= $this->object_default_desc) {
            $basename = ($name === $this->object_default_name)? $name: $this->object_default_name;
            $random = mt_rand(1000, 9999);

            $new_name = $basename . '_' . $random;
            return $this->get_object_name($new_name);
        } else {
            return $name;
        }
    }
}