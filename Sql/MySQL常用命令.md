##### 导出表结果表数据

```mysql
Usage: mysqldump [OPTIONS] database [tables]
OR     mysqldump [OPTIONS] --databases [OPTIONS] DB1 [DB2 DB3...]
OR     mysqldump [OPTIONS] --all-databases [OPTIONS]

默认不带参数的导出，导出文本内容大概如下：创建数据库判断语句-删除表-创建表-锁表-禁用索引-插入数据-启用索引-解锁表

mysqldump -u用户名 -p密码 -d 数据库名 表名 > 脚本名;

#导出数据库为dbname的表结构
mysqldump -uroot -pdbpasswd -d dbname >db.sql;   

#导出数据库为dbname的一张表tableName表结构
mysqldump -uroot -pdbpasswd -d dbname tableName>db.sql;

#导出数据库为dbname所有表结构及表数据
mysqldump -uroot -pdbpasswd dbname >db.sql;

#导出数据库为dbname的一张表tableName结构及表数据
mysqldump -uroot -pdbpasswd dbname tableName >db.sql;

#导出查询结果到文件
mysql -h10.10.10.10 -ucrazyant -p123456 -P3306 -Ne "use test; select * from tb_test;" > /tmp/rs.txt

#导出查询结果到文件
mysql -h10.10.10.10 -ucrazyant -p123456 -P3306 -Ne "use test; select * from tb_test;" > /tmp/rs.txt
```

##### 导入表结果表数据

```mysql
1.登陆数据库
	mysql -uroot -proot
2.选择数据库
	mysql>use live-app;
3.导入sql文件
	mysql>source /home/live-app.sql;
	
直接导入
mysql -u用户名 -p 数据库名 < 数据库名.sql
mysql -uroot -p live-app < /home/live-app.sql
```

