#!/usr/bin/expect -f  
set user xxx
set ip xxx.xxx.xxx.xxx  
set password xxx 
set timeout xxx
set port xxx  
spawn ssh $user@$ip -p $port   
expect {               
 	"*password:" { send "$password\r" }      
	"*yes/no" { 
		send "yes\r)?"; exp_continue
		set timeout 1
		expect{
			"*password" { send "$password\r"}
		}
	}  										
}  
interact          							

set user xxx
set ip xxx.xxx.xxx.xxx  
set password xxx 
set timeout xxx
set port xxx  
spawn ssh $user@$ip -p $port   
expect {               
 	"*password:" { send "$password\r" }      
	"*yes/no)?" { 
		send "yes\r"; exp_continue
		set timeout 1
		expect{
			"*password" { send "$password\r"}
		}
	}  										
}  
interact
