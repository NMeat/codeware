<?php
/*
完成一项任务，往往可以有多种不同的方式，每一种方式称为一个策略，我们可以根据环境或者条件的不同选择不同的策略来完成该项任务。

在软件开发中也常常遇到类似的情况，实现某一个功能有多个途径，此时可以使用一种设计模式来使得系统可以灵活地选择解决途径，也能够方便地增加新的解决途径。

这种设计模式就是策略模式。策略模式定义了一系列的算法，并将每一个算法封装起来，而且使它们还可以相互替换。策略模式让算法独立于使用它的客户而独立变化，即封装变化的算法。

策略模式主要用来分离算法，根据相同的行为抽象来做不同的具体策略实现。

策略模式结构清晰明了、使用简单直观。并且耦合度相对而言较低，扩展方便。同时操作封装也更为彻底，数据更为安全。

当然策略模式也有缺点，就是随着策略的增加，子类也会变得繁多。另外一个缺点就是客户端必须知道所有的策略类，并自行决定使用哪一个策略类。

但缺点并不会影响系统运行，所以在复杂业务中应该考虑使用。

*/

// 策略接口
interface OutputStrategy
{
    public function render($array);
}


// 策略类1：返回序列化字符串
class SerializeStrategy implements OutputStrategy
{
    public function render($array)
    {
        return serialize($array);
    }
}

// 策略类2：返回JSON编码后的字符串
class JsonStrategy implements OutputStrategy
{
    public function render($array)
    {
        return json_encode($array);
    }
}

// 策略类3：直接返回数组
class ArrayStrategy implements OutputStrategy
{
    public function render($array)
    {
        return $array;
    }
}

// 以后的维护过程中，以上代码都不需修改了
// 要增加新的输出方式，只要在增加子类就好

// 环境角色类
// 一旦写好，环境角色类以后也不需要修改了
class Out
{
    private $outputStrategy;
    public function __construct(outputStrategy $outputStrategy)
    {
        $this->outputStrategy = $outputStrategy;
    }

    public function renderOutput($array)
    {
        return $this->outputStrategy->render($array);
    }
}

class Client
{
    public static function main()
    {
        $array = [3,6,4,67,998,1];
        $output = new Out(new SerializeStrategy());
        print_r($output->renderOutput($array)) . PHP_EOL;

        $output = new Out(new JsonStrategy());
        print_r($output->renderOutput($array)) . PHP_EOL;

        $output = new Out(new ArrayStrategy());
        print_r($output->renderOutput($array)) . PHP_EOL;
    }
}


Client::main();




























