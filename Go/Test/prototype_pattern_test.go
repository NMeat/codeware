package Test

import (
	"bytes"
	"encoding/gob"
	"fmt"
	"testing"
)

type CPU struct {
	Name string
}

type ROM struct {
	Name string
}

type Disk struct {
	Name string
}

type Computer struct {
	Cpu  CPU
	Rom  ROM
	Disk Disk
}

// 浅拷贝
func (c *Computer) Clone() *Computer {
	resume := *c
	//fmt.Println(*c)
	return &resume
}

func (c *Computer) BackUp() *Computer {
	pc := new(Computer)
	if err := DeepCopy(pc, c); err != nil {
		panic(err.Error())
	}
	return pc
}

//  深拷贝
func DeepCopy(dst, src interface{}) error {
	var buf bytes.Buffer
	if err := gob.NewEncoder(&buf).Encode(src); err != nil {
		return err
	}

	return gob.NewDecoder(bytes.NewBuffer(buf.Bytes())).Decode(dst)
}

func TestProtoTypePattern(t *testing.T) {
	cpu := CPU{Name: "因特尔"}
	disk := Disk{Name: "闪迪"}
	rom := ROM{Name: "不知名品牌"}

	computer := Computer{
		Cpu:  cpu,
		Disk: disk,
		Rom:  rom,
	}

	computer1 := computer.Clone()
	computer2 := computer.Clone()

	fmt.Printf("%p, CPU:%s\n", &computer, computer.Cpu)
	fmt.Printf("%p, CPU:%s\n", &computer1, computer1.Cpu)
	fmt.Printf("%p, CPU:%s\n", &computer2, computer2.Cpu)

	computer3 := computer.Clone()
	fmt.Printf("%p, CPU:%s\n", &computer3, computer3.Cpu)

	computer4 := computer.Clone()
	fmt.Printf("%p, CPU:%s\n", &computer4, computer4.Cpu)
}
