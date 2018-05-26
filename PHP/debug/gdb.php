<?php
/*
	GDB:
	linux core dump 文件gdb分析，core dump又叫核心转储，当程序运行过程中发生异常， 程序异常退出时， 由操作系统把程序当前的内存状况存储在一个core文件中， 叫core dump。
	linux中如果内存越界会收到SIGSEGV信号，然后就会core dump。

	在程序运行的过程中，有的时候我们会遇到Segment fault--段错误。
	这样的错误。这种看起来比较困难，因为没有任何的栈、trace信息输出。该种类型的错误往往与指针操作相关。往往可以通过这样的方式进行定位。

	配置core dump 生成目录
	修改系统参数kernel.core_pattern:

	sudo vi /etc/sysctl.conf
	kernel.core_pattern=/var/crash/%E.%p.%t.%s
	sudo sysctl -p

	命名方式为`%E.%p.%t.%s`，它们的含义： 
		- `%E`：程序文件的完整路径（路径中的`/`会被`!`替代）
		- `%p`：进程 ID
		- `%t`：进程奔溃的时间戳
		- `%s`：哪个信号让进程奔溃
 
	用gdb查看core文件

	发生core dump之后， 用gdb进行查看core文件的内容， 以定位文件中引发core dump的行。
	gdb exec file  如: gdb ./test test.core
*/