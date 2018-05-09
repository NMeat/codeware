**Redis命令行操作**

```shell
./redis-server &                       启动redis  以后台形式运行
sudo netstat -lntp | grep 6379		   检测6379端口是否在监听
redis-cli shutdown
redis-server  ./redis.conf			   启动时指定配置文件
redis-cli -p 6380					   redis-cli`客户端连接时，也需要指定端口
redis-cli -h 主机IP					   连接redis

登录后可以继续以下操作:
ping			测试连接是否存活
dbsize			返回当前数据库中key的数目
select 0-15		选择数据库,Redis数据库编号从0-15
info			获取服务器的信息和统计
```

**Redis持久化**

	Redis有两种持久化的方式：快照（RDB文件）和追加式文件（AOF文件）
		
	- RDB持久化方式会在一个特定的间隔保存那个时间点的一个数据快照
	- AOF持久化方式则会记录每一个服务器收到的写操作。在服务启动时，这些记录的操作会逐条执行从而重建出原来的数据。
	  写操作命令记录的格式跟Redis协议一致，以追加的方式进行保存。
	- Redis的持久化是可以禁用的，就是说你可以让数据的生命周期只存在于服务器的运行时间里。
	- 两种方式的持久化是可以同时存在的，但是当Redis重启时，AOF文件会被优先用于重建数据
	
	手动生成RDB快照临时文件:save 和 bgsave

一、什么是Redis?

- Redis 是由意大利人Salvatore Sanfilippo 开发的一款内存高速缓存数据库。
- Redis全称为：Remote Dictionary Server（远程数据服务），该软件使用C语言编写，遵守BSD协议，是一个高性能的key-value数据库。

二、Redis优点?

- 性能极高 – Redis能读的速度是110000次/s,写的速度是81000次/s 
- 丰富的数据类型 – Redis支持二进制案例的 Strings, Lists, Hashes, Sets 及 Ordered Sets 数据类型操作，以及更高级的HyperLogLog、Geo
- 原子 – Redis的所有操作都是原子性的，意思就是要么成功执行要么失败完全不执行。单个操作是原子性的。多个操作也支持事务，即原子性，通过MULTI和EXEC指令包起来。
- 丰富的特性 – Redis还支持 publish/subscribe, 通知, key 过期等等特性
- Redis支持主从模式，可以配置集群，这样更利于支撑起大型的项目

三、Redis和Memcache相比有哪些优势?

- memcached所有的值均是简单的字符串，redis作为其替代者，支持更为丰富的数据类型
- redis的速度比memcached快很多
- redis可以持久化其数据

