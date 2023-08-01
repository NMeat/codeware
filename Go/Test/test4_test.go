package demo

import (
	"fmt"
	"testing"
	"time"
)

func Test04(t *testing.T) {

	ch := make(chan struct{})

	go func() {
		fmt.Println("工作中----")
		time.Sleep(3 * time.Second)

		close(ch)
	}()

	<-ch
	fmt.Println("已经收到了退出信号，退出中.....")
}
