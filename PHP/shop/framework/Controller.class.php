<?php
//基础控制器
class Controller {
	//跳转函数
	protected function jump($url,$message = '',$time = 3){
          if ($message == '') {
          	header("Location:" . $url);
          }else{
          	if (file_exists(CURRENT_VIEW_DIR . 'jump.html')) {
          		require CURRENT_VIEW_DIR . 'jump.html';
          	}else{
          		 //这是默认的提示
          		echo <<<HTML
<html>
	 <head>
	  <meta http-equiv="content-type" content="text/html;charser=utf-8";/>
	  <meta http-equiv="refresh" content="$time;url = $url"/>
	  <title>提示:$message</title>
	 </head>
	 <body>
	     $message
	 </body>
</html>
HTML;
          	}
          }
          die;         //强制停止脚本运行
	}
}
