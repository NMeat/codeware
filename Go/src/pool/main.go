package main

import (
	"fmt"
	"time"
)

// Pool xxxx
type Pool struct {
	work chan func()
	sem  chan struct{}
}

// NewTask xxxx
func (p *Pool) NewTask(task func()) {
	select {
	case p.work <- task:
	case p.sem <- struct{}{}:
		go p.worker(task)
	}
}

func (p *Pool) worker(task func()) {
	defer func() {
		<-p.sem
	}()

	for {
		task()
		task = <-p.work
	}
}

// New xxxx
func New(size int) *Pool {
	return &Pool{
		work: make(chan func()),
		sem:  make(chan struct{}, size),
	}
}

func main() {
	pool := New(18)

	pool.NewTask(func() {
		fmt.Println("hello world")
	})

	time.Sleep(20 * time.Second)
}
