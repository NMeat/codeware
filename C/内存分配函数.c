#include <stdio.h> 
#include <stdlib.h>
#include <string.h>
//C语言 malloc calloc realloc alloc 在分配内存时的 区别
/*
    malloc  ： 向堆申请分配内存，不初始化
               分配足够的内存给大小为size的对象, 并返回指向所分配区域的第一个字节的指针;
               若内存不够,则返回NULL. 不对分配的空间进行初始化.
               char *p = (char *) malloc(sizeof(char));

    calloc  ： 向堆申请分配内存，初始化为0 
               分配足够的内存给nobj个大小为size的对象组成的数组, 并返回指向所分配区域的第一个字节的指针;
               若内存不够,则返回NULL. 该空间的初始化大小为0字节.
               char *p = (char *) calloc(100,sizeof(char));

    realloc ： 向堆申请分配内存，可调整大小
               将p所指向的对象的大小改为size个字节.
               如果新分配的内存比原内存大, 那么原内存的内容保持不变, 增加的空间不进行初始化.
               如果新分配的内存比原内存小, 那么新内存保持原内存的内容, 增加的空间不进行初始化.
               返回指向新分配空间的指针; 若内存不够,则返回NULL, 原p指向的内存区不变.
               char *p = (char *) malloc(sizeof(char));
               p= (char *) realloc(p, 256);

    alloc   ： 向栈申请内存，不需手动释放

    void free(void *p);
    释放p所指向的内存空间; 当p为NULL时, 不起作用
    p必先调用calloc, malloc或realloc
*/
int main(int argc, char const *argv[])
{
    char *q,*p;
    q = malloc(10);
    p = q;
    q = realloc(p, 10);
    printf("p = 0x%x\n", p);    //p = 0x3513c0 内存地址
    printf("q = 0x%x\n", q);    //q = 0x3513c0

    int cstr[5] = {4,5,5,8,8}; 
    printf("p %d\n", sizeof(cstr)); //20  即cstr的长度是20个字节

    char *p1, *p2;
    p1 = malloc(10);
    p2 = p1;
    p1 = realloc(p1, 100);
    printf("p1 = 0x%x\n", p1);
    printf("p2 = 0x%x\n", p2);

    char *p3;
    p3 = calloc(10, sizeof(char));//分配内存 并初始化为0
    int k;
    for(k = 0; k <= 9; k++){
        printf("p3[%d] = %d\n", k, p3[k]);
    }
    
    //字符数组是可以被修改的，字符串是只读的，不能被修改，而 memset() 又必须修改 str，
    //所以不能将 char str[] = "http://c.biancheng.net"; 
    //声明为 char *str = "http://c.biancheng.net";，否则运行时会报错。
    char str[] = "www.baidu.com.cn";  //一个字符数组
    memset(str, '*', 7); //将字符数组的前7个字节的内容修改为'*'
    puts(str);  //输出字符串:*******du.com.cn

    system("pause");
    return 0;
}
