<?php
//二分查找法
//二分查找的数组必须是已经排序好的数组
function binarySearch($arr, $target){
	if(!is_array($arr)) return false;
	$low = 0;
	$high = count($arr) - 1;
	while ($low <= $high) {
		$mid = floor(($high + $low) / 2);
		echo $mid . "\n";
		if($arr[$mid] == $target) return $mid;
		//中间元素比目标元素大
		if($arr[$mid] > $target) $high = $mid - 1;
		//中间元素比目标元素小
		if($arr[$mid] < $target) $low  = $mid + 1;
	}
	return false;
}
$arr = array(4,23,56,89,433,23345,77888);
$res = binarySearch($arr, 4);
var_dump($res);

//二分查找法
$arr = array(4,6,7,9,3,2);
function binSearch($arr, $start, $end, $target){
    if($start <= $end){
        $mid = intval(($start+$end)/2);
        if($arr[$mid] == $target){
            return $mid;
        }elseif($target < $arr[$mid]){
            return binSearch($arr, $start, $mid-1, $target);
        }else{
            return binSearch($arr, $mid+1, $end, $target);
        }
    }
    return -1;
}
sort($arr);
var_dump(binSearch($arr,0,5,2));
