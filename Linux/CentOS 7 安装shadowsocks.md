## CentOS 7 安装shadowsocks

1. yum install python-setuptools && easy_install pip

2. pip install shadowsocks

3. 创建配置文件     vim /etc/shadowsocks.json

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