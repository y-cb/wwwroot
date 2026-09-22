<?php
namespace controller\system;
use controller\mController;
use message\MainModel;
use lib\ExportCnf;
use lib\Json2Txt;

class SysCfgFileController extends mController{	
	function get(){
		$type = $_GET['type'];
		$config_data = ExportCnf::export($type);
		echo base64_encode($config_data);
        exit(0);
	}
	/*function post(){
		$file = $_POST['file'];
		$file_base64 = preg_replace('/data:.*;base64,/i', '', $file);  
    	$file_base64 = base64_decode($file_base64);
		$tmpfname = tempnam("/tmp", "tmpsysconf");
    	$handle = fopen($tmpfname, "w");
    	fwrite($handle, $file_base64);
		fclose($handle);
		$res = MainModel::updateConfig("SYSCONFIG_IN", $tmpfname);
		$code = $res['code'];
		if ($code == 0) {
			echo "ok";
		} else {
			if($code>0){
				$code = $code*(-1);
			}
			$ret = array('code'=>$code,'str'=>$res["str"]);
			echo json_encode($ret);
		}
		unlink($tmpfname);
	}*/
	function post(){
        $updatefile = $_FILES['file'];
        if (0 == $updatefile['size']) {
            $ret = array('code'=>'-1','str'=>t('update.file_empty'));
            echo json_encode($ret);
            exit(0);
        } else {

            if (UPLOAD_ERR_OK == $updatefile['error']) {    

                $param = array();
                $data = array();
                $tmpfname = $updatefile['tmp_name'];
                $file_type = explode(".",$updatefile['name']);

                if(strtolower($file_type[1])=='tgz'){
                    $fname = '/tmp/SYSCONFIG.tgz';
                    move_uploaded_file($updatefile['tmp_name'], $fname);
                    $ret = MainModel::updateConfig("ALL_IN", $fname);
                }else{
                    $ret = MainModel::updateConfig("SYSCONFIG_IN", $tmpfname);
                }
                if($ret['code']){
                    if($ret['code']>0){
                        $code = $ret['code']*(-1);
                    }
                    $res = array('code'=>$code,'str'=>$ret["str"]);
                    echo json_encode($res);
                }else{
                    echo "ok";
                }
            } 
        }
    }
}

