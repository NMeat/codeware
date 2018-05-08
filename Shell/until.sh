#! /bin/sh
i=10
until (($i < 0));do
	echo $i;
	((i--))
done;

j=20;
until [ $j -le 0 ];do
	echo $j;
	((j--));
done;
