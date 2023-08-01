package demo

import (
	"fmt"
	"testing"
	"unsafe"
)

type Animal interface {
	Move() string
}

type Dog struct {
}

func (d Dog) Eat() string {
	return "Dog is eating"
}

func (d Dog) Move() string {
	return fmt.Sprintf("狗会跑了")
}

func Test02(t *testing.T) {
	dog := new(Dog)
	fmt.Println(dog.Move())
	fmt.Printf("%T\n", dog)

	var dog2 Dog
	fmt.Println(dog2.Move())
	fmt.Printf("%T\n", dog2)

	var e struct{}
	fmt.Println(e) // 匿名结构体
	fmt.Println(unsafe.Sizeof(e))
}
