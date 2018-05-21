<?php
/*
	- 实现如下函数(PHP 7)
	- echo a(1, 3); //4
	- echo a(3)(5); //8
	- echo a(1, 2)(3, 4, 5)(6); //21
	当尝试以调用函数的方式调用一个对象时，__invoke() 方法会被自动调用
*/

class InvokeCls
{
	public static $cnt = 0;

	public function __invoke(...$args)
	{
		if (!empty($args)) {
			foreach ($args as $key => $value) {
				self::$cnt += (int) $value;
			}
		}
		return $this;
	}

	public function __toString()
	{
		return (String) self::$cnt;
	}
}


echo (new InvokeCls)()(5,7,89)(7)(88,0);

