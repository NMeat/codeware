#include "stdio.h"

main()
{
	int a;
	a = 10;
	int *b;
	b = &a;
	*b = 20;
	int c = *b;
	printf("b:%d; a:%d, c %d", b, a, c);
	return 0;
}
