#! /bin/sh
i=10
while(($i >= 5));do
	echo $i;
	((i--));
done;

j=20;
#大于号 推荐用中括号的方式
while [ $j -gt 5 ];do
	echo $j;
	if [ $j -eq 6 ];then
		echo "your input number is $j";
	fi
	((j--))
done;
