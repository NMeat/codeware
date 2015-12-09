#include <stdio.h> //C语方中 以"#"开头的命令称为 预处理命令
/*
    宏是预处理命令的一种 它允许用一个标识符来表示一个字符串 "#define N 100"就是宏定义，N为宏名，100是宏的内容
    宏定义的一般形式为：#define  宏名  字符串
    #表示这是一条预处理命令，所有的预处理命令都以#开头。define是预处理命令。
    宏名是标识符的一种，命名规则和标识符相同。字符串可以是常数、表达式等
    注意这里所说的字符串是一般意义上的字符序列，不要和C语言中的字符串等同，它不需要双引号
*/
#define N 100 

int main(int argc, char const *argv[])
{
    int sum = N + 20;
    printf("sum = %d\n", sum);
    system("pause");
    return 0;
}
