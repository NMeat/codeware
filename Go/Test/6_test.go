package Test

import (
	"fmt"
	"testing"
)

func Test6(t *testing.T) {

	m := map[string]int{
		"1": 1,
		"2": 1,
		"3": 1,
	}

	v1, ok := m["1"]
	if ok {
		fmt.Println(v1)
	} else {
		fmt.Println("v1 is not exists")
	}

	delete(m, "4")
	fmt.Println(m)

}
