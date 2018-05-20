**tail  & head**

	tail -n 行数值 filename      显示后N行
	tail -f filename            循环查看文件内容
	head -n 行数值 filename      显示前N行
**cat**

	cat  -n filename     	 		对文件中的所有行(包括空白行）并显示行号 
	cat filename | grep 目标内容 | less/more
	cat filename | less/more  		显示文件内容
**uname**

    uname -m 				     显示机器的处理器架构
    uname -r 				     显示正在使用的内核版本
**find**

	find dir -name "文件夹名" -exec rm -rf {} \;　     在指定目录里查找相应的文件夹并删除
	find dir -name "文件名/文件夹名"                   在指定目录里查找相应的文件或则文件夹
	find / -type f -name "*.log" | xargs grep "ERROR"  从根目录查找所有扩展名为.log的文本文件并找出包含”ERROR”的行
	find . -type d -exec chmod 755 {} \; 
	find . -type f -exec chmod 644 {} \; 

**locate**

	locate命令用于查找文件，它比find命令的搜索速度快，它需要一个数据库，
	这个数据库由每天的例行工作（crontab）程序来建立。当我们建立好这个数据库后，就可以方便地来搜寻所需文件了。
	
	即先运行：updatedb（无论在那个目录中均可，可以放在crontab中 ）
	后在/var/lib/slocate/ 下生成 slocate.db 数据库即可快速查找。
	locate filename  查找该文件

**grep**

	grep -n "word" filename					#指定文件内查找word并显示行数
	grep -v "word" filename 				#指定文件内显示不包含匹配的所有行
	grep 'energywise' *           		#在当前目录搜索带'energywise'行的文件
	grep -r 'energywise' *        		#在当前目录及其子目录下搜索'energywise'行的文件
	grep -l -r 'energywise' *     		#在当前目录及其子目录下搜索'energywise'行的文件，只显示匹配的文件	

**ssh**

	ssh  name@remoteserver				#默认端口22
	ssh  remoteserver -l name			#默认端口22
	ssh  name@remoteserver -p 2222		#指定端口2222
	ssh  remoteserver -l name -p 2222	#指定端口2222
	scp  文件名 对方用户名@对方IP地址:对方路径  #拷贝文件

**ps**

    ps -ef | grep '进程名称'
    ps -ef | grep '进程名称' |  wc -l     统计进程数量
    ps aux | grep "进程名称"

**tar**
```
tar.gz格式
tar -zcvf [目标文件名].tar.gz [原文件名/目录名]  打包并压缩
tar -zxvf [原文件名].tar.gz		解压并解包	
tar.bz2格式
tar -jcvf [目标文件名].tar.bz2 [原文件名/目录名]   打包并压缩
tar -jxvf [原文件名].tar.bz2					解压并解包
```

**du**

```shell
du -s * | sort -nr | sed 5q 当前目录下占用空间最多的5个资源
```

**Linux terminal快捷键**

```
tab 	          制表符　自动补全
ctrl+a 	        移动光标到开始位置
ctrl+e            移动光标到结束位置
ctrl+h            删除当前字符
ctrl+k            删除此处至末尾的所有内容
ctrl+u            删除此处至开始的所有内容
ctrl+l            清屏 相当于clear
```

**Linux下时间戳和日期的相互转换**

	date -d "@1279592730" => 2010年 07月 20日 星期二 10:25:30 CST
	date -d '2016-09-20 00:00:00' +%s => 1474300800
**MySQL里时间戳和日期相互转换**

	select FROM_UNIXTIME(1156219870); --> 2006-08-22 12:11:10
	Select UNIX_TIMESTAMP('2006-11-04 12:23:00'); -->1162614180
	Select NOW(); -->得到当前时间

**关于时间格式的解释**

```shell
UTC	 (Universal Time Coordinated,UTC)世界协调时间
CST （China Standard Time UTC+8:00）中国沿海时间(北京时间)
GMT  (Greenwich Mean Time)格林威治标准时间
```

**Linux后台运行程序**

```shell
一般形式: nohup name &
输出可以重定向到一个名为nohup.out的文件中,
也可以指定程序的输出: nohup name > save.file 2>&1 &
```

**变更拥有者(owner)**

```
chown -R 账户名称 文件或则目录
chown -R 账户名称:群组名称 文件或则目录
```

变更群组

```
chgrp [-options]  群组名 文档路径
```

变更权限

```
分别使用u，g，o来代表三种身份，a表示全部身份；分别使用r、w、x表示三种权限；分别使用+、-、=表示操作行为
chmod | u g o a | +（加入） -（除去） =（设置） | r w x | 文档路径 
//设置权限
chmod u=rwx,g=rwx,o=rwx test === chmod ugo=rwx test === chmod a=rwx test
//去掉权限
chmod u-x,g-x,o-x test === chmod ugo-x test === chmod a-x test
//添加权限
chmod u+x,g+x,o+x test === chmod ugo+x test === chmod a+x test

使用数字来代表权限，r,w,x分别为4,2,1。三种权限累加就可以得出一种身份的权限
chmod 777 test    //设置目录test的权限为任何人都可读、写、执行
chmod 666 test    //设置目录test的权限为任何人都可读、写。
chmod 755 test    //赋予一个shell文件test.sh可执行权限，拥有者可读、写、执行，群组账号和其他人可读、执行。
```

