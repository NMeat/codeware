#-*- coding: UTF-8 -*-
from functools import reduce

def power(x):
	return x * x;

res = power(5)

#print(res)



#-------------python reduce---------------
a,b = 2,1
arr = []

num = int(input('请输入要计算的项数:'))
for i in range(num):
	arr.append(a/b)
	a,b = b,a+b

#print(num,a,b)

print(reduce(lambda x,y:x+y,arr))

#-------------python reduce---------------

