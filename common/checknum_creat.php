<?
/**
 * 判断是用户登录还是认证登录，分别生成不同的校验码。用session来做验证;注册session
 */

$module = $_GET['module'];
unset($_SESSION[$module]);
Header("Content-type:image/png");

//session_start();			//开启session;  
$authnum_session = '';
$str = 'abcdefghijkmnpqrstuvwxyz1234567890';		//定义用来显示在图片上的数字和字母;

$l = strlen($str); 

/**循环随机抽取四位前面定义的字母和数字;每次随机抽取一位数字;从第一个字到该字串最大长度,减1是因为截取字符是从0开始起算;这样34字符任意都有可能排在其中;将通过数字得来的字符连起来一共是四位
 **/
if (isset($_SESSION[$module])) {
	$authnum_session = $_SESSION[$module];
} else {
	for($i = 1; $i <= 4; $i++) {
		$num = rand(0, $l - 1);
		$authnum_session.= $str[$num];
	}
	//session_register($module);
	$_SESSION[$module] = $authnum_session;
}

//生成验证码图片
//srand((double)microtime()*1000000);
$im = imagecreate(50,25);		//图片宽与高;

//主要用到三种色;
$bg = ImageColorAllocate($im, 0x88, 0x88, 0x88);    //背景色
$white = ImageColorAllocate($im, 255,255,255);
$gray = ImageColorAllocate($im, 0x86,0xCF,0xFA);   //干扰色

//将四位整数验证码绘入图片
imagefill($im,68,30,$gray);

//加入3条干扰线;也可以不要;视情况而定，因为可能影响用户输入;
/*$li = ImageColorAllocate($im, 0x86,0xCF,0xFA);
for($i = 0; $i < 3;$i++) {
	imageline($im,rand(0,30),rand(0,21),rand(20,40),rand(0,21),$li);
}*/

//字符在图片的位置;
imagestring($im, 5, 8, 5, $authnum_session, $white);

for ($i = 0; $i < 90; $i++) {		//加入干扰象素
	imagesetpixel($im, rand()%70 , rand()%30 , $gray);
}

ob_get_clean();
ImagePNG($im);
ImageDestroy($im);
?> 