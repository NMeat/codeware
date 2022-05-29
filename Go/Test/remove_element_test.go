package Test

import (
	"fmt"
	"testing"
)

func TestRemoveElement(t *testing.T) {
	nums := []int{6, 7, 3, 2, 6, 74, 39, 0, -2}
	target := 6
	fmt.Printf("nums:%+v\n", removeElement(nums, target))
	fmt.Println(nums)
}

func removeElement(nums []int, target int) int {
	if len(nums) == 0 {
		return 0
	}

	slow := 0
	for fast := 0; fast < len(nums); fast++ {
		if nums[fast] != target {
			nums[slow] = nums[fast]
			slow++
		}
	}

	return slow
}

func Example_GetScore() {
	score := []int{100, 100, 100}
	fmt.Println(score)

	// Output:
	// 31.1
}
