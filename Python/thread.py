#encoding=utf-8
import threading
from time import ctime,sleep
def music(fun):
	for i in range(3):
		print "I was listening to %s.%s" %(fun,ctime())
		sleep(1)

def move(fun):
	for i in range(2):
		print "I was at the %s! %s" %(fun,ctime())
		sleep(5)

threads = [];
t1 = threading.Thread(target=music, args=(u'爱情买卖',));
threads.append(t1);

t2 = threading.Thread(target=move, args=(u'阿凡达',));
threads.append(t2);

if __name__ == '__main__':
	for td in threads:
		td.setDaemon(True);
		td.start();
	for td in threads:
		td.join();
	print "all over %s" %ctime()

