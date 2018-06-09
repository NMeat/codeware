#include <stdio.h>

int main(int argc, char const *argv[])
{
	int max = 0, numCount, i;
	int intArr[100]; //存储100个整数的数组

	printf("请输入需要比较的整数个数\n");
	scanf("%d", &numCount);

	for (int i = 0; i < numCount; ++i)
	{
		scanf("%d", &intArr[i]);
		if(intArr[i] > max){
			max = intArr[i];
		}
	}

	printf("最大的整数为%d\n", max);
	return 0;
}