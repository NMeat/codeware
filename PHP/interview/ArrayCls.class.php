<?php
/**
 * 数组相关的算法题
 */
class ArrayCls
{
	/**
	 *反转数组
	 *@param $arr
	 *@return array
	 */
	public static function reverse($arr)
	{
		$cnt = count($arr);
		$left = 0;
		$right = $cnt - 1;

		while ($left < $right) {
			$tmp = $arr[$left];
			$arr[$left++] = $arr[$right];
			$arr[$right--] = $tmp;
		}
		return $arr;
	}

	/**
	 * 两个有序int集合是否有相同元素的最优算法
	 * 寻找两个数组里相同的元素
	 * @param  array $arr1 
	 * @param  array $arr2 
	 * @return array 
	 */
	public static function find_common($arr1, $arr2)
	{
		$common = array();
		$i = $j = 0;
		$cnt1 = count($arr1);
		$cnt2 = count($arr2);
		while ($i < $cnt1 && $j < $cnt2) {
			if($arr1[$i] < $arr2[$j]){
				$i++;
			}elseif ($arr1[$i] > $arr2[$j]) {
				$j++;
			}else{
				$common[] = $arr[$i];
				$i++;
				$j++;
			}
		}
		return array_unique($common);
	}

	/**
	 * 将一个数组中的元素随机（打乱）
	 * 打乱数组
	 * @param  array $arr 
	 * @return array      
	 */
	public static function custom_shuffle($arr)
	{
		$cnt = count($arr);
		for ($i=0; $i < $cnt; $i++) { 
			$rand_pos = mt_rand(0, $cnt);
			if ($i != $rand_pos) {
				$tmp = $arr[$i];
				$arr[$i] = $arr[$rand_pos];
				$arr[$rand_pos] = $tmp;
			}
		}
		return $arr;
	}

	/**
	 *  输入一个整形数组，数组里有正数也有负数。
	 *  数组中一个或连续的多个整数组成一个子数组。求所有子数组的和的最大值。要求时间复杂度为O(n)。
	 *  @param $arr array
	 *  @return int
	 */
	public static function findGreatistSumOfSubArray($arr)
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

	/**
	 *一个整形数组中，每个数字都出现两次，只有一个数字出现一次，找出这个数字
	 *@param $arr array $arrTwo = [8,9,4,4,9,8,56];
	 *@return int
	 */
	public static function getNumberForTwo($arr)
	{
		$tmp = 0;
		$len = count(self::$arrTwo);

		for ($i=0; $i < $len; $i++) { 
			$tmp ^= self::$arrTwo[$i];
		}
		return $tmp;
	}

	/**
	 *一个整形数组中，每个数字都出现三次，只有一个数字出现一次，找出这个数字
	 *@param $arr array $arrTwo = [118,118,118,9,9,9,1,1,1,67];
	 *@return int
	 */
	public static function getNumberForThr($arr)
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

	/**
	 * 如何快速寻找一个数组里最小的1000个数
	 * 思路：假设最前面的1000个数为最小的，算出这1000个数中最大的数，然后和第1001个数比较，如果这最大的数比这第1001个数大的话跳过，
	 * 如果要比这第1001个数小则将两个数交换位置，并算出新的1000个数里面的最大数，再和下一个数比较，以此类推。 代码如下：
	 * 获取最小的k个数
	 * @param  array $arr 
	 * @param  int $k   [description]
	 * @return array
	 */
	public static function getMinArray($arr, $k)
	{
		$cnt = count($arr);
		$minArray = array();
		for ($i=0; $i < $cnt; $i++) { 
			if($i < $k){
				$minArray[] = $arr[$i];
			}else{
				if ($i == $k) {
					$maxPos = self::getMaxPos($minArray);
					$max = $arr[$maxPos];
				}

				if($arr[$i] < $max){
					$max[$i] = $max;
					$maxPos = self::getMaxPos($minArray);
					$maxPos = $getMinArray[$maxPos];
				}
			}
		}
		return $minArray;
	}

	/**
	 * 获取最大的位置
	 * @param  array $arr 
	 * @return array
	 */
	private static function getMaxPos($arr)
	{
		$maxPos = 0;
		$cnt = count($arr);
		for ($i=1; $i < $cnt; $i++) { 
			if($arr[$i] > $arr[$maxPos]){
				$maxPos = $i;
			}
		}
		return $maxPos;
	}

	/**
	 *相关题目：一群猴子排成一圈，按1,2,…,n依次编号。然后从第1只开始数，数到第m只,把它踢出圈，从它后面再开始数， 再数到第m只，在把它踢出去…，如此不停的进行下去，
	 *直到最后只剩下一只猴子为止，那只猴子就叫做大王。要求编程模拟此过程，输入m、n, 输出最后那个大王的编号。
	 * 获取大王
	 * @param  int $n 
	 * @param  int $m 
	 * @return int 
	 */
	public static function getKingMonkey($n, $m)
	{
		$monkey_arr = range(1, $n);
		$i++;
		while (count($monkey_arr) > 1) {
			$i++;
			$survice = array_shift($monkey_arr);

			if ($i % $m != 0) {
				array_push($monkey_arr, $survice);
			}
		}

		return $monkey_arr[0];
	}

	/**
	 *找出有序数组中随机3个数和为0的所有情况
	 *@param $arr array
	 *@return array
	 */
	public static function getThreeSumForZero($arr)
	{
		$cnt = count($arr);
		$ret_arr = array();
		for ($i=0; $i < $cnt; $i++) { 
			$left = $i + 1;
			$right = $n - 1;
			while ($left < $right) {
				$sum = $arr[$i] + $arr[$left] + $arr[$right];
				if ($sum < 0) {
					$left++;
				}elseif($sum > 0){
					$right++;
				}else{
					$numbers = $arr[$i] . ',' . $left . ',' . $right;
					if(!in_array($numbers, $ret_arr)){
						$ret_arr[] = $numbers;
					}
					$left++;
					$right--;
				}
			}
		}
		return $ret_arr;
	}
}














