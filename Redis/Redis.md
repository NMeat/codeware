# Redis命令行操作 #

    ./redis-server &                       启动redis  以后台形式运行
    ps -ef |grep redis				       检测后台进程是否存在
	sudo netstat -lntp | grep 6379		   检测6379端口是否在监听
	redis-cli shutdown
	kill -9 PID
	redis-server  ./redis.conf			   启动时指定配置文件
	redis-cli -p 6380					   redis-cli`客户端连接时，也需要指定端口
    redis-cli -h 主机IP					   连接redis

	登录后可以继续以下操作:
    ping			测试连接是否存活
    dbsize			返回当前数据库中key的数目
    select 0-15		选择数据库,Redis数据库编号从0-15
    info			获取服务器的信息和统计
