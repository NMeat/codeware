package person

import "fmt"

// Person 结构体
type Person struct {
	Name string
	Age  int
	Sex  string
}

// People 结构体
type People struct {
	name string
	age  int
	sex  string
}

// Live 接口 interface是一种类型
type Live interface {
	Run(run int)
	Eat()
}

//Run xx
func (p *People) Run(num int) {
	fmt.Println(p.GetName(), "正在跑步，跑了", num, "米")
}

// Eat 正在吃饭
func (p *People) Eat() {
	fmt.Println(p.GetName(), "已经跑完步了，正在吃饭")
}

// SetName 设置name
func (p *People) SetName(name string) {
	p.name = name
}

//GetName XS
func (p *People) GetName() string {
	return p.name
}

// SetAge 设置age
func (p *People) SetAge(age int) {
	if age < 0 || age > 100 {
		age = 0
	}
	p.age = age
}

// GetAge xx
func (p *People) GetAge() int {
	return p.age
}

//SetSex 设置sex
func (p *People) SetSex(sex string) {
	p.sex = sex
}

// GetSex xx
func (p *People) GetSex() string {
	return p.sex
}
