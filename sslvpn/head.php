<?php
/*if(!strstr($_SERVER['HTTP_HOST'],'8443')){
	header('Location:/login.html');
	break;
}*/
require_once '../common/config.inc';
require_once '../common/common.inc'; 
require_once 'sslvpn_lang.php';
$DEMO_DATA = 0;
$rspString = getResponse( 'login_state_xml', "show" , $param, $demo_link='page_frame_timeout' );
// print $rspString[login_state_xml][group][state]	
if( !isset($_COOKIE["user"]) || $_GET['action'] == 'SignOut')
{
	webauthlogout();
};

function webauthlogout()
{
  $param['vsysid'] = $_SERVER['VSYSID'];
  $rspString = getResponse( "webauthlogout", "mod" , $param );
  setcookie("user", "",  time()- 3600,"/");
  //header("Location:login.html");
  echo "<script>window.top.location.href='login.html'</script>";
  
};

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html;charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<title></title>
<!--                       CSS                       -->
<!-- Reset Stylesheet -->
<link rel="stylesheet" href="resources/css/reset.css" type="text/css" media="screen" />
<!-- Main Stylesheet -->
<link rel="stylesheet" href="resources/css/style.css" type="text/css" media="screen" />
<!-- Invalid Stylesheet. This makes stuff look pretty. Remove it if you want the CSS completely valid -->
<link rel="stylesheet" href="resources/css/invalid.css" type="text/css" media="screen" />
<!--                       Javascripts                       -->
<!-- jQuery -->
<script type="text/javascript" src="resources/js/jquery-1.11.1.js"></script>
<script type="text/javascript" src="resources/js/function.js"></script>
</head>
