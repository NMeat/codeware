#include <stdio.h>
#include <stdlib.h>

int main(int argc, char const *argv[])
{
	int *p = (int *)malloc(sizeof(int));

	*p = 12;

	printf("%lu\n", sizeof(p));

	printf("%d\n", *p);
	free(p);
	return 0;
}