<?php
require_once '../common/config.inc';
require_once '../common/common.inc';
require_once '../common/func.inc';
require_once '../common/cfgeng.inc';

function aes_decrypt($data) {
    $privateKey=$_SESSION['randomkey'];
    $iv=$_SESSION['randomkey'];

    $encryptedData=base64_decode($data);
    // $decrypted=mcrypt_decrypt(MCRYPT_RIJNDAEL_128,$privateKey,$encryptedData,MCRYPT_MODE_CBC,$iv);
    $decrypted=openssl_decrypt($encryptedData, "AES-128-CBC", $privateKey, OPENSSL_RAW_DATA|OPENSSL_ZERO_PADDING, $iv);
    return $decrypted;
}
$cookieInfo = ($_COOKIE['logincookie'] && isset($_COOKIE['logincookie'])) ? json_decode($_COOKIE['logincookie'],true) : array();
$usr = formatpost(trim(aes_decrypt($_POST['username'])));
$oldpwd = formatpost(trim(aes_decrypt($_POST['oldpassword'])));
$newpwd = formatpost(trim(aes_decrypt($_POST['newpassword'])));
$token = formatpost(trim(aes_decrypt($_POST['token'])));
$error_msg = '';
if (isset($usr, $newpwd, $oldpwd)) {
    if($token!=$_SESSION['token']){
        echo '0#'."check_token_error";
        exit();
    }
    $param[username] = $usr;
    $param[newpassword] = $newpwd;
    $param[oldpassword] = $oldpwd;
    $rspString = getResponse( "webauthchgpassword", "mod" , $param );

    $result = $rspString['return_code']['group'];
    if($result[str])
        $error_msg = $result[str];
}
echo $error_msg;
exit();
?>
