#include <stdio.h>
#include <stdlib.h>
#include <string.h>
/*
	函数指针作为某个函数的参数
	函数指针变量可以作为某个函数的参数来使用的，回调函数就是一个通过函数指针调用的函数。
*/

void populate_array(int *array, size_t arraySize, int(*getNextValue)(void))
{
	for (int i = 0; i < arraySize; ++i)
	{
		array[i] = getNextValue();
	}
}

int getNextRandomValue(void)
{
	return rand();
}

int main(int argc, char const *argv[])
{
	int myarray[10];
	populate_array(myarray, 10, getNextRandomValue);

	for (int i = 0; i < 10; ++i)
	{
		printf("%d\n", myarray[i]);
	}

	char str[20] = "hello world";

	printf("str占用的字符空间 %lu\n", sizeof(str));

	printf("%c\n", str[0]);

	for (int i = 0; i < sizeof(str); ++i)
	{
		printf("%d === %c\n", i, str[i]);
	}

	printf("str的长度%lu\n", strlen(str));
	return 0;
}



