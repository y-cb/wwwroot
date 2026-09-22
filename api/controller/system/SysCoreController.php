<?php
namespace controller\system;
use controller\mController;

/**
 * @api {get}  /api/exception-message 异常信息导出
 * @apiName 异常信息导出
 * @apiGroup 诊断工具
 *
 *
 * @apiSuccess {String} name 文件名称
 * @apiSuccess {String} time 文件生成时间
 * @apiSuccess {Number} size 文件大小
 * 
 * @apiSuccessExample {json} Success-Response:
 *  HTTP/1.1 200 OK
    {
    "data": [
        {
            "name": "app_main-0-20170717-103658.1213",
            "time": "2017-07-17 10:36:58",
            "size": "40280064"
        }
    ],
    "totle":  "1"
    }
 */
/**
 * @api {delete}  /api/exception-message 异常信息删除
 * @apiName 诊断工具
 * @apiGroup 诊断工具
 *
 * @apiSuccess {String} name 文件名称
 *
 * @apiSuccessExample {json} Success-Response:
 *  HTTP/1.1 200 OK
    {
    "data": [
        {
            "name": "app_main-0-20170717-103658.1213",
        }
    ],
    }
 */
class SysCoreController extends mController{
    public $module = 'core';
    static function get_dir(){
        $dir = '/mnt1/coredump/';
        if(!is_dir($dir))
        {
            $dir = '/mnt/coredump/';

            if(!is_dir($dir)){
                $dir = '/mnt/boot/coredump/';
            }
        }
        return $dir;
    }
    static function asc2bin($temp){
        $len = strlen($temp);
        for ($i = 0; $i < $len; $i++) {
            $data .= sprintf('%08b', ord(substr($temp, $i, 1)));
        }
        return $data;
    }
    function get(){
        $dl_filename = $_GET['file_name'];
        if(isset($dl_filename)){
            ini_set('memory_limit', '512M');
            if (!preg_match("/^[a-zA-Z0-9_\-\.]+$/",$dl_filename)) {
                echo '';
                return false;
            }
            $fname = self::get_dir().$dl_filename;
            if (!file_exists($fname)) {
                echo '';
                return false;
            }

            Header("Pragma: public");
            Header("Cache-Control: private");
            Header("Content-type: text/plain");
            Header("Accept-Ranges: bytes");
            Header("Content-Length: " . filesize($fname));
            Header("Content-Disposition: attachment; filename=".$dl_filename);
            ob_clean();
            $fp = fopen($fname, "r");
            while (!feof($fp)) {
                echo fread($fp, "4096");
            }
            exit();
        }else{
            $mydir = dir(self::get_dir()); 
            $files = array();
            $i = 0;
            if ($mydir) {
                while($filename = $mydir->read())
                {
                    $file_path = $mydir->path;
                    if((!is_dir($file_path."/".$filename)) AND ($filename!=".") AND ($filename!="..")) {
                        $file = array();
                        $file['name'] = $filename;
                        $file['size'] = filesize($file_path.$filename);
                        $file['time'] = date("Y-m-d H:i:s", filectime($file_path.$filename));
                        $files[] = $file;
                    }
                } 
                $mydir->close(); 
            }

            if(sizeof($files)== 0){
                echo '{"data":[]}';
                return;
            }

            $arr['data'] = $files;
            $arr['total'] = sizeof($files);
            echo json_encode($arr);
            return;
        }  
    }
    function delete(){
        $param=get_inputs();
        $del_filename=$param['name'];
        if (!preg_match("/^[a-zA-Z0-9_\-\.]+$/",$del_filename)) {
            echo '';
            return;
        }
        unlink(self::get_dir().$del_filename);
        return;
    }
}

?>
