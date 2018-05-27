<?php
//快速排序
function quict_sort($arr)
{
	if(count($arr) <= 1) {
		return $arr;
	}

	$key = $arr[0];
	$left_arr = $right_arr = array();

	for($i = 1; $i < count($arr); $i++){
		if($arr[$i] <= $key){
			$left_arr[] = $arr[$i];
		}else{
			$right_arr[] = $arr[$i];
		}
	}

	$left_arr = quict_sort($left_arr);
	$right_arr = quict_sort($right_arr);

	return array_merge($left_arr, array($key), $right_arr);
}
$arr = [4,44,-2,3,98,777,9,877];
$arr = quict_sort($arr);
var_dump($arr);

//二分查找
function bin_search($arr, $target, $low, $high)
{
	if($low <= $high){
		$mid = intval(($low + $high)/2);
		if ($arr[$mid] == $target) {
			return $mid;
		}else if($arr[$mid] < $target){
			return bin_search($arr, $target, $mid+1, $high);
		}else{
			return bin_search($arr, $target, $low, $mid-1);
		}
	}
	return -1;
}


$arr = bin_search($arr, 3, 0, 7);
var_dump($arr);