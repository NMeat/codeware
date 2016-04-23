#coding=utf-8
import MySQLdb
conn = MySQLdb.connect(
		host='localhost',
		port=3306,
		user='root',
		passwd='root',
		db='test'
		);
cur = conn.cursor();


#创建数据库

#cur.execute("create table student (id int, name varchar(20), class varchar(30), age varchar(10	))");

#插入一条数据

#cur.execute("insert into student values ('2','tom','3 year 2 class','9')");
student = cur.execute("select * from student where name = 'tom'");
#print student;
info = cur.fetchmany(student)
for st in info:
	print st;

sqli = 'insert into student values (%s,%s,%s,%s)';
#cur.executemany(sqli, [
#		('3','huhu','2 year 1 class','7'),
#		('4','lala','4 year 3 class','9'),
#		('5','soso', '5 year 6 class', '10'),
#		]);
cur.close();
conn.commit();
conn.close();
