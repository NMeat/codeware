package main

import "fmt"

func main() {

	// 两个协程间通信
	ch := make(chan string)
	// 数据同步
	ch2 := make(chan int)
	go func() {
		ch <- "传送给另外一个协程的数据"
		ch2 <- 1
	}()

	go func() {
		content := <-ch
		println("取出数据成功:", content)
		// ch2 <- 2
	}()
	<-ch2
	// <-ch2
	fmt.Println("程序执行结束")
}
