package Test

import (
	"bufio"
	"fmt"
	"net"
	"testing"
)

func Process(conn net.Conn) {
	defer conn.Close()
	for {
		reader := bufio.NewReader(conn)
		var buf [128]byte
		n, err := reader.Read(buf[:])
		if err != nil {
			fmt.Println("read from client failed, err:", err)
			break
		}

		revStr := string(buf[:n])
		fmt.Println("收到client端发来的数据:", revStr)
		conn.Write([]byte(revStr))
	}
}

func Test3(t *testing.T) {
	listen, err := net.Listen("tcp", "127.0.0.1:20000")

	if err != nil {
		fmt.Println("listen failed, err:", err)
		return
	}

	for {
		conn, err := listen.Accept()
		if err != nil {
			fmt.Println("accept failed, err:", err)
			continue
		}
		go Process(conn)
	}
}
