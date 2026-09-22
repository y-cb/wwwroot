<?php
namespace controller\system;

use controller\Controller;

class ReportViewController  extends Controller {
    public $dir = '/mnt1/reports/';
    function get() {
        if ($_GET['name']){$name = $_GET['name'];}
        if ($name){
            $path = $this->dir.'word/' . $name.'.docx';
            if (!file_exists($path)) {
                $data['code'] = -1;
                $data['str'] = t('cert.not_exist');
            }
            header('Cache-Control: max-age=0');
            header("Content-Description: File Transfer");
            header("Content-Disposition:attachment;filename=".$name.'.wps'); //文件名
            header("Content-type: application/vnd.ms-word");
            header("Content-Transfer-Encoding: binary");
            header('Content-Length: '. filesize($path));
            @readfile($path);
        }
    }
}
