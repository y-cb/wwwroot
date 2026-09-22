<?php
namespace controller\statistics;
use controller\mController;


/**
 * @api {GET}  /api/app-monitor-trend 获取应用分类流量统计
 * @apiName app-monitor-trend
 * @apiGroup 应用分类流量统计
 *
 *
 * @apiParam {Number} range 1代表最近1小时，2代表最近1天，3代表最近1周
 * @apiParam {String} direct “up”代表上行，“down”代表下行，“total”代表双向，“all”代表前三种
 * @apiParam {Number} category 分类，固定为1
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"top_n": "1",
 *		"direct": "all",
 *		"category": "1"
 *	}
 *
 * @apiSuccess {Number} start_time 统计结果截止时间
 * @apiSuccess {Array} items 应用分类统计数组
 * @apiSuccess {String} name 应用分类名称
 * @apiSuccess {String} name_cn 应用分类名称对应中文
 * @apiSuccess {String} up_bytes 上行流量
 * @apiSuccess {String} down_bytes 下行流量
 * @apiSuccess {String} total_bytes 总流量
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data":,
 *		{
 *			"start_time"："1525795740",
 *			"items": [
 *			{
 *              "name": "websites",
 *              "name_cn": "常用网站",
 *              "up_bytes": "1535,1533,1545,1596,1596,1460,1572,1644,1596,1323,1766,1612,1596,1275,1612,1725,1612,1440,1503,1588,1601,1463,1580,1661,1424,1625,1596,1628,1291,1628,1789,1556,1316,1604,1621,1749,1275,1612,1605,1480,1593,1620,1596,1456,1463,1749,1440,1604,1628,1456,1577,1596,1463,1580,1440,1726,1463,1424,1612,1620",
 *              "down_bytes": "8199,7756,8802,8718,8617,8672,8182,9332,8182,7032,9747,8746,8787,7002,8709,9653,8691,7502,8723,8182,8709,8429,8191,8889,7763,9572,8201,8777,6950,9298,9697,8516,7287,9250,8287,9653,6949,8691,8139,8430,9017,8691,8581,7891,8418,9199,8185,8218,9250,7447,8691,8691,7947,8741,7740,9521,8147,7703,8691,9269",
 *              "total_bytes": "9734,9289,10347,10314,10213,10132,9755,10976,9779,8355,11514,10358,10384,8277,10321,11378,10303,8942,10226,9771,10311,9892,9771,10550,9187,11197,9798,10405,8241,10927,11486,10072,8604,10854,9909,11402,8224,10303,9745,9910,10610,10311,10177,9348,9881,10948,9625,9822,10878,8903,10268,10287,9410,10322,9180,11247,9610,9127,10303,10889"
 *          }, 
 *			{
 *              "name": "network-protocol",
 *              "name_cn": "网络协议",
 *              "up_bytes": "591,30,207,275,73,698,221,49,130,49,40,39,466,77,162,215,73,48,344,30,456,40,144,157,360,49,40,136,262,39,617,30,57,40,39,196,368,40,139,49,250,39,231,62,40,57,129,49,234,250,898,40,266,130,240,39,40,47,106,49",
 *              "down_bytes": "109,96,105,86,86,86,86,109,109,79,86,79,95,86,88,79,95,88,86,86,105,86,96,105,96,86,86,86,96,96,86,86,25,86,86,95,95,86,86,103,86,117,86,117,86,126,92,117,126,92,92,92,100,92,92,100,96,100,92,96",
 *              "total_bytes": "700,127,313,361,160,785,307,159,240,129,126,119,562,164,250,295,168,137,431,116,561,126,241,263,456,135,126,222,359,136,703,116,82,126,125,291,463,126,225,152,336,157,317,179,126,183,221,167,361,342,990,132,367,222,332,140,137,148,198,146"
 *          }
 *			]
 *		}
 *	}
 */


class AppMonitorTrendXmlController extends mController {	
	public $module = 'monitor_apps_trend';
	function get(){
		$param = get_inputs();
		$rspString = getResponse($this->module, "showone" ,$param);
		$monitor_apps_trend_arr = getAssign($rspString,$this->module,1);
		$array =  json_decode($monitor_apps_trend_arr[items],true);
		if(!$array[group][0]){
			if($array){
				$a[group][0][name_cn] = $array[group][name_cn];
				$a[group][0][up_bytes] = $array[group][up_bytes];
				$a[group][0][down_bytes] = $array[group][down_bytes];
				$a[group][0][total_bytes] = $array[group][total_bytes];
				echo json_encode($a)."@".$monitor_apps_trend_arr[start_time];
			}else{
				echo '';
			}
		}else{
			echo $monitor_apps_trend_arr[items]."@".$monitor_apps_trend_arr[start_time];
		}
	}
}
