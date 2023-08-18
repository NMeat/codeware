package demo

import (
	"fmt"
	"testing"
)

func Test012(t *testing.T) {
	// 定义普通变量并打印
	age := 18
	fmt.Println(age) //output: 18

	ptr := &age
	fmt.Println(ptr)  //output:
	fmt.Println(*ptr) //output:
}
