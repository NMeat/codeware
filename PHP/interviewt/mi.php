<?php
/*
    小米的一道面试题
    一个类有两个属性，都是整型数组
    有两个方法，一个方法对任意一个成员属性进行排序
    另一个方法对两个数组进行相加
*/
class Test
{
	public static $arrA = [12,242,22,69,499,39,9,59,780];
    public static $arrB = [14,242,64,44,332,29,5,80];
	
	//对数组进行排序 从小到大
	public static function sortArr($arrTag = 'A')
	{
		if ('A' === $arrTag) {
			return sort(self::$arrA);
		}else if ('B' === $arrTag) {
			return sort(self::$arrB);
		}
		return false;
	}

	//两个数组进行相加 注意位对齐
	public static function addArr()
	{
		return array_map(function($v1, $v2){
			return $v1 + $v2;
		}, self::$arrA, self::$arrB);
	}
}

$sum_arr = Test::addArr();
var_dump($sum_arr);

Test::sortArr('A');

var_dump(Test::$arrA);







