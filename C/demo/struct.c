#include <stdio.h>
#include <stdlib.h>
#include <string.h>

struct Birthday{	//声明结构体 Birthday
	int year;
	int month;
	int day;
};

struct Student{		//声明结构体Student
	char name[20];
	int num;
	float score;
	struct Birthday birthday;
} stu3 = {"hulatang", 89, 89.0,{6,7,5}};

int main(int argc, char const *argv[])
{
	struct Student stu1, stu2;

	strcpy(stu1.name, "Jack");

	stu1.num = 120;
	stu1.score = 58.8;
	stu1.birthday.year = 2007;
	stu1.birthday.month = 7;
	stu1.birthday.day = 25;

	stu2 = (struct Student){"Tom", 15, 88.8,{3,4,5}};

	printf("%s\n", stu2.name);
	printf("%d\n", stu2.birthday.year);

	printf("%d\n", stu1.birthday.day);
	printf("%s\n", stu1.name);

	printf("%s\n", stu3.name);

	struct Student stu4 = {.num = 77, .name="hulatang4"};
	printf("%s\n", stu4.name);

	struct Student stu5 = stu1;
	printf("%s\n", stu5.name);
	return 0;
}