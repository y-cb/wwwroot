<?php
namespace controller\system;
use controller\mController;
use lib\Json2Csv;
use lib\QRcode;

class AdminKeyManageController extends mController{

	private $qrcode_file_name =  'qrcode.tar.gz';
	public $qrocode_module = 'admin_qrencode_cfg';
	private $qrcode_path =  '/tmp/qrcode/';
	public $module = 'adminkey_manage';
	public $ha_module = 'adminkey_manage_ha';
	private $tmp_file_path = '/tmp/tmp_qrcode.png';

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
		}
		header('Content-type: application/json');
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
		if($data){
			$list = self::is_accoc($data);

			foreach ($list as $key => $value) {
				$file_path = (empty($value['grpname']))? ($this->qrcode_path . $value['name']): ($this->qrcode_path . $value['grpname'] .'_' . $value['name']);
				$file_path .= '.png';
				self::qocode_output(urldecode($value['qrencode']), $file_path);
			}
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
        foreach($data as $key => $val) {
            $data[$key]['name'] = $val['name']."\t";
        }
		$data = json_encode($data);
		echo Json2Csv::json_csv($data);
	}

	private function export($data) {
		//数据整理
		if (!file_exists($this->qrcode_path)) {
			mkdir($this->qrcode_path);
		}
		$module = ($data['filetype'] == 'qrcode')? $this->qrocode_module : $this->module;
		$file_name =  'key_' . date('YmdHis', time()) . '.xls';
		$list = array();

		/*if($data['filenum'] == 'all'){
			$data['number']=1;
		}*/
		$rspString = getResponse( $module, "show" , $data );
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
		}

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
}

