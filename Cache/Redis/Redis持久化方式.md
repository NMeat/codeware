Redis提供了将数据定期自动持久化至硬盘的能力，包括RDB和AOF两种方案，两种方案分别有其长处和短板，可以配合起来同时运行，确保数据的稳定性。

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

也可以通过BGSAVE命令手工触发RDB快照保存。

RDB的优点：

- 对性能影响最小。如前文所述，Redis在保存RDB快照时会fork出子进程进行，几乎不影响Redis处理客户端请求的效率。
- 每次快照会生成一个完整的数据快照文件，所以可以辅以其他手段保存多个时间点的快照（例如把每天0点的快照备份至其他存储媒介中），作为非常可靠的灾难恢复手段。
- 使用RDB文件进行数据恢复比使用AOF要快很多。

RDB的缺点：

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

随着AOF不断地记录写操作日志，必定会出现一些无用的日志，例如某个时间点执行了命令SET key1 "abc"，在之后某个时间点又执行了SET key1 "bcd"，那么第一条命令很显然是没有用的。大量的无用日志会让AOF文件过大，也会让数据恢复的时间过长。
所以Redis提供了AOF rewrite功能，可以重写AOF文件，只保留能够把数据恢复到最新状态的最小写操作集。
AOF rewrite可以通过BGREWRITEAOF命令触发，也可以配置Redis定期自动进行：

```
auto-aof-rewrite-percentage 100
auto-aof-rewrite-min-size 64mb
```

上面两行配置的含义是，Redis在每次AOF rewrite时，会记录完成rewrite后的AOF日志大小，当AOF日志大小在该基础上增长了100%后，自动进行AOF rewrite。同时如果增长的大小没有达到64mb，则不会进行rewrite。

AOF的优点：

- 最安全，在启用appendfsync always时，任何已写入的数据都不会丢失，使用在启用appendfsync everysec也至多只会丢失1秒的数据。
- AOF文件在发生断电等问题时也不会损坏，即使出现了某条日志只写入了一半的情况，也可以使用redis-check-aof工具轻松修复。
- AOF文件易读，可修改，在进行了某些错误的数据清除操作后，只要AOF文件没有rewrite，就可以把AOF文件备份出来，把错误的命令删除，然后恢复数据。

AOF的缺点：

- AOF文件通常比RDB文件更大
- 性能消耗比RDB高
- 数据恢复速度比RDB慢