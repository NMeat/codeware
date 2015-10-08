#include <stdio.h>
struct Person{              //一个Person类型的结构体
    void (*print)(void *p); //一个函数指针变量 接受任意类型的指针
};

struct Student{             
    struct Person p;
};

void printPerson(void *person){
    if(person == NULL) return;
    struct Person *p = (struct Person *) person;
    printf("run in the person\n");
}

void printStudent(void *person){
    if (person == NULL) return;
    struct Person *p = (struct Person *) person;
    printf("run in the student\n");
}

void print(void *person){
    if(person == NULL) return;
    struct Person *p = (struct Person *) person;
    p->print(person);
}

//主函数 入口函数
int main()
{
    struct Person person;
    struct Student student;

    person.print = printPerson;
    student.p.print = printStudent;

    print(&person);
    print(&student);
    system("pause");
    return 0;
}