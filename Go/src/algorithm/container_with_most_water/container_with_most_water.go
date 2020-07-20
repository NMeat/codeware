package main

import (
	"fmt"
	"reflect"
)

/*
Input: [1,8,6,2,5,4,8,3,7]
Output: 49
给出一个非负整数数组 a1，a2，a3，…… an，
每个整数标识一个竖立在坐标轴 x 位置的一堵高度为 ai 的墙，选择两堵墙，和 x 轴构成的容器可以容纳最多的水。
*/

func maxArea(height []int) int {
	max, start, end := 0, 0, len(height)-1
	for start < end {
		width := end - start
		high := 0
		if height[start] < height[end] {
			high = height[start]
			start++
		} else {
			high = height[end]
			end--
		}

		temp := width * high
		if temp > max {
			max = temp
		}
	}
	return max
}

func main() {
	arrs := []int{6, 7, 8, 2, 4, 7, 4}

	fmt.Println(reflect.TypeOf(arrs)) // []int
	println(maxArea(arrs))            // 30
}
