

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
   echo_supervisord_conf > /etc/supervisord.conf
   mkdir -p /var/log/supervisor
   mkdir -p /etc/supervisor/conf.d/
   echo -e "[include]\nfiles = /etc/supervisor/conf.d/*.conf">>/etc/supervisord.conf
   ```

3. 添加相应的配置  vim /usr/lib/systemd/system/supervisord.service

   ```
   # supervisord service for systemd (CentOS 7.0+)
   # by ET-CS (https://github.com/ET-CS)
   [Unit]
   Description=Supervisor daemon

   [Service]
   Type=forking
   ExecStart=/usr/bin/supervisord
   ExecStop=/usr/bin/supervisorctl $OPTIONS shutdown
   ExecReload=/usr/bin/supervisorctl $OPTIONS reload
   KillMode=process
   Restart=on-failure
   RestartSec=42s

   [Install]
   WantedBy=multi-user.target
   ```

4. systemctl enable supervisord.service 设置开机启动服务

   ```
   supervisord 启动supervisord服务端
   supervisorctl reload 重载supervisorctl
   supervisorctl start shadowsocks 运行SS
   supervisorctl stop shadowsocks 停止SS
   supervisorctl restart shadowsocks 重启SS
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



