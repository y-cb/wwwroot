<?php
namespace controller\policy;
use controller\mController;
use lib\Json2Csv;

class ExconnStudyAddrController extends mController {
	public $module = 'serv_exconn_study_addr';
	function get(){
		$module = $this->module;
    	$param=get_inputs();
    	if($param['download'] == 1){
    		$file_name =  t('external_study_res.study_result').'_' . date('YmdHis', time()) . '.xls';
    		$list = array();
    		$page['page'] = 1;
            $page['pageSize'] = 10;
            $action = "show_index";
            $rspString = getResponse( $module, $action , $page );
            $ret = getAssign($rspString, $module);
            if ($ret['server_name']) {
                $tmp[] = $ret;
                $ret = $tmp;
            }
            $total = $rspString[$module]['page']['total'];
            $cnt = $rspString[$module]['page']['count'];
            $num = ceil($total/$cnt);
            if($total > 10) {
                for ($i = 1; $i <= $num; $i++) {
                    $page['page'] = $i;
                    if ($i == $num) {
                        $page['count'] = 10;//$total - ($i - 1) * 10;
                    }

                    $rspString = getResponse( $module, $action , $page );
                    $ret = getAssign($rspString, $module, 0);

                    if ($ret['group']['server_name']) {
                        $tmp[] = $ret['group'];
                        $ret['group'] = $tmp;
                    }
                    $list = array_merge($list, $ret['group']);
                }
            } else {
                $list = array_merge($list, $ret);
            }
            //if (!empty($list)) {
            	header('Content-type:application/vnd.ms-excel; charset=utf-8');
    			header('Content-Disposition: attachment;filename="'.$file_name.'"');
    			header('Cache-Control: max-age=0');
    			$data = json_encode($list);
    			echo Json2Csv::json_csv($data);
            //}

    	}else{
            $action = "show";
            if($param['op']){
                $action="show_one";
            }
    		$rspString = getResponse($module, $action, $param);
    		$ret = getAssign($rspString, $module, false, true);
    		$data['data'] = $ret['group'];
	        if (isset($ret['page'])) {
	            $data['total'] = (int)$ret['page']['total'];
	        } else {
	            $data['total'] = (int)count($data['data']);
	        }
	        echo json_encode($data);
    		return;
    	}
	}
}

?>
