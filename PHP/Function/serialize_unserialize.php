<?php
class Person
{
	private $name;
	private $sex;
	private $age;

	function __construct($name,$age,$sex)
	{
		$this->name = $name;
		$this->age = $age;
		$this->sex = $sex;
	}

	function say()
	{
		echo "我的名字：".$this->name."性别为: ".$this->sex."年龄为：".$this->age;
	}

　　 //在类中添加此方法，在串行化的时候自动调用并返回数组
	function __sleep()
	{
		//数组中的成员$name和$age将被串行化，成员$sex则将被忽略
		$arr = array("name","age");
		//使用__sleep()方法的时候必须返回一个数组
		return($arr);			  
	}

	//在反串行化对象时自动调用该方法，没有参数也没有返回值
	function __wakeup()
	{
		//在重新组织对象的时候，为新对象中的$age属性重新赋值
		$this->age = 40;	 
	}
}

$person1 = new Person("张三",20,"男");
$person1_string = serialize($person1);
echo $person1_string."<br />";

//反串行化对象，并自动调用了__wakeup()方法重新为独享中的age赋值。
$person2 = unserialize($person1_string);
$person2->say();