<?php
/*
与单例模式一样，工厂模式也是一种创建对象的模式。它的特点在于把创建对象的过程封装了起来，从而减少了不同类之间的耦合。

例如，不使用工厂模式，很多地方调用类 A，那么就要实例化一个对象：new A($construct)。如果某天需要修改 A 的名称或者参数，意味着这些代码都要修改。而使用了工厂模式，我们的对象都是从工厂类中产生的，这时我们只要修改工厂类的代码就行。

工厂模式常见的应用场景是这样的：有一个基类（抽象商品）以及多个继承基类的子类（具体商品），例如多个数据库，多种支付方式等。
*/ 


//商品基类
abstract class Cat
{
    abstract protected function voice();
}

//子类  白猫
class WhiteCat extends Cat
{
    public function voice()
    {
        echo '我是白猫, 喵喵喵' . PHP_EOL;
    }
}

//子类 黑猫
class BlackCat extends Cat
{
    public function voice()
    {
        echo '我是黑猫，喵喵喵' . PHP_EOL;
    }
}

//工厂类 生产对象
class factory
{
    public static function create($colorCat)
    {
        switch ($colorCat) {
            case 'WhiteCat':
                return new WhiteCat();
                break;
            case 'BlackCat':
                return new BlackCat();
                break;
            default:
                # code...
                break;
        }
    }

    public static function createWhiteCat(){
        return new WhiteCat();
    }

    public static function createBlackCat(){
        return new BlackCat();
    }
}

$WhiteCat = factory::create('WhiteCat');
$WhiteCat->voice();
$BlackCat = factory::create('BlackCat');
$BlackCat->voice();