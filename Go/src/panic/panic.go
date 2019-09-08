package main

import (
	"fmt"
	"time"
)

func main() {
	fmt.Println("开始执行了")
	defer func() {
		// recover 只能获取当前函数内的panic
		if error := recover(); error != nil {
			fmt.Println("出现了panic, 使用recover获取信息:", error)
		}
	}()

	// 停2秒
	time.Sleep(2e9)

	panic("panic 执行了哈")
	// fmt.Println("结束了")
	// fmt.Println("开始执行了")
}
