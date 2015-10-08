#include <stdio.h>
/*需要注意的是枚举成员默认值从0开始，
如果给其中一个成员赋值，其它后面的成员将依次赋值，
例如上面如果summer手动指定为8，则autumn=9，winter=10，而sprint还是0*/
enum Season{    //默认情况下spring=0，summer=1,autumn=2,winter=3
    spring,
    summer,
    autumn,
    winter
};
int main(int argc, char const *argv[])
{
    enum Season season = summer;    //枚举赋值,等价于season=1
    for(season = spring; season <= winter; season++){
        printf("element value = %d\n", season);
    }
    system("pause");
    return 0;
}