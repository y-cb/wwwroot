function getStringByteLength(value) {
	var totalLen = 0;
	var charCode;
	for (var i = 0; i < value.length ; i++) {
		charCode = value.charCodeAt(i);
		if (charCode <= 0x007f) {
			totalLen += 1;
		} else if (0x0080 <= charCode && charCode <= 0x07ff) {
			totalLen += 2;
		} else if (0x0800 <= charCode && charCode <= 0xffff) {
			totalLen += 3;
		}
	}
	return totalLen;
}
//写cookie方法
function setCookie(name, cookie, day) {
	var exp  = new Date();
	if (! day)
		day = 30;
	exp.setTime(exp.getTime() + day*86400000);
	document.cookie = name + '=' + escape(cookie) + ";path=/;expires=" + exp.toGMTString();
}
//获取cookie方法
function getCookie(name) {
	var arr = document.cookie.match(new RegExp("(^| )"+name+"=([^;]*)(;|$)"));
    if(arr != null) 
    	return unescape(arr[2]); 
    return null;
}
function is_mobile(){
	var is_mobi = navigator.userAgent.toLowerCase().match(/(ipod|iphone|android|coolpad|mmp|smartphone|midp|wap|xoom|symbian|j2me|blackberry|win ce)/i) != null;
	return is_mobi;
}
function time_To_hhmmss(seconds) {
	var hh, mm, ss;
	//传入的时间为空或小于0
	if (seconds == null || seconds < 0) {
		return;
	}
	//得到小时
	hh = seconds / 3600 | 0;
	var tmp_seconds = parseInt(seconds) - hh * 3600;
	//得到分
	mm = tmp_seconds / 60 | 0;
	//得到秒
	ss = parseInt(tmp_seconds) - mm * 60;
	if(seconds>=3600){
		return hh + "h" + mm + "m" + ss + "s";
	}else if(seconds<3600 && seconds>=60){
		return mm + "m" + ss + "s";
	}else{
		return ((ss == 0) ? 1 : ss) + "s"
	}
	/*if (mm <= 0) return ((ss == 0) ? 1 : ss) + "s"
	else if (mm > 0 && hh <= 0) return mm + "m" + ss + "s";
	else return hh + "h" + mm + "m" + ss + "s";*/
}
function getLocalTime(nS) {     
	  var now = new Date(parseInt(nS) * 1000);
	  var year=now.getFullYear();     
	  var month=now.getMonth()+1;     
	  var date=now.getDate();     
	  var hour=now.getHours();     
	  var minute=now.getMinutes();     
	  var second=now.getSeconds();
	  return year+"-"+month+"-"+date+"   "+hour+":"+minute+":"+second;  
}
function cookie_login_out(){
	setCookie('logincookie','');
}
function getCookieData(){
	var vc = getCookie('logincookie'),jsonobj = '';
	if(vc){
		jsonobj = eval('(' + vc + ')');
	}
	return jsonobj;
}
function get_weburl(){
	var href = location.href;
	var inx = href.indexOf('?weburl='),weburl = '';
	if(inx > 0)
		weburl = href.substr(inx + 8);
	return weburl;
}
function get_param() {
	var arr = {};
	var tmp = window.location.search.substring(1);
	var vars = tmp.split('&');
	if (tmp.length !=0 && vars.length != 0) {
		for (var i = 0; i < vars.length; i++) {
			var pair = vars[i].split('=');
			arr[pair[0]] = pair[1];
		}
	}

	return arr;
}