package class

type Person struct {
	Name string
	Age  int
}

// NewPerson 构造函数
func NewPerson(name string, age int) *Person {
	return &Person{Name: name, Age: age}
}
