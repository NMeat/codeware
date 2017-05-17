#!/bin/sh
cd ~/shell_learn
mkdir shell_nut
cd shell_nut

for((i=0; i<10; i++));do
	touch test_$i.txt
done
