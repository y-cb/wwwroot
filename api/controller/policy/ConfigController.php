<?php
namespace controller\policy;
use controller\mController;

class ConfigController extends mController{
    function delete(){
        $param = get_inputs();
        if ($param['type'] == 'period_time') { //周期时间
            $module = 'clear_tr_time_table';
            $ret = getResponse($module,'del','');
        } elseif($param['type'] == 'abs_time') { //绝对时间
            $module = 'clear_tr_time_table';
            $ret = getResponse($module,'del','');
        } elseif($param['type'] == 'service') {  //服务对象
            $module = 'clear_sev_obj_table';
            $ret = getResponse($module,'del','');
        } elseif($param['type'] == 'address') {     //地址对象
            $module = 'clear_addr_obj_table';
            $ret = getResponse($module,'del','');
        } elseif($param['type'] == 'acl') {   //防火墙策略
            $module = 'clear_fw_policy_table';
            $ret = getResponse($module,'del','');
        } elseif($param['type'] == 'vlan') {    //VLAN
            $module = 'clear_tb_vlan';
            $ret = getResponse($module,'del','');
        } elseif($param['type'] == 'dhcp_server') {     //DHCP
            $module = 'clear_dhcp_server';
            $ret = getResponse($module,'del','');
        } elseif($param['type'] == 'healthcheck') {     //健康检查
            $module = 'clear_healthcheck';
            $ret = getResponse($module,'del','');
        } elseif($param['type'] == 'healthcheck-group') {     //健康检查组
            $module = 'clear_healthcheck_group';
            $ret = getResponse($module,'del','');
        } elseif($param['type'] == 'ips_merge') {     //ips日志合并
            $module = 'ips_log_merge';
            $ret = getResponse($module,'clear','');
        } elseif($param['type'] == 'ips_link') {     //ips设备联动
            $module = 'idp_linkage';
            $ret = getResponse($module,'clear','');
        } elseif($param['type'] == 'ips_sig') {     //ips事件集
            $module = 'ips_sig_set';
            $ret = getResponse($module,'clear','');
        } elseif($param['type'] == 'ips_rule') {     //ips防护策略
            $module = 'ips_rule';
            $ret = getResponse($module,'clear','');
        } elseif($param['type'] == 'blacklist') {     //黑名单
            $module = 'sec_ad_blacklist';
            $ret = getResponse($module,'clear','');
        } elseif($param['type'] == 'ddos') {     //dos防护
            $module = 'anti_attack';
            $ret = getResponse($module,'clear','');
        } elseif($param['type'] == 'app') {     //应用控制策略
            $module = 'app_policy';
            $ret = getResponse($module,'clear','');
        } elseif($param['type'] == 'web') {     //web访问策略
            $module = 'xml_web_access_policy';
            $ret = getResponse($module,'clear','');
        } elseif($param['type'] == 'app_audit') {     //应用审计
            $module = 'xml_app_audit_policy';
            $ret = getResponse($module,'clear','');
        } elseif($param['type'] == 'whitelist') {     //白名单
            $module = 'xml_app_whitelist';
            $ret = getResponse($module,'clear','');
        } elseif($param['type'] == 'url_whitelist') {     //url白名单
            $module = 'xml_url_whitelist';
            $ret = getResponse($module,'clear','');
        } elseif($param['type'] == 'app_group') {     //应用组
            $module = 'app_group';
            $ret = getResponse($module,'clear','');
        } elseif($param['type'] == 'syslog') {     //日志服务器
            $module = 'syslog';
            $ret = getResponse($module,'clear','');
        } elseif($param['type'] == 'dns') {     //DNS
            $module = 'dns';
            $ret = getResponse($module,'clear','');
        } elseif($param['type'] == 'url') {     //预定义URL
            $module = 'xml_custom_url';
            $ret = getResponse($module,'clear','');
        }elseif($param['type'] == 'av') {     //AV防护策略
            $module = 'xml_av_rule';
            $ret = getResponse($module,'clear','');
        } elseif($param['type'] == 'av_engine') {     //AV扫描文件
            $module = 'av_engine';
            $ret = getResponse($module,'clear','');
        } elseif($param['type'] == 'av_engtype') {     //AV扫描文件类型
            $module = 'check_list';
            $ret = getResponse($module,'clear','');
        } elseif($param['type'] == 'av_config') {     //AV沙箱配置
            $module = 'anti_apt';
            $ret = getResponse($module,'clear','');
        }
        $ret = getAssign($ret, $module);
        header('Content-type: application/json');
        if (!empty($ret)) {
            echo json_encode($ret);
        }
    }
}

?>
