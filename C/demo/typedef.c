#include <stdio.h>

typedef char (*PTRFUN)(int); //定义PTRFUN函数指针,它是指向某种函数的指针,有个int型参数,反回值是char类型
typedef char fPTRFUN(int);	 //定义fPTRFUN函数类型

char glFun(int a){
	printf("%d\n", a);
	return 'a';
}

void FileFunc()
{
	printf("FileFunc\n");
}

void EditFunc()
{
	printf("EditFunc\n");
}
/*-------------------------typedef 定义的函数指针----------------------------*/
/*
	从里向外分析
	* (*fp1)(int) 是fp1函数指针 参数是int 返回值是指针 指向哪里?
	最外层 void * [10] 返回值是一个指针,指向包含10个void类数据的数组
*/
void * (*(*fp1)(int))[10];
/*
	*(*fp2)(int, int, float) fp2是一个函数指针, 三个参数,返回值是函数指针
	指向具有一个int型参数 且返回值是float型
*/
float (*(*fp2)(int, int, float))(int);  

/*
	fp3被定义为一个函数指针类型，这种函数指针所指向的函数的参数为空；
	它的返回值是一个指针，这个指针指向一个包含10元素的函数指针数组，
	这些函数指针所指向的函数的参数为空，返回值为double。
*/
typedef double (*(*(*fp3)())[10])(); 

/*
	fp4是一个指针，这个指针指向一个包含10元素的函数指针数组，这些函数指针所指向的函数的参数为空，返回值为int
*/

int main(int argc, char const *argv[])
{

	PTRFUN pFun;	  //pFun是一个指向函数类型的函数指针
	pFun = glFun;
	(*pFun)(2);
	pFun(3);

	fPTRFUN *fptrfun; //fPTRFUN是函数类型，所以fptrfun是指向此函数类型的指针
	fptrfun = &glFun;
	fptrfun(100);



	typedef void (*funcp)();
	funcp editF = EditFunc;
	editF();

	funcp fileF = FileFunc;
	fileF();
	return 0;
}





