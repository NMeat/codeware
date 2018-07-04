#include <stdio.h>
#include <stdlib.h>

int main(int argc, char const *argv[])
{
	int i;
	scanf("%d", &i);

	double f;
	f = i * 0.6 + 36;
	printf("%6.1f", f);
	return 0;
}