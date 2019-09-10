package main

import "fmt"

//People xx
type People struct {
	name string
	age  int
}

func main() {
	// 创建结构体指针
	// peo := new(People)
	peo := &People{}        //和上面的创建方式等价
	fmt.Println(peo)        //&{ 0}
	fmt.Println(peo == nil) //false

	peo.name = "xiaoming"

	fmt.Println(peo.name) //xiaoming
	fmt.Println(peo)      //&{xiaoming 0}

	peo.age = 10
	fmt.Println(peo.age) //10
	fmt.Println(peo)     //&{xiaoming 10}

}
