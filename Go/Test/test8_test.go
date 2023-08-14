package demo

import (
	"fmt"
	"testing"
)

// go的闭包
func func008() func(int) int {
	sum := 0
	return func(i int) int {
		sum += i
		return sum
	}
}

func Test008(t *testing.T) {
	fun := func008()
	fmt.Println(fun(1))
	fmt.Println(fun(2))
}
