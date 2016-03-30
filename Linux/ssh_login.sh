#!/usr/bin/expect -f  
set user root
set ip 138.128.194.193  
set password gxs5SvTsvnp4 
set timeout 1000
set port 29010  
spawn ssh $user@$ip -p $port   
expect {               
 	"*password:" { send "$password\r" }      //出现密码提示,发送密码  
	"*yes/no" { 
		send "yes\r"; exp_continue
		set timeout 1
		expect{
			"*password" { send "$password\r"}
		}
	}  //第一次ssh连接会提示yes/no,继续  
}  
interact          //交互模式,用户会停留在远程服务器上面.  
