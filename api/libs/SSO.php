<?php
/**
 * Created by PhpStorm.
 * User: wangminghao
 * Date: 2022/6/15
 * Time: 3:48 PM
 */

namespace lib;


class SSO
{
    private static $pem_path = '/etc/webserver.pem';
//    private static $sso_path = '/tmp/sso_config.json';

    public function check_sso_file($data) {
        if (file_exists(SSO_FILE)) {
            $username = base64_decode($data[0]);
            $password = base64_decode($data[1]);
            $srcip = base64_decode($data[2]);
            $config_json = file_get_contents(SSO_FILE);

            $config_array = json_decode($config_json, true);

            foreach ($config_array as $key=>$val) {
                if ($val['srcip'] === $srcip && $val['username'] === $username && $val['password'] === $password) {
                    if ($val['validtime'] < time()) {
                        unset($config_array[$key]);
                        continue;
                    } else {
                        unset($val['password']);
                        return $val;
                    }
                }
            }
            @file_put_contents(SSO_FILE, json_encode($config_array));
        }
        return true;
    }

    public function write_sso_file($login) {
        $data = [];

        if (file_exists(SSO_FILE)) {
            $json = file_get_contents(SSO_FILE);

            if ($json) {
                $data = json_decode($json, true);
            }
        }

        $info = ['srcip' => $login['srcip'], 'username'=> $login['username'], 'password'=> $login['password'], 'token'=> session_id(), 'validtime'=> (time() + 3600)];
        $data[] = $info;

        @file_put_contents(SSO_FILE, json_encode($data));

        unset($info['password']);

        return $info;
    }

    public function get_token_session(){
        $token_file = '/mnt/boot/token.json';
        $rstr = '';
        $m = 32;
        $arr = array();
        $str = 'abcdefghijklmnopqrstuvwsyz0123456789';
        $max = strlen($str) - 1;
        for ($i = 1; $i <= $m; $i++) {
            $rstr .= $str[mt_rand(0, $max)];
        }

        return $rstr;
    }

    public function get_pem_key() {
        $data = file_get_contents(SSO::$pem_path);

        if($data){
            $str = strstr($data, '-----BEGIN CERTIFICATE-----');
            $str = str_replace(array("\r\n", "\r", "\n"), "", $str);
            sscanf($str, "-----BEGIN CERTIFICATE-----%[a-zA-Z0-9\/\+]-----END CERTIFICATE-----",$key);
            return $key;
        }

        return false;
    }
}