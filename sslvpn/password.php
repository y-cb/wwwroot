<?php
require_once '../common/config.inc';
require_once '../common/common.inc'; 
require_once 'sslvpn_lang.php';
$DEMO_DATA = 0;
if($_POST['submit']=='modpwd'){
		$usr = $_POST['username'];
		$newpwd = $_POST['newpassword']; 
		$oldpwd = $_POST['oldpassword'];
		$error_msg = '';
		if (isset($usr, $newpwd, $oldpwd)) {
			$param[username] = $usr;
			$param[newpassword] = $newpwd;
			$param[oldpassword] = $oldpwd;
			$rspString = getResponse( "webauthchgpassword", "mod" , $param );
			$result = getAssign($rspString, "webauthchgpassword");	
			if($result[str]){
				$error_msg = $result[str];
				echo $error_msg;
				return;
			}else{
				echo "1";
				return;
			};	
		};
};
				
?>

<?php require_once("head.php")  ?>
<script>
function form_submit(){
	var ostr = $("#password_cid").val();
		nstr = $("#newpasswd_cid").val();
	    rstr = $("#repasswd_cid").val();
	    /*$notice = $(".input-notification ");
	    $error =  $(".error" );
		$success = $(".success" );
	    $notice.css("display","inline-block").removeClass("error","success");*/
		if(!!ostr == false || !!nstr == false || !!rstr == false  ){
				alert("<?php echo getCommonResource('sslvpn.cant.empty');?>");
				//$notice.addClass("error")
				//$error.html("<?php echo getCommonResource('sslvpn.cant.empty');?>")
				return false;
		}
		if(nstr != rstr ){
			alert("<?php echo getCommonResource('sslvpn_error.pwdnosame');?>");
			//$notice.addClass("error")
			//$error.html("<?php echo getCommonResource('sslvpn_error.pwdnosame');?>")
			return false;				
		}
		if (nstr.length < 6 || nstr.length > 31) {
			alert("<?php echo getCommonResource('sslvpn.length.pass');?>");
			//$notice.addClass("error")
			//$error.html("<?php echo getCommonResource('sslvpn.length.pass');?>")
			return false;				
		}
		if (!/^[\u4e00-\u9faf\uFE30-\uFFA0a-zA-Z0-9@。._\-\|\(\)\[\]]*$/.test(rstr)) {
				alert("The password does not conform to the rules, allowing only the input alphanumeric characters and @ ._- () []");
				//$notice.addClass("error")
				//$error.html("The password does not conform to the rules, allowing only the input alphanumeric characters and @ ._- () []")
				return false;
		}	
	
	$.ajax({
				url : '/password.php',
				type : 'POST',
				data : 'username=<?php print $_COOKIE["user"] ?>&newpassword='+ nstr +'&oldpassword='+ ostr +'&submit=modpwd',
				async : false,
				timeout : 30000,
				success : function(data) {
					if (data == "1") {
						/*$notice.addClass("success");
						$notice.html("<?php echo getCommonResource('sslvpn_changepwd_sucess');?>")*/
						alert("<?php echo getCommonResource('sslvpn_changepwd_sucess');?>");
						$("#password_cid").val("") ;
						$("#newpasswd_cid").val("");
						$("#repasswd_cid").val("") ;
						return ;					
					} else {
						alert(data);
						/*$notice.addClass("error")
						$notice.html(data)*/
						return false;		
					}
				}
			});
	
};
</script>

	<body style="background: transparent;">
	<div class="" >
    <p id="page-intro"><?php echo getCommonResource('sslvpn_changepsd');?></p>
    	<div class="content-box column-center"  style="width: 50%; ">
      	<!-- Start Content Box -->
	      <div class="content-box-header" style="height: 30px; ">  </div>
	      <!-- End .content-box-header -->
	     	 <div class="content-box-content">
	   		<div class="tab-content" id="tab2">
		          <form action="#" method="post">
		            <fieldset>
		            <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
		            <p>
		              <label><?php echo getCommonResource('sslvpn_old_password');?></label>
		              <input class="text-input " type="password" id="password_cid" name="small-input" />
		              <br />
		               </p>
		            <p>
		              <label><?php echo getCommonResource('sslvpn_new_password');?></label>
		              <input class="text-input " type="password" id="newpasswd_cid" name="small-input"/>  
					  <?php echo getCommonResource('sslvpn_tip_user_pass');?>
		              <br />
		               </p>
		            <p>
		              <label><?php echo getCommonResource('sslvpn_confirm_newpsd');?></label>
		              <input class="text-input " type="password" id="repasswd_cid" name="small-input"/>   
		              <!-- Classes for input-notification: success, error, information, attention -->
					  <?php echo getCommonResource('sslvpn_tip_user_pass');?>
		              <br />
		              </p>
		            
		            <p>
		              <input class="button" type="button" style="margin-left: 105px;" value="<?php echo getCommonResource('sslvpn_submit');?>" onclick="form_submit()" />
		              <span class="input-notification error png_bg" style="display: none;">Error message</span>
		            </p>
		            </fieldset>
		            <div class="clear"></div>
		            <!-- End .clear -->
		          </form>
	        	</div>
	    	</div>
	    </div>  
  </div>
	</body>
</html>
