package main

import (
	"fmt"
	"reflect"
)

func main() {
	// 切片初始化 通过数组初始化
	// 未初始化之前默认为 nil，长度为 0
	// var identifier []type
	// var slice1 []type = make([]type, len)
	// slice1 := make([]type, len)

	var myArray [10]int = [10]int{1, 2, 3, 4, 5, 6, 7, 8, 9, 10}
	var mySlice []int = myArray[:5]

	println(mySlice)                 // [5/10]0xc00009aef8
	println(reflect.TypeOf(mySlice)) // (0x10b8040,0x1081c40)

	// 通过make方法初始化切片  make([]T, length, capacity)
	// len 是数组的长度并且也是切片的初始长度
	// 容量，其中capacity为可选参数
	slice1 := make([]int, 5, 10)

	println(slice1) // [5/10]0xc00009aef8

	slice2 := []int{1, 2, 3, 4, 5}
	fmt.Println(slice2) // [1 2 3 4 5]

	// 函数append是Go专门为切片增加元素而提供的一个内建函数。
	// 内建的append可以接收任何类型的切片，但是Go语言中却没有C++中的泛型，所以，这需要编译器的支持。
	slice2 = append(slice2, 6)
	fmt.Println(slice2) // [1 2 3 4 5 6]

	fmt.Println(slice2[0]) // 1
	fmt.Println(slice2[1]) // 2

	// 打印子切片从索引1(包含) 到索引4(不包含)
	fmt.Println(slice2[1:4]) // [2 3 4]
	fmt.Println(slice2[:3])  // [1 2 3]
	fmt.Println(slice2[3:])  // [4 5 6]

	// 遍历切片 两种办法
	// for i := 0; i < len(slice2); i++ {
	// 	fmt.Println(slice2[i])
	// }

	// for k, v := range slice2 {
	// 	fmt.Println(k, v)
	// }
}
