<?php
/**
 * 用PHP实现一个双向队列
 */
class Deque
{
     public $queue = array();
    //的第一个元素
    public function addFirst($value)
    {
        //array_unshift 在数组元素开头插入一个或多久元素
        return array_unshift($this->queue, $value);
    }
    //删除第一个元素
    public function delFisrt($value)
    {
        //删除数组的第一个元素
        return array_shift($this->queue);
    }
    //将一个或多个压入数组的尾部
    public function addLast($value)
    {
        return array_push($this->queue, $value);
    }
    //删除数组尾部的最后一个元素
    public function delLast($value)
    {
        return array_pop($this->queue);
    }
}

$arr = new Deque();
$arr->queue = array("a","b","c","d");
echo $arr->addFirst("lzf");
print_r($arr);
