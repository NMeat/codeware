#include <stdio.h>
#include <string.h>

/*
	在C中，并没有字符串这个数据类型，而是使用字符数组来保存字符串。

	C字符串实际上就是一个以null('\0')字符结尾的字符数组，null字符表示字符串的结束。

	需要注意的是：只有以null字符结尾的字符数组才是C字符串，否则只是一般的C字符数组。

	注意:C字符串定义时可以利用"="号进行初始化，但是以后不能利用"="对C字符串进行赋值。
*/

int main(int argc, char const *argv[])
{
	//1.分配内存给字符指针；2.分配内存给字符串；3.将字符串首地址赋值给字符指针
	char *a = "hello world"; //声明一个字符指针后，把"hello world"常量的首地址赋值给指针变量a

	printf("%c\n", *a); //output 'h'		   输出字符
	printf("%s\n", a);	//outout "hello world" 输出字符串

	//字符串的初始化
	char b[11] = "huanying";
	//字符串的赋值
	strcpy(b,"nihao");
	printf("%s\n", b);

	//在C中也可以使用字符指针来访问一个字符串,通过字符指针指向存放字符串数组的首元素地址来进行访问
	char *c = "nihao"; 
	printf("%s\n",c);

	char d[] = "hello hulatang";
	printf("%s\n", d);
	printf("%c\n", *d);

	char e[4] = {1,2,3,4,'\0'};
	printf("%s\n", e);
	return 0;
}