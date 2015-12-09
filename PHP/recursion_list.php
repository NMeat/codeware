<?php
/*
 *利用递归 实现无限级分类
 *@author  liuzhifeng
 *@date    2014-12-29
 */
//预制一个数组
$rows = array(
    array(
        'id' => 1,
        'name' => 'dev',
        'parent_id' => 0
    ),
    array(
        'id' => 2,
        'name' => 'php',
        'parent_id' => 1
    ),
    array(
        'id' => 3,
        'name' => 'smarty',
        'parent_id' => 2
    ),
    array(
        'id' => 4,
        'name' => 'life',
        'parent_id' => 0
    ),
    array(
        'id' => 5,
        'name' => 'pdo',
        'parent_id' => 2
    ),
    array(
        'id' => 6,
        'name' => 'pdo-mysql',
        'parent_id' => 5
    ),
    array(
        'id' => 7,
        'name' => 'java',
        'parent_id' => 1
    )
);


/*
 *@param  $arr       -array,    要处理的数组 
 *        $pare_id   -int,      父结点的ID ，默认值是0
 *        $deep,     -int,      子结点的深度，默认值是0
 *
 *@return array      -array     返回处理后的数组树
 */
function getTree($arr,$pare_id = 0, $deep = 0)
{
	static $tree = array();                          //定义一个静态的数组变量
	foreach($arr as $value)
	{
		if ($value['parent_id'] == $pare_id) 
		{
			$value['deep'] = $deep;                  //将树的深度值插入该元素
			$tree[] = $value;                        //再将改变后的数组放入静态数组里
			getTree($arr, $value['id'], $deep + 1);
		}
	} 
	return $tree;                                    //返回处理后的数组树
}

$tree = getTree($rows);
var_dump($tree);