package demo

import "testing"

// 接口的嵌套
type Reader interface {
	Read()
}

type Writer interface {
	Write()
}

type ReadWriter interface {
	Reader
	Writer
	Close()
}

type Bike struct {
}

func (b *Bike) Read() {
	//TODO implement me
	panic("implement me")
}

func (b *Bike) Write() {
	//TODO implement me
	panic("implement me")
}

func (b *Bike) Close() {
	panic("implement me")
}

func Test006(t *testing.T) {
	var rw ReadWriter
	bike := Bike{}

	rw = &bike
	//bike.Close()
	rw.Close()
}
