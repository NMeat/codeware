 <?php
 /*
前面的两个设计模式都是用于创建对象的，观察者模式是属于面向行为的。它的具体思路是这样的：首先，有一个主题类，它用于执行某些业务；其次，有多个观察者类，它们先向主题类注册，当主题类的实例发生变化时，执行某些操作。

它需要有两个接口和至少两个类。一个主题接口（注册观察者方法，通知观察者方法），一个观察者接口（收到通知执行操作方法），一个主题类实现主题接口，一个或多个观察者类实现观察者接口。

这么说来比较抽象，一个具体的业务实例如下：每当有新用户注册时，给他发一封邮件。

不使用观察者模式的写法是这样的：首先，向数据库插入一条数据，然后，判断是否插入成功，成功则调用发送邮件函数。这样会产生两个问题：一旦业务逻辑发生改变，如注册成功要先发送短信，需要修改用户注册流程，相当于要修改核心业务文件；另一个问题如果注册成功需要执行的其他业务较多，导致这个文件冗长，后续维护困难。

使用观察者模式的逻辑是这样的：将用户注册业务作为主题，后续的每个业务看作是观察者。每个观察者先在主题类中进行注册，和主题类构建依赖关系。当执行完用户注册的操作后，调用观察者的业务函数（相当于通知观察者），观察者开始执行自己的业务。增加业务只要增加观察者并注册到主题就好。

通过观察者模式（个人理解有点触发器的意思），可以降低主题和观察者之间耦合，减少代码的长度。
*/

// 观察者接口(通知接口)
interface ITicketObserver
{
    public function onBuyTicketOver($sender, $args);
}

// 主题接口
interface ITicketObservable
{
    public function addObserver(ITicketObserver $observer);//提供注册观察者方法
}


#====================主题类实现========================

class Buy implements ITicketObservable
{
    private $_observers = array (); //通知数组（观察者）

    //注册观察者，添加通知
    public function addObserver(ITicketObserver $observer)
    {
        $this->_observers[] = $observer;
    }

    //购票核心方法，处理购票流程
    public function buyTicket($ticket)
    {
        //... 购票逻辑
        //循环通知每个观察者，调用其onBuyTicketOver实现不同业务逻辑
        foreach ($this->_observers as $obs) {
            $obs->onBuyTicketOver($this, $ticket);  //$this可用来获取主题类句柄，在通知中使用
        }
    }
}

#=========================定义多个观察者====================
//文本日志通知
class Txt implements ITicketObserver
{
    public function onBuyTicketOver($sender, $args)
    {
        echo date('Y-m-d H:i:s') . ' 文本日志记录:购票成功:' . $ticket . PHP_EOL;
    }
}

//短信日志通知
class Sms implements ITicketObserver
{
    public function onBuyTicketOver($sender, $args)
    {
        echo date('Y-m-d H:i:s') . ' 短信通知记录:购票成功' . $ticket . PHP_EOL;
    }
}

//抵扣券赠送通知
class DiKou implements ITicketObserver
{
    public function onBuyTicketOver($sender, $args)
    {
        echo date('Y-m-d H:i:s') . ' 赠送抵扣券:购票成功' . $ticket . PHP_EOL;
    }
}


#============================用户购票====================
$buy = new Buy();
$buy->addObserver(new Txt());
$buy->addObserver(new Sms());
$buy->addObserver(new DiKou);
$buy->buyTicket('一排一号');



































