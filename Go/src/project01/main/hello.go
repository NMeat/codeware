package main

import "fmt"

//Saiyan struct
type Saiyan struct {
	Name  string
	Power int
}

func main() {
	fmt.Println("hello world")
	var power int
	power = 9000
	power = getPower()

	fmt.Printf("it's over %d\n", power)

	name, age := "hello world", 67

	fmt.Printf("my name is %s, my age is %d\n", name, age)

	goku := &Saiyan{"Goku", 9000}
	Super(goku)
	fmt.Println(goku.Power)

	gokuTest := &Saiyan{"gokuTest", 8000}
	gokuTest.SuperTest()
	fmt.Println(gokuTest.Power)
}

// Super func
func Super(s *Saiyan) {
	s.Power += 10000
}

//SuperTest func *Saiyan 类型是 SuperTest 方法的接受者
func (s *Saiyan) SuperTest() {
	s.Power += 10000
}

func getPower() int {
	return 9001
}
