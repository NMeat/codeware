<?php
$arr = array_rand(range(1, 3000), 1500); //创建50个元素的大数组 随机取20个元素
shuffle($arr); //获取已经打乱的顺序数组

function getCurrentTime()
{
	list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}

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

//从大到小排列数组
function bubbleSort($arr)
{
    for($i = 0, $len = count($arr); $i < $len; $i++){
        for($j = $i + 1; $j < $len; $j++){
            if($arr[$i] < $arr[$j]){
                $tmp = $arr[$i];
                $arr[$i] = $arr[$j];
                $arr[$j] = $tmp;
            }
        }
    }
    return $arr;
}

$startTime = getCurrentTime();
$arr = quickSort($arr);
// var_dump($arr);
$endTime = getCurrentTime();
echo '快排耗时:' . ($endTime - $startTime) . PHP_EOL;

shuffle($arr);
$startTime = getCurrentTime();
$arr = bubbleSort($arr);
$endTime = getCurrentTime();
// var_dump($arr);
echo '冒排耗时:' . ($endTime - $startTime) . PHP_EOL;


