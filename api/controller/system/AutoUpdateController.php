<?php
namespace controller\system;
use controller\mController;

/**
 * @api {GET} /api/auto-update  获取系统自动升级配置
 * @apiName 获取系统自动升级配置
 * @apiGroup 系统设置
 *
 *
 * @apiSuccess {Number} server_style 升级服务器类型，0为默认升级服务器，1为指定升级服务器
 * @apiSuccess {Number} flag 升级标志位，0表示不定期升级，1表示定期升级 
 * @apiSuccess {String} server_addr被指定升级服务器的地址，如果server_style为1需要添加该地址信息 
 * @apiSuccess {Number} updata_flag 升级周期标志位，0表示每周，1表示每月
 * @apiSuccess {Number} sun 周日，0表示没有选中，1表示选中 
 * @apiSuccess {Number} mon 周一， 0表示没有选中，1表示选中
 * @apiSuccess {Number} tue 周二，0表示没有选中，1表示选中
 * @apiSuccess {Number} wed 周三，0表示没有选中，1表示选中
 * @apiSuccess {Number} thu 周四，0表示没有选中，1表示选中
 * @apiSuccess {Number} fri 周五，0表示没有选中，1表示选中
 * @apiSuccess {Number} sat 周六，0表示没有选中，1表示选中
 * @apiSuccess {String} mon_str 按月升级指定升级的日期，例如1，12，26 表示每个月的1号，12号，26号进行升级
 * @apiSuccess {Number} time_hour升级时间时钟(0~23) 
 * @apiSuccess {Number} time_min 升级时间分钟(0~59) 
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"server_style": "0",
 *			"flag": "0",
 *			"server_addr": "www.test.update.com",
 *			"updata_flag": "1",
 *			"sun": "1",
 *			"mon": "1",
 *			"tue": "1",
 *			"wed": "1",
 *			"thu": "0",
 *			"fri": "0",
 *			"sat": "0",
 *			"mon_str": "1,2,26",
 *			"time_hour": "0",
 *			"time_min": "10"
 *		}
 *	]
 *	"total": 1
 *	}
 */

/**
 * @api {PUT} /api/auto-update  修改系统自动升级配置
 * @apiName 修改系统自动升级配置
 * @apiGroup 系统设置
 *
 *
 * @apiSuccess {Number} server_style 升级服务器类型，0为默认升级服务器，1为指定升级服务器
 * @apiSuccess {Number} flag 升级标志位，0表示不定期升级，1表示定期升级 
 * @apiSuccess {String} server_addr被指定升级服务器的地址，如果server_style为1需要添加该地址信息 
 * @apiSuccess {Number} updata_flag 升级周期标志位，0表示每周，1表示每月
 * @apiSuccess {Number} sun 周日，0表示没有选中，1表示选中 
 * @apiSuccess {Number} mon 周一， 0表示没有选中，1表示选中
 * @apiSuccess {Number} tue 周二，0表示没有选中，1表示选中
 * @apiSuccess {Number} wed 周三，0表示没有选中，1表示选中
 * @apiSuccess {Number} thu 周四，0表示没有选中，1表示选中
 * @apiSuccess {Number} fri 周五，0表示没有选中，1表示选中
 * @apiSuccess {Number} sat 周六，0表示没有选中，1表示选中
 * @apiSuccess {String} mon_str 按月升级指定升级的日期，例如1，12，26 表示每个月的1号，12号，26号进行升级
 * @apiSuccess {Number} time_hour升级时间时钟(0~23) 
 * @apiSuccess {Number} time_min 升级时间分钟(0~59) 
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"data": [
 *		{
 *			"server_style": "0",
 *			"flag": "0",
 *			"server_addr": "www.test.update.com",
 *			"updata_flag": "1",
 *			"sun": "1",
 *			"mon": "1",
 *			"tue": "1",
 *			"wed": "1",
 *			"thu": "0",
 *			"fri": "0",
 *			"sat": "0",
 *			"mon_str": "1,2,26",
 *			"time_hour": "0",
 *			"time_min": "10"
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
 *		"code":"250"
 *		"str":"Invalid parameters"
 *	}
*/
use message\MainModel;

class AutoUpdateController extends mController{	
	public $module = 'auto_update';
	function get(){
		$param = get_inputs();
		$rspString = getResponse( $this->module, "show" , $param );
		$ret = getAssign($rspString, $this->module, false, true);
		$data = array();
		$data['data'] = $ret['group'];
		if (file_exists("/var/updating")) {
			$data['data'][1]['is_updating'] = 1;
		} else {
			$data['data'][1]['is_updating'] = 0;
			$rd = simplexml_load_file('/mnt/boot/update.xml');
			$update_time_arr = (array)$rd->update_time;
			$data['data'][1]['update_time'] = $update_time_arr[0];
			if($rd->status != 0){
				$data['data'][1]['update_error'] = t('update.update_error_'.$rd->status);
			}else{
				$data['data'][1]['app_status'] = self::get_update_status($rd->app);
				$data['data'][1]['ips_status'] = self::get_update_status($rd->ips);
				$data['data'][1]['av_status'] = self::get_update_status($rd->av);
				$data['data'][1]['url_status'] = self::get_update_status($rd->url);
				$data['data'][1]['malurl_status'] = self::get_update_status($rd->malurl);
			}	
		}
		echo json_encode($data);
		return;
	}
	function get_update_status($data) {
		$str = "";

		switch ($data->status) {
			case 0:
				if ($data->version == '') {
					return '';
				}
				$str =  t('update.update_log').' '.$data->version;
				break;
			case 1:
				$str = t('update.update_error_latest');
				break;
			case -1:
				$str = t('update.update_error_license');
				break;
			case -2:
				$str = t('update.update_error_load');
				break;
		}
		return $str;
	}
}

