<?php
/*
    工厂模式:
        提供获取某个对象实例的一个接口，同时使调用代码避免确定实例化基类的步骤。
        工厂模式 实际上就是建立一个统一的类实例化的函数接口。统一调用，统一控制。
        工厂模式是php项目开发中，最常用的设计模式，一般会配合单例模式一起使用，来加载php类库中的类
    使用场景：
        我们拥有一个Json类，String类，Xml类。
        如果我们不使用工厂方式实例化这些类，则需要每一个类都需要new一遍，过程不可控，类多了，到处都是new的身影
        引进工厂模式，通过工厂统一创建对象实例
*/

//工厂模式 提供获取某个对象实例的一个接口，同时使调用代码避免确定实例化基类的步骤  
//字符串类  
class String {  
    public function write() {
        return 'String'
    }  
}  
//Json类  
class Json {  
    public function getJsonData() {
        return 'Json';
    }  
}  
//xml类  
class Xml {  
    public function buildXml() {
        return 'Xml';
    }  
}  
//工厂类  
class Factory {  
    public static function create($class) {  
        return new $class;  
    }  
}  
$ob = Factory::create("Json"); //获取Json对象
$ob->getJsonData();   