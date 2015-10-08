#include <stdio.h> 
#include <time.h>
#include <stdlib.h>
//C语言中产生随机数
/*
    C中也有rand()函数，但是rand()函数产生的数不是真正意义上的随机数，
    是一个伪随机数，是根据一个数，我们称它为种子，为基准以某个递推公式推算出来的一系列数
*/
int main(int argc, char const *argv[])
{
    srand((int)time(0)); //产生随机数的种子
    int i,j;
    for(i = 0; i < 10; i++){
        printf("rand =  %d\n", rand());
        j = 1 + (int)(rand() % 10);
        printf("j = %d\n", j);
    }
    system("pause");
    return 0;
}