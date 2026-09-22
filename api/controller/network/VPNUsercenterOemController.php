<?php

namespace controller\network;
use controller\mController;

class VPNUsercenterOemController extends mController{
	public $vpn_oem_file = '/mnt/boot/vpn_oem.json';
    //public $vpn_oem_img = '/usr/local/wwwroot/sslvpn/resources/images/logo.png';
    public $vpn_oem_img = '/mnt/boot/vpnlogo.png';												  
    public $module = 'vpn_usercenter_cfg';
    function get(){
        
        $vpn_oem_data = array();
        $vpn_oem_data[0]['title'] = '';
        $vpn_oem_data[0]['content'] = '';
        
    	if(file_exists($this->vpn_oem_file)){
			$content = file_get_contents($this->vpn_oem_file); 
			$json = json_decode($content,true);
            if (empty($json)) {
                $json = $vpn_oem_data;
            }
		}else{
            $json = $vpn_oem_data;
		}  
		echo json_encode($json);
    }

    function post(){
    	$updatefile = $_FILES['file'];
    	$content = isset($_POST['content'])?$_POST['content']:'';
    	$title = isset($_POST['title'])?$_POST['title']:'';
    	if (file_exists($this->vpn_oem_file)) {
			$str = file_get_contents($this->vpn_oem_file);
			$content_arr = json_decode($str);
			$new_json_arr = array();
			foreach ($content_arr as $key => $value) {
				//if($content!=''){
					$value->content = $content;
				//}
				//if($title!=''){
					$value->title = $title;
				//}
				$new_json_arr[] = $value;
			}

			$json = json_encode($new_json_arr);
			file_put_contents($this->vpn_oem_file,$json);
		}else{
			$new_json_arr = array();
			$new_json_arr[0]['title'] = $title;
			$new_json_arr[0]['content'] = $content;
			$json = json_encode($new_json_arr);
			file_put_contents($this->vpn_oem_file,$json);
		}

        if (UPLOAD_ERR_OK == $updatefile['error']) {    

            $param = array();
            $data = array();
            $tmpfname = $updatefile['tmp_name'];
            move_uploaded_file($updatefile['tmp_name'], $this->vpn_oem_img);

        } 
        $ha_param = array("sync_module"=>10,"sync_type"=>3,"sync_name"=>"");
        $ha_rspString = getResponse('ha_sync_module','mod',$ha_param);
    }
}

?>
