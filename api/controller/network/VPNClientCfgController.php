<?php
    namespace controller\network;
    use controller\mController;

    class VPNClientCfgController extends mController{
    	private $file_name = array('client_windows32' => 'VPNCLIENT_WINDOWS32.zip', 'client_windows64' => 'VPNCLIENT_WINDOWS64.zip', 'client_android' => 'VPNCLIENT_ANDROID.zip');
        public $module = 'vpn_client_cfg';

        function post() {
        	$param = get_inputs();
        	$data['type'] = $param['type'];
        	$data['lang'] = $param['lang'];
        	if ($param['type'] == '0') {
				$data['client_ios'] = $param['client_ios'];									 

				if (file_exists(UPLOAD_FILE)) {
					delete_upload_file(UPLOAD_FILE);
				}

				// set_upload_file(UPLOAD_FILE, strtotime('+ 10 minutes'));

				foreach ($_FILES as $key => $value) {
					if (0 == $value['size']) {
						$ret = array('code'=>'-1','str'=>t('update.file_empty'));
						echo json_encode($ret);
						exit(0);
					} else {
						if (UPLOAD_ERR_OK == $value['error']) {
							$tmp_dir = $value['tmp_name'];
							$dirs = explode('/', $tmp_dir);
							$dir = '/tmp/'. $value['name'];		  
							//$dir = '/tmp/'. $this->file_name[$key];
							move_uploaded_file($value['tmp_name'], $dir);
							$data[$key] = $value['name'];//$this->file_name[$key];
							continue;
						}else{
							$ret = array('code'=>'-50000','str'=>t('update.update_error_50000'));
							echo json_encode($ret);
						}
					}
				}
        	}else{
        		$data = $param;
        	}

			$rspString = getResponse($this->module, "mod" , $data);
			$ret = getAssign($rspString, $this->module);

			if (!empty($ret)) {
				echo json_encode($ret);
			} 	
        }
    }
?>