package main

func main() {
	println("hello 类型转换")

	var sum int = 9
	count := 78
	var mean float32

	mean = float32(sum) / float32(count)

	println(sum, count, mean) // 9 78 +1.153846e-001
}
