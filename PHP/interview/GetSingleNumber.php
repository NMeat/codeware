<?php
/*
通过这种思路，我们可以求出任何这种类型的题目。

如果一个数组中，每个数字都出现偶数次，只有一个数字出现一次，利用异或即可

如果一个数组中，每个数字都出现奇数(大于1)次，只有一个数字出现一次，那么就用一个32位的数组，记录所有位中为1的个数，最后数组中每一个数字对这个奇数取余，不为0的，把它取出，按它的位数，转化成十进制的数字。
*/
class GetSingleNumber
{
	public static $arrTwo = [8,9,4,4,9,8,56];

	public static $arrThr = [118,118,118,9,9,9,1,1,1,67];

	//一个整形数组中，每个数字都出现两次，只有一个数字出现一次，找出这个数字
	public function getNumberForTwo()
	{
		$tmp = 0;
		$len = count(self::$arrTwo);

		for ($i=0; $i < $len; $i++) { 
			$tmp ^= self::$arrTwo[$i];
		}

		return $tmp;
	}

	//一个整形数组中，每个数字都出现三次，只有一个数字出现一次，找出这个数字。
	public function getNumberForThr()
	{
		$bits = array_fill(0, 31, 0);
		$len = count(self::$arrThr);

		for ($i=0; $i < $len; $i++) { 
			for ($j=0; $j < count($bits); $j++) { 
				$bits[$j] += ((self::$arrThr[$i] >> $j) & 1);
			}
		}

		$res = 0;
		for ($i=0; $i < 32; $i++) { 
			if(($bits[$i] % 3) != 0){
				$res += (1 << $i);
			}
		}
		return $res;
	}
}

echo GetSingleNumber::getNumberForTwo() . PHP_EOL;

echo GetSingleNumber::getNumberForThr() . PHP_EOL;