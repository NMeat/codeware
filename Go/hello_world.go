package main

import "fmt"

//入口函数
func main() {
    var x int; //声明一个int型的变量
    x = 10;
    var y int = 20; //声明+赋值
    z := 30;
	fmt.Println("Hello World");
    fmt.Println("x =", x);
    fmt.Println("y =", y);
    fmt.Println("z =", z);

    name, age := "hello world", 20;
    fmt.Println("name:", name, "age:", age);

    a := func() {  //匿名函数
        fmt.Println("hello world");
    }
    a();
    fmt.Printf("%T\n", a); //函数的类型
    fmt.Println(a);  //函数的地址

    msg := "hello world"
    func (m string) {
        fmt.Println(m);
    }(msg)
}
