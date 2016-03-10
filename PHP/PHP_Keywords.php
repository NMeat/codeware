<?php
/**
 *abstract PHP支持抽象类和抽象方法
 *抽象类指在声明一个类的前面加abstract来修饰这个类 
 *抽象类不能被实例化 只能被继承 其子类必段实现抽象父类中的所有抽象方法
 *抽像方法是在方法用abstract修饰 只有方法声明没有方法体 抽象方法在子类中必须被重写
 *抽象类中至少有一个抽象方法 一个类包含抽象方法  这个类也必须声明为抽象类
 *如果子类没有全部实现父类的全部抽象方法 那么子类必须也要定义成抽象类 且不能实例化
 *抽象子类中的方法的访问权限必须等于或大于等于父类中的抽象方法方法的访问权限县且能数数量也要致
 */
//定义一个抽象方法
abstract class User{
    public $height;
    abstract public function getClassName(); //抽象方法   方法体
    public function getHeight(){    //普通非抽象方法
        return $this->height;
    }
}

//一个子类继承抽象类
class subClassA extends User{
    private $name;
    private $age;

    public function __construct($name, $age, $height){
        $this->name = $name;
        $this->age  = $age;
        $this->height = $height;
    }

    public function getClassName(){     //实现父类的抽象方法
        return __CLASS__;
    }
}

$sub1 = new subClassA('Alan', 22, 178.00);
echo $sub1->getHeight();
echo $sub1->getClassName();

/*
    Interface(对象接口)指定某些类必须实现某些方法而不需定义这些方法的具体内容
    PHP类是单继承 当一个类需要多个类的功能时,就需要用到接口技术,接口只定义功能,不包含具体的实现
    接口里不能声明成员属性(实例属性),但可以定义常量
    接口的成员方法都是public访问权限
    实现多个接口时，接口中的方法不能有重名
    接口也可以继承接口 用extends操作符
*/
interface iA{
    const AVAR = 3; //可以定义一个常量(尽量不要定义)
    public function getName();  //没有方法体
    public function getAge();
}

echo iA::AVAR;

//一个子类实现iA接口
class subClassA implements iA{
    private $name;
    private $age ;
    public function __construct($name, $age){
        $this->name = $name;
        $this->age  = $age;
    }

    //实现接口方法
    public function getName(){
        return $this->name;
    }

    public function getAge(){
        return $this->age;
    }
}

$sub1 = new subClassA('Alan', 12);     //实例一个对象
echo $sub1->getName();     //调用方法
echo $sub1->getAge(); 

//定义一个类
class exClassB{
    public $height;
    public function getHeight(){
        return $this->height;
    }
}

//接口
interface iB{
    public function getClassName();
}

//多继承
class subClassB extends exClassB implements iA,iB{
    private $name;
    private $age ;
    public function __construct($name, $age){
        $this->name = $name;
        $this->age  = $age;
    }

    //实现接口方法
    public function getName(){
        return $this->name;
    }

    public function getAge(){
        return $this->age;
    }

    public function getClassName(){
        return __CLASS__;   //返回类名
    }
}

$sub2 = new subClassB('lily', 23);
$sub->height = 170.00;
echo $sub2->getClassName();

//接口继承接口
interface iC extends iA,iB{};

class subClassC implements iC{
    private $name;
    private $age ;
    public function __construct($name, $age){
        $this->name = $name;
        $this->age  = $age;
    }

    //实现接口方法
    public function getName(){
        return $this->name;
    }

    public function getAge(){
        return $this->age;
    }

    //反回类名
    public function getClassName(){
        return __CLASS__;   
    }
}

$sub3 = new subClassC('Lucy', 22);
echo $sub3->getClassName();

/*
    final PHP5新增的关键字
    final用来修修饰 类和方法
    final class className   不能被继承 可以实例化
    final methodName        该方法不能被子类重写
    注意：属性不能被定义为 final，只有类和方法才能被定义为 final
*/

//定义一个final类
final class classA{
    protected static $age;
    public $name;

    public function __construct($age, $name){
        $this->name = $name;
        $this->age  = $age;
    }

    public final function getName(){
        return $this->name;
    }
}

$sub1 = new classA(22, 'Alan');
echo $sub1->getName(); 

class Animal{
    private $_create;
    private $logfile_handle;
    //构造方法 实例化对象时调用
    public function __construct(){
        $this->_create = time();
        $this->logfile_handle = fopen("/home/lzf/web/demo.php", "w");
    }
    //析构方法 当对象销毁时调用此方法
    public function __destruct(){
        fclose($this->logfile_handle);
    }
    //__get魔术方法 访问不存在的属性时调用
    public function __get($field){
        if($field == "name"){
            return '我是__get魔术方法';
        }
    }
    //__set方法是用在给不存在的属性赋值时调用
    public function __set($field,$value){
        if($field == "name"){
            return $value;
        }
    }
    //调用对象不存在的方法时调用此函数
    public function __call($method, $args){
        echo "unknow method :" . $method;
        echo "<br>";
        print_r($args);
        return false;
    }
    //对象序列化时调用此函数
    public function __sleep(){
        return array("_create");
    }
    //当对象反序列化时调用
    public function __wakeup(){
        return $this->_create;
    }
    //对象被克隆时调用
    public function __clone(){
        echo "我被克隆了";
    }
    //当打印对象作为字符串输出时调用此方法
    public function __toString(){
        return "我被打印了";
    } 
}

$penguin = new Animal(); 
echo $penguin;


/**
 *@param    $host   String-  memcache服务器的地址 　　　默认值是127.0.0.1 
 *@param    $port   int   -  memcache服务器的监听端口　 默认值是11211
 *
 *@return   String        -  返回token值
 */
function getAccessToken($host = "127.0.0.1", $port = 11211){
    $memObj = new Memcache;
    $memObj->connect($host, $port);
    $access_token   = $memObj->get("access_token");//获取token值
    $token_time     = $memObj->get("tokenTime"); //获取token值的生命期
    if($access_token && $token_time) {  //token值和token值的生命期　都没有过期
        $timeNow    = time();
        $remainTime = $token_time - $timeNow;              
        if($remainTime < 300) { //如果离token的到期时间不足300秒　则更新token值
            $access_token = "110";
        }
    }else{  //两者任一不存在 则重新token
        $access_token = "110";
    }
    $memObj->close();//关闭联接资源
    return $access_token;
}
$value = getAccessToken();
var_dump($value);