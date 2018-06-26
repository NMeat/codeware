#include <stdio.h>
#include <stdlib.h>


#define SIZE 5
int main(int argc, char const *argv[])
{

	/*
		calloc()函数的功能与malloc()函数的功能相似，都是从堆分配内存.
		函数返回值为void型指针.
		如果执行成功，函数从堆上获得 size X n 的字节空间，并返回该空间的首地址.
		如果执行失败，函数返回NULL.
		该函数与malloc()函数的一个显著不同时是，calloc()函数得到的内存空间是经过初始化的，其内容全为0.
		calloc()函数适合为数组申请空间，可以将size设置为数组元素的空间长度，将n设置为数组的容量.
		calloc()函数的分配的内存也需要自行释放.
	*/

	int *pl = NULL;
	int s = 0;
	// 为p从堆上分配SIZE个int型空间
	pl = (int *)calloc(SIZE, sizeof(int));
	if (pl == NULL){
		printf("can't get memory\n");
	}

	// 为p指向的SIZE个int型空间赋值
	for (s = 0; s < SIZE; ++s){
		pl[s] = s;
	}

	// 输出各个空间的值
	for (int s = 0; s < SIZE; ++s){
		printf("%d\n", pl[s]);
	}
	exit(0);

	int n;
	printf("input n:>");
	scanf("%d", &n);
	printf("%d\n", n);

	//一个参数， 指定具体空间的大小
	int *p= (int*)malloc(sizeof(int) * n);
	if (NULL == p){
		return 1;
	}	

	//两个参数 第一个参数是个数 第二个参数是每个的大小
	int *cp = (int*)calloc(n, sizeof(int));

	for (int i = 0; i < n; ++i){
		*(p + i) = i;
		printf("%d\n", *(p+i));
	}
	printf("\n");
	for (int i = 0; i < n; ++i){
		*(cp + i) = i;
		printf("%d\n", *(cp + i));
	}

	free(p);
	free(cp);
	return 0;
}