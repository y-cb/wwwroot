<?php
namespace controller\login;

class CaptchaController {
	function get(){
		//$module = $_GET['module'];
		$module = 'config_authnum';
		unset($_SESSION[$module]);
		unset($_SESSION['randomkey']);
		header("content-type:text/html;charset=utf-8");

		//session_start();			//开启session;  
		$authnum_session = '';
		$randomkey_session = '';
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

		//生成加密随机数
		$randomkey_session = self::randomkeys(16);
		$_SESSION['randomkey'] = $randomkey_session;
		//生成验证码图片
		//srand((double)microtime()*1000000);
		$im = imagecreate(70,20);		//图片宽与高;

		//主要用到三种色;
		$bg = ImageColorAllocate($im, 230, 230, 230);    //背景色
		$white = ImageColorAllocate($im, 0,0,0);
		$gray = ImageColorAllocate($im, 0x86,0xCF,0xFA);   //干扰色

		//将四位整数验证码绘入图片
		imagefill($im,60,30,$gray);

		//加入3条干扰线;也可以不要;视情况而定，因为可能影响用户输入;
		/*$li = ImageColorAllocate($im, 0x86,0xCF,0xFA);
		for($i = 0; $i < 3;$i++) {
			imageline($im,rand(0,30),rand(0,21),rand(20,40),rand(0,21),$li);
		}*/

		//字符在图片的位置;
		imagestring($im, 5, 20, 2, $authnum_session, $white);

		for ($i = 0; $i < 90; $i++) {		//加入干扰象素
			imagesetpixel($im, rand()%70 , rand()%30 , $gray);
		}

		ImagePNG($im);
		$buffer = ob_get_clean();
		ob_end_clean();

    	session_start();
		$_SESSION[CONFIG_CHECKNUM]=$authnum_session;
		$_SESSION[RANDOMKEY]=$randomkey_session;
		$data = base64_encode($buffer);
    	$token = session_id();
    	/*if (file_exists('/etc/sys_lang')) {
    		$has_lang = 1;
    	}else{
    		$has_lang = 0;
    	}*/
    	//echo json_encode(array(data => $data, token => $token,randomkey=>$randomkey_session));
		echo json_encode(array(data => $data,randomkey=>$randomkey_session));
		ImageDestroy($im);
	}
	function randomkeys($length){   
	   $pattern = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLOMNOPQRSTUVWXYZ';  
	    for($i=0;$i<$length;$i++)   
	    {   
	        $key .= $pattern{mt_rand(0,35)};
	    }   
	    return $key;   
	}
}
