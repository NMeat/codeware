package demo

import (
	"encoding/json"
	"fmt"
	"testing"
)

func Test014(t *testing.T) {
	var list []int
	listStr, _ := json.Marshal(list)
	fmt.Println(string(listStr))

	list2 := make([]int, 0)
	listStr, _ = json.Marshal(list2)
	fmt.Println(string(listStr))
}
