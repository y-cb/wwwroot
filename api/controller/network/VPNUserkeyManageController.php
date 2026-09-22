<?php
    namespace controller\network;
    use controller\mController;
    use lib\Json2Csv;
    use lib\QRcode;

    class VPNUserkeyManageController extends mController{
        public $module = 'vpn_userkey_manage';
        public $ha_module = 'vpn_userkey_manage_ha';
        private $qrcode_file_name =  'user_qrcode.tar.gz';
        public $qrocode_module = 'vpn_user_qrencode_cfg';
        private $qrcode_path =  '/tmp/user_qrcode/';
        private $tmp_file_path = '/tmp/tmp_user_qrcode.png';

    	function get(){
    		$module = $this->module;
    		$param=get_inputs();
    		$action = 'show';
    		if($param['op']=='detail'){
    			$action = 'showone';
    			if ($param['qrcode'] && $param['qrcode'] == '1') {
    				$module = $this->qrocode_module;
    			}
    		}

    		if ($param['download'] == 1) {
    			self::export($param);
                return;
    		} else {
    			$rspString = getResponse($module, $action, $param);
    			$ret = getAssign($rspString, $module, false, true);

    			if ($param['op']=='detail' && $param['qrcode'] == '1') {
    				$qrcode_str = urldecode($ret['group'][0]['qrencode']);
    				if (file_exists($this->tmp_file_path)) {
    					unlink($this->tmp_file_path);
    				}
    				self::qocode_output($qrcode_str, $this->tmp_file_path);
    				$image_url = base64_encode(file_get_contents($this->tmp_file_path));
    				$ret['group'][0]['qrencode'] = $image_url;
    			}

    			$data['data'] = $ret['group'];
    	        if (isset($ret['page'])) {
    	            $data['total'] = (int)$ret['page']['total'];
    	        } else {
    	            $data['total'] = (int)count($data['data']);
    	        }
    			if (file_exists($this->tmp_file_path)) {
    				unlink($this->tmp_file_path);
    			}
    		 	echo json_encode($data);
    			return;
    		}

    	}

        function post()
        {
            $get_param=get_inputs();
            $params = $get_param['data'];
            if($params) {
                $list = array();

                $rspString = getResponse( $this->ha_module, "show", array('number'=> count($params)) );
                $ret = getAssign($rspString, $this->ha_module);

                $ret = self::is_accoc($ret);

                foreach($params as $key =>$value){
                    $value['key'] = $ret[$key]['key'];
                    $list['items'][] = $value;
                    if (( $key + 1 ) % 10 == 0 || ($key + 1) == count($params)) {
                        $list['number'] = count($list['items']);
                        $rspString = getResponse( $this->ha_module, "add" , $list );
                        $list = array();
                    }
                }
                $ret1 = getAssign($rspString, $this->ha_module, false, true);
                $code = 0;
                $str='';
                foreach($ret1 as $key=>$value){
                    if($key=='code'){
                        $code = $value;
                    }
                    if($key=='str'){
                        $str = $value;
                    }
                }
                if($code==0){
                   $ret1=''; 
                }
                echo json_encode($ret1);
            }
            header('Content-type: application/json');
        }

        function is_accoc($data) {
            $list = array();
            if (array_keys($data) !== range(0, count($data)-1)) {
                $list[] = $data;
            } else {
                $list = $data;
            }

            return $list;
        }

    	function qocode_output($file, $path = false, $level = 'L', $size = 6){
    		if (!isset($file) || file_exists($path)) {
    			return false;
    		}
    		return QRcode::png($file, $path, $level, $size);
    	}

    	function qrcode_generate($data) {

    		//根据时间周期进行数据整理
    		ob_clean();
    		foreach ($data as $key => $value) {
    			$file_path = (empty($value['grpname']))? ($this->qrcode_path . $value['name']): ($this->qrcode_path . $value['grpname'] .'_' . $value['name']);
    			$file_path .= '.png';
    			self::qocode_output(urldecode($value['qrencode']), $file_path);
    		}
    	}

    	function qrcode_export() {

    		exec('tar -zvcf '. $this->qrcode_path . $this->qrcode_file_name .' '. $this->qrcode_path );

    		header("Accept-Ranges:bytes");
    		header("Accept-Length: ".filesize($this->qrcode_path . $this->qrcode_file_name));
    		Header("Content-Disposition:attachment; filename=".$this->qrcode_file_name);
    		@readfile($this->qrcode_path . $this->qrcode_file_name);

    		exec('rm -r '. $this->qrcode_path);
    	}

    	function key_export($data, $file_name) {
    		header('Content-type:application/vnd.ms-excel; charset=utf-8');
    		header('Content-Disposition: attachment;filename="'.$file_name.'"');
    		header('Cache-Control: max-age=0');
    		$data = json_encode($data);
    		echo Json2Csv::json_csv($data);
    	}

    	private function export($data) {
    		//数据整理
    		if (!file_exists($this->qrcode_path)) {
    			mkdir($this->qrcode_path);
    		}
    		$module = ($data['filetype'] == 'qrcode')? $this->qrocode_module : $this->module;
    		$file_name =  'user_key_' . date('YmdHis', time()) . '.xls';
    		$list = array();

            $page = array(
                'page' => $data['page'],
                'pageSize' => $data['pageSize']
            );
/*
    		if($data['filenum'] != 'all'){
    			$data['number']=1;
    		}

    		$rspString = getResponse( $module, "show" , $page );
    		$ret = getAssign($rspString, $module);
            
    		if ($ret['code']) {
    			echo json_encode($ret);
    			return;
    		}
    		if ($data['filetype'] == 'qrcode') {
    			self::qrcode_generate($ret);
    			self::qrcode_export();
    		} else {
    			self::key_export($ret, $file_name);
    		}*/

            if ($data['filenum'] == 'one') {
                //数据获取逻辑待定
                $page['type'] = 0;
                $action = ($data['filetype'] == 'qrcode')? 'show': 'show_index';
                // $action = 'show_index';

                $rspString = getResponse( $module, $action , $page );
                $ret = getAssign($rspString, $module);               


                if ($ret['code']) {
                    return;
                }

                if ($ret['name']) {
                    $tmp[] = $ret;
                    $ret = $tmp;
                }

                if ($data['filetype'] == 'qrcode') {
                    self::qrcode_generate($ret);
                    self::qrcode_export();
                } else {
                    self::key_export($ret, $file_name);
                }
            } else {
                $page['type'] = 1;
				$page['page'] = 1;
                $page['pageSize'] = 10;
                $action = ($data['filetype'] == 'qrcode')? 'show': 'show_index';
                // $action = 'show_index';
                $rspString = getResponse( $module, $action , $page );
                $ret = getAssign($rspString, $module);
                if ($ret['name']) {
                    $tmp[] = $ret;
                    $ret = $tmp;
                }
                $total = $rspString[$module]['page']['total'];
                $cnt = $rspString[$module]['page']['count'];
                $num = ceil($total/$cnt);
                // var_dump($total);die;
                if($total > 10) {
                    //将首次获取数据进行整理
                    /*if ($data['filetype'] == 'qrcode') {
                        self::qrcode_generate($ret);
                    } else {
                        $list = array_merge($list, $ret);
                    }*/
                    for ($i = 1; $i <= $num; $i++) {
                        $page['page'] = $i;
                        if ($i == $num) {
                            $page['count'] = 10;//$total - ($i - 1) * 10;
                        }

                        $rspString = getResponse( $module, $action , $page );
                        $ret = getAssign($rspString, $module, 0);

                        if ($ret['group']['name']) {
                            $tmp[] = $ret['group'];
                            $ret['group'] = $tmp;
                        }

                        if ($data['filetype'] == 'qrcode') {
                            self::qrcode_generate($ret['group']);
                        } else {
                            $list = array_merge($list, $ret['group']);
                        }
                    }
                } else {
                    if ($data['filetype'] == 'qrcode') {
                        self::qrcode_generate($ret);
                    } else {
                        $list = array_merge($list, $ret);
                    }
                }
                if ($data['filetype'] == 'qrcode') {
                    self::qrcode_export();
                } else {
                    //if (!empty($list)) {
                        self::key_export($list, $file_name);
                    //}
                }
            }

    	}
    }
?>