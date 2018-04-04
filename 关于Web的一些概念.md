1. 负载均衡：

   ​	Nginx：高性能、高并发的web服务器；功能包括负载均衡、反向代理、静态内容缓存、访问控制；工作在应用层

   ​	LVS： Linux virtual server，基于集群技术和Linux操作系统实现一个高性能、高可用的服务器；工作在网络层

2. webserver：

　　　　Java：Tomcat，Apache，Jboss

　　　　Python：gunicorn、uwsgi、twisted、webpy、tornado

3. service：　　

　　　　SOA、微服务、spring boot，django

4. 容器：

　　　　docker，kubernetes

5. cache：

　　　　memcache、redis等

6. 协调中心：

　　　　zookeeper、etcd等

​		zookeeper使用了Paxos协议Paxos是强一致性，高可用的去中心化分布式。zookeeper的使用场景非常广泛，之后细讲。

7. RPC框架：

　　　　grpc、dubbo、brpc

　　　　dubbo是阿里开源的Java语言开发的高性能RPC框架，在阿里系的诸多架构中，都使用了dubbo + spring boot

8. 消息队列：

　　　　kafka、rabbitMQ、rocketMQ、QSP

　　　　消息队列的应用场景：异步处理、应用解耦、流量削锋和消息通讯

9. 实时数据平台：

　　　　storm、akka

10. 离线数据平台：

　　　　hadoop、spark

　　　　PS: apark、akka、kafka都是scala语言写的，看到这个语言还是很牛逼的

11. dbproxy：

　　　　cobar也是阿里开源的，在阿里系中使用也非常广泛，是关系型数据库的sharding + replica 代理

12. db：

　　　　mysql、oracle、MongoDB、HBase

13. 搜索：

　　　　elasticsearch、solr

14. 日志：

　　　　rsyslog、elk、flume