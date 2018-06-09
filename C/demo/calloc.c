#include <stdio.h>
#include <stdlib.h>

int main(int argc, char const *argv[])
{

	int n;

	printf("input n:>");
	scanf("%d", &n);
	printf("%d\n", n);

	//一个参数， 指定具体空间的大小

	int *p= (int*)malloc(sizeof(int) * n);

	if (NULL == p)
	{
		return 1;
	}	

	//两个参数 第一个参数是个数 第二个参数是每个的大小
	int *cp = (int*)calloc(n, sizeof(int));

	for (int i = 0; i < n; ++i)
	{
		*(p + i) = i;
		printf("%d\n", *(p+i));
	}

	printf("\n");

	for (int i = 0; i < n; ++i)
	{
		*(cp + i) = i;
		printf("%d\n", *(cp + i));
	}

	free(p);
	free(cp);
	return 0;
}