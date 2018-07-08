import os
import time
import requests

class maoyan():
	def __init__(self):
		self.headers = {
			'Host': '猫眼专业版-实时票房',
			'Referer': '猫眼专业版-实时票房',
			'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/57.0.2987.98 Safari/537.36 LBBROWSER',
			'X-Requested-With': 'XMLHttpRequest'
		}
		
	def get_page(self):
		url = 'https://box.maoyan.com/promovie/api/box/second.json'
		try:
			response = requests.get(url, self.headers)
			if response.status_code == 200:
				return response.json()
		except requests.ConnectionError as e:
				print('Error', e.args)

	def parse_page(self, json):
		if json:
			data = json.get('data')
			for index, item in enumerate(data.get('list')):
				self.piaofang = {}
				# 场均上座率
				self.piaofang['avgSeatView'] = item.get('avgSeatView')
				# 场均人次
				self.piaofang['avgShowView'] = item.get('avgShowView')
				# 平均票价
				self.piaofang['avgViewBox'] = item.get('avgViewBox')
				# 票房
				self.piaofang['boxInfo'] = item.get('boxInfo')
				# 票房占比
				self.piaofang['boxRate'] = item.get('boxRate')
				# 电影名称
				self.piaofang['movieName'] = item.get('movieName')
				# 上映天数
				self.piaofang['releaseInfo'] = item.get('releaseInfo')
				# 排片场次
				self.piaofang['showInfo'] = item.get('showInfo')
				# 排片占比
				self.piaofang['showRate'] = item.get('showRate')
				# 总票房
				self.piaofang['sumBoxInfo'] = item.get('sumBoxInfo')
				yield self.piaofang

if __name__ == "__main__":
	while True:
		my = maoyan()
		json = my.get_page()
		results = my.parse_page(json)
		os.system('cls')
		print(json.get('data')['updateInfo'])
		print('今日总票房: %s' % json.get('data')['totalBox']+json.get('data')['totalBoxUnit'])
		x_line = '-' * 155
		print(x_line)
		print('电影名称\t综合票房（万）\t票房占比\t场均上座率\t场均人次\t平均票价\t排片场次\t排片占比\t累积总票房\t上映天数')
		print(x_line)
		for result in results:
			print(
				result['movieName'][:7].ljust(8) + '\t' + 
				result['boxInfo'][:8].rjust(8) + '\t' + 
				result['boxRate'][:8].rjust(8) + '\t' + 
				result['avgSeatView'][:8].rjust(8) + '\t' + 
				result['avgShowView'][:8].rjust(8) + '\t' + 
				result['avgViewBox'][:8].rjust(8) + '\t' + 
				result['showInfo'][:8].rjust(8) + '\t' + 
				result['showRate'][:8].rjust(8) + '\t' + 
				result['sumBoxInfo'][:8].rjust(8) + '\t' + 
				result['releaseInfo'][:8] + 
				'\n'
				)
		time.sleep(4)