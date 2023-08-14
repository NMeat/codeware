package demo

import (
	"fmt"
	"testing"
	"time"
)

func Test011(t *testing.T) {
	data := make(map[int]int, 10)

	for i := 0; i < 10; i++ {
		data[i] = i
	}

	for k, v := range data {
		//fmt.Println(k, v)
		go func(k, v int) {
			fmt.Println(k, v)
		}(k, v)
	}

	time.Sleep(time.Second * 1)
}
