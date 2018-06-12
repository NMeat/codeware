#include <stdio.h>

int main(int argc, char const *argv[])
{
	int a[10] = {1,2,3,4};
	int *p = a;

	for (int i = 0; i < 10; ++i)
	{
		*p = i;
		// printf("%d\n", a[i]);
		p++;
	}

	// return 0;
	for (int i = 0; i < 10; ++i)
	{
		// printf("%d\n", i);
		printf("%d\n", a[i]);
	}

	int* p1 = &a[2];
	int* p2 = &a[5];

	printf("\n");

	printf("%ld\n", p2 - p1);
	printf("%d\n", *(p2+2));


	int b = 20;
	int* p3 = &b;

	int** p4= &p3;

	**p4 = 100;
	printf("%d\n", b);
	return 0;
}