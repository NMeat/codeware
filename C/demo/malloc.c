#include <stdio.h>
#include <stdlib.h>
#include <string.h>

#define SIZE 5

int main(int argc, char const *argv[])
{
	/*
		void *malloc(size_t size); 

		malloc()函数有一个参数,函数可以从堆上获得指定字节的内存空间.
		如果函数执行成功,malloc()返回获得内存空间的首地址.
		如果函数执行失败,那么返回值为NULL.

		由于malloc()函数返回值的类型为void型指针.
		因此,可以将其值类型转换后赋给任意类型指针，这样就可以通过操作该类型指针来操作从堆上获得的内存空间.

		malloc()函数分配得到的内存空间是未初始化的。
		因此，一般在使用该内存空间时，要调用另一个函数memset来将其初始化为全0.
		void * memset (void * p, int c, size_t n).
		该函数可以将指定的内存空间按字节单位置为指定的字符c.
		其中，p为要清零的内存空间的首地址，c为要设定的值，n为被操作的内存空间的字节长度.
		如果要用memset清0，变量c实参要为0.

		注意：通过malloc()函数得到的堆内存必须使用memset()函数来初始化。
	*/
	int *p = (int *)malloc(sizeof(int));
	if (p == NULL){
		printf("Can't get memory!");
	}
	memset(p, 0, sizeof(int));		//将p指向的空间清0
	*p = 12;
	printf("%d\n", *p);		//输出分配的空间上的值

	/*
		从堆上获得的内存空间在程序结束以后，系统不会将其自动释放，需要程序员来自己管理.
		一个程序结束时，必须保证所有从堆上获得的内存空间已被安全释放，否则，会导致内存泄露.

		free()函数可以实现释放内存的功能.
		void free(void * p)

		free()函数只是释放指针指向的内容，而该指针仍然指向原来指向的地方，此时，指针为野指针，如果此时操作该指针会导致不可预期的错误.
		安全做法是：在使用free()函数释放指针指向的空间之后，将指针的值置为NULL.
	*/
	free(p);				//释放分配空间
	printf("%d\n", *p);		//依然能输出 但是有风险
	p = NULL;				
	printf("%d\n", *p);		//输出分配的空间上的值 会发布错误

	int *pl = (int *)malloc(sizeof(int) * SIZE);

	for (int i = 0; i < SIZE; ++i){
		pl[i] = i;
	}

	for (int i = 0; i < SIZE; ++i){
		printf("%d\n", pl[i]);
	}

	return 0;
}