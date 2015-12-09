<?php
/*
    Interface(接口)
    PHP类是单继承 当一个类需要多个类的功能时,就需要用到接口技术,接口只定义功能,不包含具体的实现(没有方法体)
    接口里不能声明成员属性(实例属性),但是类中可以定义常量
    接口的成员方法都是public访问权限
    接口也可以继承接口
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