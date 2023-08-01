package demo

import (
	"context"
	"fmt"
	"testing"
	"time"
)

func TestTest1(t *testing.T) {
	ctx, cancel := context.WithCancel(context.Background())

	ch := func(ctx context.Context) <-chan int {
		ch := make(chan int)
		go func() {
			for i := 0; ; i++ {
				select {
				case <-ctx.Done():
					fmt.Println("我要停止了")
					return
				case ch <- i:
					fmt.Printf("i = %d\n", i)
					break
				}
			}
		}()
		return ch
	}(ctx)

	for v := range ch {
		if v == 5 {
			cancel()
			break
		}
	}
	time.Sleep(time.Second * 4)
	fmt.Println("程序已要结束了")
}
