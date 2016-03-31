#!/usr/bin/expect -f  
set user xxx
set ip xxx.xxx.xxx.xxx  
set password xxx 
set timeout xxx
set port xxx  
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
