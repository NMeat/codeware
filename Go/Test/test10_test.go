package demo

import (
	"errors"
	"fmt"
	"testing"
)

type Reason int

func (r Reason) String() string {
	return "555"
}

const (
	SPRING Reason = iota + 1
	SUMMER
	AUTUMN
	WINTER
)

func Test10(t *testing.T) {
	fmt.Println(SPRING)
	fmt.Println(SUMMER)
	fmt.Println(AUTUMN)
	fmt.Println(WINTER)

	var err = errors.New("not Found")
	fmt.Println(err)
}
