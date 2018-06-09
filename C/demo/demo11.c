#include <stdio.h>

int max(int a, int b)
{
	return a > b ? a : b;
}

int min(int a, int b)
{
	return a > b ? b : a;
}

int exe(int a, int b, int (*pf)(int, int))
{
	return (*pf)(a, b);
}

int main(int argc, char const *argv[])
{
	int a = 30;
	int b = 50;


	//返回值 函数指针 参数列表
	int (*pfun)(int, int);

	pfun = &max;
	int result = (*pfun)(a, b);
	printf("%d\n", result);

	pfun = max;
	result = (*pfun)(a, b);
	printf("%d\n", result);

	//把函数指针作为函数的参数

	int i;
	int (*pf)(int, int);
	scanf("%d", &i);

	if (i)
	{
		pf = max;
	}else{
		pf = min;
	}

	result = exe(a, b, pf);

	printf("%d\n", result);
	return 0;
}