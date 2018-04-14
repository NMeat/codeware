#-*- coding: UTF-8 -*-
import urllib
import urllib.request
import re

url = "http://www.baidu.com"
data = urllib.request.urlopen(url).read()
data = data.decode('UTF-8')

#----------我是分隔线-----------


data={}  #我是一个字典
data['word'] = 'python spider'

url_values = urllib.parse.urlencode(data)

url="http://www.baidu.com/s?"

full_url = url + url_values
print(full_url)
exit()

reponse_data = urllib.request.urlopen(full_url).read().decode('UTF-8')

#print(reponse_data)







