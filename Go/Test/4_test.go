package Test

import (
	"fmt"
	"sync"
	"testing"
)

func Test4(t *testing.T) {
	var mutex sync.Mutex
	num := 0
	var wg sync.WaitGroup
	threadCount := 100000
	wg.Add(threadCount)
	for i := 0; i < threadCount; i++ {
		go func() {
			defer func() {
				wg.Done()
				mutex.Unlock()
			}()
			mutex.Lock()
			num++
		}()
	}

	wg.Wait()
	fmt.Println(num)
}
