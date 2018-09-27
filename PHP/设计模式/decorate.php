<?php  
/*
    装饰器模式 : 对已有对象的部分内容或者功能进行调整，但是不需要修改原始对象结构，可以使用装饰器设计模式
    应用场景:
        设计一个UserInfo类，里面有UserInfo数组，用于存储用户名信息
        通过addUser来添加用户名
        getUserList方法将打印出用户名信息
        现在需要将添加的用户信息变成大写的，我们需要不改变原先的类，并且不改变原先的数据结构
        我们设计了一个UserInfoDecorate类来完成这个需求的操作，就像装饰一样，给原先的数据进行了装修
        装饰器模式有些像适配器模式，但是一定要注意，装饰器主要是不改变现有对象数据结构的前提
*/

//UserInfo类
class UserInfo
{
    public $userInfo = array();             //用户信息数组

    public function addUser($userInfo) {    //添加用户信息
        $this->userInfo[] = $userInfo;  
    }  
          
    public function getUserList() {         //获取用户信息
        print_r($this->userInfo);  
    }  
}  

//UserInfoDecorate 装饰一样，改变用户信息输出为大写格式，不改变原先UserInfo类
class UserInfoDecorate {  
    public function makeCaps($UserInfo) {  
        foreach ($UserInfo->userInfo as &$val) {  
            $val = strtoupper($val);  
        }  
    }  
      
}  
  
$UserInfo = new UserInfo;                   //实例化一个类
$UserInfo->addUser('zhu');          //添加用户信息
$UserInfo->addUser('initphp');  
$UserInfoDecorate = new UserInfoDecorate();
$UserInfoDecorate->makeCaps($UserInfo);     //修改用户信息
$UserInfo->getUserList();  