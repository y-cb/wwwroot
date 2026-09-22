<?php
namespace controller\statistics;
use controller\mController;
use database\MySQLite3Db;

/**
 * @api {GET}  /api/apt-list 获取沙箱检测状态列表
 * @apiName 获取沙箱检测状态列表
 * @apiGroup 病毒防护统计
 *
 * @apiParam {Number} page 列表页码数
 * @apiParam {Number} pageSize 每页显示条数
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"page": "1",
 *		"pageSize": "10"
 *	}
 *
 * @apiSuccess {Number} ID  数据id
 * @apiSuccess {String} time  时间
 * @apiSuccess {String} md5  文件MD5值
 * @apiSuccess {String} filename  文件名称
 * @apiSuccess {String} filetype  文件类型
 * @apiSuccess {String} srcIp  源IP
 * @apiSuccess {String} dstIp  目的IP
 * @apiSuccess {String} App  应用名称
 * @apiSuccess {String} Proto  协议类型
 * @apiSuccess {Number} result  检测结果
 * @apiSuccess {String} malware  病毒名称
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"ID":1,
 *			"time":"2018-07-20 14:34:50",
 *			"md5":"8f60c2202d29fcd525162d02134566b",
 *			"filename":"file1",
 *			"filelen":12235,
 *			"filetype":"txt",
 *			"srcIp":"1.1.2.3",
 *			"dstIp":"12.2.3.2",
 *			"App":"qq",
 *			"Proto":"tcp",
 *			"result":4,
 *			"malware":"malware1"
 *		},
 *		{
 *			"ID":2,
 *			"time":"2018-07-20 14:44:50",
 *			"md5":"8f60c2202d29fcd525162d02134566b",
 *			"filename":"file2",
 *			"filelen":12235,
 *			"filetype":"txt",
 *			"srcIp":"1.1.12.3",
 *			"dstIp":"2.2.3.2",
 *			"App":"wechat",
 *			"Proto":"udp",
 *			"result":5,
 *			"malware":"malware2"
 *		},
 *		{
 *			"ID":3,
 *			"time":"2018-07-20 14:54:50",
 *			"md5":"8f60c2202d29fcd525162d02134566b",
 *			"filename":"file3",
 *			"filelen":12235,
 *			"filetype":"txt",
 *			"srcIp":"1.1.12.3",
 *			"dstIp":"12.2.3.2",
 *			"App":"sina",
 *			"Proto":"http",
 *			"result":6,
 *			"malware":"malware3"
 *		},
 *	],
 *	"total": 3
 *	}
 */

class AptStatListController extends mController {	
	function get(){
		$param['page'] = $_GET['page'];
		$param['count'] = $_GET['pageSize'];
		$db = new MySQLite3Db('/mnt/boot/apt.db', '/tmp/apt_tmp.db');
		$table_name = 'apt_result';
		$where = 'where id > 0 '.$query_log_time.$query_level_name.$query_log_user.$query_log_ip.$query_content;
		$offset = ($param['page']-1)*$param['count'];
		$retdata = $db->get_SQLite3_data_result($table_name,$where,$param['count'],$offset,'id');
		$totalNum = $db->get_SQLite3_data_count($table_name,$where,'id');
		if(!empty($retdata)){
			$tmp;

			foreach ($retdata['group'] as $item) {
				$item[time] = date('Y-m-d H:i:s', $item[time]); 
				$tmp['data'][] = $item;
			}

			$tmp[total] = $totalNum;
			echo get_jsondata($tmp);
		}else{
			$data = array('data'=> array(),'total'=> 0);
			echo json_encode($data);
		}

		return;
	}
	
}
?>
