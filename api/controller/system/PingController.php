<?php
namespace controller\system;
use controller\mController;

/**
 * @api {GET}  /api/ping ping某个ip地址
 * @apiName ping
 * @apiGroup 系统维护
 *
 *
 * @apiParam {String} ip 需要ping的ip地址
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"ip":  "172.16.0.1"
 *	}
 *
 * @apiSuccess {String} ping_msg ping结果
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *	    "data": {
 *	        "ping_msg": "64 bytes from 172.16.0.1: seq=0 ttl=64 time=2.156 ms"
 *	    }
 *	}
 *
 * @apiErrorExample {json} Error-Response:
 *	HTTP/1.1 422 Not Found
 *	{
 *		"code":"非0"
 *	}
 *
 */

class PingController extends mController{
	public function get() {
		$param = get_inputs();
		//防止XSS注入
		$data = array('code'=>-1, str=> 'Data return error');
		//php7filter_var函数无法使用，先屏蔽校验
		// $param['ip'] = filter_var_array(array('ip'=>$param['ip']), array('ip'=>FILTER_VALIDATE_IP))? htmlspecialchars($param['ip']): '';
		if ($param['ip']) {
			$cmd = 'ping -c 1 -W 1 '. $param['ip'];
			exec($cmd, $output);
			$ping_msg = str_replace("seq=0", "", $output[1]);
			//解析ping命令返回数据
			if (is_array($output)) {
				unset($data);
				if ($output[1]) {
					$info = array('ping_msg'=> $ping_msg);
				} else {
					$info = array('ping_msg'=> 'Unreachable address');
				}
				$data['data'] = $info;
			}
		}
		echo json_encode($data);
	}
}