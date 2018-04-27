<?php
/*
	yield 生成器函数看上去就像一个普通函数， 除了不是返回一个值之外， 
		  生成器 类实现了生成器接口 这意味着你必须遍历方法来取值
		  一个生成器允许你使用循环来迭代一组数据，而不需要在内存中创建是一个数组，这可能会导致你超出内存限制

*/
function get_one_to_three()
{
	for ($i=0; $i <= 8; $i++) { 
		yield $i;
	}
}


$generator = get_one_to_three();

var_dump($generator);	//object(Generator)#1 (0) {}
var_dump($generator instanceof Iterator);	//bool(true)

foreach ($generator as $key => $value) {
	echo $value . PHP_EOL;
}

echo '华丽分界线---------------------------' . PHP_EOL;

/*
	在下面的例子里我们创建一个有 800,000 元素的数字同时从 getValues() 方法中返回他，
	同时在此期间，我们将使用函数 memory_get_usage() 来获取分配给次脚本的内存， 
	我们将会每增加 200,000 个元素来获取一下内存使用量，这意味着我们将会提出四个检查点
*/
function get_values()
{
	$valuesArray = [];
	echo round(memory_get_usage() / 1024 / 1024, 2) . 'MB' . PHP_EOL;

	for ($i=0; $i < 800000; $i++) { 
		$valuesArray[] = $i;
		if(($i % 200000) == 0){
			echo round(memory_get_usage() / 1024 / 1024, 2) . 'MB' . PHP_EOL;
		}
	}
	return $valuesArray;
}
$myValues = get_values(); // 一旦我们调用函数将会在这里创建数组

echo '华丽分界线---------------------------' . PHP_EOL;

function getValues() 
{
   //获取内存使用数据
   echo round(memory_get_usage() / 1024 / 1024, 2) . ' MB' . PHP_EOL;
   for ($i = 1; $i < 800000; $i++) {
      yield $i;
      //做性能分析，因此可测量内存使用率
      if (($i % 200000) == 0) {
         //内存使用以 MB 为单位
         echo round(memory_get_usage() / 1024 / 1024, 2) . ' MB'. PHP_EOL;
      }
   }
}
$myValues = getValues(); // 在循环之前都不会有动作,特别注意此时函数并没有执行
foreach ($myValues as $value) {} // 开始生成数据

