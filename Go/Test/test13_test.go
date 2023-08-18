package demo

import (
	"fmt"
	"testing"
)

func Test013(t *testing.T) {
	s := "{([])}"
	fmt.Println(isValid13(s)) //output:
}

func isValid13(s string) bool {
	n := len(s)

	// 奇数个一定不对称
	if n%2 == 1 {
		return false
	}

	pairs := map[byte]byte{
		'}': '{',
		']': '[',
		')': '(',
	}

	//fmt.Println('}', '{')
	//fmt.Println(pairs[128])

	var stack []byte

	for i := 0; i < n; i++ {
		//fmt.Println(i, s[i], pairs, pairs[s[i]], stack)

		if pairs[s[i]] > 0 {
			if len(stack) == 0 || stack[len(stack)-1] != pairs[s[i]] {
				return false
			}
			fmt.Println(stack, pairs[s[i]])
			stack = stack[:len(stack)-1]
		} else {
			stack = append(stack, s[i])

		}
	}

	return true
}
