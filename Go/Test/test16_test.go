package demo

import (
	"context"
	"fmt"
	"github.com/go-redis/redis/v8"
	"testing"
)

func Test016(t *testing.T) {
	// 创建一个连接池
	pool := redis.NewClient(&redis.Options{
		Addr:     "localhost:6379",
		Password: "",
		DB:       0,
		PoolSize: 10,
	})

	defer pool.Close()
	ctx := context.Background()

	res, err := pool.Get(ctx, "name").Result()
	fmt.Println(res, err)

	err = pool.Set(ctx, "name", 89999, 0).Err()
	if err != nil {
		fmt.Println("Error setting key:", "name")
	}

	res, err = pool.Get(ctx, "name").Result()
	fmt.Println(res, err)
}
