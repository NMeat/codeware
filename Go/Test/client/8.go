package main

import (
	"Test/service"
	"context"
	"google.golang.org/grpc"
	"google.golang.org/grpc/credentials/insecure"
	"log"
	"os"
	"time"
)

func main() {
	conn, err := grpc.Dial("localhost:8080", grpc.WithTransportCredentials(insecure.NewCredentials()))
	if err != nil {
		log.Fatalf("did not connect:%v", err)
	}

	defer conn.Close()

	c := service.NewGreeterClient(conn)
	name := "7192"
	if len(os.Args) > 1 {
		name = os.Args[1]
	}

	ctx, cancel := context.WithTimeout(context.Background(), time.Second*5)
	defer cancel()

	r, err := c.SayHello(ctx, &service.HelloRequest{Name: name})
	if err != nil {
		log.Fatalf("could not greet: %v", err)
	}

	log.Println(r.GetMessage())
}
