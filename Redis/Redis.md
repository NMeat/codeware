**Redis命令行操作**

```shell
./redis-server &                       启动redis  以后台形式运行
sudo netstat -lntp | grep 6379		   检测6379端口是否在监听
redis-cli shutdown
redis-server  ./redis.conf			   启动时指定配置文件
redis-cli -p 6380					   redis-cli`客户端连接时，也需要指定端口
redis-cli -h 主机IP					  连接redis

登录后可以继续以下操作:
ping			测试连接是否存活
dbsize			返回当前数据库中key的数目
select 0-15		选择数据库,Redis数据库编号从0-15
info			获取服务器的信息和统计
```

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

四、Redis中一个字符串类型的值能存储最大容量是多少？

​	A String value can be at max 512 Megabytes in length 即512M ,且redis的key和string类型value限制均为512M。

##### 五、MySQL里有2000w数据，redis中只存20w的数据，如何保证redis中的数据都是热点数据？

​	redis 提供 6种数据淘汰策略：

- voltile-lru ：从已设置过期时间的数据集（server.db[i].expires）中挑选最近最少使用的数据淘汰
- volatile-ttl：从已设置过期时间的数据集（server.db[i].expires）中挑选将要过期的数据淘汰
- volatile-random：从已设置过期时间的数据集（server.db[i].expires）中任意选择数据淘汰
- allkeys-lru    ：从数据集（server.db[i].dict）中挑选最近最少使用的数据淘汰
- allkeys-random ：从数据集（server.db[i].dict）中任意选择数据淘汰
- no-enviction   ：禁止驱逐数据

最好为Redis指定一种有效的数据淘汰策略以配合maxmemory设置，避免在内存使用满后发生写入失败的情况。

一般来说，推荐使用的策略是volatile-lru，并辨识Redis中保存的数据的重要性。对于那些重要的，绝对不能丢弃的数据（如配置类数据等），应不设置有效期，这样Redis就永远不会淘汰这些数据。对于那些相对不是那么重要的，并且能够热加载的数据（比如缓存最近登录的用户信息，当在Redis中找不到时，程序会去DB中读取），可以设置上有效期，这样在内存不够时Redis就会淘汰这部分数据。

配置方法：

```
maxmemory-policy volatile-lru   #默认是noeviction，即不进行数据淘汰
```

##### 六、Redis中key的设计注意事项?

Redis采用Key-Value型的基本数据结构，任何二进制序列都可以作为Redis的Key使用(例如普通的字符串或一张JPEG图片)。

- 不要使用过长的Key。例如使用一个1024字节的key就不是一个好主意，不仅会消耗更多的内存，还会导致查找的效率降低
- Key短到缺失了可读性也是不好的，例如"u1000flw"比起"user:1000:followers"来说，节省了寥寥的存储空间，却引发了可读性和可维护性上的麻烦
- 最好使用统一的规范来设计Key，比如"object-type:id:attr"，以这一规范设计出的Key可能是"user:1000"或"comment:1234:reply-to"
- Redis允许的最大Key长度是512MB（对Value的长度限制也是512MB）

##### 七、Redis的内存管理与数据淘汰机制？

默认情况下，在32位OS中，Redis最大使用3GB的内存，在64位OS中则没有限制。

在使用Redis时，应该对数据占用的最大空间有一个基本准确的预估，并为Redis设定最大使用的内存。否则在64位OS中Redis会无限制地占用内存（当物理内存被占满后会使用swap空间），容易引发各种各样的问题。

通过如下配置控制Redis使用的最大内存：

```
maxmemory 100mb
```

在内存占用达到了maxmemory后，再向Redis写入数据时，Redis会：

- 根据配置的数据淘汰策略尝试淘汰数据，释放空间
- 如果没有数据可以淘汰，或者没有配置数据淘汰策略，那么Redis会对所有写请求返回错误，但读请求仍然可以正常执行

在为Redis设置maxmemory时，需要注意：

- 如果采用了Redis的主从同步，主节点向从节点同步数据时，会占用掉一部分内存空间，如果maxmemory过于接近主机的可用内存，导致数据同步时内存不足。所以设置的maxmemory不要过于接近主机可用的内存，留出一部分预留用作主从同步

##### 八、Redis的数据持久化策略?

​	Redis提供了将数据定期自动持久化至硬盘的能力，包括RDB和AOF两种方案，两种方案分别有其长处和短板，可以配合起来同时运行，确保数据的稳定性。

​	Redis的数据持久化机制是可以关闭的。如果你只把Redis作为缓存服务使用，Redis中存储的所有数据都不是该数据的主体而仅仅是同步过来的备份，那么可以关闭Redis的数据持久化机制。 但通常来说，仍然建议至少开启RDB方式的数据持久化，因为：

- RDB方式的持久化几乎不损耗Redis本身的性能，在进行RDB持久化时，Redis主进程唯一需要做的事情就是fork出一个子进程，所有持久化工作都由子进程完成
- Redis无论因为什么原因crash掉之后，重启时能够自动恢复到上一次RDB快照中记录的数据。这省去了手工从其他数据源（如DB）同步数据的过程，而且要比其他任何的数据恢复方式都要快
- 现在硬盘那么大，真的不缺那一点地方

**RDB**

​	采用RDB持久方式，Redis会定期保存数据快照至一个rbd文件中，并在启动时自动加载rdb文件，恢复之前保存的数据。可以在配置文件中配置Redis进行快照保存的时机：

```
save [seconds] [changes]
```

意为在[seconds]秒内如果发生了[changes]次数据修改，则进行一次RDB快照保存，例如

```
save 60 100
```

会让Redis每60秒检查一次数据变更情况，如果发生了100次或以上的数据变更，则进行RDB快照保存。

可以配置多条save指令，让Redis执行多级的快照保存策略。
Redis默认开启RDB快照，默认的RDB策略如下：

```
save 900 1
save 300 10
save 60 10000
```

也可以通过**BGSAVE**命令手工触发RDB快照保存。

**RDB的优点：**

- 对性能影响最小。如前文所述，Redis在保存RDB快照时会fork出子进程进行，几乎不影响Redis处理客户端请求的效率。
- 每次快照会生成一个完整的数据快照文件，所以可以辅以其他手段保存多个时间点的快照（例如把每天0点的快照备份至其他存储媒介中），作为非常可靠的灾难恢复手段。
- 使用RDB文件进行数据恢复比使用AOF要快很多。

**RDB的缺点：**

- 快照是定期生成的，所以在Redis crash时或多或少会丢失一部分数据。
- 如果数据集非常大且CPU不够强（比如单核CPU），Redis在fork子进程时可能会消耗相对较长的时间（长至1秒），影响这期间的客户端请求。

**AOF**

采用AOF持久方式时，Redis会把每一个写请求都记录在一个日志文件里。在Redis重启时，会把AOF文件中记录的所有写操作顺序执行一遍，确保数据恢复到最新。

AOF默认是关闭的，如要开启，进行如下配置：

```
appendonly yes
```

AOF提供了三种fsync配置，always/everysec/no，通过配置项[appendfsync]指定：

- appendfsync no：不进行fsync，将flush文件的时机交给OS决定，速度最快
- appendfsync always：每写入一条日志就进行一次fsync操作，数据安全性最高，但速度最慢
- appendfsync everysec：折中的做法，交由后台线程每秒fsync一次

随着AOF不断地记录写操作日志，必定会出现一些无用的日志，例如某个时间点执行了命令**SET key1 "abc"**，在之后某个时间点又执行了**SET key1 "bcd"**，那么第一条命令很显然是没有用的。大量的无用日志会让AOF文件过大，也会让数据恢复的时间过长。
所以Redis提供了AOF rewrite功能，可以重写AOF文件，只保留能够把数据恢复到最新状态的最小写操作集。
AOF rewrite可以通过**BGREWRITEAOF**命令触发，也可以配置Redis定期自动进行：

```
auto-aof-rewrite-percentage 100
auto-aof-rewrite-min-size 64mb
```

上面两行配置的含义是，Redis在每次AOF rewrite时，会记录完成rewrite后的AOF日志大小，当AOF日志大小在该基础上增长了100%后，自动进行AOF rewrite。同时如果增长的大小没有达到64mb，则不会进行rewrite。

**AOF的优点：**

- 最安全，在启用appendfsync always时，任何已写入的数据都不会丢失，使用在启用appendfsync everysec也至多只会丢失1秒的数据。
- AOF文件在发生断电等问题时也不会损坏，即使出现了某条日志只写入了一半的情况，也可以使用redis-check-aof工具轻松修复。
- AOF文件易读，可修改，在进行了某些错误的数据清除操作后，只要AOF文件没有rewrite，就可以把AOF文件备份出来，把错误的命令删除，然后恢复数据。

**AOF的缺点：**

- AOF文件通常比RDB文件更大
- 性能消耗比RDB高
- 数据恢复速度比RDB慢