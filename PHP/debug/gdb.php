<?php
/*
	GDB:
	linux core dump 文件gdb分析，core dump又叫核心转储，当程序运行过程中发生异常， 程序异常退出时， 由操作系统把程序当前的内存状况存储在一个core文件中， 叫core dump。
	linux中如果内存越界会收到SIGSEGV信号，然后就会core dump。

	在程序运行的过程中，有的时候我们会遇到Segment fault--段错误。
	这样的错误。这种看起来比较困难，因为没有任何的栈、trace信息输出。该种类型的错误往往与指针操作相关。往往可以通过这样的方式进行定位。

	打开Linux的core dumps：
	一般情况下，Linux默认core dumps是关闭状态。我们可以将其打开并且重定向到我们指定的文件。
	$ echo '/tmp/coredump-%e.%p' > /proc/sys/kernel/core_pattern
	这个例子中，我们把错误文件重定向到/tmp目录下。

	core dumps文件支持变量：
		%%  a single % character
		%c  core file size soft resource limit of crashing process (since
		    Linux 2.6.24)
		%d  dump mode—same as value returned by prctl(2) PR_GET_DUMPABLE
		    (since Linux 3.7)
		%e  executable filename (without path prefix)
		%E  pathname of executable, with slashes ('/') replaced by
		    exclamation marks ('!') (since Linux 3.0).
		%g  (numeric) real GID of dumped process
		%h  hostname (same as nodename returned by uname(2))
		%p  PID of dumped process, as seen in the PID namespace in which
		    the process resides
		%P  PID of dumped process, as seen in the initial PID namespace
		    (since Linux 3.12)
		%s  number of signal causing dump
		%t  time of dump, expressed as seconds since the Epoch,
		    1970-01-01 00:00:00 +0000 (UTC)
		%u  (numeric) real UID of dumped process
*/




/*
	使用方法：
		gdb -p 进程ID
		gdb php
		gdb php core

	gdb有3种使用方式：
	跟踪正在运行的PHP程序，使用gdb -p 进程ID
	使用gdb运行并调试PHP程序，使用gdb php -> run server.php 进行调试
	PHP程序发生coredump后使用gdb加载core内存镜像进行调试 gdb php core

	如果PATH环境变量中没有php，gdb时需要指定绝对路径，如gdb /usr/local/bin/php



	常用指令：
		p：print，打印C变量的值
		c：continue，继续运行被中止的程序
		b：breakpoint，设置断点，可以按照函数名设置，如b zif_php_function，也可以按照源代码的行数指定断点，如b src/networker/Server.c:1000
		t：thread，切换线程，如果进程拥有多个线程，可以使用t指令，切换到不同的线程
		ctrl + c：中断当前正在运行的程序，和c指令配合使用
		n：next，执行下一行，单步调试
		info threads：查看运行的所有线程
		l：list，查看源码，可以使用l 函数名 或者 l 行号
		bt：backtrace，查看运行时的函数调用栈
		finish：完成当前函数
		f：frame，与bt配合使用，可以切换到函数调用栈的某一层
		r：run，运行程序


*/