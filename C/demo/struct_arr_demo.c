#include <stdio.h>
struct Date{
    int year;
    int month;
    int day;
};

struct Person{
    char *name;
    int age;
    struct Date birthday;
    float height;
};
//结构体作为函数参数传递的是成员的值（值传递而不是引用传递）
//对于结构体指针而言可以通过”->”操作符进行访问
void changeValue(struct Person person){
    person.height = 1.80;
    printf("name=%s,age=%d,birthday=%d-%d-%d,height=%.2f\n",
    person.name,
    person.age,
    person.birthday.year,
    person.birthday.month,
    person.birthday.day,
    person.height);
}

int main(int argc, char const *argv[])
{
    //定义一个Person类型结构体数组
    struct Person persons[] = {
        {"lzf1", 18, {1982,6,6}, 1.5},
        {"lzf2", 19, {1983,7,7}, 1.6},
        {"lzf3", 20, {1984,8,8}, 1.7}
    };
    int i;
    for(i = 0; i < 3; i++){
        printf("name = %s, age = %d, birthday = %d-%d-%d, height = %.2f \n", 
            persons[i].name,
            persons[i].age,
            persons[i].birthday,
            persons[i].height
            );
    }
    printf("\n");

    struct Person person = persons[0];
    changeValue(person);
    printf("name=%s,age=%d,birthday=%d-%d-%d,height=%.2f\n",
           persons[0].name,
           persons[0].age,
           persons[0].birthday.year,
           persons[0].birthday.month,
           persons[0].birthday.day,
           persons[0].height);

    printf("\n");
    printf("name=%s,age=%d,birthday=%d-%d-%d,height=%.2f\n",
    person.name,
    person.age,
    person.birthday.year,
    person.birthday.month,
    person.birthday.day,
    person.height);

    printf("\n");
    struct Person *p = &person; //一个结构体指针变量
    printf("name = %s, age = %d, birthday = %d-%d-%d, height = %.2f\n", 
        p->name,
        p->age,
        p->birthday,
        p->height
        );

    system("pause");

    return 0;
}