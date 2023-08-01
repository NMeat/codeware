package demo

import (
	"fmt"
	"math/rand"
	"net/http"
	"strconv"
	"time"
)

func getUrl(i int) error {

	num := rand.Intn(100)
	time.Sleep(time.Second * time.Duration(num))

	resp, err := http.Get("http://www.wenxuefen.com/")
	if err != nil {
		fmt.Println(err.Error())
		return err
	}

	if resp.StatusCode == 200 {
		fmt.Println("请求成功了" + strconv.Itoa(i))
	}

	defer resp.Body.Close()
	return nil
}

func main() {

	//getUrl(1)
	for i := 0; i < 100; i++ {
		go getUrl(i)
	}
	select {}
}
