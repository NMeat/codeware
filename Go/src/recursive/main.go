package main

// Factorial 阶乘
func Factorial(num uint64) (result uint64) {
	if num > 0 {
		result = num * Factorial(num-1)
		return result
	}

	return 1
}

// Fibonacci 斐波那契数列
func Fibonacci(num int) (result int) {
	if num < 2 {
		return num
	}
	return Fibonacci(num-2) + Fibonacci(num-1)
}

func main() {
	println("hello 递归")
	var i uint64 = 15
	var result uint64

	result = Factorial(i)
	println(result) // 1307674368000

	for num := 0; num < 5; num++ {
		println(num, "-------")
		println(Fibonacci(num))
	}
}
