package Test

import (
	"fmt"
	"sync"
	"testing"
)

type Counter struct {
	num   int
	mutex sync.Mutex
}

func (c *Counter) Count() int {
	c.mutex.Lock()
	defer c.mutex.Unlock()
	return c.num
}

func (c *Counter) Add() {
	c.mutex.Lock()
	defer c.mutex.Unlock()
	c.num++
}

func Test5(t *testing.T) {
	var counter Counter
	threadCount := 10000
	var wg sync.WaitGroup
	wg.Add(threadCount)
	for i := 0; i < threadCount; i++ {
		go func() {
			defer wg.Done()
			counter.Add()
		}()
	}
	wg.Wait()
	fmt.Println(counter.Count())
}
