#include <stdio.h>
//结构体类型Date
struct Date{
    int year;
    int month;
    int day;
};
//一个PERSON结构体
struct Person{
    char *name;
    int age;
    struct Date birthday;//一个结构体中使用了另一个结构体类型，结构体类型变量声明前必须加上struct关键字
    float height;
};

int main(int argc, char const *argv[])
{
    /*可以在定义结构体类型的同时声明结构体变量；
      如果定义结构体类型的同时声明结构体变量，此时结构体名称可以省略；
      定义结构体类型并不会分配内存，在定义结构体变量的时候才进行内存分配（同基本类型时类似的）；
      结构体类型的所占用内存大型等于所有成员占用内存大小之和（如果不考虑内存对齐的前提下 */
      
    //定义结构体变量并初始化,不允许先定义再直接初始化，例如：struct Person p;
    //p={"Kenshin",28,{1986,8,8},1.72};是错误的，但是可以分别赋值，例如p.name="Kenshin"
    struct Person p = {"lzf", 29, {1982,8,8},170.24};
    printf("name = %s, age = %d, birthday = %d-%d-%d, height=%.2f", p.name, p.age, p.birthday.year,p.birthday.month,p.birthday.day,p.height);
    printf("\n");
    //结果：len(Date)=12,len(Person)=32
    printf("len(Date)=%lu,len(Person)=%lu\n",sizeof(struct Date),sizeof(struct Person)); 
    printf("\n");
    system("pause");
    /* code */
    return 0;
}