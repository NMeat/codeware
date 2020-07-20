package main

// 引用包
import (
	"fmt"
	"reflect"
	"sort"
)

func main() {
	// 数组的特性
	// 数组是值类型。将一个数组赋值给另一个，会拷贝所有的元素
	// 如果你给函数传递一个数组，其将收到一个数组的拷贝，而不是它的指针
	// 数组的大小是其类型的一部分，类型[10]int和[20]int是不同的。数组长度在声明后，就不可更改

	// 初始化数组
	var balance [3]float32
	balance[0] = 7.8
	balance[1] = 7.8
	balance[2] = 7.8
	fmt.Println(balance) //[7.8 7.8 7.8]

	var balance2 = [5]int{1, 2, 3, 4, 5}
	fmt.Println(balance2) //[1 2 3 4 5]

	var balance3 = [...]int{1, 2, 3, 4, 5, 6, 7, 8}
	fmt.Println(balance3) //[1 2 3 4 5 6 7 8]

	// 指定索引的值
	var balance4 = [5]int{2: 1, 3: 2, 4: 3}
	fmt.Println(balance4) //[0 0 1 2 3]

	// 二维数组
	var balance5 = [5][2]int{{1, 2}, {2, 3}}
	fmt.Println(balance5)       //[[1 2] [2 3] [0 0] [0 0] [0 0]]
	fmt.Println(balance5[0][1]) // 2

	intList := []int{2, 4, 3, 5, 7, 6, 9, 8, 1, 0}
	float8List := []float64{4.2, 5.9, 12.3, 10.0, 50.4, 99.9, 31.4, 27.81828, 3.14}
	stringList := []string{"a", "c", "b", "d", "f", "i", "z", "x", "w", "y"}

	// 数组的排序，默认是从小到大排列
	sort.Ints(intList)
	sort.Float64s(float8List)
	sort.Strings(stringList)

	fmt.Printf("%v\n", intList)    // [0 1 2 3 4 5 6 7 8 9]
	fmt.Printf("%v\n", float8List) // [3.14 4.2 5.9 10 12.3 27.81828 31.4 50.4 99.9]
	fmt.Printf("%v\n", stringList) // [a b c d f i w x y z]

	// 数组的长度
	fmt.Println(len(intList))    // 10
	fmt.Println(len(float8List)) // 9
	fmt.Println(len(stringList)) // 10

	// 打印数据类型
	fmt.Println(reflect.TypeOf(intList))    // []int
	fmt.Println(reflect.TypeOf(float8List)) // []float64
	fmt.Println(reflect.TypeOf(stringList)) // []string

	// 遍历数组
	for i := 0; i < len(intList); i++ {
		fmt.Println(intList[i])
	}

	for k, v := range intList {
		println(k, v)
	}

	for _, v := range intList {
		println(v)
	}
}
