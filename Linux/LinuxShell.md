**Shell部分**

    lsof -i：端口号   列出谁在使用某个端口
	netstat -lntp | grep 端口号  #查看某个服务是否在监听某个端口号

    tail -n 行数值 	 文件名
	head -n 行数值 文件名      显示前n行

	cat  -n /etc/profile     		#对/etc目录中的profile的所有的行(包括空白行）显示行号 
	cat 文件名 | grep 查找内容 | less/more
	cat 文件名 | less/more  			#显示文件内容
	cat /proc/cpuinfo 	     		#显示CPU info的信息
    cat /proc/net/dev 				#显示网络适配器及统计
	cat /proc/version 				#显示内核的版本

	find 路径名 -name "文件夹名" -exec rm -rf {} \　     #在指定目录里查找相应的文件夹并删除
	find 路径名 -name "文件名/文件夹名"                   #在指定目录里查找相诮的文件或则文件夹
	find / -type f -name "*.log" | xargs grep "ERROR"  #从根目录开始查找所有扩展名为.log的文本文件，并找出包含”ERROR”的行

	grep -n "word" filename 						    #查找word并显示行数
	grep -v "word" filanem 						    #显示不包含匹配的所有行
	grep -nr --exclude-dir=".svn" 'INFO_URL' *
	grep 'energywise' *           #在当前目录搜索带'energywise'行的文件
	grep -r 'energywise' *        #在当前目录及其子目录下搜索'energywise'行的文件
	grep -l -r 'energywise' *     #在当前目录及其子目录下搜索'energywise'行的文件，但是不显示匹配的行，只显示
	
	ssh  name@remoteserver					#默认端口22
	ssh  remoteserver -l name				#默认端口22
	ssh  name@remoteserver -p 2222			#指定端口2222
	ssh  remoteserver -l name -p 2222		#指定端口2222
	scp  文件名 对方用户名@对方IP地址:对方路径  #拷贝文件

    ps -ef | grep '进程名称'
    ps aux | grep "进程名称"
    
    free -m						#查看内存的使用情况
    arch 					    #显示机器的处理器架构

    uname -m 				    #显示机器的处理器架构
    uname -r 				    #显示正在使用的内核版本
    

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

**VIM**

	:Ve       	打开目录
	F9  	 	查看文件的相关信息
	ctrl + w 	在不同窗口间切换
	:nohl 		用于在vim中去掉搜索后的关键字的高亮背景
	:setnu

    多行注释：
		    	  a. 按下Ctrl + v，进入列模式;
		    	  b. 在行首选择需要注释的行;
		    	  c. 按下“I”，进入插入模式；
		    	  d. 然后输入注释符（“//”、“#”等）;
		    	  e. 按下“Esc”键。
    删除多行注释：
		    	  a. 按下Ctrl + v, 进入列模式;
		    	  b. 选定要取消的注释符;
		    	  c. 按下“x”或者“d”.

移动光标

	w			向前移动一个单词 并把符号和标点当作单词处理
	W			向前移动一个单词 不把符号和标点当作单词处理
	b        	向后移动一个单词，把符号或标点当作单词处理
	B        	向后移动一个单词，不把符号或标点当作单词处理
	H        	光标移至屏幕顶行
	M        	光标移至屏幕中间行
	L        	光标移至屏幕最后行
	0			光标移到行首
	$		    光标移到行尾
	gg		    光标移到页首
	G		    光标移到页尾
	行号+G   	跳转到指定行
	n+       	光标下移n行
	n      	    光标上移n行
	C-b      	向上滚动一屏
	C-f	        向下滚动一屏
	C-u      	向上滚动半屏
	C-d      	向下滚动半屏
	C-y	        向上滚动一行
	C-e     	    向下滚动一行

复制	

	yy			复制一整行
	2yy或y2y		复制两行
	yw			复制一个word
	y2w			复制两个word
	yG			复制至档尾 
	y1G			复制至档首。 
	p			小写p代表贴至游标后（下)
	P			大写P代表贴至游标前（上)


剪切

	dd			剪切当前行
	ndd			n表示大于1的数字，剪切n行
	dw			从光标处剪切至一个单子/单词的末尾，包括空格
	de			从光标处剪切至一个单子/单词的末尾，不包括空格
	d$			从当前光标剪切到行末
	d0			从当前光标位置（不包括光标位置）剪切之行首
	d3l			从光标位置（包括光标位置）向右剪切3个字符
	d5G			将当前行（包括当前行）至第5行（不包括它）剪切
	d3B			从当前光标位置（不包括光标位置）反向剪切3个单词
	dH			剪切从当前行至所显示屏幕顶行的全部行
	dM			剪切从当前行至命令M所指定行的全部行
	dL			剪切从当前行至所显示屏幕底的全部行


插入	

	o        	在光标下方新开一行并将光标置于新行行首，进入插入模式
	O        	同上，在光标上方
	a        	在光标之后进入插入模式
	A        	同上，在光标之前
	i           在光标前插入文本
	I           在当前行前插入文本


保存	

	ZZ          退出vi并保存
	:q!         退出vi，不保存
	:wq         退出vi并保存	

	
查询 

	C+g   		查询当前行信息和当前文件信息

操作

	u	        撤销最后执行的命令
	U        	修正之前对该行的操作
	Ctrl+R   	Redo
	.        	重复上一次操作


删除

	x 	 		删除当前光标下的字符
	dw			删除光标之后的单词剩余部分
	d$			删除光标之后的该行剩余部分
	dd			删除当前行

行合并 
 
	J		把下面一行合并到本行后面

查找和替换

	/word		至上而下查找word
	?word		至下而上查找word

    :s/old/new  		用new替换行中首次出现的old
    :s/old/new/g		用new替换行中所有出现的old
    :m,n s/old/new/g	用new替换从第＃行到第＃行中出现的old
    :% s/old/new/g  	用new替换整篇中出现的old

	如果替换的范围较大时，在所有的命令尾加一个c命令，强制每个替换需要用户进行确认，
	例如: s/old/new/c 或 s/old/new/gc


