<?php
class CaptchaTool{
    function generareCaptcha(){
		//从本地图片中生成画布
	   $rand_bg_file = TOOL_DIR . "captcha/captcha_bg" . mt_rand(1,5).".jpg";
	   $image = imagecreatefromjpeg($rand_bg_file);
	   $white = imagecolorallocate($image,255,255,255);
	   imagerectangle($image,0,0,144,19,$white);

	   $chars = "ABCDEFGHGKLMNPQRSTUVWXYZ23456789";
	   $captcha_str ='';
	   for($i = 1,$strlen = strlen($chars);$i<=4;++$i){
		   $range_key = mt_rand(0,$strlen-1);
		   $captcha_str .= $chars[$range_key];
	   }

       //将生成的验证码保存到session中
	   @session_start();
	   $_SESSION['captcha_str'] = $captcha_str;

	   $black = imagecolorallocate($image,0,0,0);
	   if(mt_rand(0,1) == 1){
	      $str_color = $white;
	   }else{
	      $str_color = $black;
	   }

	   //在画布上写字符串

	   imagestring($image,5,60,3,$captcha_str,$str_color);

	   header('content-type:image/jpeg;charset = utf-8');

	   imagejpeg($image);
       
	   //销毁资源
	   imagedestroy($image);

	}


	function checkCaptcha($captcha){
	   @session_start();
       return $_SESSION['captcha_str'] == strtoupper($captcha);
	}

}