package main

import (
	"fmt"
	"l_package/person"
	"l_package/utils" //绝对路径
	"l_package/utils/timeutils"
	// "./utils" //相对路径
)

func main() {
	utils.Count()
	timeutils.PrintTime()
	p1 := person.Person{Name: "王二狗", Age: 30, Sex: "男"}
	fmt.Println(p1.Name, p1.Age, p1.Sex)
	// p2 := person.People{Name: "王二狗", Age: 30, Sex: "男"}
	// fmt.Println(p2.Name, p2.Age, p2.Sex)
	p2 := new(person.People)
	p2.SetName("张三")
	fmt.Println(p2.GetName())
	p2.SetAge(500)
	if p2.GetAge() == 0 {
		fmt.Println("年龄设置不正确")
	} else {
		fmt.Println(p2.GetAge())
	}

	p2.Run(888)
	p2.Eat()

	var live person.Live
	live = p2
	live.Run(777)
	live.Eat()

	fmt.Println("---------------------------------以下是指针")
	a := new(int)
	fmt.Println(a) //0xc000098018
	*a = 34
	fmt.Println(*a)

	var c = 99     //声明一个c变量
	var b *int     //声明一个int型指针变量b 并没有在内存中开辟空间
	fmt.Println(b) //nil
	b = &c
	*b = 99

	fmt.Println(b)  //0xc0000c0028
	fmt.Println(&c) //0xc00001a0d8
	fmt.Println(*b) //99
	fmt.Println(c)  //99
	fmt.Println(c == *b)

	// fmt.Println("---------------------------------以下是数组")

	var i interface{} = 456
	result, ok := i.(int)
	fmt.Println(result, ok)
	fmt.Printf("%T", result)
}
