<?php
class BackPlatformController extends Controller{
	public function __construct(){
		$this->initSession();
		$this->checkLogin();
	}
	//初始化session的方法
	protected function initSession(){
		new SessionDBTool;
	}

	//验证是否登陆
	protected function checkLogin(){
		$controller = array('Admin');
		$action = array("login","signin","captcha","logout");
		if(in_array(CONTROLLER, $controller) && in_array(ACTION, $action)){
			//不需要验证
		}else{
			if(isset($_SESSION['is_login']) && $_SESSION['is_login']=='yes'){
				//继续执行
			}else{
				$adminModel = new AdminModel;
				if($adminModel->checkByCookie()){
					$_SESSION['is_login'] = "yes";
				}else{
					$this->jump('index.php?p=back&c=Admin&a=login','请先登录！！！',2);
				}
			}
		}
	}
}