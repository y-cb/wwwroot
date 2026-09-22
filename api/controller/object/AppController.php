<?php
namespace controller\object;
use controller\mController;

/**
 * @api {GET}  /api/app 获取所有应用对象，由于太多只做部分展示
 * @apiName 获取所有应用对象
 * @apiGroup 应用对象
 *
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
		"total": 1139, 
		"data": [
			{"category": "", "name": "any", "show_name": "any", "popular": "0", "category_show": "", "desc": "\u4efb\u610f\u5e94\u7528", "ref": "1", "risk": "0", "refer": ""}, 
			{"category": "instant-messaging", "name": "qq", "show_name": "QQ", "popular": "5", "category_show": "", "desc": "\u817e\u8bafQQ(\u7b80\u79f0QQ)\u662f\u817e\u8baf\u516c\u53f8\u5f00\u53d1\u7684\u4e00\u6b3e\u57fa\u4e8eInternet\u7684\u5373\u65f6\u901a\u4fe1(IM)\u8f6f\u4ef6\u3002\u7528\u6237\u53ef\u80fd\u5229\u7528\u5b83\u901a\u8fc7\u7f51\u7edc\u5b9e\u73b0\u4e0e\u670b\u53cb\u4e4b\u95f4\u4e92\u53d1\u5373\u65f6\u7684\u77ed\u6d88\u606f\u3001\u4f20\u9001\u6587\u4ef6\u3001\u8fdb\u884c\u97f3\u9891\u6216\u89c6\u9891\u4ea4\u6d41\u3001\u8fdb\u884c\u6e38\u620f\u7b49\u7b49.", "ref": "0", "risk": "3", "refer": "http://www.qq.com/"}, 
			{"category": "instant-messaging", "name": "sina-uc", "show_name": "\u65b0\u6d6aUC", "popular": "3", "category_show": "", "desc": "\u65b0\u6d6aUC\u662f\u56fd\u5185\u7814\u53d1\u7684\u5373\u65f6\u901a\u8baf\u8f6f\u4ef6\u3002\u65b0\u6d6aUC\u662f\u5c06\u4f20\u7edf\u5373\u65f6\u901a\u4fe1\u8f6f\u4ef6\u529f\u80fd\u4e8e\u4e00\u4f53\uff0c\u91c7\u7528P2P\u6280\u672f\u7684\u5373\u65f6\u901a\u4fe1\u5a31\u4e50\u8f6f\u4ef6\uff0c\u5177\u6709\u573a\u666f\u804a\u5929\u6a21\u5f0f\uff0c\u4ee5\u53ca\u89c6\u9891\u7535\u8bdd\u3001\u53ef\u65ad\u70b9\u7eed\u4f20\u7684\u6587\u4ef6\u4f20\u8f93\u3001\u80fd\u591f\u591a\u4eba\u804a\u5929\u7684\u591a\u4eba\u4e16\u754c\uff0c\u6d88\u606f\u7fa4\u53d1\u529f\u80fd\u548c\u5728\u7ebf\u6e38\u620f\u529f\u80fd\u4ee5\u53ca\u540c\u5b66\u5f55(\u56e2\u4f53)\u7b49\uff0c\u662f\u4e00\u4e2a\u5b8c\u6574\u7684\u7f51\u4e0a\u5373\u65f6\u901a\u8baf\u5a31\u4e50\u5e73\u53f0\u3002", "ref": "0", "risk": "2", "refer": "http://uc.sina.com.cn/"}]
 *	}
 */


/**
 * @api {GET}  /api/app 获取单个应用对象
 * @apiName 获取单个应用对象
 * @apiGroup 应用对象
 *
 *
 * @apiSuccess {String} name 应用对象分类名称

 * @apiParamExample {json} Request-Example:
 *	{
		"name":"any",
		"op":"detail_o"
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
		"category": "instant-messaging", 
		"name": "qq", 
		"show_name": "qq", 
		"popular": "5", 
		"category_show": "instant-messaging", 
		"desc": "QQ is a popular instant messenger at home, and users can use it to send instant \,
			short messages, transfer files, communicate through audios or videos, play games, etc.", 
		"ref": "0", 
		"risk": "3", 
		"refer": "http://www.qq.com/"
 *	}
 */



class AppController extends mController {	
	public $module = 'app_profile';

    function get() {
         $data = array();
		 $param = get_inputs();

		 $show_one = false;
		 if ($param['op'] == 'list') {
			$rspString = getResponse($this->module, "show_index" ,$param);
		    $ret = getAssign($rspString, $this->module, false, true);
		 } else if ($param['op'] == 'detail') {
			$show_one = true;
			$rspString = getResponse($this->module, "show_one" ,$param);
		    $ret = getAssign($rspString, $this->module);
			if ($ret['group']) {
				$ret['group'] = json_decode($ret['group']);
			}
		 } else if ($param['op'] == 'detail_o') {
			$show_one = true;
			$rspString = getResponse($this->module, "show_o" ,$param);
		    $ret = getAssign($rspString, $this->module);
			if ($ret['group']) {
				$ret['group'] = json_decode($ret['group']);
			}
		 } else if ($param['op'] == 'list_i') {
			$rspString = getResponse($this->module, "show_i" ,$param);
		    $ret = getAssign($rspString, $this->module, false, true);
		 } else if ($param['op'] == 'detail_one') {
			$rspString = getResponse($this->module, "showone" ,$param);
		    $ret = getAssign($rspString, $this->module, false, true);
		 } else {
			$rspString = getResponse($this->module, "show" ,$param);
		    $ret = getAssign($rspString, $this->module, false, true);
		 }
         header('Content-type: application/json');  

		 if($show_one) {
		 	echo json_encode($ret);
			return;
		 } else if (empty($ret)) {
		 	unset($ret);
			$ret['data'] = Array();
			$ret['total'] = 0;
		 	echo json_encode($ret);
			return;
		 } else {
            $data['data'] = $ret['group'];
            if (isset($ret['page'])) {
                $data['total'] = (int)$ret['page']['total'];
                $data['fake_total'] = (int)$ret['page']['fake_total'];
            } else {
                $data['total'] = (int)count($data['data']);
            }
		 	echo json_encode($data);
		 }
    }
}
