linux core dump 文件 gdb分析，core dump又叫核心转储, 当程序运行过程中发生异常, 程序异常退出时, 由操作系统把程序当前的内存状况存储在一个core文件中, 叫core dump. (linux中如果内存越界会收到SIGSEGV信号，然后就会core dump)

在程序运行的过程中，有的时候我们会遇到Segment fault(段错误)这样的错误。这种看起来比较困难，因为没有任何的栈、trace信息输出。该种类型的错误往往与指针操作相关。往往可以通过这样的方式进行定位。

**一 、造成segment fault，产生core dump的可能原因**

1.内存访问越界

 a) 由于使用错误的下标，导致数组访问越界

 b) 搜索字符串时，依靠字符串结束符来判断字符串是否结束，但是字符串没有正常的使用结束符

 c) 使用strcpy, strcat, sprintf, strcmp, strcasecmp等字符串操作函数，将目标字符串读/写爆。应该使用strncpy, strlcpy, strncat, strlcat, snprintf, strncmp, strncasecmp等函数防止读写越界。

2 多线程程序使用了线程不安全的函数。

3 多线程读写的数据未加锁保护。对于会被多个线程同时访问的全局数据，应该注意加锁保护，否则很容易造成core dump

4 非法指针

a) 使用空指针

b) 随意使用指针转换。一个指向一段内存的指针，除非确定这段内存原先就分配为某种结构或类型，或者这种结构或类型的数组，否则不要将它转换为这种结构或类型的指针，而应该将这段内存拷贝到一个这种结构或类型中，再访问这个结构或类型。这是因为如果这段内存的开始地址不是按照这种结构或类型对齐的，那么访问它时就很容易因为bus error而core dump.

5 堆栈溢出.不要使用大的局部变量（因为局部变量都分配在栈上），这样容易造成堆栈溢出，破坏系统的栈和堆结构，导致出现莫名其妙的错误。

 **二 、配置操作系统使其产生core文件**

首先通过ulimit命令查看一下系统是否配置支持了dump core的功能。通过ulimit -c或ulimit -a，可以查看core file大小的配置情况，如果为0，则表示系统关闭了dump core。可以通过ulimit -c unlimited来打开。若发生了段错误，但没有core dump，是由于系统禁止core文件的生成。

解决方法:
$**ulimit -c unlimited**　　注意到，这个设置只对当前登录回话有效。如果想要这个设置持久有效，可以把它写入到`/etc/security/limits.conf`文件中：

```
$ sudo vi /etc/security/limits.conf
* soft core unlimited
* soft hard unlimited
```

或在**~/.bashrc**　的最后加入： **ulimit -c unlimited** （一劳永逸）

```
# ulimit -c

0

$ ulimit -a

core file size          (blocks, -c) 0

data seg size           (kbytes, -d) unlimited

file size               (blocks, -f) unlimited
```

那么 core dump 会存放在哪个目录呢？这是由系统参数`kernel.core_pattern`决定的。例如，在 Ubuntu 16.04 中，它的值如下：

```
cat /proc/sys/kernel/core_pattern
|/usr/share/apport/apport %p %s %c %P
```

开头的`I`表示，core dump 文件会交给 apport 程序去处理，而 apport 会将 core dump 文件保存在`/var/crash`目录下。 　　在实践中，更好的做法是自己指定 core dump 目录，以及 core dump 文件的命名方式：

```
sudo vi /etc/sysctl.conf
kernel.core_pattern=/var/crash/%E.%p.%t.%s
sudo sysctl -p
```

我们设置 core dump 目录为`/var/crash`，core dump 的命名方式为`%E.%p.%t.%s`，它们的含义： 

- `%E`：程序文件的完整路径（路径中的`/`会被`!`替代）
- `%p`：进程 ID
- `%t`：进程奔溃的时间戳
- `%s`：哪个信号让进程奔溃

**三 用gdb查看core文件**

发生core dump之后, 用gdb进行查看core文件的内容, 以定位文件中引发core dump的行.

gdb exec file

如: gdb ./test test.core

使用gdb 调试方法，首先要在gcc编译时加入-g选项。

调试core文件，在Linux命令行下：gdb pname corefile。

例如，程序名为controller_tester，core文件为core.3421，则为：gdb controller_tester core.3421。

这样进入了gdb core调试模式。

追踪产生segmenttation fault的位置及代码函数调用情况：

gdb>bt

这样，一般就可以看到出错的代码是哪一句了，还可以打印出相应变量的数值，进行进一步分析。

gdb>print 变量名

之后，就全看各位自己的编程功力与经验了，gdb已经做了很多了。