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





安装