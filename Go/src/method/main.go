package main

import "fmt"

//People xx
type People struct {
	name   string
	age    int
	weight int
}

func (p *People) run() {
	fmt.Println(p.name, "正在跑步，跑的很快", p.age, p.weight)
	p.weight -= 10
}

func main() {
	peo := People{"张三", 87, 88}
	peo.run()
	fmt.Println(peo.weight)
}
