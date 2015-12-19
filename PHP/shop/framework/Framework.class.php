<?php
//框架的初始化类
class Framework{

   public static function run(){
   	self::initRequest();
   	self::initPath();
   	self::loadConfig();  //带有初始化数据的方法要早于自动加载方法执行
   	spl_autoload_register(array('Framework','shop__autoload'));
   	self::distribution();
   	

   }
   
   //初始化请求 并定义成常量  
   private static function initRequest(){

   	  define("PLATFORM", isset($_GET['p']) ? $_GET['p'] : 'back');
   	  define("CONTROLLER", isset($_GET['c']) ? $_GET['c'] : 'class');
   	  define("ACTION", isset($_GET['a']) ? $_GET['a'] : '');
   }
   
   //初始化路径常量
   private static function initPath(){

	   define('DS', DIRECTORY_SEPARATOR);                        
	   define('ROOT_DIR', dirname(dirname(__FILE__)) . DS);                    //根目录
	   define('APP_DIR', ROOT_DIR . 'app' . DS);                               //应用程序的目录
	   define('CONTROLLER_DIR', APP_DIR . 'controller' . DS);                  //控制器目录
	   define('CURRENT_CONTROLLER_DIR', CONTROLLER_DIR . PLATFORM . DS);       //当前平台控制器的目录
	   define('VIEW_DIR', APP_DIR . 'view' . DS);
	   define("CURRENT_VIEW_DIR", VIEW_DIR . PLATFORM . DS);
	   define("MODEL_DIR", APP_DIR . 'model' . DS);
	   define("FRAMEWORK", ROOT_DIR . 'framework' .DS);
	   define('CONFIG_DIR', APP_DIR . "config" . DS);
	   define('TOOL_DIR',FRAMEWORK . 'TOOL' . DS);//工具类目录
	   define('UPLOAD_DIR',APP_DIR . 'upload' . DS);
   }


   //自定义加载方法
    public static function shop__autoload($class_name){

   	  $map = array(
         'MySQLDB'=>FRAMEWORK . 'MySQLDB.class.php',
         'Model'  =>FRAMEWORK . 'Model.class.php',
         'Controller'=>FRAMEWORK . 'Controller.class.php'
   	  	);

   	     if (isset($map[$class_name])) {
	   	  	  require $map[$class_name];
	   	  }elseif(substr ($class_name, -10) == 'Controller'){
	          require CURRENT_CONTROLLER_DIR . $class_name .'.class.php';
	   	  }elseif(substr($class_name, -5) == 'Model') {
	   	  	  require MODEL_DIR . $class_name . ".class.php";
	   	  }elseif(substr($class_name,-4) == "Tool"){
			  require TOOL_DIR . $class_name . ".class.php";
		  }
    }


    //请求分发
    private static function distribution(){
   
	     $controller_name = CONTROLLER . 'Controller';
	     $controller = new $controller_name; 
	     $action = ACTION . 'Action';
	     $controller->$action();	
	}
   //加载配置文件
	private static function loadConfig(){
		$GLOBALS['config'] = require CONFIG_DIR . 'app.config.php';
	}
}