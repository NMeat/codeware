package demo

import (
	"fmt"
	"github.com/PuerkitoBio/goquery"
	"log"
	"net/http"
	"testing"
)

func Test015(t *testing.T) {

	// 目标网页的URL
	url := "https://www.baidu.com" // 你可以替换为你要爬取的网页URL

	// 发起HTTP GET请求
	resp, err := http.Get(url)
	if err != nil {
		log.Fatal(err)
	}
	defer resp.Body.Close()

	// 检查HTTP响应状态码
	if resp.StatusCode != 200 {
		log.Fatalf("HTTP request failed with status code: %d", resp.StatusCode)
	}

	// 使用goquery解析HTML
	doc, err := goquery.NewDocumentFromReader(resp.Body)
	if err != nil {
		log.Fatal(err)
	}

	// 在这里，你可以使用goquery选择器来提取感兴趣的内容
	// 例如，提取网页标题
	title := doc.Find("title").Text()
	fmt.Println("网页标题:", title)

	// 提取其他信息
	// 例如，提取所有链接
	doc.Find("a").Each(func(index int, element *goquery.Selection) {
		link, _ := element.Attr("href")
		fmt.Printf("链接 %d: %s\n", index+1, link)
	})
}
