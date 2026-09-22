<?php
namespace controller\object;
use controller\mController;
use database\AssetsDb;

class AssetsImportController extends mController{
    public $module = 'assets_mgmt';
    function getCsvData($filePath){
        /*$handle = fopen( $filePath, "rb" );
        
        $data = [];
        while (!feof($handle)) {
            $data[] = fgetcsv($handle);   
        }
        fclose($handle);
        
        $data = eval('return ' . iconv('gb2312', 'utf-8', var_export($data, true)) . ';');  //字符转码操作
        
        return $data;*/

        $cvs_file = fopen($filePath, 'r'); //开始读取csv文件数据
        $i = 0;//记录cvs的行
        while ($file_data = fgetcsv($cvs_file)) {
            $i++;
            if ($i == 1) {
                continue;//过滤表头
            }
            $res = array();
            if ($file_data[0] != '') {
                foreach ($file_data as $val){
                    $charset = mb_detect_encoding($val, array("ASCII",'UTF-8',"GB2312","GBK",'BIG5'));

                    //修改后的文件格式判断
                    if ($charset == 'EUC-CN') {
                        $val = mb_convert_encoding($val, "UTF-8", "GB2312");
                    }
                    
                    $res[] = $val;
                }
                $data[$i] = $res;
            }
        }
        fclose($cvs_file);

        if (file_exists(UPLOAD_FILE)) {
                $return = delete_upload_file(UPLOAD_FILE);
        }

        return $data;
        }

    function post(){
        $assets_log = '/tmp/assets_log.csv';
        $table = 'assets';
        /*if (file_exists($assets_log)) {
            delete_upload_file($assets_log);
        }*/
        $updatefile = $_FILES['file'];
        $import_type = $_POST['import_type'];
       
        if (0 == $updatefile['size']) {
            $ret = array('code'=>'-1','str'=>t('update.file_empty'));
            echo json_encode($ret);
            exit(0);
        } else {
            if (!file_exists(UPLOAD_FILE)) {
                $return = set_upload_file(UPLOAD_FILE, strtotime('+ 10 minutes'));
            }
            if (UPLOAD_ERR_OK == $updatefile['error']) {
                set_time_limit(0);
                ini_set('memory_limit', '256M');
                $tmp_dir = $updatefile['tmp_name'];
                $dirs = explode('/', $tmp_dir);
                $dir = $assets_log;
                move_uploaded_file($updatefile['tmp_name'], $dir);
                $csv_data = self::getCsvData($dir);
                $db = new AssetsDb();
                $importance = ['普通资产','核心资产','Ordinary Assets','Core Assets'];
                $source = ['流量发现','手动添加','端口扫描','EDR同步','Traffic Found','Manually Add','Port Scan','EDR Sync'];
                $status = ['在线','空闲','Online','Free'];
                $assets_os = ['windows','linux','unix','ios','android'];
                foreach ($csv_data as $key => $value) {
                    flush();
                    if (empty($value[0])) {
                        $ret = array('code'=>'-1','str'=>t('assets_import.ip_not_null'));
                        echo json_encode($ret);
                        exit(0);
                    }
                    if (empty($value[4])) {
                        $ret = array('code'=>'-1','str'=>t('assets_import.importance_not_null'));
                        echo json_encode($ret);
                        exit(0);
                    }
                    $pat = "/^(((1?\d{1,2})|(2[0-4]\d)|(25[0-5]))\.){3}((1?\d{1,2})|(2[0-4]\d)|(25[0-5]))$/";
                    $reg_ipv6 = "/^\s*((([0-9A-Fa-f]{1,4}:){7}([0-9A-Fa-f]{1,4}|:))|(([0-9A-Fa-f]{1,4}:){6}(:[0-9A-Fa-f]{1,4}|((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3})|:))|(([0-9A-Fa-f]{1,4}:){5}(((:[0-9A-Fa-f]{1,4}){1,2})|:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3})|:))|(([0-9A-Fa-f]{1,4}:){4}(((:[0-9A-Fa-f]{1,4}){1,3})|((:[0-9A-Fa-f]{1,4})?:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(([0-9A-Fa-f]{1,4}:){3}(((:[0-9A-Fa-f]{1,4}){1,4})|((:[0-9A-Fa-f]{1,4}){0,2}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(([0-9A-Fa-f]{1,4}:){2}(((:[0-9A-Fa-f]{1,4}){1,5})|((:[0-9A-Fa-f]{1,4}){0,3}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(([0-9A-Fa-f]{1,4}:){1}(((:[0-9A-Fa-f]{1,4}){1,6})|((:[0-9A-Fa-f]{1,4}){0,4}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(:(((:[0-9A-Fa-f]{1,4}){1,7})|((:[0-9A-Fa-f]{1,4}){0,5}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:)))(%.+)?\s*$/";
                    
                    $ip_arr = explode('.',$value[0]);
    
                    if ($ip_arr[0] == '0') {
                        $ret = array('code'=>'-1','str'=>t('assets_import.input_file_error'));
                        echo json_encode($ret);
                        exit(0);
                    }
                    
                    if(!preg_match($pat,$value[0])&&!preg_match($reg_ipv6,$value[0])){
                        $ret = array('code'=>'-1','str'=>t('assets_import.input_file_error'));
                        echo json_encode($ret);
                        exit(0);
                    }
        
                    if (!in_array($value[4],$importance)) {
                        $ret = array('code'=>'-1','str'=>t('assets_import.input_file_error'));
                        echo json_encode($ret);
                        exit(0);
                    }
                    
                    if (!empty($value[5]) && !in_array($value[5],$assets_os)) {
                        $ret = array('code'=>'-1','str'=>t('assets_import.input_file_error'));
                        echo json_encode($ret);
                        exit(0);
                    }
                    if (!empty($value[7]) && !in_array($value[7],$source)) {
                        $ret = array('code'=>'-1','str'=>t('assets_import.input_file_error'));
                        echo json_encode($ret);
                        exit(0);
                    }
                    if (!in_array($value[8],$status)) {
                        $ret = array('code'=>'-1','str'=>t('assets_import.input_file_error'));
                        echo json_encode($ret);
                        exit(0);
                    }
                    $col_a = array();
                    $col_a['ip'] = $value[0];
                    if(preg_match($pat,$value[0])){
                      $value[9] = 0;  
                    }
                    if(preg_match($reg_ipv6,$value[0])){
                      $value[9] = 1;  
                    }
                    //var_dump($col_a);exit(0);
                    $items = $db->queryForList($table, $col_a, 1, 10);
        
                    if($value[4]=="普通资产"||$value[4]=="Ordinary Assets"){
                        $value[4] = 0;
                    }else if ($value[4]=="核心资产"||$value[4]=="Core Assets"){
                        $value[4] = 1;
                    }
                    if($value[7]=="流量发现"||$value[7]=="Traffic Found"){
                        $value[7] = 0;
                    }else if ($value[7]=="手动添加"||$value[7]=="Manually Add"){
                        $value[7] = 1;
                    }else if ($value[7]=="端口扫描"||$value[7]=="Port Scan"){
                        $value[7] = 2;
                    }else if ($value[7]=="EDR同步" ||$value[7]=="EDR Sync") {
                        $value[7] = 3;
                    }
                    if($value[8]=="在线"||$value[8]=="Online"){
                        $value[8] = 0;
                    }else if ($value[8]=="空闲"||$value[8]=="Free"){
                        $value[8] = 1;
                    }
                    
                    $count = $db->getCount($table,[]);
                    
                    if ($count == 10000) {
                        //找到一个最小的可删除的流量发现且没经过修改的资产
                        $row = $db->getRow($table);
                        if (!empty($row['id']) && !empty($row['ip'])) {
                            $ip = explode('.',$row['ip']);
                            $service_table = 'service_'.$ip[0].'_'.$ip[1].'_'.$ip[2].'_'.$ip[3];
                            //删除对应资产的服务table
                            $db->dropTable($service_table);
                            //删除对应的资产
                            $db->delRow($table,$row['id']);
                        } else {
                            $ret = array('code'=>'-2','str'=>t('assets_import.maximum'));
                            echo json_encode($ret);
                            exit(0);
                        }
                    }
                    if($items){
                        if($import_type=='0'){//覆盖
                            $param['ip'] =  $value[0];
                            $param['import'] =  1;
                            $rspString = getResponse($this->module, "add" ,$param);
                            $db->assets_update($table, $value);
                        }
                    }else{
                        $param['ip'] =  $value[0];
                        $param['import'] =  1;
                        $rspString = getResponse($this->module, "add" ,$param);
                        $db->assets_insert($table, $value);
                    }

                    if ($key % 500 == 0) {
                        sleep(4);
                    }

                    ob_flush();
                }

                if (file_exists(UPLOAD_FILE)) {
                    $return = delete_upload_file(UPLOAD_FILE);
                }

                echo "ok";
                return;
            }else{
                $ret = array('code'=>'-50000','str'=>t('update.update_error_50000'));
                echo json_encode($ret);
            }
        }
    }
}

?>
