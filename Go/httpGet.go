package main

import (
    "fmt"
    "net/http"
    "log"
    "reflect"
    "bytes"
)

func main(){
    resp, err := http.Get("http://www.baidu.com")

    if(err != nil){
        log.Println(err)
        return
    }

    defer resp.Body.Close()

    //请求头
    headers := resp.Header

    for k, v := range headers {
        //%v 相应的默认格式
        fmt.Printf("k=%v, v=%v\n", k, v)
    }

    fmt.Printf("resp Status %s, statusCode %d\n", resp.Status, resp.StatusCode)
    fmt.Printf("resp Proto %s\n", resp.Proto)
    
    //TypeOf TypeOf用来动态获取输入参数接口中的值的类型，如果接口为空则返回nil
    fmt.Println(reflect.TypeOf(resp.Body))
    //make分配空间 第一个参数是类型，第二个参数是分配的空间，第三个参数是预留分配空间
    buf := bytes.NewBuffer(make([]byte, 0, 512))
    length, _ := buf.ReadFrom(resp.Body)
    
    fmt.Println(len(buf.Bytes()))
    fmt.Println(length)
    fmt.Println(string(buf.Bytes()))
}






