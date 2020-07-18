package main

// Phone 电话接口 有打电话的功能
type Phone interface {
	call()
}

// HWPhone HW手机
type HWPhone struct {
}

func (hwPhone HWPhone) call() {
	println("我是HW手机，可拨打电话")
}

// iPhone 苹果手机
type iPhone struct {
}

func (apple iPhone) call() {
	println("我是苹果手机，可拨打电话")
}

func main() {
	// 接口是一种数据类型，它把所有具有共性的方法定义在一起，任何其它类型只要
	// 实现这些方法就是实现了这个类
	println("hello interface")

	var phone Phone
	phone = new(HWPhone)
	phone.call()

	phone = new(iPhone)
	phone.call()
}
