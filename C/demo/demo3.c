#include "stdlib.h"
#include "stdio.h"
#include "string.h"

typedef struct Teacher{
	char name[10];
	int age;
} Teacher;

//数据类型的本质:固定大小内存块的别名
void main()
{
	int a;  //告诉编译器分配4个字节的内存
	int b[10];	//告诉C编译器分配40个字节的内存
	printf("b:%d, b+1:%d, &b:%d,&b+1:%d \n", b, b+1, &b, &b+1); //out b:-354957088, b+1:-354957084, &b:-354957088,&b+1:-354957048
	//b 代表数据的首元素的地址
	//&b 代表整个数组的址址 

	Teacher t1;
	t1.age =10;

	printf("t1.age %d\n", t1.age);
}
