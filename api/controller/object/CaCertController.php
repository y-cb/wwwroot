<?php
namespace controller\object;
use controller\mController;


/**
 * @api {GET}  /api/ca-cert 获取证书策略
 * @apiName 获取本地CA中心策略
 * @apiGroup 证书
 *
 *
 * @apiSuccess {String} ca_cert_name 证书名称
 * @apiSuccess {String} subject 证书主题
 * @apiSuccess {Number} local_cert_type 证书类型
 *
 * @apiSuccessExample {json} Success-Response:
 *  HTTP/1.1 200 OK
    {
    "data": [
        {
            "ca_cert_name": "sss",
            "subject": "fffff",
            "local_cert_type":"0",
        }
    ],
    }
 */

use message\MainModel;

class CaCertController extends mController{
	public $module = 'pki_ca_cert_info';
    public $dir = '/etc/pki/ca/';
    function get(){
        if(isset($_GET['download'])){
            $dl_filename = $_GET['ca_cert_name'].'.cer';
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
            if($ret && $ret['group']){
                $data['data'] = $ret['group'];
                //$data['total'] = count($ret['group']); 
                $data['total'] = (int)$ret['page']['total'];
            }else{
                $data['data'] = array();
                $data['total'] = 0;
            }
            echo json_encode($data);
        }
    }
    function post(){
        $updatefile = $_FILES['file'];
        $updatetype = $_POST['cert_type'];

        if (0 == $updatefile['size']) {
            $ret = array('code'=>'-1','str'=>t('update.file_empty'));
            echo json_encode($ret);
            exit(0);
        } else {

            if (UPLOAD_ERR_OK == $updatefile['error']) {    

                $param = array();
                $data = array();
                $cert_name = $updatefile['tmp_name'];

                if($updatetype==1){
                    $file_content = file_get_contents($cert_name);
                    unlink($cert_name);
                    $param['cert_file_name'] = $updatefile['name'];
                    $param['cert_file_content'] = base64_encode($file_content);
                    $rspString = getResponse("pki_ca_cert_updown", 'mod' ,$param);
                    $ret = getAssign($rspString, "pki_ca_cert_updown");
                }else{
                    $configtype="CAL_IN_". $updatefile['name'];
                    $ret = MainModel::updateConfig($configtype,$cert_name);
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

?>
