#! /bin/sh
#output all information
function print(){
	echo "Your input is $1";
}
echo "This program will print your selection!";
case $1 in 
"one")
	print 1;;
"two")
	print 2;;
"three")
	print 3;;
*)
	print "Usage $0 (one|two|three)";;
esac
