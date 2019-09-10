package main

import (
	"fmt"
	"net/http"
)

func welcome(w http.ResponseWriter, r *http.Request) {
	w.Header().Set("Content-Type", "text/html;charset=utf-8")
	fmt.Fprintln(w, "服务器返回信息<b>加粗</b>")
}

func main() {
	http.HandleFunc("/", welcome)
	http.ListenAndServe("127.0.0.1:8081", nil)
}
