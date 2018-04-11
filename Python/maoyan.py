# -*-  coding:utf-8 -*-

import requests
import re
import json
from requests.exceptions import RequestException
from multiprocessing import Pool

def get_page_html(url):
    #设置headers是猫眼加了反爬机制
    headers = {
        'user-agent': 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.181 Safari/537.36'
    }
    try:
        response = requests.get(url,headers=headers)
        if response.status_code == 200:
            return response.text
        return None  #如果页面状态码不为200，则函数终止
    except RequestException:
        return None  #如果测试代码异常，则无返回，函数结束

def parse_page_html(html):
    pattern = re.compile('<dd>.*?board-index.*?>(\d+)</i>.*?data-src="(.*?)".*?name"><a'
                         +'.*?>(.*?)</a>.*?star">(.*?)</p>.*?releasetime">(.*?)</p>'
                          +'.*?integer">(.*?)</i>.*?fraction">(.*?)</i>.*?</dd>',re.S)
    items = re.findall(pattern,html)
    for item in items:
        yield {
            'index':item[0],
            'image':item[1],
            'name':item[2],
            'actor':item[3].strip()[3:],
            'date':item[4].strip()[5:],
            'score':item[5]+item[6]

        }

def save_file(content):
    with open("detail.txt",'a',encoding='utf-8') as f:
        f.write(json.dumps(content,ensure_ascii=False)+'\n')
        f.close()



def main(offset):
    url = "http://maoyan.com/board/4?offset="  + str(offset)
    html = get_page_html(url)
    for detail in parse_page_html(html):
        save_file(detail)


if __name__ == '__main__':
    # for offset in range(10):
    #     main(offset*10)
    pool = Pool()
    pool.map(main,[i*10 for i in range(10)])
