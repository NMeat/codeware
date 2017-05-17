#!/bin/sh
echo 'please input a number:'
read number
for((i=0; i< $number; i++));
do
	echo $i;
done

for skill in php,js,python;
do
    echo "i am good at ${skill} script"
done
