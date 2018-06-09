#include <stdio.h>
#include <stdlib.h>

/*

根据n的大小，如果n比较小，就沿用原来的内存地址（也就是返回的地址就是原来的地址），在原来地址的内存空间的最后面，加上n大小的内存空间；
如果n比较大，系统就不会沿用原来的内存地址，系统有新开辟一个内存空间，并把原来内存空间里存放的值复制过来，这时realloc的返回地址和原来的地址就不同了。


当realloc返回的地址不是原来的地址的时候，realloc函数会释放掉原来地址的内存空间，在这种情况下，如果在realloc调用的后面，free（原来的地址），就会发生吐核（segment fault）,
所以，最后只需要free（新的地址）就可以了。
*/

int main(int argc, char const *argv[])
{
	/* code */

	int *p = (int *) malloc(sizeof(int) * 5);

	if (NULL == p)
	{
		return 1;
	}

	for (int i = 0; i < 5; ++i)
	{
		*(p + i) = i;
		printf("%d\n", *(p + i));
	}

	printf("\n");

    //由于新要求的空间过大，realloc就会释放掉原来的p指向的空间，然后再从新开辟空间，并把地址返回给p1，这时p和p1就不指向同一个地址了。
	int *p1 = (int *)realloc(p, sizeof(int) * 800000);

	for(int k = 5; k < 8; ++k)
	{
		*(p1 + k) = k;
		printf("%d\n", *(p1 + k));
	}

	printf("\n");
	//free(p); //因为要求新的空间过大，所以就不沿用原来的地址，再释放原来的地址就吐核了；如果要求新的空间不大的话，free(p)和free(p1)哪个都可以，但只能调用其中的一个。 
	// free(p);  
	free(p1);//释放新地址的内存空间
}