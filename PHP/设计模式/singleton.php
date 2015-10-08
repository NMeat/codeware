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
    //保存实例到此属性中
    private static $_instance;
    //构造函数声明为prvate 防止直接创建对象
    private function __construct()
    {
        echo "我被实例化了";
    }

    //单例方法
    public static function getInstance()
    {
        if(!isset(self::$_instance))
        {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    //防止用户复制对象实例
    private function __clone()
    {
        trigger_error("clone is not allow", E_USER_ERROR);
    }
    function test()
    {
        echo "test";
    }
}

$testMan = Man::getInstance();
echo "</br>";
$testMan->test();
