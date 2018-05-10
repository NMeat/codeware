```
在server模块下面，执行顺序:

优先执行rewrite部分--->执行location匹配--->执行选定的location中的rewrite指令
如果其中某步URI被重写，再次进入server块，重试location匹配，直到找到真实存在的文件,如果循环超过10次，则返回500 Internal Server Error错误

-------------------------------分割线-------------------------------------
--rewrite--
URL重写:  rewrite <REGEX> <REPL> <FLAG>  即rewrite 规则 定向路径 标识位
规则：可以是字符串或者正则来表示想匹配的目标url
定向路径：表示匹配到规则后要定向的路径，如果规则里有正则，则可以使用$index来表示正则里的捕获分组
标识位有以下4种:
- last：	表示完成rewrite，浏览器地址栏URL地址不变
  location域里的last会终止当前location下的所有rewrite,重新执行location匹配
  重新发起的匹配从匹配location开始,而不是从server域下的rewrite开始。

  server域里的break和last的作用没有区别，都是终止rewrite进入location匹配。
  1.server中的break终止rewrite进入location匹配
  2.location中的break，终止当前请求的匹配工作，进入执行阶段

- break：本条规则匹配完成后，终止匹配，不再匹配后面的规则，浏览器地址栏URL地址不变,完成本次请求
- redirect：返回302临时重定向，浏览器地址会显示跳转后的URL地址
- permanent：返回301永久重定向，浏览器地址栏会显示跳转后的URL地址

location中rewrite的作用：
有rewrite则执行如下顺序:
	1.break 终止rewrite，进入请求处理阶段
	2.last 终止rewrite，重新开始匹配location
	3.redirect , perminate 301和302
	4.default(rewrite后不带指令) 继续执行下一条rewrite指令，如果该条指令为最后一条，则执行处理请求的指令（如fastcgi_pass，proxy_pass），没有则继续匹配其他location。
无rewrite则直接进入请求处理阶段
-------------------------------分割线-------------------------------------
```

