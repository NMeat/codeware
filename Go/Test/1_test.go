package Test

import (
	"fmt"
	"testing"
	"time"
)

func Test1(t *testing.T) {
	fmt.Println("hello world")
	var i int
	f := func() {
		time.Sleep(time.Second * 1)
		i++
		fmt.Printf("i:%d\n", i)
	}

	f()
	f()
	fmt.Println(i)
}
