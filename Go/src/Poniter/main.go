package main

import (
	"fmt"
	"net"
)

func main() {
	//var point *int
	//
	//fmt.Printf("%v", point)
	//
	//varInt := 9
	//
	//point = &varInt
	//
	//fmt.Printf("%v\n", point)
	//fmt.Println(*point)
	//
	//*point = 19
	//
	//fmt.Println(varInt == *point)
	//fmt.Println(varInt)
	//
	//fmt.Println()
	//Lily := class.NewPerson("Lily", 19)
	//
	//fmt.Println(Lily.Age)
	//fmt.Println(Lily.Name)
	//fmt.Println(Lily)
	//
	//user1 := &class.Person{
	//	Name: "user1",
	//	Age:  19,
	//}
	//
	//fmt.Println(user1)
	//fmt.Println(user1.Name)
	//fmt.Println(user1.Age)
	//
	//var user2 class.Person
	//user2.Name = "user2"
	//user2.Age = 19
	//fmt.Println(user2)
	//fmt.Println(user2.Age)
	//fmt.Println(user2.Name)
	//
	//user3 := new(class.Person)
	//user3.Age = 89
	//user3.Name = "User3"
	//fmt.Println(user3)
	//fmt.Println(user3.Age)
	//fmt.Println(user3.Name)
	//
	//var user4 class.Person = class.Person{Name: "user4", Age: 89}
	//fmt.Println(user4)
	//fmt.Println(user4.Age)
	//fmt.Println(user4.Name)

	//var user5 class.User
	//user5.Init("user5", 87)
	//fmt.Println(user5)
	//fmt.Println(user5.GetName())
	//
	//conJon, err := json.Marshal(user5)
	//if err == nil {
	//	fmt.Println(string(conJon))
	//	fmt.Println(conJon)
	//}

	//mapVar1 := map[string]string{
	//	"name":  "mapVar1",
	//	"index": "index1",
	//}
	//fmt.Println(mapVar1["name"])
	//
	//num := runtime.NumCPU() //本地机器的逻辑CPU个数
	//runtime.GOMAXPROCS(num) //设置可同时执行的最大CPU数，并返回先前的设置
	//fmt.Println(num)
	//
	//var v *int
	//v = new(int)
	//*v = 9
	//
	//fmt.Println(*v)

	//var slice = []interface{}{122, "Chin"}
	//
	//fmt.Println(slice[0])
	//fmt.Println(append(slice, "77888888"))
	//
	//fmt.Println(slice[0])

	//var boolVal = map[string]int{}
	//boolVal["aaa"] = 7
	//fmt.Println(boolVal["aaa"])

	//x := [3]int{1, 2, 3}
	//y := []int{1, 2, 3}
	//
	//func(arr [3]int) {
	//	arr[0] = 7
	//}(x)
	//
	//func(arr []int) {
	//	arr[0] = 7
	//}(y)
	//
	//fmt.Println(x)
	//fmt.Println(y)

	//m := map[string]string{
	//	"1": "1",
	//	"2": "2",
	//	"3": "3",
	//}
	//
	//for k, v := range m {
	//	fmt.Println(k, v)
	//}

	//ch := make(chan string, 10)
	////ch := make(chan string)
	//
	//go func() {
	//	who := "我是外卖员"
	//	food := "鸡腿"
	//	//fmt.Println(who, "送餐中……2s")
	//	//time.Sleep(time.Second * 2)
	//	//fmt.Println(who, "已送餐到门口，等待顾客开门取餐")
	//	ch <- food
	//	fmt.Println(who, "订单已送达，开始送其他单")
	//}()

	//go func() {
	//	who := "你："
	//	//fmt.Println(who, "等待外卖……")
	//	//time.Sleep(time.Second * 3)
	//	//fmt.Println(who, "磨磨唧唧开门中……3s")
	//	food := <-ch
	//	fmt.Println(who, "拿到", food, "开吃！")
	//}()
	//
	//time.Sleep(time.Second * 2)

	//printVar("hello world")
	//printVar(88888)

	//str := "hello world"
	//substr := "hello"
	//
	//index := strings.Index(str, substr)
	//
	//aa, err := fmt.Println(index)
	//if err != nil {
	//	fmt.Println("error log")
	//}
	//fmt.Println(aa)
	//fmt.Println(err)
	fmt.Println("Starting the server...")
	listener, err := net.Listen("tcp", "localhost:50000")
	if err != nil {
		fmt.Println("Error Listening", err.Error())
		return
	}

	for {
		conn, err := listener.Accept()
		if err != nil {
			fmt.Println("Error accepting", err.Error())
			return // 终止程序
		}

		go doServerStuff(conn)
	}
}

func printVar(v interface{}) {
	fmt.Println(v)
}

func doServerStuff(conn net.Conn) {
	for {
		buf := make([]byte, 512)
		len, err := conn.Read(buf)
		if err != nil {
			fmt.Println("Error reading", err.Error())
			return //终止程序
		}
		fmt.Printf("Received data: %v", string(buf[:len]))
	}
}
