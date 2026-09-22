function isCharIn(str, valid) {
	var str = str.trim();
	for(var i = 0; i < str.length; i += 1) {
		for (var j = 0; j < valid.length; j += 1) {
			if (str.charAt(i) == valid.charAt(j)) {
				return true
			}
		}
	}
	return false;
}
function form_submit(){
	var ostr = $("#password_cid").val(),
		nstr = $("#newpasswd_cid").val(),
	    rstr = $("#repasswd_cid").val();
	    $notice = $(".input-notification ")
	    $error =  $(".error" )
	    $notice.css("display","inline-block").removeClass("error","success")
	if(!!ostr == false || !!nstr == false || !!rstr == false  ){
				$notice.addClass("error")
				$error.html("密码不能为空")
				return false;
			}
	if(nstr != rstr ){
				$notice.addClass("error")
				$error.html("两次密码输入不一致")
				return false;				
			}
	var result = (isCharIn(rstr, '0123456789') && isCharIn(rstr, 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ') && isCharIn(rstr, '!@#$%&`,-.'));
	if (!result) {
				$notice.addClass("error")
				$error.html("密码不符合规则")
				return false;
			}	
	$notice.addClass("success")
	$(".success").html("密码修改成功")
	
};