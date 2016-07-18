#!/usr/bin/env python
#-*- encoding:utf-8 -*-
"""
	使用多线程爬豆瓣Top前250的电影
"""
import urllib2,re,string
import threading,Queue,time
import sys

reload(sys)
sys.setdefaultencoding('utf-8')
_DATA = []
FILE_LOCK = threading.Lock()
SHARE_Q = Queue.Queue()   #一个不限制大小的队列
_WORKER_THREAD_NUM = 3    #设置线程的个数

class MyThread(threading.Thread):
	
	def __init__(self,func):
		super(MyThread,self).__init__() #调用父类的构造函数
		self.func = func

	def run(self):
		self.func()

def worker():
	global SHARE_Q
	while not SHARE_Q.empty():
		url = SHARE_Q.get()
		my_page = get_page(url)
		find_title(my_page)
		time.sleep(1)
		SHARE_Q.task_done()

def get_page(url):
	try:
		my_page = urllib2.urlopen(url).read().decode('utf-8')
	except urllib.URLError,e:
		if hasattr(e,'code'):
			print "The server couldn't fulfill the request"
			print "Error code : %s" % e.code
		if hasattr(e,'reason'):
			print "We failed to reach a server, Please check your url and read the Reason"
			print "Reason: %s" % e.readon
	return my_page

def find_title(my_page):
	temp_data = []
	movie_item = re.findall(r'<span.*?class="title">(.*?)</span>', my_page, re.S)
	for index,item in enumerate(movie_item):
		if item.find("&nbsp") == -1 :
			temp_data.append(item)
	_DATA.append(temp_data)

def main():
	global SHARE_Q
	threads = []
	douban_url = "http://movie.douban.com/top250?start={page}&filter=&type="
	for index in xrange(10):
		SHARE_Q.put(douban_url.format(page = index * 25))
	for i in xrange(3):
		thread = MyThread(worker)
		thread.start()
		threads.append(thread)
	for thread in threads:
		thread.join()
	SHARE_Q.join()

	with open("movie.txt", "w+") as my_file:
		for page in _DATA:
			for movie_name in page:
				my_file.write(movie_name + "\n")
	print "Spider Successfull"

if __name__ == '__main__':
	main()
