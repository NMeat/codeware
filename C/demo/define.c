#include <stdio.h>

#define CHAR1 char*  //定义一个CHAR1宏

typedef char* CHAR2; //注意这里有个;号


int main(int argc, char const *argv[])
{
	char c = 'c';

	CHAR1 pc1, pc2;//pc1是指针 pc2是char类型声明

	pc1 = &c;
	pc2 = c;

	*pc1 = 'w'; //改变pc1指针指向内存存的值

	printf("%c\n", c);

	CHAR2 pc3, pc4; //pc3 pc4都是指针

	pc3 = pc4 = &c;

	*pc4 = 'x';

	printf("%c\n", c);

	return 0;
}