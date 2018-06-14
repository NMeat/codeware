#include <stdio.h>

/*
    从编译角度讲，指针是一种数据类型，存储的就是地址。
*/

int i = 189; //int是类型（整型类型）,i是该类型的变量,189是赋与i的值(一个整数),i所占的空间大小是平台相关的,一般编译环境中 sizeof(i) == 4


//int* 是类型（指向整数的指针类型）,p是该类型的变量,&i 是赋与 p 的值（一个地址）,p 所占的空间大小是平台相关的，一般32位编译环境中 sizeof(p) == 4
int* p = &i; //补充：&i 是对 i 取址，生成一个 int* 类型、指向 i 的指针

void swapA(int *v1, int *v2);  //定义一个功能函数 它有两个指针变量参数
void swapB(int *v1, int *v2);

int main(int argc, char const *argv[])
{

    printf("i = %d\n", i);
    printf("*p = %d\n", *p);

    
    int a = 88;
    int b = 89;
    swapA(&a, &b);
    printf("a = %i, b  = %i\n", a, b);  //结果: a = 88, b  = 89

    swapB(&a, &b);
    printf("a = %i, b  = %i\n", a, b);  //结果: a = 89, b  = 88

    return 0;
}
// 不能交换外面实参的值，仅仅是交换了内部指针的指向

void swapA(int *v1, int *v2){
    int *temp;      //一个int型的指针变量
    temp = v1;     
    v1 = v2;        //交换的指针地址
    v2 = temp;
    printf("a = %i, b  = %i\n", *v1, *v2);  //结果: a = 89, b  = 88
}

// 完成两个整型变量值的互换
void swapB(int *v1, int *v2)
{
    int temp = *v1;
    *v1 = *v2;
    *v2 = temp;
    printf("a = %i, b  = %i\n", *v1, *v2);  //结果: a = 89, b  = 88
}