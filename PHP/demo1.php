<?php
//对二维数组可以
function testSort($arr, $str, $order = 0)
{
    $tmpArr = array();
    foreach ($arr as $key => $value)
    {
        $keyTest = $value[$str];
        $tmpArr[$keyTest] = $value;
    }
    if($order == 0)
    {
        ksort($tmpArr);//根据键词对数组排序
    }
    else
    {
        krsort($tmpArr);//根据键值对数组逆向排序
    }
    return $tmpArr = array_values($tmpArr);
}

$arr = array(
    array("name"=>"lzf1", "score"=>78),
    array("name"=>"lzf2", "score"=>58),
    array("name"=>"lzf3", "score"=>98),
    array("name"=>"lzf4", "score"=>28)
);

//$arrT = testSort($arr, "score",1);
//var_dump($arrT);

//在一个数组中查找指定的值
function seqSearch($arr, $target)
{
    for($i = 0, $length = count($arr); $i < $length; $i++)
    {
        if($arr[$i] == $target)
        {
            break;//找到就跳出遍历
        }
    }
    return $i < $length ? $i : -1;
}

$arr = array(4,6,7,9,3,2);

function binSearch($arr,$start,$end, $target)
{
    if($start <= $end)
    {
        $mid = intval(($start+$end)/2);
        if($arr[$mid] == $target)
        {
            return $mid;
        }
        elseif($target < $arr[$mid])
        {
            return binSearch($arr,$start,$mid-1,$target);
        }
        else
        {
            return binSearch($arr,$mid+1,$end,$target);
        }
    }
    return -1;
}
sort($arr);
var_dump(binSearch($arr,0,5,2));
















