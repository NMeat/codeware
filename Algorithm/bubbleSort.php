<?php
/**
 * @param $arr
 * @return mixed
 */
function bubbleSort($arr)
{
    //第一层for循环可以理解为从数组中键为0开始循环到最后一个
    for($i = 0, $len = count($arr); $i < $len; $i++){
        // 第二层将从键为$i的地方循环到数组最后
        for($j = $i + 1; $j < $len; $j++){
            //比较数组中相邻两个值的大小  只要修改一个比较符号就可以反向操作
            if($arr[$i] > $arr[$j]){
                $tmp = $arr[$i];
                $arr[$i] = $arr[$j];
                $arr[$j] = $tmp;
            }
        }
    }
    return $arr;
}

$arr = array(10,3,90,45,33,22,111);
print_r(bubbleSort($arr));
echo "<br>";
print_r($arr);
arsort($arr); //对数组进行逆向排序并保持索引关系
echo "<br>";
print_r($arr);
echo "<br>";
asort($arr);  //对数组进行排序并保持索引关系
print_r($arr);
