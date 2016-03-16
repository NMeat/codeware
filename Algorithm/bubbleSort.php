<?php
/**
 * 比较相邻两个元素的大小 如果第一个比第二个大就交换两个元素的位置
 * 冒泡排序
 */
function bubbleSort($arr){
    for($i = 0,$len = count($arr);$i < $len; $i++){
        for($j = 1;$j < $len -$i; $j++ ){
            if($arr[$j - 1] > $arr[$j]){
                $temp = $arr[$j - 1];
                $arr[$j - 1] = $arr[$j];
                $arr[$j] = $temp;
            }
        }
    }
    return $arr;
}

//从大到小排列数组
function getSort($arr){
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

$arr = array(10,3,90,45,33,22,111);
print_r(getSort($arr));
echo "<br>";
print_r(bubbleSort($arr));
echo "<br>";
print_r($arr);
arsort($arr); //对数组进行逆向排序并保持索引关系
echo "<br>";
print_r($arr);
echo "<br>";
asort($arr);  //对数组进行排序并保持索引关系
print_r($arr);
