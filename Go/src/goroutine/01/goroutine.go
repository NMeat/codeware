package main

import (
	"fmt"
	"sync"
)

var (
	num = 100
	wg  sync.WaitGroup
	m   sync.Mutex
)

func demo() {
	m.Lock()
	for i := 0; i < 10; i++ {
		num = num - 1
		fmt.Println(num)
	}
	wg.Done()
	m.Unlock()
}

func main() {
	wg.Add(10)
	for i := 0; i < 10; i++ {
		go demo()
	}
	wg.Wait()
	fmt.Println(num)
	fmt.Println("程序运行结束")
}
