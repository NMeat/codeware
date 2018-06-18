#include <stdio.h>
/*
	sizeof是一个单目运算发，而不是一个函数，其用于获取操作数所占内存空间的字节数。
	sizeof操作符以字节形式给出了其操作数的存储大小。
    操作数可以是一个表达式或括在括号内的类型名。
    操作数的存储大小由操作数的类型决定。　   

*/

int main(int argc, char const *argv[])
{
	int a = 100;
	double b = 2;
	/*
		sizeof的操作数可以是类型名，也可以是表达式;
		如果是类型名则直接获得该类型所占字节数;
		如果是表达式，则先分析表达式结果的类型,再根据类型确定所占字节数，并不对表达式进行实际计算。
	*/
	printf("sizeof(a) = %lu\n", sizeof(a));
	printf("sizeof(b) = %lu\n", sizeof(b));
	printf("sizeof(int) = %lu\n", sizeof(int));
	printf("sizeof(double) = %lu\n", sizeof(double));

	//当操作数是指针时，sizeof依赖于编译器
	char* ptr;
	printf("sizeof(ptr) = %lu\n", sizeof(ptr));

	//当操作数具有数组类型时，其结果是数组的总字节数
	char c[5];
	printf("sizeof(c) = %lu\n", sizeof(c));

	//当操作数是具体的字符串或者数值时，会根据具体的类型进行相应转化
	printf("%lu\n", sizeof(8));		//自动转化为int类型
	printf("%lu\n", sizeof("ab"));	//自动转化为数组类型，是3，因为加上了最后的'\n'符


	/*
		主要用途
		1、主要用途是与存储分配和I/O系统那样的例程进行通信。
    	例如: void　*malloc(size_t　size);
　　      	 size_t　fread(void　*ptr, size_t　size, size_t　nmemb, FILE　*　stream);　   

　　		2、另一个的主要用途是计算数组中元素的个数。
    	例如: void　*memset(void　*s, int　c, sizeof(s));　   
	*/
	return 0;
}