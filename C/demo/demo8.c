#include <stdio.h>
#include <string.h>
#include <stdlib.h>


int main(int argc, char const *argv[])
{
	char name[100];	//声明一个容量为100个字节的字符数组
	char *description;	//声明一个字符型的指针变量

	strcpy(name, "Zara Ali");

	printf("my name is %s\n", name);

	//动态分配内存
	description = malloc(200 * sizeof(char)); //在堆中申请200个字节长度的空间

	if (description == NULL){
		fprintf(stderr, "Error - unable to allocate required memory\n");
	}else{
		strcpy(description, "Zara ali a DPS student in class 10th");
	}
	
	printf("description = %s\n", description);
	description = realloc(description, 300 * sizeof(char));

	if (description == NULL){
		fprintf(stderr, "Error - unable to allocate required memory\n");
	}else{
		strcpy(description, "Zara ali a DPS student in class 10th 300000000");
	}

	printf("Name = %s\n", name);
	printf("description = %s\n", description);
	free(description);
	return 0;
}