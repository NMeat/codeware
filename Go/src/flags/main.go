package main
import (
    "flag"
    "fmt"
)

func main() {
    var flags struct {
		Client    string
		Server    string
		Cipher    string
		Key       string
		Password  string
		Keygen    int
		Socks     string
		RedirTCP  string
		RedirTCP6 string
		TCPTun    string
		UDPTun    string
		UDPSocks  bool
	}
    flag.BoolVar(&flags.UDPSocks, "u", false, "(client-only) Enable UDP support for SOCKS")
    flag.Parse()

    
    fmt.Println(flags.UDPSocks)
    fmt.Println("hello world")
}
