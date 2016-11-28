**根据访问IP统计UV**

`awk '{print $1}'  access.log | sort | uniq -c | wc -l`

**统计访问URL统计PV**

	awk '{print $7}' access.log | wc -l
**查询访问最频繁的IP**

	awk '{print $1}' access.log|sort | uniq -c |sort -n -k 1 -r|more
	
**访问最多的100个ip及访问次数**

	awk '{print $1}' 日志地址 | sort | uniq -c | sort -n -k 1 -r | head -n 100
	
**示例**

分支语句

	seq 10 | awk '{if($0%2==0){print $1,"ok"}else{print $0, "no"}}'

数组

	awk 'BEGIN{a[5]="name";a["name"]="leilei";for(i in a){print i":"a[i]}}'
	
	awk 'BEGIN{a[5]="name";a["name"]="leilei";delete a["name"];for(i in a){print i":"a[i]}}'
	
生成随机数

	awk 'BEGIN{print rand();}'
	awk 'BEGIN{print rand();srand();print rand()}'
	
字符串替换

	echo 'hello world'|awk '{sub("world", "cainiao");print $0}'
	echo 'hello world world'|awk '{gsub("world", "cainiao");print $0}'
	
index 

	echo 'hello world'|awk '{print index($0,"world")}'

length
	
	echo 'hello world'|awk '{print length($0)}'
	
match(s, r) 

	s:字符串 r：正则 匹配到显示起始位置 否则显示0
split(s,a,sep)
	
	使用sep分割s得到的数组赋到a中. 默认sep为FS
	echo '00-22-77-98-88-99-54'|awk '{split($0,a,"-");for(i in a){print i":"a[i]}}'
	
tolower
	
	大写转小写
	echo 'HELLO'|awk '{print tolower($0)}'
	
function

	awk 'function sum(n,m){total=n+m;return total}BEGIN{print sum(34,98)}'
	
查看IP地址

	ifconfig eth0 | awk -F':| +' '/inet addr:/{print $4}'

统计网络连接数

	netstat -an | awk '/^tcp/{state[$NF]++}END{for(key in state){print key,"\t",state[key]}}'|column -t
	

统计小区访问数

	awk 'BEGIN{count=0}/xiaoqu/{if($9 ~ /^\/xiaoqu.*?\//){count++;a[$1]++}}END{print count;for(key in a){ print key,"\t",a[key]}}' access.log | sort -n -k 2 -r | head -n 10