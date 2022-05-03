package main

import (
	pb "Test/service"
	"context"
	"google.golang.org/grpc"
	"log"
	"net"
)

type Server struct {
	pb.UnimplementedGreeterServer
}

func (s *Server) SayHello(ctx context.Context, in *pb.HelloRequest) (*pb.HelloReply, error) {
	log.Printf("Received; %v", in.GetName())
	msg := in.GetName() + " say hello for gRPC"
	reply := &pb.HelloReply{
		Message: msg,
	}
	return reply, nil
}

func main() {
	lis, err := net.Listen("tcp", ":8080")
	if err != nil {
		log.Fatalf("failed to listen: %v", err)
	}

	srv := grpc.NewServer()
	pb.RegisterGreeterServer(srv, &Server{})

	log.Println("gRPC server is running ...")

	if err := srv.Serve(lis); err != nil {
		log.Fatalf("failed to serve:%v", err)
	}
}
