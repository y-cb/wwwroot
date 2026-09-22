<?php
	include_once("head.php");
	$rspString = getResponse( 'vpn_client_cfg', "show");
	$dl_param = getAssign($rspString, 'vpn_client_cfg');

	if(file_exists('/mnt1/vpn_client/')){
		$file_dir = '/mnt1/vpn_client/';
	}else{
		$file_dir = '/mnt/boot/vpn_client/';
	}
	$download_type = $_GET['type'];
	if($download_type){
		switch ($download_type) {
			case 'client_windows32':
				$filename = $dl_param[client_windows32];
				$dir = $file_dir.'VPNCLIENT_WIN32/'.$filename;
				break;
			case 'client_windows64':
				$filename = $dl_param[client_windows64];
				$dir = $file_dir.'VPNCLIENT_WIN64/'.$filename;
				break;
			case 'client_android':
				$filename = $dl_param[client_android];
				$dir = $file_dir.'VPNCLIENT_ANDROID/'.$filename;
				break;
			case 'client_ios':
				$filename = $dl_param[client_ios];
				$dir = $file_dir.'VPNCLIENT_IOS/'.$filename;
				break;
			default:
				# code...
				break;
		}
		$down_host = $_SERVER['SERVER_NAME'];
		header('Content-type: application/octet-stream; charset=utf-8');//下载动作的关键
		Header("Accept-Ranges: bytes");
		header('Content-Disposition: attachment; filename='.$filename );
		ob_clean();
		flush();
		readfile($dir);  //读取文件到缓冲区
		exit();
	}


?>
	<body style="background: transparent; ">
	<div>
    	<p id="page-intro" class="client_download"><?php echo getCommonResource('sslvpn_client_download');?></p>
	    <ul class="shortcut-buttons-set">

		<?php
		if($dl_param[client_windows32]){
			//echo '<li><a class="shortcut-button"   target="_blank" href="?type=client_windows32"><span> <img src="resources/images/icons/win32_48.png" alt="icon" /><br />'.getCommonResource('sslvpn_32_win').'</span></a></li> ' ;
			echo strstr($dl_param[client_windows32] ,"http")  ?  '<li><a class="shortcut-button"   target="_blank" href='.$dl_param[client_windows32].' ><span> <img src="resources/images/icons/win32_48.png" alt="icon" /><br />'.getCommonResource('sslvpn_32_win').'</span></a></li>' : '<li><a class="shortcut-button"   target="_blank" href="?type=client_windows32"><span> <img src="resources/images/icons/win32_48.png" alt="icon" /><br />'.getCommonResource('sslvpn_32_win').'</span></a></li> ' ;
		};
		/*if($dl_param[client_xp64]){
		 echo  strstr($dl_param[client_xp64] ,"http") ?  '<li><a class="shortcut-button"   target="_blank" href='.$dl_param[client_xp64].' ><span> <img src="resources/images/icons/win32_48.png" alt="icon" /><br />'.getCommonResource('sslvpn_64_winxp').'</span></a></li>' : ' <li><a class="shortcut-button"   target="_blank" href="http://'.$dl_param[client_xp64].'" ><span> <img src="resources/images/icons/win32_48.png" alt="icon" /><br />'.getCommonResource('sslvpn_64_winxp').'</span></a></li>' ;
		}
		 if($dl_param[client_vista32]){
			echo strstr($dl_param[client_vista32] ,"http")  ?  '<li><a class="shortcut-button"   target="_blank" href='.$dl_param[client_vista32].' ><span> <img src="resources/images/icons/win64_48.png" alt="icon" /><br />'.getCommonResource('sslvpn_32_vista').'</span></a></li>' : '<li><a class="shortcut-button"   target="_blank" href="http://'.$dl_param[client_vista32].' "><span> <img src="resources/images/icons/win64_48.png" alt="icon" /><br />'.getCommonResource('sslvpn_32_vista').'</span></a></li> ' ;
		}; */
		if($dl_param[client_windows64]){
			//echo '<li><a class="shortcut-button"   target="_blank" href="?type=client_windows64"><span> <img src="resources/images/icons/win64_48.png" alt="icon" /><br />'.getCommonResource('sslvpn_64_win').'</span></a></li> ' ;
			echo  strstr($dl_param[client_windows64] ,"http") ?  '<li><a class="shortcut-button"   target="_blank" href='.$dl_param[client_windows64].' ><span> <img src="resources/images/icons/win64_48.png" alt="icon" /><br />'.getCommonResource('sslvpn_64_win').'</span></a></li>' : ' <li><a class="shortcut-button"   target="_blank" href="?type=client_windows64"><span> <img src="resources/images/icons/win64_48.png" alt="icon" /><br />'.getCommonResource('sslvpn_64_win').'</span></a></li>' ;
		}

		if($dl_param[client_android]){
			//echo '<li><a class="shortcut-button"   target="_blank" href="?type=client_android"><span> <img src="resources/images/icons/android_48.png" alt="icon" /><br />'.getCommonResource('sslvpn_android').'</span></a></li> ' ;
        	echo strstr($dl_param[client_android]  ,"http") ?  '<li><a class="shortcut-button"   target="_blank"    href='.$dl_param[client_android].' ><span> <img src="resources/images/icons/android_48.png" alt="icon" /><br />'.getCommonResource('sslvpn_android').'</span></a></li>' : '<li><a class="shortcut-button"  target="_blank" href="?type=client_android"><span> <img src="resources/images/icons/android_48.png" alt="icon" /><br />'.getCommonResource('sslvpn_android').'</span></a></li>' ;
		}
		if($dl_param[client_ios]&&$dl_param['type']=='1'){
			//echo '<li><a class="shortcut-button"   target="_blank" href="?type=client_ios"><span> <img src="resources/images/icons/ios_48.png" alt="icon" /><br />'.getCommonResource('sslvpn_ios').'</span></a></li> ' ;
        	echo strstr($dl_param[client_ios]  ,"http") ?  '<li><a class="shortcut-button"   target="_blank" href='.$dl_param[client_ios].' ><span> <img src="resources/images/icons/ios_48.png" alt="icon" /><br />'.getCommonResource('sslvpn_ios').'</span></a></li>' : '<li><a class="shortcut-button" target="_blank" href="?type=client_ios"><span> <img src="resources/images/icons/ios_48.png" alt="icon" /><br />'.getCommonResource('sslvpn_ios').'</span></a></li>';
		}
		echo !$dl_param[client_ios] && !$dl_param[client_android] && !$dl_param[client_windows64] && !$dl_param[client_windows32]  ?  '<li class=""><img src="resources/images/icons/blank_net_48.png" alt="icon" /><label style="padding-left: 20px;color: darkgray;">'.getCommonResource('sslvpn_no_down').'</label></li>': ' ';
		 ?>
	    </ul>
  			 <div class="clear"></div>
    <!-- End .shortcut-buttons-set -->
   </div>
	</body>
</html>
