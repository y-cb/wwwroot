<?php
namespace controller\object;
use controller\mController;

/**
 * @api {POST}  /api/address 添加地址对象
 * @apiName 添加地址对象
 * @apiGroup 地址对象
 *
 *
 * @apiParam {String} name 地址对象名称
 * @apiParam {String} desc 地址对象描述
 * @apiParam {Number} type 地址对象类型
 * @apiParam {Array} item 要添加的地址对象的集合:"type"表示地址类型，"host"表示ip地址，"range1"表示地址起始，"range2"表示地址结束，"net"表示网络地址，"isp_name"表示服务商名称，"isp_desc"表示服务商描述，"Host_v6"表示ipv6地址，"net_v6"表示ipv6网络地址，"range6_min"ipv6地址起始，"range6_max"ipv6地址结束,
 *
 * @apiParamExample {json} Request-Example:
 *  {
 *      "name": "my_new",
 *      "desc": "my_new_add_obj",
 *      "type": 0,
 *      "item": [{"host":"7.7.7.7", "type":0}, {"range1":"7.7.7.7", "range2":"7.7.7.70", "type":2}]
 *  }
 *
 * @apiSuccessExample {json} Success-Response:
 *  HTTP/1.1 200 OK
 *  {
 *      "code":"0"
 *  }
 *
 * @apiErrorExample {json} Error-Response:
 *  HTTP/1.1 422 Not Found
 *  {
 *      "code":"非0"
 *  }
 *
 */

/**
 * @api {GET}  /api/address 获取所有地址对象信息
 * @apiName 获取所有地址对象信息
 * @apiGroup 地址对象
 *
 *
 *
 *
 * @apiParamExample {json} Request-Example:
 *  {
 *  }
 *
 * @apiSuccessExample {json} Success-Response:
 *  HTTP/1.1 200 OK
 *  {
        total: 3
        data: [
                {'type': '0', 'ref': '6', 'name': 'any', 'item': {'group': [{'range6_min': '', 'range6_max': '', 'range1': '', 'net_v6': '', 'mac': '', 'range2': '', 'host': '', 'host_v6': '', 'isp_desc': '', 'isp_name': '', 'type': '1', 'net': '0.0.0.0/0'}, {'range6_min': '', 'range6_max': '', 'range1': '', 'net_v6': '::/0', 'mac': '', 'range2': '', 'host': '', 'host_v6': '', 'isp_desc': '', 'isp_name': '', 'type': '8', 'net': ''}]}, 'desc': ''},
                {'type': '0', 'ref': '0', 'name': 'bbbb', 'item': {'group': [{'range6_min': '', 'range6_max': '', 'range1': '', 'net_v6': '', 'mac': '', 'range2': '', 'host': '8.9.8.8', 'host_v6': '', 'isp_desc': '', 'isp_name': '', 'type': '0', 'net': ''}, {'range6_min': '', 'range6_max': '', 'range1': '1.2.3.4', 'net_v6': '', 'mac': '', 'range2': '1.2.3.8', 'host': '', 'host_v6': '', 'isp_desc': '', 'isp_name': '', 'type': '2', 'net': ''}]}, 'desc': 'cccc'},
                {'type': '0', 'ref': '0', 'name': 'my_new', 'item': {'group': [{'range6_min': '', 'range6_max': '', 'range1': '7.7.7.7', 'net_v6': '', 'mac': '', 'range2': '7.7.7.70', 'host': '', 'host_v6': '', 'isp_desc': '', 'isp_name': '', 'type': '2', 'net': ''}, {'range6_min': '', 'range6_max': '', 'range1': '', 'net_v6': '', 'mac': '', 'range2': '', 'host': '6.6.6.6', 'host_v6': '', 'isp_desc': '', 'isp_name': '', 'type': '0', 'net': ''}]}, 'desc': 'my_new_add_obj'}
            ]
 *  }
 *
 * @apiErrorExample {json} Error-Response:
 *  HTTP/1.1 422 Not Found
 *  {
 *      "code":"非0"
 *  }
 */

/**
 * @api {GET}  /api/address 获取当个地址对象信息
 * @apiName 获取单个地址对象信息
 * @apiGroup 地址对象
 *
 * @apiParam {String} name 地址对象名称
 * @apiParam {Number} type 地址对象类型
 *
 * @apiParamExample {json} Request-Example:
 *  {
 *      "name": "my_new",
 *      "type": 0
 *  }
 *
 * @apiSuccessExample {json} Success-Response:
 *  HTTP/1.1 200 OK
 *  {
 *      "total": 1,
 *      "data": [{'type': '0', 'ref': '0', 'name': 'my_new', 'item': {'group': [{'range6_min': '', 'range6_max': '', 'range1': '7.7.7.7', 'net_v6': '', 'mac': '', 'range2': '7.7.7.70', 'host': '', 'host_v6': '', 'isp_desc': '', 'isp_name': '', 'type': '2', 'net': ''}, {'range6_min': '', 'range6_max': '', 'range1': '', 'net_v6': '', 'mac': '', 'range2': '', 'host': '6.6.6.6', 'host_v6': '', 'isp_desc': '', 'isp_name': '', 'type': '0', 'net': ''}]}, 'desc': 'my_new_add_obj'}]
 *  }
 *
 * @apiErrorExample {json} Error-Response:
 *  HTTP/1.1 422 Not Found
 *  {
 *      "code":"非0"
 *  }
 */

/**
 * @api {PUT}  /api/address 修改地址对象
 * @apiName 修改地址对象
 * @apiGroup 地址对象
 *
 *
 * @apiParam {String} name 地址对象名称
 * @apiParam {String} desc 地址对象描述
 * @apiParam {Number} type 地址对象类型
 * @apiParam {Array} item 要添加的地址对象的集合:"type"表示地址类型，"host"表示ip地址，"range1"表示地址起始，"range2"表示地址结束，"net"表示网络地址，"isp_name"表示服务商名称，"isp_desc"表示服务商描述，"Host_v6"表示ipv6地址，"net_v6"表示ipv6网络地址，"range6_min"ipv6地址起始，"range6_max"ipv6地址结束,
 *
 * @apiParamExample {json} Request-Example:
 *  {
 *      "name": "my_new",
 *      "desc": "my_new_add_obj",
 *      "type": 0,
 *      "item": [{"host":"7.7.7.7", "type":0}, {"host":"8.8.8.8", "type":0}, {"range1":"7.7.7.7", "range2":"7.7.7.70", "type":2}]
 *  }
 *
 * @apiSuccessExample {json} Success-Response:
 *  HTTP/1.1 200 OK
 *  {
 *      "code":"0"
 *  }
 *
 * @apiErrorExample {json} Error-Response:
 *  HTTP/1.1 422 Not Found
 *  {
 *      "code":"非0"
 *  }
 *
 */

/**
 * @api {DELETE}  /api/address 删除地址对象信息
 * @apiName 删除地址对象信息
 * @apiGroup 地址对象
 *
 *
 * @apiParam {String} name 地址对象名称
 * @apiParam {Number} type 地址对象类型
 * @apiParam {Number} def  地址对象定义类型:0表示自定义类型,1表示与定义类型
 *
 * @apiParamExample {json} Request-Example:
 *  {
 *      "name": "my_new",
 *      "type": 0,
 *      "def": 0
 *  }
 *
 * @apiSuccessExample {json} Success-Response:
 *  HTTP/1.1 200 OK
 *  {
 *      "code":"0"
 *  }
 *
 * @apiErrorExample {json} Error-Response:
 *  HTTP/1.1 422 Not Found
 *  {
 *      "code":"非0"
 *  }
 *
 */



class AddressController extends mController {
    public $module = 'addr_obj_table';
    private $address_items = [0=>'host',1=>'net',2=>['range1','range2'],3=>'mac',4=>['host','mac'],5=>['isp_name','isp_desc'],6=>'host_v6',7=>['range6_min','range6_max'],8=>'net_v6',9=>'domain_name',10=>['geo_name','geo_name_cn','geo_name_en']];
    private $address_exitems = [0=>'ex_host',1=>'ex_net',2=>['ex_range1','ex_range2'],6=>'ex_host_v6',7=>['ex_range6_min','ex_range6_max'],8=>'ex_net_v6',10=>['ex_geo_name','ex_geo_name_cn','ex_geo_name_en']];
    function get() {
         $data = array();
         $param = get_inputs();

         $show_one = false;
         if ($param['op'] == 'list') {
            $rspString = getResponse($this->module, "show_index" ,$param);
            $ret = getAssign($rspString, $this->module, false, true);
         } else if ($param['op'] == 'detail') {
            $show_one = true;
            $rspString = getResponse($this->module, "show_one" ,$param);
            $ret = getAssign($rspString, $this->module);
            if ($ret['group']) {
                $ret['group'] = json_decode($ret['group']);
            }
         } else if ($param['op'] == 'detail_o') {
            $show_one = true;
            $rspString = getResponse($this->module, "show_o" ,$param);
            $ret = getAssign($rspString, $this->module);
            if ($ret['group']) {
                $ret['group'] = json_decode($ret['group']);
            }
         } else if ($param['op'] == 'list_i') {
            $rspString = getResponse($this->module, "show_i" ,$param);
            $ret = getAssign($rspString, $this->module, false, true);
         } else if ($param['op'] == 'detail_one') {
            $rspString = getResponse($this->module, "showone" ,$param);
            $ret = getAssign($rspString, $this->module, false, true);
         } else {
            $rspString = getResponse($this->module, "show" ,$param);
            $ret = getAssign($rspString, $this->module, false, true);
         }
         header('Content-type: application/json');

         foreach($ret['group'] as $key=>$val) {
            $ret['group'][$key]['item'] = $this->filter_address_items($val['item'], $this->address_items);
            $ret['group'][$key]['ex_item'] = $this->filter_address_items($val['ex_item'], $this->address_exitems);
         }

         if($show_one) {
            echo json_encode($ret);
            return;
         } else if (empty($ret)) {
            unset($ret);
            $ret['data'] = Array();
            $ret['total'] = 0;
            echo json_encode($ret);
            return;
         } else {
            $data['data'] = $ret['group'];
            if (isset($ret['page'])) {
                $data['total'] = (int)$ret['page']['total'];
            } else {
                $data['total'] = (int)count($data['data']);
            }
            echo json_encode($data);
         }
    }

    private function filter_address_items($data, $keys) {
        $list = [];
        if (empty($data)) {
            return [];
        }

        if (!isset($data['group']['type'])) {
            foreach($data['group'] as $key=>$val) {
                $tmp = ['type'=> $val['type']];
                if (is_array($keys[$val['type']])) {
                    foreach($keys[$val['type']] as $val1) {
                        $tmp[$val1] = $val[$val1];
                    }
                } else {
                    $tmp[$keys[$val['type']]] = $val[$keys[$val['type']]];
                }
                $list[] = $tmp;
            }
        } else {
            $info = $data['group'];
            $tmp = ['type'=> $info['type']];
            if (is_array($keys[$info['type']])) {
                foreach($keys[$info['type']] as $val1) {
                    $tmp[$val1] = $info[$val1];
                }
            } else {
                $tmp[$keys[$info['type']]] = $info[$keys[$info['type']]];
            }
            $list[] = $tmp;
        }
        return ['group'=>$list];
    }
}
