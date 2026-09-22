<?php
namespace controller\system;
use controller\mController;


/**
 * @api {PUT}  /api/sysconfigexport 导出配置
 * @apiName 导出配置
 * @apiGroup 系统设置
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *	}
 *
 **/

class SysConfigExportController extends mController{

    function get(){
        $param = get_inputs();
        $path = "/mnt/boot/";
        $serial_number = $param['serial_number'];
        
        if (!isset($serial_number))  {
            $ret = array('code'=>'0','str'=>t('number_must_pass'));
            echo json_encode($ret);
        }
        if ($serial_number > 0) {
            $filePath = $path.'/utmcfg.bcp.'.$serial_number;
        } else {
            $filePath = $path.'/utmcfg.bcp';
        }
        
        if (file_exists($filePath)) {
            $data = file_get_contents($filePath);
        } else {
            $data['code'] = -1;
            $data['str'] = t('cert.not_exist');
        }
        echo base64_encode($data);
    }
}

