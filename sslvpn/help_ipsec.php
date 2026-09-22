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

				<li><a href="#h0001"><span class="li_s">1.	</span><?php echo "IOS系统如何使用IPSEC VPN";?></a></li>
				<li><a href="#h0011"><span class="li_s">1.1	</span><?php echo "客户端安装";?>	</a></li>
				<li><a href="#h0012"><span class="li_s">1.2	</span><?php echo "运行客户端";?></a>	</li>
				<li><a href="#h0121"><span class="li_s">1.2.1 </span><?php echo "配置服务器网址、端口、填写预共享密钥、填写账号密码";?></a></li>
				<li><a href="#h0122"><span class="li_s">1.2.2 </span><?php echo "输入动态口令";?></a>	</li>
				<li><a href="#h1221"><span class="li_s">1.2.2.1	</span><?php echo "获取登录口令两种方式";?></a></li>
				<li><a href="#h0123"><span class="li_s">1.2.3	</span><?php echo "登录过程";?></a></li>
				<li><a href="#h0013"><span class="li_s">1.3 </span><?php echo "信息修改页";?></a>	</li>
				<li><a href="#h0014"><span class="li_s">1.4	</span><?php echo "常见问题";?></a></li>

				</ul>
			</div>
		</div>
	</div>

	<div class="content-box" style="margin-top:400px">
      <!-- Start Content Box -->

		<div  class="content-box-header">
			<h5 id="h0003"><?php echo "1. IOS系统如何使用IPSEC VPN";?></h5>
        
        </div>
        <div class="content-box-content">
			
			<h5 id="h0011" style="float:none"><?php echo "1.1 客户端安装";?></h5>
			<div style="border-top:1px dashed #ccc; padding:10px 0px; margin-bottom:10px">
			<p>
			<div class="height"></div>
			<?php echo "搜索应用,在App Store内搜索”Uconnect”,安装如下图所示应用";?><br/>
			<div class="height"></div>
			<img src="resources/img/help_ipsec/01.png"><br/>
			</p>
			</div>
			
			<h5 id="h0012" style="float:none"><?php echo "1.2 运行客户端";?></h5>
			<div style="border-top:1px dashed #ccc; padding:10px 0px;">
			<h6 id="h0121"><?php echo "1.2.1 配置服务器网址、端口、填写预共享密钥、填写账号密码";?></h6>
			<p>
			<?php echo "在登录页面，填写用户认证信息";?><br/>
			<img src="resources/img/help_ipsec/02.png"><br/>
			</p>
			</div>

			<div style="border-top:1px dashed #ccc; padding:10px 0px;">
			<h6 id="h0122"><?php echo "1.2.2 输入动态口令";?></h6>
			<p>
			<?php echo "服务端若开启动态口令配置，则客户端需录入动态口令进行二次校验";?><br/>
			<img src="resources/img/help_ipsec/03.png"><br/>
			</p>
			</div>

			<div style="border-top:1px dashed #ccc; padding:10px 0px;">
			<h6 id="h1221"><?php echo "1.2.2.1 获取登录口令两种方式";?></h6>
			<p>
			<?php echo "1、移动端下载freeotp或者Authenticator进行登录";?><br/>
			<img src="resources/img/help_ipsec/04.png"><br/>
			</p>
			<p>
			<?php echo "2、用户登录方式有两种：";?><br/>
			<?php echo "①第一种方式：二维码扫描：";?><br/>
			<?php echo "打开freeotp或者谷歌app扫描管理员提供的二维码";?><br/>
			<img src="resources/img/help_ipsec/05.png"><br/>
			<?php echo "②第二种方式：录入账号和密钥：";?><br/>
			<?php echo "使用管理员提供的用户名和对应密钥";?><br/>
			<img src="resources/img/help_ipsec/06.png"><br/>
			<img src="resources/img/help_ipsec/07.png"><br/>
			</p>
			</div>

			<h6 id="h0123"><?php echo "1.2.3 登录过程";?></h6>
			<div style="border-top:1px dashed #ccc; padding:10px 0px;">
			<p>
			<?php echo "点击允许添加VPN配置";?><br/>
			<img src="resources/img/help_ipsec/08.png"><br/>
			<?php echo "由于ios系统原因，需要再次输入密码（用户名字段已默认无需输入）";?><br/>
			<img src="resources/img/help_ipsec/09.png"><br/>
			<?php echo "1)点击登录后，客户端会将用户认证信息发送至服务端进行校验，校验通过后，方可进入连接成功页面。";?><br/>
			<?php echo "2)连接成功页面中可查看连接信息，包括连接时长、已用流量、上下行流速等。";?><br/>
			<img src="resources/img/help_ipsec/10.png"><br/>
			</p>
			</div>

			<h5 id="h0013" style="float:none"><?php echo "1.3 信息修改页";?></h5>
			<div style="border-top:1px dashed #ccc; padding:10px 0px;">
			<p>
			<?php echo "点击左上角设置图标，进入设置页面，可修改服务器地址，自动连接开关等";?><br/>
			<img src="resources/img/help_ipsec/11.png"><br/>
			</p>
			</div>

			<h5 id="h0014" style="float:none"><?php echo "1.4 常见问题";?></h5>
			<div style="border-top:1px dashed #ccc; padding:10px 0px;">
			<p>
			<?php echo "若动态口令校验失败时，可尝试同步手机时间，手机端设置路径：通用--日期与时间，开启自动设置后再尝试登录";?><br/>		
			</p>
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
				<li><a href="#h0001"><span class="li_s">1.	</span><?php echo "How IOS System Uses IPSEC VPN";?></a></li>
				<li><a href="#h0011"><span class="li_s">1.1	</span><?php echo "Install Client";?>	</a></li>
				<li><a href="#h0012"><span class="li_s">1.2	</span><?php echo "Run Client";?></a>	</li>
				<li><a href="#h0121"><span class="li_s">1.2.1 </span><?php echo "Configure the server url, port,fill in the pre-shared key,fill in the account password";?></a></li>
				<li><a href="#h0122"><span class="li_s">1.2.2 </span><?php echo "Enter Dynamic Dassword";?></a>	</li>
				<li><a href="#h1221"><span class="li_s">1.2.2.1	</span><?php echo "Two Ways To Get Login Password";?></a></li>
				<li><a href="#h0123"><span class="li_s">1.2.3	</span><?php echo "Login Process";?></a></li>
				<li><a href="#h0013"><span class="li_s">1.3 </span><?php echo "Information Modification Page";?></a>	</li>
				<li><a href="#h0014"><span class="li_s">1.4	</span><?php echo "Q&A";?></a></li>
				</ul>
			</div>
		</div>
	</div>

	<div class="content-box" style="margin-top:400px">
      <!-- Start Content Box -->

		<div  class="content-box-header">
			<h5 id="h0003"><?php echo "1. How IOS System Uses IPSEC VPN";?></h5>
        
        </div>
        <div class="content-box-content">
			
			<h5 id="h0011" style="float:none"><?php echo "1.1 Install Client";?></h5>
			<div style="border-top:1px dashed #ccc; padding:10px 0px; margin-bottom:10px">
			<p>
			<div class="height"></div>
			<?php echo "In App Store, search for Uconnect, and install the following application:";?><br/>
			<div class="height"></div>
			<img src="resources/img/help_ipsec/01.png"><br/>
			</p>
			</div>
			
			<h5 id="h0012" style="float:none"><?php echo "1.2 Run Client";?></h5>
			<div style="border-top:1px dashed #ccc; padding:10px 0px;">
			<h6 id="h0121"><?php echo "1.2.1 Configure the server url, port,fill in the pre-shared key,fill in the account password";?></h6>
			<p>
			<?php echo "On the login page, fill in the user authentication information";?><br/>
			<img src="resources/img/help_ipsec/02.png"><br/>
			</p>
			</div>

			<div style="border-top:1px dashed #ccc; padding:10px 0px;">
			<h6 id="h0122"><?php echo "1.2.2 Enter Dynamic Dassword";?></h6>
			<p>
			<?php echo "If the server turns on the dynamic password configuration, the client needs to enter the dynamic password for secondary verification";?><br/>
			<img src="resources/img/help_ipsec/03.png"><br/>
			</p>
			</div>

			<div style="border-top:1px dashed #ccc; padding:10px 0px;">
			<h6 id="h1221"><?php echo "1.2.2.1 Two Ways To Get Login Password";?></h6>
			<p>
			<?php echo "1、The mobile side downloads Freeotp or Authenticator for login";?><br/>
			<img src="resources/img/help_ipsec/04.png"><br/>
			</p>
			<p>
			<?php echo "2、There are two ways for users to log in：";?><br/>
			<?php echo "①The first way: Qr code scanning：";?><br/>
			<?php echo "Open freeotp or Google app to scan the Qr code provided by the administrator";?><br/>
			<img src="resources/img/help_ipsec/05.png"><br/>
			<?php echo "②The second way: Enter the account number and key：";?><br/>
			<?php echo "Use the user name and corresponding key provided by the administrator";?><br/>
			<img src="resources/img/help_ipsec/06.png"><br/>
			<img src="resources/img/help_ipsec/07.png"><br/>
			</p>
			</div>

			<h6 id="h0123"><?php echo "1.2.3 Login Process";?></h6>
			<div style="border-top:1px dashed #ccc; padding:10px 0px;">
			<p>
			<?php echo "Click Allow to add VPN configuration";?><br/>
			<img src="resources/img/help_ipsec/08.png"><br/>
			<?php echo "Due to the ios system, the password needs to be entered again (the user name field has been defaulted without input)";?><br/>
			<img src="resources/img/help_ipsec/09.png"><br/>
			<?php echo "1)After clicking login, the client will send the user authentication information to the server for verification. Only after the verification is passed, can you enter the successful connection page.";?><br/>
			<?php echo "2)The connection information can be viewed in the successful connection page, including connection duration, used flow rate, upstream and downstream flow rate, etc.";?><br/>
			<img src="resources/img/help_ipsec/10.png"><br/>
			</p>
			</div>

			<h5 id="h0013" style="float:none"><?php echo "1.3 Information Modification Page";?></h5>
			<div style="border-top:1px dashed #ccc; padding:10px 0px;">
			<p>
			<?php echo "Click the Settings icon in the upper left corner to enter the Settings page. The server address can be modified, and the automatic connection switch can be changed.";?><br/>
			<img src="resources/img/help_ipsec/11.png"><br/>
			</p>
			</div>

			<h5 id="h0014" style="float:none"><?php echo "1.4 常见问题";?></h5>
			<div style="border-top:1px dashed #ccc; padding:10px 0px;">
			<p>
			<?php echo "If the dynamic password verification fails, you can try to synchronize the mobile phone time. Set the path on the mobile phone: universal -- date and time. Turn on the automatic setting and then try to log in.";?><br/>		
			</p>
			</div>
			

		</div>
			
	</div>
</div>

<?php } ?>

	</body>
</html>
