<?php
namespace controller\policy;
use controller\mController;

/**
 * @api {GET}  /api/ips-rule 获取入侵防护策略
 * @apiName ips-rule
 * @apiGroup 获取防护策略
 *
 *
 * @apiSuccess {String} name 策略名称
 * @apiSuccess {String} src_zone 入接口
 * @apiSuccess {String} dst_zone 出接口
 * @apiSuccess {String} src 源地址
 * @apiSuccess {String} dst 目的地址
 * @apiSuccess {String} set 事件集
 * @apiSuccess {Number} id 策略ID
 * @apiSuccess {Number} enable 启用状态
 * @apiSuccess {Number} log 是否记录日志
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"name": "test",
 *			"src_zone": "any",
 *			"dst_zone": "any",
 *			"src": "any",
 *			"dst": "any",
 *			"set": "All",
 *			"id": "1",
 *			"enable": "1",
 *			"log": "1"
 *		},
 *		{
 *			"name": "test1",
 *			"src_zone": "any",
 *			"dst_zone": "ge0/0",
 *			"src": "any",
 *			"dst": "any",
 *			"set": "All",
 *			"id": "2",
 *			"enable": "1",
 *			"log": "1"
 *		}
 *	],
 *	"total": 2
 *	}
 */

/**
 * @api {POST}  /api/ips-rule 添加入侵防护策略
 * @apiName ips-rule
 * @apiGroup 添加防护策略
 *
 *
 * @apiParam {String} name 策略名称
 * @apiParam {String} src_zone 入接口
 * @apiParam {String} dst_zone 出接口
 * @apiParam {String} src 源地址
 * @apiParam {String} dst 目的地址
 * @apiParam {String} set 事件集
 * @apiParam {Number} id 策略ID
 * @apiParam {Number} refer_id 移动参考目标策略id
 * @apiParam {Number} enable 启用状态
 * @apiParam {Number} log 是否记录日志
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "test",
 *		"src_zone": "any",
 *		"dst_zone": "any",
 *		"src": "any",
 *		"dst": "any",
 *		"set": "All",
 *		"id": "1",
 *		"refer_id": "0",
 *		"enable": "1",
 *		"log": "1"
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
 * @api {PUT}  /api/ips-rule 修改入侵防护策略
 * @apiName ips-rule
 * @apiGroup 修改防护策略
 *
 *
 * @apiParam {String} name 策略名称
 * @apiParam {String} src_zone 入接口
 * @apiParam {String} dst_zone 出接口
 * @apiParam {String} src 源地址
 * @apiParam {String} dst 目的地址
 * @apiParam {String} set 事件集
 * @apiParam {Number} id 策略ID
 * @apiParam {Number} refer_id 引用计数，固定为0
 * @apiParam {Number} enable 启用状态
 * @apiParam {Number} log 是否记录日志
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "test",
 *		"src_zone": "any",
 *		"dst_zone": "any",
 *		"src": "any",
 *		"dst": "any",
 *		"set": "Common",
 *		"id": "1",
 *		"refer_id": "0",
 *		"enable": "1",
 *		"log": "1"
 *	}
 *
 * @apiParam {String} name 策略名称
 * @apiParam {String} src_zone 入接口
 * @apiParam {String} dst_zone 出接口
 * @apiParam {String} src 源地址
 * @apiParam {String} dst 目的地址
 * @apiParam {String} set 事件集
 * @apiParam {Number} id 策略ID
 * @apiParam {Number} refer_id 引用计数，固定为0
 * @apiParam {Number} move_type 策略移动类型
 * @apiParam {Number} enable 启用状态
 * @apiParam {Number} log 是否记录日志
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "test",
 *		"src_zone": "any",
 *		"dst_zone": "any",
 *		"src": "any",
 *		"dst": "any",
 *		"set": "Common",
 *		"id": "1",
 *		"refer_id": "1",
 *		"move_type": "3",
 *		"enable": "1",
 *		"log": "1"
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
 * @api {DELETE}  /api/ips-rule 删除入侵防护策略
 * @apiName ips-rule
 * @apiGroup 删除防护策略
 *
 *
 * @apiParam {Number} id 策略id
 *
 * @apiParamExample {json} Request-Example:
 *	{
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
 *		"code":"非0",
 *		"str":""
 *	}
 *
 */


class IpsCustomController extends mController{
	public $module = 'ips_sig_custom';
	/*public $json_file = '/mnt/boot/ips_custom.json';
	function get(){

	}

	function post(){
		$params = get_inputs();

		$str_all='';

		foreach ($params['item'] as $key => $value) {
			if($key==0){
				$params['protocol'] = $value['protocol'];
			}

			$str_all .= $value['protocol_field'].$value['operator'].$value['content'].$value['connector'];

		}
		if($str_all!=''){
			$params['item_str'] = substr($str_all, 0, -1);
		}
		if (file_exists($this->json_file)) {  	
			$all_json = file_get_contents($this->json_file);
			$flag = false;
			
			if ($all_json){
				$array = json_decode($all_json, true);

				foreach ($array as $key => $value) {

					if($value['name']==$params['name']){
						$flag = true;
						break;
					}

				}
				if($flag){
					$ret = array('code'=>'-1111','str' => "名称重复");
					echo json_encode($ret);
					return;
				}
				
			}
		}
		$array[] = $params;
		$rspString = getResponse($this->module, "add" ,$params);
		$str = json_encode($array);

		file_put_contents($this->json_file, $str);
		self::generate_xml($array);

		echo "ok";
		
		return;


	}

	function put(){
		$params = get_inputs();

		$str_all='';

		foreach ($params['item'] as $key => $value) {
			if($key==0){
				$params['protocol'] = $value['protocol'];
			}

			$str_all .= $value['protocol_field'].$value['operator'].$value['content'].$value['connector'];

		}
		if($str_all!=''){
			$params['item_str'] = substr($str_all, 0, -1);
		}
		if (file_exists($this->json_file)) {  	
			$all_json = file_get_contents($this->json_file);
			
			if ($all_json){
				$array = json_decode($all_json, true);

				foreach ($array as $key => $value) {

					if($value['name']==$params['name']){
						$array[$key] = $params;
						
					}

				}

				
			}
		}
		$rspString = getResponse($this->module, "mod" ,$params);
		$str = json_encode($array);

		file_put_contents($this->json_file, $str);

		echo "ok";
		self::generate_xml($array);
		return;


	}

	function delete(){

	}
*/

	/*function generate_xml($events){
		$xml_file = "/mnt/boot/detect/ips_rule_custom.xml";

		$events_id=2000000;
		$string = "<?xml version='1.0' encoding='utf-8'?><root></root>";
		$xml = simplexml_load_string($string);
		$xml->addChild('build_time', date('y-m-d h:i:s',time()));
		$xml->addChild('build_user', "laver");
		foreach ($events as $event) {
			$xmlEvt = $xml->addChild("event");
			$xmlEvt->addChild('name_cn', $event['name']);
			$xmlEvt->addChild('name_en', $event['name']);
			$xmlEvt->addChild('version', '1+');
			$xmlEvt->addChild('type', 'pattern');
			$xmlEvt->addChild('encrypt', 0);
			$xmlEvt->addChild('reverse', 0);
			$xmlEvt->addChild('protocol', $event['protocol']);
			$xmlEvt->addChild('decode_match', htmlspecialchars($event['item_str']));
			$xmlEvt->addChild('impact', 'Other_app');
			$xmlEvt->addChild('event_set', 'All');
			$xmlEvt->addChild('security_type', '命令执行');
			$xmlEvt->addChild('security_type_en', 'CommandExecution');
			$xmlEvt->addChild('can_block', '-1');
			$xmlEvt->addChild('high_action', '3');
			$xmlEvt->addChild('middle_action', '0');
			$xmlEvt->addChild('low_action', '0');
			$xmlEvt->addChild('source','0');
			$xmlEvt->addChild('level', $event['level']);
			$xmlEvt->addChild('popular', '2');  //流行
			$xmlEvt->addChild('risk', '2');      //风险
			$xmlEvt->addChild('log', '-1'); 
			$xmlEvt->addChild('distort', '0');
			$events_id++;
		}

		$dom = new \DOMDocument();
		$dom->preserveWhiteSpace = false; 
		$dom->formatOutput = true;
		$dom->loadXML($xml->asXML());
		$xml_string = $dom -> saveXML();
		file_put_contents($xml_file, $xml_string);

	}*/

}

?>
