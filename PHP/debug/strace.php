<?php
/*
	strace 
		是一个集诊断、调试、统计与一体的工具，我们可以使用strace对应用的系统调用和信号传递的跟踪结果来对应用进行分析，以达到解决问题或者是了解应用工作过程的目的。
		是 Linux 环境下的一款程序调试工具，用来监察一个应用程序所使用的系统调用及它所接收的系统信息。

	原理: 
		在 Linux 中，进程是不能直接去访问硬件设备(比如读取磁盘文件，接收网络数据等等)，但可以将用户态模式切换至内核态模式，通过系统调用来访问硬件设备。
		这时 strace 就可以跟踪到一个进程产生的系统调用，包括参数，返回值，执行消耗的时间，调用次数，成功和失败的次数。
		在命令执行的过程中，strace会记录和解析命令进程的所有系统调用以及这个进程所接收到的所有的信号值。


	strace的最简单的用法就是执行一个指定的命令，在指定的命令结束之后它也就退出了。
	默认返回的结果每一行代表一条系统调用，规则为“系统调用的函数名及其参数=函数返回值”。
	也可以外加一些条件比如：-e 指定返回的调用函数，-c 对结果进行统计，-T 查看绝对耗时，-p 通过 pid 附着(attach)到任何运行的进程等等。

	strace 的使用方法这里就不做具体介绍了，可以通过 strace –help 去详细了解使用方法。

	那么通过 strace 拿到了所有程序去调用系统过程所产生的痕迹后，我们能用来定位哪些问题呢？
		1、调试性能问题，查看系统调用的频率，找出耗时的程序段
		2、查看程序读取的是哪些文件从而定位比如配置文件加载错误问题
		3、查看某个 php 脚本长时间运行“假死”情况
		4、当程序出现 “Out of memory” 时被系统发出的 SIGKILL 信息所 kill

	phptrace 扩展:
	因为 strace 只能追踪到系统调用信息，而拿不到php代码层的调用信息。phptrace扩展就是为了解决这个问题，phptrace 包含两个功能：1. 打印当前 PHP 调用栈，2. 实时追踪 PHP 调用。这样就能更方便我们去查看到我们需要的信息。

	
*/


/*
	比如我们使用 strace 来跟踪 cat 查看一个文件做了什么：strace cat dytt.sh
	
	输出结果如下:
	execve("/usr/bin/cat", ["cat", "dytt.sh"], [/* 23 vars */]) = 0
	brk(NULL)                               = 0x138b000
	mmap(NULL, 4096, PROT_READ|PROT_WRITE, MAP_PRIVATE|MAP_ANONYMOUS, -1, 0) = 0x7f1fb39af000
	access("/etc/ld.so.preload", R_OK)      = -1 ENOENT (No such file or directory)
	open("/etc/ld.so.cache", O_RDONLY|O_CLOEXEC) = 3
	fstat(3, {st_mode=S_IFREG|0644, st_size=33037, ...}) = 0
	mmap(NULL, 33037, PROT_READ, MAP_PRIVATE, 3, 0) = 0x7f1fb39a6000
	close(3)                                = 0
	open("/lib64/libc.so.6", O_RDONLY|O_CLOEXEC) = 3
	read(3, "\177ELF\2\1\1\3\0\0\0\0\0\0\0\0\3\0>\0\1\0\0\0\20\35\2\0\0\0\0\0"..., 832) = 832
	fstat(3, {st_mode=S_IFREG|0755, st_size=2127336, ...}) = 0
	mmap(NULL, 3940800, PROT_READ|PROT_EXEC, MAP_PRIVATE|MAP_DENYWRITE, 3, 0) = 0x7f1fb33cc000
	mprotect(0x7f1fb3584000, 2097152, PROT_NONE) = 0
	mmap(0x7f1fb3784000, 24576, PROT_READ|PROT_WRITE, MAP_PRIVATE|MAP_FIXED|MAP_DENYWRITE, 3, 0x1b8000) = 0x7f1fb3784000
	mmap(0x7f1fb378a000, 16832, PROT_READ|PROT_WRITE, MAP_PRIVATE|MAP_FIXED|MAP_ANONYMOUS, -1, 0) = 0x7f1fb378a000
	close(3)                                = 0
	mmap(NULL, 4096, PROT_READ|PROT_WRITE, MAP_PRIVATE|MAP_ANONYMOUS, -1, 0) = 0x7f1fb39a5000
	mmap(NULL, 8192, PROT_READ|PROT_WRITE, MAP_PRIVATE|MAP_ANONYMOUS, -1, 0) = 0x7f1fb39a3000
	arch_prctl(ARCH_SET_FS, 0x7f1fb39a3740) = 0
	mprotect(0x7f1fb3784000, 16384, PROT_READ) = 0
	mprotect(0x60b000, 4096, PROT_READ)     = 0
	mprotect(0x7f1fb39b0000, 4096, PROT_READ) = 0
	munmap(0x7f1fb39a6000, 33037)           = 0
	brk(NULL)                               = 0x138b000
	brk(0x13ac000)                          = 0x13ac000
	brk(NULL)                               = 0x13ac000
	open("/usr/lib/locale/locale-archive", O_RDONLY|O_CLOEXEC) = 3
	fstat(3, {st_mode=S_IFREG|0644, st_size=106070960, ...}) = 0
	mmap(NULL, 106070960, PROT_READ, MAP_PRIVATE, 3, 0) = 0x7f1facea3000
	close(3)                                = 0
	fstat(1, {st_mode=S_IFCHR|0620, st_rdev=makedev(136, 0), ...}) = 0
	open("dytt.sh", O_RDONLY)               = 3
	fstat(3, {st_mode=S_IFREG|0755, st_size=337, ...}) = 0
	fadvise64(3, 0, 0, POSIX_FADV_SEQUENTIAL) = 0
	read(3, "#! /bin/bash\nmoves=('\346\232\264\351\233\252\345\260\206\350\207"..., 65536) = 337
	write(1, "#! /bin/bash\nmoves=('\346\232\264\351\233\252\345\260\206\350\207"..., 337#! /bin/bash
	moves=('暴雪将至' '银翼杀手2049' '雷神3')
	url='http://www.dytt8.net/'
	for move in ${moves[@]};
	do
	    content=`curl -v --silent $url 2>&1| iconv -c -f GB2312 -t utf-8|grep -c $move`
	    if [[ ${content} -gt 1 ]];
	    then
	        echo $move'已有高清资源' | mail -s $move liuzhifeng01@58ganji.com
	    fi
	done
	) = 337
	read(3, "", 65536)                      = 0
	close(3)                                = 0
	close(1)                                = 0
	close(2)                                = 0
	exit_group(0)                           = ?
	+++ exited with 0 +++
*/