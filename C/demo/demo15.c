#include <stdio.h>
#include <stdlib.h>  //提供malloc()原型
#include <stdbool.h> //提供true false 原型

#define MaxSize 10
#define ERROR -1

typedef struct SNode *Stack;
typedef int ElementType;

struct SNode
{
	ElementType *Data;
	int Top;
	int Maxsize;
};

Stack CreateStack(int Max)
{
	Stack S = (Stack) malloc(sizeof(struct SNode));
	S->Data = (ElementType *)malloc(Max * sizeof(ElementType));
	S->Top = -1;
	S->Maxsize = Max;
	return S;
}

bool Push(Stack PtrS, ElementType item)
{
	if(PtrS->Top == MaxSize - 1){ //验证数组是否满了
		printf("堆栈已满\n");
		return false;
	}else{
		PtrS->Data[++(PtrS->Top)] = item;
		return true;
	}
}

ElementType Pop(Stack PtrS)
{
	if(PtrS->Top == -1){
		printf("堆栈空\n");
		return ERROR;
	}else{
		return (PtrS->Data[(PtrS->Top)--]); //返回值并更新top
	}
}

int main(int argc, char const *argv[])
{
	Stack Ptr;
	int Tmp;
	Ptr = CreateStack(10);

	Push(Ptr, 10);
	Tmp = Pop(Ptr);

	printf("%d\n", Tmp);
	return 0;
}






