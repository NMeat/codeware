

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

2.  生成配置文件

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

4. systemctl enable supervisord.service 开启服务

   ```
   supervisord 启动supervisord服务端
   supervisorctl reload 重载supervisorctl
   supervisorctl start shadowsocks 运行SS
   supervisorctl stop shadowsocks 停止SS
   supervisorctl restart shadowsocks 重启SS
   ```