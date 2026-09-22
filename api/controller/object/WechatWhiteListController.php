<?php
namespace controller\object;
use controller\mController;

class WechatWhiteListController extends mController {
    public $module = 'addr_obj_table';
    private $object_default_name = 'def_wechat_whitelist_policy';
    private $object_default_desc = 'wechat domain white list';
    private $config_path = '/mnt/boot/wechat_whitelist_policy';
    private $whitelist_path = '/mnt/boot/wechat_whitelist_detail';
    private $wechat_domain_array = ['open.weixin.qq.com', 'res.wx.qq.com', 'lp.open.weixin.qq.com'];
    private $wechat_service_domain = 'aaa.www.sec-inside.com';

    function get() {
        $param = get_inputs();

        if (isset($param['gettype']) && $param['gettype'] === 'name') {
            if (!file_exists($this->config_path)) {
                echo json_encode(['object_name'=> 'none']);
                exit;
            } else {
                $str = file_get_contents($this->config_path);

                $rspString = getResponse($this->module, 'showone', ['addr_type'=> 1, 'ip_type'=> 1,'name'=> $policy_name,'ref'=> -1]);
                $whitelist_object = getAssign($rspString, $this->module);
                $data = ['object_name'=> 'none'];
                if (!empty($whitelist_object)) {
                    $data = ['object_name'=> trim($str)];
                }else {
                    @unlink($this->config_path);
                }

                echo json_encode($data);
                exit;
            }

        }

        $policy_cache = @json_decode(@file_get_contents($this->whitelist_path));
        if($policy_cache && is_array($policy_cache)) {
            $policy_cache = array_column($policy_cache, 'domain_name');
            $this->wechat_domain_array = array_merge($this->wechat_domain_array, $policy_cache);
            if(array_search($this->wechat_service_domain, $this->wechat_domain_array)) {
                unset($this->wechat_domain_array[array_search($this->wechat_service_domain, $this->wechat_domain_array)]);
            }
            $this->wechat_domain_array = array_values(array_unique($this->wechat_domain_array));
        }

        if(!file_exists($this->config_path)) {
            echo json_encode(['object_name'=> 'none', 'list' => $this->wechat_domain_array, 'default_service'=> $this->wechat_service_domain]);
            exit;
        }

        $policy_name = file_get_contents($this->config_path);

        if (empty($policy_name)) {
            echo json_encode(['object_name'=> 'none', 'list' => $this->wechat_domain_array, 'default_service'=> $this->wechat_service_domain]);
            exit;
        }

        $rspString = getResponse($this->module, 'showone', ['addr_type'=> 1, 'ip_type'=> 1,'name'=> $policy_name,'ref'=> -1]);
        $whitelist_object = getAssign($rspString, $this->module);

        if (empty($whitelist_object)) {
            @unlink($this->config_path);
        }

        //默认数据规则匹配
        if ($whitelist_object['desc']!= $this->object_default_desc) {
            echo json_encode(['object_name'=> 'none', 'list' => $this->wechat_domain_array, 'default_service'=> $this->wechat_service_domain]);
            exit;
        }

        $item_array = json_decode($whitelist_object['item'], true);

        $list = array_column($item_array['group'], 'domain_name');
        echo json_encode(['object_name'=> $whitelist_object['name'], 'list'=> $list, 'default_service'=> $this->wechat_service_domain]);
        exit;
    }

    function put() {
        $param = get_inputs();
        $object_name='';
        $action='';
        $list=[];
        $data=[];

        foreach ($param['list'] as $val) {
            if(empty($val)) {
                continue;
            }
            if(
                !preg_match('/^[a-zA-Z0-9][-a-zA-Z0-9]{0,62}(\.[a-zA-Z0-9][-a-zA-Z0-9]{0,62})+\.?$/', $val) ||
                preg_match('/^((2(5[0-5]|[0-4]\d))|[0-1]?\d{1,2})(\.((2(5[0-5]|[0-4]\d))|[0-1]?\d{1,2})){3}$/', $val)

            ) {
                echo json_encode(['code' => '-2', 'str' => t('wechat.domain_err_1')."「{$val}」".t('wechat.domain_err_2')]); exit;
            }
            $list[] = [
                'domain_name'=> $val,
                'type'=> '9',
                'exclude'=> '0'
            ];
        }

        if ($param['object_name'] === 'none') {
            $object_name = $this->get_object_name($this->object_default_name);
            $action = 'add';

            $data = [
                'name'=> $object_name,
                'desc'=> $this->object_default_desc,
                'type'=> '0',
                'fresh_time'=> 60,
                'item'=> $list
            ];
        } else {
            $rspString = getResponse($this->module, 'showone', ['addr_type'=> 1, 'ip_type'=> 1,'name'=> $param['object_name'],'ref'=> -1]);
            $object = getAssign($rspString, $this->module);
            $action = 'mod';

            $data = $object;
            $data['item'] = $list;
            $data['fresh_time'] = 60;
        }

        $edit_rspString = getResponse($this->module, $action, $data);
        $edit_ret = getAssign($edit_rspString, $this->module);

        if (empty($edit_ret)) {
            @file_put_contents($this->config_path, $data['name']);
            @file_put_contents($this->whitelist_path, json_encode($list));
        } else {
            echo json_encode($edit_ret);
        }
        exit;
    }

    /**
     * 递归计算微信认证白名单地址对象名称
     */
    protected function get_object_name($name) {
        $rspString = getResponse($this->module, 'showone', ['addr_type'=> 1, 'ip_type'=> 1, 'name'=> $name,'ref'=> -1]);
        $object = getAssign($rspString, $this->module);

        if (!empty($object) && $object['desc']!= $this->object_default_desc) {
            $basename = ($name === $this->object_default_name)? $name: $this->object_default_name;
            $random = mt_rand(1000, 9999);

            $new_name = $basename . '_' . $random;
            return $this->get_object_name($new_name);
        } else {
            return $name;
        }
    }
}
