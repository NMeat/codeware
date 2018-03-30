**Form表单的enctype属性**

HTTP/1.1 协议规定的 HTTP 请求方法有 OPTIONS、GET、HEAD、POST、PUT、DELETE、TRACE、CONNECT 这几种。

其中 POST 一般用来向服务端提交数据。



HTTP 协议是以 ASCII 码传输，建立在 TCP/IP 协议之上的应用层规范。规范把 HTTP 请求分为三个部分：状态行、请求头、消息主体。类似于下面这样：

			<method> <request-URL> <version>
			<headers>
			<entity-body>

协议规定 POST 提交的数据必须放在消息主体（entity-body）中，但协议并没有规定数据必须使用什么编码方式。实际上，开发者完全可以自己决定消息主体的格式，只要最后发送的 HTTP 请求满足上面的格式就可以。

用 enctype 属性指定将数据回发到服务器时浏览器使用的编码类型，enctype是EncodeType的简写。

	application/x-www-form-urlencoded
		默认类型	
		发送前对所有字符进行编码（把 "+" 转换为空格，把特殊字符转换为 ASCII 十六进制值）
	multipart/form-data
		不对字符编码
		窗体数据被编码为一条消息，页上的每个控件对应消息中的一个部分，上传附件用到
	text/plain
		空格转换为 "+" 加号，但不对特殊字符编码