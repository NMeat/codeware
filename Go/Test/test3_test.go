package demo

import (
	"fmt"
	"testing"
)

// 用空结构体实现Set集合类型
type Set[K comparable] map[K]struct{}

func (s Set[K]) Add(val K) {
	s[val] = struct{}{}
}

func (s Set[K]) Remove(val K) {
	delete(s, val)
}

func (s Set[K]) Contains(val K) bool {
	_, ok := s[val]
	return ok
}

func Test03(t *testing.T) {
	set := Set[string]{}
	set.Add("lucy")
	fmt.Println(set.Contains("lucy"))
	set.Remove("lucy")
	fmt.Println(set.Contains("lucy"))
}
