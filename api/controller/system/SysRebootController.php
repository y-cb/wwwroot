<?php
namespace controller\system;
use controller\mController;


/**
 * @api {PUT}  /api/reboot 重启设备
 * @apiName  重启设备
 * @apiGroup 系统设置
 *
 * @apiSuccess {Number} operation 操作码：0:表示重启, 1:恢复出厂设置，并重启设备 
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"data": [
 *		{
 *			"operation": "0"
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *	}
 *
 **/

class SysRebootController extends mController{
	public $module = 'power_off';

    function put () {
    	$param = get_inputs();

    	$rspString = getResponse($this->module, "mod" ,$param);
		$ret = getAssign($rspString, $this->module);
		header('Content-type: application/json');
		if (!empty($ret)) {
			echo json_encode($ret);
		} else {
	    	if($param['operation'] == 1) {
	    		$this->clean_report();
	    	}
		}
    }

    function clean_report() {
    	$reportCfg = '/mnt/boot/report.json';
    	$reportFile = '/mnt1/reports/';
        $reportName = '/mnt/boot/report_file.json';

    	if (file_exists($reportCfg)){
    		@unlink($reportCfg);
    	}
        if (file_exists($reportName)){
            @unlink($reportName);
        }

    	if(file_exists($reportFile)) {
    		$dh = opendir($reportFile);

    		while ($file = readdir($dh)) {
    			if($file!="."&&$file!=".."){
    				$path = $reportFile . '/' . $file;
    				if (!is_dir($path)) {
    					@unlink($path);
    				}
    			}
    		}
    		closedir($dh);
    		@rmdir($reportFile);
    	}
    }
}

