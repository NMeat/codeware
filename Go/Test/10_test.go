package Test

import (
	"fmt"
	"runtime"
	"sync"
	"testing"
)

var wg10 sync.WaitGroup

func Test10(t *testing.T) {
	fmt.Printf("用户线程数%d\n", runtime.NumGoroutine())
	//theadCnt := 10
	ch := make(chan bool)

	for i := 0; i < 10; i++ {
		wg10.Add(1)
		ch <- true
	}
	for i := 0; i < 3; i++ {
		go read10(ch, i)
	}
	wg10.Wait()
}

func read10(ch chan bool, i int) {
	for _ = range ch {
		fmt.Printf("用户线程数%d, go func %d\n", runtime.NumGoroutine(), i)
		wg10.Done()
	}
}
