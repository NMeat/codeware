package main

import (
	"fmt"
	"mymath"
)

const Pi = 3.1315926 //7777

func main() {
	// const Pi = 67.8888
	fNum := mymath.Sqrt(2)
	fmt.Printf("hello world. Sqrt(2) = %v", fNum)
	_, b := 34, 56
	fmt.Println(b)
	fmt.Println(Pi)
}
