**Mysql存储时间字段用int、timestamp还是datetime?**

INT

	4个字节存储，INT的长度是4个字节，存储空间上比DATETIME少
	int索引存储空间也相对较小，排序和查询效率相对较高一点点
	可读性极差，无法直观的看到数据，可能让你很恼火

TIMESTAMP

	4个字节储存
	值以UTC格式保存 
	时区转化 ，存储时对当前的时区进行转换，检索时再转换回当前的时区
	TIMESTAMP值不能早于1970或晚于2037


DATETIME

	8个字节储存
	与时区无关
	以'YYYY-MM-DD HH:MM:SS'格式检索和显示DATETIME值。
	支持的范围为'1000-01-01 00:00:00'到'9999-12-31 23:59:59'

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
	字符串类型:   
    char(n)			0-255字节	定长字符串
    varchar(n)		0-65535 字节	变长字符串
    TINYBLOB		0-255字节	不超过 255 个字符的二进制字符串
    TINYTEXT		0-255字节	短文本字符串
    BLOB			0-65 535字节	二进制形式的长文本数据
    TEXT			0-65 535字节	长文本数据
	MEDIUMBLOB		0-16 777 215字节	二进制形式的中等长度文本数据
	MEDIUMTEXT		0-16 777 215字节	中等长度文本数据
	LONGBLOB		0-4 294 967 295字节	二进制形式的极大文本数据
	LONGTEXT		0-4 294 967 295字节	极大文本数据
	----------------------------------------------------------------------
	数值类型:
	TINYINT		1字节	(-128，127)	            		
	SMALLINT	2字节	(-32 768，32 767)	    		
	MEDIUMINT	3字节	(-8 388 608，8 388 607)			
	INT 		4字节	(-2 147 483 648，2 147 483 647)
	BIGINT	    8字节	(-9 233 372 036 854 775 808，9 223 372 036 854 775 807)
	FLOAT(size,d)   4字节	单精度
	DOUBLE(size,d)	8字节	双精度
	DECIMAL(size,d)	作为字符串存储的 DOUBLE 类型，允许固定的小数点。

	这些整数类型拥有额外的选项 UNSIGNED。通常，整数可以是负数或正数。如果添加 UNSIGNED 属性，
	那么范围将从 0 开始，而不是某个负数。
	---------------------------------------------------------------------
	日期和时间类型：
    DATE	3字节	1000-01-01/9999-12-31	-----YYYY-MM-DD
    TIME	3字节	-838:59:59/838:59:59		-----HH:MM:SS
    YEAR	1字节	1901/2155				-----YYYY
    DATETIME  8字节	1000-01-01 00:00:00/9999-12-31 23:59:59	--YYYY-MM-DD HH:MM:SS
    TIMESTAMP 8字节	1970-01-01 00:00:00/2037 年某时	---YYYYMMDD HHMMS

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
	




