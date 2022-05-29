package Test

import (
	"fmt"
	"sync"
	"testing"
)

type Singleton interface {
	doSomething()
}

type singleton struct {
}

func (s *singleton) doSomething() {
	//TODO implement me
	fmt.Println("do some thing")
}

var (
	once     sync.Once
	instance *singleton
)

func GetInstance() Singleton {
	once.Do(func() {
		instance = &singleton{}
	})

	return instance
}

func Test11(t *testing.T) {
	fmt.Printf("指定地址%p\n", GetInstance())
	fmt.Printf("指定地址%p\n", GetInstance())

	fmt.Println(GetInstance() == GetInstance())
}
