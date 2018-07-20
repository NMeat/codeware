

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

   ​

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
   rpm -qa | grep kernel
   If the installation is successful, you should see kernel-ml-4.9.0-1.el7.elrepo.x86_64 among the output list:
   ```

   ```
   kernel-tools-libs-3.10.0-514.16.1.el7.x86_64
   kernel-3.10.0-514.el7.x86_64
   kernel-3.10.0-514.10.2.el7.x86_64
   kernel-tools-3.10.0-514.16.1.el7.x86_64
   kernel-3.10.0-514.16.1.el7.x86_64
   kernel-ml-4.10.13-1.el7.elrepo.x86_64  #目前是4.10
   ```

5. enable the 4.9.0 kernel by setting up the default grub2 boot entry

   Show all entries in the grub2 menu:

   ```
   sudo egrep ^menuentry /etc/grub2.cfg | cut -f 2 -d \'     
   ```

   ```
   显示如下:
   CentOS Linux (4.10.13-1.el7.elrepo.x86_64) 7 (Core)
   CentOS Linux 7 Rescue d8a77e850a4d412fad892befce9bd9c8 (3.10.0-514.16.1.el7.x86_64)
   CentOS Linux (3.10.0-514.16.1.el7.x86_64) 7 (Core)
   CentOS Linux (3.10.0-514.10.2.el7.x86_64) 7 (Core)
   CentOS Linux (3.10.0-514.el7.x86_64) 7 (Core)
   CentOS Linux (0-rescue-41bda1dfef7941278145d8fc0d781204) 7 (Core)
   ```

6. Since the line count starts at 0 and the 4.10 kernel entry is on the first line, set the default boot entry as 0:

   ```
   sudo grub2-set-default 0
   sudo shutdown -r now
   uname -r
   ```

   ```
   显示如下:
   4.10.13-1.el7.elrepo.x86_64
   ```

7. enable bbr

   ```
   echo 'net.core.default_qdisc=fq' | sudo tee -a /etc/sysctl.conf
   echo 'net.ipv4.tcp_congestion_control=bbr' | sudo tee -a /etc/sysctl.conf
   sudo sysctl -p
   ```

   Now, you can use the following commands to confirm that BBR is enabled:

   ```
   sudo sysctl net.ipv4.tcp_available_congestion_control
   ```

   The output should resemble:

   ```
   net.ipv4.tcp_available_congestion_control = bbr cubic reno
   ```

   Next, verify with:

   ```
   sudo sysctl -n net.ipv4.tcp_congestion_control
   ```

   The output should be:

   ```
   bbr
   ```

   Finally, check that the kernel module was loaded:

   ```
   lsmod | grep bbr
   ```

   The output will be similar to:

   ```shell
   tcp_bbr                16384  0
   ```

8. 增加系统文件描述符的最大限数

   ```
   vi /etc/security/limits.conf
   * soft nofile 51200
   * hard nofile 51200

   启动shadowsocks服务器之前，设置以下参数
   ulimit -n 51200
   ```

   ​



