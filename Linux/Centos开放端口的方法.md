## Centos开放端口的方法

Centos升级到7之后，内置的防火墙已经从iptables变成了firewalld。所以，端口的开启还是要从两种情况来说明的，即iptables和firewalld。

#### iptables

```
chkconfig iptables on		#开启防火墙(重启后永久生效)
chkconfig iptables off		#关闭防火墙(重启后永久生效)
service iptables start		#开启防火墙(即时生效，重启后失效)
service iptables stop			#关闭防火墙(即时生效，重启后失效)
service iptables restartd		#重启防火墙
/etc/init.d/iptables status		#查看打开的端口
iptables -A INPUT -p tcp --dport 8080 -j ACCEPT 	#开启端口

#保存并重启防火墙
/etc/rc.d/init.d/iptables save	
/etc/init.d/iptables restart

#打开49152~65534之间的端口
iptables -A INPUT -p tcp --dport 49152:65534 -j ACCEPT 

vim /etc/sysconfig/iptables
-A RH-Firewall-1-INPUT -m state –state NEW -m tcp -p tcp –dport 8080 -j ACCEPT
参数说明:
–A 参数就看成是添加一条规则
–p 指定是什么协议，我们常用的tcp 协议，当然也有udp，例如53端口的DNS
–dport 就是目标端口，当数据从外部进入服务器为目标端口
–sport 数据从服务器出去，则为数据源端口使用
–j 就是指定是 ACCEPT -接收 或者 DROP 不接收
```
## firewalld

Centos7默认安装了firewalld，如果没有安装的话，可以使用 yum install firewalld firewalld-config进行安装。

```
systemctl start firewalld                       #启动防火墙
systemctl stop firewalld						#禁用防火墙					
systemctl enable firewalld           			#设置开机启动
sytemctl disable firewalld 						#停止并禁用开机启动
firewall-cmd --reload 							#重启防火墙
systemctl status firewalld或者 firewall-cmd --state 		#查看状态
#在指定区域打开端口(记得重启防火墙)
firewall-cmd --zone=public --add-port=80/tcp(永久生效再加上 --permanent) 
firewall-cmd --zone=public --list-ports   		#查看所有打开的端口
```