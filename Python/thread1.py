#encoding=utf-8
import threading
from time import ctime,sleep

def super_player(file,time):
	for i in range(2):
		print 'Start playing: %s! %s' %(file,ctime());
		sleep(time);
#歌曲字典
list = {'爱情买卖.mp5':3,'阿凡达.mp4':4,'我和你':5};

#创建线程
threads = [];
for file,time in list.items():
	t = threading.Thread(target=super_player,args=(file,time))
	threads.append(t)

files = range(len(list));
if __name__ == '__main__':
	#启动线程
	for i in files:
		threads[i].start();
	for i in files:
		threads[i].join();
print 'end : %s' %ctime();


