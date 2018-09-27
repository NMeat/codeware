<?php
//快速排序
function quickSort($arr)
{
    $len = count($arr);
	if (!is_array($arr) || $len <= 1) {
        return $arr;
    }

	$first = $arr[0];  //第一个元素做比较值
	$left = $right = array();
	for ($i = 1; $i < $len; $i++) {
		if ($arr[$i] < $first) {
			$left[] = $arr[$i];
		} else {
			$right[] = $arr[$i];
		}
	}

    //递归
	$left  = quickSort($left);
	$right = quickSort($right);
    //组合数组
	$res = array_merge($left, array($first), $right);
	return $res;
}
$arr = array_rand(range(1, 50), 20); //创建50个元素的大数组 随机取20个元素
shuffle($arr); //获取已经打乱的顺序数组
$arr = quickSort($arr);
var_dump($arr);

