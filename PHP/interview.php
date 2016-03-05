<?php
/*
	一个类有两个属性，都是整型数组
	有两个方法，一个方法对任意一个成员属性进行排序
	另一个方法对两个数组进行相加
*/
class Test{
	public $arrA;
    public $arrB;
	public function __construct($arrA, $arrB){
		$this->arrA = $arrA;
		$this->arrB = $arrB;
	}
	
	//对数组进行排序 从小到大
	public function sortArr(){
		if(!is_array($this->arrA)) return false;
		return asort($this->arrA);
	}
	//两个数组进行相加 注意位对齐
	public function addArr(){
		$lenA = count($this->arrA);
		$lenB = count($this->arrB);	
		if($lenA < $lenB){
			$this->arrA = array_pad($this->arrA, -$lenB,0);
		}elseif($lenA > $lenB){
			$this->arrB = array_pad($this->arrB, -$lenA,0);
		}
		
		return array_map("doAdd", $this->arrA, $this->arrB);
	}
}
//回调函数
function doAdd($arrA, $arrB){
	return $arrA + $arrB;
}
$arrA = array(1,2,22,6,4,3,9,5,780);
$arrB = array(14,242,64,44,332,29,5,80);
$testObj = new Test($arrA, $arrB);
$testObj->sortArr();
$addArr = $testObj->addArr();
