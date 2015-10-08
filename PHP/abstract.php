<?php
/*
    abstract类 和 abstrac方法
    抽象类指在声明一个类的前面加abstract来修饰这个类 
    抽象类不能被实例化 只能被继承 子类必段实现抽象父类中的所有抽象方法
    抽像方法是在方法用abstract修饰 只有方法声明没有方法体 抽象方法在子类中必须被重写
    抽象类中至少有一个抽象方法 一个类中如果有人个方法是抽象方法  这个类也必须声明为抽象类
    如果子类没有全部实现父类的全部抽象方法 那么子类必须也要定义成抽象类 且不能实例化
    抽象子类中的方法的访问权限 大于等于父类中的 抽象方法方法的访问权限
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