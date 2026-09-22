<?php
namespace controller\object;
use controller\mController;

/**
 * @api {GET} /api/crl-cert 获取crl证书
 * @apiName 获取crl列表
 * @apiGroup 证书
 *
 *
 * @apiSuccess {String} crl_cert_name 证书名称
 * @apiSuccess {String} issuer 发行者
 * @apiSuccess {String} last_update_time 上次更新
 * @apiSuccess {String} next_update_time 下次更新
 * @apiSuccess {Number} version           版本
 * @apiSuccess {String} serial_num       保留字段
 * @apiSuccess {String} ext_info         扩展信息
 * @apiSuccess {Number} ref              引用计数
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"crl_cert_name": "CRL_1",
 *			"issuer": "C=CN,ST=Beijing,L=Beijing,O=VPN_Team,OU=VPN_Root_CA,CN=VPN_Root_CA,emailAddress=admin@rootca.vpnteam",
 *			"last_update_time": "Sep 11 04:42:01 2017 GMT",
 *			"next_update_time": "Oct 11 04:42:01 2017 GMT",
 *			"version": "1",
 *			"serial_num": "",
 *			"ext_info": "",
 *			"ref": "0"
 *		},
 *		{
 *			"crl_cert_name": "CRL_2",
 *			"issuer": "C=CN,ST=Beijing,L=Beijing,O=VPN_Team,OU=VPN_Root_CA,CN=VPN_Root_CA,emailAddress=admin@rootca.vpnteam",
 *			"last_update_time": "Sep 11 04:42:01 2017 GMT",
 *			"next_update_time": "Oct 11 04:42:01 2017 GMT",
 *			"version": "1",
 *			"serial_num": "",
 *			"ext_info": "",
 *			"ref": "0"
 *		}
 *	],
 *	"total": 2
 *	}
 */

/**
 * @api {DELETE} /api/crl-cert 删除crl证书
 * @apiName 删除crl列表
 * @apiGroup 证书
 *
 *
 * @apiSuccess {String} crl_cert_name 证书名称
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *			"crl_cert_name": "CRL_2",
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
 *		"code":"234"
 *	}
 *
 */


use message\MainModel;
class CrlCertController extends mController{
	public $module = 'pki_crl_cert_info';
    public $dir = '/etc/pki/crl/';
    function get(){
        if(isset($_GET['download'])){
            $dl_filename = $_GET['crl_cert_name'].'.crl';
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
                //$data['total'] = count($ret['group']); 
                $data['total'] = (int)$ret['page']['total'];
            }
            echo json_encode($data);
        }
    }
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
                $cert_name = $updatefile['tmp_name'];

                $file_content = file_get_contents($cert_name);
                unlink($cert_name);
                $param['cert_file_name'] = $updatefile['name'];
                $param['cert_file_content'] = base64_encode($file_content);
                $rspString = getResponse("pki_crl_cert_updown", OT_MODIFY ,$param);
                $ret = getAssign($rspString, "pki_crl_cert_updown");
                
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
