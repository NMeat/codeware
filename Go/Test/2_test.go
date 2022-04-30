package Test

import (
	"fmt"
	"testing"
)

type Info struct {
	result int
}

func Work() (int, error) {
	return 3, nil
}

func Test2(t *testing.T) {
	var data Info
	var err error
	data.result, err = Work()

	if err != nil {
		fmt.Println(err)
		return
	}

	fmt.Printf("info:%+v", data)
}
