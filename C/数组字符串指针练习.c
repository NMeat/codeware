//  main.c
//  C语言基础.
#include <stdio.h>
void changeValue(int a[]){
    a[0] = 2;
}

void changeValue2(int *p){
    p[0] = 3;
}
int main(int argc, const char * argv[]) {
    //对于数而方  a == &a[0] == *p
    int a[] = {1,2,3};      //定义一个数组
    int *p = &a[0];         //等价于 int *p = a;
    //int *p = a;
    int c = sizeof(int);    //一个int类的数据占多少个字节宽度

    int i;
    for(i = 0;i < 3; i++){
        printf("a[%d] = %d\n", i,  *(p+i));//输出结果： a[0]=1 a[1]=2 a[2]=3
    }
    printf("--------------------\n");

    changeValue(a);
    for(i = 0;i < 3; i++){
        printf("a[%d] = %d\n", i,  *(p+i));//输出结果： a[0]=2 a[1]=2 a[2]=3
    }
    printf("--------------------\n");
    changeValue2(p);
    for(i = 0;i < 3; i++){
        printf("a[%d] = %d\n", i,  a[i]);//输出结果： a[0]=3 a[1]=2 a[2]=3
    }

    //以C语方中 字符串就是字符数组
    char d[] = "hello world";
    printf("d = %s, %x\n", a, a); //结果 "hello world,28ff28"
    printf(d);  //结果 "hello world"
    printf("\n");

    printf("---------------------\n");
    char e[] = "hello world";
    char *f = e;
    printf("e = %s, %s\n", e, f);   //结果  e = hello world, hello world

    printf("---------------------\n");
    char *g = "hello world";    //等价于 char g = "hello world"
    printf("g = %s\n", g);      // g = hello world
    system("pause");
    return 0;
}