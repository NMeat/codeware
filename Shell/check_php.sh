#!/bin/bash
dir=$1;
if [ -z $dir ];then
    echo "请输入要检测目录, 类似${0} fang";
    exit 0
fi

if [ $dir = 'fang' ];then
    cd "/home/${USER}/www/${dir}";#需要检测的目录

    change=$(svn st|awk '{print $2}');
    OLD_IFS="$IFS"
    IFS=" "
    array=($change)
    IFS="$OLD_IFS"

    for i in ${array[*]};do
        error=$(php -l $i);
        echo $error
    done
fi
exit 0
