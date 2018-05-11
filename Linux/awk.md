**awk根据访问IP统计UV**

`awk '{print $1}'  access.log | sort | uniq -c | wc -l`

**awk统计访问URL统计PV**

	awk '{print $7}' access.log | wc -l
**awk**查询访问最频繁的IP**

	awk '{print $1}' access.log|sort | uniq -c |sort -n -k 1 -r|more

**awk访问最多的100个ip及访问次数**

	awk '{print $1}' 日志地址 | sort | uniq -c | sort -n -k 1 -r | head -n 100
**awk分支语句**

	seq 10 | awk '{if($0%2==0){print $1,"ok"}else{print $0, "no"}}'

**awk数组**

	awk 'BEGIN{a[5]="name";a["name"]="leilei";for(i in a){print i":"a[i]}}'
	
	awk 'BEGIN{a[5]="name";a["name"]="leilei";delete a["name"];for(i in a){print i":"a[i]}}'

**awk生成随机数**

	awk 'BEGIN{print rand();}'
	awk 'BEGIN{print rand();srand();print rand()}'

**awk字符串替换**

	echo 'hello world'|awk '{sub("world", "cainiao");print $0}'
	echo 'hello world world'|awk '{gsub("world", "cainiao");print $0}'

**awk查看IP地址**

	ifconfig eth0 | awk -F':| +' '/inet addr:/{print $4}'

**awk查询nginx单台QPS**

```
#实时
tail -f access.log | awk -F '[' '{print $2}' | awk 'BEGIN{key="";count=0}{if(key==$1){count++}else{printf("%s\t%d\r\n", key, count);count=1;key=$1}}'

tail -f access.log | awk -F '[' '{print $2}' | awk '{print $1}' | uniq -c

#非实时
cat access.log | awk -F '[' '{print $2}' | awk '{print $1}' | sort | uniq -c |sort -k1,1nr 
```