<?php
namespace controller\policy;
use controller\mController;

/**
 * @api {GET} /api/nbc-tm 获取流量控制策略
 * @apiName 获取流量控制策略
 * @apiGroup 流控策略
 *
 *
 * @apiSuccess {Number} id  流控策略ID
 * @apiSuccess {String} name  流控策略名称
 * @apiSuccess {String} parent_name  线路名称
 * @apiSuccess {Number} _parentId  线路ID
 * @apiSuccess {String} schedule  时间对象
 * @apiSuccess {Number} egress_max   出接口的带宽流量
 * @apiSuccess {Number} ingress_max  入接口的最大带宽流量
 * @apiSuccess {Number} ingress_guaran  入接口配置保障带宽
 * @apiSuccess {Number} egress_guaran  出接口配置保障带宽
 * @apiSuccess {Number} ingress_guaran_true  入接口配置保障带宽
 * @apiSuccess {Number} egress_guaran_true  出接口配置保障带宽
 * @apiSuccess {Number} egress_perip  出接口每IP限速
 * @apiSuccess {Number} ingress_perip  入接口每IP限速
 * @apiSuccess {String} priority  策略优先级
 * @apiSuccess {Array} 	users 用户
 * @apiSuccess {Array}  apps  应用
 * @apiSuccess {Array}  serves  服务
 * @apiSuccess {Array}  src_addr   原地址
 * @apiSuccess {String} user_items  用户类型
 * @apiSuccess {String} app_items  应用类型
 * @apiSuccess {String} src_addr_items  原地址类型
 * @apiSuccess {String} server_items  服务类型
 * @apiSuccess {Number} move_up  上移
 * @apiSuccess {Number} move_down  下移
 * @apiSuccess {Number} enable 	启用策略（1为启用策略，0为不启用策略）
 * @apiSuccess {String} dummy  XXX 此处替换为对dummy 的中文注释
 * @apiSuccess {Array}  children_num  子策略个数
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"id": "3",
 *			"name": "aaa",
 *			"parent_name": "1",
 *			"schedule": "always",
 *			"egress_max": "102400",
 *			"ingress_max": "102400",
 *			"ingress_guaran": "102400",
 *			"egress_guaran": "102400",
 *			"egress_perip": "1024",
 *			"ingress_perip": "1024",
 *			"priority": "H+",
 *			"users": "any",
 *			"apps": "any",
 *			"server": "any",
 *			"src_addr": "any",
 *			"user_items": "any",
 *			"app_items": "any",
 *			"src_addr_items": "any",
 *			"server_items": "any",
 *			"move_up": "0",
 *			"move_down": "0",
 *			"enable": "1",
 *			"ingress_guaran_true": "85333",
 *			"egress_guaran_true": "85333",
 *			"egress_perip": "1024",
 *	        "egress_bps": "0",
 *			"ingress_enable": "1",
 *			"children_num": "0",
 *			
 *		},
 *		{
 "id": "3",
 *			"name": "def_AAAAA",
 *			"parent_name": "1",
 *			"schedule": "always",
 *			"egress_max": "102400",
 *			"ingress_max": "102400",
 *			"ingress_guaran": "20480",
 *			"egress_guaran": "20480",
 *			"egress_perip": "1024",
 *			"ingress_perip": "1024",
 *			"priority": "L",
 *			"users": "",
 *			"apps": "",
 *			"server": "",
 *			"src_addr": "",
 *			"user_items": "any",
 *			"app_items": "any",
 *			"src_addr_items": "any",
 *			"server_items": "any",
 *			"move_up": "0",
 *			"move_down": "0",
 *			"enable": "1",
 *			"ingress_guaran_true": "17067",
 *			"egress_guaran_true": "17067",
 *			"egress_perip": "1024",
 *	        "egress_bps": "0",
 *			"ingress_enable": "1",
 *			"children_num": "0"
 *		}
 *	],
 *	"total": 2
 *	}
 */

/**
 * @api {POST} /api/nbc-tm 添加流量控制策略
 * @apiName 添加流量控制策略
 * @apiGroup 流控策略
 *
 *
 * @apiSuccess {String} name  流控策略名称
 * @apiSuccess {String} parent_name  线路名称
 * @apiSuccess {String} schedule  时间对象
 * @apiSuccess {Number} egress_max   出接口的最大带宽流量
 * @apiSuccess {Number} ingress_max  入接口的最大带宽流量
 * @apiSuccess {Number} ingress_guaran  入接口配置保障带宽
 * @apiSuccess {Number} egress_guaran  出接口配置保障带宽
 * @apiSuccess {Number} egress_perip  出接口每IP限速（范围：0-7为不设置；范围：8-10485760为设置）
 * @apiSuccess {Number} ingress_perip  入接口每IP限速（范围：0-7为不设置；范围：8-10485760为设置）
 * @apiSuccess {String} priority  策略优先级
 * @apiSuccess {Number} egress_enable   出接口带宽流量控制是否启用(1为启用，0为不启用)
 * @apiSuccess {Number} ingress_enable  入接口带宽流量控制是否启用(1为启用，0为不启用)
 * @apiSuccess {Number} app_check 是否匹配用户/用户组(1为匹配，0为不匹配)
 * @apiSuccess {Number} user_check  是否匹配应用(1为匹配，0为不匹配)
 * @apiSuccess {Array} 	users 用户
 * @apiSuccess {Array}  apps  应用
 * @apiSuccess {Array}  serves  服务
 * @apiSuccess {Array}  src_addr   原地址
 * @apiSuccess {String} user_items  用户类型
 * @apiSuccess {String} app_items  应用类型
 * @apiSuccess {String} src_addr_items  原地址类型
 * @apiSuccess {String} server_items  服务类型
 * @apiSuccess {Number} move_up  上移
 * @apiSuccess {Number} move_down  下移
 * @apiSuccess {Number} enable 	策略启用（1为启用策略，0为不启用策略）
 * @apiSuccess {String} dummy  XXX 此处替换为对dummy 的中文注释
 * @apiSuccess {Array}  children_num  子策略个数
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "ccc",
 *		"parent_name": "AAAAA",
 *		"schedule": "always",
 *		"egress_max": "102400",
 *		"ingress_max": "10240",
 *		"ingress_guaran": "10240",
 *		"egress_guaran": "102400",
 *		"egress_perip": "1024",
 *		"ingress_perip": "1024",
 *		"priority": "H+",
 *		"src_addr_items": "aaa",
 *		"server_items": "dhcp",
 *		"user_items": "anonymous",
 *		"app_items": "instant-messaging",
 *		"src_addr_items": "aaa",
 *		"enable": "0",
 *		"top_id": "1",
 *		"app_check": "1",
 *		"user_check": "1"
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"code":""
 *	}
 *
 * @apiErrorExample {json} Error-Response:
 *	HTTP/1.1 422 Not Found
 *	{
 *		"code":"-1",
 *		"str":"\u5df2\u7ecf\u6709\u540c\u540d\u7684QOS\u7ebf\u8def\u6216\u8005\u7ba1\u9053\u5b58\u5728\u3002"
 *	}
 *
 */

/**
 * @api {PUT} /api/nbc-tm 修改流量控制策略
 * @apiName 修改流量控制策略
 * @apiGroup 流控策略
 *
 *
 * @apiSuccess {String} name  流控策略名称
 * @apiSuccess {String} parent_name  线路名称
 * @apiSuccess {String} schedule  时间对象
 * @apiSuccess {Number} egress_max   出接口的带宽流量
 * @apiSuccess {Number} ingress_max  入接口的最大带宽流量
 * @apiSuccess {Number} ingress_guaran  入接口配置保障带宽
 * @apiSuccess {Number} egress_guaran  出接口配置保障带宽
 * @apiSuccess {Number} egress_perip  出接口每IP限速（范围：0-7为不设置；范围：8-10485760为设置）
 * @apiSuccess {Number} ingress_perip  入接口每IP限速（范围：0-7为不设置；范围：8-10485760为设置）
 * @apiSuccess {String} priority  策略优先级
 * @apiSuccess {Number} egress_enable， 出接口带宽流量控制是否启用(1为启用，0为不启用)
 * @apiSuccess {Number} ingress_enable  入接口带宽流量控制是否启用(1为启用，0为不启用)
 * @apiSuccess {Number} app_check 是否匹配用户/用户组(1为匹配，0为不匹配)
 * @apiSuccess {Number} user_check  是否匹配应用(1为匹配，0为不匹配)
 * @apiSuccess {Array} 	users 用户
 * @apiSuccess {Array}  apps  应用
 * @apiSuccess {Array}  serves  服务
 * @apiSuccess {Array}  src_addr   原地址
 * @apiSuccess {String} user_items  用户类型
 * @apiSuccess {String} app_items  应用类型
 * @apiSuccess {String} src_addr_items  原地址类型
 * @apiSuccess {String} server_items  服务类型
 * @apiSuccess {Number} move_up  上移
 * @apiSuccess {Number} move_down  下移
 * @apiSuccess {Number} enable 	策略启用（1为启用策略，0为不启用策略）
 * @apiSuccess {String} dummy  XXX 此处替换为对dummy 的中文注释
 * @apiSuccess {Array}  children_num  子策略个数
 * @apiSuccess {Number} top_id  ID号
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "ccc",
 *		"parent_name": "AAAAA",
 *		"schedule": "always",
 *		"egress_max": "102400",
 *		"ingress_max": "10240",
 *		"ingress_guaran": "10240",
 *		"egress_guaran": "102400",
 *		"egress_perip": "1024",
 *		"ingress_perip": "1024",
 *		"priority": "H+",
 *		"src_addr_items": "aaa",
 *		"server_items": "dhcp",
 *		"user_items": "anonymous",
 *		"app_items": "instant-messaging",
 *		"src_addr_items": "aaa",
 *		"enable": "1",
 *		"top_id": "1",
 *		"app_check": "1",
 *		"user_check": "1"
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"code":""
 *	}
 *
 *
 */

/**
 * @api {DELETE} /api/nbc-tm 删除流量控制策略
 * @apiName 删除流量控制策略
 * @apiGroup 流控策略
 *
 *
 * @apiSuccess {String} name  流控策略名称
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "ccc"
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"code":""
 *	}
 *
 * @apiErrorExample {json} Error-Response:
 *	HTTP/1.1 422 Not Found
 *	{
 *		"code":"-1",
 *		"str":"QOS\u5bf9\u8c61\u4e0d\u5b58\u5728\u3002"
 *	}
 *
 */


class NbcTmController extends mController {
	public $module = 'nbc_tm_policy';
	function get() {
         $data = array();
		 $param = get_inputs();
		 $id = '';
		 $rspString = getResponse($this->module, "showindex" ,$param);
		 $ret = getAssign($rspString, $this->module, false, true);
		 $num = count($ret['group']);
		 //如果为查询动作，拼接子项名称
		 if ($param['name']){$name = 'def_'.$param['name'];}
		 for($i=0;$i<$num;$i++){
		 	//从子项名称获取父项id
		 	if ($param['name'] && $name == $ret['group'][$i]['name']) {
		 		$id = $ret['group'][$i]['_parentId'];
		 	}
		 	$ret['group'][$i]['src_addrs']=$ret['group'][$i]['src_addrs']['group']['name'];
			$ret['group'][$i]['users']=$ret['group'][$i]['users']['group']['name'];
			$ret['group'][$i]['apps']=$ret['group'][$i]['apps']['group']['name'];
			$ret['group'][$i]['serves']=$ret['group'][$i]['serves']['group']['name'];
		 }
		 //如果为树状查询，重新整合数据
		 if ($param['name']) {
		 	//不修改原逻辑添加临时变量
		 	$tmp = $ret;
		 	$ret = array();
			foreach ($tmp['group'] as $key => $value) {
				if ($value['_parentId'] == $id) {
					$ret['group'][] = $tmp['group'][$key];
				}
			}
		 }
         header('Content-type: application/json');  
		 if (empty($ret)) {
			echo json_encode(array());
		 } else {
		 	$data['data'] = $ret['group'];
            if (isset($ret['page'])) {
                $data['total'] = (int)$ret['page']['total'];
            } else {
                $data['total'] = (int)count($data['data']);
            }
		 	echo json_encode($data);
		 }
    }
    /*function put(){
		$data = array();
		$param = get_inputs();
		$rspString = getResponse( $this->module, "mod" , $param);
		$ret = getAssign($rspString, $this->module);
		 header('Content-type: application/json');
		 if (!empty($ret)) {
		 	echo json_encode($ret);
		 }
		$param = getAssign($rspString, 0);
		$ret = '';
		if($param[code])
			$ret = $param[str];
		echo $ret;
		return;
    }*/
}

