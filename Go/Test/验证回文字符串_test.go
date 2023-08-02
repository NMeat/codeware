package demo

import (
	"fmt"
	"strings"
	"testing"
)

/**
输入: s = "A man, a plan, a canal: Panama"
输出：true
解释："amanaplanacanalpanama" 是回文串。
*/
var s string = "A man, a plan, a canal: Panama"

func Test1(t *testing.T) {
	var sgood string
	for i := 0; i < len(s); i++ {
		if isalnum(s[i]) {
			sgood += string(s[i])
		}
	}

	// 大写转小写
	sgood = strings.ToLower(sgood)
	n := len(sgood)
	for i := 0; i < n/2; i++ {
		if sgood[i] != sgood[n-i-1] {
			fmt.Println("不是回文字符串")
		}
	}

	fmt.Println("是回文字符串")
	fmt.Println(sgood)
}

func isalnum(ch byte) bool {
	return (ch >= 'A' && ch <= 'Z') || (ch >= 'a' && ch <= 'z') || (ch >= '0' && ch <= '9')
}
