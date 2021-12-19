package class

type User struct {
	Name string `json:"userName"`
	Age  int32  `json:"userAge"`
}

func (u *User) Init(name string, age int32) {
	u.Name = name
	u.Age = age
}

func (u User) GetName() string {
	return u.Name
}
