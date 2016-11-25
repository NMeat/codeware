**根据访问IP统计UV**

`awk '{print $1}'  access.log | sort | uniq -c | wc -l`

**统计访问URL统计PV**

	awk '{print $7}' access.log | wc -l
**查询访问最频繁的IP**

	awk '{print $1}' access.log|sort | uniq -c |sort -n -k 1 -r|more
	
**访问最多的100个ip及访问次数**

	awk '{print $1}' 日志地址 | sort | uniq -c | sort -n -k 1 -r | head -n 100