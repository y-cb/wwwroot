<?php
namespace controller\system;
use controller\mController;
use message\MainModel;

class ManualUpdateController extends mController{
    private $upload_path= 'mnt';
    function post(){

        $updatefile = $_FILES['filename'];
        $updatetype = $_POST['filetype'];
        set_upload_file(UPLOAD_FILE, strtotime('+ 10 minutes'));

        if (0 == $updatefile['size']) {
            $ret = array('code'=>'-1','str'=>t('update.file_empty'));
            echo json_encode($ret);
        } else {
            if (UPLOAD_ERR_OK == $updatefile['error']) {
                $tmp_dir = $updatefile['tmp_name'];
                $dirs = explode('/', $tmp_dir);
                $dir = '/' . $this->upload_path . '/' . $updatefile['name'];
//                $dir = implode('/', array_slice($dirs, 0, -1)) .'/'. $updatefile['name'];
                move_uploaded_file($updatefile['tmp_name'], $dir);
                $res = MainModel::updateVersion($updatetype, $dir);
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
            }else{
                $ret = array('code'=>'-50000','str'=>t('update.update_error_50000'));
                echo json_encode($ret);
            }
        }
        if (file_exists(UPLOAD_FILE)) {
            delete_upload_file(UPLOAD_FILE);
        }
        return;
    }
}
