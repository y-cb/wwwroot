<?php
namespace controller\object;
use controller\mController;

class DownloadSingleSignProgramController extends mController{
    
    public $module = 'download_single_program';
    
    function get()
    {
        $filePath = '/usr/local/wwwroot/sslvpn/download/adsso.zip';
        if (!file_exists($filePath)) {
            $data['code'] = -1;
            $data['str'] = t('cert.not_exist');
        }
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header('Content-disposition: attachment; filename='.basename('adsso.zip')); //文件名
        header("Content-Type: application/zip");
        header("Content-Transfer-Encoding: binary");
        header('Content-Length: '. filesize($filePath));
        @readfile($filePath);
    }
}