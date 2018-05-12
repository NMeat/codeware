<?php
/**
 *设计模式之　单例模式
 *$_instance必须声明为静态私有变量
 *构造函数必须声明私有，否则外部程序new之后　就失去了单例的意义
 *getInstance()方法必须声明为公共的方法　调用此方法可以返回一个实例的引用
 *::操作符只能访问静态变量和静态方法
 *new对象只会消耗内存
 *使用场景：最常用的地方是数据库连接
 *使用单例模式生成一个对象后，该对象可以被其它众多对象使用
 */
class Man
{
    //被重载的数据保存在此
    private $data = array();
    //保存实例到此属性中
    private static $_instance;
    //构造函数声明为prvate 防止直接创建对象
    private function __construct(){}

    public static function getInstance(){
        if(!isset(self::$_instance)){
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    private function __clone(){
        trigger_error("clone is not allow", E_USER_NOTICE);
    }

    public function __set($name, $value){
        $this->data[$name] = $value;
    }

    public function __get($name){
        if(array_key_exists($name, $this->data)){
            return $this->data[$name];
        }
        $trace = debug_backtrace();
        trigger_error(
            'Undefined property via __get(): ' . $name .
            ' in ' . $trace[0]['file'] .
            ' on line ' . $trace[0]['line'],
            E_USER_NOTICE);
    }
}

$testMan = Man::getInstance();
$testMan->name = 'I am test data';

echo $testMan->name . PHP_EOL;

unset($testMan);  //unset 后对象里的数据依然在保留

$_testMan = Man::getInstance();
echo $_testMan->name;
