package main

import "fmt"

func main() {
	fmt.Println("打开连接")

	defer fmt.Println("关闭连接01")

	defer func() {
		fmt.Println("关闭连接02")
	}()

	fmt.Println("执行业务逻辑")

	defer fmt.Println("关闭连接03")
}
