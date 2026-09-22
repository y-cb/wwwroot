<?php
namespace controller\system;
use controller\mController;
/**
 * @api {GET}  /api/time 获取系统时间设置选项
 * @apiName 获取系统时间设置选项
 * @apiGroup 系统设置
 *
 *
 * @apiSuccess {Number} clock_type  时钟类型(手动0; NTP:1)
 * @apiSuccess {Number} time_zone  时区选择 <0-75>
 * @apiSuccess {String} sys_clock 系统时间
 * @apiSuccess {String} year  年
 * @apiSuccess {String} mon  月 <1-12>
 * @apiSuccess {String} day  日 <1-31>
 * @apiSuccess {String} hour  时<0-23>
 * @apiSuccess {String} min  分<0-59>
 * @apiSuccess {String} sec  秒<0-59>
 * @apiSuccess {String} ntp_server_ip  ntp服务器
 * @apiSuccess {Number} ntp_interval  ntp同步间隔 <5-65535>
 * @apiSuccess {Number} ntp_key_id  ntp认证id
 * @apiSuccess {String} ntp_key  ntp认证key
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *                "hour": "8",
 *                "min": "34",
 *                "time_zone": "57",
 *                "sys_clock": "Thu May 10 08:34:54 2018\n",
 *                "ntp_server_ip": "",
 * 	       	  "ntp_interval": "",
 *	    	  "sec": "54",
 *                "mon": "5",
 *                "year": "18",
 *                "clock_type": "0",
 * 		  "day": "10",
 *		{
 *		  "hour": "19",
 *	          "min": "10",
 *	          "ntp_key_id"a: "11",
 *                "time_zone": "66",
 *                "sys_clock": "Thu May 10 19:10:41 2018\n",
 *                "ntp_server_ip": "pool.ntp.org",
 *                "ntp_interval": "5",
 *                "sec": "41",
 *                "mon": "5",
 *                "year": "18",
 *                "clock_type": "1",
 *                "day": "10",
 *                "ntp_key": "asddas"
 *		}
 *	],
 *	"total": 2
 *	}
 */

/**
 * @api {PUT}  /api/time 配置系统时间选项
 * @apiName 配置系统时间选项
 * @apiGroup 系统设置
 *
 * @apiSuccess {Number} clock_type  时钟类型(手动0; NTP:1)
 * @apiSuccess {Number} time_zone  时区选择 <0-75>
 * @apiSuccess {String} sys_clock 系统时间
 * @apiSuccess {String} year  年
 * @apiSuccess {String} mon  月 <1-12>
 * @apiSuccess {String} day  日 <1-31>
 * @apiSuccess {String} hour  时<0-23>
 * @apiSuccess {String} min  分<0-59>
 * @apiSuccess {String} sec  秒<0-59>
 * @apiSuccess {String} ntp_server_ip  ntp服务器
 * @apiSuccess {Number} ntp_interval  ntp同步间隔 <5-65535>
 * @apiSuccess {Number} ntp_key_id  ntp认证id
 * @apiSuccess {String} ntp_key  ntp认证key
 *
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"clock_type": "0",
 *		"time_zone": "66",
 *		"year": "18",
 *		"mon": "5",
 *		"day": "10",
 *		"hour": "19",
 *		"min": "18",
 *		"sec": "15",
 *		"ntp_server_ip": "pool.ntp.org",
 *		"ntp_interval": "5",
 *		"ntp_key_id": "11",
 *		"ntp_key": "asddas"
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *	}
 *
 * @apiErrorExample {json} Error-Response:
 *	HTTP/1.1 422 Not Found
 *	{
 *	}
 *
 */

class TimeConfigController extends mController{
	public $module = 'time_config';
	function get (){
		$param = get_inputs();
		$data = array();
		if (isset($param['ntp_key'])) {
			$pattern_cn = '/[\x{4e00}-\x{9fa5}]/u';
			$res_cn =  preg_match($pattern_cn, $param['ntp_key']);
			if($res_cn>0){
				$ret = array('code' => '-1', 'str' => t('system_time.key_err'));
				echo json_encode($ret);
				return;
			}
			$param['ntp_key'] = bin2hex(htmlspecialchars_decode($param['ntp_key']));
		}
		$rspString = getResponse($this->module, "show" ,$param);
	    $ret = getAssign($rspString, $this->module, false, true);

	   	if(empty($ret)) {
	   		$data['data'] = array();
	   		$data['total'] = 0;
	   	} else {
	   		foreach ($ret['group'] as $key => $value) {
	   			if ($value['ntp_key']) {
	   				$value['ntp_key'] = hex2bin($value['ntp_key']);
	   			}
	   			$data['data'][] = $value;
	   		}
	   		if (isset($ret['page'])) {
	   			$data['total'] = (int)$ret['page']['total'];
	   		} else {
	   			$data['total'] = (int)count($data['data']);
	   		}
	   	}

	   	header('Content-type: application/json');
	   	echo json_encode($data);
	}

	function put () {

		$param = get_inputs();

        //ntp服务器字段检测
        $ntp_reg_check = false;
        $ntp_domain_reg = "/^(([0-9a-zA-Z]+)|([0-9a-zA-Z]+[_.0-9a-zA-Z-]*[0-9a-zA-Z]+))(([a-zA-Z0-9-]+[.])+([a-zA-Z]{2}|net|NET|com|COM|gov|GOV|mil|MIL|org|ORG|edu|EDU|int|INT|cn|CN)|((2[0-4]\d|25[0-5]|[01]?\d\d?)\.){3}(2[0-4]\d|25[0-5]|[01]?\d\d?))$/";
        $ntp_ipv4_reg = "/^(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$/";
        $ntp_ipv6_reg = "/^([\da-fA-F]{1,4}:){6}(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])(\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])){3}$|^([\da-fA-F]{1,4}:){1,5}:(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])(\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])){3}$|^::(([\da-fA-F]{1,4}:){0,5})(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])(\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])){3}$|^([\da-fA-F]{1,4}::([\da-fA-F]{1,4}:){0,4})(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])(\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])){3}$|^(([\da-fA-F]{1,4}:){2}:([\da-fA-F]{1,4}:){0,3})(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])(\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])){3}$|^(([\da-fA-F]{1,4}:){3}:([\da-fA-F]{1,4}:){0,2})(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])(\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])){3}$|^(([\da-fA-F]{1,4}:){4}:([\da-fA-F]{1,4}:){0,1})(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])(\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])){3}$|^:((:[\da-fA-F]{1,4}){1,7}|:)$|^([\da-fA-F]{1,4}:){1}((:[\da-fA-F]{1,4}){1,6}|:)$|^([\da-fA-F]{1,4}:){2}((:[\da-fA-F]{1,4}){1,5}|:)$|^([\da-fA-F]{1,4}:){3}((:[\da-fA-F]{1,4}){1,4}|:)$|^([\da-fA-F]{1,4}:){4}((:[\da-fA-F]{1,4}){1,3}|:)$|^([\da-fA-F]{1,4}:){5}((:[\da-fA-F]{1,4}){1,2}|:)$|^([\da-fA-F]{1,4}:){6}((:[\da-fA-F]{1,4})|:)$|^([\da-fA-F]{1,4}:){7}(([\da-fA-F]{1,4})|:)$/";
        if(
            preg_match($ntp_domain_reg, $param['ntp_server_ip']) ||
            preg_match($ntp_ipv4_reg, $param['ntp_server_ip']) ||
            preg_match($ntp_ipv6_reg, $param['ntp_server_ip'])
        ) {
            $ntp_reg_check = true;
        }

		//MD5可输入任意字符
		if ($param['clock_type']== '1') {
			$pattern_cn = '/[\x{4e00}-\x{9fa5}]/u';
			$res_cn =  preg_match($pattern_cn, $param['ntp_key']);
			if($res_cn>0){
				$ret = array('code' => '-1', 'str' => t('system_time.key_err'));
				echo json_encode($ret);
				return;
			}
			$param['ntp_key'] = bin2hex(htmlspecialchars_decode($param['ntp_key']));
		}

        if ($param['clock_type'] == '0' && !empty($param['ntp_server_ip'])) {
            $ret = array('code' => '-1', 'str' => t('system_time.parameter_err'));
            echo json_encode($ret);
            return;
        }
        if ($param['clock_type'] == '1' && (!$ntp_reg_check && !filter_var($param['ntp_server_ip'], FILTER_VALIDATE_IP))){
            $ret = array('code' => '-1', 'str' => t('system_time.server_err'));
            echo json_encode($ret);
            return;
        }

		$rspString = getResponse($this->module, "mod" ,$param);

		$ret = getAssign($rspString, $this->module);
		header('Content-type: application/json');
		if (!empty($ret)) {
			echo json_encode($ret);
		}
	}
}

