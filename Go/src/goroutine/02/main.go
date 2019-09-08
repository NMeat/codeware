package main

import "fmt"

func main() {

	ch := make(chan int)

	go func() {
		fmt.Println("执行")
		fmt.Println("结束")
		ch <- 998
	}()

	a := <-ch
	fmt.Println(a)
	fmt.Println("执行结束")
}
