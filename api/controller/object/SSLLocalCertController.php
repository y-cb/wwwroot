<?php
namespace controller\object;
use controller\Controller;
use message\MainModel;

/**
 * @api {get}  /api/ssl-local-cert 获取本地证书列表
 * @apiName 获取本地证书列表
 * @apiGroup 证书
 *
 * @apiParam {Number}  local_cert_type   值为3， 获取所有证书列表
 *
 *

 * @apiParamExample {json} Request-Example:
 *	{
 *		"local_cert_type": "3",
 *	}
 *
 * @apiSuccess {String} local_cert_name           证书的名称
 * @apiSuccess {Number} ref                       证书引用计数
 * @apiSuccess {Number} local_cert_state          证书状态：状态码默认为1  
 * @apiSuccess {Number} local_cert_type           证书类型：0 证书， 1：证书链 
 * @apiSuccess {String} subject                   证书摘要信息 
 * @apiSuccess {String} local_cert_locate         证书文件的位置：0 本地证书文件 1，USB
 *
 * 
 * @apiSuccessExample {json} Success-Response:
 *  HTTP/1.1. 200 OK
 	{
		"total": 3, 
		"data": [
		{
			"local_cert_name": "default", 
			"local_cert_state": "1", 
			"local_cert_type": "0", 
			"ref": "1", 
			"local_cert_locate": "0", 
			"subject": "C=CN,ST=BJ,O=AD,OU=AD,CN=ADC"
		}, 
		{
			"local_cert_name": "root", 
			"local_cert_state": "1", 
			"local_cert_type": "0", 
			"ref": "0", 
			"local_cert_locate": "0", 
			"subject": "C=CN,ST=beijing,L=beijing,O=sunya,OU=sunya,CN=sunya info"
		}, 
		{
			"local_cert_name": "test", 
			"local_cert_state": "1", 
			"local_cert_type": "0", 
			"ref": "0", 
			"local_cert_locate": "0", 
			"subject": "C=CN,L=bj,ST=bj,O=sunya,OU=sunya,emailAddress=huxuefeng@sunyainfo.com,CN=alan"
		}
		]
	}
 *
 *
 *
 */

class SSLLocalCertController extends Controller{
	public $module = 'pki_local_cert_info';
    public $dir = '/etc/pki/local/';
    function get(){
        if(isset($_GET['download'])){
            $dl_filename = $_GET['local_cert_name'].'.cer';
            $fname = $this->dir.$dl_filename;
            if(file_exists($fname)){
                $data = file_get_contents($fname);   

            }else{
                $data['code']=-1;
                $data['str'] = t('cert.not_exist');
            }
            echo base64_encode($data);
        }else{
            $param = get_inputs();
            $mode="show";
            if(isset($param['op'])){
              $mode="show_o";  
            }
            /*if (!$param['local_cert_type']){
            	$param['local_cert_type'] = 3;
            }*/
			$data=array();
            $rspString = getResponse($this->module, $mode ,$param);
            $ret = getAssign($rspString, $this->module, false, true);
            if($ret){
                $data['data'] = $ret['group'];
                //$data['total'] = count($ret['group']); 
                $data['total'] = (int)$ret['page']['total'];
            }
            echo json_encode($data);
        }
    }

	function post(){
		if($_POST['type']){$param['type'] = $_POST['type'];}
		if($param['type'] == 4){
			$updatefile = $_FILES['file'];
			if (0 == $updatefile['size']) {
	            $ret = array('code'=>'-1','str'=>t('update.file_empty'));
	            echo json_encode($ret);
	            exit(0);
	        }else{
	        	if(UPLOAD_ERR_OK == $updatefile['error']){
	        		/*$param1 = array();
                	$data1 = array();*/
                	$cert_name = $updatefile['tmp_name'];
                	$configtype="CERTL_IN_". $updatefile['name'];
                    $ret = MainModel::updateConfig($configtype,$cert_name);
	        	}
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
        }else{
        	$param = get_inputs();
        	if($_POST['cert_type']){$file = $_POST['cert_type'];}
			if($_POST['passwd']){$param['password'] = $_POST['passwd'];}
			if($_POST['cert_name']){$param['cert_file_name'] = $_POST['cert_name'];}
			if($_POST['key_name']){$param['key_file_name'] = $_POST['key_name'];}
			$param['upload_location'] = 0;
			if($_POST['cert_file']){
				//处理data头
				$file = $_POST['cert_file'];
				$file = preg_replace('/data:.*;base64,/i','', $file);
				$param['cert_file_content'] = $file;
			}
			//判断上传文件格式
			if ($param['type'] === '3'){
				$key_file = $_POST['key_file'];
				$key_file = preg_replace('/data:.*;base64,/i','', $key_file);
				$param['key_file_content'] = $key_file;
			}
			$ret = getResponse('pki_local_cert_upload','mod',$param);
			$res = getAssign($ret,'pki_local_cert_upload');
			if (!empty($res)){
				echo json_encode($res);
				return;
			}
        }
	}
}

