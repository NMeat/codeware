package main

import (
	"fmt"
	"net"
)

func main() {
	fmt.Println("Starting the server...")
	listener, err := net.Listen("tcp", "localhost:50000")
	if err != nil {
		fmt.Println("Error Listening", err.Error())
		return
	}

	for {
		conn, err := listener.Accept()
		if err != nil {
			fmt.Println("Error accepting", err.Error())
			return // 终止程序
		}

		go doServerStuff(conn)
	}
}

func doServerStuff(conn net.Conn) {
	for {
		buf := make([]byte, 512)
		len, err := conn.Read(buf)
		if err != nil {
			fmt.Println("Error reading", err.E≤rror())
			return //终止程序
		}
		fmt.Printf("Received data: %v", string(buf[:len]))
	}
}
