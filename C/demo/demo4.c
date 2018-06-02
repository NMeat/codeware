#include "stdio.h"

main()
{
	int a;
	a = 10;
	int *b;
	b = &a;
	*b = 20;
	int c = *b;
	printf("b:%d; a:%d, c %d \n", b, a, c);

	printf("hello world\n");
	return 0;
}
