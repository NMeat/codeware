#include <stdio.h>

#define MAX(a, b) min(a, b)
#define M x*3+x*5
#define N (x*3+x*5)


#define P printf
#define D "%d\n"
#define F "%f\n"


int min(int a, int b)
{
	return a + b;
}

int main(int argc, char const *argv[])
{
	
	int a = 9, b = 10;

	int c = MAX(a, b);
	printf("%d\n", c);

	int x = 2;

	int s = 3*M;
	int p = 3*N;

	char hello[] = "ZEND_PARSE_PARAMETERS_START_EX";
	printf("%s\n", hello);

	printf("%d\n", s);
	printf("%d\n", p);

	float f = 5.9;

	P(D F, a, f);
	return 0;
}