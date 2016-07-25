# -*- coding:utf-8 -*-
import os
import sys
import urllib2
import requests
import re
from lxml import etree

def StringListSave(save_path,filename,getPageRet):
	if not os.path.exists(save_path): #如果不存在该目录
		os.mkdir(save_path) #新建文件夹
	path = save_path + '/' + filename + '.txt' //新建文件
	with open(path, "w+") as fp: #打开一个文件句柄 with可以自动处理资源的关闭
		for s in getPageRet:
			fp.write("%s\t\t%s\n" % (s[0].encode('utf-8'),s[1].encode('utf-8')))

def Page_Info(getPage):
	page_Info = re.findall(r'<div class="titleBar" id=".*?"><h2>(.*?)</h2><div class="more"><a href="(.*?)">.*?</a></div></div>',getPage,re.S)
	return page_Info

def new_Page_Info(get_new_page):
	dom = etree.HTML(get_new_page)
	new_items = dom.xpath('//tr//td/a/text()')
	new_urls  = dom.xpath('//tr//td/a/@href')
	assert(len(new_items) == len(new_urls)) #断言两个list是否相等
	return zip(new_items,new_urls)	#返回一个包含元组对的list

def Spider(url):
	i = 0
	print 'downloading',url
	#getPage = requests.get(url).content.decode('gbk')
	getPage = urllib2.urlopen(url).read().decode('gbk')
	# print getPage
	getPageRet = Page_Info(getPage)
	print getPageRet
	save_path = u'网易新闻抓取'
	filename = str(i) + '_' + u'新闻排行榜'
	StringListSave(save_path, filename,getPageRet)
	i += 1

	for item,url in getPageRet: #遍历该list
		print "downloading", url
		get_new_page = urllib2.urlopen(url).read().decode('gbk')
		get_nPageRet = new_Page_Info(get_new_page)
		filename = str(i) + '_' + item
		StringListSave(save_path,filename,get_nPageRet)
		i += 1


if __name__ == '__main__':
	print "start"
	start_url = 'http://news.163.com/rank/'
	Spider(start_url)
	print 'end'