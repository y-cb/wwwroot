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

class RootCaTrustController extends Controller{
	public $module = 'pki_ca_cert_info';
    public $dir = '/etc/pki/proxy/trustca/';
    function get(){
        if(isset($_GET['download'])){
            $dl_filename = $_GET['ca_cert_name'];
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
			$data=array();
            $rspString = getResponse($this->module, $mode ,$param);
            $ret = getAssign($rspString, $this->module, false, true);
            if($ret){
                $data['data'] = $ret['group'];
                $data['total'] = (int)$ret['page']['total'];
            }
            echo json_encode($data);
        }
    }

	function post(){
        $updatefile = $_FILES['file'];
        $is_ssl_trustca = $_POST['is_ssl_trustca'];

        if (0 == $updatefile['size']) {
            $ret = array('code'=>'-1','str'=>t('update.file_empty'));
            echo json_encode($ret);
            exit(0);
        } else {

            if (UPLOAD_ERR_OK == $updatefile['error']) {    

                $param = get_inputs();
                $data = array();
                $cert_name = $updatefile['tmp_name'];

                $file_content = file_get_contents($cert_name);
                unlink($cert_name);
                $param['is_ssl_trustca'] = $is_ssl_trustca;
                $param['cert_file_name'] = $updatefile['name'];
                $param['cert_file_content'] = base64_encode($file_content);
                $rspString = getResponse("pki_ca_cert_updown", 'mod' ,$param);
                $ret = getAssign($rspString, "pki_ca_cert_updown");
                
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

