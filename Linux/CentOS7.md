

## CentOS 7 安装shadowsocks

1. yum install python-setuptools && easy_install pip

2. 安装shadowsocks

   ```
   pip install shadowsocks
   ```

3. 创建配置文件     vim /etc/shadowsocks.json 以下是多账号的配置

   ```json
   {
   	"server":"your server ip",
     	"local_address": "127.0.0.1",
     	"local_port":1080,
     	"port_password":{    
   		"your port":"your password"
   	},
   	"timeout":300,
   	"method":"aes-256-cfb",
   	"fast_open": false
   }
   ```

4. 启动服务

   ```
   ssserver -c /etc/shadowsocks.json -d start  启动服务
   ssserver -c /etc/shadowsocks.json -d stop   停止服务
   ```

5. 打开所使用的端口

   ```
   firewall-cmd --zone=public --add-port=8088/tcp --permanent
   firewall-cmd --complete-reload  重置使配置生效
   ```

6. 检查日志

   ```
   less /var/log/shadowsocks.log
   ```

   

## 安装supervisor来监测shadowsocks服务

1. easy_install supervisor  安装

2. 生成配置文件

   ```
   echo_supervisord_conf > /etc/supervisord.conf    #新建配置文件
   supervisord -c /etc/supervisord.conf	#启动
   supervisorctl -c /etc/supervisord.conf	#启动
   上面这个命令会进入 supervisorctl 的 shell 界面，然后可以执行不同的命令了：
   > status    		#查看程序状态
   > stop usercenter   #关闭 usercenter 程序
   > start usercenter  #启动 usercenter 程序
   > restart usercenter    #重启 usercenter 程序
   > reread    ＃读取有更新（增加）的配置文件，不会启动新添加的程序
   > update    ＃重启配置文件修改过的程序
   
   上面这些命令都有相应的输出，除了进入 supervisorctl 的 shell 界面，也可以直接在 bash 终端运行：
   supervisorctl status
   supervisorctl stop usercenter
   supervisorctl start usercenter
   supervisorctl restart usercenter
   supervisorctl reread
   supervisorctl update
   
   mkdir -p /var/log/supervisor	#日志文件夹
   
   #配置目录
   mkdir -p /etc/supervisor/conf.d/
   在/etc/supervisord.conf 追加如下
   
   [include]
   files = /etc/supervisor/conf.d/*.conf
   ```

3. 进程配置

   ```shell
   ;进程名唯一
   [program:ssserver]
   command = /usr/bin/python2 /usr/bin/ssserver -c /etc/shadowsocks.json ;程序启动命令
   autostart = true     ;自动启动  在supervisord启动的时候也自动启动
   autoresart = true    ;自动重启	程序异常退出后自动重启
   startsecs=10         ;程序重启检测时间	启动10秒后没有异常退出，就当作已经正常启动了
   startretries = 3     ;启动失败自动重试次数，默认是 3
   redirect_stderr=true ;把 stderr 重定向到 stdout，默认 false
   user = root          ;启动用户为root
   stderr_logfile = /var/log/supervisor/supervisorkms.log    ;记录启动错误日志
   ;stdout日志文件，当指定目录不存在时无法正常启动，需要手动创建目录（supervisord 会自动创建日志文件）
   stdout_logfile = /var/log/supervisor/supervisorkms.log    ;记录意外退出日志
   stdout_logfile_maxbytes=1MB   ; stdout 日志文件大小，默认 50MB
   stdout_logfile_backups=1      ; stdout 日志文件备份数
   stderr_logfile_maxbytes=1MB   ; max # logfile bytes b4 rotation (default 50MB)
   stderr_logfile_backups=1      ; # of stderr logfile backups (default 10)	
   ```

4. 将supervisor加入开机自启动

   ```
   cd /usr/lib/systemd/system/
   vim supervisor.service 加入以下内容
   ------------分界线--------------
   [Unit]
   Description=supervisor
   After=network.target
   
   [Service]
   Type=forking
   ExecStart=/usr/bin/supervisord -c /etc/supervisord.conf
   ExecReload=/usr/bin/supervisorctl reread
   ExecStop=/usr/bin/supervisorctl stop all
   PrivateTmp=true
   
   [Install]
   WantedBy=multi-user.target
   ------------分界线--------------
   
   systemctl enable supervisor.service  //设置链接
   systemctl start supervisor.service	 //开启
   ```

## BBR加速

1. 查看当前内核

   ```
   uname -r
   显示:3.10.0-514.2.2.el7.x86_64
   ```

2. 安装ELRepo repo源

   ```
   sudo rpm --import https://www.elrepo.org/RPM-GPG-KEY-elrepo.org
   sudo rpm -Uvh http://www.elrepo.org/elrepo-release-7.0-2.el7.elrepo.noarch.rpm
   ```

3. 升级内核至4.9+

   ```
   sudo yum --enablerepo=elrepo-kernel install kernel-ml -y
   ```

4. 确认安装结果

   ```
   # 查看安装内核并设置，从返回结果中找到版本号最大的一行的序号，设置为默认启动
   awk -F\' '$1=="menuentry " {print i++ " : " $2}' /etc/grub2.cfg
   # 0是版本号最大的一行的序号
   grub2-set-default 0
   ```

5. enable bbr

   ```
   # 开启BBR
   echo "net.core.default_qdisc=fq" >> /etc/sysctl.conf
   echo "net.ipv4.tcp_congestion_control=bbr" >> /etc/sysctl.conf
   # 保存并生效
   sysctl -p 
   # 查看是否开启。返回值有 tcp_bbr 模块即说明 bbr 已启动。
   lsmod | grep bbr
   ```

8. 增加系统文件描述符的最大限数

   ```
   vi /etc/security/limits.conf
   * soft nofile 51200
   * hard nofile 51200

   启动shadowsocks服务器之前，设置以下参数
   ulimit -n 51200
   ```




## 新VPS初始化常用步骤

1.免密登录 ----- 新建 work组 work用户

```
groupadd work
useradd -g work work
passwd work

切换到work家目录
su work
mkdir -p ~/.ssh
chmod -R 700 ~/.ssh  
touch  ~/.ssh/authorized_keys

将登录用的公用证书复制进,尽量用scp上传公钥,vim复制会出现迷之登录不上的bug
把公钥id_rsa.pub传到服务器上:scp ~/.ssh/id_rsa.pub  work@远程服务器IP:~/
把公钥追加到authorized_keys里:cat ~/id_rsa.pub >> ~/.ssh/authorized_keys
更改授权:chmod -R 600 ~/.ssh/authorized_keys

root修改sshd配文件
vim /etc/ssh/sshd_config

禁用root账户登录
PermitRootLogin no
RSAAuthentication yes
PubkeyAuthentication yes  
AuthorizedKeysFile .ssh/authorized_keys
#有了证书登录了，就禁用密码登录吧，安全要紧  
PasswordAuthentication no

重启服务
systemctl restart sshd.service
```

2.安装SSL证书

```
yum -y install epel-release
yum -y install certbot

将example.com替换成你的域名
certbot certonly --standalone -d example.com

如果申请成功，证书和私钥路径如下
/etc/letsencrypt/live/example.com/fullchain.pem
/etc/letsencrypt/live/example.com/privkey.pem

显示证书信息
certbot certificates   

撤销证书
certbot revoke --cert-path /etc/letsencrypt/live/CERTNAME/cert.pem 

删除证书（撤销之后使用
certbot delete --cert-name example.com

crontab -e 增加两条定时任务
每月的 1,7,21,28号， 4点30 更新证书
30 4 1,7,21,28 * * /usr/bin/certbot renew
每月的 1,7,21,28号， 5点30 重新启动nginx 服务器
30 5 1,7,21,28 * * /usr/sbin/nginx -t && killall  nginx  && /usr/sbin/nginx
```

