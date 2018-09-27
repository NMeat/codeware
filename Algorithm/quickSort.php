<?php
//快速排序
function quickSort($arr)
{

	if (!is_array($arr) || $len = count($arr) <= 1) {
        return $arr;
    }
    echo $len;die;
	$first = $arr[0];
	$left = $right = array();
	for($i = 1; $i < $len; $i++){
		if ($arr[$i] < $first) {
			$left[] = $arr[$i];
		}else{
			$right[] = $arr[$i];
		}
	}

	$left  = quickSort($left);
	$right = quickSort($right);
	$res = array_merge($left, array($first), $right);
	return $res;
}

$arr = array(23,4,3,2,78,4556,34,22,987);

$arr = quickSort($arr);

var_dump($arr);

