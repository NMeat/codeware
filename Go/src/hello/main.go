package main

import (
	"fmt"
)

func returnValues() int {
	var result int
	defer func() {
		result++
		fmt.Println("defer")
	}()
	return result
}

func namedReturnValues() (result int) {
	defer func() {
		result++
		fmt.Println("defer")
	}()
	return result
}

// NAME 名字
const NAME string = "GOLANG"

type demo1 struct {
	name string
	age  int
}

// ArrayStruct xxxx
type ArrayStruct struct {
	value [10]int
}

// SliceStruct xxxx
type SliceStruct struct {
	value []int
}

type Sort interface {
	BubbleSort() []int
}

type ArrayObj struct {
	Array []int
}

func (array ArrayObj) BubbleSort() []int {
	// 验证数组是否为空
	if len(array.Array) == 0 {
		fmt.Println("array is empty")
	}
	var i, j, length int
	length = len(array.Array)
	for i = 0; i < length; i++ {
		for j = 1; j < length-i; j++ {
			if array.Array[j] < array.Array[j-1] {
				array.Array[j], array.Array[j-1] = array.Array[j-1], array.Array[j]
			}
		}
	}
	fmt.Println(array.Array)
	return array.Array
}

func main() {
	var arr ArrayObj
	arr.Array = []int{19, 32, 23, 4, 89, 338, 7, 8, 9, 108}
	arr.BubbleSort()
	// nums := []int{2, 3, 4}
	// sum := 0
	// for i, num := range nums {
	// 	sum += num
	// 	fmt.Println(i)
	// }

	// fmt.Println(sum)

	// fmt.Println("hello world go")
	// var a = 18
	// var b = 12
	// var c int
	// c = a + b
	// fmt.Println(c)

	// defer func() {
	// 	fmt.Println("1")
	// }()
	// defer func() {
	// 	fmt.Println("2")
	// }()
	// defer func() {
	// 	fmt.Println("3")
	// }()

	// var a = returnValues()
	// var b = namedReturnValues()
	// const NAME string = "PHP"
	// fmt.Println(a, b)
	// fmt.Println(NAME)

	// var s1 = make([]int, 5, 8)
	// s2 := make([]int, 8)
	// fmt.Println(s1)
	// fmt.Println(s2)

	// s := []int{1, 2, 3, 4, 5} // 满容的
	// fmt.Println(s, len(s), cap(s))

	// var demoVar = demo1{
	// 	name: "test",
	// 	age:  12,
	// }

	// fmt.Println(demoVar)
	// fmt.Println(demoVar.age)
	// fmt.Println(demoVar.name)

	// var demoVar1 = demo1{}
	// fmt.Println(demoVar1)
	// demoVar1.age = 13
	// fmt.Println(demoVar1.age)

	// var as = ArrayStruct{[...]int{0, 1, 2, 3, 4, 5, 6, 7, 8, 9}}
	// var ss = SliceStruct{[]int{0, 1, 2, 3, 4, 5, 6, 7, 8, 9}}
	// fmt.Println(unsafe.Sizeof(as), unsafe.Sizeof(ss))

	// 创建一个bool的chan
	// chann := make(chan bool)
	// go func() {
	// 	fmt.Println("匿名函数")
	// 	chann <- true
	// }()
	// <-chann

	// fmt.Println(runtime.NumCPU())

	// runtime.GOMAXPROCS(runtime.NumCPU()) // 设置线程数为当前计算机的CPU数
	// chann := make(chan int, 10)
	// for i := 0; i < 10; i++ {
	// 	go Go(chann, i)
	// }

	// for i := 0; i < 10; i++ {
	// 	<-chann
	// }

	// var p Person = Student{20, "Elon", 78.89}
	// fmt.Println("This person name is", p.GetName())
	// fmt.Println("This person age is", p.GetAge())
	// fmt.Println("This person score is", p.GetScore())

	// var c Car = Student{1, "BMW", 78.56}
	// fmt.Println("This car name is", c.GetName())
	// fmt.Println("This car age is", c.GetAge())

	// var i interface{} = 10
	// t1 := i.(int)
	// fmt.Println(t1)

	// c1 := make(chan string, 1)
	// c2 := make(chan string, 1)

	// c2 <- "hello"
	// c1 <- "world"

	// // 在运行 select 时，会遍历所有（如果有机会的话）的 case 表达式，只要有一个信道有接收到数据，那么 select 就结束，所以输出如下
	// select {
	// case msg1 := <-c1:
	// 	fmt.Println("c1 received: ", msg1)
	// case msg2 := <-c2:
	// 	fmt.Println("c2 received: ", msg2)
	// default:
	// 	fmt.Println("No data received.")
	// }
}

// func Go(chann chan int, index int) {
// 	a := 1
// 	for i := 0; i < 1000000000; i++ {
// 		a++
// 	}
// 	fmt.Println(index, a)
// 	chann <- index
// }

// type Person interface {
// 	GetAge() int
// 	GetName() string
// 	GetScore() float32
// }

// type Car interface {
// 	GetAge() int
// 	GetName() string
// }

type Student struct {
	age   int
	name  string
	score float32
}

func (s Student) GetAge() int {
	return s.age
}

func (s Student) GetName() string {
	return s.name
}

func (s Student) GetScore() float32 {
	return s.score
}
