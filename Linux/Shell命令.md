# Shell部分

**losf:list open files**

	lsof -i：[port number]  				列出谁在使用某个端口

**netstat:network status** 	

	netstat -lntp | grep [port number]  	  查看某个服务是否在监听某个端口号
	netstat -an | grep ESTABLISHED | wc -l    查看并发访问数
	netstat -nat| grep -i "80" | wc -l	      返回所有80端口的请求总数

**tail**

	tail -n 行数值 filename      显示后N行
	tail -f filename            循环查看文件内容
	head -n 行数值 filename      显示前N行
**cat**

	cat  -n filename     	 对文件中的所有行(包括空白行）并显示行号 
	cat filename | grep 目标内容 | less/more
	cat filename | less/more  		显示文件内容
	cat /proc/cpuinfo 	     		显示CPU info的信息
 	cat /proc/net/dev 				显示网络适配器及统计
	cat /proc/version 				显示内核的版本
	
	free -m						 查看内存的使用情况
    arch 					        显示机器的处理器架构
    
  **uname**
  
    uname -m 				      显示机器的处理器架构
    uname -r 				      显示正在使用的内核版本
**find**

	find dir -name "文件夹名" -exec rm -rf {} \　     在指定目录里查找相应的文件夹并删除
	find dir -name "文件名/文件夹名"                   在指定目录里查找相诮的文件或则文件夹
	find / -type f -name "*.log" | xargs grep "ERROR"  从根目录查找所有扩展名为.log的文本文件并找出包含”ERROR”的行
	
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

	ssh  name@remoteserver					#默认端口22
	ssh  remoteserver -l name				#默认端口22
	ssh  name@remoteserver -p 2222		#指定端口2222
	ssh  remoteserver -l name -p 2222		#指定端口2222
	scp  文件名 对方用户名@对方IP地址:对方路径  #拷贝文件

**ps:process**

    ps -ef | grep '进程名称'
    ps aux | grep "进程名称"
	ps -ef | grep '进程名称' |  wc -l     统计进程数量
    
**tar**
	
	tar.gz格式
	tar -zcvf [目标文件名].tar.gz [原文件名/目录名]  打包并压缩
	tar -zxvf [原文件名].tar.gz		解压并解包
    
	tar.bz2格式
	tar -jcvf [目标文件名].tar.bz2 [原文件名/目录名]	打包并压缩
	tar -jxvf [原文件名].tar.bz2						#解压并解包

    date						#显示系统日期
    cal 2007 					#显示2007年的日历表
    which ls					#显示命今ls的绝对路径
    curl ifconfig.me    		#查看本机公网IP
    
**Ubuntu terminal快捷键**

	ctrl+alt+t        打开一下终端窗口
	ctrl+shift + t    在终端窗口中打开一个标签
	tab 	          制表符　自动补全
	ctrl+a 	          移动光标到开始位置
	ctrl+e            移动光标到结束位置
	ctrl+h            删除当前字符
	ctrl+l            清屏 相当于clear
	ctrl+k            删除此处至末尾的所有内容
	ctrl+u            删除此处至开始的所有内容
	shift+ctrl+c      复制
	shift+ctrl+v　　　 粘贴


