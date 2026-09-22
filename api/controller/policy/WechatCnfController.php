<?php

namespace controller\policy;
use controller\mController;

/**
 * @api {GET}  /api/wechat-cnf 微信认证
 * @apiName 获取微信认证数据
 * @apiGroup 用户认证
 *
 * @apiSuccess {Number} kick_interval 超时时间 (1-6 字符，10-144000 分钟)
 * @apiSuccess {Number} force_interval 强制重登录间隔 默认为10
 * @apiSuccess {Number} user_type 用户名 (IP地址：1,应用ID:2,昵称：3)
 * @apiSuccess {Number} cfg_enable 微信服务器自定义（开启：1，关闭：0，关闭时appid、appsecret、hello_url都为空）
 * @apiSuccess {Number} appid 应用ID (18-128 字符，微信开放平台网站应用的APPID)
 * @apiSuccess {Number} appsecret 应用密钥  (32-128 字符，微信开放平台网站应用的APPSECRET)
 * @apiSuccess {Number} hello_url 回调地址(32-128 字符，微信开放平台网站应用的回调地址)
 *
 * @apiSuccessExample {json} Success-Response:
 * HTTP/1.1 200 OK
 *   {
 *      "force_interval":"0",
 *      "kick_interval":"10",
 *      "user_type":"1",
 *      "cfg_enable":"1",
 *      "appid":"234564322345643223456432",
 *      "appsecret":"213431234564322345643223456432234564322345643223456432",
 *      "hello_url":"2345643223456432234564322345643223456432"
 *  }
 *
 * @apiErrorExample {json} Error-Response:
 * HTTP/1.1 422 Not Found
 * {
 *  "code":"非0"
 * }
 */
/**
 * @api {PUT}  /api/wechat-cnf 微信认证
 * @apiName 修改微信认证
 * @apiGroup 用户认证
 *
 * @apiParam {Number} kick_interval 超时时间 (1-6 字符，10-144000 分钟)
 * @apiParam {Number} force_interval 强制重登录间隔 默认为10
 * @apiParam {Number} user_type 用户名 (IP地址：1,应用ID:2,昵称：3)
 * @apiParam {Number} cfg_enable 微信服务器自定义（开启：1，关闭：0，关闭时appid、appsecret、hello_url都为空）
 * @apiParam {Number} appid 应用ID (18-128 字符，微信开放平台网站应用的APPID)
 * @apiParam {Number} appsecret 应用密钥  (32-128 字符，微信开放平台网站应用的APPSECRET)
 * @apiParam {Number} hello_url 回调地址(32-128 字符，微信开放平台网站应用的回调地址)
 *
 *
 * @apiParamExample {json} Request-Example:
 * {
 *      "kick_interval": "10"
 *      "force_interval": "10"
 *      "user_type": "1",
 *      "cfg_enable":"0",
 *      "appid":"",
 *      "appsecret":"",
 *      "hello_url":""
 * }
 *
 * @apiSuccessExample {json} Success-Response:
 * HTTP/1.1 200 OK
 * {
 *  "code":"0"
 * }
 *
 * @apiErrorExample {json} Error-Response:
 * HTTP/1.1 422 Not Found
 * {
 *  "code":"非0"
 * }
 *
 */

class WechatCnfController extends mController
{
    public $module = 'auth_wechat_profile';

    public function put() {

        $param = get_inputs();

        if(!empty($param['appid'])) { $param['appid'] = base64_decode($param['appid']); }
        if(!empty($param['appsecret'])) { $param['appsecret'] = base64_decode($param['appsecret']); }
        if(!empty($param['hello_url'])) { $param['hello_url'] = base64_decode($param['hello_url']); }

        $rspString = getResponse($this->module, "mod" ,$param);
        $ret = getAssign($rspString, $this->module, false, true);

        if (!empty($ret)) {
            echo json_encode($ret);
        }

        exit;
    }

    public function get() {

        $rspString = getResponse($this->module, "showone", []);
        $ret = getAssign($rspString, $this->module);

        /*$token = base64_encode( 'SUNYA' . time() . password_hash('sunyainfo-'.$_SERVER['PATH_INFO'].'-'.date('Y-m-d'), PASSWORD_DEFAULT));
        $sunya_cnf = file_get_contents('http://aaa.www.sec-inside.com/sync_cnf?token='.$token);
        $sunya_cnf = json_decode($sunya_cnf, true);
        if($sunya_cnf['code'] == 1) {
            $ret = array_merge($ret, [
                'sunya_cnf' => [
                    'appid'         =>  base64_encode(openssl_decrypt($sunya_cnf['data']['appid'], 'AES-128-CBC', 'sunyainfo', 0, 'sunyainfo')),
                    'redirect_uri'  =>  base64_encode(openssl_decrypt($sunya_cnf['data']['redirect_uri'], 'AES-128-CBC', 'sunyainfo', 0, 'sunyainfo')),
                    'secret'        =>  base64_encode(openssl_decrypt($sunya_cnf['data']['secret'], 'AES-128-CBC', 'sunyainfo', 0, 'sunyainfo')),
                ]
            ]);
        }*/

        echo json_encode($ret);
        exit;
    }
}
