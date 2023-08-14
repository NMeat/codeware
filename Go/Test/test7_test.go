package demo

import (
	"fmt"
	"testing"
)

// map channel slice是引用类型 当参数传入时是引用传递
func Cart(cart map[string]int) map[string]int {
	cart["电脑"] = 2000
	cart["鼠标"] = 200
	cart["键盘"] = 20
	return cart
}

func Test007(t *testing.T) {
	m := make(map[string]int)
	m["数据线"] = 2
	Cart(m)
	fmt.Println(m)

	lgA := []string{"C++", "JavaScript", "Python", "PHP"}
	fmt.Println("添加前：", lgA)
	AddItem(lgA)
	fmt.Println("添加后：", lgA)

	a := []int{7, 8, 9}
	fmt.Printf("len: %d cap:%d data:%+v\n", len(a), cap(a), a)
	ap(a)
	fmt.Printf("len: %d cap:%d data:%+v\n", len(a), cap(a), a)

}

func ap(a []int) {
	a[0] = 1
	a = append(a, 10)
}

func AddItem(lgB []string) {
	lgB = append(lgB, "Rust")
	fmt.Println("Add函数内:", lgB)
}
