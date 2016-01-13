**Redis命令行操作**

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

**Redis持久化**

	Redis有两种持久化的方式：快照（RDB文件）和追加式文件（AOF文件）
		
	- RDB持久化方式会在一个特定的间隔保存那个时间点的一个数据快照
	- AOF持久化方式则会记录每一个服务器收到的写操作。在服务启动时，这些记录的操作会逐条执行从而重建出原来的数据。
	  写操作命令记录的格式跟Redis协议一致，以追加的方式进行保存。
	- Redis的持久化是可以禁用的，就是说你可以让数据的生命周期只存在于服务器的运行时间里。
	- 两种方式的持久化是可以同时存在的，但是当Redis重启时，AOF文件会被优先用于重建数据

	手动生成RDB快照临时文件:save 和 bgsave
