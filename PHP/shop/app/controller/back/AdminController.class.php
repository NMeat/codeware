<?php
header("content-type:text/html;charset=utf-8");
class AdminController extends BackPlatformController {
	// 展示登录表单
	public function loginAction() {
		//调用视图层，模板，载入登录视图页面
		require VIEW_DIR.'back/login.html';
	}

    //管理员登录验证
	public function signinAction(){
        $captcha = new CaptchaTool;
	    if(!$captcha->checkCaptcha($_POST['captcha'])){
		   $this->jump("index.php?p=back&c=Admin&a=login",'验证码错误');
		}

		$model_admin = new AdminModel();
         //判断返回的验证结果
		if($admin_info = $model_admin->checkByLogin($_POST['username'],$_POST['password'])){
			$_SESSION['is_login'] = "yes";
			if(isset($_POST['remember']) && $_POST['remember'] == '1'){
			    setcookie('admin_id',$admin_info['admin_id'],PHP_INT_MAX);
				setcookie('admin_pass',md5('shop_admin'.$admin_info['admin_pass'].'pass'),PHP_INT_MAX);
			}
			$this->jump('index.php?p=back&c=Index&a=index');
		}else{
			$this->jump("index.php?p=back&c=Admin&a=login","对不起，您是非法用户",5);
		}
	}


    //验证码
	public function captchaAction(){
	   $captcha = new CaptchaTool;
	   $captcha->generareCaptcha();
	}
	
	//注销登陆
	public function logoutAction(){
	   unset($_SESSION['is_login']);
	   unset($_SESSION['captcha_str']);
	   session_destroy();
	   setcookie("PHPSESSID",'',time()-1);
	   $this->jump("index.php?p=back&c=Admin&a=login");
	}
}