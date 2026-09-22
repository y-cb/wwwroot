<?php
//定义隔离地址，进行阻断
$php_self = $_SERVER['PHP_SELF'];

if(!preg_match('/^((?:(?:25[0-5]|2[0-4]\d|((1\d{2})|([1-9]?\d)))\.){3}(?:25[0-5]|2[0-4]\d|((1\d{2})|([1-9]?\d)))(:\d{1,5})?)$/', $_SERVER['HTTP_HOST'])
    && !preg_match('/^(127\.0\.0\.1:[0-9]{1,5})$/', $_SERVER['HTTP_HOST'])
    && !preg_match('/^(localhost)$/', $_SERVER['HTTP_HOST'])
    && !empty($_SERVER['HTTP_HOST'])){
    header('HTTP/1.1 404 Not Found');
    exit('404');
}
$block_array = array(
  '/auth/',
  '/sslvpn/',
  '/vendor/',
  '/common/',
  '/phonemsg_sdk/',
  "/cacrl.crl"
);
foreach($block_array as $value){
   if (strpos($php_self, $value)!== false){
     header('Location: /');
     return;
   }
}

