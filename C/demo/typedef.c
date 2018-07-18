#include <stdio.h>

char (*pFun)(int);

char glFun(int a){
	printf("%d\n", a);
	return 'a';
}

int main(int argc, char const *argv[])
{
	pFun = glFun;
	(*pFun)(2);
	return 0;
}