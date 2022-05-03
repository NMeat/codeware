package Test

import (
	"fmt"
	"runtime"
	"sync"
	"testing"
)

var wg sync.WaitGroup

func Test9(t *testing.T) {
	fmt.Printf("gotroutine num:%d\n", runtime.NumGoroutine())
	threadCnt := 10
	ch := make(chan bool, 6)

	for i := 0; i < threadCnt; i++ {
		wg.Add(1)
		ch <- true
		go read(i, ch)
	}
	wg.Wait()
}

func read(i int, ch chan bool) {
	fmt.Printf("gotroutine num:%d, 线程%d \n", runtime.NumGoroutine(), i)
	<-ch
	defer wg.Done()
}
