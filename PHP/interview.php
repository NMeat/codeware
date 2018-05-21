<?php
/*
	输入一个整形数组，数组里有正数也有负数。
	数组中一个或连续的多个整数组成一个子数组。求所有子数组的和的最大值。要求时间复杂度为O(n)。
*/

function findGreatistSumOfSubArray($arr)
{
	if (!is_array($arr) || empty($arr)) {
		return 0;
	}

	$sum = 0;
	$max = $arr[0];
	$len = count($arr);

	for ($i=0; $i < $len; $i++) { 
		$sum = $max + $arr[$i];

		if ($sum > $max) {
			$max = $sum;
		}

		if ($sum < 0) {
			$sum = 0;
		}
	}

	return $sum;
}

$arr = [6,-9,9,8,1,0,87];

echo findGreatistSumOfSubArray($arr);
