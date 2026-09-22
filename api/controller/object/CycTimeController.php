<?php
namespace controller\object;
use controller\mController;

/**
 * @api {POST}  /api/cyc-time 创建周期时间对象
 * @apiName 创建周期时间对象
 * @apiGroup 时间对象
 *
 *
 * @apiParam {String} name 创建的周期时间对象的名称
 * @apiParam {String} desc 周期时间对象的描述
 * @apiParam {Number} enable_absolute 是否设置起止日期
 * @apiParam {String} ab_year1 起止日期的开始年
 * @apiParam {String} ab_month1 起止日期的开始月
 * @apiParam {String} ab_day1 起止日期的开始日
 * @apiParam {String} ab_hour1 起止日期的开始时
 * @apiParam {String} ab_minute1 起止日期的开始分
 * @apiParam {String} ab_year2 起止日期的结束年
 * @apiParam {String} ab_month2 起止日期的结束月
 * @apiParam {String} ab_day2 起止日期的结束日
 * @apiParam {String} ab_hour2 起止日期的结束时
 * @apiParam {String} ab_minute2 起止日期的结束分
 * @apiParam {Array} periods 周期时间设置："weekday1""weekday2"..."weekday7":分别表示周一到周日 值为1表示该天被设置，否则就没有设置该天"hour1""minute1":表示周期时间的起始时、分"hour2""minute2"：表示周期时间的结束时分,
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "alan_ab_test",
 *		"desc": "Just a test for ab time",
 *		"enable_absolute": 1, 
 *		"ab_year1": "18",
 *		"ab_month1": "5",
 *		"ab_day1": "10",
 *		"ab_hour1": "10",
 *		"ab_minute1": "10",
 *		"ab_year2": "19",
 *		"ab_month2": "6",
 *		"ab_day2": "11",
 *		"ab_hour2": "11",
 *		"ab_minute2": "11",
 *		"periods": [{"weekday1":1, "weekday1":1, "weekday3":0, "weekday4":0, "weekday5":0, "weekday6":0, "weekday7":0, "hour1":18, "minute1":18, "hour2":22, "minute2":22}] 
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
 * @api {PUT}  /api/cyc-time 修改周期时间对象
 * @apiName 修改周期时间对象
 * @apiGroup 时间对象
 *
 *
 * @apiParam {String} name 周期时间对象的名称
 * @apiParam {String} desc 周期时间对象的描述
 * @apiParam {Number} enable_absolute 是否设置起止日期
 * @apiParam {Number} ref 该对象被引用计数
 * @apiParam {String} ab_year1 起止日期的开始年
 * @apiParam {String} ab_month1 起止日期的开始月
 * @apiParam {String} ab_day1 起止日期的开始日
 * @apiParam {String} ab_hour1 起止日期的开始时
 * @apiParam {String} ab_minute1 起止日期的开始分
 * @apiParam {String} ab_year2 起止日期的结束年
 * @apiParam {String} ab_month2 起止日期的结束月
 * @apiParam {String} ab_day2 起止日期的结束日
 * @apiParam {String} ab_hour2 起止日期的结束时
 * @apiParam {String} ab_minute2 起止日期的结束分
 * @apiParam {Array} periods 周期时间设置："weekday1""weekday2"..."weekday7":分别表示周一到周日 值为1表示该天被设置，否则就没有设置该天"hour1""minute1":表示周期时间的起始时、分"hour2""minute2"：表示周期时间的结束时分,
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "alan_ab_test",
 *		"desc": "Just a test for ab time",
 *		"enable_absolute": 1 ,
 *		"ab_year1": "18",
 *		"ab_month1": "5",
 *		"ab_day1": "10",
 *		"ab_hour1": "10",
 *		"ab_minute1": "10",
 *		"ab_year2": "19",
 *		"ab_month2": "6",
 *		"ab_day2": "11",
 *		"ab_hour2": "11",
 *		"ab_minute2": "11",
 *		"periods": [{"weekday1":1, "weekday1":1, "weekday3":0, "weekday4":1, "weekday5":0, "weekday6":0, "weekday7":0, "hour1":18, "minute1":18, "hour2":23, "minute2":23}] 
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
 * @api {GET}  /api/cyc-time 获取所有周期时间对象
 * @apiName 获取所有周期时间对象
 * @apiGroup 时间对象
 *
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
		"total": 1, 
		"data": [
			{"ab_hour2": "11", "ab_month2": "6", "ab_month1": "5", "ab_hour1": "10", "name": "alan_ab_test", "enable_absolute": "1", "ab_minute2": "11", "ab_day2": "11", "ab_year1": "18", "ab_minute1": "10", "ab_day1": "10", "periods": {"group": {"weekday6": "0", "weekday7": "0", "weekday4": "1", "weekday5": "0", "weekday2": "1", "weekday3": "0", "weekday1": "1", "hour2": "23", "hour1": "18", "minute2": "23", "minute1": "18"}}, "ab_year2": "19", "ref": "0", "desc": "Just a test for ab time"}
			]
 *	}
 */

/**
 * @api {GET}  /api/cyc-time 获取单个周期时间对象
 * @apiName 获取单个周期时间对象
 * @apiGroup 时间对象
 *
 * @apiParam {String} name 创建的周期时间对象的名称
 *
 * @apiParamExample {json} Request-Example:
 *	{
		"name":"alan_ab_test",
		"op":"detail_o"
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
		"data": [
			{"ab_hour2": "11", "ab_month2": "6", "ab_month1": "5", "ab_hour1": "10", "name": "alan_ab_test", "enable_absolute": "1", "ab_minute2": "11", "ab_day2": "11", "ab_year1": "18", "ab_minute1": "10", "ab_day1": "10", "periods": {"group": {"weekday6": "0", "weekday7": "0", "weekday4": "1", "weekday5": "0", "weekday2": "1", "weekday3": "0", "weekday1": "1", "hour2": "23", "hour1": "18", "minute2": "23", "minute1": "18"}}, "ab_year2": "19", "ref": "0", "desc": "Just a test for ab time"}
			]
 *	}
 */


/**
 * @api {GET}  /api/cyc-time 删除单个周期时间对象
 * @apiName 删除单个周期时间对象
 * @apiGroup 时间对象
 *
 *
 * @apiParam {String} name 创建的周期时间对象的名称
 *
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "alan_ab_test"
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
 * @api {DELETE}  /api/cyc-time 删除周期时间对象
 * @apiName 删除周期时间对象
 * @apiGroup 时间对象
 *
 *
 * @apiParam {String} name 周期时间对象名称
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "alan_ab_test"
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


class CycTimeController extends mController {	
	public $module = 'tr_periodic_table';
	function get(){
		$data = array();
		$param = get_inputs();
		$data = array();
		if(isset($param['op'])){
			header('Content-type: application/json');
			$rspString = getResponse($this->module, "show_o" ,$param);
		 	$ret = getAssign($rspString, $this->module, false, true);
		 	$data['data'] = $ret['group'];
		}else{

			$rspString = getResponse($this->module, "show" ,$param);
		 	$ret = getAssign($rspString, $this->module, false, true);
		 	if($ret){
		 		$data['data'] = $ret['group'];
		 		if (isset($ret['page'])) {
	                $data['total'] = (int)$ret['page']['total'];
	            } else {
	                $data['total'] = (int)count($data['data']);
	            }
		 	}
		}
		echo json_encode($data);
	}
}
