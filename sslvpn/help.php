<?php include_once("head.php");  ?>
<style>
.help_doc{
color:#555
}
.help_doc li{
padding:5px 0px;

}
.help_doc li:hover{
color:#57a000;
}
.help_doc .li_s{
width:50px;
display: block;
float: left;
}
.help_doc .li_m{
width:100px;
display: block;
float: left;
}
.help_doc .height{
height:10px;
}

</style>
<body style="background: transparent; ">
	<div>
    	<p id="page-intro"><?php echo getCommonResource('sslvpn_help');?></p>
		  <!--<ul class="shortcut-buttons-set">
	      <li><a class="shortcut-button" href="help_dl.php"><span class="li_s"> <img src="resources/images/icons/help_48.png" alt="icon" /><br />
	        <?php echo getCommonResource('sslvpn_config_download');?></span></a></li>
		</ul>
		
  			<div class="clear"></div>
    End .shortcut-buttons-set -->
 </div>
<?php  if(get_sapl_language() == "cn"){?>
<div id="cn" class="help_doc">
	<div class="content-box">
      <!-- Start Content Box -->
      <div class="content-box-header">
        <h3><?php echo "目录";?></h3>
        
      </div>
      <!-- End .content-box-header -->
      <div class="content-box-content">
			<div class="tab-content default-tab" id="tab1">
          <!-- This is the target div. id must match the href of this div's tab -->
				<ul>
				<li><a href="#h0001"><span class="li_s">1.	</span><?php echo "	Windows7 SSL VPN客户端的配置";?> </a></li>
				<li><a href="#h0011"><span class="li_s">1.1	</span><?php echo "	客户端下载及安装";?>	</a></li>
				<li><a href="#h0111"><span class="li_s">1.1.1 </span><?php echo "	步骤1：下载客户端";?></a>	</li>
				<li><a href="#h0112"><span class="li_s">1.1.2	</span><?php echo "步骤2：安装客户端";?></a>	</li>
				<li><a href="#h0113"><span class="li_s">1.1.3 </span><?php echo "	步骤3：运行客户端";?></a>	</li>
				<li><a href="#h0012"><span class="li_s">1.2	</span><?php echo "SSL VPN属性设置";?></a>	</li>
				<li><a href="#h0121"><span class="li_s">1.2.1 </span><?php echo "	断开/重新连接";?>	</a></li>
				<li><a href="#h0122"><span class="li_s">1.2.2 </span><?php echo "	显示状态";?></a>	</li>
				<li><a href="#h0123"><span class="li_s">1.2.3	</span><?php echo " 查看日志";?>	</a></li>
				<li><a href="#h0124"><span class="li_s">1.2.4 </span><?php echo "	修改密码";?></a>	</li>
				<li><a href="#h0125"><span class="li_s">1.2.5	</span><?php echo "系统设置";?>	</a></li>

				<li><a href="#h0002"><span class="li_s">2.	</span><?php echo "Android SSLVPN客户端的配置";?>	</a></li>
				<li><a href="#h0021"><span class="li_s">2.1	</span><?php echo "	客户端下载及安装";?>	</a></li>
				<li><a href="#h0211"><span class="li_s">2.1.1 </span><?php echo "	步骤1：下载客户端";?></a>	</li>
				<li><a href="#h0212"><span class="li_s">1.1.2	</span><?php echo "步骤2：安装客户端";?></a>	</li>
				<li><a href="#h0022"><span class="li_s">2.2	</span><?php echo "编辑配置文件及使用";?></a>	</li>
				<li><a href="#h0221"><span class="li_s">2.2.1 </span><?php echo "步骤1：编辑配置文件";?></a></li>
				<li><a href="#h0222"><span class="li_s">2.2.2 </span><?php echo "	步骤2：导入配置文件";?></a>	</li>
				<li><a href="#h0223"><span class="li_s">2.2.3	</span> <?php echo "步骤3：使用配置文件";?></a></li>
				<li><a href="#h0023"><span class="li_s">2.3 </span>	<?php echo "故障排查";?></a>	</li>
				<li><a href="#h0231"><span class="li_s">2.3.1	</span><?php echo "无法识别client.ovpn文件：";?></a></li>
				<li><a href="#h0232"><span class="li_s">2.3.2	</span><?php echo "连接失败：";?></a></li>
				<li><a href="#h0233"><span class="li_s">2.3.3	</span><?php echo "导入配置文件失败";?></a></li>

				<li><a href="#h0003"><span class="li_s">3.	</span><?php echo "IOS系统如何使用SSLVPN";?></a></li>
				<li><a href="#h0031"><span class="li_s">3.1	</span><?php echo "	客户端安装";?>	</a></li>
				<li><a href="#h0032"><span class="li_s">3.2	</span><?php echo "编辑配置文件并导入";?></a>	</li>
				<li><a href="#h0321"><span class="li_s">3.2.1 </span><?php echo "步骤1：编辑client.ovpn文件";?></a></li>
				<li><a href="#h0322"><span class="li_s">3.2.2 </span><?php echo "步骤2：传输配置文件";?></a>	</li>
				<li><a href="#h0323"><span class="li_s">3.2.3	</span><?php echo " 步骤3：导入配置文件";?></a></li>
				<li><a href="#h0033"><span class="li_s">3.3 </span><?php echo "	运行客户端";?></a>	</li>
				<li><a href="#h0034"><span class="li_s">3.4	</span><?php echo "故障排查";?></a></li>
				<li><a href="#h0341"><span class="li_s">3.4.1	</span><?php echo "App Store内找不到openvpn：";?></a></li>
				<li><a href="#h0342"><span class="li_s">3.4.2	</span><?php echo "连接失败：";?></a></li>

				<li><a href="#h0004"><span class="li_s">4.	</span><?php echo "Linux系统如何使用SSLVPN";?></a></li>
				<li><a href="#h0041"><span class="li_s">4.1	</span><?php echo "	客户端安装";?></a></li>
				<li><a href="#h0042"><span class="li_s">4.2	</span><?php echo "添加证书及配置文件";?></a>	</li>
				<li><a href="#h0421"><span class="li_s">4.2.1 </span><?php echo "添加证书及配置文件";?></a></li>
				<li><a href="#h0422"><span class="li_s">4.2.2 </span><?php echo "编辑配置文件";?></a>	</li>
				<li><a href="#h0423"><span class="li_s">4.2.3	</span><?php echo " 拨号登录";?></a></li>
				<li><a href="#h0043"><span class="li_s">4.3	</span><?php echo "故障排查";?></a></li>
				<li><a href="#h0431"><span class="li_s">4.3.1	</span><?php echo "“# apt-get install openvpn”命令安装失败：";?></a></li>
				<li><a href="#h0432"><span class="li_s">4.3.2	</span><?php echo "连接失败：";?></a></li>

				</ul>
			</div>
		</div>
	</div>

	<div class="content-box" style="margin-top:400px">
      <!-- Start Content Box -->
    
	    <div  class="content-box-header">
			<h5 id="h0001"> <?php echo "1.Windows7 SSL VPN客户端的配置";?></h5>
        
        </div>
        <div class="content-box-content">
			
       
			<p>
			 <?php echo "本部分主要介绍了SSL VPN客户端安装和使用。";?><br/>
			 <?php echo "环境要求";?><br/>
			 <?php echo "1、客户端计算机已经接入因特网，并且网络通信正常。";?><br/>
			 <?php echo "2、使用主流浏览器如：IE、Chrome、Opera";?><br/>
			 <?php echo "3、电脑安装上网助手等工具，可能会影响正常使用SSL VPN，可以先卸载。";?><br/>
			 <?php echo "根据以下步骤完成Windows7操作系统的SSL VPN客户端的配置。";?><br/>
			</p>
			
			<h5 id="h0011" style="float:none"> <?php echo "1.1 客户端下载及安装";?></h5>
			<div style="border-top:1px dashed #ccc; padding:10px 0px; margin-bottom:10px">
			<h6 id="h0111"> <?php echo "1.1.1 步骤1：下载客户端";?></h6>
			
			<p>
			 <?php echo "确保此时用户已经接入了Internet，打开IE浏览器，输入https://[ssp vpn server IP]:8443，显示下图所示页面：";?><br/>
			<img src="resources/img/help/001.png"><br/>
			 <?php echo "输入正确的用户名和名账号，出现下面界面表示登录成功，下载相适应的SSL VPN客户端，显示下图所示页面：";?><br/>
			<img src="resources/img/help/002.png"><br/>
			</p>
			</div>
			
		
			<div style="border-top:1px dashed #ccc; padding:10px 0px;">
			<h6 id="h0112"><?php echo "1.1.2 步骤2：安装客户端";?></h6>
			
			<p>
			<?php echo "下载并安装完VPN客户端后，将会在“开始—>程序—>SSL VPN Client—>SSL VPN Client”找到相对应的程序，为了方便也可以安装时候创建桌面快捷方式，或者发送到桌面快捷方式使用。";?><br/>
			<img src="resources/img/help/003.png"><br/><br/>
			</p>
			</div>
			
			<div style="border-top:1px dashed #ccc; padding:10px 0px;">
			<h6 id="h0113"><?php echo "1.1.3 步骤3：运行客户端";?></h6>
			
			<p>
			<?php echo "点击";?><img src="resources/img/help/004.png"><?php echo "后，会出现客户端配置向导，如下图示：";?><br/>
			<div class="height"></div>
			<?php echo "向导1：安全提醒";?><br/>
			<img src="resources/img/help/005.png"><br/>
			<?php echo "在上图页面中，请选择【是】，弹出如下图所示：";?><br/>
			<div class="height"></div>

			<?php echo "向导2：账号登录";?><br/>
			<img src="resources/img/help/006.png"><br/>
			<br/>
			<span class="li_m"><?php echo "SSL VPN地址：";?></span><?php echo "按要求输入SSL VPN服务器地址；";?><br/>
			<span class="li_m"><?php echo "用户名：";?></span><?php echo "按要求输入自己的SSL VPN账号的用户名；";?><br/>
			<span class="li_m"><?php echo "密码：";?></span><?php echo "按要求输入自己正确的账号密码。";?><br/>
			<div class="height"></div>
			<?php echo "输入正确用户信息后，点击登录，成功后会在系统右下角，显示系统图标。";?><br/>
			<img src="resources/img/help/007.png"><br/>
			<?php echo "至此，一次登录SSL VPN，并访问SSL VPN内网资源的过程即完成。";?><br/>
			</p>
			</div>
			<h5 id="h0012"style="float:none"><?php echo "1.2 SSL VPN属性设置";?></h5>
			<div style="border-top:1px dashed #ccc; padding:10px 0px;">
			<h6 id="h0121"><?php echo "1.2.1 断开/重新连接";?></h6>
			<p>
			<?php echo "在鼠标右键点击SSL VPN图标弹出的属性界面，点击【断开】，即可结束SSL VPN访问内网资源，断开成功后会在系统右下角，显示系统图标为。";?><br/>
			<img src="resources/img/help/008.png"><br/>
			<div class="height"></div>
			<img src="resources/img/help/009.png"><br/>
			<?php echo "在鼠标右键点击SSL VPN图标弹出的属性界面，点击【显示状态】，即可进入SSL VPN的登录页面。";?><br/>
			</p>
			</div>
			
			<div style="border-top:1px dashed #ccc; padding:10px 0px;">
			<h6 id="h0122"><?php echo "1.2.2 查看状态";?></h6>
			<p>
			<?php echo "当客户端处理连接中/已经连接时，鼠标右键点击SSL VPN图标弹出的属性界面，点击【显示状态】，即可显示当前SSL VPN的详细当前连接的详情。";?><br/>
			<img src="resources/img/help/010.png"><br/>
			</p>
			</div>
			
			<div style="border-top:1px dashed #ccc; padding:10px 0px;">
			<h6 id="h0123"><?php echo "1.2.3 历史消息";?></h6>
			<p>
			<?php echo "在鼠标右键点击SSL VPN图标弹出的属性界面，点击【历史消息】，即可显示当前SSL VPN客户端的历史详情。";?><br/>
			<img src="resources/img/help/011.png"><br/>
			</p>
			</div>
			
			<div style="border-top:1px dashed #ccc; padding:10px 0px;">
			<h6 id="h0124"><?php echo "1.2.4 修改密码";?></h6>
			<p>
			<?php echo "打开IE浏览器，输入https://[服务器IP地址]:8443，显示下图所示页面：";?><br/>
			<img src="resources/img/help/012.png"><br/>
			<div class="height"></div>
			<?php echo "在上图页面，请点击“继续浏览此网站”，会显示如下页面：";?><br/>
			<img src="resources/img/help/013.png"><br/>
			<div class="height"></div>
			<?php echo "输入正确的用户名和密码后，登录修改密码页面，可以自行修改用户的密码，显示如下界面：";?><br/>
			<img src="resources/img/help/014.png"><br/>
			<div class="height"></div>
			<?php echo "[注：修改密码后，请重新登录SSL VPN客户端]";?><br/>
			</p>
			</div>
			
			<div style="border-top:1px dashed #ccc; padding:10px 0px;">
			<h6 id="h0125"><?php echo "1.2.5 系统设置";?></h6>
			<p>
			<?php echo "在鼠标右键点击SSL VPN图标弹出的属性界面，点击【Settings】，显示如下界面：";?><br/>
			<img src="resources/img/help/015.png"><br/>
			<?php echo "SSL VPN 地址：服务器地址配置";?><br/>
			<?php echo "登录VPN后不显示服务页面：勾选后登录成功自动隐藏拨号界面";?><br/>
			<?php echo "自动登录设置：启动sslvpn后自动登录。";?><br/>
			<?php echo "开机自动登录：勾选后，开机可以自动登录SSL VPN。";?><br/>
			</p> 
			</div>
			
			
	    </div>
	    <div  class="content-box-header">
			<h5 id="h0002"><?php echo " 2. Android SSLVPN客户端的配置";?></h5>
        
        </div>
        <div class="content-box-content">
			
       
			<p>
			
			</p>
			
			<h5 id="h0021" style="float:none"><?php echo "2.1 客户端下载及安装";?></h5>
			<div style="border-top:1px dashed #ccc; padding:10px 0px; margin-bottom:10px">
			<h6 id="h0211"><?php echo "2.1.1 步骤1：下载客户端";?></h6>
			
			<p>
			<?php echo "确保此时用户已经接入了Internet，打开IE浏览器，输入https://[ssp vpn server IP]:8443，显示下图所示页面：";?><br/>
			<img src="resources/img/help/018.png"><br/>
			<?php echo "输入正确的用户名和名账号，出现下面界面表示登录成功，下载相适应的SSL VPN客户端，显示下图所示页面：";?><br/>
			<img src="resources/img/help/019.png"><br/>
			</p>
			</div>
			
		
			<div style="border-top:1px dashed #ccc; padding:10px 0px;">
			<h6 id="h0112"><?php echo "2.1.2 步骤2：安装客户端";?></h6>
			
			</div>
			<h5 id="h0022"style="float:none"><?php echo "2.2 编辑配置文件及使用";?></h5>
			<div style="border-top:1px dashed #ccc; padding:10px 0px;">
			<h6 id="h0221"><?php echo "2.2.1 步骤1：编辑配置文件";?></h6>
			<p>
			<?php echo "将配置文件作为文本格式打开，找到42行 “remote 1.1.11.1 1194” 格式字段，将IP地址1.1.11.1 改为sslvpn服务器IP地址，保存退出。";?><br/>
			<img src="resources/img/help/020.png"><br/>
			
			</p>
			</div>
			
			<div style="border-top:1px dashed #ccc; padding:10px 0px;">
			<h6 id="h0222"><?php echo "2.2.2 步骤2：导入配置文件";?></h6>
			<p>
			<?php echo "将CLIENT.OVPN文件传给手机，使用QQ或微信等工具。";?><br/>
			<img src="resources/img/help/021.png"><br/>
			<div class="height"></div>
			<?php echo "直接点击文件，选择“使用其他应用打开”，会自动导入VPN应用内。";?><br/>
			<img src="resources/img/help/022.png"><br/>
			<div class="height"></div>
			</p>
			</div>
			
			<div style="border-top:1px dashed #ccc; padding:10px 0px;">
			<h6 id="h0223"><?php echo "2.2.3 步骤3：使用配置文件";?></h6>
			<p>
			<strong><?php echo "向导1：";?></strong><?php echo "启用配置文件";?><br/>
			<img src="resources/img/help/023.png"><br/>
			<?php echo "蓝框内IP是SSLVPN服务器地址，点击ACCEPT启用配置文件。";?><br/>
			</p>
			
			<p>
			<strong><?php echo "向导2：";?></strong><?php echo "输入用户名密码";?><br/>
			<img src="resources/img/help/024.png"><br/>	
			<?php echo "输入用户名和密码，点击Connect连接服务器，状态显示为”Connected”表示成功连接。";?><br/>
			</p>
			
			<p>
			<strong><?php echo "向导3：";?></strong><?php echo "断开连接";?><br/>
			<img src="resources/img/help/025.png"><br/>
			<div class="height"></div>
			<?php echo "点击Disconnect断开连接。";?><br/>
			</p>
			</div>
			
			<h5 id="h0023"style="float:none"><?php echo "2.3 故障排查";?></h5>
			<div style="border-top:1px dashed #ccc; padding:10px 0px;">
			<h6 id="h0231"><?php echo "2.3.1 无法识别client.ovpn文件：";?></h6>
			<p>
			<?php echo "将client.ovpn重命名为client.ovpn.txt。";?><br/>
			</p>
			</div>

			<div style="border-top:1px dashed #ccc; padding:10px 0px;">
			<h6 id="h0232"><?php echo "2.3.2 连接失败：";?></h6>
			<p>
			<?php echo "检查client.ovpn文件内服务器地址是否正确，网络环境是否畅通，用户名密码是否正确。";?><br/>		
			</p>
			</div>

			
			<div style="border-top:1px dashed #ccc; padding:10px 0px;">
			<h6 id="h0233"><?php echo "2.3.3 导入配置文件失败";?></h6>
			<p>
			<?php echo "在openvpn内点击右上角点状图标，在二级菜单内选择”import”，找到client.ovpn文件（通常在/sdcard/Tencent/QQfile_recv/目录下），点击文件即可导入";?><br/>	
			</p>
			</div>

			</div>


		<div  class="content-box-header">
			<h5 id="h0003"><?php echo "3. IOS系统如何使用SSLVPN";?></h5>
        
        </div>
        <div class="content-box-content">
			
			<h5 id="h0031" style="float:none"><?php echo "3.1 客户端安装";?></h5>
			<div style="border-top:1px dashed #ccc; padding:10px 0px; margin-bottom:10px">
			
			
			<p>
			<?php echo "搜索应用";?><br/>
			<img src="resources/img/help/026.png"><br/>
			<div class="height"></div>
			<?php echo "在App Store内搜索”openvpn connect”,安装如下图所示应用";?><br/>
			<div class="height"></div>
			<img src="resources/img/help/027.png"><br/>
			</p>
			</div>
			
			<h5 id="h0032" style="float:none"><?php echo "3.2 编辑配置文件并导入";?></h5>
			<div style="border-top:1px dashed #ccc; padding:10px 0px;">
			<h6 id="h0321"><?php echo "3.2.1 步骤1：编辑client.ovpn文件";?></h6>
			<p>
			<img src="resources/img/help/028.png"><br/>
			<div class="height"></div>
			<?php echo "将配置文件作为文本格式打开，找到42行 “remote 1.1.11.1 1194” 格式字段，将IP地址1.1.11.1 改为sslvpn服务器IP地址，保存退出。";?><br/>
			
			</p>
			</div>

			<div style="border-top:1px dashed #ccc; padding:10px 0px;">
			<h6 id="h0322"><?php echo "3.2.2 步骤2：传输配置文件";?></h6>
			<p>
			<img src="resources/img/help/029.png"><br/>
			<div class="height"></div>
			<?php echo "用QQ将client.ovpn传给苹果设备";?><br/>
			
			</p>
			</div>
			
			<div style="border-top:1px dashed #ccc; padding:10px 0px;">
			<h6 id="h0323"><?php echo "3.2.3 步骤3：导入配置文件";?></h6>
			<p>
			
			<img src="resources/img/help/030.png"><br/>
			<div class="height"></div>
			<?php echo "点击“拷贝至OpenVPN”";?><br/>
			</p>
			</div>
			
			<h5 id="h0033"style="float:none"><?php echo "3.3 运行客户端";?></h5>
			<div style="border-top:1px dashed #ccc; padding:10px 0px;">
			
			<p>
			<?php echo "在刚才导入成功后，出现下图所示界面：";?><br/>
			<strong><?php echo "向导1：";?></strong><?php echo "使用配置文件";?><br/>
			<img src="resources/img/help/031.png"><br/>
			<?php echo "点击绿色加号启用配置文件";?><br/>
			</p>
			

			<p>
			<strong><?php echo "向导2：";?></strong><?php echo "填写用户名密码";?><br/>
			<img src="resources/img/help/032.png"><br/>
			<?php echo "点击“connect”开启SSLVPN连接。";?><br/>
			</p>
			</div>

			<h5 id="h0034" style="float:none"><?php echo "3.4 故障排查";?></h5>
			<div style="border-top:1px dashed #ccc; padding:10px 0px;">
			<h6 id="h0341"><?php echo "3.4.1 App Store内找不到openvpn：";?></h6>
			<p>
			<?php echo "目前国区已下架openvpn应用，请使用国外Apple ID登录苹果设备获取openvpn[临时账号：us3@28baimi.com 密码：Aa002288]。";?><br/>
			</p>
			</div>

			<div style="border-top:1px dashed #ccc; padding:10px 0px;">
			<h6 id="h0342"><?php echo "3.4.2 连接失败：";?></h6>
			<p>
			<?php echo "检查client.ovpn文件内服务器地址是否正确，网络环境是否畅通，用户名密码是否正确。";?><br/>		
			</p>
			</div>
			

			</div>
			

		<div  class="content-box-header">
			<h5 id="h0004"><?php echo "4. Linux系统如何使用SSLVPN";?></h5>
        
        </div>
        <div class="content-box-content">
			
			<h5 id="h0041" style="float:none"><?php echo "4.1 客户端安装";?></h5>
			<div style="border-top:1px dashed #ccc; padding:10px 0px; margin-bottom:10px">
			<p>
			<?php echo "如果你是Ubuntu/Debian，使用如下命令安装客户端：";?><br/>
			<?php echo "# apt-get install openvpn";?><br/>
			<?php echo "如果提示缺少组件包，请对比以下依赖，安装缺失的依赖包。";?><br/>
			<?php echo "依赖: debconf";?><br/>
			<?php echo "依赖: <debconf-2.0>";?><br/>
			<?php echo "cdebconf";?><br/>
			<?php echo "debconf";?><br/>
			<?php echo "依赖: libc6";?><br/>
			<?php echo "依赖: liblzo2-2";?><br/>
			<?php echo "依赖: libpam0g";?><br/>
			<?php echo "依赖: libpkcs11-helper1";?><br/>
			<?php echo "依赖: libssl1.0.0";?><br/>
			<?php echo "依赖: net-tools";?><br/>
			<?php echo "依赖: initscripts";?><br/>
			<?php echo "推荐:openssl";?><br/>
			<?php echo "推荐:resolvconf";?><br/>
			<?php echo "openresolv";?><br/>
			<?php echo "#RedHat 请自行使用yum命令安装";?><br/>
			</p>
			</div>
			
			<h5 id="h0042" style="float:none"><?php echo "4.2 添加证书及配置文件";?></h5>
			<div style="border-top:1px dashed #ccc; padding:10px 0px;">
			<h6 id="h0421"><?php echo "4.2.1 添加证书及配置文件";?></h6>
			<p>
			<?php echo "将ca.crt、client.ovpn两个文件复制到/etc/openvpn/目录下，最后效果如下：";?><br/>
			<img src="resources/img/help/033.png"><br/>
			</p>
			</div>

			<div style="border-top:1px dashed #ccc; padding:10px 0px;">
			<h6 id="h0422"><?php echo "4.2.2 编辑配置文件";?></h6>
			<p>
			
			<?php echo "进入/etc/openvpn/目录，打开client.ovpn文件，找到42行 “remote 1.1.11.1 1194”字段，将IP地址1.1.11.1 改为sslvpn服务器IP地址，保存退出。";?><br/>
			
			</p>
			</div>
			
			<div style="border-top:1px dashed #ccc; padding:10px 0px;">
			<h6 id="h0423"><?php echo "4.2.3 拨号登录";?></h6>
			<p>
			<?php echo "在openvpn目录下使用openvpn命令后输入用户名、密码登录：";?><br/>
			<?php echo "#cd /etc/openvpn/";?><br/>
			<?php echo "#openvpn  client.ovpn";?><br/>
			<img src="resources/img/help/034.png"><br/>
			<div class="height"></div>
			<?php echo "出现如下图语句表示连接成功，使用Ctrl C快捷键断开VPN连接。如需后台运行，使用jobs命令来切换任务进程。";?><br/>
			<div class="height"></div>
			<img src="resources/img/help/035.png"><br/>
			</p>
			</div>
			
			<h5 id="h0043"style="float:none">4.3 故障排查<";?>/h5>
			<div style="border-top:1px dashed #ccc; padding:10px 0px;">
			<h6 id="h0431"><?php echo "4.3.1 “# apt-get install openvpn”命令安装失败：";?></h6>
			<p>
			<?php echo "更新你的apt命令，使用”apt-get update”。";?><br/>
			</p>
			</div>

			<div style="border-top:1px dashed #ccc; padding:10px 0px;">
			<h6 id="h0432"><?php echo "4.3.2 连接失败：";?></h6>
			<p>
			<?php echo "检查client.ovpn文件内服务器地址是否正确，网络环境是否畅通，用户名密码是否正确。";?><br/>		
			</p>
			</div>
			

			</div>





		</div>
			
			
	    </div>
	</div>
</div>

<?php } ?>


<?php  if(get_sapl_language() == "en"){?>
<div id="cn" class="help_doc">
	<div class="content-box">
      <!-- Start Content Box -->
      <div class="content-box-header">
        <h3>CONTENTS</h3>
        
      </div>
      <!-- End .content-box-header -->
      <div class="content-box-content">
			<div class="tab-content default-tab" id="tab1">
          <!-- This is the target div. id must match the href of this div's tab -->
				<ul>
				<li><a href="#h0001"><span class="li_s">1.	</span>	How WINDOWS System Uses SSLVPN </a></li>
				<li><a href="#h0011"><span class="li_s">1.1	</span>Download and Install Client</a></li>
				<li><a href="#h0111"><span class="li_s">1.1.1 </span>Step 1: Download Client</a>	</li>
				<li><a href="#h0112"><span class="li_s">1.1.2	</span>Step 2: Install Client</a>	</li>
				<li><a href="#h0113"><span class="li_s">1.1.3 </span>	Run Client</a>	</li>
				<li><a href="#h0012"><span class="li_s">1.2	</span>SSL VPN property set</a>	</li>
				<li><a href="#h0121"><span class="li_s">1.2.1 </span>Disconnect/Reconnection</a></li>
				<li><a href="#h0122"><span class="li_s">1.2.2 </span>Dispaly Status</a>	</li>
				<li><a href="#h0123"><span class="li_s">1.2.3	</span>View the Log</a></li>
				<li><a href="#h0124"><span class="li_s">1.2.4 </span>Modify the Password</a>	</li>
				<li><a href="#h0125"><span class="li_s">1.2.5	</span>System Set</a></li>

				<li><a href="#h0002"><span class="li_s">2.	</span>How Android System Uses SSLVPN	</a></li>
				<li><a href="#h0021"><span class="li_s">2.1	</span>	Download and Install Client	</a></li>
				<li><a href="#h0211"><span class="li_s">2.1.1 </span>Step 1: Download Client</a>	</li>
				<li><a href="#h0212"><span class="li_s">1.1.2	</span>Step 2: Install Client</a>	</li>
				<li><a href="#h0022"><span class="li_s">2.2	</span>Edit and Use Configuration File</a>	</li>
				<li><a href="#h0221"><span class="li_s">2.2.1 </span>Step 1: Edit Configuration File</a></li>
				<li><a href="#h0222"><span class="li_s">2.2.2 </span>	Step 2: Import Configuration File</a>	</li>
				<li><a href="#h0223"><span class="li_s">2.2.3	</span>Step 3: Use Configuration File</a></li>
				<li><a href="#h0023"><span class="li_s">2.3 </span>Troubleshooting</a>	</li>
				<li><a href="#h0231"><span class="li_s">2.3.1	</span>client.ovpn Cannot Be Identified</a></li>
				<li><a href="#h0232"><span class="li_s">2.3.2	</span>Connecting Failed</a></li>
				<li><a href="#h0233"><span class="li_s">2.3.3	</span>Importing Configuration File Failed</a></li>

				<li><a href="#h0003"><span class="li_s">3.	</span>How IOS System Uses SSLVPN</a></li>
				<li><a href="#h0031"><span class="li_s">3.1	</span>	Install Client</a></li>
				<li><a href="#h0032"><span class="li_s">3.2	</span>Edit and Import Configuration File</a>	</li>
				<li><a href="#h0321"><span class="li_s">3.2.1 </span>Step 1: Edit client.ovpn</a></li>
				<li><a href="#h0322"><span class="li_s">3.2.2 </span>Step 2: Transmit Configuration File</a>	</li>
				<li><a href="#h0323"><span class="li_s">3.2.3	</span>Step 3: Import Configuration File</a></li>
				<li><a href="#h0033"><span class="li_s">3.3 </span>	Run Client</a>	</li>
				<li><a href="#h0034"><span class="li_s">3.4	</span>Troubleshooting</a></li>
				<li><a href="#h0341"><span class="li_s">3.4.1	</span>openvpn Cannot Be Found in App Store</a></li>
				<li><a href="#h0342"><span class="li_s">3.4.2	</span>Connecting Failed</a></li>

				<li><a href="#h0004"><span class="li_s">4.	</span>How Linux System Uses SSLVPN</a></li>
				<li><a href="#h0041"><span class="li_s">4.1	</span>	Install Client</a></li>
				<li><a href="#h0042"><span class="li_s">4.2	</span>Add Certificate and Configuration File</a>	</li>
				<li><a href="#h0421"><span class="li_s">4.2.1 </span>Add Certificate and Configuration File</a></li>
				<li><a href="#h0422"><span class="li_s">4.2.2 </span>Edit Configuration File</a>	</li>
				<li><a href="#h0423"><span class="li_s">4.2.3	</span> Dialing Login</a></li>
				<li><a href="#h0043"><span class="li_s">4.3	</span>Troubleshooting</a></li>
				<li><a href="#h0431"><span class="li_s">4.3.1	</span>“# apt-get install openvpn” Failed</a></li>
				<li><a href="#h0432"><span class="li_s">4.3.2	</span>Connecting Failed</a></li>

				</ul>
			</div>
		</div>
	</div>

	<div class="content-box" style="margin-top:400px">
      <!-- Start Content Box -->
    
	    <div  class="content-box-header">
			<h5 id="h0001">1. How WINDOWS System Uses SSLVPN</h5>
        
        </div>
        <div class="content-box-content">
			
       
			<p>
			This section mainly introduce the installation and usage in SSL VPN client side。<br/>
			enviromental requirement<br/>
			1、The client computer has access to the Internet, and network communication is connected.<br/>
			2、Use major browsers：IE、Chrome、Opera<br/>
			3、If computer has install the assistant tools, may affect the normal use of SSL VPN, may unload first.<br/>
			According to the following steps to complete the SSL VPN client configuration in Windows 7 operating system.<br/>
			</p>
			
			<h5 id="h0011" style="float:none">1.1 Download and Install Client</h5>
			<div style="border-top:1px dashed #ccc; padding:10px 0px; margin-bottom:10px">
			<h6 id="h0111">1.1.1 Step 1: Download Client</h6>
			
			<p>
			Ensure that the user is connected to Internet, open the browser, input https://[sslvpn server IP]:8443, and display the following interface:<br/>
			<img src="resources/img/help/e001.png" style="width:72%;"><br/>
			<img src="resources/img/help/e002.png"><br/>
			Input the correct user name and password, and display the following interface, indicating that logging in succeeded. Display the following interface and download the desired SSL VPN client:<br/>
			<img src="resources/img/help/e003.png" style="width:72%;"><br/>
			</p>
			</div>
			
		
			<div style="border-top:1px dashed #ccc; padding:10px 0px;">
			<h6 id="h0112">1.1.2 Step 2: Install Client</h6>
			
			<p>
			After download and install the VPN Client, the corresponding procedures will be dind from the "start - > programs - > SSL VPN Client  ",a desktop shortcut can also be created during installing to create a desktop shortcut.<br/>
			<img src="resources/img/help/e004.png"><br/><br/>
			</p>
			</div>
			
			<div style="border-top:1px dashed #ccc; padding:10px 0px;">
			<h6 id="h0113">1.1.3 Run Client</h6>
			
			<p>
			Click this icon<img src="resources/img/help/e005.png">,the client configuration guide is appeared, the page is showed as below：<br/>
			<div class="height"></div>
			<strong>Wizard 1: </strong>Securety remind<br/>
			<img src="resources/img/help/e006.png"><br/>
			Please select [YES] in upper page,and then next page is popup as below：<br/>
			<div class="height"></div>

			<strong>Wizard 2: </strong>Account login<br/>
			<img src="resources/img/help/e007.png"><br/>
			<br/>
			<span class="li_m">SSL VPN address：</span>Input the SSL VPN server address due to the request<br/>
			<span class="li_m">User name: </span>Input own user name of SSL VPN due to the request<br/>
			<span class="li_m">Password: </span>Input correct password of SSL VPN due to the request<br/>
			<span class="li_m">Remermb: </span>Remermb the password<br/>
			<span class="li_m">Auto-Login: </span>Auto login in use last username and password<br/>
			<div class="height"></div>
			After input the username and password, click the login, and the sslvpn logo will appear on right corner of system after succeed.<br/>
			<img src="resources/img/help/e008.png"><br/>
			Now, login SSL VPN and visit SSL VPN intranet is compeleted.<br/>
			</p>
			</div>
			<h5 id="h0012"style="float:none">1.2 SSL VPN property set</h5>
			<div style="border-top:1px dashed #ccc; padding:10px 0px;">
			<h6 id="h0121">1.2.1 Disconnect/Reconnection</h6>
			<p>
			In the right mouse button click on the SSL VPN icon and popup the property interface, click the "Disconnect" can be the end of the SSL VPN access network resources disconnect after success will be in the lower right corner, system icon to display system.<br/>
			<img src="resources/img/help/e010.png"><br/>
			<div class="height"></div>
			<img src="resources/img/help/e011.png"><br/>
			</p>
			</div>
			
			<div style="border-top:1px dashed #ccc; padding:10px 0px;">
			<h6 id="h0122">1.2.2 Dispaly Status</h6>
			<p>
			Click on the SSL VPN icon on the right mouse button,the properties of the interface is popup,and click on the "display status"to enter the SSL VPN login page.<br/>
			<img src="resources/img/help/e012.png"><br/>
			</p>
			</div>
			
			<div style="border-top:1px dashed #ccc; padding:10px 0px;">
			<h6 id="h0123">1.2.3 View the Log</h6>
			<p>
			Click on the SSL VPN icon on the right mouse button,, then the properties of the interface is popup, and then click the message history , that can display the current SSL VPN client's history for details.<br/>
			<img src="resources/img/help/e013.png" style="width:75%;"><br/>
			</p>
			</div>
			
			<div style="border-top:1px dashed #ccc; padding:10px 0px;">
			<h6 id="h0124">1.2.4 Modify the Password</h6>
			<p>
			Open the browers, input https://[server address]:8443，dispaly the page as below:<br/>
			<img src="resources/img/help/e014.png" style="width:75%;"><br/>
			<div class="height"></div>
			At the upper page,please click continous browse this website, then the page will display as below:<br/>
			<img src="resources/img/help/e015.png"><br/>
			<div class="height"></div>
			After input the correct user name and password, login to modify the password page, which is able to modify the user password. the page is showed as blelow:<br/>
			<img src="resources/img/help/e016.png" style="width:75%;"><br/>
			<div class="height"></div>
			[note: after change the password, please login to the SSL VPN client]<br/>
			</p>
			</div>
			
			<div style="border-top:1px dashed #ccc; padding:10px 0px;">
			<h6 id="h0125">1.2.5 System Set</h6>
			<p>
			Click on the SSL VPN icon on the right mouse button, the property of the interface is popup, click "Settings", and show the following interface:<br/>
			<img src="resources/img/help/e017.png"><br/>
			SSL VPN address：server address configuration<br/>
			After login VPN page,and it does not display service page: hook the hidden automatically dialing interface<br/>
			Automatic login Settings: start the SSLVPN automatically after login.<br/>
			Boot automatically login: after hook, boot automatically log in the SSL VPN.<br/>
			</p> 
			</div>
			
			
	    </div>
	    <div  class="content-box-header">
			<h5 id="h0002"> 2. How Android System Uses SSLVPN</h5>
        
        </div>
        <div class="content-box-content">
			
			<h5 id="h0021" style="float:none">2.1 Download and Install Client</h5>
			<div style="border-top:1px dashed #ccc; padding:10px 0px; margin-bottom:10px">
			<h6 id="h0211">2.1.1 Step 1: Download Client</h6>
			
			<p>
			Ensure that the user is connected to Internet, open the browser, input https://[sslvpn server IP]:8443, and display the following interface:<br/>
			<img src="resources/img/help/e018.png" style="width:75%;"><br/>
			Input the correct user name and password, and display the following interface, indicating that logging in succeeded. Download the desired SSL VPN client:<br/>
			<img src="resources/img/help/e019.png" style="width:75%;"><br/>
			</p>
			</div>
			
		
			<div style="border-top:1px dashed #ccc; padding:10px 0px;">
			<h6 id="h0112">2.1.2 Step 2: Install Client</h6>
			<p>
			（Omit）</br>
			</p>
			</div>
			<h5 id="h0022"style="float:none">2.2 Edit and Use Configuration File</h5>
			<div style="border-top:1px dashed #ccc; padding:10px 0px;">
			<h6 id="h0221">2.2.1 Step 1: Edit Configuration File</h6>
			<p>
			
			<img src="resources/img/help/e020.png"><br/>
			Open the configuration file as the text format, find line 42 “remote 124.200.190.62 1194”, change the IP address 124.200.190.62  to the IP address of the sslvpn server, save and exit.<br/>
			</p>
			</div>
			
			<div style="border-top:1px dashed #ccc; padding:10px 0px;">
			<h6 id="h0222">2.2.2 Step 2: Import Configuration File</h6>
			<p>
			Transmit the CLIENT.OVPN file to the phone via QQ or WeChat.<br/>
			<img src="resources/img/help/e021.png"><br/>
			<div class="height"></div>
			Directly click the file, select “Use other applications to open”, and automatically import to the VPN application.<br/>
			<img src="resources/img/help/e022.png"><br/>
			<div class="height"></div>
			</p>
			</div>
			
			<div style="border-top:1px dashed #ccc; padding:10px 0px;">
			<h6 id="h0223">2.2.3 Step 3: Use Configuration File</h6>
			<p>
			<strong>Wizard 1: </strong>Enable the configuration file<br/>
			<img src="resources/img/help/e023.png"><br/>
			The IP in the blue box is the address of the SSLVPN server, click ACCEPT to enable the configuration file.<br/>
			</p>
			
			<p>
			<strong>Wizard 2:</strong>Input the user name and password.<br/>
			<img src="resources/img/help/e024.png" style="width:51%;"><br/>	
			Input the user name and password, click Connect to connect the server, and the status is displayed as “Connected”, showing connecting successfully.<br/>
			</p>
			
			<p>
			<strong>Wizard 3: </strong>Disconnect<br/>
			<img src="resources/img/help/e025.png" style="width:51%;"><br/>
			<div class="height"></div>
			Click Disconnect.<br/>
			</p>
			</div>
			
			<h5 id="h0023"style="float:none">2.3 Troubleshooting</h5>
			<div style="border-top:1px dashed #ccc; padding:10px 0px;">
			<h6 id="h0231">2.3.1 client.ovpn Cannot Be Identified</h6>
			<p>
			Re-name client.ovpn as client.ovpn.txt.<br/>
			</p>
			</div>

			<div style="border-top:1px dashed #ccc; padding:10px 0px;">
			<h6 id="h0232">2.3.2 Connecting Failed</h6>
			<p>
			Check whether the server address in the client.ovpn file is connect, whether the network is connected, and whether the user name and password are correct.<br/>		
			</p>
			</div>

			
			<div style="border-top:1px dashed #ccc; padding:10px 0px;">
			<h6 id="h0233">2.3.3 Importing Configuration File Failed</h6>
			<p>
			In openvpn, click the dot icon at the top right corner, select “Import” in the second menu, find the client.ovpn file (in the directory of /sdcard/Tencent/QQfile_recv/), and click the file to import.<br/>	
			</p>
			</div>

			</div>


		<div  class="content-box-header">
			<h5 id="h0003">3. How IOS System Uses SSLVPN</h5>
        
        </div>
        <div class="content-box-content">
			
			<h5 id="h0031" style="float:none">3.1 Install Client</h5>
			<div style="border-top:1px dashed #ccc; padding:10px 0px; margin-bottom:10px">
			
			
			<p>
			Search for the application<br/>
			<img src="resources/img/help/e026.png"><br/>
			<div class="height"></div>
			In App Store, search for openvpn connect, and install the following application:<br/>
			<div class="height"></div>
			<img src="resources/img/help/e027.png" style="width:42%;"><br/>
			</p>
			</div>
			
			<h5 id="h0032" style="float:none">3.2 Edit and Import Configuration File</h5>
			<div style="border-top:1px dashed #ccc; padding:10px 0px;">
			<h6 id="h0321">3.2.1 Step 1: Edit client.ovpn</h6>
			<p>
			<img src="resources/img/help/e028.png"><br/>
			<div class="height"></div>
			Open the configuration file as the text format, find line 42 “remote 124.200.190.62 1194”, change the IP address 124.200.190.62  to the IP address of the sslvpn server, save and exit.<br/>
			
			</p>
			</div>

			<div style="border-top:1px dashed #ccc; padding:10px 0px;">
			<h6 id="h0322">3.2.2 Step 2: Transmit Configuration File</h6>
			<p>
			<img src="resources/img/help/e029.png"><br/>
			<div class="height"></div>
			Use QQ to transmit client.ovpn to the Apple devices.<br/>
			
			</p>
			</div>
			
			<div style="border-top:1px dashed #ccc; padding:10px 0px;">
			<h6 id="h0323">3.2.3 Step 3: Import Configuration File</h6>
			<p>
			
			<img src="resources/img/help/e030.png" style="width:54%;"><br/>
			<div class="height"></div>
			Click “Copy to OpenVPN”<br/>
			</p>
			</div>
			
			<h5 id="h0033"style="float:none">3.3 Run Client</h5>
			<div style="border-top:1px dashed #ccc; padding:10px 0px;">
			
			<p>
			After importing successfully, display the following interface:<br/>
			<strong>Wizard 1: </strong>Use the configuration file<br/>
			<img src="resources/img/help/e031.png"><br/>
			Click the green plus to enable the configuration file.<br/>
			</p>
			

			<p>
			<strong>Wizard 2: </strong>Fill in the user name and password.<br/>
			<img src="resources/img/help/e032.png"><br/>
			Click “connect” to enable the SSLVPN connection.<br/>
			</p>
			</div>

			<h5 id="h0034" style="float:none">3.4 Troubleshooting</h5>
			<div style="border-top:1px dashed #ccc; padding:10px 0px;">
			<h6 id="h0341">3.4.1 openvpn Cannot Be Found in App Store</h6>
			<p>
			At present, openvpn has been removed from the market in China. Please use the foreign Apple ID to log into the Apple device to get openvpn.
(The temporary account: us3@28baimi.com, password: Aa002288)<br/>
			</p>
			</div>

			<div style="border-top:1px dashed #ccc; padding:10px 0px;">
			<h6 id="h0342">3.4.2 Connecting Failed</h6>
			<p>
			Check whether the server address in the client.ovpn file is connect, whether the network is connected, and whether the user name and password are correct.<br/>		
			</p>
			</div>
			

			</div>
			

		<div  class="content-box-header">
			<h5 id="h0004">4. How Linux System Uses SSLVPN</h5>
        
        </div>
        <div class="content-box-content">
			
			<h5 id="h0041" style="float:none">4.1 Install Client</h5>
			<div style="border-top:1px dashed #ccc; padding:10px 0px; margin-bottom:10px">
			<p>
			If you are Ubuntu/Debian, use the following command to install the client:<br/>
			# apt-get install openvpn<br/>
			If the system prompts that the component packet is missing, compare the following rely-on, and install the missing rely-on packages.<br/>
			Rely on: debconf<br/>
			Rely on: <debconf-2.0><br/>
			cdebconf<br/>
			debconf<br/>
			Rely on:  libc6<br/>
			Rely on: liblzo2-2<br/>
			Rely on: libpam0g<br/>
			Rely on: libpkcs11-helper1<br/>
			Rely on: libssl1.0.0<br/>
			Rely on: net-tools<br/>
			Rely on: initscripts<br/>
			Recommend: openssl<br/>
			Recommend: resolvconf<br/>
			openresolv<br/>
			#RedHat Please use the yum command to install by yourself.<br/>
			</p>
			</div>
			
			<h5 id="h0042" style="float:none">4.2 Add Certificate and Configuration File</h5>
			<div style="border-top:1px dashed #ccc; padding:10px 0px;">
			<h6 id="h0421">4.2.1 Add Certificate and Configuration File</h6>
			<p>
			Copy the two files ca.crt, client.ovpn to /etc/openvpn/, and the last effect is as follows:<br/>
			<img src="resources/img/help/e033.png"><br/>
			</p>
			</div>

			<div style="border-top:1px dashed #ccc; padding:10px 0px;">
			<h6 id="h0422">4.2.2 Edit Configuration File</h6>
			<p>
			Enter the directory /etc/openvpn/, open the file client.ovpn, find line 42 “remote 1.1.11.1 1194”, change the IP address 1.1.11.1 to the IP address of the sslvpn server, save and exit.<br/>
			
			</p>
			</div>
			
			<div style="border-top:1px dashed #ccc; padding:10px 0px;">
			<h6 id="h0423">4.2.3 Dialing Login</h6>
			<p>
			After using the command openvpn in the directory openvpn, input the user name and password to log in:<br/>
			#cd /etc/openvpn/<br/>
			#openvpn  client.ovpn<br/>
			<img src="resources/img/help/e034.png"><br/>
			<div class="height"></div>
			If the following sentences are displayed, indicate that connecting succeeded. Use the shortcut key Ctrl C to disconnect VPN. If it is necessary to run at the background, use the jobs command to switch the task process.<br/>
			<div class="height"></div>
			<img src="resources/img/help/e035.png"><br/>
			</p>
			</div>
			
			<h5 id="h0043"style="float:none">4.3 Troubleshooting</h5>
			<div style="border-top:1px dashed #ccc; padding:10px 0px;">
			<h6 id="h0431">4.3.1 “# apt-get install openvpn” Failed</h6>
			<p>
			Use ”apt-get update” to update your apt command.<br/>
			</p>
			</div>

			<div style="border-top:1px dashed #ccc; padding:10px 0px;">
			<h6 id="h0432">4.3.2 Connecting Failed</h6>
			<p>
			Check whether the server address in the client.ovpn file is connect, whether the network is connected, and whether the user name and password are correct.<br/>		
			</p>
			</div>
			

			</div>





		</div>
			
			
	    </div>
	</div>
</div>

<?php } ?>

	</body>
</html>
