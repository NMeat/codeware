package main

import "os"

/*
Example 1:

Input: 123
Output: 321
Example 2:

Input: -123
Output: -321
Example 3:

Input: 120
Output: 21

给出一个 32 位的有符号整数，你需要将这个整数中每位上的数字进行反转。
注意:假设我们的环境只能存储得下 32 位的有符号整数，则其数值范围为 [−2^31,  2^31 − 1]。
请根据这个假设，如果反转后整数溢出那么就返回 0。
*/

// Reverse 功能函数
func Reverse(x int) int {
	tmp := 0
	for x != 0 {
		tmp = tmp*10 + x%10
		x = x / 10
		println(tmp, x)
	}

	if tmp > 1<<31-1 || tmp < -(1<<31) {
		return 0
	}

	return tmp
}

func main() {
	println(Reverse(657)) // 756
	os.Exit(0)
	println(Reverse(656))  // 656
	println(Reverse(-780)) // -87
}
