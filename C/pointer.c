#include <stdio.h>
void swapA(int *v1, int *v2);  //定义一个功能函数 它有两个指针变量参数
void swapB(int *v1, int *v2);


int main(int argc, char const *argv[])
{
    int a = 88;
    int b = 89;
    swapA(&a, &b);
    printf("a = %i, b  = %i\n", a, b);  //结果: a = 88, b  = 89

    swapB(&a, &b);
    printf("a = %i, b  = %i\n", a, b);  //结果: a = 89, b  = 88


    system("pause");
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