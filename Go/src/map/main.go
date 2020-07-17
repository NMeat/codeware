package main

import "fmt"

func main() {
	/* 声明变量，默认 map 是 nil */
	// var map_variable map[key_data_type]value_data_type

	/* 使用 make 函数 */
	// map_variable := make(map[key_data_type]value_data_type)

	// 创建集合
	var countryCapitalMap map[string]string
	countryCapitalMap = make(map[string]string)

	/* map插入key - value对,各个国家对应的首都 */
	countryCapitalMap["France"] = "巴黎"
	countryCapitalMap["Italy"] = "罗马"
	countryCapitalMap["Japan"] = "东京"
	countryCapitalMap["India"] = "新德里"

	capital, ok := countryCapitalMap["American"]
	if ok {
		fmt.Println("American 的首都是", capital)
	} else {
		fmt.Println("American 的首都不存在")
	}

	// 遍历Map
	for country := range countryCapitalMap {
		println(country, "首都是", countryCapitalMap[country])
	}

	// 删除元素
	delete(countryCapitalMap, "India")

	// 遍历Map
	for country := range countryCapitalMap {
		println(country, "首都是", countryCapitalMap[country])
	}

	println(countryCapitalMap["Japan"])
}
