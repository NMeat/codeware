# Redis命令行操作 #
# 启动redis  #  
./redis-server &  #以后台形式运行
#检测后台进程是否存在#
sudo ps -ef |grep redis
#检测6379端口是否在监听#
sudo netstat -lntp | grep 6379
#使用客户端#
redis-cli shutdown
#因为Redis可以妥善处理SIGTERM信号，所以直接kill -9也是可以的#
kill -9 PID
#启动时指定配置文件#
redis-server ./redis.conf
#如果更改了端口，使用`redis-cli`客户端连接时，也需要指定端口，例如：#
redis-cli -p 6380

    登录		 	   : redis-cli -h 主机IP
    测试连接是否存活   : ping
    返回当前数据库中key的数目		  :dbsize
    选择数据库,Redis数据库编号从0-15 : select 0-15
    获取服务器的信息和统计   		  :info
