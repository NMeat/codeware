<?php
class Animal
{
    private $_create;
    private $logfile_handle;
    //构造方法 实例化对象时调用
    public function __construct()
    {
        $this->_create = time();
        $this->logfile_handle = fopen("/home/lzf/web/demo.php", "w");
    }
    //析构方法 当对象销毁时调用此方法
    public function __destruct()
    {
        fclose($this->logfile_handle);
    }
    //__get魔术方法 访问不存在的属性时调用
    public function __get($field)
    {
        if($field == "name")
        {
            return '我是__get魔术方法';
        }
    }
    //__set方法是用在给不存在的属性赋值时调用
    public function __set($field,$value)
    {
        if($field == "name")
        {
            return $value;
        }
    }
    //调用对象不存在的方法时调用此函数
    public function __call($method, $args)
    {
        echo "unknow method :" . $method;
        echo "<br>";
        print_r($args);
        return false;
    }
    //对象序列化时调用此函数
    public function __sleep()
    {
        return array("_create");
    }
    //当对象反序列化时调用
    public function __wakeup()
    {
        return $this->_create;
    }
    //对象被克隆时调用
    public function __clone()
    {
        echo "我被克隆了";
    }
    //当打印对象作为字符串输出时调用此方法
    public function __toString()
    {
        return "我被打印了";
    } 
}

$penguin = new Animal(); 
echo $penguin;
