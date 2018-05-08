#! /bin/sh
a=10;
b=20;
echo $(($a + $b));
echo $(($a * $b));
echo $(($a - $b));
echo $(($a / $b));
echo $(($a % $b));

str="this is a test str";
#统计字符串长度
echo ${#str};

#截取字符串

echo ${str#t*.};
echo '-----------'
echo ${str#this is};
echo ${str:3};
echo ${str:3:5};
