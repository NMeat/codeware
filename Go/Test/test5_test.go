package demo

import (
	"fmt"
	"testing"
)

func Test05(t *testing.T) {
	//sliceArr := make([]int, 10)
	sliceArr := []int{
		0, 1, 2, 3, 4, 5, 6, 7, 9,
	}

	fmt.Println(missingNumber(sliceArr))
}

func missingNumber(nums []int) int {
	if len(nums) == 0 {
		return 0
	}

	left, right := 0, len(nums)-1

	for left <= right {
		middle := (left + right) / 2
		if nums[middle] == middle {
			left = middle + 1
		} else {
			right = middle - 1
		}
	}

	return left
}
