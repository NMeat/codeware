#include <stdio.h>
int b = 100;


int fun(int b)
{
	b += b;
	return b;
}

int fun2(int b)
{
	b += b;
	return b;
}

char stack[512];
int top = 0;

void push(char c)
{
	printf("%d\n", top);
	stack[top++] = c;
}

char pop(void)
{
	return stack[--top];
}

int is_empty(void)
{
	return top == 0;
}

int main(int argc, char const *argv[])
{
	
	char a[5] = {'a','b','c','d','e'}; //声明一个字符数组变量a, 空间为5个字符


	//a == &a == 数组的初始地址
	printf("a = %p\n", a);
	printf("&a = %p\n", &a);

	printf("%d, %d, %d\n", *a, *(a+1), *(a+2));
	printf("%c, %c, %c\n", *a, *(a+1), *(a+2));

	printf("%d\n", b);
	int c = fun(b);
	c = fun2(b);
	// printf("%d\n", c);
	printf("%d\n", b);

	push('a');
	push('b');
	push('c');
	
	while(!is_empty())
		putchar(pop());
	putchar('\n');

	return 0;
}