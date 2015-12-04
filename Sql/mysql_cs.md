**Mysql存储时间字段用int、timestamp还是datetime?**

INT
> 4个字节存储，INT的长度是4个字节，存储空间上比DATETIME少
> 
> int索引存储空间也相对较小，排序和查询效率相对较高一点点
> 
> 可读性极差，无法直观的看到数据，可能让你很恼火

TIMESTAMP

> 4个字节储存
> 
> 值以UTC格式保存
> 
> 时区转化 ，存储时对当前的时区进行转换，检索时再转换回当前的时区
> 
> TIMESTAMP值不能早于1970或晚于2037


DATETIME

> 8个字节储存
> 
> 与时区无关
> 
> 以'YYYY-MM-DD HH:MM:SS'格式检索和显示DATETIME值。支持的范围为'1000-01-01 00:00:00'到'9999-12-31 23:59:59'

**MySQL语句规范**

    1. 关键字和函数名大写（小写也可识别）
    2. 数据库，表，字段全部小写
    3. 每条语句分号结尾


**MySQL常用函数**

    1. SELECT VERSION(); --显示当前服务器版本
    2. SELECT NOW(); 	 --显示当前日期时间
    3. SELECT USER();	 --显示当前用户

**MYSQL数据类型**

	在MYSQL中数据类型有三种:文本、数字、日期
	TEXT类型:
    MySQL数据类型	含义   

    char(n)			固定长度，最多255个字符
    varchar(n)		可变长度，最多65535个字符
    tinytext		可变长度，最多255个字符
    text			可变长度，最多65535个字符
    mediumtext		可变长度，最多2的24次方-1个字符
    longtext		可变长度，最多2的32次方-1个字符

	Number类型:

	数据类型				描述
	TINYINT(size)		-128 到 127 常规。0 到 255 无符号*。在括号中规定最大位数。
	SMALLINT(size)		-32768 到 32767 常规。0 到 65535 无符号*。在括号中规定最大位数。
	MEDIUMINT(size)		-8388608 到 8388607 普通。0 to 16777215 无符号*。在括号中
						规定最大位数。
	INT(size)			-2147483648 到 2147483647 常规。0 到 4294967295 无符号*。
						在括号中规定最大位数。
	BIGINT(size)		-9223372036854775808 到 9223372036854775807 常规。0 到
						18446744073709551615 无符号*。在括号中规定最大位数。
	FLOAT(size,d)		带有浮动小数点的小数字。在括号中规定最大位数。在 d 参数中规定小数
						点右侧的最大位数。
	DOUBLE(size,d)		带有浮动小数点的大数字。在括号中规定最大位数。在 d 参数中规定小数
						点右侧的最大位数。
	DECIMAL(size,d)		作为字符串存储的 DOUBLE 类型，允许固定的小数点。

	这些整数类型拥有额外的选项 UNSIGNED。通常，整数可以是负数或正数。如果添加 UNSIGNED 属性，
	那么范围将从 0 开始，而不是某个负数。

	Date 类型：
    数据类型		描述
    DATE	 	日期。格式：YYYY-MM-DD 注释：支持的范围是从 '1000-01-01' 到 '9999-12-31'
    DATETIME	日期和时间的组合。格式：YYYY-MM-DD HH:MM:SS  注释：支持的范围是
				从'1000-01-01 00:00:00' 到 '9999-12-31 23:59:59'
    TIMESTAMP	时间戳。TIMESTAMP 值使用 Unix 纪元('1970-01-01 00:00:00' UTC) 至今的
				描述来存储。格式：YYYY-MM-DD HH:MM:SS	注释：支持的范围是从
				 '1970-01-01 00:00:01' UTC 到 '2038-01-09 03:14:07' UTC
    TIME		时间。格式：HH:MM:SS 注释：支持的范围是从 '-838:59:59' 到 '838:59:59'
    YEAR		2 位或 4 位格式的年。注释：4 位格式所允许的值：1901 到 2155。2 位格式所
				允许的值：70 到 69，表示从 1970 到 2069。9/14/2015 10:19:44 AM 

    即便 DATETIME 和 TIMESTAMP 返回相同的格式，它们的工作方式很不同。
	在 INSERT 或 UPDATE 查询中，TIMESTAMP 自动把自身设置为当前的日期和时间。
	TIMESTAMP 也接受不同的格式，比如YYYYMMDDHHMMSS、YYMMDDHHMMSS、YYYYMMDD 或 YYMMDD。

SQL操作:

	创建用户:
		grant 权限 on 数据库.* to 用户名@登录主机 identified by "密码";
	不设置用户密码的话:
		grant select,insert,update,delete  on 数据库.* to 用户名@登录主机 
		identified by "";
	查询所有用户:
		select user from mysql.user;
	查看当前用户:
		select user();
	查询时间:
		select now();
	删除用户:
		drop user 用户名;
	用户已存在赋予权限:
		grant select,insert,update,delete  on 数据库.* to 用户名@登录主机 identified 
		by "密码";
	查询数据库版本:
		select version();
	查询当前选定的数据库:
		select database();
	查看存储过程:
		show procedure status;
	查看存储过程的具体内容:
		show create procedure 存储过程名;
	权限有14种权限:
	  select,insert,update,delete,create,drop,index,alter,grant,
	  references,reload,shutdown,process
	




