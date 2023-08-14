package demo

import (
	"fmt"
	"testing"
)

func func009() (val int) {
	val = 10

	defer func() {
		val += 1
	}()
	// 先执行val = 10 再执行 defer 10 += 10 最后return val
	return val
}

func Test009(t *testing.T) {
	fmt.Println(func009())
	fmt.Println(func009())
}
