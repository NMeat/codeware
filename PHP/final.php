<?php
/*
    php 关键字 final
    final用来修修饰 类和方法
    final class className  不能被继承 能实例化
    final methodName       该方法不能被子类重写
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